		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="stylesheet" type="text/css" href="../css/styles.css">
			<title>add-blog</title>

             <style>
          .back_db{
            position: fixed;
            top: 0;
            margin-top: 20px;
            left: 0;
            margin-left: 20px;
          }
        .back_db a{
            background-color: blue;
            padding: 10px;
            border-radius: 15px;
            text-decoration: none;
            color: #fff;
        }
    </style>
		</head>
		<body>
<?php
session_start();
include('../config.php');

// Display the message if it's set
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);  // Clear the message after displaying it
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title'], $_POST['description'], $_POST['author_name'], $_POST['category_id'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $authorname = $_POST['author_name'];
        $category_id = (int)$_POST['category_id'];

        // Image handling
        $imageFilePath = null;  // Default to null
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];
            $uploadDir = "../uploads/";
            $imageFilePath = $uploadDir . time() . '_' . basename($imageName); // Unique file name to avoid conflicts

            if (move_uploaded_file($imageTmpPath, $imageFilePath)) {
                // Image upload succeeded
            } else {
                $_SESSION['message'] = "Image upload failed: Could not move file.";
                header("Location: add-blog.php");
                exit();
            }
        }

        try {
            $addata = $conn->prepare("INSERT INTO posts (title, description, author_name, category_id, image) 
                VALUES (:title, :description, :authorname, :category_id, :image)");
            $addata->bindParam(':title', $title);
            $addata->bindParam(':description', $description);
            $addata->bindParam(':authorname', $authorname);
            $addata->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $addata->bindParam(':image', $imageFilePath);  // Bind the image path

            if ($addata->execute()) {
                $_SESSION['message'] = "Blog added successfully!";
                header("Location: add-blog.php");
                exit();  // Ensure the script stops after the redirect
            } else {
                $_SESSION['message'] = "Failed to add blog.";
                header("Location: add-blog.php");
                exit();  // Ensure the script stops after the redirect
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>

<!-- HTML part -->
<div class="back_db">
    <a href="dashboard.php">Back to Dashboard</a>
</div>
<div class="form-container">
    <h2>Create a New Blog Post</h2>
    <form action="add-blog.php" method="POST" enctype="multipart/form-data">
        <label for="title">Blog Title</label>
        <input type="text" id="title" name="title" placeholder="Enter blog title" required>

        <label for="category">Category</label>
        <select id="category" name="category_id" required>
            <?php
            // Fetch categories for the select dropdown
            $categories = $conn->prepare("SELECT * FROM categories");
            $categories->execute();
            $categoriesList = $categories->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categoriesList as $category) {
                echo '<option value="' . htmlspecialchars($category['id']) . '">'
                    . htmlspecialchars($category['name']) . '</option>';
            }
            ?>
        </select>

        <label for="description">Blog Description</label>
        <textarea id="description" name="description" rows="6" placeholder="Write your blog description" required></textarea>

        <label for="author">Author Name</label>
        <input type="text" id="author" name="author_name" placeholder="Enter author's name" required>

        <label for="image">Blog Image</label>
        <input type="file" id="image" name="image">

        <input type="submit" class="submit-btn" value="Add Blog">
    </form>
</div>
		</body>
		</html>