<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';

// تأكد أن السلة موجودة
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// جلب كل المنتجات من DB
$stmt = $pdo->query("SELECT * FROM products");
$allProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// مصفوفة سريعة حسب ID
$productsById = [];
foreach($allProducts as $p){
    $productsById[$p['id']] = $p;
}

/* ===== ADD ITEM ===== */
if(isset($_POST['add'])){
    $id = (int)$_POST['id'];
    if(isset($productsById[$id])){
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    }
}

/* ===== INCREASE ===== */
if(isset($_GET['inc']) && isset($_SESSION['cart'][$_GET['inc']])){
    $_SESSION['cart'][$_GET['inc']]++;
}

/* ===== DECREASE ===== */
if(isset($_GET['dec']) && isset($_SESSION['cart'][$_GET['dec']])){
    $id = $_GET['dec'];
    if($_SESSION['cart'][$id] > 1){
        $_SESSION['cart'][$id]--;
    } else {
        unset($_SESSION['cart'][$id]);
    }
}

/* ===== REMOVE ===== */
if(isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])){
    unset($_SESSION['cart'][$_GET['remove']]);
}
?>

<div class="cart-container">

    <h1>Your Shopping Cart 🛒</h1>

    <?php if(empty($_SESSION['cart'])): ?>
        <p>Your cart is empty 🛒</p>
        <a href="products.php" class="checkout-btn">Continue Shopping</a>
    <?php else: ?>
    
    <div class="cart-layout">

        <!-- LEFT: ITEMS -->
        <div class="cart-items">
            <?php 
            $total = 0;
            foreach($_SESSION['cart'] as $id => $qty):
                if(isset($productsById[$id])):
                    $p = $productsById[$id];
                    $price = (float)$p['price'];
                    $subtotal = $price * $qty;
                    $total += $subtotal;
            ?>
                <div class="cart-card">
                    <img src="asset/images/<?= $p['image'] ?>" alt="<?= htmlspecialchars($p['name']) ?>">

                    <div class="cart-info">
                        <h3><?= htmlspecialchars($p['name']) ?></h3>
                        <p><?= number_format($price, 2) ?> EGP</p>

                        <div class="qty-box">
                            <a href="cart.php?dec=<?= $id ?>">−</a>
                            <span><?= $qty ?></span>
                            <a href="cart.php?inc=<?= $id ?>">+</a>
                        </div>
                    </div>

                    <div class="cart-actions">
                        <p class="subtotal"><?= number_format($subtotal, 2) ?> EGP</p>
                        <a href="cart.php?remove=<?= $id ?>" class="remove">✖</a>
                    </div>
                </div>
            <?php 
                endif; 
            endforeach; 
            ?>
        </div>

        <!-- RIGHT: SUMMARY -->
        <div class="cart-summary">
            <h2>Order Summary</h2>
            <p>Total Items: <?= array_sum($_SESSION['cart']) ?></p>
            <h3>Total: <?= number_format($total, 2) ?> EGP</h3>
            <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
        </div>

    </div>
    <?php endif; ?>

</div>