<?php
// Establish a database connection (same code as in the previous scripts)
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

    // Search for the death certificate by App No
    $query = "SELECT * FROM dc WHERE appno = :appno";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':appno', $appno);
    $stmt->execute();
    $dc_record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dc_record) {
        // Redirect to the update page with the App No as a query parameter
        header("Location: update_dc_form.php?appno=$appno");
        exit; // Ensure that no further code is executed
    } else {
        echo "Death certificate with App No $appno not found.";
    }
}
?>
