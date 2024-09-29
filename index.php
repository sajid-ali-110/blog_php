<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blogs</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }
        .container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  width: 940px;
  margin: auto;
}
.card {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  width: 300px;
}
.card-header img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}
.card-body {
  display: flex;
  flex-direction: column;
  align-items: start;
  padding: 20px;
  min-height: 250px;
}
.tag {
  background-color: #ccc;
  color: #fff;
  border-radius: 50px;
  font-size: 12px;
  margin: 0;
  padding: 2px 10px;
  text-transform: uppercase;
}
.tag-teal {
  background-color: #92d4e4;
}
.tag-purple {
  background-color: #3d1d94;
}
.tag-pink {
  background-color: #c62bcd;
}
.card-body h4 {
  margin: 10px 0;
}
.card-body p {
  font-size: 14px;
  margin: 0 0 40px 0;
  font-weight: 500;
  color: rgb(70, 68, 68);
}
.user {
  display: flex;
  margin-top: auto;
}
.user img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 10px;
  object-fit: cover;
}
.user-info h5 {
  margin: 0;
}
.user-info small {
  color: #888785;
}
@media (max-width: 940px) {
  .container {
    grid-template-columns: 1fr;
    justify-items: center;
  }
}

        .navbar {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
        }

        .navbar input[type="text"] {
            padding: 10px;
            border: none;
            border-radius: 4px;
            width: 200px;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-header img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
        }

        .tag {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            display: inline-block;
        }

        .user {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .user-info {
            margin-left: 10px;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 20px;
        }

        .login {
            position: fixed;
            top: 10px;
            right: 20px;
        }

        .login a {
            text-decoration: none;
            color: #000;
            font-size: 20px;
        }
    </style>
</head>
<body>

<?php 
require_once("config.php");

$postsQuery = $conn->prepare("
    SELECT posts.*, categories.name AS category_name 
    FROM posts 
    LEFT JOIN categories ON posts.category_id = categories.id
");

$postsQuery->execute();
$posts = $postsQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="navbar">
    <div>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
    </div>
    <div>
        <input type="text" placeholder="Search blogs...">
    </div>
    <div class="login">
        <a href="login.php">Login</a>
    </div>
</div>

<div class="container">
    <?php foreach ($posts as $post) { ?>
    <div class="card">
        <div class="card-header">
            <?php if (!empty($post['image'])): ?>
                <img src="./uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image">
            <?php else: ?>
                <p>No Image</p>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <span class="tag"><?php echo htmlspecialchars($post['category_name']); ?></span>
            <h4><?php echo htmlspecialchars($post['title']); ?></h4>
            <p><?php echo htmlspecialchars($post['description']); ?></p>
            <div class="user">
                <div class="user-info">
                    <h5><?php echo htmlspecialchars($post['author_name']); ?></h5>
                    <small>2h ago</small>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<footer>
    <p>&copy; 2024 Your Blog Name. All rights reserved.</p>
</footer>

</body>
</html>
