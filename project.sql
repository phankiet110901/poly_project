-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2020 at 06:05 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--
CREATE DATABASE IF NOT EXISTS `project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `project`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `cartDate` date NOT NULL,
  `customerName` varchar(50) NOT NULL,
  `customerAddress` varchar(100) NOT NULL,
  `customerTelephone` int(15) NOT NULL,
  `customerEmail` varchar(125) NOT NULL,
  `cartTotal` decimal(15,2) NOT NULL,
  `cartStatus` bit(1) NOT NULL DEFAULT b'0',
  `userID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cart_detail`
--

CREATE TABLE `cart_detail` (
  `ID` int(11) NOT NULL,
  `cartID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `sizeID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentID` int(11) NOT NULL,
  `commentText` varchar(5000) NOT NULL,
  `productID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `commentDate` date NOT NULL,
  `commentStatus` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productID` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productImg` varchar(255) NOT NULL,
  `productGallery` varchar(255) NOT NULL,
  `productPrice` decimal(15,2) NOT NULL,
  `productDiscount` int(11) NOT NULL,
  `productQuantity` int(11) NOT NULL,
  `productDate` date NOT NULL,
  `productDescription` varchar(5000) NOT NULL,
  `productView` int(11) NOT NULL DEFAULT 0,
  `productStatus` bit(1) NOT NULL DEFAULT b'1',
  `catalogID` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `productImg`, `productGallery`, `productPrice`, `productDiscount`, `productQuantity`, `productDate`, `productDescription`, `productView`, `productStatus`, `catalogID`) VALUES
(1, 'The Blue Banded Bee Tee\r\n', 'product-1.png', 'describe-1.png,describe-right-1.png,describe-right-2.png', '89.00', 0, 1, '2020-11-09', '              <p>\r\n                The Blue Banded Bee Tee is a signature RYDER vintage style\r\n                t-shirt. Featuring hand-drawn illustrations of Australian blue\r\n                banded bees with a contrast dusty blue neckline. Made from a\r\n                100% organic cotton providing a soft vintage feel.\r\n              </p>\r\n              <p>- 100% organic cotton jersey</p>\r\n              <p>- Contrast blue rib neckline</p>\r\n              <p>- Relaxed, boxy fit</p>\r\n              <p>- Scoop neckline</p>\r\n              <p>- Short sleeves</p>\r\n              <p>- Hand illustrated print</p>\r\n              <p>- Lucinda and Kepsi wear a size S/8</p>\r\n              <p>We love our planet as much as you love our tees.</p>\r\n              <p>\r\n                Now you can feel even happier in your Australian Tee knowing\r\n                that 10% of its profits are heading towards protecting our only\r\n                home.\r\n              </p>\r\n              <p>\r\n                Wear them proudly, every flora and fauna represented on our tees\r\n                needs our help.\r\n              </p>\r\n', 1, b'1', 'f3ab4f52-22a5-11eb-8822-309c23de2ee2'),
(2, 'G\'day Knit Sweater Wheat', 'product-2.png', '', '159.00', 0, 1, '2020-11-03', '              <p>\r\n                The Blue Banded Bee Tee is a signature RYDER vintage style\r\n                t-shirt. Featuring hand-drawn illustrations of Australian blue\r\n                banded bees with a contrast dusty blue neckline. Made from a\r\n                100% organic cotton providing a soft vintage feel.\r\n              </p>\r\n              <p>- 100% organic cotton jersey</p>\r\n              <p>- Contrast blue rib neckline</p>\r\n              <p>- Relaxed, boxy fit</p>\r\n              <p>- Scoop neckline</p>\r\n              <p>- Short sleeves</p>\r\n              <p>- Hand illustrated print</p>\r\n              <p>- Lucinda and Kepsi wear a size S/8</p>\r\n              <p>We love our planet as much as you love our tees.</p>\r\n              <p>\r\n                Now you can feel even happier in your Australian Tee knowing\r\n                that 10% of its profits are heading towards protecting our only\r\n                home.\r\n              </p>\r\n              <p>\r\n                Wear them proudly, every flora and fauna represented on our tees\r\n                needs our help.\r\n</p>\r\n', 0, b'1', 'f3ae6e2b-22a5-11eb-8822-309c23de2ee2'),
(3, 'Crikey Tee', 'product-3.png', '', '59.00', 0, 1, '2020-11-07', '              <p>\r\n                The Blue Banded Bee Tee is a signature RYDER vintage style\r\n                t-shirt. Featuring hand-drawn illustrations of Australian blue\r\n                banded bees with a contrast dusty blue neckline. Made from a\r\n                100% organic cotton providing a soft vintage feel.\r\n              </p>\r\n              <p>- 100% organic cotton jersey</p>\r\n              <p>- Contrast blue rib neckline</p>\r\n              <p>- Relaxed, boxy fit</p>\r\n              <p>- Scoop neckline</p>\r\n              <p>- Short sleeves</p>\r\n              <p>- Hand illustrated print</p>\r\n              <p>- Lucinda and Kepsi wear a size S/8</p>\r\n              <p>We love our planet as much as you love our tees.</p>\r\n              <p>\r\n                Now you can feel even happier in your Australian Tee knowing\r\n                that 10% of its profits are heading towards protecting our only\r\n                home.\r\n              </p>\r\n              <p>\r\n                Wear them proudly, every flora and fauna represented on our tees\r\n                needs our help.\r\n</p>\r\n', 0, b'1', 'f3ae6fe5-22a5-11eb-8822-309c23de2ee2'),
(4, 'It\'s A Good Day Tee', 'product-4.png', '', '69.00', 0, 1, '2020-11-09', '              <p>\r\n                The Blue Banded Bee Tee is a signature RYDER vintage style\r\n                t-shirt. Featuring hand-drawn illustrations of Australian blue\r\n                banded bees with a contrast dusty blue neckline. Made from a\r\n                100% organic cotton providing a soft vintage feel.\r\n              </p>\r\n              <p>- 100% organic cotton jersey</p>\r\n              <p>- Contrast blue rib neckline</p>\r\n              <p>- Relaxed, boxy fit</p>\r\n              <p>- Scoop neckline</p>\r\n              <p>- Short sleeves</p>\r\n              <p>- Hand illustrated print</p>\r\n              <p>- Lucinda and Kepsi wear a size S/8</p>\r\n              <p>We love our planet as much as you love our tees.</p>\r\n              <p>\r\n                Now you can feel even happier in your Australian Tee knowing\r\n                that 10% of its profits are heading towards protecting our only\r\n                home.\r\n              </p>\r\n              <p>\r\n                Wear them proudly, every flora and fauna represented on our tees\r\n                needs our help.\r\n              </p>\r\n', 0, b'1', 'f3ab4f52-22a5-11eb-8822-309c23de2ee2'),
(5, 'You Beauty Tee', 'product-5.png', '', '19.99', 0, 1, '2020-11-09', '              <p>\r\n                The Blue Banded Bee Tee is a signature RYDER vintage style\r\n                t-shirt. Featuring hand-drawn illustrations of Australian blue\r\n                banded bees with a contrast dusty blue neckline. Made from a\r\n                100% organic cotton providing a soft vintage feel.\r\n              </p>\r\n              <p>- 100% organic cotton jersey</p>\r\n              <p>- Contrast blue rib neckline</p>\r\n              <p>- Relaxed, boxy fit</p>\r\n              <p>- Scoop neckline</p>\r\n              <p>- Short sleeves</p>\r\n              <p>- Hand illustrated print</p>\r\n              <p>- Lucinda and Kepsi wear a size S/8</p>\r\n              <p>We love our planet as much as you love our tees.</p>\r\n              <p>\r\n                Now you can feel even happier in your Australian Tee knowing\r\n                that 10% of its profits are heading towards protecting our only\r\n                home.\r\n              </p>\r\n              <p>\r\n                Wear them proudly, every flora and fauna represented on our tees\r\n                needs our help.\r\n              </p>\r\n', 0, b'1', 'f3ae707d-22a5-11eb-8822-309c23de2ee2'),
(6, 'Basic Organic Cotton Tee', 'product-6.png', '', '59.00', 0, 1, '2020-11-03', '              <p>\r\n                The Blue Banded Bee Tee is a signature RYDER vintage style\r\n                t-shirt. Featuring hand-drawn illustrations of Australian blue\r\n                banded bees with a contrast dusty blue neckline. Made from a\r\n                100% organic cotton providing a soft vintage feel.\r\n              </p>\r\n              <p>- 100% organic cotton jersey</p>\r\n              <p>- Contrast blue rib neckline</p>\r\n              <p>- Relaxed, boxy fit</p>\r\n              <p>- Scoop neckline</p>\r\n              <p>- Short sleeves</p>\r\n              <p>- Hand illustrated print</p>\r\n              <p>- Lucinda and Kepsi wear a size S/8</p>\r\n              <p>We love our planet as much as you love our tees.</p>\r\n              <p>\r\n                Now you can feel even happier in your Australian Tee knowing\r\n                that 10% of its profits are heading towards protecting our only\r\n                home.\r\n              </p>\r\n              <p>\r\n                Wear them proudly, every flora and fauna represented on our tees\r\n                needs our help.\r\n              </p>\r\n', 0, b'1', 'f3ae707d-22a5-11eb-8822-309c23de2ee2');

-- --------------------------------------------------------

--
-- Table structure for table `product_catalog`
--

CREATE TABLE `product_catalog` (
  `catalogID` varchar(36) NOT NULL,
  `catalogName` varchar(30) NOT NULL,
  `catalogOrder` int(11) NOT NULL,
  `catalogStatus` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_catalog`
