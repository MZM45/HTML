<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get admin credentials from the form
    $admin_username = $_POST["admin_username"];
    $admin_password = $_POST["admin_password"];

    // Check if the credentials match those in the admin table
    include "db_connection.php"; // Include your database connection code here

    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $admin_username, $admin_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Admin credentials are correct
        $_SESSION["admin_username"] = $admin_username;
        header("Location: admindashboard.php"); // Redirect to the admin dashboard
        exit;
    } else {
        // Admin credentials are incorrect
        $error_message = "Admin login failed. Please check your credentials.";
    }

    $stmt->close();
    $conn->close();
}
?>
