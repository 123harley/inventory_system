<?php
include('db.php'); // Include your database connection file

// Handle form submissions (Add, Update, Delete)
$action = ''; // To track the current action

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        // Add new product logic
        $product_name = $_POST['product_name'];
        $sku = $_POST['sku'];
        $manufacturer = $_POST['manufacturer'];
        $price = $_POST['price'];
        $barcode = $_POST['barcode'];
        $expiry_date = $_POST['expiry_date'];
        $unit_of_measure = $_POST['unit_of_measure'];
        $quantity_in_stock = $_POST['quantity_in_stock'];
        $stock_threshold = $_POST['stock_threshold'];

        $sql = "INSERT INTO products (product_name, sku, manufacturer, price, barcode, expiry_date, unit_of_measure, quantity_in_stock, stock_threshold) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssssssis", $product_name, $sku, $manufacturer, $price, $barcode, $expiry_date, $unit_of_measure, $quantity_in_stock, $stock_threshold);
            if ($stmt->execute()) {
                $action = 'add_success';
            } else {
                $action = 'error';
            }
            $stmt->close();
        }
    } elseif (isset($_POST['update_product'])) {
        // Update product logic
        $product_id = $_POST['id'];
        $quantity_in_stock = $_POST['quantity_in_stock'];

        $sql = "UPDATE products SET quantity_in_stock = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ii", $quantity_in_stock, $product_id);
            if ($stmt->execute()) {
                $action = 'update_success';
            } else {
                $action = 'error';
            }
            $stmt->close();
        }
    } elseif (isset($_POST['delete_product'])) {
        // Delete product logic
        $product_id = $_POST['id'];

        $sql = "DELETE FROM products WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $product_id);
            if ($stmt->execute()) {
                $action = 'delete_success';
            } else {
                $action = 'error';
            }
            $stmt->close();
        }
    }
}

// Fetch all products from the database
$sql = "SELECT * FROM products";
$products = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2 class="mt-4">Manage Products</h2>
    <a href="main.php"><button class="back-button">Back</button></a>
    <br>
    <br>
    <!-- Display success or error messages -->
    <?php if ($action === 'add_success'): ?>
        <div class="alert alert-success">Product added successfully!</div>
    <?php elseif ($action === 'update_success'): ?>
        <div class="alert alert-success">Product updated successfully!</div>
    <?php elseif ($action === 'delete_success'): ?>
        <div class="alert alert-success">Product deleted successfully!</div>
    <?php elseif ($action === 'error'): ?>
        <div class="alert alert-danger">There was an error processing your request.</div>
    <?php endif; ?>

    <!-- Add Product Section -->
    <div class="card mb-4">
        <h3 class="card-header">Add Product</h3>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="product_name">Product Name:</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" required>
                </div>
                <div class="form-group">
                    <label for="sku">STOCK KEEPING UNIT:</label>
                    <input type="text" class="form-control" name="sku" id="sku" required>
                </div>
                <div class="form-group">
                    <label for="manufacturer">Manufacturer/Supplier:</label>
                    <input type="text" class="form-control" name="manufacturer" id="manufacturer" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" name="price" id="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="barcode">Barcode:</label>
                    <input type="text" class="form-control" name="barcode" id="barcode" required>
                </div>
                <div class="form-group">
                    <label for="expiry_date">Expiry Date:</label>
                    <input type="date" class="form-control" name="expiry_date" id="expiry_date">
                </div>
                <div class="form-group">
                    <label for="unit_of_measure">Unit of Measure:</label>
                    <input type="text" class="form-control" name="unit_of_measure" id="unit_of_measure" required>
                </div>
                <div class="form-group">
                    <label for="quantity_in_stock">Quantity in Stock:</label>
                    <input type="number" class="form-control" name="quantity_in_stock" id="quantity_in_stock" required>
                </div>
                <div class="form-group">
                    <label for="stock_threshold">Stock Threshold (for low stock alerts):</label>
                    <input type="number" class="form-control" name="stock_threshold" id="stock_threshold" required>
                </div>
                <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </div>

    <!-- View All Products Section -->
    <div class="card">
        <h3 class="card-header">View All Products</h3>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>STOCK KEEPING UNIT</th>
                        <th>Manufacturer</th>
                        <th>Price</th>
                        <th>Barcode</th>
                        <th>Expiry Date</th>
                        <th>Unit of Measure</th>
                        <th>Quantity in Stock</th>
                        <th>Stock Threshold</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($products->num_rows > 0): ?>
                        <?php while ($row = $products->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['product_name'] ?></td>
                                <td><?= $row['sku'] ?></td>
                                <td><?= $row['manufacturer'] ?></td>
                                <td><?= $row['price'] ?></td>
                                <td><?= $row['barcode'] ?></td>
                                <td><?= $row['expiry_date'] ?></td>
                                <td><?= $row['unit_of_measure'] ?></td>
                                <td><?= $row['quantity_in_stock'] ?></td>
                                <td><?= $row['stock_threshold'] ?></td>
                                <td>
                                    <!-- Update and Delete Buttons -->
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="delete_product" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateModal" 
                                        data-id="<?= $row['id'] ?>" data-quantity="<?= $row['quantity_in_stock'] ?>">Edit</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="10">No products found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Updating Product -->
<div class="modal" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="update_id">
                    <div class="form-group">
                        <label for="update_quantity_in_stock">New Quantity:</label>
                        <input type="number" class="form-control" name="quantity_in_stock" id="update_quantity_in_stock" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update_product" class="btn btn-primary">Update</button>
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
    // Populate the modal with the product details for updating
    $('#updateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id');
        var quantity = button.data('quantity');
        var modal = $(this);
        modal.find('#update_id').val(id);
        modal.find('#update_quantity_in_stock').val(quantity);
    });
</script>

</body>
</html>
