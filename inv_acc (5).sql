-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 04:51 PM
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
-- Database: `inv&acc`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `acc_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `userType` varchar(100) NOT NULL,
  `createdAt` datetime NOT NULL,
  `status` varchar(100) NOT NULL,
  `verification_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`acc_id`, `email`, `password`, `userType`, `createdAt`, `status`, `verification_code`) VALUES
(1, 'ronraguero@gmail.com', '$2y$10$H2eJHDtr7G6kjE.A2tF1A.iuiR5bbSJoEQ8Mh4qYjH7l6IU4eIC.i', 'user', '2024-09-01 20:53:47', 'verified', 0),
(13, '07107997@dwc-legazpi.edu', '$2y$10$3o56PYCd8mjttimK6ahvUOGbXoOvy2Y/cvHQZ/z84J2ZkXa.zmfhW', 'user', '2024-09-04 13:04:20', 'verified', 0),
(14, '07109568@dwc-legazpi.edu', '$2y$10$7Nf1LIqPjQsiy148dda2iOyszhC5vUN9bITakiIB2fxZ8iHsoFkSS', 'admin', '2024-09-04 13:26:56', 'verified', 0),
(25, 'ronalynco364@gmail.com', '$2y$10$bUfQic6pWU0aghSZybAYceb.8TI5pg7oeKica4jUcnxGnv//fLMQu', 'supply_manager', '2024-10-08 03:08:21', 'verified', 0),
(26, 'george@gmail.com', '$2y$10$cU3dMGwgYOxQ6obNJR1c9eMHhIvWQnQeU/JJCchfC6aYNTZDhSgVe', 'user', '2024-10-09 20:24:15', 'verified', 0),
(27, 'johnrey@gmail.com', '$2y$10$gi7BxTpdRNZhHL3x0Zx.M.dXO22M6M4ncyNlc0FRdUsG8QgQQIhCm', 'user', '2024-10-09 20:29:17', 'verified', 0),
(28, 'chano@gmail.com', '$2y$10$tla8.PLn3Gk1ata1gPNE4ukNftKTvxWjStPXcAIg3qaWLdTCbwN0q', 'user', '2024-10-09 20:39:16', 'verified', 0),
(29, 'gago@gmail.com', '$2y$10$sAF.93YlSg8nI50yCKbMx.n4Fwx9v0oGezATQGBkyqnQOg98ZydCe', 'admin', '2024-10-10 02:08:06', 'verified', 0),
(30, 'carl@gmail.com', '$2y$10$4NT4WMjbF.Z8fd9n.tggSuEOYPYa/chLZ0YHh2Vncyl0hT.2TRlY.', 'admin', '2024-10-10 02:18:39', 'verified', 0),
(31, 'rave@gmail.com', '$2y$10$1Cm46ArFiI0b5avoCa4HieY55qY2myP1Pp1pi1P5MBfhlM.XtiJDS', 'admin', '2024-10-10 02:29:46', 'verified', 0),
(32, 'nica@gmail.com', '$2y$10$DeAc0bX9ozFassZehdJdJuduNtVllSV322osU4wm97zjXqn81o2ZS', 'user', '2024-10-10 02:44:49', 'verified', 0),
(33, 'paolo_llona@gmaail.com', '$2y$10$lf2ycBtK3csagl6NI9XXnOaOWTN.xDOYCrG0NXsxoB26df0RdQ/0a', '666', '2024-10-25 18:30:33', 'pending', 585930),
(34, 'gazylle@gmail.com', '$2y$10$lckEOp6fAo0XYNBSGTAZbemJR/EFwaIYdtgs.ks/0drs5LrvFO3fC', 'user', '2024-10-29 16:43:40', 'verified', 0),
(35, 'gazylle@gmail.com', '$2y$10$fSwl02fCg6GZ2x5l2/tK1OVKJz6IODuXYvMYJ25FCMUbG4/8u5j1m', 'user', '2024-11-12 03:13:48', 'pending', 127192),
(36, 'gazylle@gmail.com', '$2y$10$kpJxf/fWkO0BkAr83oAdSevM6SxpsTKnGYfv.N1BrZ5nb/uv0kI4e', 'user', '2024-11-12 03:14:47', 'pending', 680184),
(37, 'gazylle@gmail.com', '$2y$10$XfIS6wCRJiHCRoZbQ0RWP.R/QuiQ3mL.d5RLiPjboggzl85IIYehG', 'user', '2024-11-12 03:15:45', 'pending', 786798),
(38, 'kent@gmail.com', '$2y$10$me5NQ4H1UjZBTgwGUhjK9uI6kyFMsge4B.l7gkRZE/PbDggUywpOq', 'supply_manager', '2024-11-15 05:49:11', 'verified', 0);

