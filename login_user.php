<?php

include 'connect.php';

session_start();

// https://www.php.net/manual/en/function.htmlspecialchars.php
if (isset($_POST["session_id"]) == false || $_POST["session_id"] != $_SESSION["session_id"]) {
    $valid_input += "Incorrect Session ID! ";
}
if (isset($_POST["username"])) {
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
} else {
    $valid_input += "Incorrect Username! ";
}
if (isset($_POST["password"])) {
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES);
} else {
    $valid_input += "Incorrect Password! ";
}


if ($valid_input == 0) {
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

    if (!($result = $mysqli->query($query))) {
        showerror($mysqli->errno, $mysqli->error);
    } else {
        // Check of er uberhaupt een antwoord terug komt, zo niet, dan kunnen we ervan uit gaan dat de user gegevens niet kloppen.
        $row = $result->fetch_assoc();
        if ($row != null) {
            session_start();
            echo json_encode($row);
        } else {
            echo $valid_input;
        }
    }
} else {
    echo $valid_input;
}