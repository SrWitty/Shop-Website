<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
      
    form {
        margin-top: 20px;
    }

    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type="submit"] {
        background-color: #007BFF;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

  
    header {
        background-color: #007BFF;
        padding: 10px 0;
    }

    nav ul {
        list-style: none;
        padding: 0;
        text-align: center;
    }

    nav ul li {
        display: inline;
        margin-right: 20px;
    }

    nav ul li a {
        color: #fff;
        text-decoration: none;
        font-weight: bold;
    }
    nav a {
        color: #fff;
    }
    


  
    .container {
        text-align: center;
        margin-top: 20px;
    }



    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar">
            <a class="navbar-brand" href="index.php">Home</a>
            <?php
            session_start();
            if (!isset($_SESSION["username"])) {
                echo '<a class="nav-link" href="login.php">Login</a>';
            } else {
                $username = $_SESSION["username"];
                echo '<a class="nav-link" href="profile.php">'.$username.'</a>';
            }
            ?>
            <form class="form-inline my-2 my-lg-0" action="search.php" method="get">
                <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search for a product" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav>
    </header>
    
    <div class="container mt-5">
        <div class="row">
            <?php
            // Database connection
            $servername = 'localhost';
            $username = 'root';
            $password = '';
            $dbname = 'shop';

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if (!$conn) {
                die("Database connection failed: " . mysqli_connect_error());
            }

            // Display products
            $sql = "SELECT * FROM products";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-md-4">';
                    echo '<div class="product-card">';
                    echo '<img src="' . $row['image_path'] . '" alt="' . $row['name'] . '" class="img-fluid">';
                    echo '<h2>' . $row['name'] . '</h2>';
                    echo '<p class="mb-3">Price: ' . $row['price'] . ' SAR</p>';
                    echo '<a href="product.php?id=' . $row['id'] . '" class="btn btn-primary">View Details</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No products available.";
            }

            // Close database connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
    <hr> 
</body>
</html>
