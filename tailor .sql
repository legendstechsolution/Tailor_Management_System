-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2023 at 04:15 PM
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
  `ORDER NUMBER` varchar(255) NOT NULL,
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
  `DISCOUNT` varchar(100) NOT NULL,
  `final_amount_paid` varchar(255) NOT NULL,
  `advancepaid` varchar(250) NOT NULL,
  `finalpaid` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manage_order`
--

INSERT INTO `manage_order` (`ID`, `ORDER DATE`, `ORDER NUMBER`, `JC NO`, `FUNCTION NAME`, `FUNCTION DATE`, `PERSON NAME`, `SELVAN`, `SELVI`, `PLACE`, `MOBILE NUMBER`, `ITEM NAME`, `SIZE`, `MODEL`, `EXTRA DETAIL`, `HANDLE`, `PRINTING COLOR`, `SIDE PATTI COLOR`, `ORDER QTY`, `RATE`, `DTP CHARGES`, `GST%`, `ADVANCE`, `DISCOUNT`, `final_amount_paid`, `advancepaid`, `finalpaid`) VALUES
(50, '2023-10-05', '22', 22, 'tight fit', '2023-10-27', 'satheesh.s', 'SATHEESH', 'devi', 'cuddalore', 2147483647, 'shirt', 33, 's', 'tight fit', 'neck', 'red', 'white', 22, 12, '1', '1', '1', '1', '', 'atm', 'gpay'),
(51, '2023-10-05', '65', 0, '', '0000-00-00', '', '', '', '', 0, '', 0, '', '', '', '', '', 15, 2, '', '', '', '', '', '', ''),
(53, '0000-00-00', '12', 0, '', '0000-00-00', '', '', '', '', 0, '', 0, '', '', '', '', '', 12, 2, '', '', '', '', '', '', ''),
(54, '0000-00-00', '12AB', 0, '', '0000-00-00', '', '', '', '', 0, '', 0, '', '', '', '', '', 12, 100, '', '', '', '', '', '', '');

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
(11, 'admin', 'admin@gmail.com', '9361877853', '1234', 'address');

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
(4, 'david', 'david@gmail.com', 2147483647, 'no:18 ,vinnaya,-206102.'),
(5, 'kannan', 'suresh@gmail.com', 2147483647, 'no:18 ,vinnaya,chennai-206102.'),
(6, 'ramesh', 'suresh@gmail.com', 2147483647, 'no:18 ,vinnaya,chennai-206102.');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `assignid` int(11) NOT NULL,
  `tailorId` int(11) DEFAULT NULL,
  `order_id` varchar(10) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `paymentmode` varchar(255) DEFAULT NULL,
  `createddate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `assignid`, `tailorId`, `order_id`, `payment_date`, `amount`, `paymentmode`, `createddate`) VALUES
(362, 0, 5, '22', '2023-10-20', 1.00, 'gpay', '2023-10-30'),
(363, 0, 6, '12AB', '2023-10-20', 1.00, 'gpay', '2023-10-30');

-- --------------------------------------------------------

--
-- Table structure for table `tailor_assign`
--

CREATE TABLE `tailor_assign` (
  `id` int(11) NOT NULL,
  `assignment_date` date DEFAULT NULL,
  `tailor_id` int(11) DEFAULT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp(),
  `rate` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `order_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tailor_assign`
--

INSERT INTO `tailor_assign` (`id`, `assignment_date`, `tailor_id`, `created_date`, `rate`, `quantity`, `order_no`) VALUES
(21, '2023-10-14', 6, '2023-10-30', 2.00, 12, '12AB'),
(22, '2023-10-13', 5, '2023-10-30', 2.00, 12, '22');

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
  ADD KEY `FOREIGN KEY` (`order_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manage_order`
--
ALTER TABLE `manage_order`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `manage_staff`
--
ALTER TABLE `manage_staff`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `manage_tailor`
--
ALTER TABLE `manage_tailor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=365;

--
-- AUTO_INCREMENT for table `tailor_assign`
--
ALTER TABLE `tailor_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tailor_assign`
--
ALTER TABLE `tailor_assign`
  ADD CONSTRAINT `FOREIGN KEY` FOREIGN KEY (`order_no`) REFERENCES `manage_order` (`ORDER NUMBER`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
