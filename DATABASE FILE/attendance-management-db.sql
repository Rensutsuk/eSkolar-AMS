-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2023 at 06:53 AM
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
-- Database: `attendance-management-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`) VALUES
(1, 'Admin', '', 'admin@mail.com', 'D00F5D5217896FB7FD601412CB890830');

-- --------------------------------------------------------

--
-- Table structure for table `tblattendance`
--

CREATE TABLE `tblattendance` (
  `Id` int(10) NOT NULL,
  `admissionNo` varchar(255) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmId` varchar(10) NOT NULL,
  `sessionTermId` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `dateTimeTaken` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblattendance`
--

INSERT INTO `tblattendance` (`Id`, `admissionNo`, `classId`, `classArmId`, `sessionTermId`, `status`, `dateTimeTaken`) VALUES
(38, 'AMS-2023-7942', '1', '1', '4', '0', '2023-07-25'),
(37, 'AMS-2023-5736', '1', '1', '4', '0', '2023-07-25'),
(36, 'AMS-2023-8553', '1', '1', '4', '0', '2023-07-25'),
(35, 'AMS-2023-8464', '1', '1', '4', '0', '2023-07-25'),
(34, 'AMS-2023-2540', '1', '1', '4', '1', '2023-07-25'),
(33, 'AMS-2023-2770', '1', '1', '4', '1', '2023-07-25'),
(32, 'AMS-2023-6261', '1', '1', '4', '1', '2023-07-25'),
(31, 'AMS-2023-4006', '1', '1', '4', '1', '2023-07-25'),
(30, 'AMS-2023-5441', '1', '1', '4', '1', '2023-07-25'),
(29, 'AMS-2023-1313', '1', '1', '4', '1', '2023-07-25'),
(28, 'AMS-2023-4059', '1', '1', '4', '1', '2023-07-25'),
(27, 'AMS-2023-9576', '1', '1', '4', '1', '2023-07-25');

-- --------------------------------------------------------

--
-- Table structure for table `tblclass`
--

CREATE TABLE `tblclass` (
  `Id` int(10) NOT NULL,
  `className` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclass`
--

INSERT INTO `tblclass` (`Id`, `className`) VALUES
(1, '1-01'),
(2, '1-02'),
(3, '1-03'),
(4, '2-01'),
(5, '2-02'),
(6, '2-03'),
(7, '3-01'),
(8, '3-02'),
(9, '3-03'),
(32, '4-01');

-- --------------------------------------------------------

--
-- Table structure for table `tblclassarms`
--

CREATE TABLE `tblclassarms` (
  `Id` int(10) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmName` varchar(255) NOT NULL,
  `isAssigned` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclassarms`
--

INSERT INTO `tblclassarms` (`Id`, `classId`, `classArmName`, `isAssigned`) VALUES
(1, '1', 'Mathematics', 'Yes'),
(2, '2', 'English Literature', 'Yes'),
(3, '3', 'Computer Science', 'Yes'),
(4, '4', 'History', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tblclassteacher`
--

CREATE TABLE `tblclassteacher` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phoneNo` varchar(50) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmId` varchar(10) NOT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclassteacher`
--

INSERT INTO `tblclassteacher` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`, `phoneNo`, `classId`, `classArmId`, `dateCreated`) VALUES
(1, 'John', 'Doe', 'johndoe@gmail.com', '32250170a0dca92d53ec9624f336ca24', '09123456789', '1', '1', '2023-07-20'),
(2, 'Jane', 'Smith', 'janesmith@gmail.com', '32250170a0dca92d53ec9624f336ca24', '09987654321', '2', '1', '2023-07-20'),
(3, 'Michael', 'Garcia', 'michaelgarcia@gmail.com', '32250170a0dca92d53ec9624f336ca24', '09555444333', '3', '2', '2023-07-20'),
(4, 'Sarah', 'Lim', 'sarahlim@gmail.com', '32250170a0dca92d53ec9624f336ca24', '09111222333', '4', '2', '2023-07-20');

-- --------------------------------------------------------

--
-- Table structure for table `tblsessionterm`
--

CREATE TABLE `tblsessionterm` (
  `Id` int(10) NOT NULL,
  `sessionName` varchar(50) NOT NULL,
  `termId` varchar(50) NOT NULL,
  `isActive` varchar(10) NOT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsessionterm`
--

INSERT INTO `tblsessionterm` (`Id`, `sessionName`, `termId`, `isActive`, `dateCreated`) VALUES
(6, '2023/2024', '2', '0', '2023-07-20'),
(4, '2023/2024', '1', '1', '2023-07-20');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudents`
--

CREATE TABLE `tblstudents` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `otherName` varchar(255) NOT NULL,
  `admissionNumber` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmId` varchar(10) NOT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudents`
--

INSERT INTO `tblstudents` (`Id`, `firstName`, `lastName`, `otherName`, `admissionNumber`, `password`, `classId`, `classArmId`, `dateCreated`) VALUES
(1, 'Juan', 'Dela Cruz', 'Garcia', 'AMS-2023-9576', '32250170a0dca92d53ec9624f336ca24', '1', '1', '2023-07-20'),
(2, 'Maria', 'Santos', 'Reyes', 'AMS-2023-8275', '5f4dcc3b5aa765d61d8327deb882cf99', '2', '1', '2023-07-20'),
(3, 'Pedro', 'Gomez', 'Lopez', 'AMS-2023-2644', '5d7845ac6ee7cfffafc5fe5f35cf666d', '3', '2', '2023-07-20'),
(4, 'Ana', 'Lim', 'Castillo', 'AMS-2023-8398', '3fc0a7acf087f549ac2b266baf94b8b1', '4', '2', '2023-07-20'),
(5, 'Maria', 'Gonzales', 'Santos', 'AMS-2023-4059', '32250170a0dca92d53ec9624f336ca24', '1', '1', '2023-07-21'),
(6, 'John', 'Smith', 'Doe', 'AMS-2023-5100', '5f4dcc3b5aa765d61d8327deb882cf99', '2', '1', '2023-07-21'),
(7, 'Jane', 'Lee', 'Johnson', 'AMS-2023-3322', '5d7845ac6ee7cfffafc5fe5f35cf666d', '3', '2', '2023-07-21'),
(8, 'Michael', 'Garcia', 'Lopez', 'AMS-2023-1313', '56cf01f6edfe9598b5e23407fe290990', '1', '1', '2023-07-22'),
(9, 'Sarah', 'Rodriguez', 'Lim', 'AMS-2023-6597', 'ec26202651ed221cf8f993668c459d46', '2', '1', '2023-07-22'),
(10, 'David', 'Tan', 'Gomez', 'AMS-2023-9046', '55fc5b709962876903785fd64a6961e5', '3', '2', '2023-07-22'),
(11, 'James', 'Chua', 'Sy', 'AMS-2023-5441', '9ba36afc4e560bf811caefc0c7fddddf', '1', '1', '2023-07-22'),
(12, 'Linda', 'Wong', 'Chen', 'AMS-2023-65', '7d95d1d22485f5ac341d06bbfea91e9e', '2', '1', '2023-07-22'),
(13, 'Alex', 'Lopez', 'Garcia', 'AMS-2023-4006', 'b75bd008d5fecb1f50cf026532e8ae67', '1', '1', '2023-07-23'),
(14, 'Emily', 'Chen', 'Tan', 'AMS-2023-9834', '29e1448ae02b6fd112fcf3618e1be9f5', '2', '1', '2023-07-23'),
(15, 'Daniel', 'Sy', 'Wang', 'AMS-2023-7153', 'b5ea8985533defbf1d08d5ed2ac8fe9b', '3', '2', '2023-07-23'),
(16, 'Sophia', 'Lim', 'Gomez', 'AMS-2023-6261', '79fc98c9ebcefe5acf01bc9802b4af1d', '1', '1', '2023-07-23'),
(17, 'Ethan', 'Gonzales', 'Santos', 'AMS-2023-9849', '13b55d41e2cf32424e9faa1a52cdb67a', '2', '1', '2023-07-23'),
(18, 'Olivia', 'Smith', 'Doe', 'AMS-2023-463', '5a6fdf1ec2d9b64595817887becd660d', '3', '2', '2023-07-23'),
(19, 'William', 'Lee', 'Johnson', 'AMS-2023-2770', '8a31fc89653c9f20d371bec97430d477', '1', '1', '2023-07-23'),
(20, 'Ava', 'Rodriguez', 'Lim', 'AMS-2023-2458', 'e5ab29eee37a2cb280c09963e3c4ab4b', '2', '1', '2023-07-23'),
(21, 'James', 'Tan', 'Gomez', 'AMS-2023-3983', '9ba36afc4e560bf811caefc0c7fddddf', '3', '2', '2023-07-23'),
(22, 'Isabella', 'Wong', 'Chen', 'AMS-2023-2540', '2f7063936730e384c558074c9a71d2a6', '1', '1', '2023-07-23'),
(23, 'Alexander', 'Chua', 'Sy', 'AMS-2023-753', 'aefc64cf49588070315fbb08bd0c8ee2', '2', '1', '2023-07-23'),
(24, 'Charlotte', 'Gomez', 'Lopez', 'AMS-2023-6144', '25d496178f31e4dd190199b8388cdfad', '3', '2', '2023-07-23'),
(25, 'Liam', 'Garcia', 'Lopez', 'AMS-2023-8464', '13eed07d404b6a6369f0d87db38d9b7e', '1', '1', '2023-07-24'),
(26, 'Emma', 'Santos', 'Reyes', 'AMS-2023-3887', '1f050242921954f2c734eec74ce2ecb6', '2', '1', '2023-07-24'),
(27, 'Noah', 'Gomez', 'Castillo', 'AMS-2023-4043', '54b1504207c9de5f7b2fd9c67d540e86', '3', '2', '2023-07-24'),
(28, 'Olivia', 'Lim', 'Santos', 'AMS-2023-8553', '5a6fdf1ec2d9b64595817887becd660d', '1', '1', '2023-07-24'),
(29, 'Aiden', 'Smith', 'Doe', 'AMS-2023-638', 'd69909f68d218f2dd49d2fb2d30ca85a', '2', '1', '2023-07-24'),
(30, 'Sophia', 'Lee', 'Johnson', 'AMS-2023-7530', '79fc98c9ebcefe5acf01bc9802b4af1d', '3', '2', '2023-07-24'),
(31, 'Lucas', 'Rodriguez', 'Lim', 'AMS-2023-5736', '1308dfed71297a652cc42a390e211489', '1', '1', '2023-07-24'),
(32, 'Mia', 'Tan', 'Gomez', 'AMS-2023-6090', 'e154e212f88557130a2fe3de73299ad9', '2', '1', '2023-07-24'),
(33, 'Liam', 'Wong', 'Chen', 'AMS-2023-3242', '13eed07d404b6a6369f0d87db38d9b7e', '3', '2', '2023-07-24'),
(34, 'Ella', 'Chua', 'Sy', 'AMS-2023-7942', 'efadcf6a697bcc011b573984dcdd3740', '1', '1', '2023-07-24'),
(35, 'Avery', 'Gomez', 'Lopez', 'AMS-2023-9982', '2897195ae55d55d38738d6253c2b49ab', '2', '1', '2023-07-24'),
(36, 'Arabella', 'Smith', 'Doe', 'AMS-2023-6087', '6179c8c8fa04b40f6adc7b390adb0176', '3', '2', '2023-07-24');

-- --------------------------------------------------------

--
-- Table structure for table `tblterm`
--

CREATE TABLE `tblterm` (
  `Id` int(10) NOT NULL,
  `termName` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblterm`
--

INSERT INTO `tblterm` (`Id`, `termName`) VALUES
(1, 'First'),
(2, 'Second'),
(3, 'Third');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblattendance`
--
ALTER TABLE `tblattendance`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblclass`
--
ALTER TABLE `tblclass`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblclassarms`
--
ALTER TABLE `tblclassarms`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblclassteacher`
--
ALTER TABLE `tblclassteacher`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblsessionterm`
--
ALTER TABLE `tblsessionterm`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblterm`
--
ALTER TABLE `tblterm`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblattendance`
--
ALTER TABLE `tblattendance`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tblclass`
--
ALTER TABLE `tblclass`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tblclassarms`
--
ALTER TABLE `tblclassarms`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblclassteacher`
--
ALTER TABLE `tblclassteacher`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblsessionterm`
--
ALTER TABLE `tblsessionterm`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tblterm`
--
ALTER TABLE `tblterm`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
