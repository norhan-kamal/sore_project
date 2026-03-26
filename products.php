<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';

// جلب كل المنتجات
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="title">All Products</h1>
<div class="products-grid">

<?php if(!empty($products)): ?>
    <?php foreach($products as $product): ?>
        <div class="product">
            <img src="asset/images/<?= htmlspecialchars($product['image']) ?>" width="150">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p><?= number_format($product['price'],2) ?> EGP</p>

            <div class="product-actions">
                <!-- زر إضافة للسلة -->
                <form method="POST" action="cart.php" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <button type="submit" name="add">Add to Cart 🛒</button>
                </form>

                <!-- زر عرض التفاصيل -->
                <a href="details.php?id=<?= $product['id'] ?>" 
                   style="margin-left:10px; text-decoration:none; background:#4CAF50; color:white; padding:5px 10px; border-radius:5px;">
                   View Details 🔍
                </a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p style="text-align:center;">❌ No products found</p>
<?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>
