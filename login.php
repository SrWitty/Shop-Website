<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007BFF;
            color: #fff;
            text-align: center;
        }

        .form-group {
            margin: 20px;
        }

        .btn-primary {
            width: 100%;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>Login</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="login.php">
                            <div class="form-group">
                                <label for="email_or_username">Email:</label>
                                <input type="email" class="form-control" id="email_or_username" name="email_or_username" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
                <?php
session_start();

if (isset($_SESSION["username"])) {
    // If the user is already logged in, redirect them to the appropriate page
    header("Location: Home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "shop";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $email = $_POST["email_or_username"];
    $password = $_POST["password"];

    // Check if the email and password exist in the database
    $check_query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows == 1) {
        $row = $check_result->fetch_assoc();
        
        // Login successful
        $_SESSION["username"] = $row["username"];
        $login_success = true; // Set variable to notify JavaScript of successful login
        header("Location: Home.php"); // Redirect the user to Home.php after successful login
        exit();
    } else {
        echo '<div class="alert alert-danger" role="alert">Incorrect email or password.</div>';
    }

    $conn->close();
}
?>

<p class="mt-3">Don't have an account? <a href="signup.php">Create an account</a></p>

            </div>
        </div>
    </div>
</body>
</html>
