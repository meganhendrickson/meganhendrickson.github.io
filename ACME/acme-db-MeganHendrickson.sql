-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2020 at 03:57 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acme`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryId` int(10) UNSIGNED NOT NULL,
  `categoryName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Category classifications of inventory items';

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryId`, `categoryName`) VALUES
(1, 'Cannon'),
(2, 'Explosive'),
(3, 'Misc'),
(4, 'Rocket'),
(5, 'Trap');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `clientId` int(10) UNSIGNED NOT NULL,
  `clientFirstname` varchar(15) NOT NULL,
  `clientLastname` varchar(25) NOT NULL,
  `clientEmail` varchar(40) NOT NULL,
  `clientPassword` varchar(255) NOT NULL,
  `clientLevel` enum('1','2','3') NOT NULL DEFAULT '1',
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`clientId`, `clientFirstname`, `clientLastname`, `clientEmail`, `clientPassword`, `clientLevel`, `comments`) VALUES
(1, 'Admin', 'User', 'admin@cit336.net', '$2y$10$xTFCwk.0iJd8vwNgwby8Qug4Ftx25p3p8CmLe5G.Lmwa9CfRBJSaa', '3', ''),
(7, 'Norm', 'User', 'norm@cit336.net', '$2y$10$HL.nXJ4KpfWCFCEjInxxteEeu8u/iQrMFdVbVBU1ppmPomEjt5gGy', '1', ''),
(11, 'Megan', 'Hendrickson', 'dearmegs@gmail.com', '$2y$10$g2HxepwyEwsLpca3hnT3FuoQ2mq84KEbWXQVzbBvMrCDlAO5bU8PC', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `imgId` int(10) UNSIGNED NOT NULL,
  `invId` int(10) UNSIGNED NOT NULL,
  `imgName` varchar(100) NOT NULL,
  `imgPath` varchar(50) NOT NULL,
  `imgDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imgId`, `invId`, `imgName`, `imgPath`, `imgDate`) VALUES
