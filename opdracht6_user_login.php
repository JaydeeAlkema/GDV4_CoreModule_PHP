<?php

include 'connect.php';

session_start();

$user_id = filter_var($_GET["user_id"], FILTER_SANITIZE_NUMBER_INT);

// 0 is goed, alle andere mogelijkheden niet.
$valid_input = 0;

// Sanitize & Validate? Weet niet of dit logisch is, maar het klinkt wel veilig.
if (filter_var($user_id, FILTER_VALIDATE_INT) == false) {
    $valid_input = 1;
}

if ($valid_input == 0) {
    $query = "SELECT id FROM users WHERE id='$user_id'";

    if (!($result = $mysqli->query($query))) {
        showerror($mysqli->errno, $mysqli->error);
    } else {
        // Check of er uberhaupt een antwoord terug komt, zo niet, dan kunnen we ervan uit gaan dat de user met de gegeven ID niet bestaat.
        if (is_null($result)) {
            echo "Could not log into user with ID: [" . $user_id . "].";
        } else {
            echo "Logged in successfully with user id: [" . $user_id . "]. Session id: [" . session_id() . "]";
            $_SESSION["user_id"] = $user_id;
        }
    }
} else {
    echo "Invalid input! Please check if ID is correct!";
}
