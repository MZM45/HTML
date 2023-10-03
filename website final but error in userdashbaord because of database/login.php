<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle login logic here
    $username = $_POST["username"];
    $password = $_POST["password"];

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

    // Retrieve the hashed password from the 'registry' table
    $sql = "SELECT * FROM registry WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Start a session for user authentication
            session_start();
            $_SESSION["username"] = $username;

            // Successful login, redirect to the profile page
            header("Location: profile.php");
            exit;
        } else {
            echo "Invalid username or password. Please try again.";
        }
    } else {
        echo "Invalid username or password. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
