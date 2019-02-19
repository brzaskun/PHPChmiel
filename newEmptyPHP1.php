<?php
///R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'p6273_odomg');
$servername = "localhost";
$username = "p6273_odomg";
$password = "P3rsKy_K@tek1";
$database = "p6273_odomg";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>