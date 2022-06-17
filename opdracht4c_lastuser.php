<?php

include 'connect.php';

// Source: https://stackoverflow.com/questions/10503195/get-last-entry-in-a-mysql-table
$query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";

$mysqli->query($query);

$result = $mysqli->query($query);

if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    $row = $result->fetch_assoc();
    echo json_encode($row);
}
