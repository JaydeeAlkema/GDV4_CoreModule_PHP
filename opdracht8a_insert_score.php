<?php

include 'connect.php';

// Source: https://www.pakainfo.com/php-mysqli-datetime-format-insert-into-mysql/
$timestamp = date("Y-m-d G-i:s");
$valid_input = 0; // De verschillende error codes worden in Unity afgehandeld.

if (isset($_GET["session_id"])) {
    $session_id = htmlspecialchars($_GET['session_id'], ENT_QUOTES);
    session_id($session_id);
} else {
    $valid_input = 1;
}

if (isset($_GET["score"])) {
    $score = filter_var($_GET['score'], FILTER_SANITIZE_NUMBER_INT);
} else {
    $valid_input = 2;
}

session_start();

if ($valid_input == 0) {
    if (isset($_SESSION["game_id"]) && $_SESSION["game_id"] != 0 && isset($_SESSION["user_id"]) && $_SESSION["user_id"] != 0) {
        $query  = "INSERT INTO scores (score, user_id, game_id, date ) VALUES ('" . $score . "', '" . $_SESSION["user_id"] . "', '" . $_SESSION["game_id"] . "', '" . $timestamp . "')";

        if (!($result = $mysqli->query($query))) {
            showerror($mysqli->errno, $mysqli->error);
        } else {
            echo "Score inserted successfully!";
        }
    }
} else {
    echo "Error code:" . $valid_input;
}