<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include "db_connection.php"; // Include your database connection code here

// Initialize variables
$user_id = $_SESSION["user_id"];
$registration_id = $_GET["id"];
$name = $dob = $gender = $address = "";
$success_message = $error_message = "";

// Retrieve the existing registration data
$sql = "SELECT * FROM register WHERE ID = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $registration_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
    $dob = $row["dob"];
    $gender = $row["gender"];
    $address = $row["address"];
} else {
    echo "Registration not found or you do not have permission to edit it.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];

    // Update the registration data in the database
    $update_query = "UPDATE register SET name = ?, dob = ?, gender = ?, address = ? WHERE ID = ? AND user_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssss", $name, $dob, $gender, $address, $registration_id, $user_id);

    if ($stmt->execute()) {
        $success_message = "Data updated successfully!";
    } else {
        $error_message = "Failed to update data. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Registration</title>
    <link rel="stylesheet" href="style.css"> <!-- Use your style.css file -->
</head>

<body>
    <div class="container">
        <h2>Edit Registration</h2>
        <form action="update.php?id=<?php echo $registration_id; ?>" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
            <label for="dob">Date of Birth:</label>
            <input type="text" id="dob" name="dob" value="<?php echo $dob; ?>" required>
            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" value="<?php echo $gender; ?>" required>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>
            <input type="submit" value="Save Changes">
        </form>
        <?php
        if (!empty($success_message)) {
            echo '<p class="success-message">' . $success_message . '</p>';
        }
        if (!empty($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>
    </div>
</body>

</html>