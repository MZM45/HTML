<?php
// Establish a database connection
$hostname = "localhost"; // Change to your database host
$username = "root";      // Change to your database username
$password = "";          // Change to your database password
$dbname   = "db1";       // Change to your database name

// Create a MySQLi connection
$mysqli = new mysqli($hostname, $username, $password, $dbname);

// Check if the connection was successful
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$appno = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appno = $_POST['appno'];
    $name = $_POST['name'];
    $date_of_birth = $_POST['date_of_birth'];
    $place_of_birth = $_POST['place_of_birth'];
    $status = ($_POST['status'] === '1') ? 1 : 0;

    // Update the birth certificate data in the database
    $query_update = "UPDATE bc
                     SET name = '$name',
                         dob = '$date_of_birth',
                         pob = '$place_of_birth',
                         status = '$status'
                     WHERE appno = '$appno'";

    if ($mysqli->query($query_update) === TRUE) {
        echo "Birth certificate (App No: $appno) updated successfully.";
    } else {
        echo "Error updating birth certificate: " . $mysqli->error;
    }
}

// Redirect back to the form after updating

exit();
?>
