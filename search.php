<?php
// Database connection
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'shop';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Failed to connect to the database: " . mysqli_connect_error());
}

if (isset($_GET['query'])) {
    $search_query = $_GET['query'];
    // SQL query to search for products using the name
    $sql = "SELECT * FROM products WHERE name LIKE '%$search_query%'";
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Search Results</h1>
        <?php
        if (isset($result) && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="row">';
                echo '<div class="col-md-6 offset-md-3">';
                echo '<div class="product-card text-center">';
                echo '<img src="' . $row['image_path'] . '" alt="' . $row['name'] . '" class="img-fluid">';
                echo '<h2>' . $row['name'] . '</h2>';
                echo '<p class="mb-3">Price: ' . $row['price'] . ' SAR</p>';
                echo '<a href="product.php?id=' . $row['id'] . '" class="btn btn-primary">View Details</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p class="text-center">No results found for: ' . $search_query . '</p>';
        }
        ?>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
