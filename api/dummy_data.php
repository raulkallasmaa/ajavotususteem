<?php
ini_set('max_execution_time', 60);
set_time_limit(60);

const POST_URL =  'http://ajavotususteem.herokuapp.com/output.php';
const DATA_FILE_PATH = 'data_names';

const MIN_START_DELAY = 2;
const MAX_START_DELAY = 5;
const MIN_RUN_TIME = 5;
const MAX_RUN_TIME = 20;

function randFloat($min, $max, $decimals) {
  $divisor = pow(10, $decimals);
  return mt_rand($min, $max * $divisor) / $divisor;
}

function lapsedTime($startTime) {
  return microtime(true) - $startTime;
}

function readChipIDArray($file_path) {
  $csv = array_map('str_getcsv', file($file_path));

  $chipIDs = [];
  foreach ($csv as $key => $value) {
    $chipIDs[] = $value[2];
  }

  return $chipIDs;
}

function initializeRunners($chipIDs) {
  $standbyRunners = [];
  $participantCount = count($chipIDs);
  for ($i=0; $i < $participantCount; $i++) {
    $standbyRunners[] = new Runner($chipIDs);
  }

  usort($standbyRunners, array("Runner", "cmpStart"));

  return $standbyRunners;
}

class Runner {
  public $chipID;

  public $startDelay;
  public $runTime;

  public $realStartTime;
  public $realEndTime;

  public function __construct(& $chipIDs) {
    $this->chipID = array_pop($chipIDs);

    $this->startDelay = randFloat(MIN_START_DELAY, MAX_START_DELAY, 3);
    $this->runTime = randFloat(MIN_RUN_TIME, MAX_RUN_TIME, 3);
  }

  public function startRun() {
    $this->realStartTime = microtime(true);
    $this->realEndTime = $this->realStartTime + $this->runTime;
  }

  public function runTimeLeft() {
    return $this->realEndTime - microtime(true);
  }

  public static function cmpStart($a, $b) {
    if ($a->startDelay == $b->startDelay) {
      return 0;
    }
    return ($a->startDelay > $b->startDelay) ? -1 : 1;
  }

  public static function cmpFinish($a, $b) {
    if ($a->runTimeLeft() == $b->runTimeLeft()) {
      return 0;
    }
    return ($a->runTimeLeft() > $b->runTimeLeft()) ? -1 : 1;
  }
}

class cURLwrap {
  public $ch;
  public $url;

  public function __construct($url) {
    $this->ch = curl_init();

    curl_setopt($this->ch, CURLOPT_URL, $url);
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->ch, CURLOPT_HEADER, 0);
    curl_setopt($this->ch, CURLOPT_POST, 1);
  }

  public function signalEntry($runner) {
    $post_data = array(
      'chipID' => $runner->chipID,
      'gate'   => 'ENTER',
      'time'   => $runner->realStartTime
    );
    $this->postData($post_data);
  }

  public function signalFinish($runner) {
    $post_data = array(
      'chipID' => $runner->chipID,
      'gate'   => 'EXIT',
      'time'   => $runner->realEndTime
    );
    $this->postData($post_data);
  }

  public function postData($data) {
    curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
    $output = curl_exec($this->ch);

    if ($output === false) {
      echo curl_error($this->ch);
    }
    echo $output;
  }
}

function main($runners_file_path, $post_url) {
  $dataPoster = new cURLwrap($post_url);

  $chipIDs = readChipIDArray($runners_file_path);
  $participantCount = count($chipIDs);

  $standbyRunners = initializeRunners($chipIDs);
  $runningRunners = [];
  $finishedRunners = [];

  $startTime = microtime(true);
  while (count($finishedRunners) < $participantCount) {
    if(count($standbyRunners) > 0
                && end($standbyRunners)->startDelay <= lapsedTime($startTime)) {
      $currentRunner = end($standbyRunners);
      $currentRunner->startRun();
      $dataPoster->signalEntry($currentRunner);
      $runningRunners[] = array_pop($standbyRunners);
    }

    if(count($runningRunners) > 1) {
      usort($runningRunners, array("Runner", "cmpFinish"));
    }

    if(count($runningRunners) > 0
                && end($runningRunners)->runTime <= lapsedTime($startTime + end($runningRunners)->startDelay)) {
      $currentRunner = end($runningRunners);
      $dataPoster->signalFinish($currentRunner);
      $finishedRunners[] = array_pop($runningRunners);
    }
  }

  usleep(500);
}

main(DATA_FILE_PATH, POST_URL);

?>