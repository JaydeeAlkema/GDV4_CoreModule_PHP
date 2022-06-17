<?php

include 'connect.php';

$query = "SELECT users.username, scores.score, scores.date FROM scores INNER JOIN users ON scores.user_id=users.id ORDER BY scores.date DESC LIMIT 5";

if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    $row = $result->fetch_assoc();

    do {
        $my_json .= json_encode($row) . "<br>";
    } while ($row = $result->fetch_assoc());

    echo $my_json;
}