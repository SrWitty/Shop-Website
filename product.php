<!DOCTYPE html>
<html>
<head>
    <title>Product Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Product Details</h1>
        <div class="row justify-content-center"> <!-- Use 'justify-content-center' to center the content -->
            <?php
            // Check if a specific product ID is set
            if (isset($_GET['id'])) {
                // Connect to the database
                $servername = 'localhost';
                $username = 'root';
                $password = '';
                $dbname = 'shop';

                $conn = mysqli_connect($servername, $username, $password, $dbname);

                if (!$conn) {
                    die("Failed to connect to the database: " . mysqli_connect_error());
                }

                $product_id = $_GET['id'];

                // SQL query to retrieve product details
                $sql = "SELECT * FROM products WHERE id = $product_id";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
            ?>
                    <div class="col-md-4">
                        <div class="card mx-auto"> <!-- Use 'mx-auto' for centering -->
                            <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <p class="card-text">Price: <?php echo $row['price']; ?> SAR</p>
                                <p class="card-text">Description: <?php echo $row['description']; ?></p>
                            </div>
                        </div>
                    </div>
            <?php
                } else {
                    echo "Product not found.";
                }

                // Close the database connection
                mysqli_close($conn);
            } else {
                echo "Product ID not specified.";
            }
            ?>
        </div>
        <div class="text-center mt-3">
            <a href="Home.php" class="btn btn-primary">Back to Home Page</a>
        </div>
    </div>
</body>
</html>
