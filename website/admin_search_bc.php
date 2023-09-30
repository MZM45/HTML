<?php
// Establish a database connection
$hostname = "localhost"; // Change to your database host
$username = "root";      // Change to your database username
$password = "";          // Change to your database password
$dbname   = "db1";       // Change to your database name

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appno = $_POST['appno'];

    // Search for the birth certificate by App No
    $query = "SELECT * FROM bc WHERE appno = :appno";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':appno', $appno);
    $stmt->execute();
    $bc_record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bc_record) {
        // Display the update form with the retrieved data
        include("update_bc_form.php");
    } else {
        echo "Birth certificate with App No $appno not found.";
    }
}
?>
