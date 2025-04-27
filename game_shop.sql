-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 27 2025 г., 20:34
-- Версия сервера: 8.0.24
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `game_shop`
--
CREATE DATABASE IF NOT EXISTS `game_shop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `game_shop`;

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `developer` varchar(100) NOT NULL,
  `platform` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `genre`, `image_url`, `release_date`, `developer`, `platform`) VALUES
(1, 'Cyberpunk 2077', 'Приключенческая ролевая игра в открытом мире, действие которой происходит в Найт-Сити — мегаполисе будущего, где власть, роскошь и модификации тела ценятся выше всего.', '59.99', 'RPG', 'openserver\\domains\\game_shop\\assets\\images', '2020-12-10', 'CD Projekt Red', 'PC, PS4, PS5, Xbox'),
(2, 'The Witcher 3: Wild Hunt', 'Продолжение приключений Геральта из Ривии, ведьмака-охотника на чудовищ. На этот раз перед ним стоит личная задача — найти Цири, Дитя Предназначения.', '39.99', 'RPG', 'witcher3.jpg', '2015-05-19', 'CD Projekt Red', 'PC, PS4, Xbox'),
(3, 'Red Dead Redemption 2', 'Приключения банды Ван дер Линде на Диком Западе. История о чести и предательстве на фоне заката эпохи ковбоев.', '49.99', 'Action', 'reddead2.jpg', '2018-10-26', 'Rockstar Games', 'PC, PS4, Xbox'),
(4, 'Elden Ring', 'Фэнтезийная ролевая игра с открытым миром от создателей Dark Souls и Джорджа Р. Р. Мартина.', '59.99', 'RPG', 'eldenring.jpg', '2022-02-25', 'FromSoftware', 'PC, PS4, PS5, Xbox'),
(5, 'God of War', 'Кратос, бывший бог войны, пытается начать новую жизнь в царстве скандинавских богов и монстров.', '49.99', 'Action', 'godofwar.jpg', '2018-04-20', 'Santa Monica Studio', 'PS4');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
