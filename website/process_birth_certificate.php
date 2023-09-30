<?php
session_start();

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['username'])) {
    header('Location: loginuser.html');
    exit;
}

// Retrieve user's full name from the session
$name = $_SESSION['username'];

// Get form data
$placeOfBirth = $_POST['place_of_birth'];
$dateOfBirth = $_POST['date_of_birth'];

// Generate a random application number
$appNumber = mt_rand(100000, 999999);

// Database connection
$hostname = "localhost"; // Change this to your database host
$username = "root";      // Change this to your database username
$password = "";          // Change this to your database password
$dbname = "db1";         // Change this to your database name

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SQL query to insert data into the 'bc' table
    $query = "INSERT INTO bc (username, appno, Status, dob, pob, name)
              VALUES (:username, :appno, false, :dob, :pob, :name)";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':username', $name, PDO::PARAM_STR);
    $stmt->bindParam(':appno', $appNumber, PDO::PARAM_INT);
    $stmt->bindParam(':dob', $dateOfBirth, PDO::PARAM_STR);
    $stmt->bindParam(':pob', $placeOfBirth, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR); // Added this line

    $stmt->execute();

    // Redirect to a confirmation page or display a success message
    header('Location: confirmation_page.html');
    exit;
} catch (PDOException $e) {
    // Handle any database errors here
    echo "Error: " . $e->getMessage();
}
?>
