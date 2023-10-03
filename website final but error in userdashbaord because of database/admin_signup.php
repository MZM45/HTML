<?php
session_start();
include "db_connection.php";

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["admin_username"]) && isset($_POST["admin_password"])) {
    // Get form data
    $admin_username = $_POST["admin_username"];
    $admin_password = $_POST["admin_password"];
    $admin_age = $_POST["admin_age"];
    $admin_email = $_POST["admin_email"];

    // Hash the password for security
    $hashedPassword =$admin_password;

    // Check if the admin username already exists in the table
    $check_sql = "SELECT username FROM admin WHERE username = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $admin_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Admin username is unique; insert the new admin into the table
        $insert_sql = "INSERT INTO admin (username, password, age, email) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssis", $admin_username, $hashedPassword, $admin_age, $admin_email);

        if ($stmt->execute()) {
            // Registration successful
          echo "User registration successful!";
            // Redirect to a login page or display the success message, as needed
        } else {
            $error_message = "Error registering admin: " . $stmt->error;
        }
    } else {
        $error_message = "Admin username already exists. Choose a different username.";
    }
}