-- --------------------------------------------------------

--
-- Table structure for table `asset_request`
--

CREATE TABLE `asset_request` (
  `assetRequestId` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time(6) NOT NULL,
  `status` varchar(100) NOT NULL,
  `officeDepartment` int(100) NOT NULL,
  `requestedBy` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_request_detail`
--

CREATE TABLE `asset_request_detail` (
  `assetRequestDetailId` int(11) NOT NULL,
  `controlNo` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `description` text NOT NULL,
  `amount` varchar(100) NOT NULL,
  `assetRequestId` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentID` int(11) NOT NULL,
  `departmentName` varchar(100) NOT NULL,
  `campus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentID`, `departmentName`, `campus`) VALUES
(1, 'SOECS', 'North'),
(2, 'fbfbfdb', 'South'),
(3, 'SBMA', 'South'),
(4, 'accounting', 'South');

-- --------------------------------------------------------

--
-- Table structure for table `department_head`
--

CREATE TABLE `department_head` (
  `departmentHeadID` int(11) NOT NULL,
  `userID` int(100) NOT NULL,
  `departmentID` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_head`
--

INSERT INTO `department_head` (`departmentHeadID`, `userID`, `departmentID`) VALUES
(1, 1, 3),
(4, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_request`
--

CREATE TABLE `inventory_request` (
  `inventoryReqID` int(11) NOT NULL,
  `reqDate` date NOT NULL,
  `reqTime` time(6) NOT NULL,
  `requestStatus` varchar(100) NOT NULL,
  `requestedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_request`
--

INSERT INTO `inventory_request` (`inventoryReqID`, `reqDate`, `reqTime`, `requestStatus`, `requestedBy`) VALUES
(1, '2024-09-29', '20:29:47.000000', 'Pending', 1),
(2, '2024-09-29', '20:38:03.000000', 'Pending', 1),
(3, '2024-09-29', '20:47:00.000000', 'Pending', 1),
(4, '2024-09-29', '20:47:50.000000', 'Pending', 1),
(5, '2024-09-29', '21:41:00.000000', 'Pending', 1),
(6, '2024-09-29', '01:10:57.000000', 'Pending', 1);

-- --------------------------------------------------------

--
-- Table structure for table `issuance_request`
--

CREATE TABLE `issuance_request` (
  `issuanceRequestID` int(11) NOT NULL,
  `reqStatus` varchar(100) NOT NULL,
  `reqIssuanceDateStart` date NOT NULL,
  `reqIssuanceDateEnd` date NOT NULL,
  `reqIssuancePurpose` text NOT NULL,
  `reqOtherPurposeDetails` varchar(100) NOT NULL,
  `reqLoggedDate` date NOT NULL,
  `reqLoggedTime` time(6) NOT NULL,
  `reqIssuedTo` int(100) NOT NULL,
  `reqItemNo` int(100) NOT NULL,
  `reqBy` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issuance_request`
--

INSERT INTO `issuance_request` (`issuanceRequestID`, `reqStatus`, `reqIssuanceDateStart`, `reqIssuanceDateEnd`, `reqIssuancePurpose`, `reqOtherPurposeDetails`, `reqLoggedDate`, `reqLoggedTime`, `reqIssuedTo`, `reqItemNo`, `reqBy`) VALUES
(7, 'Approved', '2024-10-09', '2024-10-30', 'Official Use, Others', 'jdbvbdv', '2024-10-09', '12:15:14.000000', 1, 1, 1),
(11, 'Approved', '2024-10-09', '2024-10-31', 'Official Use, Others', 'jgbjj', '2024-10-09', '13:01:39.000000', 1, 3, 1),
(12, 'Pending', '2024-10-09', '2024-10-30', 'Official Use, Others', 'dfbkbkbfn', '2024-10-09', '13:04:59.000000', 1, 3, 1),
(13, 'Pending', '2024-10-09', '2024-10-30', 'Replacement, Others', 'kjbj', '2024-10-09', '13:10:28.000000', 6, 1, 1),
(14, 'Pending', '2024-10-09', '2024-10-30', 'Event Support, Others', 'dgsnk', '2024-10-09', '13:32:00.000000', 6, 1, 1),
(15, 'Pending', '2024-10-09', '2024-10-30', 'Event Support, Others', 'dgsnk', '2024-10-09', '13:32:00.000000', 6, 4, 1),
(16, 'Pending', '2024-10-09', '2024-10-31', 'Official Use, Others', 'jkbjb', '2024-10-09', '13:39:49.000000', 1, 1, 1),
(17, 'Pending', '2024-10-09', '2024-10-09', 'Event Support, Others', 'hjdjhkjd', '2024-10-09', '13:51:54.000000', 1, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `issuance_review`
--

CREATE TABLE `issuance_review` (
  `issuanceReviewID` int(11) NOT NULL,
  `issuanceReviewNo` int(100) NOT NULL,
  `date` int(100) NOT NULL,
  `time` time(6) NOT NULL,
  `quantity` int(100) NOT NULL,
  `itemDescription` varchar(100) NOT NULL,
  `refNo` int(100) NOT NULL,
  `unitPrice` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `issuedBy` int(100) NOT NULL,
  `issuedByDate` date DEFAULT NULL,
  `receivedBy` int(100) NOT NULL,
  `receivedByDate` date DEFAULT NULL,
  `postedBy` int(100) NOT NULL,
  `postedByDate` date NOT NULL,
  `status` varchar(100) NOT NULL,
  `department` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issuance_review`
--

INSERT INTO `issuance_review` (`issuanceReviewID`, `issuanceReviewNo`, `date`, `time`, `quantity`, `itemDescription`, `refNo`, `unitPrice`, `amount`, `issuedBy`, `issuedByDate`, `receivedBy`, `receivedByDate`, `postedBy`, `postedByDate`, `status`, `department`) VALUES
(1, 1, 2024, '06:02:09.000000', 0, '', 0, '', '', 6, '0000-00-00', 10, '0000-00-00', 10, '2024-11-19', 'In Process', 1),
(2, 2, 2024, '01:14:14.000000', 3, 'jsbgbvjs', 1001, '200', '600', 6, '0000-00-00', 10, '0000-00-00', 10, '2024-11-19', 'In Process', 1),
(3, 2, 2024, '01:14:14.000000', 1, 'kdnlkb', 1000, '200', '200', 6, '0000-00-00', 10, '0000-00-00', 10, '2024-11-19', 'In Process', 1);

-- --------------------------------------------------------

--
-- Table structure for table `issuance_reviewer`
--

CREATE TABLE `issuance_reviewer` (
  `issuanceReviewerID` int(11) NOT NULL,
  `authority` varchar(100) NOT NULL,
  `userID` int(100) NOT NULL,
  `departmentID` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issuance_reviewer`
--

INSERT INTO `issuance_reviewer` (`issuanceReviewerID`, `authority`, `userID`, `departmentID`) VALUES
(1, 'departmentOnly', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemNo` int(11) NOT NULL,
  `itemCode` int(100) NOT NULL,
  `itemName` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `dateAcquired` varchar(100) NOT NULL,
  `unitValue` varchar(100) NOT NULL,
  `totalValue` varchar(100) NOT NULL,
  `image` varchar(500) NOT NULL,
  `category` varchar(100) NOT NULL,
  `loggedAt` datetime(6) NOT NULL,
  `loggedBy` int(100) NOT NULL,
  `itemReviewNo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemNo`, `itemCode`, `itemName`, `description`, `quantity`, `dateAcquired`, `unitValue`, `totalValue`, `image`, `category`, `loggedAt`, `loggedBy`, `itemReviewNo`) VALUES
(1, 1000, 'fgfg', 'ggfxsrf', '1', '2024', '6', '12', 'academic_departments.png', 'Office Supplies', '2024-09-30 01:12:47.000000', 7, NULL),
(2, 1000, 'hhh', 'hhvvhv', '1', '2024', '3', '3', 'academic_departments.png', 'Office Supplies', '2024-09-30 01:13:49.000000', 7, NULL),
(3, 1006, 'cvdsdsv', 'reehbr', '1', '2024', '6', '6', 'academic_departments.png', 'Office Supplies', '2024-09-30 01:23:00.000000', 7, NULL),
(4, 1007, 'fdbfdbdfbd', 'gfn gf nfggf', '1', '2024', '6', '6', 'academic_departments.png', 'Office Supplies', '2024-09-30 01:25:12.000000', 7, NULL),
(5, 1008, 'fdbdf', 'dfbfd', '1', '2024', '6', '6', 'academic_departments.png', 'Furniture', '2024-09-30 01:26:22.000000', 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_review`
--

CREATE TABLE `item_review` (
  `itemReviewNo` int(11) NOT NULL,
  `itemReviewCode` int(100) NOT NULL,
  `itemReviewName` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `dateAcquired` date NOT NULL,
  `unitValue` varchar(100) NOT NULL,
  `totalValue` varchar(100) NOT NULL,
  `image` varchar(500) NOT NULL,
  `category` varchar(100) NOT NULL,
  `loggedAt` datetime(6) NOT NULL,
  `loggedBy` int(100) NOT NULL,
  `inventoryReqID` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_review`
--

INSERT INTO `item_review` (`itemReviewNo`, `itemReviewCode`, `itemReviewName`, `description`, `quantity`, `dateAcquired`, `unitValue`, `totalValue`, `image`, `category`, `loggedAt`, `loggedBy`, `inventoryReqID`) VALUES
(1, 0, 'dffdf', 'ggbbnrt', '1', '0000-00-00', '6', '6', 'academic_departments.png', 'Office Supplies', '2024-09-29 20:29:47.000000', 1, 1),
(2, 0, 'gbghg', 'tyhtty', '1', '0000-00-00', '5', '5', 'academic_departments.png', 'Office Supplies', '2024-09-29 20:38:03.000000', 1, 2),
(3, 1000, 'dffdf', 'tbbht', '1', '0000-00-00', '6', '6', 'academic_departments.png', 'Office Supplies', '2024-09-29 20:47:00.000000', 1, 3),
(4, 1001, 'bfdbgdf', 'dfgbd', '2', '0000-00-00', '3', '6', 'academic_departments.png', 'Office Supplies', '2024-09-29 20:47:50.000000', 1, 4),
(5, 1002, 'bfdbgdf', 'dfgbd', '2', '0000-00-00', '3', '6', 'academic_departments.png', 'Office Supplies', '2024-09-29 20:47:50.000000', 1, 4),
(6, 1003, 'b vbnv', 'gfngfngf', '1', '0000-00-00', '5', '5', 'academic_departments.png', 'Office Supplies', '2024-09-29 21:41:00.000000', 1, 5),
(7, 1004, 'fgfg', 'fngfnf', '2', '0000-00-00', '6', '12', 'academic_departments.png', 'Office Supplies', '2024-09-30 01:10:58.000000', 1, 6),
(8, 1005, 'fgfg', 'fngfnf', '2', '0000-00-00', '6', '12', 'academic_departments.png', 'Office Supplies', '2024-09-30 01:10:58.000000', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `property_issuance`
--

CREATE TABLE `property_issuance` (
  `issuanceID` int(11) NOT NULL,
  `issuanceDateStart` varchar(100) NOT NULL,
  `issuanceDateEnd` varchar(100) NOT NULL,
  `issuancePurpose` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `loggedDate` date NOT NULL,
  `loggedTime` time(6) NOT NULL,
  `issuedTo` int(100) NOT NULL,
  `issuedBy` int(100) NOT NULL,
  `itemNo` int(100) NOT NULL,
  `issuanceRequestID` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_issuance`
--

INSERT INTO `property_issuance` (`issuanceID`, `issuanceDateStart`, `issuanceDateEnd`, `issuancePurpose`, `status`, `loggedDate`, `loggedTime`, `issuedTo`, `issuedBy`, `itemNo`, `issuanceRequestID`) VALUES
(1, '2024-10-09', '2024-10-30', 'Official Use, Others', 'Approved', '2024-10-09', '12:15:14.000000', 1, 1, 1, 7),
(2, '2024-10-09', '2024-10-31', 'Official Use, Others', 'Approved', '2024-10-09', '13:01:39.000000', 1, 1, 3, 11);

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE `time` (
  `issuanceReviewID` int(11) NOT NULL,
  `issuance_reviewNo` int(100) NOT NULL,
  `date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_description` int(11) NOT NULL,
  `refNo` int(11) NOT NULL,
  `unitPrice` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `issuedBy` int(11) NOT NULL,
  `issuedByDate` int(11) NOT NULL,
  `receivedBy` int(11) NOT NULL,
  `receivedByDate` int(11) NOT NULL,
  `postedBy` int(11) NOT NULL,
  `postedByDate` int(11) NOT NULL,
  `department` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `middleName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `phoneNo` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `userImage` varchar(100) NOT NULL,
  `createdAt` datetime(6) NOT NULL,
  `department` int(100) NOT NULL,
  `acc_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `firstName`, `middleName`, `lastName`, `address`, `birthdate`, `phoneNo`, `position`, `userImage`, `createdAt`, `department`, `acc_id`) VALUES
(1, 'isagani', 'rthh', 'thtrh', 'rsdvsd', '2024-09-02', '09508568', 'managercscsc', 'profile_66d728ff9ec1f.jpg', '2024-09-03 23:19:27.000000', 1, 1),
(6, 'Olyvic', 'Acuna', 'Potinoza', 'rsdvsd', '2024-09-02', '09508568', 'Manager', 'profile_66d7eb43e7d34.jpg', '2024-09-04 13:08:19.000000', 1, 13),
(7, 'Ron', 'api', 'raguero', 'rsdvsd', '2024-09-04', '09508568', 'Manager', 'profile_66d728ff9ec1f.jpg', '2024-09-04 13:31:55.000000', 1, 14),
(8, 'ronalyn', 'gp', 'Co', '', '2024-09-04', '09508568', 'Manager', 'profile_6704320e7f0e3.jpg', '2024-10-08 03:10:06.000000', 1, 25),
(9, 'George', 'Pogi', 'Literal', 'Daraga, Albay', '2024-09-16', '09096738726', 'Instructor', 'profile_670676e834fb7.jpg', '2024-10-09 20:28:24.000000', 1, 26),
(10, 'John Rey', 'Sopot', 'Dado', 'Legazpi City', '2024-09-16', '0977678573', 'Instructor', 'profile_67067895493e1.jpg', '2024-10-09 20:35:33.000000', 1, 27),
(11, 'John Rey', 'Sopot', 'Dado', 'Legazpi City', '2024-09-16', '0977678573', 'Instructor', 'profile_67067a7887a7d.jpg', '2024-10-09 20:43:36.000000', 1, 28),
(12, 'gago', 'gago', 'gago', 'Legazpi City', '2024-09-16', '0977678573', 'Instructor', 'profile_6706c6fe2217a.jpg', '2024-10-10 02:10:06.000000', 1, 29),
(13, 'carl', 'carl', 'carl', 'Legazpi City', '2024-09-16', '0977678573', 'Instructor', 'profile_6706c9332ab24.jpg', '2024-10-10 02:19:31.000000', 1, 30),
(14, 'carl', 'carl', 'carl', 'Legazpi City', '2024-09-16', '0977678573', 'Instructor', 'profile_6706cc3bc41a9.jpg', '2024-10-10 02:32:27.000000', 1, 31),
(15, 'Nica', 'carl', 'Njfdbf', 'Legazpi City', '2024-09-16', '0977678573', 'Instructor', 'profile_6706d0fd8f3e9.jpg', '2024-10-10 02:52:45.000000', 1, 32),
(16, 'Kent', 'P.', 'Malibog', 'Legazpi City', '1997-03-16', '0977678573', 'Instructor', 'profile_6736722a0fba5.jpg', '2024-11-15 05:56:58.000000', 3, 38);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `asset_request`
--
ALTER TABLE `asset_request`
  ADD PRIMARY KEY (`assetRequestId`),
  ADD KEY `requestedBy` (`requestedBy`),
  ADD KEY `officeDepartment` (`officeDepartment`);

--
-- Indexes for table `asset_request_detail`
--
ALTER TABLE `asset_request_detail`
  ADD PRIMARY KEY (`assetRequestDetailId`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentID`);

--
-- Indexes for table `department_head`
--
ALTER TABLE `department_head`
  ADD PRIMARY KEY (`departmentHeadID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `departmentID` (`departmentID`);

--
-- Indexes for table `inventory_request`
--
ALTER TABLE `inventory_request`
  ADD PRIMARY KEY (`inventoryReqID`);

--
-- Indexes for table `issuance_request`
--
ALTER TABLE `issuance_request`
  ADD PRIMARY KEY (`issuanceRequestID`),
  ADD KEY `reqItemNo` (`reqItemNo`),
  ADD KEY `reqIssuedTo` (`reqIssuedTo`),
  ADD KEY `reqBy` (`reqBy`);

--
-- Indexes for table `issuance_review`
--
ALTER TABLE `issuance_review`
  ADD PRIMARY KEY (`issuanceReviewID`),
  ADD KEY `issuanceBy` (`issuedBy`),
  ADD KEY `receivedBy` (`receivedBy`),
  ADD KEY `department` (`department`);

--
-- Indexes for table `issuance_reviewer`
--
ALTER TABLE `issuance_reviewer`
  ADD PRIMARY KEY (`issuanceReviewerID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `departmentID` (`departmentID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemNo`),
  ADD KEY `loggedBy` (`loggedBy`),
  ADD KEY `item_ibfk_2` (`itemReviewNo`);

--
-- Indexes for table `item_review`
--
ALTER TABLE `item_review`
  ADD PRIMARY KEY (`itemReviewNo`),
  ADD KEY `loggedBy` (`loggedBy`),
  ADD KEY `inventoryReqID` (`inventoryReqID`);

--
-- Indexes for table `property_issuance`
--
ALTER TABLE `property_issuance`
  ADD PRIMARY KEY (`issuanceID`),
  ADD KEY `issuedTo` (`issuedTo`),
  ADD KEY `issuedBy` (`issuedBy`),
  ADD KEY `issuanceRequestID` (`issuanceRequestID`),
  ADD KEY `itemNo` (`itemNo`);

--
-- Indexes for table `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`issuanceReviewID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `acc_id` (`acc_id`),
  ADD KEY `department` (`department`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `asset_request`
--
ALTER TABLE `asset_request`
  MODIFY `assetRequestId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_request_detail`
--
ALTER TABLE `asset_request_detail`
  MODIFY `assetRequestDetailId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `department_head`
--
ALTER TABLE `department_head`
  MODIFY `departmentHeadID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory_request`
--
ALTER TABLE `inventory_request`
  MODIFY `inventoryReqID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `issuance_request`
--
ALTER TABLE `issuance_request`
  MODIFY `issuanceRequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `issuance_review`
--
ALTER TABLE `issuance_review`
  MODIFY `issuanceReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `issuance_reviewer`
--
ALTER TABLE `issuance_reviewer`
  MODIFY `issuanceReviewerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `itemNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item_review`
--
ALTER TABLE `item_review`
  MODIFY `itemReviewNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `property_issuance`
--
ALTER TABLE `property_issuance`
  MODIFY `issuanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `time`
--
ALTER TABLE `time`
  MODIFY `issuanceReviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asset_request`
--
ALTER TABLE `asset_request`
  ADD CONSTRAINT `asset_request_ibfk_1` FOREIGN KEY (`requestedBy`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_request_ibfk_2` FOREIGN KEY (`officeDepartment`) REFERENCES `department` (`departmentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `department_head`
--
ALTER TABLE `department_head`
  ADD CONSTRAINT `department_head_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `department_head_ibfk_2` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `issuance_request`
--
ALTER TABLE `issuance_request`
  ADD CONSTRAINT `issuance_request_ibfk_1` FOREIGN KEY (`reqItemNo`) REFERENCES `item` (`itemNo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issuance_request_ibfk_2` FOREIGN KEY (`reqIssuedTo`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issuance_request_ibfk_3` FOREIGN KEY (`reqBy`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `issuance_review`
--
ALTER TABLE `issuance_review`
  ADD CONSTRAINT `issuance_review_ibfk_1` FOREIGN KEY (`issuedBy`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issuance_review_ibfk_2` FOREIGN KEY (`receivedBy`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issuance_review_ibfk_3` FOREIGN KEY (`department`) REFERENCES `department` (`departmentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `issuance_reviewer`
--
ALTER TABLE `issuance_reviewer`
  ADD CONSTRAINT `issuance_reviewer_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issuance_reviewer_ibfk_2` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`loggedBy`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`itemReviewNo`) REFERENCES `item_review` (`itemReviewNo`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `item_review`
--
ALTER TABLE `item_review`
  ADD CONSTRAINT `item_review_ibfk_1` FOREIGN KEY (`loggedBy`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_review_ibfk_2` FOREIGN KEY (`inventoryReqID`) REFERENCES `inventory_request` (`inventoryReqID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `property_issuance`
--
ALTER TABLE `property_issuance`
  ADD CONSTRAINT `property_issuance_ibfk_1` FOREIGN KEY (`issuedTo`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `property_issuance_ibfk_2` FOREIGN KEY (`issuedBy`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `property_issuance_ibfk_3` FOREIGN KEY (`issuanceRequestID`) REFERENCES `issuance_request` (`issuanceRequestID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `property_issuance_ibfk_4` FOREIGN KEY (`itemNo`) REFERENCES `item` (`itemNo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `account` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`department`) REFERENCES `department` (`departmentID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
