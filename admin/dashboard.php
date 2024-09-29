<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Admin Dashboard</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        body {
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background-color: #004080;
            color: white;
            padding: 15px;
            display: flex;
            width: 100%;
            justify-content: space-around;
            font-size: 24px;
            align-items: center;
        }

        .header a {
            text-decoration: none;
            color: #fff;
        }

        .header h2, p {
            color: #fff;
        }

        /* Main Content */
        .dashboard {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex: 1;
            text-align: center;
            padding: 40px;
        }

        .dashboard h2 {
            font-size: 2rem;
            color: #016a70;
            margin-bottom: 30px;
        }

        /* Tabs (Buttons) */
        .tabs {
            display: flex;
            gap: 20px;
        }

        .button {
            background-color: #016a70;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            font-size: 1.2rem;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #018c94;
        }

        /* Footer */
        footer {
            background-color: #016a70;
            color: white;
            width: 100%;

            text-align: center;
            padding: 20px 0;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <p>Home</p>
        <h2>Admin Management System</h2>
        <a href="../login.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="dashboard">
        <h2>Welcome to the Admin Dashboard</h2>
        <div class="tabs">
            <a href="add-category.php" class="button">Add Category</a>
            <a href="add-blog.php" class="button">Add Blog</a>
            <a href="all-blogs.php" class="button">All Blogs</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Admin Management System. All rights reserved.</p>
    </footer>
</body>
</html>
