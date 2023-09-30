<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Replace these variables with your database credentials
    $hostname = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "db1";

    try {
        $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $db_username, $db_password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM admin WHERE username = :username AND password = :password";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['username'] = $username;
            header('Location: admindashboard.php');
            exit;
        } else {
            $error_message = "Invalid username or password. Please try again.";
        }
    } catch (PDOException $e) {
        die("Database Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>admin Login</h1>
    </header>
    <main>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <?php if (isset($error_message)) : ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </form>
    </main>
</body>
</html>
