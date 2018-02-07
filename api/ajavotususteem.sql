SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `competitors` (
  `id` int(2) DEFAULT NULL,
  `name` varchar(18) DEFAULT NULL,
  `chipID` int(5) DEFAULT NULL,
  `entry_time` double DEFAULT NULL,
  `finish_time` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `competitors` (`id`, `name`, `chipID`, `entry_time`, `finish_time`) VALUES
(1, 'Matilde Moring', 71937, NULL, NULL),
(2, 'Fabian Kanner', 79809, NULL, NULL),
(3, 'Amiee Vela', 33430, NULL, NULL),
(4, 'Norris Rundle', 33370, NULL, NULL),
(5, 'Darrel Applewhite', 16502, NULL, NULL),
(6, 'Cortez Engstrom', 46609, NULL, NULL),
(7, 'Clayton Angeles', 73854, NULL, NULL),
(8, 'Alvina Cannon', 19024, NULL, NULL),
(9, 'Yaeko Tenaglia', 54212, NULL, NULL),
(10, 'Antone Wineinger', 69399, NULL, NULL),
(11, 'Harris Seeman', 76893, NULL, NULL),
(12, 'Odilia Yi', 23601, NULL, NULL),
(13, 'Brandy Quebedeaux', 58375, NULL, NULL),
(14, 'Hulda Ramer', 23300, NULL, NULL),
(15, 'Tesha Wallach', 80994, NULL, NULL),
(16, 'Ty Blakley', 27454, NULL, NULL),
(17, 'Trisha Espada', 23747, NULL, NULL),
(18, 'Henrietta Shulman', 17278, NULL, NULL),
(19, 'Pearle Lisi', 90438, NULL, NULL),
(20, 'Mozella Mucci', 43444, NULL, NULL),
(21, 'Maryalice Bilal', 68730, NULL, NULL),
(22, 'Chun Izzo', 38831, NULL, NULL),
(23, 'January Newhouse', 47824, NULL, NULL),
(24, 'Elvis Vega', 90825, NULL, NULL),
(25, 'Melva Mealy', 66733, NULL, NULL),
(26, 'Kenda Goewey', 47525, NULL, NULL),
(27, 'Gertude Das', 80697, NULL, NULL),
(28, 'Geoffrey Dinges', 31094, NULL, NULL),
(29, 'Loraine Ackley', 83303, NULL, NULL),
(30, 'Faustino Almodovar', 39732, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
