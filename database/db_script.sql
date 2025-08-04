CREATE DATABASE ticketing_system;

USE ticketing_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `no_of_seats` int(11) NOT NULL,
  `booking_date` datetime NOT NULL,
  `payment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Amount` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `thumbnail_url` varchar(500) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `category` varchar(50) NOT NULL DEFAULT 'music'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `events` (`id`, `title`, `location`, `event_date`, `thumbnail_url`, `featured`, `category`) VALUES
(15, 'Inception', 'Cineplex Colombo', '2025-08-19', 'https://image.tmdb.org/t/p/w500/edv5CZvWj09upOsy2Y6IwDhK8bt.jpg', 1, 'movie'),
(16, 'Interstellar', 'Majestic City Cinema', '2025-08-19', 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg', 1, 'music'),
(17, 'The Dark Knight', 'Savoy Cinema Wellawatta', '2025-08-20', 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg', 1, 'concert'),
(18, 'Tenet', 'Scope Cinemas Kandy', '2025-08-21', 'https://image.tmdb.org/t/p/w500/k68nPLbIST6NP96JmTxmZijEvCA.jpg', 1, 'music');

ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

-- Dummy Data

-- INSERT INTO payments (id, Amount) VALUES
-- (1, '195.43'),
-- (2, '168.44'),
-- (3, '314.85'),
-- (4, '94.69'),
-- (5, '191.77'),
-- (6, '494.97'),
-- (7, '68.58'),
-- (8, '391.91'),
-- (9, '331.14'),
-- (10, '474.46');

-- INSERT INTO bookings (id, user_id, event_id, no_of_seats, booking_date, payment_id) VALUES
-- (1, 1, 15, 1, '2025-07-29 16:41:11', 1),
-- (2, 1, 17, 1, '2025-07-27 16:41:11', 2),
-- (3, 1, 18, 3, '2025-07-30 16:41:11', 3),
-- (4, 4, 17, 4, '2025-07-29 16:41:11', 4),
-- (5, 3, 15, 1, '2025-08-01 16:41:11', 5),
-- (6, 3, 18, 3, '2025-07-31 16:41:11', 6),
-- (7, 1, 18, 4, '2025-07-28 16:41:11', 7),
-- (8, 2, 18, 4, '2025-07-28 16:41:11', 8),
-- (9, 2, 18, 5, '2025-08-01 16:41:11', 9),
-- (10, 2, 18, 4, '2025-07-30 16:41:11', 10);

-- INSERT INTO `events` (`title`, `location`, `event_date`, `category`, `thumbnail_url`, `featured`) VALUES
-- ('Rock Concert', 'Colombo Stadium', '2025-08-10', 'concert', 'https://picsum.photos/id/1011/400/300', 1),
-- ('Tech Expo', 'BMICH', '2025-08-15', 'exhibition', 'https://picsum.photos/id/1012/400/300', 0),
-- ('Football Finals', 'Kandy Sports Complex', '2025-08-12', 'sports', 'https://picsum.photos/id/1013/400/300', 1),
-- ('Food Carnival', 'Galle Face Green', '2025-08-18', 'festival', 'https://picsum.photos/id/1014/400/300', 0),
-- ('Jazz Night', 'Colombo Jazz Club', '2025-08-22', 'concert', 'https://picsum.photos/id/1015/400/300', 1);


-- CREATE TABLE `events` (
--   `id` int(11) NOT NULL,
--   `title` varchar(255) NOT NULL,
--   `location` varchar(255) NOT NULL,
--   `event_date` date NOT NULL,
--   `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
--   `thumbnail_url` varchar(500) DEFAULT NULL,
--   `featured` tinyint(1) DEFAULT 0,
--   `category` varchar(50) NOT NULL DEFAULT 'music'
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- UPDATE `events` SET `price` = 150.00 WHERE `id` = 1; -- Rock Concert
-- UPDATE `events` SET `price` = 50.00  WHERE `id` = 2; -- Tech Expo
-- UPDATE `events` SET `price` = 120.00 WHERE `id` = 3; -- Football Finals
-- UPDATE `events` SET `price` = 60.00  WHERE `id` = 4; -- Food Carnival
-- UPDATE `events` SET `price` = 95.00  WHERE `id` = 5; -- Jazz Night
