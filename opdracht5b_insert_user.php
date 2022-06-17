<?php

include 'connect.php';

// https://www.php.net/manual/en/function.htmlspecialchars.php
$username = htmlspecialchars($_GET["username"], ENT_QUOTES);
$first_name = htmlspecialchars($_GET["first_name"], ENT_QUOTES);
$last_name = htmlspecialchars($_GET["last_name"], ENT_QUOTES);
$password = htmlspecialchars($_GET["password"], ENT_QUOTES);

// https://www.w3schools.com/php/filter_sanitize_email.asp
$email =  filter_var($_GET["email"], FILTER_SANITIZE_EMAIL);

// date input will be in the form of a TimeStamp, for example: "1541843467"; This means it could only ever be an integer.
$sanitized_birth_date = filter_var($_GET["birth_date"], FILTER_SANITIZE_NUMBER_INT);
$birth_date = date("Y-m-d H:i:s", $sanitized_birth_date);

// Per default we may assume an account with the given email doesn't exist, but that's why we check anyway.
// 0 = no account exists, 1 = email already in user, 2 = username already in use
$valid_input = 0;

// Get email from database, if this returns null, then the user may continue, otherwise they have to use a different email.
$query  = "SELECT email FROM users WHERE email='$email'";
if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    $row = $result->fetch_assoc();
    if ($row != null) {
        $valid_input = 1;
    }
}

// Get username from database, if this returns null, then the user may continue, otherwise they have to use a different username.
$query  = "SELECT username FROM users WHERE username='$username'";
if (!($result = $mysqli->query($query))) {
    showerror($mysqli->errno, $mysqli->error);
} else {
    $row = $result->fetch_assoc();
    if ($row != null) {
        $valid_input = 2;
    }
}

if ($valid_input == 0) {
    // Insert a new user into the database.
    $query  = "INSERT INTO users (username, first_name, last_name, password, email, birth_date, register_date, last_login_date ) 
    VALUES ('" . $username . "', '" . $first_name . "', '" . $last_name . "', '" . $password . "', '" . $email . "', '" . $birth_date . "', '" . date("Y-m-d H:i:s", time()) . "', '" . date("Y-m-d H:i:s", time()) . "')";

    if (!($result = $mysqli->query($query))) {
        showerror($mysqli->errno, $mysqli->error);
    } else {
        echo "User inserted successfully!";
    }
} else if ($valid_input == 1) {
    echo "Email already in use, please use a different Email!";
} else if ($valid_input == 2) {
    echo "Username already in use, please use a different Username!";
}