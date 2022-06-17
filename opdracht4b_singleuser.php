<?php

include 'connect.php';

$query = "SELECT id, username, first_name, last_name, password, email, birth_date, register_date, last_login_date FROM users WHERE id = 1";

$mysqli->query($query);

$result = $mysqli->query($query);

if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    $row = $result->fetch_assoc();
    echo json_encode($row);
    echo "<br>";
}
