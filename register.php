<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
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

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    // Check if passwords match
    if ($password !== $confirmpassword) {
        $error = "Passwords do not match.";
    } else {
        try {
            // Hash the password before storing
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL statement to insert the admin record
            $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            
            // Execute the statement and check if the registration was successful
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        } catch (PDOException $e) {
            // Catch and display any error messages
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<?php if (isset($error)): ?>
    <div class="error" style="color: red; text-align: center;"><?php echo $error; ?></div>
<?php endif; ?>

    <div class="login-container">
        <a href="index.php">Back to Home</a>
        <h1>Admin Registration</h1>
        <form method="post" action="register.php">
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
                    <td>Confirm Password</td>
                    <td><input type="password" name="confirmpassword" placeholder="Enter Password again" required></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" name="register" value="Register"></td>
                </tr>
            </table>
        </form>
        <!-- Corrected login button link -->
        <a href="login.php" class="register-btn">Login</a>
    </div>

</body>
</html>
