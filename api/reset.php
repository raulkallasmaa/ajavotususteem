<?php
$conn = mysqli_connect("localhost", "username", "password", "tablename");
$output = array();
$query = "UPDATE competitors SET entry_time = null, finish_time = null;";
$result = mysqli_query($conn, $query);
if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

while ($row = mysqli_fetch_assoc($result)) {
    {
        $output[] = $row;
    }
    echo json_encode($output);
}
mysqli_close($conn);
?>