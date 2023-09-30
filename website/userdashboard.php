<?php
session_start();

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['username'])) {
    header('Location: loginuser.html');
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userdashboard.css">
    <title>User Dashboard</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html">LogOut</a></li>

            </ul>
        </nav>
    </header>
    <h1>Welcome, <?php echo $username; ?></h1>
<p>Welcome to our Birth and Death Certificate Registry website! We understand the importance of having easy access to essential documents like birth and death certificates. Our user-friendly platform is designed to make the application process seamless and efficient. Whether you're here to apply for a birth certificate, a crucial document for identification and legal purposes, or a death certificate, an important record for various administrative and legal matters, we've got you covered. Our secure and straightforward forms allow you to submit your information with confidence, ensuring accuracy and reliability in the records we maintain. Rest assured, our dedicated team is committed to processing your applications promptly, so you can access these vital certificates whenever you need them. Thank you for choosing our services, and we look forward to assisting you in your document-related needs.</p>
<h1>Birth Certificate Application</h1>
        <form action="process_birth_certificate.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="place_of_birth">Place of Birth:</label>
                <input type="text" id="place_of_birth" name="place_of_birth" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" required>
            </div>
            <button type="submit">Submit Application</button>
        </form>

        <h1>Death Certificate Application</h1>
<form action="process_death_certificate.php" method="POST">
    <div class="form-group">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="date_of_death">Date of Death:</label>
        <input type="date" id="date_of_death" name="date_of_death" required>
    </div>
    <button type="submit">Submit Application</button>
</form>
<?php
// Assuming you have already established a database connection
// Replace with your database connection details
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "db1";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start a session if not already started


// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: loginuser.html');
    exit;
}

$username = $_SESSION['username'];

// Query to retrieve data from the 'dc' table
$sql_dc = "SELECT * FROM dc WHERE username = '$username'";
$result_dc = mysqli_query($conn, $sql_dc);

// Query to retrieve data from the 'bc' table
$sql_bc = "SELECT * FROM bc WHERE username = '$username'";
$result_bc = mysqli_query($conn, $sql_bc);

// Close the database connection (you can do this after displaying the data)
mysqli_close($conn);
?>
<h2>Birth Certificate Cases:</h2>
<ul>
    <?php
    while ($row_bc = mysqli_fetch_assoc($result_bc)) {
        echo "<li>Name: " . htmlspecialchars($row_bc['name']) . "</li>";

        // Check if 'place_of_birth' key exists before accessing it
        if (isset($row_bc['place_of_birth'])) {
            echo "<li>Place of Birth: " . htmlspecialchars($row_bc['place_of_birth']) . "</li>";
        } else {
            echo "<li>Place of Birth: Not specified</li>";
        }

        // Check if 'date_of_birth' key exists before accessing it
        if (isset($row_bc['date_of_birth'])) {
            echo "<li>Date of Birth: " . htmlspecialchars($row_bc['date_of_birth']) . "</li>";
        } else {
            echo "<li>Date of Birth: Not specified</li>";
        }

        echo "<li>App No: " . htmlspecialchars($row_bc['appno']) . "</li>";
        echo "<li>Status: " . ($row_bc['status'] ? 'Completed' : 'In Progress') . "</li>";
        echo "<hr>";
    }
    ?>
</ul>

   <h2>Death Certificate Cases:</h2>
   <ul>
       <?php
       while ($row_dc = mysqli_fetch_assoc($result_dc)) {
           echo "<li>Name: " . $row_dc['name'] . "</li>";
           echo "<li>Date of Death: " . $row_dc['date_of_death'] . "</li>";
           echo "<li>App No: " . $row_dc['appno'] . "</li>";
           echo "<li>Status: " . ($row_dc['status'] ? 'Completed' : 'In Progress') . "</li>";
           echo "<hr>";
       }
       ?>
   </ul>
</html>
