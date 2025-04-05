<?php
include_once 'db.php';

function addTransaction($product_id, $transaction_type, $quantity) {
    $database = new Database();
    $db = $database->getConnection();

    $query = "INSERT INTO inventory_transactions (product_id, transaction_type, quantity) VALUES (:product_id, :transaction_type, :quantity)";
    $stmt = $db->prepare($query);

    // Bind parameters
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':transaction_type', $transaction_type);
    $stmt->bindParam(':quantity', $quantity);

    if ($stmt->execute()) {
        echo "Transaction added successfully!";
    } else {
        echo "Unable to add transaction.";
    }
}

function updateTransaction($id, $quantity) {
    $database = new Database();
    $db = $database->getConnection();

    $query = "UPDATE inventory_transactions SET quantity = :quantity WHERE id = :id";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Transaction updated successfully!";
    } else {
        echo "Unable to update transaction.";
    }
}

function deleteTransaction($id) {
    $database = new Database();
    $db = $database->getConnection();

    $query = "DELETE FROM inventory_transactions WHERE id = :id";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Transaction deleted successfully!";
    } else {
        echo "Unable to delete transaction.";
    }
}
?>
