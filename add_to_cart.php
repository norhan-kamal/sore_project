<?php
session_start();
include 'includes/db.php';

if(isset($_POST['add'])){
    $id = intval($_POST['id']);
    $qty = intval($_POST['qty'] ?? 1);

    // نتحقق إن المنتج موجود
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if($product){
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
        echo "Product added to cart!";
    } else {
        echo "Product not found!";
    }
}
?>