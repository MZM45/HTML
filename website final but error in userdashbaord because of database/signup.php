<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle signup logic here
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Include your database connection code here
    // Replace these with your actual database credentials
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "register";

    // Create a database connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert user data into the 'registry' table
    $sql = "INSERT INTO registry (name, phone, email, username, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $phone, $email, $username, $hashedPassword);

    if ($stmt->execute()) {
        echo "User registration successful!";
        // You can redirect the user to the login page or any other page as needed.
        // header("Location: login.php");
        // exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
