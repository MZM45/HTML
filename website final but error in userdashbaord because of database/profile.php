<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include "db_connection.php"; // Include your database connection code here

$success_message = $error_message = "";

// Retrieve user information from the 'registry' table
$username = $_SESSION["username"];
$sql = "SELECT * FROM registry WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$r = $stmt->get_result();

if ($r->num_rows === 1) {
    $row = $r->fetch_assoc();


    $email = $row["email"];
    $phone = $row["phone"];
    $user_id = $row["id"];
} else {
    echo "User not found.";
}

// Handle registration
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register"])) {
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $father_name = $_POST["father_name"];
    $mother_name = $_POST["mother_name"];
    $register_type = $_POST["register_type"];
    $place_of_birth = ($register_type === "birth") ? $_POST["place_of_birth"] : "";
    $cause_of_death = ($register_type === "death") ? $_POST["cause_of_death"] : "";

    // Insert the registration data into the 'reg' table
    $insert_sql = "INSERT INTO reg (user_id, name, dob, gender, address, father_name, mother_name, register_type, place_of_birth, cause_of_death) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);

    if ($stmt->bind_param("isssssssss", $user_id, $name, $dob, $gender, $address, $father_name, $mother_name, $register_type, $place_of_birth, $cause_of_death) && $stmt->execute()) {
        $success_message = "Registration successful!";
    } else {
        $error_message = "Error registering: " . $stmt->error;
    }
}
?>
<?php
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include "db_connection.php"; // Include your database connection code here

$success_message = $error_message = "";

// Retrieve user information from the 'registry' table
$username = $_SESSION["username"];
$sql = "SELECT * FROM registry WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$r = $stmt->get_result();

if ($r->num_rows === 1) {
    $row = $r->fetch_assoc();


    $email = $row["email"];
    $phone = $row["phone"];
    $user_id = $row["id"];
} else {
    echo "User not found.";
}




if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include "db_connection.php"; // Include your database connection code here

$success_message = $error_message = "";

// Retrieve user information from the 'registry' table
$username = $_SESSION["username"];
$sql = "SELECT * FROM registry WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$r = $stmt->get_result();

if ($r->num_rows === 1) {
    $row = $r->fetch_assoc();


    $email = $row["email"];
    $phone = $row["phone"];
    $user_id = $row["id"];
} else {
    echo "User not found.";
}



// Retrieve appointments of the current user
$appointments = array();
$appointments_sql = "SELECT date, purpose FROM appoint WHERE user_id = ?";
$stmt = $conn->prepare($appointments_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$appointments_result = $stmt->get_result();

if ($appointments_result->num_rows > 0) {
    while ($row = $appointments_result->fetch_assoc()) {
        $appointments[] = $row;
    }
}
?>
<?php


if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include "db_connection.php"; // Include your database connection code here

$success_message = $error_message = "";

// Retrieve user information from the 'registry' table
$username = $_SESSION["username"];
$sql = "SELECT * FROM registry WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$r = $stmt->get_result();

if ($r->num_rows === 1) {
    $row = $r->fetch_assoc();

    $email = $row["email"];
    $phone = $row["phone"];
    $user_id = $row["id"];
} else {
    echo "User not found.";
}



// Retrieve appointments for the logged-in user
$appointments = array();
$appointments_sql = "SELECT date, purpose FROM appoint WHERE user_id = ?";
$stmt = $conn->prepare($appointments_sql);
$stmt->bind_param("s", $username); // Bind the username as a string
$stmt->execute();
$appointments_result = $stmt->get_result();

if ($appointments_result->num_rows > 0) {
    while ($row = $appointments_result->fetch_assoc()) {
        $appointments[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="dashboardstyle.css"> <!-- Include your dashboard CSS -->
</head>
<body>
    <div class="nav-bar">
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>User Dashboard</h2>
        <div class="profile">
            <div class="profile-info">
                <h2>Welcome</h2>
                <p>Username: <?php echo $username; ?></p>
                <p>Phone: <?php echo $phone; ?></p>
                <p>Email: <?php echo $email; ?></p>
            </div>
        </div>
        <div class="appointment-form">
          <h2>Appointment Registration</h2>
     <form action="register_appointment.php" method="POST">
         <label for="date">Date:</label>
         <input type="date" id="date" name="date" required><br><br>

         <label for="purpose">Purpose:</label>
         <textarea id="purpose" name="purpose" rows="3" required></textarea><br><br>

         <input type="submit" name="register_appointment" value="Register Appointment">
     </form>
   </div>
        <div class="registration-form">
            <h2>Registration</h2>
            <form action="profile.php" method="POST">
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
                    <option value="birth">Birth</option>
                    <option value="death">Death</option>
                </select><br><br>

                <div id="place_of_birth_container">
                    <label for="place_of_birth">Place of Birth:</label>
                    <input type="text" id="place_of_birth" name="place_of_birth">
                </div>

                <div id="cause_of_death_container" style="display: none;">
                    <label for="cause_of_death">Cause of Death:</label>
                    <input type="text" id="cause_of_death" name="cause_of_death">
                </div><br><br>

                <input type="submit" name="register" value="Register">
            </form>
            <?php
            if (!empty($success_message)) {
                echo '<p class="success-message">' . $success_message . '</p>';
            } elseif (!empty($error_message)) {
                echo '<p class="error-message">' . $error_message . '</p>';
            }
            ?>
        </div>
    </div>
    <script>
        // JavaScript to toggle the visibility of "Place of Death" field
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

            <!-- Appointments Section -->
            <div class="appointments">
                <h2>Your Appointments</h2>
                <?php if (!empty($appointments)): ?>
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Purpose</th>
                        </tr>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?php echo $appointment['date']; ?></td>
                                <td><?php echo $appointment['purpose']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>No appointments found.</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Registrations Section -->
        <div class="registrations">
            <h2>Your Registrations</h2>
            <?php
            // Retrieve registrations of the current user
            $registrations = array();
            $registrations_sql = "SELECT name, dob, gender, address, father_name, mother_name, register_type, place_of_birth, cause_of_death, status FROM reg WHERE user_id = ?";
            $stmt = $conn->prepare($registrations_sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $registrations_result = $stmt->get_result();

            if ($registrations_result->num_rows > 0) {
                while ($row = $registrations_result->fetch_assoc()) {
                    $registrations[] = $row;
                }
            }
            ?>
            <?php if (!empty($registrations)): ?>
                <table>
                    <tr>
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
                    </tr>
                    <?php foreach ($registrations as $registration): ?>
                        <tr>
                            <td><?php echo $registration['name']; ?></td>
                            <td><?php echo $registration['dob']; ?></td>
                            <td><?php echo $registration['gender']; ?></td>
                            <td><?php echo $registration['address']; ?></td>
                            <td><?php echo $registration['father_name']; ?></td>
                            <td><?php echo $registration['mother_name']; ?></td>
                            <td><?php echo $registration['register_type']; ?></td>
                            <td><?php echo $registration['place_of_birth']; ?></td>
                            <td><?php echo $registration['cause_of_death']; ?></td>
                            <td><?php echo ($registration['status'] == 1) ? 'Approved' : 'In Progress'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No registrations found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
