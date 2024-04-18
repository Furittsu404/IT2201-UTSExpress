-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 07:29 PM
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
(1, 12400003, '{\"92400018\":1,\"92400020\":1,\"92400017\":1,\"92400005\":1,\"92400006\":1}'),
(2, 1, '{\"92400007\":2,\"92400006\":2,\"92400005\":1,\"92400017\":1}');

-- --------------------------------------------------------

--
-- Table structure for table `driverdata`
--

CREATE TABLE `driverdata` (
  `driver_ID` int(8) NOT NULL,
  `driver_Nickname` varchar(100) NOT NULL,
  `driver_Name` varchar(100) NOT NULL,
  `driver_Phone` bigint(11) DEFAULT NULL,
  `driver_UTSNo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driverdata`
--

INSERT INTO `driverdata` (`driver_ID`, `driver_Nickname`, `driver_Name`, `driver_Phone`, `driver_UTSNo`) VALUES
(22400003, 'Druber', 'Druber', 9870934533, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `driverlogin`
--

CREATE TABLE `driverlogin` (
  `driver_ID` int(8) NOT NULL,
  `driver_Email` varchar(100) NOT NULL,
  `driver_Password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driverlogin`
--

INSERT INTO `driverlogin` (`driver_ID`, `driver_Email`, `driver_Password`) VALUES
(22400003, 'druber@gmail.com', '$2y$10$B8bPVZTV1eavg4EaJTtfvuK.OV0WLtn4td/elVMQ6NLEm8SEAeADO');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `filename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `filename`) VALUES
(1, 'UTS-Express.png'),
(2, 'UTS-Express.png'),
(3, 'UTS-Express.png'),
(4, 'nato.jpg'),
(5, 'nato.jpg'),
(6, 'nato.jpg'),
(7, 'nato.jpg'),
(8, 'nato.jpg'),
(9, 'UTS-Express.png'),
(10, 'UTS-Express.png'),
(11, 'UTS-Express.png'),
(12, 'UTS-Express.png'),
(13, 'UTS-Express.png'),
(14, 'UTS-Express.png'),
(15, 'UTS-Express.png'),
(16, 'UTS-Express.png'),
(17, 'UTS-Express.png'),
(18, 'nato.jpg'),
(19, 'nato.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `shopblogs`
--

CREATE TABLE `shopblogs` (
  `blog_ID` int(8) NOT NULL,
  `blog_Name` varchar(100) NOT NULL,
  `blog_Content` longtext NOT NULL,
  `shop_ID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(12400003, 'Shop', 9123456789, 'shop location'),
(12400006, 'shop2', 0, 'shop location'),
(12400007, 'test', 0, 'shop location'),
(12400009, 'image', 0, 'image loc'),
(12400026, '123', 9123456789, '123'),
(12400028, 'Charkings', 9178721526, 'New Market'),
(12400029, 'University Canteen NM Branch', 9185642332, 'New Market'),
(12400031, 'Sari-Sari Store', 9126551239, 'Second Gate'),
(12400033, 'Marys Restaurant', 9077812952, 'Marketting'),
(12400034, '7-Eleven', 9077823863, 'New Market'),
(12400035, 'Aling Karenderya', 9256823490, 'Alumni Canteen');

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
(12400006, 'shop2@gmail.com', '$2y$10$nR5m.YlHh5GBGAnA0C4WwOYRg97PIpFmF0w8oKSsqYG88uCnwqtya'),
(12400007, 'test@gmail.com', '$2y$10$dPQmIv6QOs1Ewb4/FTA.R.CSSVn2qKjS6jOcL9RYveqGdB7UkZVNu'),
(12400009, 'image@gmail.com', '$2y$10$sgwepiaX9LtT1WWmUvns9eYpi8r5iKJBU6w5BhYvZ1bCxj0Zv8ns2'),
(12400026, '123@gmail.com', '$2y$10$VFRO0le1tWd/T3nxwQ4AqOTi2qXbeF/3r41oC6NNakQbrFXPahW7e'),
(12400028, 'charking@gmail.com', '$2y$10$LymOx4GpqtzYwqPE9qYESOxDS9GdADlwLaAIUCEMN5ijLW9.pCZei'),
(12400029, 'ucnm@gmail.com', '$2y$10$BbFt6AZeXGKcbqiDmdTmR.iFC6yhWG55lNz/nTSoaY.JVT4acnfxS'),
(12400030, 'minysari@gmail.com', '$2y$10$VBk8.UJa/0IHY8.mx6IXkeA0YTkYEYe0iArdbSlMcDuJd6X.FXtDa'),
(12400031, 'sarisari@gmail.com', '$2y$10$JGOgXwqQANUEijVGxqUmQOw22ZfQdarJQv7LNmqb359otG/ePdi8K'),
(12400033, 'mary@gmail.com', '$2y$10$jt4S5zkVf4MhJruXXVKSFORj2zcrXDQ/QObNXkdCMFTZCg9t.TADq'),
(12400034, '7eleven@gmail.com', '$2y$10$iq49aYBaF9GtiZOEEtVbVuKlp4qSEmpnKe77MdLBcSJuYGbdZ21MK'),
(12400035, 'karenderya@gmail.com', '$2y$10$60lfbhhlwxU/Yz/V.ESpj.Yo0clVtTQ5eVbs2Hm3uKQ8NbYAs4miK');

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
(92400005, 'Siomai Rice', 49, 'Siomai Rice for Only P49.00 with toppings of your choice.', '92400005.png', 12400003),
(92400006, 'Coffee Jelly', 15, 'Coffe Jelly for only P15.00. Extra Jelly for an Extra P5.00.', '92400006.png', 12400003),
(92400007, 'Adobo Rice', 59, 'Adobo Rice with a choice of Plain Rice or Fried Rice for P5.00. Topped with toppings of your choice.', '92400007.png', 12400003),
(92400017, 'Hotdog', 20, 'hotdog on a stick. chicken and pork variants available!', '92400017.png', 12400003),
(92400018, 'soup', 25, 'fresh soup. freshly cooked with fresh ingridients', '92400018.png', 12400003),
(92400020, 'Anime Waifu', 95000, 'anime waifu of your choice', '92400020.png', 12400003);

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
(24000007, 'Furi', 'Furi F Fuwittsu', 0, 'Hello World'),
(24000008, 'Fuwi', 'fuwi', 0, ''),
(24000011, 'Charles', 'Charles Jeremy P Berza', 0, ''),
(24000012, 'Erjohn', 'Erjohn Agape D Sabio', 0, ''),
(24000013, 'Jasper', 'Jasper Dion S Pabros', 0, ''),
(24000014, 'Zane', 'Louis Zane DS De Jesus', 0, ''),
(24000015, 'Fritz', 'Gian Fritz P Mangalindan', 0, ''),
(24000016, 'Shun', 'Shun', 0, ''),
(24000017, 'sato', 'sato', 0, ''),
(24000018, 'gureth', 'gureth', 0, ''),
(24000019, 'chrales', 'chrales', 9123456789, 'helloworld'),
(24000040, 'testing', 'test', 9123456789, 'test location'),
(24000042, 'Blue', 'Blu', NULL, NULL);

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
(24000007, 'furi@gmail.com', '$2y$10$o.rvq9c.viKesPmISHUsIeYgNPUgtPlG.MTDlt9UqHgrsnlNAWGcK'),
(24000008, 'fuwi@gmail.com', '$2y$10$fpsU8LZu8rl6FmW5aFAPdudJyRoH/IDT/OlNI821khOZZCA4rPu6u'),
(24000011, 'charles@gmail.com', '$2y$10$AEU/mu4svEUgGVXfopPQsesTawL9KD7xMO9CZJduamK3QLCRu8D76'),
(24000012, 'erjohn@gmail.com', '$2y$10$EFMvNZ8hYE9W/NvgLcBwKe0WRVxswfRt6aKO5JUkNuHWnhPig2j2.'),
(24000013, 'jasper@gmail.com', '$2y$10$MQddMlgGbJ5TfNNJ6XAHCuTfQXkYbG7VrwjCEqUgYgYE/.iZ5Z4ua'),
(24000014, 'zane@gmail.com', '$2y$10$kNlHlm0lMSDAK2FIK8wJNeH.v7PSrGJ2JEk0oHL7txDEVXQi.VbMi'),
(24000015, 'fritz@gmail.com', '$2y$10$cmLCGSv2lUsPbfR04cp5GON/ckqalK71QKiRJJh9eECAhKVZwTDm6'),
(24000016, 'shun@gmail.com', '$2y$10$88arXVQfZN76xNkJ1L1osOtDDkYL45SdYYr23TnXghy9p1CXnqxtW'),
(24000017, 'sato@gmail.com', '$2y$10$EbhZauByrPVhn7Ahyex8ReberMi4xv6Trmj5IoZ9dOnGuypC51Qz.'),
(24000018, 'gureth@gmail.com', '$2y$10$4TfCsAIHroBHcfw7Tu1VxuwIEkPJvO7Bc7sjsQxtNQnx1IQpHCpwK'),
(24000019, 'chrales@gmail.com', '$2y$10$EvD8KRfoy1s60dsQv2l2GuJZa7qHEyXOYOMqo396NpDWvryrqqzYO'),
(24000040, 'test@gmail.com', '$2y$10$/DiUGzdq2oyCFRvXucuJiup1rwAcDExM9YWa8l30s4pxBd6.asB02'),
(24000042, 'Blue@gmail.com', '$2y$10$84yCa0oufO1UCY.60SP2PuVXgC08qFMyCwYVeY6lnytuVB6dtLIjC');

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
-- Indexes for table `driverlogin`
--
ALTER TABLE `driverlogin`
  ADD PRIMARY KEY (`driver_ID`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shopblogs`
--
ALTER TABLE `shopblogs`
  ADD PRIMARY KEY (`blog_ID`),
  ADD KEY `shop_ID_shopblog_FK` (`shop_ID`);

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
  MODIFY `cart_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `driverlogin`
--
ALTER TABLE `driverlogin`
  MODIFY `driver_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22400004;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `shopblogs`
--
ALTER TABLE `shopblogs`
  MODIFY `blog_ID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shoplogin`
--
ALTER TABLE `shoplogin`
  MODIFY `shop_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12400036;

--
-- AUTO_INCREMENT for table `shopproducts`
--
ALTER TABLE `shopproducts`
  MODIFY `product_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92400021;

--
-- AUTO_INCREMENT for table `userlogin`
--
ALTER TABLE `userlogin`
  MODIFY `user_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24000043;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `shopblogs`
--
ALTER TABLE `shopblogs`
  ADD CONSTRAINT `shop_ID_shopblog_FK` FOREIGN KEY (`shop_ID`) REFERENCES `shoplogin` (`shop_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
