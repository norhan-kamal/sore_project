<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';

if(!isset($_GET['id']) || empty($_GET['id'])){
    echo "<p style='text-align:center;'>❌ Invalid product ID</p>";
    exit;
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$product){
    echo "<p style='text-align:center;'>❌ Product not found</p>";
    exit;
}
?>

<div class="product-detail" style="
    display:flex;
    flex-direction: column;
    align-items:center;
    padding:30px;
    background:#f9f9f9;
    border-radius:10px;
    max-width:700px;
    margin:40px auto;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
    font-family:Arial, sans-serif;
">
    <h1 style="font-size:2em; margin-bottom:20px; color:#333;">
        <?= htmlspecialchars($product['name']) ?> 🛒
    </h1>

    <img src="asset/images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:100%; max-width:400px; border-radius:10px; margin-bottom:20px;">

    <p style="font-size:1.2em; color:#555; margin-bottom:10px;">
        <strong>Price:</strong> <?= number_format($product['price'],2) ?> EGP 💰
    </p>

    <p style="font-size:1em; color:#666; line-height:1.6; margin-bottom:20px;">
        <strong>Description:</strong> <?= htmlspecialchars($product['description'] ?? 'No description available') ?>
    </p>

    <form method="POST" action="cart.php" style="margin-top:10px;">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <button type="submit" name="add" style="
            background:#ff5722; 
            color:white; 
            padding:12px 30px; 
            border:none; 
            border-radius:8px; 
            font-size:1.1em;
            cursor:pointer;
            transition:0.3s;
        " onmouseover="this.style.background='#e64a19'" onmouseout="this.style.background='#ff5722'">
            Add to Cart 🛒
        </button>
    </form>

    <a href="products.php" style="margin-top:20px; text-decoration:none; color:#4CAF50; font-weight:bold;">⬅ Back to Products</a>
</div>

<style>
@media (max-width: 600px){
    .product-detail { padding:20px; }
    .product-detail img { max-width:100%; }
    .product-detail button { width:100%; }
}
</style>

<?php include 'includes/footer.php'; ?>