<?php

include 'connect.php';

session_start();

$valid_input = "";

if (isset($_POST["session_id"]) == false || $_POST["session_id"] != $_SESSION["session_id"]) {
    $valid_input += "Incorrect Session ID! ";
}

if (isset($_POST["interval1"])) {
    $interval1 = filter_var($_POST['interval1'], FILTER_SANITIZE_NUMBER_INT);
} else {
    $valid_input += "interval1 can not be empty! ";
}

if (isset($_POST["interval2"])) {
    $interval2 = filter_var($_POST['interval2'], FILTER_SANITIZE_NUMBER_INT);
} else {
    $valid_input += "interval2 can not be empty! ";
}

$query = "SELECT users.username, scores.score FROM scores INNER JOIN users ON scores.user_id=users.id WHERE scores.date >= NOW() - INTERVAL '$interval1' MONTH AND scores.date <= NOW() - INTERVAL '$interval2' MONTH ORDER BY scores.score DESC LIMIT 5";
$query2 = "SELECT COUNT(score) AS plays FROM scores WHERE date >= NOW() - INTERVAL '$interval1' MONTH AND date <= NOW() - INTERVAL '$interval2' MONTH";

// De text die hieruit word meegegeven word binnen Unity mooi afgehandeld.
if ($valid_input == "") {
    if (!($result = $mysqli->query($query))) {
        showerror($mysqli->errno, $mysqli->error);
    } else {
        // Check of er uberhaupt een antwoord terug komt, zo niet, dan kunnen we ervan uit gaan dat de POST gegevens niet kloppen.
        $row = $result->fetch_assoc();
        if ($row != null) {
            do {
                $my_json .= json_encode($row);
            } while ($row = $result->fetch_assoc());
            echo $my_json;
        } else {
            echo "Wrong id/username";
        }
    }

    // Haal de totale aantal plays op tussen de meegegeven intervals.
    if (!($result = $mysqli->query($query2))) {
        showerror($mysqli->errno, $mysqli->error);
    } else {
        // Check of er uberhaupt een antwoord terug komt, zo niet, dan kunnen we ervan uit gaan dat de POST gegevens niet kloppen.
        $row = $result->fetch_assoc();
        if ($row != null) {
            echo json_encode($row);
        }
    }
} else {
    echo "Error code: " + $valid_input;
}