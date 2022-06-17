<?php

include "connect.php";

// Source: https://www.pakainfo.com/php-mysqli-datetime-format-insert-into-mysql/
$timestamp = date("Y-m-d G-i:s");

// Voor een of andere reden insert dit 2 keer de score in de database...
// Misschien ligt het aan mijn browser?
$query  = "INSERT INTO scores (score, user_id, game_id, date ) VALUES ('" . rand(100, 999) . "', '" . rand(1, 5) . "', '" . rand(1, 5) . "', '" . $timestamp . "')";

if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    echo "Score inserted successfully!";
}
