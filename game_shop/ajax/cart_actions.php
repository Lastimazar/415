<?php
include 'config.php';

header('Content-Type: application/json');

$action = isset($_POST['action']) ? $_POST['action'] : '';
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
$session_id = session_id();

$response = ['success' => false, 'message' => ''];

try {
    switch ($action) {
        case 'add':
            // Проверяем, есть ли уже товар в корзине
            $query = "SELECT * FROM cart WHERE product_id = :product_id AND session_id = :session_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':session_id', $session_id, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                // Увеличиваем количество
                $query = "UPDATE cart SET quantity = quantity + 1 WHERE product_id = :product_id AND session_id = :session_id";
            } else {
                // Добавляем новый товар
                $query = "INSERT INTO cart (product_id, quantity, session_id) VALUES (:product_id, 1, :session_id)";
            }
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':session_id', $session_id, PDO::PARAM_STR);
            $stmt->execute();
            
            $response['success'] = true;
            $response['message'] = 'Товар добавлен в корзину';
            break;
            
        case 'remove':
            $query = "DELETE FROM cart WHERE id = :id AND session_id = :session_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $cart_id, PDO::PARAM_INT);
            $stmt->bindParam(':session_id', $session_id, PDO::PARAM_STR);
            $stmt->execute();
            
            $response['success'] = true;
            $response['message'] = 'Товар удален из корзины';
            break;
            
        case 'update_quantity':
            if ($quantity > 0) {
                $query = "UPDATE cart SET quantity = :quantity WHERE id = :id AND session_id = :session_id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->bindParam(':id', $cart_id, PDO::PARAM_INT);
                $stmt->bindParam(':session_id', $session_id, PDO::PARAM_STR);
                $stmt->execute();
                
                $response['success'] = true;
                $response['message'] = 'Количество обновлено';
            } else {
                // Если количество 0, удаляем товар
                $query = "DELETE FROM cart WHERE id = :id AND session_id = :session_id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $cart_id, PDO::PARAM_INT);
                $stmt->bindParam(':session_id', $session_id, PDO::PARAM_STR);
                $stmt->execute();
                
                $response['success'] = true;
                $response['message'] = 'Товар удален из корзины';
            }
            break;
            
        default:
            $response['message'] = 'Неизвестное действие';
    }
} catch(PDOException $e) {
    $response['message'] = 'Ошибка базы данных: ' . $e->getMessage();
}

echo json_encode($response);
?>