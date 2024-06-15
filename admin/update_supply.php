<?php
include 'conn.php'; // Include your database connection file
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editField']) && isset($_POST['editQuantity'])) {
    // Handle form submission to update data
    $id = $_POST['id'];
    $editedName = $_POST['editField'];
    $editedQuantity = $_POST['editQuantity'];

    // Update the record in the database
    $stmt = $conn->prepare("UPDATE table_item SET item_name = :editedName, item_quantity = :editedQuantity, added_date = NOW() WHERE id = :id");
    $stmt->bindParam(':editedName', $editedName, PDO::PARAM_STR);
    $stmt->bindParam(':editedQuantity', $editedQuantity, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirect to supply.php after updating record
        header('location: supply.php');
        exit();
    } else {
        echo 'Error updating record';
    }
}

?>
