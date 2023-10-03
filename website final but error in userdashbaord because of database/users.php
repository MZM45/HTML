<?php
session_start();

if (!isset($_SESSION["admin_username"])) {
    header("Location: admin_login.php");
    exit;
}

// Include your database connection code here
include "db_connection.php";
// Fetch data from the 'registry' table
$sql = "SELECT * FROM registry";
$result = $conn->query($sql);

$userData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userData[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="style.css"> <!-- Use your style.css file -->
</head>

<body>
    <div class="nav-bar">
        <a href="admin_manage_form.php">Manage Form</a>
        <a href="admin_view_registrations.php">Manage Registrations</a>
        <a href="admin_users.php">Users</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="table">
        <h2>Users</h2>
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userData as $data) { ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['name']; ?></td>
                        <td><?php echo $data['phone']; ?></td>
                        <td><?php echo $data['email']; ?></td>
                        <td><?php echo $data['username']; ?></td>
                        <td><?php echo $data['password']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>