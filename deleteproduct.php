<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// SQL query to retrieve products from the database
$select_sql = "SELECT * FROM products";

$result = $conn->query($select_sql);

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // SQL query to delete the product
    $delete_sql = "DELETE FROM products WHERE id = $product_id";

    if ($conn->query($delete_sql) === true) {
        // Product deleted successfully
        echo '<div class="alert alert-success">Product deleted successfully.</div>';
        header("Location: deleteproduct.php");
        exit();
    } else {
        echo '<div class="alert alert-danger">Error deleting product: ' . $conn->error . '</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Delete Product</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Delete Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td><img src="' . $row["image_path"] . '" width="100" height="100"></td>';
                        echo '<td>' . $row["name"] . '</td>';
                        echo '<td>' . $row["price"] . '</td>';
                        echo '<td>' . $row["description"] . '</td>';
                        echo '<td><a href="deleteproduct.php?id=' . $row["id"] . '" class="btn btn-danger">Delete</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No products available at the moment.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
