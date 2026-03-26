<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';

$success = false;
$total = 0;
$cartItems = [];

// تجهيز بيانات السلة
if(!empty($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $id => $qty){
        $stmt = $pdo->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $p = $stmt->fetch(PDO::FETCH_ASSOC);

        if($p){
            $subtotal = $p['price'] * $qty;
            $total += $subtotal;

            $cartItems[] = [
                'id' => $p['id'],
                'name' => $p['name'],
                'price' => $p['price'],
                'qty' => $qty,
                'subtotal' => $subtotal
            ];
        }
    }
}

// عند الضغط على Checkout
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(empty($cartItems)){
        die("Cart is empty!");
    }

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    $pdo->beginTransaction();

    try {
        // إدخال الطلب
        $stmt = $pdo->prepare("INSERT INTO orders (user_name, user_email, total) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $total]);

        $order_id = $pdo->lastInsertId();

        // إدخال المنتجات
        $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

        foreach($cartItems as $item){
            $stmtItem->execute([
                $order_id,
                $item['id'],
                $item['qty'],
                $item['price']
            ]);
        }

        $pdo->commit();

        // مسح السلة
        unset($_SESSION['cart']);
        $success = true;

    } catch(Exception $e){
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>

<div class="checkout-container">

    <h2>Checkout 🧾</h2>

    <?php if($success): ?>
        <div class="success">
            ✅ Order placed successfully! <br>
            🧾 Order ID: <?= $order_id ?> <br><br>
            <a href="index.php" class="back-home">🏠 Back to Home</a>
        </div>
    <?php else: ?>

    <!-- Order Summary -->
    <div class="summary-box">
        <h3>Order Summary</h3>

        <?php if(!empty($cartItems)): ?>
            <?php foreach($cartItems as $item): ?>
                <div class="summary-item">
                    <span><?= htmlspecialchars($item['name']) ?> x<?= $item['qty'] ?></span>
                    <span><?= number_format($item['subtotal'],2) ?> EGP</span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Your cart is empty</p>
        <?php endif; ?>

        <hr>

        <div class="summary-item total">
            <span>Total</span>
            <span><?= number_format($total,2) ?> EGP</span>
        </div>
    </div>

    <!-- Form -->
    <form method="POST">
        <input type="text" name="name" placeholder="👤 Your Name" required>
        <input type="email" name="email" placeholder="📧 Your Email" required>
        <button type="submit">Place Order</button>
    </form>

    <?php endif; ?>

</div>