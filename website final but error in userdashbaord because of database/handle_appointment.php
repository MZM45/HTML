<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect if the user is not logged in
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register_appointment"])) {
    // Include your database connection code here
    include "db_connection.php";

    // Get data from the form
    $user_id = $_POST["user_id"];
    $name = $_POST["name"];
    $date = $_POST["date"];
    $purpose = $_POST["purpose"];

    // Insert the appointment data into the 'appoint' table
    $insert_sql = "INSERT INTO appoint (user_id, name, date, purpose) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("isss", $user_id, $name, $date, $purpose);

    if ($stmt->execute()) {
        // Appointment registered successfully
        header("Location: appointment_registration.php?success=1");
        exit;
    } else {
        // Error registering appointment
        header("Location: appointment_registration.php?error=1");
        exit;
    }
} else {
    header("Location: appointment_registration.php"); // Redirect if the form is not submitted
    exit;
}
?>
