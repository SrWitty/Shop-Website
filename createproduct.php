<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "shop"; // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $name = $_POST["name"];
    $price = $_POST["price"];
    $image_path = '';
    $description = $_POST["description"];

    if (isset($_FILES['image'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = 'uploads/' . $image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
            // Image uploaded successfully
        } else {
            echo '<div class="alert alert-danger">Failed to upload the image.' . '</div>';
        }
    }

    $insert_sql = "INSERT INTO products (name, price, image_path, description) VALUES ('$name', $price, '$image_path', '$description')";

    if ($conn->query($insert_sql) === true) {
        echo '<div class="alert alert-success">Product added successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Error adding the product: ' . $conn->error . '</div>';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Add New Product</h1>
        <form action="createproduct.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="image">Product Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <div class="form-group">
                <label for="description">Product Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
