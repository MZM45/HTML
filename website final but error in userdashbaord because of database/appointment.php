<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include "db_connection.php"; // Include your database connection code here

$success_message = $error_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the logged-in user's data
    $username = $_SESSION["username"];
    $user_query = "SELECT * FROM registry WHERE username = ?";
    $stmt = $conn->prepare($user_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $user_id = $row["id"]; // Get the user_id from the retrieved data
        $stmt->close();

        // Retrieve form data
        $name = $_POST["name"];
        $date = $_POST["date"];
        $purpose = $_POST["purpose"];

        // Insert data into the 'appoint' table
        $sql = "INSERT INTO appoint (user_id, name, date, purpose) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt || !$stmt->bind_param("ssss", $user_id, $name, $date, $purpose) || !$stmt->execute()) {
            $error_message = "Appointment submission failed: " . $stmt->error;
        } else {
            $success_message = "Appointment submitted successfully!";
        }

        $stmt->close();
    } else {
        $error_message = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment</title>
    <link rel="stylesheet" href="style.css"> <!-- Use your style.css file -->
</head>

<body>
    <div class="nav-bar">
        <a href="profile.php">Profile</a>
        <a href="registry.php">Registry</a>
        <a href="appointment.php">Appointments</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Appointment Form</h2>
        <form action="appointment.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required><br><br>

            <label for="purpose">Purpose:</label>
            <textarea id="purpose" name="purpose" rows="3" required></textarea><br><br>

            <input type="submit" value="Submit Appointment">
        </form>

        <!-- Display success or error message -->
        <?php
        if (!empty($success_message)) {
            echo '<div class="success-message">' . $success_message . '</div>';
        }
        if (!empty($error_message)) {
            echo '<div class="error-message">' . $error_message . '</div>';
        }
        ?>
    </div>
</body>

</html>