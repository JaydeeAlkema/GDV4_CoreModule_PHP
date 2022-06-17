<?php

include 'connect.php';

$query = "SELECT user_id, COUNT(user_id) AS aantal_keer_gespeeld, AVG(score) AS gemiddelde_score FROM scores GROUP BY user_id";

if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    $row = $result->fetch_assoc();

    do {
        $my_json .= json_encode($row) . "<br>";
    } while ($row = $result->fetch_assoc());

    echo $my_json;
}