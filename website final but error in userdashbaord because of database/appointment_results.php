<?php
// Include your database connection code here
include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];

    // Query the database to fetch appointments by user_id
    $sql = "SELECT * FROM appoint WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Redirect back to the search page if user_id is not provided
    header("Location: search_appointment.html");
    exit;
}
?>
<style>
        /* Style the header */
        header {
            background-color: #333;
            padding: 10px;
            text-align: center; /* Center-align the content */
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav h1 {
            display: inline; /* Display the heading inline */
            margin: 0; /* Remove any default margin */
        }

        nav a {
            text-decoration: none;
            color: white;
            padding: 10px;
            transition: color 0.3s; /* Add a smooth color transition */
        }

        nav a:hover {
            background-color: #ff9900;
            color: black; /* Change the text color on hover */
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <h1><a href="index.html">Home</a></h1>
            </ul>
        </nav>
    </header>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Results</title>
    <link rel="stylesheet" href="appointmentresultstyles.css">
</head>
<body>
    <h1>Appointment Results for User ID: <?php echo $user_id; ?></h1>
    <table>
        <thead>
            <tr>

                <th>Date</th>
                <th>Purpose</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>

                    <td><?php echo $row["date"]; ?></td>
                    <td><?php echo $row["purpose"]; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
