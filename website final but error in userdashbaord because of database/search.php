<?php
include "db_connection.php";
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["search"])) {
    $search = $_GET["search"];

    // Query the database to search for matching records
    $sql = "SELECT * FROM reg WHERE name LIKE ? OR address LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchParam = "%$search%";
    $stmt->bind_param("ss", $searchParam, $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();

    $searchResults = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="searchstyle.css">
</head>

<body>
    <div class="container">
        <h2>Search Results</h2>
        <div class="search-results">
            <?php if (isset($searchResults) && !empty($searchResults)) { ?>
                <table class="search-results-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Address</th>
                            <!-- Add other columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($searchResults as $data) { ?>
                            <tr>
                                <td><?php echo $data['ID']; ?></td>
                                <td><?php echo $data['name']; ?></td>
                                <td><?php echo $data['dob']; ?></td>
                                <td><?php echo $data['address']; ?></td>
                                <!-- Add other columns as needed -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>No results found.</p>
            <?php } ?>
        </div>
    </div>
</body>

</html>
