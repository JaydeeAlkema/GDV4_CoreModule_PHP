<?php

include 'connect.php';

$query = "SELECT u.username, COUNT(user_id) AS aantal_keer_gespeeld, AVG(score) AS gemiddelde_score FROM scores s INNER JOIN users u ON s.user_id=u.id GROUP BY score DESC LIMIT 5";

if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    $row = $result->fetch_assoc();

    do {
        $my_json .= json_encode($row) . "<br>";
    } while ($row = $result->fetch_assoc());

    echo $my_json;
}