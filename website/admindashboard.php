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

// Retrieve data from the 'bc' table
$query = "SELECT * FROM bc";
$stmt = $dbh->query($query);
$bc_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminstyles.css">
      <nav><li><a href="index.html">LogOut</a></li></nav>
    <title>Admin Page - Birth Certificates</title>
</head>
<body>
    <header>
        <h1>Birth Certificate Records (Admin View)</h1>
    </header>

    <table>
        <tr>
            <th>Username</th>
            <th>App No</th>
            <th>Status</th>
            <th>Date of Birth</th>
            <th>Place of Birth</th>
            <th>Name</th>
        </tr>
        <?php foreach ($bc_records as $record) : ?>
            <tr>
                <td><?php echo htmlspecialchars($record['username']); ?></td>
                <td><?php echo htmlspecialchars($record['appno']); ?></td>
                <td><?php echo $record['status'] ? 'Completed' : 'In Progress'; ?></td>
                <td><?php echo htmlspecialchars($record['dob']); ?></td>
                <td><?php echo htmlspecialchars($record['pob']); ?></td>
                <td><?php echo htmlspecialchars($record['name']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
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

// Retrieve data from the 'dc' table
$query_dc = "SELECT * FROM dc";
$stmt_dc = $dbh->query($query_dc);
$dc_records = $stmt_dc->fetchAll(PDO::FETCH_ASSOC);
?>
<header>
       <h1>Death Certificate Records (Admin View)</h1>
   </header>

   <table>
       <tr>
           <th>Username</th>
           <th>App No</th>
           <th>Status</th>
           <th>Date of Death</th>
           <th>Name</th>
       </tr>
       <?php foreach ($dc_records as $record_dc) : ?>
           <tr>
               <td><?php echo htmlspecialchars($record_dc['username']); ?></td>
               <td><?php echo htmlspecialchars($record_dc['appno']); ?></td>
               <td><?php echo $record_dc['status'] ? 'Completed' : 'In Progress'; ?></td>
               <td><?php echo htmlspecialchars($record_dc['date_of_death']); ?></td>
               <td><?php echo htmlspecialchars($record_dc['name']); ?></td>
           </tr>
       <?php endforeach; ?>
   </table>
   <h2>Search for Birth Certificate by App No:</h2>
<form method="POST" action="admin_search_bc.php">
    <div class="form-group">
        <label for="appno">App No:</label>
        <input type="text" id="appno" name="appno" required>
    </div>
    <button type="submit">Search</button>
</form>
<h2>Search for Death Certificate by App No</h2>
    </header>
    <main>
        <form method="POST" action="search_dc.php">
            <div class="form-group">
                <label for="appno">App No:</label>
                <input type="text" id="appno" name="appno" required>
            </div>
            <button type="submit">Search</button>
        </form>
        <h2>Search and Delete Death Certificate Record</h2>
            </header>

            <form method="POST" action="delete_dc.php">
                <div class="form-group">
                    <label for="appno">App No:</label>
                    <input type="text" id="appno" name="appno" required>
                </div>
                <button type="submit">Search and Delete</button>
            </form>

        <h2>Search and Delete Birth Certificate Record</h2>


    <form method="POST" action="delete_bc.php">
        <div class="form-group">
            <label for="appno">App No:</label>
            <input type="text" id="appno" name="appno" required>
        </div>
        <button type="submit">Search and Delete</button>
    </form>

</body>
</html>
