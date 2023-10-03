<?php
session_start();

if (!isset($_SESSION["admin_username"])) {
    header("Location: admin_login.php");
    exit;
}

// Include your database connection code here
include "db_connection.php";
// Fetch data from the 'reg' table
$sql = "SELECT * FROM reg";
$result = $conn->query($sql);

$registrationData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $registrationData[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Registrations</title>
    <link rel="stylesheet" href="adminviewstyle.css"> <!-- Use your style.css file -->
</head>

<body>
    <div class="nav-bar">
        <a href="admin_manage_form.php">Manage Form</a>
        <a href="admin_manage_registrations.php">Manage Registrations</a>
        <a href="users.php">Users</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="table">
        <h2>Manage Registrations</h2>
        <table class="registration-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Address</th>
                    <th>Father's Name</th>
                    <th>Mother's Name</th>
                    <th>Registered Type</th>
                    <th>Place of Birth</th>
                    <th>Cause of Death</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registrationData as $data) { ?>
                    <tr>
                        <td><?php echo $data['ID']; ?></td>
                        <td><?php echo $data['name']; ?></td>
                        <td><?php echo $data['dob']; ?></td>
                        <td><?php echo $data['address']; ?></td>
                        <td><?php echo $data['father_name']; ?></td>
                        <td><?php echo $data['mother_name']; ?></td>
                        <td><?php echo isset($data['registered_type']) ? $data['registered_type'] : ''; ?></td>
                        <td><?php echo $data['place_of_birth']; ?></td>
                        <td><?php echo $data['cause_of_death']; ?></td>
                        <td><a href="admin_edit_registration.php?id=<?php echo $data['ID']; ?>">Edit</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>
