<?php
include 'config.php';
include 'includes/header.php';

// Получаем ID товара из URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Запрос для получения информации о товаре
$query = "SELECT * FROM products WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo '<div class="container"><div class="alert alert-danger">Товар не найден</div></div>';
    include 'includes/footer.php';
    exit;
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <img src="assets/images/<?php echo $product['image_url']; ?>" class="img-fluid rounded product-image" alt="<?php echo $product['name']; ?>">
        </div>
        <div class="col-md-6">
            <h1><?php echo $product['name']; ?></h1>
            <div class="mb-3">
                <span class="badge badge-secondary"><?php echo $product['genre']; ?></span>
                <span class="badge badge-info ml-2"><?php echo $product['platform']; ?></span>
            </div>
            <h3 class="price"><?php echo $product['price']; ?> руб.</h3>
            <p class="lead"><?php echo $product['description']; ?></p>
            <div class="mb-3">
                <strong>Разработчик:</strong> <?php echo $product['developer']; ?><br>
                <strong>Дата выхода:</strong> <?php echo date('d.m.Y', strtotime($product['release_date'])); ?>
            </div>
            <button class="btn btn-success btn-lg add-to-cart" data-id="<?php echo $product['id']; ?>">Добавить в корзину</button>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>