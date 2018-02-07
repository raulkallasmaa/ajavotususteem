<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$enterData = null;
foreach ($data as $enter) {
    if ($data['gate'] === 'ENTER') {
        $enterData = $data;
    }
}
print_r($enterData);
$enterTime = $enterData['time'];
$enterChipID = $enterData['chipID'];

$exitData = null;
foreach ($data as $exit) {
    if ($data['gate'] === 'EXIT') {
        $exitData = $data;
    }
}
print_r($exitData);
$exitTime = $exitData['time'];
$exitChipID = $exitData['chipID'];

$conn = mysqli_connect("localhost", "username", "password", "tablename");
function loop_multi($result)
{
    global $conn;
    $returned = array("result" => array(), "error" => array());

    if ($result) {
        $returned["result"][0] = mysqli_store_result($conn);
        $count = 0;

        do {
            $count++;
            mysqli_next_result($conn);
            $result = mysqli_store_result($conn);

            if ($result) {
                $returned["result"][$count] = $result;
            } else {
                $returned["error"][$count] = mysqli_error($conn);
            }
        }
        while (mysqli_more_results($conn));
    } else {
        $returned["error"][0] = mysqli_error($conn);
    }
    return $returned;
}

$query = "UPDATE competitors SET entry_time = '" . $enterTime . "' WHERE chipID = '" . $enterChipID . "';";
$query .= "UPDATE competitors SET finish_time = '" . $exitTime . "' WHERE chipID = '" . $exitChipID . "';";

$result = mysqli_multi_query($conn, $query);
$output = loop_multi($result);

mysqli_close($conn);

?>