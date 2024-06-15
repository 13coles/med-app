<?php
include 'conn.php'; // Include your database connection file
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Check if the editItem and other fields are provided
    if (isset($_POST['editItem'], $_POST['editQuantity'])) {
        function updateRequestData($conn, $reqNumber, $item, $quantity)
        {
            try {
                // Example SQL statement for updating request_table
                $updateRequestSQL = "UPDATE request_table SET requested_quantity = :quantity WHERE req_number = :reqNumber AND item_id = :itemId";
                $stmtRequest = $conn->prepare($updateRequestSQL);
                $stmtRequest->bindParam(':reqNumber', $reqNumber, PDO::PARAM_STR);
                $stmtRequest->bindParam(':itemId', $item, PDO::PARAM_INT);
                $stmtRequest->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmtRequest->execute();

                // Example SQL statement for updating table_item
                // Adjust this query based on your actual table structure
                $updateItemSQL = "UPDATE table_item SET item_quantity = item_quantity - :quantity WHERE id = :itemId";
                $stmtItem = $conn->prepare($updateItemSQL);
                $stmtItem->bindParam(':itemId', $item, PDO::PARAM_INT);
                $stmtItem->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmtItem->execute();

                return true; // Update successful
            } catch (PDOException $e) {
                // Log or handle the exception
                return false; // Update failed
            }
        }

        $editItems = $_POST['editItem'];
        $editQuantities = $_POST['editQuantity'];

        // Loop through the submitted data and perform the update
        for ($i = 0; $i < count($editItems); $i++) {
            $editedItem = $editItems[$i];
            $editedQuantity = $editQuantities[$i];

            // Update the request and item data
            updateRequestData($conn, $id, $editedItem, $editedQuantity);
        }

        // Redirect or display a success message as needed
        header('Location: list_request.php');
        exit;
    }
}
?>
