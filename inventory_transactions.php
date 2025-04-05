<?php
include('db.php'); // Include the database connection

$action = ''; // To track the current action

// Handle form submissions (Add, Update, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_transaction'])) {
        // Add transaction logic
        $product_id = $_POST['product_id'];
        $transaction_type = $_POST['transaction_type'];
        $quantity = $_POST['quantity'];

        // Insert the new transaction into the database
        $sql = "INSERT INTO inventory_transactions (product_id, transaction_type, quantity) 
                VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("isi", $product_id, $transaction_type, $quantity);
            if ($stmt->execute()) {
                $action = 'add_success';
            } else {
                $action = 'error';
            }
            $stmt->close();
        }
    } elseif (isset($_POST['update_transaction'])) {
        // Update transaction logic
        $transaction_id = $_POST['id'];
        $new_quantity = $_POST['quantity'];

        // Update the transaction quantity
        $sql = "UPDATE inventory_transactions SET quantity = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ii", $new_quantity, $transaction_id);
            if ($stmt->execute()) {
                $action = 'update_success';
            } else {
                $action = 'error';
            }
            $stmt->close();
        }
    } elseif (isset($_POST['delete_transaction'])) {
        // Delete transaction logic
        $transaction_id = $_POST['id'];

        // Delete the transaction from the database
        $sql = "DELETE FROM inventory_transactions WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $transaction_id);
            if ($stmt->execute()) {
                $action = 'delete_success';
            } else {
                $action = 'error';
            }
            $stmt->close();
        }
    }
}

// Fetch all transactions from the database to display them
$sql = "SELECT * FROM inventory_transactions";
$transactions = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory Transactions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <center>
    <h2 class="mt-4">Manage Inventory Transactions</h2>
</center>
    <!-- Display success or error messages -->
    <?php if ($action === 'add_success'): ?>
        <div class="alert alert-success">Transaction added successfully!</div>
    <?php elseif ($action === 'update_success'): ?>
        <div class="alert alert-success">Transaction updated successfully!</div>
    <?php elseif ($action === 'delete_success'): ?>
        <div class="alert alert-success">Transaction deleted successfully!</div>
    <?php elseif ($action === 'error'): ?>
        <div class="alert alert-danger">There was an error processing your request.</div>
    <?php endif; ?>

    <!-- Back Button -->
    <a href="main.php" class="btn btn-secondary mb-3">Back to Main</a>

    <!-- Add Transaction Section -->
    <div class="card mb-4">
        <h3 class="card-header">Add Transaction</h3>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="product_id">Product ID:</label>
                    <input type="number" class="form-control" name="product_id" id="product_id" required>
                </div>
                <div class="form-group">
                    <label for="transaction_type">Transaction Type:</label>
                    <select class="form-control" name="transaction_type" id="transaction_type" required>
                        <option value="in">In</option>
                        <option value="out">Out</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" required>
                </div>
                <button type="submit" name="add_transaction" class="btn btn-primary">Add Transaction</button>
            </form>
        </div>
    </div>

    <!-- View All Transactions Section -->
    <div class="card">
        <h3 class="card-header">View All Transactions</h3>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Transaction Type</th>
                        <th>Quantity</th>
                        <th>Transaction Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($transactions->num_rows > 0): ?>
                        <?php while ($row = $transactions->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['product_id'] ?></td>
                                <td><?= $row['transaction_type'] ?></td>
                                <td><?= $row['quantity'] ?></td>
                                <td><?= $row['transaction_date'] ?></td>
                                <td>
                                    <!-- Update and Delete Buttons -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateModal" 
                                        data-id="<?= $row['id'] ?>" data-quantity="<?= $row['quantity'] ?>">Edit</button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" 
                                        data-id="<?= $row['id'] ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5">No transactions found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Updating Transaction -->
<div class="modal" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="update_id">
                    <div class="form-group">
                        <label for="update_quantity">New Quantity:</label>
                        <input type="number" class="form-control" name="quantity" id="update_quantity" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update_transaction" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Deleting Transaction -->
<div class="modal" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="delete_id">
                    <p>Are you sure you want to delete this transaction?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="delete_transaction" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Populate the modal with the transaction details for updating
    $('#updateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id');
        var quantity = button.data('quantity');
        var modal = $(this);
        modal.find('#update_id').val(id);
        modal.find('#update_quantity').val(quantity);
    });

    // Populate the modal with the transaction id for deleting
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id');
        var modal = $(this);
        modal.find('#delete_id').val(id);
    });
</script>

</body>
</html>
