<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Add Category</title>

    <style>
          .back_db{
            position: fixed;
            top: 0;
            margin-top: 20px;
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
    include('../config.php');
    $message = "";

    if (isset($_POST['name'])) {
        $category = $_POST['name'];

        $check = $conn->prepare(" SELECT * FROM categories WHERE name = :name");
        $check->bindParam(":name", $category);
        $check->execute();

        if ($check->rowCount()>0) {
            $message = $category . " alredy added in the category";
        } else{
             $addcat = $conn->prepare("INSERT INTO categories(name) VALUES(:name)");
        $addcat->bindValue(":name", $category);

        if ($addcat->execute()) {
            session_start();
            $_SESSION['message'] = "Category added successfully!";
            
            header("Location: add-category.php");
            exit();
        } else {
            $message = "Failed to add category!";
        }
        }
    }

    session_start();
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);  
    }
    ?>

    <?php if(!empty($message)): ?>
        <script>
            alert("<?php echo $message; ?>");
        </script>
    <?php endif; ?>

    <div class="back_db">
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
    <div class="form-container">
        <h2>Add a New Category</h2>
        <form action="add-category.php" method="POST">
            <label for="title"> Add Category</label>
            <input type="text" id="title" name="name" placeholder="Add Category" required>
            <input type="submit" class="submit-btn" value="Add Category">
        </form>
    </div>
</body>
</html>
