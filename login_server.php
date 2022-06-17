<?php

include 'connect.php';

session_start();

// https://www.w3schools.com/php/filter_validate_int.asp
// https://www.php.net/manual/en/function.htmlspecialchars.php
$session_id = htmlspecialchars($_POST["session_id"], ENT_QUOTES);
$servername = htmlspecialchars($_POST["servername"], ENT_QUOTES);
$password = htmlspecialchars($_POST["password"], ENT_QUOTES);

// De tabel op de database heet "games", maar het idee is hetzelfde als servers.
$query = "SELECT id, name FROM games WHERE name='$servername' AND password='$password'";

if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    $row = $result->fetch_assoc();
    if ($row != null) {
        //session_id($session_id); Dit werkte voor een of andere manier niet... Dus ik heb het maar opgeslagen als session variable, wat blijkbaar wel werkt...
        $_SESSION["session_id"] = $session_id;
        $_SESSION["game_id"] = $row["id"];
        echo $_SESSION["session_id"];
    } else {
        echo "Wrong server name/password!";
    }
}