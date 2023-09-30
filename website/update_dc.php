<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Establish a database connection (same code as in the previous scripts)
    // ...

    $appno = $_POST['appno'];
    $name = $_POST['name'];
    $date_of_death = $_POST['date_of_death'];
    $status = ($_POST['status'] === '1') ? 1 : 0;

    // Update the Death Certificate data in the database
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
        echo "Death Certificate (App No: $appno) updated successfully.";
    } else {
        echo "Error updating Death Certificate.";
    }
}
?>
