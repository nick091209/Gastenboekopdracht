SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `berichten` (
  `id` int(11) NOT NULL,
  `naam` varchar(50) DEFAULT NULL,
  `bericht` text DEFAULT NULL,
  `datum` timestamp NOT NULL DEFAULT mktime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `berichten`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `berichten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

ALTER TABLE `berichten` ADD `photo` VARCHAR(255);

