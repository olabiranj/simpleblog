<?php
    require('env.php');

    $servername = $_ENV['servername']; // your db_servername
    $username = $_ENV['username']; // your db_username
    $password = $_ENV['password']; // your db_password
    $db = $_ENV['db']; // db name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db); //this line will throw an error at first instance, just ignore.
    // Check connection
    if ($conn->connect_error) {
        // die("Connection failed: " . $conn->connect_error);
        // Create database if db does not exist
        $conn = new mysqli($servername, $username, $password);
        $sql = "CREATE DATABASE $db";
        if ($conn->query($sql) === TRUE) {
            echo "Database created successfully";
            // create table after creating a db
            $sql = "CREATE TABLE news (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(30) NOT NULL,
            body VARCHAR(255) NOT NULL,
            photo VARCHAR(255) NOT NULL,
            category VARCHAR(255) NOT NULL,
            created_by VARCHAR(50),
            reg_date TIMESTAMP
            )";
            $conn = mysqli_connect($servername, $username, $password, $db);
            if ($conn->query($sql) === TRUE) {
                echo "Table news created successfully";
            } else {
                echo "Error creating table: " . $conn->error;
            }
        } else {
            echo "Error creating database: " . $conn->error;
        }

    } else {
        // echo "Connected to the db";
    }


    #create a new folder for storing uploaded images if the folder does not exist.
    $storage = './uploads';
    if (!file_exists($storage)) {
        mkdir('./uploads');
    }
    
?>