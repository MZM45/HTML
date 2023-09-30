<?php
session_start();

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['username'])) {
    header('Location: loginuser.html');
    exit;
}

// Get the current logged-in username from the session
$username = $_SESSION['username'];

// Process the Death Certificate application form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Establish a database connection (modify the database credentials as needed)
    $hostname = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "db1";

    try {
        $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $db_username, $db_password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    // Generate a random application number
    $appno = rand(1000, 9999);

    // Retrieve data from the Death Certificate application form
    $name = $_POST['name'];
    $date_of_death = $_POST['date_of_death'];

    // Insert the application data into the database
    $query = "INSERT INTO dc (username, appno, status, Name, date_of_death) VALUES (:username, :appno, 0, :name, :date_of_death)";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':appno', $appno);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':date_of_death', $date_of_death);

    if ($stmt->execute()) {
        // Application successfully submitted
        header('Location: deathconfirmation_page.html');
        exit;
    } else {
        // Error occurred while submitting the application
        echo "Error: Unable to submit the Death Certificate application.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
