<?php

include 'connect.php';

// Source: https://www.pakainfo.com/php-mysqli-datetime-format-insert-into-mysql/
$timestamp = date("Y-m-d G-i:s");

$score = $_GET["score"];
$user_id = $_GET["user_id"];
$game_id = $_GET["game_id"];

$query  = "INSERT INTO scores (score, user_id, game_id, date ) VALUES ('" . $score . "', '" . $user_id . "', '" . $game_id . "', '" . $timestamp . "')";

if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    echo "Score inserted successfully!";
}
