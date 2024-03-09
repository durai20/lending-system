-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2023 at 09:14 PM
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
-- Database: `datas`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_credentials`
--

CREATE TABLE `admin_credentials` (
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `PHARMACY_NAME` varchar(20) NOT NULL,
  `ADDRESS` varchar(50) NOT NULL,
  `EMAIL` varchar(20) NOT NULL,
  `CONTACT_NUMBER` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

--
-- Dumping data for table `admin_credentials`
--

INSERT INTO `admin_credentials` (`USERNAME`, `PASSWORD`, `PHARMACY_NAME`, `ADDRESS`, `EMAIL`, `CONTACT_NUMBER`) VALUES
('admin', 'admins', 'MKCE', 'Thalavaplayam ,Karur.', 'admin@mkce.ac.in', 1234567899);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `ID` varchar(20) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `PASSWORD` varchar(20) NOT NULL,
  `EMAIL` varchar(50) DEFAULT '0',
  `CONTACT_NUMBER` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`ID`, `NAME`, `PASSWORD`, `EMAIL`, `CONTACT_NUMBER`) VALUES
('927621BCS001', 'Naveen', '927621BCS001', '927621BCS001@mkce.ac.in', 9999999999),
('927621bcs000', 'Ravi', '927621BCS000', '927621bcs000@mkce.ac', 1234567890),
('927621bcs003', 'Sabari', '12345678', '927621bcs003@mkce.ac.in', 9856321475),
('927621bcs004', 'Guna', '21341241241', '927621bcs004@mkce.ac.in', 7458963112);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `INVOICE_ID` int(11) NOT NULL,
  `NET_TOTAL` double NOT NULL DEFAULT 0,
  `INVOICE_DATE` date NOT NULL DEFAULT current_timestamp(),
  `CUSTOMER_ID` int(11) NOT NULL,
  `TOTAL_AMOUNT` double NOT NULL,
  `TOTAL_DISCOUNT` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(30) NOT NULL,
  `product_name` varchar(40) NOT NULL,
  `product_quantity` int(40) NOT NULL,
  `product_price` int(11) NOT NULL,
  `total_price` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `product_quantity`, `product_price`, `total_price`) VALUES
(1, 'COKE', 7, 50, 350),
(2, 'JUICE', 8, 20, 160),
(3, 'LAYS', 5, 5, 25),
(4, 'GOODDAY', 5, 10, 50);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `SUPPLIER_NAME` varchar(100) NOT NULL,
  `INVOICE_NUMBER` int(11) NOT NULL,
  `VOUCHER_NUMBER` int(11) NOT NULL,
  `PURCHASE_DATE` varchar(10) NOT NULL,
  `TOTAL_AMOUNT` double NOT NULL,
  `PAYMENT_STATUS` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `no` int(100) NOT NULL,
  `id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` int(50) NOT NULL,
  `product_quantity` int(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_history`
--

INSERT INTO `purchase_history` (`no`, `id`, `name`, `product_name`, `product_price`, `product_quantity`, `date`) VALUES
(1, '927621bcs000', 'Ravi', 'JUICE', 20, 1, '2023-10-12'),
(2, '927621bcs000', 'Ravi', 'COKE', 50, 1, '2023-10-12'),
(3, '927621bcs003', 'Sabari', 'COKE', 50, 1, '2023-10-12'),
(4, '927621bcs003', 'Sabari', 'COKE', 50, 1, '2023-10-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  ADD PRIMARY KEY (`USERNAME`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`INVOICE_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_name` (`product_name`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`VOUCHER_NUMBER`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `INVOICE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `VOUCHER_NUMBER` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `no` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
