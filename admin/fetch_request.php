<?php
include 'conn.php'; // Adjust the path as needed

if (isset($_POST['id'])) {
    $reqNumber = $_POST['id'];

    // Your SQL query to fetch the request items based on req_number
    $sql = "SELECT r.req_number, r.item_id, i.item_name, r.requested_quantity
            FROM request_table r
            JOIN table_item i ON r.item_id = i.id
            WHERE r.req_number = :reqNumber";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':reqNumber', $reqNumber, PDO::PARAM_STR);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
        echo '<form id="editForm" action="update_item.php" method="post">';
        
        foreach ($rows as $row) {
            // Echo the HTML response for each item
            echo '<div class="form-group">
                    <label for="editItem">Item Requested:</label>
                    <input type="text" id="editItem" class="form-control" name="editItem[]" value="' . $row['item_name'] . '" readonly>
                  </div>';
            echo '<div class="form-group">
                    <label for="editQuantity">Requested Quantity:</label>
                    <input type="text" id="editQuantity" class="form-control" name="editQuantity[]" value="' . $row['requested_quantity'] . '">
                  </div>';
        }

        // Add a single submit button after all items
        echo '<button type="submit" class="btn btn-block btn-info btn-sm" id="editFormButton">
                <i class="fas fa-save"></i> Save Changes
              </button>';
              
        echo '</form>';
    } else {
        echo 'Record not found.';
        exit;
    }
} else {
    echo 'Invalid request.';
    exit;
}
?>
