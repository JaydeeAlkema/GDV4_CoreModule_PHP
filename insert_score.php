<?php

include 'connect.php';

session_start();

// Source: https://www.pakainfo.com/php-mysqli-datetime-format-insert-into-mysql/
$timestamp = date("Y-m-d G-i:s");
$valid_input = "";

if (isset($_POST["session_id"]) == false || $_POST["session_id"] != $_SESSION["session_id"]) {
    $valid_input += "Incorrect Session ID! ";
}

if (isset($_POST["score"])) {
    $score = filter_var($_POST['score'], FILTER_SANITIZE_NUMBER_INT);
} else {
    $valid_input += "Score can't be empty! ";
}

if (isset($_POST["user_id"])) {
    $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
} else {
    $valid_input += "User ID can't be empty! ";
}

if (isset($_SESSION["game_id"]) == false && $_SESSION["game_id"] == 0) {
    $valid_input += "Game ID can't be empty! ";
}

if ($valid_input == "") {
    $query  = "INSERT INTO scores (score, user_id, game_id, date ) VALUES ('" . $score . "', '" . $user_id . "', '" . $_SESSION["game_id"] . "', '" . $timestamp . "')";

    if (!($result = $mysqli->query($query))) {
        showerror($mysqli->errno, $mysqli->error);
    } else {
        echo "Score inserted successfully!";
    }
} else {
    echo "Error code:" . $valid_input;
}