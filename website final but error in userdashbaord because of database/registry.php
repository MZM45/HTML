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
        $dob = $_POST["dob"];
        $gender = $_POST["gender"];
        $address = $_POST["address"];
        $father_name = $_POST["father_name"];
        $mother_name = $_POST["mother_name"];
        $register_type = $_POST["register_type"];
        $place_of_birth = ($register_type === "birth") ? $_POST["place_of_birth"] : "";
        $cause_of_death = ($register_type === "death") ? $_POST["cause_of_death"] : "";

        // Insert data into the 'register' table
        $sql = "INSERT INTO reg (user_id, name, dob, gender, address, father_name, mother_name, register_type, place_of_birth, cause_of_death) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt || !$stmt->bind_param("ssssssssss", $user_id, $name, $dob, $gender, $address, $father_name, $mother_name, $register_type, $place_of_birth, $cause_of_death) || !$stmt->execute()) {
            $error_message = "Registration failed: " . $stmt->error;
        } else {
            $success_message = "Registration successful!";
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
    <title>Registration</title>
    <link rel="stylesheet" href="regisrystyle.css"> <!-- Use your style.css file -->
</head>

<body>
    <div class="nav-bar">
        <a href="profile.php">Profile</a>
        <a href="registry.php">Registry</a>
        <a href="appointment.php">Appointments</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Registration</h2>
        <form action="registry.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required><br><br>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select><br><br>

            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="3" required></textarea><br><br>

            <label for="father_name">Father's Name:</label>
            <input type="text" id="father_name" name="father_name" required><br><br>

            <label for="mother_name">Mother's Name:</label>
            <input type="text" id="mother_name" name="mother_name" required><br><br>

            <label for="register_type">Register Type:</label>
            <select id="register_type" name="register_type" required>
                <option value="" disabled selected>Select</option>
                <option value="birth">Birth</option>
                <option value="death">Death</option>
            </select><br><br>

            <div id="place_of_birth_container" style="display: none;">
                <label for="place_of_birth">Place of Birth:</label>
                <input type="text" id="place_of_birth" name="place_of_birth">
            </div>

            <div id="cause_of_death_container" style="display: none;">
                <label for="cause_of_death">Cause of Death:</label>
                <input type="text" id="cause_of_death" name="cause_of_death">
            </div><br><br>

            <input type="submit" value="Register">
        </form>
    </div>

    <script>
        // JavaScript to toggle the visibility of "Place of Birth" or "Cause of Death" fields
        const registerTypeSelect = document.getElementById("register_type");
        const placeOfBirthContainer = document.getElementById("place_of_birth_container");
        const causeOfDeathContainer = document.getElementById("cause_of_death_container");

        registerTypeSelect.addEventListener("change", () => {
            if (registerTypeSelect.value === "birth") {
                placeOfBirthContainer.style.display = "block";
                causeOfDeathContainer.style.display = "none";
            } else if (registerTypeSelect.value === "death") {
                placeOfBirthContainer.style.display = "none";
                causeOfDeathContainer.style.display = "block";
            } else {
                placeOfBirthContainer.style.display = "none";
                causeOfDeathContainer.style.display = "none";
            }
        });
    </script>
</body>

</html>
