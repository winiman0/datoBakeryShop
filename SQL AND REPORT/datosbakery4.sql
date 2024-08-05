-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2024 at 09:26 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datosbakery4`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `custID` varchar(10) NOT NULL,
  `custName` varchar(50) NOT NULL,
  `custEmail` varchar(50) NOT NULL,
  `custUsername` varchar(50) NOT NULL,
  `custPassword` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`custID`, `custName`, `custEmail`, `custUsername`, `custPassword`) VALUES
('C203484', 'SITI NAZHAN', 'SitiNazhan@gmail.com', 'Nazhan', '1234.'),
('C336629', 'AZIB', 'azibhensem@gmail.com', 'Azib', '1234.'),
('C4266', 'ALIBABA', 'ali@gmail.com', 'Ali', '1234.'),
('C5861', 'SYAFINA IZZAH', 'pina1234@mail.com', 'Syafina', '1234.'),
('C6809', 'AISYAH', 'aisyah123@gmail.com', 'Aisyah', '1234.'),
('C7833', 'SARAH', 'sarah@gmail.com', 'Sarah', '1234.'),
('C8453', 'SALEHA', 'leha@gmail.com', 'Saleha', '1234.'),
('C8991', 'SITI', 'sitiwe123@gmail.com', 'Siti', '1234.'),
('C9793', 'AMIRAH', 'mirahIzzati@gmail.com', 'Amirah', '1234.');

-- --------------------------------------------------------

--
-- Table structure for table `customer_info`
--

CREATE TABLE `customer_info` (
  `custID` varchar(10) NOT NULL,
  `custState` varchar(20) DEFAULT NULL,
  `custPostcode` int(11) DEFAULT NULL,
  `custAddress` varchar(100) DEFAULT NULL,
  `custPhoneNo` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_info`
--

INSERT INTO `customer_info` (`custID`, `custState`, `custPostcode`, `custAddress`, `custPhoneNo`) VALUES
('C203484', 'Kedah', 2000, 'No.1, Taman Naga Emas', '0123456987'),
('C336629', 'Perlis', 78945, 'A-01-23, Apartment Manjakali', '0125698745'),
('C4266', '', 0, '', ''),
('C5861', 'Kelantan', 45623, '309, Jalan Seroja 2/7', '0162357895'),
('C6809', 'Negeri Sembilan', 29000, '22-b90, jalan raja, cheras', '0102966555'),
('C7833', 'Pahang', 27001, 'No 25, Jalan Kasturi Lemon', '0142563256'),
('C8991', 'Kelantan', 89456, 'No2, Jalan Kaswira Kasturi', '0156987546');

-- --------------------------------------------------------

--
-- Table structure for table `dessert`
--

