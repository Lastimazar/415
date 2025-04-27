<?php
include 'config.php';
include 'includes/header.php';

// Получаем ID сессии
$session_id = session_id();
?>

<div class="container my-5">
    <h1 class="mb-4">Ваша корзина</h1>
    
    <?php
    // Проверяем, есть ли товары в корзине
    $query = "SELECT c.*, p.name, p.price, p.image_url 
              FROM cart c 
              JOIN products p ON c.product_id = p.id 
              WHERE c.session_id = :session_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':session_id', $session_id, PDO::PARAM_STR);
    $stmt->execute();
    
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($cart_items)) {
        echo '<div class="alert alert-info">Ваша корзина пуста</div>';
    } else {
        $total = 0;
    ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Товар</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item) { 
                    $sum = $item['price'] * $item['quantity'];
                    $total += $sum;
                ?>
                <tr>
                    <td><img src="assets/images/<?php echo $item['image_url']; ?>" width="50" alt="<?php echo $item['name']; ?>"></td>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['price']; ?> руб.</td>
                    <td>
                        <div class="input-group" style="width: 120px;">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary update-quantity" type="button" data-id="<?php echo $item['id']; ?>" data-action="decrease">-</button>
                            </div>
                            <input type="text" class="form-control text-center quantity-input" value="<?php echo $item['quantity']; ?>" data-id="<?php echo $item['id']; ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary update-quantity" type="button" data-id="<?php echo $item['id']; ?>" data-action="increase">+</button>
                            </div>
                        </div>
                    </td>
                    <td><?php echo $sum; ?> руб.</td>
                    <td>
                        <button class="btn btn-danger remove-from-cart" data-id="<?php echo $item['id']; ?>">Удалить</button>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="4" class="text-right"><strong>Итого:</strong></td>
                    <td colspan="2"><strong><?php echo $total; ?> руб.</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="text-right">
        <a href="checkout.php" class="btn btn-primary btn-lg">Оформить заказ</a>
    </div>
    <?php } ?>
</div>

<?php
include 'includes/footer.php';
?>