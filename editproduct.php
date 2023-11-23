<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$product_id = 0;
$product_name = '';
$product_price = '';
$product_image_path = '';
$product_description = '';

// SQL query to retrieve products
$select_products_sql = "SELECT * FROM products";
$products_result = $conn->query($select_products_sql);

if (isset($_GET['id'])) {
    $product_id = $conn->real_escape_string($_GET['id']);
    $select_product_sql = "SELECT * FROM products WHERE id='$product_id'";
    $result = $conn->query($select_product_sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_name = $row["name"];
        $product_price = $row["price"];
        $product_image_path = $row["image_path"];
        $product_description = $row["description"];
    } else {
        echo "Product not found.";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_product_name = $conn->real_escape_string($_POST["name"]);
        $new_product_price = $conn->real_escape_string($_POST["price"]);
        $new_product_description = $conn->real_escape_string($_POST["description"]);

        // Update SQL query to update the product
        $update_sql = "UPDATE products SET name='$new_product_name', price='$new_product_price', description='$new_product_description' WHERE id='$product_id'";

        if ($conn->query($update_sql) === true) {
            echo '<div class="alert alert-success">Product updated successfully.</div>';

            if ($_FILES['new_image']['name']) {
                $new_image_path = "uploads/" . basename($_FILES["new_image"]["name"]);

                if (file_exists($product_image_path)) {
                    unlink($product_image_path);
                }

                if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $new_image_path)) {
                    $update_image_sql = "UPDATE products SET image_path='$new_image_path' WHERE id='$product_id'";
                    if ($conn->query($update_image_sql) !== true) {
                        echo '<div class="alert alert-danger">Error updating image: ' . $conn->error . '</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger">Error uploading new image.</div>';
                }
            }
        } else {
            echo '<div class="alert alert-danger">Error updating product: ' . $conn->error . '</div>';
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_image'])) {
        if (file_exists($product_image_path)) {
            unlink($product_image_path);
        }

        $delete_sql = "DELETE FROM products WHERE id = $product_id";

        if ($conn->query($delete_sql) === true) {
            echo '<div class="alert alert-success">Product deleted successfully.</div>';
            header("Location: editproduct.php");
            exit();
        } else {
            echo '<div class="alert alert-danger">Error deleting product: ' . $conn->error . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Product</h1>
        <form action="editproduct.php?id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $product_price; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Product Description:</label>
                <textarea class="form-control" id="description" name="description"><?php echo $product_description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Product Image:</label>
                <img src="<?php echo $product_image_path; ?>" width="100" height="100">
            </div>
            <div class="form-group">
                <label for="new_image">Upload New Image:</label>
                <input type="file" class="form-control-file" id="new_image" name="new_image">
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
            <button type="submit" class="btn btn-danger" name="delete_image">Delete Image</button>
        </form>

        <h2>Available Products:</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($products_result->num_rows > 0) {
                    while ($product = $products_result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $product["name"] . '</td>';
                        echo '<td>' . $product["price"] . '</td>';
                        echo '<td><a href="editproduct.php?id=' . $product["id"] . '" class="btn btn-primary">Edit</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="3">No products available at the moment.</td></tr>';
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
