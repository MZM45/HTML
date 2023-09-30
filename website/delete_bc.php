<?php
// Establish a database connection
$hostname = "localhost"; // Change to your database host
$username = "root";      // Change to your database username
$password = "";          // Change to your database password
$dbname   = "db1";   // Change to your database name

// Create a MySQLi connection
$mysqli = new mysqli($hostname, $username, $password, $dbname);

// Check if the connection was successful
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appno = $_POST['appno'];

    // Search for the record in the "bc" table by App No
    $query_select = "SELECT * FROM bc WHERE appno = '$appno'";
    $result = $mysqli->query($query_select);

    if ($result->num_rows > 0) {
        // Record found, delete it
        $query_delete = "DELETE FROM bc WHERE appno = '$appno'";
        if ($mysqli->query($query_delete) === TRUE) {
            echo "BC Record with App No: $appno has been deleted successfully.";
        } else {
            echo "Error deleting BC Record: " . $mysqli->error;
        }
    } else {
        echo "No BC Record found with App No: $appno.";
    }
}

// Close the MySQL connection
$mysqli->close();
?>
