-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 11:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uts_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE `adminlogin` (
  `admin_ID` int(11) NOT NULL,
  `admin_Name` varchar(55) NOT NULL,
  `admin_Email` varchar(55) NOT NULL,
  `admin_Password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`admin_ID`, `admin_Name`, `admin_Email`, `admin_Password`) VALUES
(1, 'admin1', 'admin@gmail.com', '$2a$12$EDLvcGy.3kAVQp6fLlGOB.x3WCQFwelljsXvc17S5P.D1gkBu7tL.');

-- --------------------------------------------------------

--
-- Table structure for table `cartitems`
--

CREATE TABLE `cartitems` (
  `cart_ID` int(11) NOT NULL,
  `user_ID` int(8) NOT NULL,
  `cart_Products` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cartitems`
--

INSERT INTO `cartitems` (`cart_ID`, `user_ID`, `cart_Products`) VALUES
(7, 24000008, '[]'),
(8, 1, '[]'),
(12, 12400003, '[]'),
(13, 12400045, '[]'),
(14, 24000043, '[]');

-- --------------------------------------------------------

--
-- Table structure for table `shopdata`
--

CREATE TABLE `shopdata` (
  `shop_ID` int(8) NOT NULL,
  `shop_Name` varchar(100) NOT NULL,
  `shop_Phone` bigint(11) NOT NULL,
  `shop_Location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopdata`
--

INSERT INTO `shopdata` (`shop_ID`, `shop_Name`, `shop_Phone`, `shop_Location`) VALUES
(12400003, 'Shop', 9123456789, 'New Market'),
(12400037, 'Food Shop', 9123456799, 'CLSU Marketting'),
(12400038, 'Nanny Store', 9878765434, 'CLSU'),
(12400039, 'On pizza', 3214567854, 'CLSU'),
(12400040, 'Topsilog', 2342567591, 'CLSU'),
(12400041, 'Pares', 3215984736, 'CLSU'),
(12400042, 'Minute Burger', 4587332791, 'CLSU'),
(12400043, 'School Supplies', 6547712977, 'CLSU'),
(12400044, 'Tuhog-Tuhog', 3214563218, 'CLSU'),
(12400045, 'Bigbrew', 1234567891, 'CLSU'),
(12400046, '7/11', 3214567854, 'CLSU');

-- --------------------------------------------------------

--
-- Table structure for table `shoplogin`
--

CREATE TABLE `shoplogin` (
  `shop_ID` int(8) NOT NULL,
  `shop_Email` varchar(100) NOT NULL,
  `shop_Password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shoplogin`
--

INSERT INTO `shoplogin` (`shop_ID`, `shop_Email`, `shop_Password`) VALUES
(12400003, 'shop@gmail.com', '$2y$10$MNJI8tqWzXGSoct1F08tAen2PJL.HJJy3p87zfTCpiA3FtEilLLz.'),
(12400037, 'foodshop@gmail.com', '$2y$10$WJvUcwd2CZvGmh1HmRXBi.KkpZLJ0Hf81Zdi6.d/uGQvEcWBzBwZm'),
(12400038, 'nannystore@gmail.com', '$2y$10$URjzsPVyFkIa97.2mP4qDeR5tC/PBAcM2A0iotEOVT6B0Ql1agRCq'),
(12400039, 'onpizza@gmail.com', '$2y$10$ovqOtNbX2RSOFYkzrLq.JebIKSbb20H6gsAN0lTOhzBSs/TcDz4Km'),
(12400040, 'topsilog@gmail.com', '$2y$10$sipBU/qed1hyXZs/57bHUuRs50zpcLa6P3PLNtr4rPq9xNHYB5cRC'),
(12400041, 'pares@gmail.com', '$2y$10$7k5QfK.xSlMJE/cMHFTbw.JIIZ/uOJ80h6fMBfu5NgC6yUYow6r82'),
(12400042, 'minuteburger@gmail.com', '$2y$10$yUcU.Vr6DzIEPUMeSaDbb.J/AE3xXJSY4aoGSJaX2VRC04IegPJTS'),
(12400043, 'schoolsupplies@gmail.com', '$2y$10$x90WcAs6JWnwGhY/PohMgee/pRy0M1FxEamMUAo0RsjMM0bQYMgPG'),
(12400044, 'tuhogtuhog@gmail.com', '$2y$10$hjmYNJOip1mzXoGSt4cfSeqooyq.vajDAYCr4lSKGVhareKQbq982'),
(12400045, 'bigbrew@gmail.com', '$2y$10$PJXP5gT2f7ILMtYCONIpIe9JWqg7JTvWJBBkOTvMOlPZ5zeZpv36G'),
(12400046, 'seveneleven@gmail.com', '$2y$10$wddMIOQVlFGL/FT5ZYzATONjebS/f6imOtfZfLWiM9z.Es0FMGZES');

-- --------------------------------------------------------

--
-- Table structure for table `shopproducts`
--

CREATE TABLE `shopproducts` (
  `product_ID` int(8) NOT NULL,
  `product_Name` varchar(55) NOT NULL,
  `product_Price` double NOT NULL,
  `product_Description` varchar(255) NOT NULL,
  `product_Image` varchar(255) NOT NULL,
  `shop_ID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopproducts`
--

INSERT INTO `shopproducts` (`product_ID`, `product_Name`, `product_Price`, `product_Description`, `product_Image`, `shop_ID`) VALUES
(92400021, 'Kape Moca', 39, 'Kapeng Mocang Moca', '92400021.png', 12400045),
(92400022, 'Matcha', 49, 'Kapeng Matchang Matcha', '92400022.png', 12400045),
(92400023, 'Caramel Macch', 49, '', '92400023.png', 12400045),
(92400024, 'Coffee Jelly', 49, '', '92400024.png', 12400045),
(92400025, 'Cookies and Cream', 39, '', '92400025.png', 12400045),
(92400026, 'Kape Vanilla', 39, '', '92400026.png', 12400045),
(92400027, 'Kwek-Kwek', 20, '', '92400027.png', 12400044),
(92400028, 'Fish Ball', 20, '', '92400028.png', 12400044),
(92400029, 'Isaw', 10, '', '92400029.png', 12400044),
(92400030, 'Kikiam', 20, '', '92400030.png', 12400044),
(92400031, 'Betamax', 20, '', '92400031.png', 12400044),
(92400032, 'Pencil', 15, '', '92400032.png', 12400043),
(92400033, 'Ballpen', 15, '', '92400033.png', 12400043),
(92400034, 'Yellow paper', 50, '', '92400034.png', 12400043),
(92400035, 'bacon Egg Burger', 50, '', '92400035.png', 12400042),
(92400036, 'Cheesy Burger', 50, '', '92400036.png', 12400042),
(92400037, 'Patties Egg Burger', 50, '', '92400037.png', 12400042),
(92400038, 'Beef Pares', 65, '', '92400038.png', 12400041),
(92400039, 'Pares Mami', 65, '', '92400039.png', 12400041),
(92400040, 'Overload Beef Pares', 150, '', '92400040.png', 12400041),
(92400041, 'Carbonara', 50, 'yummy', '92400041.png', 12400037),
(92400042, 'Spaghetti', 45, '', '92400042.png', 12400037),
(92400043, 'Pancit Malabon', 45, '', '92400043.png', 12400037),
(92400044, 'Tapa rice', 50, '', '92400044.png', 12400038),
(92400045, 'Sisig Rice', 50, '', '92400045.png', 12400038),
(92400046, 'Samgyup Rice', 50, '', '92400046.png', 12400038),
(92400047, 'Ham Pizza', 100, '', '92400047.png', 12400039),
(92400048, 'Cheese Pizza', 100, '', '92400048.png', 12400039),
(92400049, 'Topsilog', 70, '', '92400049.png', 12400040),
(92400050, 'Hotsilog', 70, '', '92400050.png', 12400040),
(92400051, 'Tosilog', 70, '', '92400051.png', 12400040),
(92400052, 'Praf Balbas', 59, 'Praf medio', '92400052.png', 12400045),
(92400053, 'Big Gulp', 69, '', '92400053.png', 12400046),
(92400054, 'Siopao', 45, '', '92400054.png', 12400046),
(92400055, 'Big Bite', 45, '', '92400055.png', 12400046),
(92400056, 'Slurpee', 40, '', '92400056.png', 12400046),
(92400058, 'Coffee Jelly', 15, 'Coffee Jelly 350mL', '92400058.png', 12400003);

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `user_ID` int(8) NOT NULL,
  `user_Nickname` varchar(55) NOT NULL,
  `user_Name` varchar(55) NOT NULL,
  `user_Phone` bigint(11) DEFAULT NULL,
  `user_Location` varchar(100) CHARACTER SET utf32 COLLATE utf32_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`user_ID`, `user_Nickname`, `user_Name`, `user_Phone`, `user_Location`) VALUES
(24000008, 'Fuwi', 'fuwi', 0, ''),
(24000011, 'Charles', 'Charles Jeremy P Berza', 0, ''),
(24000012, 'Erjohn', 'Erjohn Agape D Sabio', 0, ''),
(24000014, 'Zane', 'Louis Zane DS De Jesus', 0, ''),
(24000015, 'Fritz', 'Gian Fritz P Mangalindan', 0, ''),
(24000016, 'Shun', 'Shun', 0, ''),
(24000017, 'sato', 'sato', 0, ''),
(24000018, 'gureth', 'gureth', 0, ''),
(24000019, 'chrales', 'chrales', 9123456789, 'helloworld'),
(24000040, 'testing', 'test', 9123456789, 'test location'),
(24000043, 'Fritz', 'Furittsu', 9167632219, 'CLIRDECCLSU');

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

CREATE TABLE `userlogin` (
  `user_ID` int(8) NOT NULL,
  `user_Email` varchar(55) NOT NULL,
  `user_Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`user_ID`, `user_Email`, `user_Password`) VALUES
(24000008, 'fuwi@gmail.com', '$2y$10$fpsU8LZu8rl6FmW5aFAPdudJyRoH/IDT/OlNI821khOZZCA4rPu6u'),
(24000011, 'charles@gmail.com', '$2y$10$AEU/mu4svEUgGVXfopPQsesTawL9KD7xMO9CZJduamK3QLCRu8D76'),
(24000012, 'erjohn@gmail.com', '$2y$10$EFMvNZ8hYE9W/NvgLcBwKe0WRVxswfRt6aKO5JUkNuHWnhPig2j2.'),
(24000014, 'zane@gmail.com', '$2y$10$kNlHlm0lMSDAK2FIK8wJNeH.v7PSrGJ2JEk0oHL7txDEVXQi.VbMi'),
(24000015, 'fritz@gmail.com', '$2y$10$cmLCGSv2lUsPbfR04cp5GON/ckqalK71QKiRJJh9eECAhKVZwTDm6'),
(24000016, 'shun@gmail.com', '$2y$10$88arXVQfZN76xNkJ1L1osOtDDkYL45SdYYr23TnXghy9p1CXnqxtW'),
(24000017, 'sato@gmail.com', '$2y$10$EbhZauByrPVhn7Ahyex8ReberMi4xv6Trmj5IoZ9dOnGuypC51Qz.'),
(24000018, 'gureth@gmail.com', '$2y$10$4TfCsAIHroBHcfw7Tu1VxuwIEkPJvO7Bc7sjsQxtNQnx1IQpHCpwK'),
(24000019, 'chrales@gmail.com', '$2y$10$EvD8KRfoy1s60dsQv2l2GuJZa7qHEyXOYOMqo396NpDWvryrqqzYO'),
(24000040, 'test@gmail.com', '$2y$10$/DiUGzdq2oyCFRvXucuJiup1rwAcDExM9YWa8l30s4pxBd6.asB02'),
(24000043, 'furittsuf@gmail.com', '$2y$10$AZ24vRBzv2SBV/uOt6Ei4.H1WrIu/K.RUTpeohUszvnZ0VnfrpYga');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminlogin`
--
ALTER TABLE `adminlogin`
  ADD PRIMARY KEY (`admin_ID`);

--
-- Indexes for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`cart_ID`);

--
-- Indexes for table `shopdata`
--
ALTER TABLE `shopdata`
  ADD KEY `shop_ID_FK` (`shop_ID`);

--
-- Indexes for table `shoplogin`
--
ALTER TABLE `shoplogin`
  ADD PRIMARY KEY (`shop_ID`);

--
-- Indexes for table `shopproducts`
--
ALTER TABLE `shopproducts`
  ADD PRIMARY KEY (`product_ID`),
  ADD KEY `shop_ID_products_FK` (`shop_ID`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD KEY `user_ID_FK` (`user_ID`);

--
-- Indexes for table `userlogin`
--
ALTER TABLE `userlogin`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminlogin`
--
ALTER TABLE `adminlogin`
  MODIFY `admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `cart_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `shoplogin`
--
ALTER TABLE `shoplogin`
  MODIFY `shop_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12400048;

--
-- AUTO_INCREMENT for table `shopproducts`
--
ALTER TABLE `shopproducts`
  MODIFY `product_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92400061;

--
-- AUTO_INCREMENT for table `userlogin`
--
ALTER TABLE `userlogin`
  MODIFY `user_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24000046;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `shopdata`
--
ALTER TABLE `shopdata`
  ADD CONSTRAINT `shop_ID_FK` FOREIGN KEY (`shop_ID`) REFERENCES `shoplogin` (`shop_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shopproducts`
--
ALTER TABLE `shopproducts`
  ADD CONSTRAINT `shop_ID_products_FK` FOREIGN KEY (`shop_ID`) REFERENCES `shoplogin` (`shop_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userdata`
--
ALTER TABLE `userdata`
  ADD CONSTRAINT `user_ID_FK` FOREIGN KEY (`user_ID`) REFERENCES `userlogin` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
