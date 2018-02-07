<?php
$connect = mysqli_connect("hostname", "username", "password", "tablename");
$output = array();
$query = "SELECT 
    * 
    FROM competitors 
    WHERE entry_time 
    IS NOT NULL 
    ORDER BY finish_time DESC,
    entry_time DESC";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $output[] = $row;
    }
    echo json_encode($output);
}
mysqli_close($connect);
?>