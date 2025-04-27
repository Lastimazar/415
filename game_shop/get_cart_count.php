<?php
include 'config.php';

$session_id = session_id();
$query = "SELECT SUM(quantity) as total FROM cart WHERE session_id = :session_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':session_id', $session_id, PDO::PARAM_STR);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo $result['total'] ? $result['total'] : 0;
?>