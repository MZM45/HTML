<?php
// Include your database connection code here
include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];

    // Query the database to fetch appointments by user_id
    $sql = "SELECT * FROM appoint WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Appointments found, redirect to results page
        header("Location: appointment_results.php?user_id=$user_id");
        exit;
    } else {
        // No appointments found, display a message or redirect to an error page
        header("Location: no_appointments.php");
        exit;
    }
} else {
    // Redirect back to the search page if user_id is not provided
    header("Location: search_appointment.html");
    exit;
}
?>
