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
    $name = $_POST['name'];
    $date_of_death = $_POST['date_of_death'];
    $status = ($_POST['status'] === '1') ? 1 : 0;

    // Update the death certificate data in the database
    $query_update = "UPDATE dc
                     SET name = :name,
                         date_of_death = :date_of_death,
                         status = :status
                     WHERE appno = :appno";
    $stmt_update = $dbh->prepare($query_update);
    $stmt_update->bindParam(':appno', $appno);
    $stmt_update->bindParam(':name', $name);
    $stmt_update->bindParam(':date_of_death', $date_of_death);
    $stmt_update->bindParam(':status', $status);

    if ($stmt_update->execute()) {
        echo "Death certificate (App No: $appno) updated successfully.";
    } else {
        echo "Error updating death certificate.";
    }
}

// Retrieve the Death Certificate record by App No
if (isset($_GET['appno'])) {
    $appno = $_GET['appno'];

    // Search for the Death Certificate by App No
    $query = "SELECT * FROM dc WHERE appno = :appno";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':appno', $appno);
    $stmt->execute();
    $dc_record = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dc_record) {
        die("Death certificate with App No $appno not found.");
    }
} else {
    die("App No not provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Update Death Certificate</title>
</head>
<body>
    <header>
        <h1>Update Death Certificate (App No: <?php echo htmlspecialchars($appno); ?>)</h1>
    </header>

    <form method="POST">
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($dc_record['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="date_of_death">Date of Death:</label>
            <input type="date" id="date_of_death" name="date_of_death" value="<?php echo htmlspecialchars($dc_record['date_of_death']); ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="1" <?php if ($dc_record['status'] == 1) echo "selected"; ?>>Completed</option>
                <option value="0" <?php if ($dc_record['status'] == 0) echo "selected"; ?>>In Progress</option>
            </select>
        </div>
        <input type="hidden" name="appno" value="<?php echo htmlspecialchars($appno); ?>">
        <button type="submit">Update</button>
    </form>
</body>
</html>
