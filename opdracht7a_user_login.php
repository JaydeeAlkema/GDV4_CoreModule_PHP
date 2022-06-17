<?php

include 'connect.php';

// https://www.php.net/manual/en/function.htmlspecialchars.php
$username = htmlspecialchars($_GET["username"], ENT_QUOTES);
$password = htmlspecialchars($_GET["password"], ENT_QUOTES);

$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    // Check of er uberhaupt een antwoord terug komt, zo niet, dan kunnen we ervan uit gaan dat de user gegevens niet kloppen.
    $row = $result->fetch_assoc();
    if ($row != null) {
        echo json_encode($row);
    } else {
        echo "Wrong username/password!";
    }
}