<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Profile</h1>
        <?php
        // Start the session
        session_start();

        // Check for login
        if (!isset($_SESSION["username"])) {
            // If not logged in, redirect the user to the login page
            echo '<p class="text-center">Please log in to view your profile.</p>';
            echo '<p class="text-center"><a href="login.php">Log In</a></p>';
        } else {
            // If logged in, retrieve user information from the database and display it
            $servername = 'localhost';
            $dbUsername = 'root';
            $dbPassword = '';
            $dbName = 'shop';

            $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

            if ($conn->connect_error) {
                die("Failed to connect to the database: " . $conn->connect_error);
            }

            $username = $_SESSION["username"];
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<p class="text-center">Welcome ' .  '</p>';
                echo '<p class="text-center">Name: ' . $row['username'] . '</p>';
                echo '<p class="text-center">Email: ' . $row['email'] . '</p>';
                // You can display more information here

                // Add a logout button
                echo '<p class="text-center"><a href="logout.php">Log Out</a></p>';
                // Add a button to return to the home page
                echo '<p class="text-center"><a href="Home.php">Back to Home</a></p>';
            } else {
                echo '<p class="text-center">User information not found.</p>';
            }

            // Close the database connection
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
