<?php

include 'connect.php';

session_start();

$game_id = filter_var($_GET["game_id"], FILTER_SANITIZE_NUMBER_INT);

// 0 is goed, alle andere mogelijkheden niet.
$valid_input = 0;

// Sanitize & Validate? Weet niet of dit logisch is, maar het klinkt wel veilig.
if (filter_var($game_id, FILTER_VALIDATE_INT) == false) {
    $valid_input = 1;
}

if ($valid_input == 0) {
    // Ik gebruik 'games' in plaats van 'servers'. Het idee is hetzelfde, alleen andere naam.
    $query = "SELECT id FROM games";

    if (!($result = $mysqli->query($query))) {
        showerror($mysqli->errno, $mysqli->error);
    } else {
        // https://www.geeksforgeeks.org/php-mysqli_num_rows-function/#:~:text=The%20mysqli_num_rows()%20function%20is,connection%20with%20the%20MySQL%20database.
        $row = mysqli_num_rows($result);

        if ($game_id < 0 || $game_id > $row) {
            echo "No game exists with id: " . $game_id . ". Please check if ID is correct!";
        } else {
            echo "Logged in successfully into game with id: [" . $game_id . "]. Session id: [" . session_id() . "]";
            $_SESSION["game_id"] = $game_id;
        }
    }
} else {
    echo "Invalid input! Please check if ID is correct!";
}
