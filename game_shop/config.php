<?php
// Настройки подключения к базе данных
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Стандартный пользователь Open Server
define('DB_PASS', ''); // Пароль по умолчанию в Open Server пустой
define('DB_NAME', 'game_shop');

// Устанавливаем соединение с базой данных
try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("set names utf8");
} catch(PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

?>