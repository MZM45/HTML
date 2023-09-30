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

    <form method="POST" action="update_bc.php"> <!-- Point the form action to update_bc.php -->
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