(9, 1, 'rocket.png', '/acme/images/products/rocket.png', '2020-03-22 02:42:27'),
(10, 1, 'rocket-tn.png', '/acme/images/products/rocket-tn.png', '2020-03-22 02:42:27'),
(17, 8, 'anvil.png', '/acme/images/products/anvil.png', '2020-03-22 02:48:32'),
(18, 8, 'anvil-tn.png', '/acme/images/products/anvil-tn.png', '2020-03-22 02:48:32'),
(19, 3, 'catapult.png', '/acme/images/products/catapult.png', '2020-03-22 02:48:46'),
(20, 3, 'catapult-tn.png', '/acme/images/products/catapult-tn.png', '2020-03-22 02:48:46'),
(21, 14, 'helmet.png', '/acme/images/products/helmet.png', '2020-03-22 02:49:02'),
(22, 14, 'helmet-tn.png', '/acme/images/products/helmet-tn.png', '2020-03-22 02:49:02'),
(23, 4, 'roadrunner.jpg', '/acme/images/products/roadrunner.jpg', '2020-03-22 02:49:15'),
(24, 4, 'roadrunner-tn.jpg', '/acme/images/products/roadrunner-tn.jpg', '2020-03-22 02:49:15'),
(25, 5, 'trap.jpg', '/acme/images/products/trap.jpg', '2020-03-22 02:49:53'),
(26, 5, 'trap-tn.jpg', '/acme/images/products/trap-tn.jpg', '2020-03-22 02:49:53'),
(27, 13, 'piano.jpg', '/acme/images/products/piano.jpg', '2020-03-22 02:50:03'),
(28, 13, 'piano-tn.jpg', '/acme/images/products/piano-tn.jpg', '2020-03-22 02:50:03'),
(29, 6, 'hole.png', '/acme/images/products/hole.png', '2020-03-22 02:50:25'),
(30, 6, 'hole-tn.png', '/acme/images/products/hole-tn.png', '2020-03-22 02:50:25'),
(31, 7, 'no-image.png', '/acme/images/products/no-image.png', '2020-03-22 02:50:54'),
(32, 7, 'no-image-tn.png', '/acme/images/products/no-image-tn.png', '2020-03-22 02:50:54'),
(33, 10, 'mallet.png', '/acme/images/products/mallet.png', '2020-03-22 02:51:08'),
(34, 10, 'mallet-tn.png', '/acme/images/products/mallet-tn.png', '2020-03-22 02:51:08'),
(35, 9, 'rubberband.jpg', '/acme/images/products/rubberband.jpg', '2020-03-22 02:51:34'),
(36, 9, 'rubberband-tn.jpg', '/acme/images/products/rubberband-tn.jpg', '2020-03-22 02:51:34'),
(37, 2, 'mortar.jpg', '/acme/images/products/mortar.jpg', '2020-03-22 02:51:51'),
(38, 2, 'mortar-tn.jpg', '/acme/images/products/mortar-tn.jpg', '2020-03-22 02:51:51'),
(39, 15, 'rope.jpg', '/acme/images/products/rope.jpg', '2020-03-22 02:52:04'),
(40, 15, 'rope-tn.jpg', '/acme/images/products/rope-tn.jpg', '2020-03-22 02:52:04'),
(41, 12, 'seed.jpg', '/acme/images/products/seed.jpg', '2020-03-22 02:52:15'),
(42, 12, 'seed-tn.jpg', '/acme/images/products/seed-tn.jpg', '2020-03-22 02:52:15'),
(43, 16, 'bomb.png', '/acme/images/products/bomb.png', '2020-03-22 02:52:26'),
(44, 16, 'bomb-tn.png', '/acme/images/products/bomb-tn.png', '2020-03-22 02:52:26'),
(47, 17, 'tnt.png', '/acme/images/products/tnt.png', '2020-03-22 02:58:08'),
(48, 17, 'tnt-tn.png', '/acme/images/products/tnt-tn.png', '2020-03-22 02:58:08'),
(49, 3, 'catapult2.png', '/acme/images/products/catapult2.png', '2020-03-22 04:27:41'),
(50, 3, 'catapult2-tn.png', '/acme/images/products/catapult2-tn.png', '2020-03-22 04:27:41'),
(51, 3, 'catapult3.png', '/acme/images/products/catapult3.png', '2020-03-23 14:56:38'),
(52, 3, 'catapult3-tn.png', '/acme/images/products/catapult3-tn.png', '2020-03-23 14:56:38'),
(53, 16, 'bomb2.jpg', '/acme/images/products/bomb2.jpg', '2020-03-23 15:31:25'),
(54, 16, 'bomb2-tn.jpg', '/acme/images/products/bomb2-tn.jpg', '2020-03-23 15:31:25'),
(55, 16, 'bomb3.png', '/acme/images/products/bomb3.png', '2020-03-23 15:31:55'),
(56, 16, 'bomb3-tn.png', '/acme/images/products/bomb3-tn.png', '2020-03-23 15:31:55');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `invId` int(10) UNSIGNED NOT NULL,
  `invName` varchar(50) NOT NULL DEFAULT '',
  `invDescription` text NOT NULL,
  `invImage` varchar(50) NOT NULL DEFAULT '',
  `invThumbnail` varchar(50) NOT NULL DEFAULT '',
  `invPrice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invStock` smallint(6) NOT NULL DEFAULT '0',
  `invSize` smallint(6) NOT NULL DEFAULT '0',
  `invWeight` smallint(6) NOT NULL DEFAULT '0',
  `invLocation` varchar(35) NOT NULL DEFAULT '',
  `categoryId` int(10) UNSIGNED NOT NULL,
  `invVendor` varchar(20) NOT NULL DEFAULT '',
  `invStyle` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Acme Inc. Inventory Table';

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`invId`, `invName`, `invDescription`, `invImage`, `invThumbnail`, `invPrice`, `invStock`, `invSize`, `invWeight`, `invLocation`, `categoryId`, `invVendor`, `invStyle`) VALUES
(1, 'Acme Rocket', 'The Acme Rocket meets multiple purposes. This can be launched independently to deliver a payload or strapped on to help get you to where you want to be FAST!!! Really Fast! Launch stand is included.', '/acme/images/products/rocket.png', '/acme/images/products/rocket-tn.png', '132000.00', 5, 60, 90, 'Albuquerque, New Mexico', 4, 'Goddard', 'metal'),
(2, 'Mortar', 'Our Mortar is very powerful. This cannon can launch a projectile or bomb 3 miles. Made of solid steel and mounted on cement or metal stands [not included].', '/acme/images/products/mortar.jpg', '/acme/images/products/mortar-tn.jpg', '1500.00', 26, 250, 750, 'San Jose', 1, 'Smith & Wesson', 'Metal'),
(3, 'Catapult', 'Our best wooden catapult. Ideal for hurling objects for up to 1000 yards. Payloads of up to 300 lbs.', '/acme/images/products/catapult.png', '/acme/images/products/catapult-tn.png', '2500.00', 4, 1569, 400, 'Cedar Point, IO', 1, 'Wooden Creations', 'Wood'),
(4, 'Female RoadRuner Cutout', 'This carbon fiber backed cutout of a female roadrunner is sure to catch the eye of any male roadrunner.', '/acme/images/products/roadrunner.jpg', '/acme/images/products/roadrunner-tn.jpg', '20.00', 500, 27, 2, 'San Jose', 5, 'Picture Perfect', 'Carbon Fiber'),
(5, 'Giant Mouse Trap', 'Our big mouse trap. This trap is multifunctional. It can be used to catch dogs, mountain lions, road runners or even muskrats. Must be staked for larger varmints [stakes not included] and baited with approptiate bait [sold seperately].\r\n', '/acme/images/products/trap.jpg', '/acme/images/products/trap-tn.jpg', '20.00', 34, 470, 28, 'Cedar Point, IO', 5, 'Rodent Control', 'Wood'),
(6, 'Instant Hole', 'Wonderful for creating the appearance of openings.', '/ACME/images/products/hole.png', '/ACME/images/products/hole-tn.png', '25.00', 269, 24, 2, 'San Jose', 3, 'Hidden Valley', 'Nothing'),
(7, 'Koenigsegg CCX Car', 'This high performance car is sure to get you where you are going fast. It holds the production car land speed record at an amazing 250mph.', '/acme/images/products/no-image.png', '/acme/images/products/no-image-tn.png', '99999999.99', 1, 25000, 3000, 'Stockholm, Sweden', 3, 'Koenigsegg', 'Metal'),
(8, 'Anvil', '50 lb. Anvil - perfect for any task requireing lots of weight. Made of solid, tempered steel.', '/acme/images/products/anvil.png', '/acme/images/products/anvil-tn.png', '150.00', 15, 80, 50, 'San Jose', 5, 'Steel Made', 'Metal'),
(9, 'Monster Rubber Band', 'These are not tiny rubber bands. These are MONSTERS! These bands can stop a train locamotive or be used as a slingshot for cows. Only the best materials are used!', '/acme/images/products/rubberband.jpg', '/acme/images/products/rubberband-tn.jpg', '4.00', 4589, 75, 1, 'Cedar Point, IO', 3, 'Rubbermaid', 'Rubber'),
(10, 'Mallet', 'Ten pound mallet for bonking roadrunners on the head. Can also be used for bunny rabbits.', '/acme/images/products/mallet.png', '/acme/images/products/mallet-tn.png', '25.00', 100, 36, 10, 'Cedar Point, IA', 3, 'Wooden Creations', 'Wood'),
(12, 'Roadrunner Custom Bird Seed Mix', 'Our best varmint seed mix - varmints on two or four legs cannot resist this mix. Contains meat, nuts, cereals and our own special ingredient. Guaranteed to bring them in. Can be used with our monster trap.', '/acme/images/products/seed.jpg', '/acme/images/products/seed-tn.jpg', '8.00', 150, 24, 3, 'San Jose', 5, 'Acme', 'Plastic'),
(13, 'Grand Piano', 'This upright grand piano is guaranteed to play well and smash anything beneath it if dropped from a height.', '/acme/images/products/piano.jpg', '/acme/images/products/piano-tn.jpg', '3500.00', 36, 500, 1200, 'Cedar Point, IA', 3, 'Wulitzer', 'Wood'),
(14, 'Crash Helmet', 'This carbon fiber and plastic helmet is the ultimate in protection for your head. comes in assorted colors.', '/acme/images/products/helmet.png', '/acme/images/products/helmet-tn.png', '100.00', 25, 48, 9, 'San Jose', 3, 'Suzuki', 'Carbon Fiber'),
(15, 'Nylon Rope', 'This nylon rope is ideal for all uses. Each rope is the highest quality nylon and comes in 100 foot lengths.', '/acme/images/products/rope.jpg', '/acme/images/products/rope-tn.jpg', '15.00', 200, 200, 6, 'San Jose', 3, 'Marina Sales', 'Nylon'),
(16, 'Small Bomb', 'Bomb with a fuse - A little old fashioned, but highly effective. This bomb has the ability to devistate anything within 30 feet.', '/acme/images/products/bomb.png', '/acme/images/products/bomb-tn.png', '275.00', 58, 30, 12, 'San Jose', 2, 'Nobel Enterprises', 'Metal'),
(17, 'TNT', 'The biggest bang for your buck with our nitro-based TNT. Price is per stick.', '/acme/images/products/tnt.png', '/acme/images/products/tnt-tn.png', '9.00', 1000, 25, 2, 'San Jose', 2, 'Nobel Enterprises', 'Plastic');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewId` int(10) UNSIGNED NOT NULL,
  `reviewText` text NOT NULL,
  `reviewDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `invId` int(10) UNSIGNED NOT NULL,
  `clientId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewId`, `reviewText`, `reviewDate`, `invId`, `clientId`) VALUES
