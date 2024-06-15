<?php
include '../admin/conn.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:index.php');
}

// Check if REQUEST_METHOD is set in the $_SERVER array
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate your form data
    $item_name = isset($_POST['item_name']) ? $_POST['item_name'] : '';
    $item_quantity = isset($_POST['item_quantity']) ? $_POST['item_quantity'] : '';

    // Prepare SQL statement for insertion
    $stmt = $conn->prepare("INSERT INTO table_item (item_name, item_quantity) VALUES (?, ?)");
    $stmt->bindParam(1, $item_name, PDO::PARAM_STR);
    $stmt->bindParam(2, $item_quantity, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Item inserted successfully, redirect to supply.php
        header('location: supply.php');
        exit(); // Make sure to exit after the redirect
    } else {
        echo 'Error adding record';
    }
} else {
    echo 'Invalid request method'; // You can customize this error message as needed
}
?>