--

INSERT INTO `product_catalog` (`catalogID`, `catalogName`, `catalogOrder`, `catalogStatus`) VALUES
('f3ab4f52-22a5-11eb-8822-309c23de2ee2', 'Man', 9, b'1'),
('f3ae6e2b-22a5-11eb-8822-309c23de2ee2', 'Woman', 10, b'1'),
('f3ae6fe5-22a5-11eb-8822-309c23de2ee2', 'Unisex', 11, b'1'),
('f3ae707d-22a5-11eb-8822-309c23de2ee2', 'Jackets', 12, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `sizeID` int(11) NOT NULL,
  `sizeName` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`sizeID`, `sizeName`) VALUES
(1, 'XS/6'),
(2, 'S/8'),
(3, 'M/10'),
(4, 'L/12'),
(5, 'XL/14'),
(6, 'XXL/16');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userAvatar` varchar(255) NOT NULL,
  `userStatus` bit(1) NOT NULL DEFAULT b'0',
  `roleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `roleID` int(11) NOT NULL,
  `roleName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`roleID`, `roleName`) VALUES
(1, 'Administrator'),
(2, 'Memer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`),
  ADD KEY `FK_userID_cart` (`userID`);

--
-- Indexes for table `cart_detail`
--
ALTER TABLE `cart_detail`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_cartID_detail` (`cartID`),
  ADD KEY `FK_productID_detail` (`productID`),
  ADD KEY `FK_sizeID_detail` (`sizeID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `FK_userID_comment` (`userID`),
  ADD KEY `FK_productID_comment` (`productID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `FK_catalogID_product` (`catalogID`);

--
-- Indexes for table `product_catalog`
--
ALTER TABLE `product_catalog`
  ADD PRIMARY KEY (`catalogID`),
  ADD UNIQUE KEY `catalogOrder` (`catalogOrder`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`sizeID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `FK_roleID` (`roleID`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`roleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_detail`
--
ALTER TABLE `cart_detail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_catalog`
--
ALTER TABLE `product_catalog`
  MODIFY `catalogOrder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `sizeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `roleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_userID_cart` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `cart_detail`
--
ALTER TABLE `cart_detail`
  ADD CONSTRAINT `FK_cartID_detail` FOREIGN KEY (`cartID`) REFERENCES `cart` (`cartID`),
  ADD CONSTRAINT `FK_productID_detail` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`),
  ADD CONSTRAINT `FK_sizeID_detail` FOREIGN KEY (`sizeID`) REFERENCES `product_size` (`sizeID`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_productID_comment` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`),
  ADD CONSTRAINT `FK_userID_comment` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_catalogID_product` FOREIGN KEY (`catalogID`) REFERENCES `product_catalog` (`catalogID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_roleID` FOREIGN KEY (`roleID`) REFERENCES `user_role` (`roleID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
