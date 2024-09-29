<?php
	
	$host = "localhost";
	$username = "root";
	$password = null;
	$database = "blog_db";

	$conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// echo "connection successfull";

  ?>