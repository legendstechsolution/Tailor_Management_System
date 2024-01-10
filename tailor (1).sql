-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2024 at 12:57 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tailor`
--

-- --------------------------------------------------------

--
-- Table structure for table `manage_order`
--

CREATE TABLE `manage_order` (
  `ID` int(100) NOT NULL,
  `ORDER DATE` date NOT NULL,
  `ORDER NUMBER` int(11) NOT NULL,
  `JC NO` int(100) NOT NULL,
  `FUNCTION NAME` varchar(100) NOT NULL,
  `FUNCTION DATE` date NOT NULL,
  `PERSON NAME` varchar(100) NOT NULL,
  `SELVAN` varchar(100) NOT NULL,
  `SELVI` varchar(100) NOT NULL,
  `PLACE` varchar(100) NOT NULL,
  `MOBILE NUMBER` int(100) NOT NULL,
  `ITEM NAME` varchar(100) NOT NULL,
  `SIZE` int(100) NOT NULL,
  `MODEL` varchar(100) NOT NULL,
  `EXTRA DETAIL` varchar(100) NOT NULL,
  `HANDLE` varchar(100) NOT NULL,
  `PRINTING COLOR` varchar(100) NOT NULL,
  `SIDE PATTI COLOR` varchar(100) NOT NULL,
  `ORDER QTY` int(100) NOT NULL,
  `RATE` int(100) NOT NULL,
  `DTP CHARGES` varchar(100) NOT NULL,
  `GST%` varchar(100) NOT NULL,
  `ADVANCE` varchar(100) NOT NULL,
  `DISCOUNT` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manage_order`
--

INSERT INTO `manage_order` (`ID`, `ORDER DATE`, `ORDER NUMBER`, `JC NO`, `FUNCTION NAME`, `FUNCTION DATE`, `PERSON NAME`, `SELVAN`, `SELVI`, `PLACE`, `MOBILE NUMBER`, `ITEM NAME`, `SIZE`, `MODEL`, `EXTRA DETAIL`, `HANDLE`, `PRINTING COLOR`, `SIDE PATTI COLOR`, `ORDER QTY`, `RATE`, `DTP CHARGES`, `GST%`, `ADVANCE`, `DISCOUNT`) VALUES
(13, '2023-10-12', 65, 12, 'tight fit', '2023-10-19', 'ranjith', 'RANJITH', 'porani', 'cuddalore', 2147483647, 'shirt', 33, 's', 'tight fit', 'neck', 'red', 'white', 9, 12, '12', '12', '12', '12'),
(14, '2023-10-12', 12, 12, 'tight fit', '2023-10-20', 'satheesh.s', 'kannan', 'devi', 'cuddalore', 2147483647, 'shirt', 33, 's', 'tight fit', 'neck', 'red', 'white', 0, 12, '12', '12', '24', '12'),
(21, '2023-10-13', 33, 12, 'tight fit', '2023-10-12', 'satheesh', 'SATHEESH', 'SATHEESH', 'cuddalore', 2147483647, 'shirt', 33, 's', 'tight fit', 'neck', 'red', 'white', 0, 12, '12', '10', '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `manage_staff`
--

CREATE TABLE `manage_staff` (
  `ID` int(100) NOT NULL,
  `Name` varchar(500) NOT NULL,
  `Email` varchar(500) NOT NULL,
  `Phone_Number` varchar(500) NOT NULL,
  `Password` varchar(500) NOT NULL,
  `Address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manage_staff`
--

INSERT INTO `manage_staff` (`ID`, `Name`, `Email`, `Phone_Number`, `Password`, `Address`) VALUES
(5, 'admin', 'admin@gmail.com', '09344010212', '1234', '18, Kathirvel nagar , CRC road'),
(6, 'sathiyam', 'sathiyam@gmail.com', '9361877853', '1234', 'ewwrr');

-- --------------------------------------------------------

--
-- Table structure for table `manage_tailor`
--

CREATE TABLE `manage_tailor` (
  `ID` int(11) NOT NULL,
  `Name` varchar(500) NOT NULL,
  `Email` varchar(500) NOT NULL,
  `Phone_Number` int(11) NOT NULL,
  `Address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manage_tailor`
--

INSERT INTO `manage_tailor` (`ID`, `Name`, `Email`, `Phone_Number`, `Address`) VALUES
(4, 'suresh', 'suresh@gmail.com', 2147483647, 'no:18 ,vinnaya,chennai-206102.'),
(5, 'kannan', 'suresh@gmail.com', 2147483647, 'no:18 ,vinnaya,chennai-206102.');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `tailorId` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `paymentmode` varchar(255) DEFAULT NULL,
  `createddate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `tailorId`, `order_id`, `payment_date`, `amount`, `paymentmode`, `createddate`) VALUES
(1, 4, 33, '2023-10-07', 24.00, 'gpay', '2023-10-20 05:35:37'),
(2, 4, 33, '2023-10-14', 24.00, 'gpay', '2023-10-20 05:38:36');

-- --------------------------------------------------------

--
-- Table structure for table `tailor_assign`
--

CREATE TABLE `tailor_assign` (
  `id` int(11) NOT NULL,
  `assignment_date` date DEFAULT NULL,
  `tailor_id` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_no` int(11) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tailor_assign`
--

INSERT INTO `tailor_assign` (`id`, `assignment_date`, `tailor_id`, `created_date`, `order_no`, `rate`, `quantity`) VALUES
(1, '2023-10-12', 4, '2023-10-19 14:35:05', 33, 2.00, 12),
(2, '2023-10-14', 4, '2023-10-19 15:18:21', 65, 2.00, 12),
(3, '2023-10-07', 5, '2023-10-19 15:20:02', 65, 1.00, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manage_order`
--
ALTER TABLE `manage_order`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `constraint_name` (`ORDER NUMBER`);

--
-- Indexes for table `manage_staff`
--
ALTER TABLE `manage_staff`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `manage_tailor`
--
ALTER TABLE `manage_tailor`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tailor_assign`
--
ALTER TABLE `tailor_assign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_no` (`order_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manage_order`
--
ALTER TABLE `manage_order`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `manage_staff`
--
ALTER TABLE `manage_staff`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `manage_tailor`
--
ALTER TABLE `manage_tailor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tailor_assign`
--
ALTER TABLE `tailor_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tailor_assign`
--
ALTER TABLE `tailor_assign`
  ADD CONSTRAINT `tailor_assign_ibfk_1` FOREIGN KEY (`order_no`) REFERENCES `manage_order` (`ORDER NUMBER`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
