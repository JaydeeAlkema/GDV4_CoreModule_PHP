<?php

include 'connect.php';

// De tabel op de database heet "games", maar het idee is hetzelfde als servers.

// https://www.w3schools.com/php/filter_validate_int.asp
// https://www.php.net/manual/en/function.htmlspecialchars.php
$game_id = filter_var($_GET["game_id"], FILTER_SANITIZE_NUMBER_INT);
$password = htmlspecialchars($_GET["password"], ENT_QUOTES);

$query = "SELECT id FROM games WHERE password='$password'";

if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    if ($row = $result->fetch_assoc() != null) {
        session_start();
        echo "Logged in successfully in game: [" . $game_id . "]. Session id: [" . session_id() . "]";
    } else {
        echo "Wrong game id/password!";
    }
}