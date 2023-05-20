-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 20 2023 г., 06:59
-- Версия сервера: 10.8.4-MariaDB-log
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `naruto-shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint(24) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'Комплектующие ПК'),
(2, 'Бытовая техника'),
(3, 'Автомобили'),
(4, 'Одежда'),
(5, 'Хобби'),
(6, 'Спортивное снаряжение'),
(7, 'Для музыкантов');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` bigint(24) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(24) DEFAULT NULL,
  `price` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(24) DEFAULT NULL,
  `public` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `category_id`, `price`, `image`, `user_id`, `public`) VALUES
(1, 'Видеокарта GTX 1060 6 gb', 'Рабочая. Была куплена в 2017-м. До сих пор актуальна. Почищена от пыли и так же поменял термопасту, хотя температуры не были высокими. Карта полностью исправна.', 1, '10000', 'storage/images/1681123058_06G-P4-6267-KR_LG_1.png', 2, 1),
(2, 'Мерч Nirvana', 'Размер L. Надевалась пару раз', 4, '1000', 'storage/images/1681130745_main_9lgkgofc-1553691856-500x500.jpg', 2, 1),
(3, 'Акустическая гитара Yamaha FS830', 'Шестиструнная акустическая гитара в малом корпусе формы Concert. Верхняя дека из массива ели. Нижняя дека, обечайка, накладка на гриф и бридж из палисандра. Гриф из ньятона. Длина мензуры 25 дюймов, радиус накладки 15.75 дюймов. 20 ладов с инкрустацией, кремовая окантовка и глянцевое покрытие корпуса, матовый гриф. Хромированные литые колки.', 5, '30000', 'storage/images/1681130897_yamaha_fs830_6747593080-1.jpg', 3, 1),
(4, 'Робот-пылесос PVCR 4000', 'Поддерживает wi fi, можно управлять с телефона, сам строит карту квартиры, настраивается', 2, '25000', 'storage/images/1681131000_7.jpg', 3, 1),
(5, 'Коньки EDEA Motivo', 'Фигурные, размер 26', 6, '17000', 'storage/images/1681132130_B9575_Edea_Motivo.jpg', 3, 1),
(6, 'Картина скейтера АВАНГАРД', 'Картина, созданная душой, заряжена на успехи', 5, '1000000', 'storage/images/1681202915_replication (1).png', 1, 1),
(14, 'Nike Air Force', 'Кроссовки новые, не подошли по размеры. Размер 42', 4, '6500', 'storage/images/1684499083_dcii7oiqoiamtdggpy8k334i3nmuh01j.jpg', 4, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(24) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `login`, `password`) VALUES
(1, 'Николай', 'niko@mail.com', '889223569636', 'Niko_Lay1337', '$2y$10$wz.VjdqEKjAwNOdt51RWvO2kaV7zfUalmTe7ER6Hc3pxwcodBRABu'),
(2, 'Хината', 'hinata@mail.com', '89006002562', 'LuvNaruto', '$2y$10$g.YCcZyzu2OXJZsCJy2HCuuZCGSiPkk9Wx9.RWtyYt0bPJ3KR3mBm'),
(3, 'Иван', 'ivan222@mail.com', '86541236363', 'Ivan_IV', '$2y$10$h/MFEJHIbAJ0KDtjZZ1Fu.K9p7tDt2Jpq6/7ysZU6WaFCGBMFbL4a'),
(4, 'Арсений', 'ar@mail.com', '45168465', 'arseniy_90', '$2y$10$1Fm6nfZR2DoCzrtjvfbSPealvO7I2tsjfnK0dCha2dKIqI5QfVIBi');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
