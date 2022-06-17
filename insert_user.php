<?php

include 'connect.php';

session_start();

// https://www.php.net/manual/en/function.htmlspecialchars.php
$id = filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT);
$username = htmlspecialchars($_POST["username"], ENT_QUOTES);
$first_name = htmlspecialchars($_POST["first_name"], ENT_QUOTES);
$last_name = htmlspecialchars($_POST["last_name"], ENT_QUOTES);
$password = htmlspecialchars($_POST["password"], ENT_QUOTES);

// https://www.w3schools.com/php/filter_sanitize_email.asp
$email =  filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

// datuminvoer zal in de vorm van een TimeStamp zijn, bijvoorbeeld: "1541843467"; Dit betekent dat het alleen maar een geheel getal kan zijn.
$sanitized_birth_date = filter_var($_POST["birth_date"], FILTER_SANITIZE_NUMBER_INT);
$birth_date = date("Y-m-d H:i:s", $sanitized_birth_date);

// Per default mogen we aannemen dat een account met het opgegeven emailadres niet bestaat, maar we controleren het toch.
$valid_input = "";

// Dit controleert of de sessie id dezelfde is als de opgegeven id. In principe wordt hier dus gecontroleerd of de server nog "ingelogd" is.
if (isset($_POST["session_id"]) == false || $_POST["session_id"] != $_SESSION["session_id"]) {
    $valid_input += "Incorrect Session ID! ";
}

// Als ID is ontvangen als -1, dan voegen we nieuwe gebruiker toe, anders bewerken we gebruikersinfo.
if ($id == -1) {
    // Haal email op uit de database, als dit null retourneert, dan mag de gebruiker verder gaan, anders moet hij een ander email gebruiken.
    $query  = "SELECT email FROM users WHERE email='$email'";
    if (!($result = $mysqli->query($query))) {
        showerror($mysqli->errno, $mysqli->error);
    } else {
        $row = $result->fetch_assoc();
        if ($row != null) {
            $valid_input += "Email already in use! ";
        }
    }

    // Haal de gebruikersnaam op uit de database, als deze null retourneert, dan mag de gebruiker doorgaan, anders moet hij een andere gebruikersnaam gebruiken.
    $query  = "SELECT username FROM users WHERE username='$username'";
    if (!($result = $mysqli->query($query))) {
        showerror($mysqli->errno, $mysqli->error);
    } else {
        $row = $result->fetch_assoc();
        if ($row != null) {
            $valid_input += "Username already in use! ";
        }
    }

    if ($valid_input == "") {
        // Voeg een nieuwe gebruiker toe in de database.
        $query = "INSERT INTO users (username, first_name, last_name, password, email, birth_date, register_date, last_login_date ) VALUES ('" . $username . "', '" . $first_name . "', '" . $last_name . "', '" . $password . "', '" . $email . "', '" . $birth_date . "', '" . date("Y-m-d H:i:s", time()) . "', '" . date("Y-m-d H:i:s", time()) . "')";

        if (!($result = $mysqli->query($query))) {
            showerror($mysqli->errno, $mysqli->error);
        } else {
            echo "User inserted successfully!";
        }
    } else {
        echo "Error Code: " . $valid_input;
    }
} else {
    if ($valid_input == "") {
        // Update gebruikersgegevens in database.
        $query  = "UPDATE users SET username='$username', first_name='$first_name', last_name='$last_name', password='$password', email='$email', birth_date='$birth_date' WHERE id='$id'";

        if (!($result = $mysqli->query($query))) {
            showerror($mysqli->errno, $mysqli->error);
        } else {
            echo "User updated successfully!";
        }
    } else {
        echo "Error Code: " . $valid_input;
    }
}