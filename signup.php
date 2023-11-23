<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Create Account</h2>
        <form method="post" action="signup.php">
            <div class="form-group">
                <label for="name">Username:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "shop";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Failed to connect to the database: " . $conn->connect_error);
            }

            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            $check_query = "SELECT * FROM users WHERE username='$name' OR email='$email'";
            $check_result = $conn->query($check_query);

            if ($check_result->num_rows > 0) {
                echo '<div class="alert alert-danger" role="alert">Username or email already in use.</div>';
            } else {
                $insert_query = "INSERT INTO users (username, email, password) VALUES ('$name', '$email', '$password')";

                if ($conn->query($insert_query) === TRUE) {
                    echo '<div class="alert alert-success" role="alert">Account created successfully.</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">An error occurred while creating the account: ' . $conn->error . '</div>';
                }
            }

            $conn->close();
        }
        ?>

        <p class="mt-3">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
