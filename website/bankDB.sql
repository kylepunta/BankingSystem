-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 26, 2025 at 06:43 PM
-- Server version: 10.5.27-MariaDB
-- PHP Version: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bankDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `Current Account`
--
DROP TABLE IF EXISTS `Current Account`;
CREATE TABLE `Current Account` (
  `accountId` int(11) NOT NULL,
  `accountNumber` int(8) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `overdraftLimit` decimal(10,2) NOT NULL,
  `deletedFlag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Current Account`
--

INSERT INTO `Current Account` (`accountId`, `accountNumber`, `balance`, `overdraftLimit`, `deletedFlag`) VALUES
(82, 18883297, 200.00, 2500.00, 0),
(83, 28604583, 50.00, 3050.00, 0),
(84, 93200745, -1.00, 100.00, 0),
(85, 55573485, 17.99, 2000.00, 0),
(86, 78045674, 9000.00, 9000.00, 0),
(87, 45976752, 100.00, 8750.24, 0),
(88, 96739409, 100.00, 2100.00, 0),
(89, 44366140, 0.00, 100.00, 1),
(90, 34510341, 1.00, 100.00, 0),
(91, 96473459, 0.00, 0.00, 1),
(92, 71976401, 0.00, 0.00, 0),
(93, 16591116, 0.00, 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Current Account History`
--
DROP TABLE IF EXISTS `Current Account History`;
CREATE TABLE `Current Account History` (
  `transactionId` int(11) NOT NULL,
  `accountId` int(11) NOT NULL,
  `date` date NOT NULL,
  `transactionType` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Current Account History`
--

INSERT INTO `Current Account History` (`transactionId`, `accountId`, `date`, `transactionType`, `amount`, `balance`) VALUES
(84, 82, '2025-03-20', 'Lodgement', 5.00, 5.00),
(85, 83, '2025-03-20', 'Lodgement', 50.00, 50.00),
(86, 84, '2025-03-20', 'Lodgement', 1.00, 1.00),
(87, 85, '2025-03-20', 'Lodgement', 30.00, 30.00),
(88, 86, '2025-03-20', 'Lodgement', 9000.00, 9000.00),
(89, 87, '2025-03-20', 'Lodgement', 200.00, 200.00),
(90, 88, '2025-03-20', 'Lodgement', 100.00, 100.00),
(91, 89, '2025-03-20', 'Lodgement', 0.00, 0.00),
(92, 90, '2025-03-20', 'Lodgement', 1.00, 1.00),
(93, 87, '2025-03-20', 'Withdrawal', 25.00, 175.00),
(94, 87, '2025-03-20', 'Withdrawal', 25.00, 150.00),
(95, 87, '2025-03-20', 'Withdrawal', 5.00, 145.00),
(96, 87, '2025-03-20', 'Withdrawal', 10.00, 135.00),
(97, 87, '2025-03-20', 'Withdrawal', 15.00, 120.00),
(98, 87, '2025-03-20', 'Withdrawal', 1.00, 119.00),
(99, 87, '2025-03-20', 'Withdrawal', 2.00, 117.00),
(100, 87, '2025-03-20', 'Withdrawal', 3.00, 114.00),
(101, 87, '2025-03-20', 'Withdrawal', 4.00, 110.00),
(102, 87, '2025-03-20', 'Withdrawal', 10.00, 100.00),
(103, 91, '2025-03-20', 'Lodgement', 0.00, 0.00),
(104, 84, '2025-03-20', 'Withdrawal', 1.00, 0.00),
(105, 84, '2025-03-20', 'Withdrawal', 1.00, -1.00),
(107, 92, '2025-03-23', 'Lodgement', 0.00, 0.00),
(108, 82, '2025-03-24', 'Lodgement', 145.00, 150.00),
(109, 85, '2025-03-24', 'Withdrawal', 12.00, 18.00),
(110, 85, '2025-03-25', 'Withdrawal', 0.01, 17.99),
(111, 82, '2025-03-25', 'Lodgement', 50.00, 200.00),
(112, 93, '2025-03-25', 'Lodgement', 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--
DROP TABLE IF EXISTS `Customer`;
CREATE TABLE `Customer` (
  `customerNo` int(11) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `surName` varchar(20) NOT NULL,
  `address` varchar(80) NOT NULL,
  `eircode` varchar(10) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `telephoneNo` varchar(25) NOT NULL,
  `occupation` varchar(40) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `emailAddress` varchar(30) NOT NULL,
  `guarantorName` varchar(40) DEFAULT NULL,
  `deletedFlag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`customerNo`, `firstName`, `surName`, `address`, `eircode`, `dateOfBirth`, `telephoneNo`, `occupation`, `salary`, `emailAddress`, `guarantorName`, `deletedFlag`) VALUES
(1, 'Will', 'Doyle', 'SETU Carlow Campus, Kilkenny Rd, Carlow', 'R93 V960', '2003-05-15', '0891234567', 'Student', 0.00, 'student@setu.ie', '', 0),
(2, 'Mark', 'Doyle', '21 Tullow Place', 'R93 ABCD', '1999-05-29', '0854204209', 'Burnside Employee', 22000.00, 'employee@burnside.ie', '', 0),
(3, 'Harry', 'Doyle', '54 The WillowsTullowCarlow', 'R65 A921', '1999-05-29', '+353 859941521', 'Assistant Manager', 32000.00, 'john@email.com', '', 0),
(4, 'Mary', 'Doyle', '54 The Willows\r\nTullow\r\nCarlow', 'R65 A921', '1998-04-05', '+353 830232205', 'Primary school teacher', 44500.00, 'mary@yahoo.com', NULL, 1),
(5, 'Mick', 'Doyle', 'Cork', 'R62 93AB', '1956-10-11', '0831257890', 'Pensioner', 44500.00, 'mickdoyle@gmail.com', '', 0),
(6, 'Sarah', 'Kelly', '55 Yellow Road, Carlow', 'R11 A291', '2000-01-31', '13899845', 'Software Intern', 14000.00, 'sk@email.com', '', 0),
(7, 'John', 'Keogh', 'Kildare', 'R340000', '2004-04-07', '08999999999', 'UNEMPLOYED', 0.00, 'johnk@email.ie', '', 0),
(8, 'Mark', 'Gibson', 'Newbridge', 'R14029P', '2007-12-15', '0892234421', 'UNEMPLOYED', 0.00, 'markgib@gibney.com', '', 0),
(9, 'Filip', 'Kotacka', 'Carlow', 'G2187A1', '2004-03-13', '0899440221', 'UNEMPLOYEED', 0.00, 'filipkpt@email.com', '', 0),
(10, 'Michael', 'Baker', 'CARLOW', 'R82F821', '2005-09-10', '0898925380', 'UNEMPLOYED', 0.00, 'mikbak@email.com', '', 1),
(11, 'Maximus', 'Cavalera', 'Dublin', 'R65 A921', '1990-10-09', '0866663321', 'Ginger', 100000.00, 'max.cavalera@yahoo.com', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Customer/CurrentAccount`
--
DROP TABLE IF EXISTS `Customer/CurrentAccount`;
CREATE TABLE `Customer/CurrentAccount` (
  `customerNo` int(11) NOT NULL,
  `accountId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Customer/CurrentAccount`
--

INSERT INTO `Customer/CurrentAccount` (`customerNo`, `accountId`) VALUES
(1, 82),
(2, 83),
(3, 84),
(3, 91),
(5, 85),
(6, 86),
(7, 87),
(8, 88),
(9, 89),
(9, 93),
(10, 90),
(11, 92);

-- --------------------------------------------------------

--
-- Table structure for table `Customer/Deposit Account`
--
DROP TABLE IF EXISTS `Customer/Deposit Account`;
CREATE TABLE `Customer/Deposit Account` (
  `customerNo` int(11) NOT NULL,
  `accountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Customer/Deposit Account`
--

INSERT INTO `Customer/Deposit Account` (`customerNo`, `accountID`) VALUES
(1, 4),
(1, 20),
(2, 5),
(2, 14),
(3, 7),
(3, 13),
(4, 6),
(4, 11),
(4, 12),
(5, 17),
(6, 15),
(7, 19),
(8, 18),
(9, 16);

-- --------------------------------------------------------

--
-- Table structure for table `Customer/LoanAccount`
--
DROP TABLE IF EXISTS `Customer/LoanAccount`;
CREATE TABLE `Customer/LoanAccount` (
  `customerNo` int(8) NOT NULL,
  `accountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Customer/LoanAccount`
--

INSERT INTO `Customer/LoanAccount` (`customerNo`, `accountID`) VALUES
(1, 47),
(2, 48),
(3, 49),
(3, 58),
(5, 50),
(6, 51),
(6, 57),
(7, 52),
(8, 53),
(8, 59),
(9, 54),
(10, 55);

-- --------------------------------------------------------

--
-- Table structure for table `Deposit Account`
--
DROP TABLE IF EXISTS `Deposit Account`;
CREATE TABLE `Deposit Account` (
  `accountID` int(11) NOT NULL,
  `accountNumber` int(11) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `deletedFlag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Deposit Account`
--

INSERT INTO `Deposit Account` (`accountID`, `accountNumber`, `balance`, `deletedFlag`) VALUES
(4, 12252573, 860.50, 0),
(5, 48095563, 0.01, 0),
(6, 40002112, 12345.67, 0),
(7, 26016634, 69420.00, 0),
(11, 71630139, 20.50, 0),
(12, 11703603, 2000.50, 0),
(13, 38763519, 492.42, 0),
(14, 91912936, 0.00, 1),
(15, 12451583, 999.99, 0),
(16, 58258096, 0.01, 0),
(17, 96502135, 9.99, 0),
(18, 71769370, 0.00, 0),
(19, 28581821, 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Deposit Account History`
--
DROP TABLE IF EXISTS `Deposit Account History`;
CREATE TABLE `Deposit Account History` (
  `transactionId` int(10) NOT NULL,
  `accountId` int(11) NOT NULL,
  `date` date NOT NULL,
  `transactionType` varchar(20) NOT NULL,
  `transactionAmount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Deposit Account History`
--

INSERT INTO `Deposit Account History` (`transactionId`, `accountId`, `date`, `transactionType`, `transactionAmount`, `balance`) VALUES
(4, 4, '2025-02-13', 'Lodgement', 1000.50, 1000.50),
(5, 5, '2025-02-24', 'Lodgement', 0.01, 0.01),
(6, 6, '2025-02-24', 'Lodgement', 12345.67, 12345.67),
(7, 7, '2025-02-24', 'Lodgement', 69420.00, 69420.00),
(8, 11, '2025-02-26', 'Lodgement', 20.50, 20.50),
(9, 12, '2025-02-27', 'Lodgement', 2000.50, 2000.50),
(10, 13, '2025-03-03', 'Lodgement', 42.42, 42.42),
(11, 13, '2025-03-04', 'Lodgement', 500.00, 542.42),
(12, 13, '2025-03-04', 'Withdrawal', 100.00, 442.42),
(13, 13, '2025-03-05', 'Lodgement', 50.00, 492.42),
(14, 14, '2025-03-06', 'Lodgement', 1234.56, 1234.56),
(15, 14, '2025-03-06', 'Withdrawal', 1234.56, 0.00),
(16, 13, '2025-03-10', 'Lodgement', 7.58, 500.00),
(17, 13, '2025-03-10', 'Withdrawal', 10.00, 490.00),
(18, 13, '2025-03-11', 'Withdrawal', 90.00, 400.00),
(19, 13, '2025-04-14', 'Withdrawal', 50.00, 350.00),
(20, 13, '2025-04-16', 'Lodgement', 300.00, 650.00),
(21, 13, '2025-04-21', 'Lodgement', 350.00, 1000.00),
(22, 13, '2025-04-22', 'Withdrawal', 100.00, 900.00),
(23, 15, '2025-03-13', 'Lodgement', 999.99, 999.99),
(24, 16, '2025-03-14', 'Lodgement', 0.01, 0.01),
(25, 17, '2025-03-16', 'Lodgement', 9.99, 9.99),
(26, 18, '2025-03-18', 'Lodgement', 0.00, 0.00),
(27, 19, '2025-03-20', 'Lodgement', 0.00, 0.00),
(28, 4, '2025-03-20', 'Withdrawal', 100.00, 900.50),
(30, 16, '2025-03-20', 'Withdrawal', 0.01, 0.00),
(31, 4, '2025-03-24', 'Withdrawal', 100.00, 800.50),
(32, 4, '2025-03-24', 'Lodgement', 50.00, 850.50),
(33, 4, '2025-03-25', 'Lodgement', 10.00, 860.50);

-- --------------------------------------------------------

--
-- Table structure for table `Loan Account`
--
DROP TABLE IF EXISTS `Loan Account`;
CREATE TABLE `Loan Account` (
  `accountID` int(11) NOT NULL,
  `accountNumber` int(8) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `loanAmount` decimal(10,2) NOT NULL,
  `loanStartDate` date NOT NULL,
  `loanTerm` int(11) NOT NULL,
  `loanMonthlyRepayments` decimal(10,2) NOT NULL,
  `deletedFlag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Loan Account`
--

INSERT INTO `Loan Account` (`accountID`, `accountNumber`, `balance`, `loanAmount`, `loanStartDate`, `loanTerm`, `loanMonthlyRepayments`, `deletedFlag`) VALUES
(47, 37003045, 800.00, 15000.00, '2024-12-11', 6, 2750.00, 0),
(48, 52515319, 31666.64, 50000.00, '2024-03-20', 24, 2291.67, 0),
(49, 73263782, 1000.00, 4200.00, '2024-12-30', 12, 385.00, 0),
(50, 73701354, 60000.00, 60000.00, '2021-03-24', 36, 1833.33, 0),
(51, 37534054, 1050.00, 1050.00, '2023-07-19', 4, 288.75, 0),
(52, 40446543, 20000.00, 20000.00, '2024-10-30', 20, 1100.00, 0),
(53, 35304204, 8500.00, 8500.00, '2025-03-20', 8, 1168.75, 0),
(54, 47988527, 2900.00, 2900.00, '2025-03-20', 5, 638.00, 0),
(55, 20898450, 1200.00, 1200.00, '2025-03-20', 12, 110.00, 0),
(57, 73228799, 1000.00, 1000.00, '2025-03-24', 5, 220.00, 0),
(58, 85515392, 0.00, 0.00, '2025-03-24', 1, 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Loan Account History`
--
DROP TABLE IF EXISTS `Loan Account History`;
CREATE TABLE `Loan Account History` (
  `transactionID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `transactionDate` date NOT NULL,
  `transactionType` varchar(20) NOT NULL,
  `repaymentAmount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Loan Account History`
--

INSERT INTO `Loan Account History` (`transactionID`, `accountID`, `transactionDate`, `transactionType`, `repaymentAmount`, `balance`) VALUES
(3, 47, '2024-12-11', 'Lodgement', 2750.00, 12250.00),
(4, 47, '2025-01-11', 'Lodgement', 2750.00, 9500.00),
(5, 47, '2025-02-11', 'Lodgement', 2750.00, 6750.00),
(6, 47, '2025-03-11', 'Lodgement', 2750.00, 4000.00),
(7, 48, '2024-03-20', 'Lodgement', 2291.67, 47708.33),
(8, 48, '2024-04-20', 'Lodgement', 2291.67, 45416.66),
(9, 48, '2024-05-20', 'Lodgement', 2291.67, 43124.99),
(10, 48, '2024-06-20', 'Lodgement', 2291.67, 40833.32),
(11, 48, '2024-07-20', 'Lodgement', 2291.67, 38541.65),
(12, 48, '2024-08-20', 'Lodgement', 2291.67, 36249.98),
(13, 48, '2024-09-20', 'Lodgement', 2291.67, 33958.31),
(14, 48, '2024-10-20', 'Lodgement', 2291.67, 31666.64),
(15, 47, '2025-03-24', 'Lodgement', 100.00, 800.00);

-- --------------------------------------------------------

--
-- Table structure for table `Rate Table`
--
DROP TABLE IF EXISTS `Rate Table`;
CREATE TABLE `Rate Table` (
  `rateType` varchar(20) NOT NULL,
  `rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Rate Table`
--

INSERT INTO `Rate Table` (`rateType`, `rate`) VALUES
('Interest', 0.1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Current Account`
--
ALTER TABLE `Current Account`
  ADD PRIMARY KEY (`accountId`);

--
-- Indexes for table `Current Account History`
--
ALTER TABLE `Current Account History`
  ADD PRIMARY KEY (`transactionId`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`customerNo`);

--
-- Indexes for table `Customer/CurrentAccount`
--
ALTER TABLE `Customer/CurrentAccount`
  ADD PRIMARY KEY (`customerNo`,`accountId`);

--
-- Indexes for table `Customer/Deposit Account`
--
ALTER TABLE `Customer/Deposit Account`
  ADD PRIMARY KEY (`customerNo`,`accountID`);

--
-- Indexes for table `Customer/LoanAccount`
--
ALTER TABLE `Customer/LoanAccount`
  ADD PRIMARY KEY (`customerNo`,`accountID`);

--
-- Indexes for table `Deposit Account`
--
ALTER TABLE `Deposit Account`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `Deposit Account History`
--
ALTER TABLE `Deposit Account History`
  ADD PRIMARY KEY (`transactionId`);

--
-- Indexes for table `Loan Account`
--
ALTER TABLE `Loan Account`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `Loan Account History`
--
ALTER TABLE `Loan Account History`
  ADD PRIMARY KEY (`transactionID`);

--
-- Indexes for table `Rate Table`
--
ALTER TABLE `Rate Table`
  ADD PRIMARY KEY (`rateType`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Current Account`
--
ALTER TABLE `Current Account`
  MODIFY `accountId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `Current Account History`
--
ALTER TABLE `Current Account History`
  MODIFY `transactionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `customerNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `Deposit Account`
--
ALTER TABLE `Deposit Account`
  MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `Deposit Account History`
--
ALTER TABLE `Deposit Account History`
  MODIFY `transactionId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `Loan Account`
--
ALTER TABLE `Loan Account`
  MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `Loan Account History`
--
ALTER TABLE `Loan Account History`
  MODIFY `transactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