CREATE TABLE `dessert` (
  `dessertID` varchar(10) NOT NULL,
  `flavourDessert` varchar(20) NOT NULL,
  `dessertName` varchar(50) NOT NULL,
  `dessertPrice` decimal(7,2) NOT NULL,
  `dessertStatus` varchar(12) DEFAULT NULL,
  `filename` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dessert`
--

INSERT INTO `dessert` (`dessertID`, `flavourDessert`, `dessertName`, `dessertPrice`, `dessertStatus`, `filename`) VALUES
('CA001', 'MATCHA', 'JAPANESE MATCHA CAKE', 83.50, 'AVAILABLE', 'japaneseMatchaCake.jpg'),
('CA002', 'BLUEBERRY', 'NIGHTSKY CAKE', 70.00, 'AVAILABLE', 'nightSkyCake.jpg'),
('CA003', 'HAZELNUT COFFEE', 'ROASTY CAKE', 63.00, 'AVAILABLE', 'roastyCake.jpg'),
('CA004', 'CHEESE', 'ALMOND LONDON CAKE', 65.20, 'AVAILABLE', 'almondLondonCake.jpg'),
('CA005', 'BLUEBERRY', 'FRUITY BITES CAKE', 43.50, 'AVAILABLE', 'fruityBitesCake.jpg'),
('CA006', 'BUTTER', 'BROWN BUTTER COOKIES CAKE', 100.50, 'AVAILABLE', 'brownButterCookiesCake.jpg'),
('CA007', 'VANILLA', 'CONFETI VANILLA CAKE', 90.50, 'AVAILABLE', 'confetiVanillaCake.jpg'),
('CA008', 'BUTTER', 'S\'MORES CAKE', 93.60, 'AVAILABLE', 'smoresCake.jpg'),
('CA009', 'KIWI', 'SWEET SOUR KIWI CAKE', 85.20, 'AVAILABLE', 'sweetSourKiwi.jpg'),
('CA010', 'BANANA', 'FLUFFY BANANA CAKE', 30.50, 'AVAILABLE', 'bananaCake.jpg'),
('CA011', 'VANILLA', 'VANILLA FONDANT CAKE', 120.00, 'AVAILABLE', 'whitefondant.jpg'),
('CA566', 'CHEESE', 'CHEESE TART', 19.00, 'AVAILABLE', 'creamPuff.jpg'),
('PA001', 'OREO CRUMBS', 'SOFTWAFFLE', 20.20, 'AVAILABLE', 'sofwaffle.jpg'),
('PA002', 'STRAWBERRY', 'SPEAK NOW ICE CREAM', 15.50, 'AVAILABLE', 'speakNowIceCream.jpg'),
('PA003', 'PISTACHIO', 'BOOMBOLONI', 32.60, 'AVAILABLE', 'boomboloniCheese.jpg'),
('PA004', 'CHOCOLATE', 'CINAMON GIRL PIE', 42.50, 'AVAILABLE', 'cinamonGirlPie.jpg'),
('PA005', 'BLUEBERRY', 'SWEET SERENDIPITY TREATS', 15.50, 'AVAILABLE', 'serendipityPops.jpg'),
('PA006', 'CREAM CHEESE CAKE', 'CROMBOLONI', 29.00, 'AVAILABLE', 'cromboloni.jpg'),
('PA007', 'BANANA', 'CREPE BANANA', 24.90, 'AVAILABLE', 'crepeBanana.jpg'),
('PA008', 'HONEY', 'WAFFLE', 12.50, 'AVAILABLE', 'waffle.jpg'),
('PA009', 'MILK', 'MILK DONUT', 5.00, 'AVAILABLE', 'milkDonut.jpg'),
('PA010', 'RASPBERRY', 'RASPBERRY PIE', 29.90, 'AVAILABLE', 'respberryPie.jpg'),
('PA099', 'CHOCOLATE', 'CHOCOLATE CUPCAKE', 10.00, 'AVAILABLE', 'chocolateCupcake.png');

-- --------------------------------------------------------

--
-- Table structure for table `order_cake`
--

CREATE TABLE `order_cake` (
  `orderID` varchar(10) NOT NULL,
  `dessertID` varchar(10) NOT NULL,
  `shapeReq` varchar(20) NOT NULL,
  `decorationReq` varchar(20) NOT NULL,
  `request` varchar(60) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_cake`
--

INSERT INTO `order_cake` (`orderID`, `dessertID`, `shapeReq`, `decorationReq`, `request`, `quantity`) VALUES
('OR1248', 'CA003', 'round', 'wedding', 'add 3 candle', 1),
('OR1941', 'CA009', 'rectangle', 'wedding', '', 1),
('OR2263', 'CA011', 'round', 'wedding', '', 1),
('OR2610', 'CA005', 'round', 'wedding', '', 1),
('OR2770', 'CA003', 'round', 'party', 'put 3 candles', 2),
('OR2945', 'CA009', 'rectangle', 'birthday', 'add 3 candles', 1),
('OR4266', 'CA006', 'round', 'wedding', '', 1),
('OR4898', 'CA003', 'rectangle', 'birthday', 'add candle 5', 2),
('OR5083', 'CA005', 'rectangle', 'wedding', '', 1),
('OR5427', 'CA005', 'rectangle', 'party', '', 1),
('OR5736', 'CA003', 'rectangle', 'wedding', 'add 3 candles', 1),
('OR6805', 'CA009', 'round', 'wedding', '', 1),
('OR811', 'CA002', 'rectangle', 'wedding', '', 1),
('OR8413', 'CA003', 'rectangle', 'birthday', '', 1),
('OR8440', 'CA009', 'round', 'wedding', '', 1),
('OR9616', 'CA005', 'rectangle', 'wedding', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_log`
--

CREATE TABLE `order_log` (
  `custID` varchar(10) NOT NULL,
  `dessertID` varchar(10) NOT NULL,
  `orderID` varchar(10) NOT NULL,
  `orderDate` date NOT NULL,
  `orderStatus` varchar(15) NOT NULL,
  `serviceID` varchar(10) NOT NULL,
  `transactionNo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_log`
--

INSERT INTO `order_log` (`custID`, `dessertID`, `orderID`, `orderDate`, `orderStatus`, `serviceID`, `transactionNo`) VALUES
('C203484', 'CA003', 'OR4898', '2024-06-04', 'delivered', 'SR956', 'TR11801'),
('C203484', 'CA005', 'OR5427', '2024-06-06', 'pending', 'SR4825', 'TR82233'),
('C203484', 'PA004', 'OR9173', '2024-06-06', 'progress', 'SR4825', 'TR82233'),
('C203484', 'PA007', 'OR2259', '2024-06-04', 'delivered', 'SR956', 'TR11801'),
('C203484', 'PA008', 'OR483', '2024-06-04', 'delivered', 'SR956', 'TR11801'),
('C5861', 'CA003', 'OR5736', '2024-06-04', 'pending', 'SR8292', 'TR5789'),
('C5861', 'CA009', 'OR2945', '2024-06-04', 'pending', 'SR9848', 'TR16093'),
('C5861', 'PA010', 'OR1859', '2024-06-04', 'delivered', 'SR9848', 'TR16093'),
('C6809', 'CA003', 'OR2770', '2024-06-13', 'progress', 'SR4059', 'TR25759'),
('C6809', 'CA005', 'OR5083', '2024-06-13', 'pending', 'SR5593', 'TR41992'),
('C6809', 'CA005', 'OR9616', '2024-06-13', 'delivered', 'SR6507', 'TR21075'),
('C6809', 'CA006', 'OR4266', '2024-06-13', 'pending', 'SR6971', 'TR82407'),
('C6809', 'CA011', 'OR2263', '2024-06-13', 'pending', 'SR4321', 'TR99033'),
('C6809', 'PA003', 'OR2688', '2024-06-13', 'progress', 'SR3692', 'TR19165'),
('C6809', 'PA005', 'OR2467', '2024-06-13', 'pending', 'SR6971', 'TR82407'),
('C6809', 'PA010', 'OR4524', '2024-06-13', 'delivered', 'SR4059', 'TR25759'),
('C7833', 'CA002', 'OR811', '2024-06-13', 'pending', 'SR9140', 'TR50689'),
('C7833', 'CA003', 'OR1248', '2024-06-04', 'delivered', 'SR3916', 'TR31028'),
('C7833', 'CA005', 'OR2610', '2024-06-11', 'pending', 'SR2483', 'TR59197'),
('C7833', 'CA009', 'OR1941', '2024-06-12', 'pending', 'SR7109', 'TR49236'),
('C7833', 'PA009', 'OR4875', '2024-06-04', 'delivered', 'SR3916', 'TR31028'),
('C7833', 'PA099', 'OR2486', '2024-06-11', 'pending', 'SR1525', 'TR95357'),
('C8453', 'CA003', 'OR8413', '2024-06-05', 'pending', 'SR1338', 'TR6992'),
('C8453', 'CA009', 'OR8440', '2024-06-06', 'pending', 'SR2189', 'TR59680');

--
-- Triggers `order_log`
--
DELIMITER $$
CREATE TRIGGER `before_order_log_insert` BEFORE INSERT ON `order_log` FOR EACH ROW BEGIN
    IF (SELECT COUNT(*) FROM `order_cake` WHERE `orderID` = NEW.orderID) = 0 AND
       (SELECT COUNT(*) FROM `order_pastry` WHERE `orderID` = NEW.orderID) = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Foreign key constraint fails: Invalid orderID';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_order_log_update` BEFORE UPDATE ON `order_log` FOR EACH ROW BEGIN
    IF (SELECT COUNT(*) FROM `order_cake` WHERE `orderID` = NEW.orderID) = 0 AND
       (SELECT COUNT(*) FROM `order_pastry` WHERE `orderID` = NEW.orderID) = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Foreign key constraint fails: Invalid orderID';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `order_pastry`
--

CREATE TABLE `order_pastry` (
  `orderID` varchar(10) NOT NULL,
  `dessertID` varchar(10) NOT NULL,
  `qtyPerBoxReq` varchar(20) NOT NULL,
  `addToppingReq` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_pastry`
--

INSERT INTO `order_pastry` (`orderID`, `dessertID`, `qtyPerBoxReq`, `addToppingReq`, `quantity`) VALUES
('OR1859', 'PA010', '2', 'creamCheese', 1),
('OR2259', 'PA007', '3', 'chocolateRice', 2),
('OR2467', 'PA005', '2', 'creamCheese', 1),
('OR2486', 'PA099', '2', 'creamCheese', 1),
('OR2688', 'PA003', '2', 'rainbowRiceChoco', 1),
('OR4524', 'PA010', '3', 'creamCheese', 1),
('OR483', 'PA008', '3', 'chocolateRice', 1),
('OR4875', 'PA009', '3', 'creamCheese', 1),
('OR9173', 'PA004', '4', 'whippingCream', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_log`
--

CREATE TABLE `sales_log` (
  `transactionNo` varchar(10) NOT NULL,
  `paymentDate` date NOT NULL,
  `paymentMethod` varchar(15) NOT NULL,
  `amount` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_log`
--

INSERT INTO `sales_log` (`transactionNo`, `paymentDate`, `paymentMethod`, `amount`) VALUES
('TR11801', '2024-05-30', 'transfer', 317.90),
('TR16093', '2024-06-04', 'transfer', 150.00),
('TR19165', '2024-06-13', 'cash', 65.20),
('TR21075', '2024-06-13', 'cash', 43.50),
('TR25759', '2024-06-13', 'transfer', 220.70),
('TR31028', '2024-06-04', 'cash', 78.00),
('TR41992', '2024-06-13', 'cash', 43.50),
('TR46200', '2024-06-06', 'cash', 85.20),
('TR49236', '2024-06-12', 'cash', 85.20),
('TR50689', '2024-06-13', 'cash', 70.00),
('TR5789', '2024-06-04', 'cash', 63.00),
('TR59197', '2024-06-11', 'cash', 48.50),
('TR59680', '2024-06-06', 'cash', 85.20),
('TR6992', '2024-06-05', 'transfer', 63.00),
('TR82233', '2024-06-06', 'transfer', 213.50),
('TR82407', '2024-06-13', 'cash', 131.50),
('TR95357', '2024-06-11', 'transfer', 38.00),
('TR99033', '2024-06-13', 'cash', 120.00);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `serviceID` varchar(10) NOT NULL,
  `serviceName` varchar(15) NOT NULL,
  `serviceDesc` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`serviceID`, `serviceName`, `serviceDesc`) VALUES
('SR1338', 'pickup', '12:30pm'),
('SR1525', 'pickup', '4:30pm'),
('SR2189', 'pickup', '3:30pm'),
('SR2483', 'delivery', 'into my house'),
('SR3692', 'pickup', '2:30pm'),
('SR3916', 'pickup', '2:30pm'),
('SR4059', 'delivery', '23-45 jalan permaisuri, cheras, 5600'),
('SR4321', 'pickup', '12:00pm'),
('SR4825', 'pickup', '4:00pm'),
('SR5593', 'pickup', '4:30pm'),
('SR6507', 'pickup', '5:00pm'),
('SR6971', 'pickup', '4:00pm'),
('SR7109', 'pickup', '12:00pm'),
('SR8292', 'pickup', '4:30pm'),
('SR9140', 'pickup', '4:00pm'),
('SR956', 'delivery', 'Blok 23, Jalan Aspirasi Alam, 57003, Pontian, Johor.'),
('SR9848', 'delivery', 'No30, Jalan Astana, 79044, Kelantan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`custID`);

--
-- Indexes for table `customer_info`
--
ALTER TABLE `customer_info`
  ADD PRIMARY KEY (`custID`);

--
-- Indexes for table `dessert`
--
ALTER TABLE `dessert`
  ADD PRIMARY KEY (`dessertID`);

--
-- Indexes for table `order_cake`
--
ALTER TABLE `order_cake`
  ADD PRIMARY KEY (`orderID`,`dessertID`),
  ADD KEY `dessertID` (`dessertID`);

--
-- Indexes for table `order_log`
--
ALTER TABLE `order_log`
  ADD PRIMARY KEY (`custID`,`dessertID`,`orderID`),
  ADD KEY `dessertID` (`dessertID`),
  ADD KEY `serviceID` (`serviceID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `transactionNo` (`transactionNo`);

--
-- Indexes for table `order_pastry`
--
ALTER TABLE `order_pastry`
  ADD PRIMARY KEY (`orderID`,`dessertID`),
  ADD KEY `dessertID` (`dessertID`);

--
-- Indexes for table `sales_log`
--
ALTER TABLE `sales_log`
  ADD PRIMARY KEY (`transactionNo`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`serviceID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_info`
--
ALTER TABLE `customer_info`
  ADD CONSTRAINT `customer_info_ibfk_1` FOREIGN KEY (`custID`) REFERENCES `customer` (`custID`);

--
-- Constraints for table `order_cake`
--
ALTER TABLE `order_cake`
  ADD CONSTRAINT `order_cake_ibfk_1` FOREIGN KEY (`dessertID`) REFERENCES `dessert` (`dessertID`);

--
-- Constraints for table `order_log`
--
ALTER TABLE `order_log`
  ADD CONSTRAINT `order_log_ibfk_1` FOREIGN KEY (`custID`) REFERENCES `customer` (`custID`),
  ADD CONSTRAINT `order_log_ibfk_2` FOREIGN KEY (`dessertID`) REFERENCES `dessert` (`dessertID`),
  ADD CONSTRAINT `order_log_ibfk_3` FOREIGN KEY (`serviceID`) REFERENCES `service` (`serviceID`),
  ADD CONSTRAINT `order_log_ibfk_6` FOREIGN KEY (`transactionNo`) REFERENCES `sales_log` (`transactionNo`),
  ADD CONSTRAINT `order_log_ibfk_7` FOREIGN KEY (`custID`) REFERENCES `customer` (`custID`);

--
-- Constraints for table `order_pastry`
--
ALTER TABLE `order_pastry`
  ADD CONSTRAINT `order_pastry_ibfk_1` FOREIGN KEY (`dessertID`) REFERENCES `dessert` (`dessertID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