(8, 'Fantastic!', '2020-04-03 05:08:01', 2, 1),
(10, 'Dangerous! I was in a full body cast for months after using this rocket!', '2020-04-02 03:49:51', 1, 1),
(11, 'Perfect! Looks just like the real thing!', '2020-04-02 03:50:24', 4, 1),
(12, 'Blast was delayed - stay back!', '2020-04-07 00:40:26', 17, 7),
(13, 'Incredible!', '2020-04-02 03:51:45', 6, 7),
(14, 'Make sure you use the crash helment!', '2020-04-02 03:52:00', 1, 7),
(15, 'Saved my life!', '2020-04-02 03:52:15', 14, 7),
(17, 'Another fantastic review!', '2020-04-06 22:06:38', 2, 7),
(24, 'This is a really really big trap!', '2020-04-07 01:19:10', 5, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`clientId`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imgId`),
  ADD KEY `FK_inv_img` (`invId`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`invId`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `FK_inv_id` (`invId`),
  ADD KEY `FK_client_id` (`clientId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `clientId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `imgId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `invId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_inv_img` FOREIGN KEY (`invId`) REFERENCES `inventory` (`invId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `FK_inv_categories` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_client_id` FOREIGN KEY (`clientId`) REFERENCES `clients` (`clientId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_inv_id` FOREIGN KEY (`invId`) REFERENCES `inventory` (`invId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
