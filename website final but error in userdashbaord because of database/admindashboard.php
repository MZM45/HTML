<?php
session_start();

if (!isset($_SESSION["admin_username"])) {
    header("Location: admin_login.php");
    exit;
}

include "db_connection.php"; // Include your database connection code here

// Fetch data from the 'reg' table
$sql = "SELECT * FROM reg";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $data = [];
}

// Handle status updates
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["approve_status"])) {
    $user_id = $_POST["user_id"];
    // Update the status to approved (you may need to adjust the SQL query)
    $update_sql = "UPDATE reg SET status = 1 WHERE user_id = $user_id";
    if ($conn->query($update_sql) === TRUE) {
        header("Location: admindashboard.php");
        exit;
    } else {
        echo "Error updating status: " . $conn->error;
    }
}

// Handle admin updates for user information
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["admin_update"])) {
    $user_id = $_POST["user_id"];
    $new_name = $_POST["new_name"];
    $new_dob = $_POST["new_dob"];
    $new_gender = $_POST["new_gender"];
    $new_address = $_POST["new_address"];
    $new_father_name = $_POST["new_father_name"];
    $new_mother_name = $_POST["new_mother_name"];
    $new_register_type = $_POST["new_register_type"];
    $new_place_of_birth = $_POST["new_place_of_birth"];
    $new_cause_of_death = $_POST["new_cause_of_death"];

    // Update the user information in the database
    $update_sql = "UPDATE reg SET
        name = '$new_name',
        dob = '$new_dob',
        gender = '$new_gender',
        address = '$new_address',
        father_name = '$new_father_name',
        mother_name = '$new_mother_name',
        register_type = '$new_register_type',
        place_of_birth = '$new_place_of_birth',
        cause_of_death = '$new_cause_of_death'
        WHERE user_id = $user_id";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: admindashboard.php");
        exit;
    } else {
        echo "Error updating user information: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adminstyle.css"> <!-- Include your admin dashboard CSS -->
</head>
<body>
    <div class="nav-bar">
        <a href="admindashboard.php">Dashboard</a>
        <a href="index.html">Logout</a>
    </div>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Father's Name</th>
                    <th>Mother's Name</th>
                    <th>Register Type</th>
                    <th>Place of Birth</th>
                    <th>Cause of Death</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row) { ?>
                    <tr>
                        <td><?= $row["user_id"] ?></td>
                        <td><?= $row["name"] ?></td>
                        <td><?= $row["dob"] ?></td>
                        <td><?= $row["gender"] ?></td>
                        <td><?= $row["address"] ?></td>
                        <td><?= $row["father_name"] ?></td>
                        <td><?= $row["mother_name"] ?></td>
                        <td><?= $row["register_type"] ?></td>
                        <td><?= $row["place_of_birth"] ?></td>
                        <td><?= $row["cause_of_death"] ?></td>
                        <td><?= $row["status"] == 1 ? "Approved" : "Pending" ?></td>
                        <td>
                            <form action="admindashboard.php" method="POST">
                                <input type="hidden" name="user_id" value="<?= $row["user_id"] ?>">
                                <button type="submit" name="approve_status" class="approve-button">Approve</button>
                            </form>
                            <form action="admindashboard.php" method="POST">
                                <input type="hidden" name="user_id" value="<?= $row["user_id"] ?>">
                                <input type="text" name="new_name" placeholder="New Name">
                                <input type="date" name="new_dob" placeholder="New Date of Birth">
                                <select name="new_gender" placeholder="New Gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <input type="text" name="new_address" placeholder="New Address">
                                <input type="text" name="new_father_name" placeholder="New Father's Name">
                                <input type="text" name="new_mother_name" placeholder="New Mother's Name">
                                <input type="text" name="new_register_type" placeholder="New Register Type">
                                <input type="text" name="new_place_of_birth" placeholder="New Place of Birth">
                                <input type="text" name="new_cause_of_death" placeholder="New Cause of Death">
                                <button type="submit" name="admin_update" class="admin-update-button">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
