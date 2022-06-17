<?php

include 'connect.php';

// Source: https://www.pakainfo.com/php-mysqli-datetime-format-insert-into-mysql/
$timestamp = date("Y-m-d G-i:s");

$score = $_GET["score"];
$user_id = $_GET["user_id"];
$game_id = $_GET["game_id"];

$validInput = 0;

// https://www.w3schools.com/php/filter_validate_int.asp
// Validating all input
if (filter_var($score, FILTER_VALIDATE_INT) == false) {
    $validInput = 1;
}
if (filter_var($user_id, FILTER_VALIDATE_INT) == false) {
    $validInput = 1;
}
if (filter_var($game_id, FILTER_VALIDATE_INT) == false) {
    $validInput = 1;
}

if ($validInput == 0) {
    $query  = "INSERT INTO scores (score, user_id, game_id, date ) VALUES ('" . $score . "', '" . $user_id . "', '" . $game_id . "', '" . $timestamp . "')";

    if (!($result = $mysqli->query($query))) {
        showerror($mysqli->errno, $mysqli->error);
    } else {
        echo "Score inserted successfully!";
    }
} else {
    echo "Input was not valid.";
}
