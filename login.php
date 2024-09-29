<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            width: 400px;
            margin: 100px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #004080;
            margin-bottom: 30px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #004080;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0059b3;
        }

        .register-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #e91e63;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
            margin-top: 10px;
            text-decoration: none;
        }

        .register-btn:hover {
            background-color: #c2185b;
        }

        .login-container table {
            width: 100%;
        }

        td {
            padding: 10px;
            color: #333;
        }

    </style>
</head>
<body>
	<?php
session_start();
include("./config.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the statement to get the hashed password
    $result = $conn->prepare("SELECT * FROM admin WHERE username = :username");
    $result->bindParam(':username', $username);
    $result->execute();

    // Check if the user exists
    if ($result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $hashedPassword = $row['password']; // Get the hashed password from the database

        // Verify the entered password against the hashed password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['username'] = $username;
            header("location: admin/dashboard.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
}
?>

    <div class="login-container">
    	<a href="index.php">Back to Home</a>
        <h1>Admin Login</h1>
        <form method="post" action="login.php">
            <table>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" placeholder="Enter Username" required></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" placeholder="Enter Password" required></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" name="login" value="Login"></td>
                </tr>
            </table>
        </form>
        <a href="register.php" class="register-btn">Register</a>
    </div>

</body>
</html>
