<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>blogs List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        header, footer {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .back-button {
            position: absolute;
            top: 15px;
            left: 15px;
        }

        .back-button a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        button {
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            border: none;
        }

        .green {
            background-color: #4CAF50;
            color: white;
        }

        .red {
            background-color: #f44336;
            color: white;
        }

        footer {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php
// Include your database connection
require_once("../config.php");

if (isset($_POST['delete'])) {
    $id = $_POST['delete'];

    $delete = $conn->prepare("DELETE FROM posts WHERE id = :id");
    $delete->bindParam(":id", $id);

    if ($delete->execute()) {
        echo "Record deleted successfully.";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Unable to delete the record.";
    }
}

// edit record 
if (isset($_POST['edit'])) {
    $id = $_POST['edit'];

    header("Location: updateblog.php?id=$id");
    exit();
}

try {
    $postsQuery = $conn->prepare("
        SELECT posts.*, categories.name AS category_name 
        FROM posts 
        LEFT JOIN categories ON posts.category_id = categories.id
    ");
    
    $postsQuery->execute();
    $posts = $postsQuery->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>blogs List</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>

<header>
    <div class="container">
        <h2>BLogging System</h2>
    </div>
</header>

<div class="back-button">
    <a href="dashboard.php">Back to Dashboard</a>
</div>

<div class="container">
    <h1>Blogs List</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Author Name</th>
                <th>Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($posts as $post) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($post['id']); ?></td> <!-- Post ID -->
                    <td><?php echo htmlspecialchars($post['title']); ?></td> <!-- Post Title -->
                    <td><?php echo htmlspecialchars($post['description']); ?></td> <!-- Post Description -->
                    <td><?php echo htmlspecialchars($post['author_name']); ?></td> <!-- Author Name -->
                    <td><?php echo htmlspecialchars($post['category_name']); ?></td>
                    <td>
                        <?php if (!empty($post['image'])): ?>
                         <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" width="100">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td> 
                    <td>
                        <form method="post" action="" style="display: inline-block;">
                            <input type="hidden" name="edit" value="<?php echo $post['id']; ?>">
                            <button type="submit" class="green" onclick="return confirm('Are you sure you want to edit this record?')">Edit</button>
                        </form>
                        <form method="post" action="" style="display: inline-block;">
                            <input type="hidden" name="delete" value="<?php echo $post['id']; ?>">
                            <button type="submit" class="red" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<footer>
    <div class="container">
        <p>&copy; 2024 Student Management System. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
