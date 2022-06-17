<?php

include 'connect.php';

// Interval is in weken, aangezien er niet elke week scores worden toegevoegd kan je hiermee zelf bepalen sinds de laatste hoeveel weken je wilt checken.
$interval = filter_var($_GET["interval"], FILTER_SANITIZE_NUMBER_INT);
$method = filter_var($_GET["method"], FILTER_SANITIZE_NUMBER_INT);
$user_id = filter_var($_GET["user_id"], FILTER_SANITIZE_NUMBER_INT);

// Weet niet zeker of dit geldt als twee "verschillende" manieren checken tussen twee datums... Hoop het wel :P
if ($method == 1) {
    // https://stackoverflow.com/questions/10763031/how-to-subtract-30-days-from-the-current-datetime-in-mysql
    $query = "SELECT users.username, scores.score, scores.date FROM scores INNER JOIN users ON scores.user_id=users.id WHERE date BETWEEN DATE_SUB(CURDATE(), INTERVAL '$interval' WEEK) AND NOW()";
} else if ($method == 2) {
    // https://stackoverflow.com/questions/8544438/select-records-from-now-1-day
    $query = "SELECT users.username, scores.score, scores.date FROM scores INNER JOIN users ON scores.user_id=users.id WHERE date >= NOW() - INTERVAL '$interval' WEEK";
} else if ($method == 3) {
    $query = "SELECT COUNT(user_id) AS 'Number of Entries' FROM scores WHERE date >= NOW() - INTERVAL '$interval' WEEK AND user_id='$user_id'";
}

if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    $row = $result->fetch_assoc();
    if ($row != null) {
        do {
            $my_json .= json_encode($row) . "<br>";
        } while ($row = $result->fetch_assoc());
        echo $my_json;
    } else {
        echo "No scores found in the last";
    }
}