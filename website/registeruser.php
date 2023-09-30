<?php

$hostname = "localhost"; // Change this to your database host
$username = "root";      // Change this to your database username
$password = "";          // Change this to your database password
$dbname   = "db1";       // Change this to your database name

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Handle form submission
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password =$_POST['password'];

    // Insert the data into the "admin" table
    $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);

    try {
        $stmt->execute();
        echo "User registration successful.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- Add a link to go back to the registration page -->
<p><a href="registeruser.html">Back to Register User</a></p>
