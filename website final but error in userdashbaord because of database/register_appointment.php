<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php"); // Redirect if the user is not logged in
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register_appointment"])) {
    // Include your database connection code here
    include "db_connection.php";

    // Get data from the form
    $username = $_SESSION["username"]; // Get the username of the currently logged-in user
    $date = $_POST["date"];
    $purpose = $_POST["purpose"];

    // Insert the appointment data into the 'appoint' table
    $insert_sql = "INSERT INTO appoint (user_id, date, purpose) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sss", $username, $date, $purpose);

    if ($stmt->execute()) {
        // Appointment registered successfully
          echo "User registration successful!";
    } else {
        // Error registering appointment
      echo "User was already registered";
    }
} else {
    header("Location: appointment_registration.php"); // Redirect if the form is not submitted
    exit;
}
?>
