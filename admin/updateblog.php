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

// Check if blog ID is provided for editing
if (isset($_GET['id'])) {
    $postId = (int)$_GET['id']; // Get the blog post ID from the query parameter

    // Fetch the blog post data from the database
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        // Redirect back if the post is not found
        $_SESSION['message'] = "Post not found!";
        header("Location: dashboard.php");
        exit();
    }
} else {
    // Redirect if no ID is provided
    header("Location: dashboard.php");
    exit();
}

// Handle form submission for updating the blog post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title'], $_POST['description'], $_POST['author_name'], $_POST['category_id'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $authorname = $_POST['author_name'];
        $category_id = (int)$_POST['category_id'];

        // Image handling
        $imageFilePath = $post['image']; // Use existing image by default
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];
            $uploadDir = "../uploads/";
            $imageFilePath = $uploadDir . time() . '_' . basename($imageName); // Unique file name to avoid conflicts

            // Move the uploaded file
            if (!move_uploaded_file($imageTmpPath, $imageFilePath)) {
                $_SESSION['message'] = "Image upload failed: Could not move file.";
                header("Location: updateblog.php?id=" . $postId);
                exit();
            }
        }

        try {
            // Update the blog post in the database
            $stmt = $conn->prepare("UPDATE posts SET title = :title, description = :description, author_name = :authorname, category_id = :category_id, image = :image WHERE id = :id");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':authorname', $authorname);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->bindParam(':image', $imageFilePath);
            $stmt->bindParam(':id', $postId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Blog updated successfully!";
                header("Location: all-blogs.php");
                exit();
            } else {
                $_SESSION['message'] = "Failed to update blog.";
                header("Location: updateblog.php.php?id=" . $postId);
                exit();
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Edit Blog</title>

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

<div class="back_db">
    <a href="dashboard.php">Back to Dashboard</a>
</div>
<div class="form-container">
    <h2>Edit Blog Post</h2>
    <form action="updateblog.php?id=<?php echo $postId; ?>" method="POST" enctype="multipart/form-data">
        <label for="title">Blog Title</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

        <label for="category">Category</label>
        <select id="category" name="category_id" required>
            <?php
            // Fetch categories for the select dropdown
            $categories = $conn->prepare("SELECT * FROM categories");
            $categories->execute();
            $categoriesList = $categories->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categoriesList as $category) {
                $selected = $category['id'] == $post['category_id'] ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($category['id']) . '" ' . $selected . '>'
                    . htmlspecialchars($category['name']) . '</option>';
            }
            ?>
        </select>

        <label for="description">Blog Description</label>
        <textarea id="description" name="description" rows="6" required><?php echo htmlspecialchars($post['description']); ?></textarea>

        <label for="author">Author Name</label>
        <input type="text" id="author" name="author_name" value="<?php echo htmlspecialchars($post['author_name']); ?>" required>

        <label for="image">Blog Image</label>
        <input type="file" id="image" name="image">
        <?php if (!empty($post['image'])): ?>
            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Blog Image" width="100">
        <?php endif; ?>

        <input type="submit" class="submit-btn" value="Update Blog">
    </form>
</div>

</body>
</html>