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
    $date_of_birth = $_POST['date_of_birth'];
    $place_of_birth = $_POST['place_of_birth'];
    $status = ($_POST['status'] === '1') ? 1 : 0;

    // Update the birth certificate data in the database
    $query_update = "UPDATE bc
                     SET name = :name,
                         dob = :date_of_birth,
                         pob = :place_of_birth,
                         status = :status
                     WHERE appno = :appno";
    $stmt_update = $dbh->prepare($query_update);
    $stmt_update->bindParam(':appno', $appno);
    $stmt_update->bindParam(':name', $name);
    $stmt_update->bindParam(':date_of_birth', $date_of_birth);
    $stmt_update->bindParam(':place_of_birth', $place_of_birth);
    $stmt_update->bindParam(':status', $status);

    if ($stmt_update->execute()) {
        echo "Birth certificate (App No: $appno) updated successfully.";
    } else {
        echo "Error updating birth certificate.";
    }
}

// Retrieve the Birth Certificate record by App No
if (isset($_GET['appno'])) {
    $appno = $_GET['appno'];

    // Search for the Birth Certificate by App No
    $query = "SELECT * FROM bc WHERE appno = :appno";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':appno', $appno);
    $stmt->execute();
    $bc_record = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$bc_record) {
        die("Birth certificate with App No $appno not found.");
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
    <title>Update Birth Certificate</title>
</head>
<body>
    <header>
        <h1>Update Birth Certificate (App No: <?php echo htmlspecialchars($appno); ?>)</h1>
    </header>

    <form method="POST">
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($bc_record['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($bc_record['dob']); ?>" required>
        </div>
        <div class="form-group">
            <label for="place_of_birth">Place of Birth:</label>
            <input type="text" id="place_of_birth" name="place_of_birth" value="<?php echo htmlspecialchars($bc_record['pob']); ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="1" <?php if ($bc_record['status'] == 1) echo "selected"; ?>>Completed</option>
                <option value="0" <?php if ($bc_record['status'] == 0) echo "selected"; ?>>In Progress</option>
            </select>
        </div>
        <input type="hidden" name="appno" value="<?php echo htmlspecialchars($appno); ?>">
        <button type="submit">Update</button>
    </form>
</body>
</html>
