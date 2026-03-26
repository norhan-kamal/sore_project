<?php
include 'includes/header.php';
include 'data/products.php';

$id = $_GET['id'];

foreach($products as $p){
    if($p['id'] == $id){
        $product = $p;
    }
}
?>

<h2><?= $product['name'] ?></h2>
<img src="<?= $product['image'] ?>">
<p>Price: <?= $product['price'] ?> EGP</p>

<form method="post" action="cart.php">
    <input type="hidden" name="id" value="<?= $product['id'] ?>">
    <button name="add">Add to Cart</button>
</form>

<?php include 'includes/footer.php'; ?>