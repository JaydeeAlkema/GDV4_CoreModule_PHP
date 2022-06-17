<?php

include 'connect.php';

$query = "SELECT * FROM users";

$mysqli->query($query);

$result = $mysqli->query($query);

if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    $my_json = "{\"users\":[";
    $row = $result->fetch_assoc();

    do {
        $my_json .= json_encode($row) . "<br>";
    } while ($row = $result->fetch_assoc());

    $my_json .= "]}";
    echo $my_json;
}
