<?php
session_start();

if (!isset($_SESSION["admin_username"])) {
    header("Location: admin_login.php");
    exit;
}

include "db_connection.php"; // Include your database connection code here

// Check if the form has been submitted to add a new field


$conn->close();
error_reporting(E_ERROR | E_PARSE);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Form</title>
    <link rel="stylesheet" href="managestyle.css"> <!-- Use your style.css file -->
</head>

<body>
    <div class="nav-bar">
        <a href="admin_manage_form.php">Manage Form</a>
        <a href="admin_view_registrations.php">Manage Registrations</a>
        <a href="users.php">Users</a>
        <a href="admin_logout.php">Logout</a>
    </div>
    <div class="wrap">
        <h2>Manage Form Fields</h2>
        <div class="form-field">
            <form action="admin_manage_form.php" method="POST">
                <label for="field_label">Field Label:</label>
                <input type="text" id="field_label" name="field_label" required>
                <label for="field_name">Field Name:</label>
                <input type="text" id="field_name" name="field_name" required>
                <label for="field_type">Field Type:</label>
                <select id="field_type" name="field_type" required>
                    <option value="text">Text</option>
                    <option value="textarea">Textarea</option>
                    <option value="email">Email</option>
                    <!-- Add more field types as needed -->
                </select>
                <input type="submit" name="add_field" value="Add Field">
            </form>
        </div>

        <form>
            <?php foreach ($form_fields as $field) { ?>
                <?php if ($field["field_type"] === "text") { ?>
                    <label><?php echo $field["field_label"]; ?>:</label>
                    <input type="text" name="<?php echo $field["field_name"]; ?>">
                <?php } elseif ($field["field_type"] === "textarea") { ?>
                    <label><?php echo $field["field_label"]; ?>:</label>
                    <textarea name="<?php echo $field["field_name"]; ?>"></textarea>
                <?php } elseif ($field["field_type"] === "email") { ?>
                    <label><?php echo $field["field_label"]; ?>:</label>
                    <input type="email" name="<?php echo $field["field_name"]; ?>">
                <?php } ?>
            <?php } ?>
            <input type="submit" value="Submit">
        </form>
    </div>
    </div>
    <div class="form-preview">
        <h3>Registration Form Preview</h3>
        <form>
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
</body>

</html>
