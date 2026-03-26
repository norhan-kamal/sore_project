<?php
$host = "localhost";
$dbname = "ecommerce";
$user = "root"; // عدلي حسب اليوزر بتاعك
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("Database connection failed: " . $e->getMessage());
}
?>