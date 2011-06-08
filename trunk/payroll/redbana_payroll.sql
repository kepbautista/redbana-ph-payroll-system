-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 07, 2011 at 03:36 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `redbana_payroll`
--
CREATE DATABASE `redbana_payroll` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `redbana_payroll`;

-- --------------------------------------------------------

--
-- Table structure for table `absence_reason`
--

CREATE TABLE IF NOT EXISTS `absence_reason` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(255) NOT NULL,
  `DEDUCTIBLE` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'this will determine if it will be included in deduction from base pay',
  `DESCRIPTION` varchar(255) NOT NULL,
  `DEDUCTION_RATE` float DEFAULT '100' COMMENT 'this is in percent, so it means if this contains ''100'', multiply  some quantity (e.g. days absent) by 100% or (1.00)',
  `ABSENCE_REASON_CATEGORY` int(11) DEFAULT NULL,
  `TO_DISPLAY_DEDUCTIBLE` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'For some reasons, we should display e.g. "PAID/UNPAID SICK LEAVE"',
  PRIMARY KEY (`TITLE`,`DEDUCTIBLE`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `absence_reason`
--

INSERT INTO `absence_reason` (`ID`, `TITLE`, `DEDUCTIBLE`, `DESCRIPTION`, `DEDUCTION_RATE`, `ABSENCE_REASON_CATEGORY`, `TO_DISPLAY_DEDUCTIBLE`) VALUES
(1, 'ABSENT', 1, 'basta na lang hindi pumasok', 100, 1, 0),
(9, 'EMERGENCY_LEAVE', 0, 'With pay', NULL, 6, 1),
(8, 'EMERGENCY_LEAVE', 1, 'Without pay', 100, NULL, 1),
(12, 'HOLIDAY_BREAK', 0, 'Di pumasok kasi Holiday daw', NULL, NULL, 0),
(2, 'LEAVE (GENERIC)', 1, '...', 100, 1, 1),
(0, 'NULL (PRESENT)', 0, 'No absence, andiyan si Kuya/Ate.', NULL, NULL, 0),
(10, 'RESTDAY', 0, 'Of course day off, at hindi din ito ibabawas sa base pay', NULL, NULL, 0),
(4, 'SICK_LEAVE', 0, 'With pay', NULL, 5, 1),
(5, 'SICK_LEAVE', 1, 'Without pay', 100, 2, 1),
(3, 'SUSPENSION', 0, 'Hala!! Anyway, hindi naman to ibabawas sa base pay.', NULL, 3, 0),
(6, 'VACATION_LEAVE', 0, 'Paid daw.', NULL, 4, 1),
(7, 'VACATION_LEAVE', 1, 'Unpaid daw.', 100, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `absence_reason_category`
--

CREATE TABLE IF NOT EXISTS `absence_reason_category` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(255) NOT NULL,
  `DESC` varchar(255) NOT NULL DEFAULT 'NO_DESC.',
  PRIMARY KEY (`TITLE`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `absence_reason_category`
--

INSERT INTO `absence_reason_category` (`ID`, `TITLE`, `DESC`) VALUES
(1, 'ABSENCES_AND_LWOP', 'NO_DESC.'),
(6, 'PAID_EMERGENCY_LEAVE_DAYS', 'NO_DESC.'),
(5, 'PAID_SL_DAYS', 'NO_DESC.'),
(4, 'PAID_VL_DAYS', 'NO_DESC.'),
(3, 'SUSPENSION', 'NO_DESC.'),
(2, 'VACATION_AND_SICK_LEAVE', 'NO_DESC.');

-- --------------------------------------------------------

--
-- Table structure for table `daily_desc`
--

CREATE TABLE IF NOT EXISTS `daily_desc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `payrate` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `daily_desc`
--

INSERT INTO `daily_desc` (`id`, `title`, `desc`, `payrate`) VALUES
(1, 'Regular Work', 'Regular Work', 0),
(2, 'Regular Holiday', 'Regular Holiday', 100),
(3, 'Special Holiday', 'Special Holiday', 30),
(67, 'Special Holiday on Rest Day', 'Special Holiday on Rest Day', 260);

-- --------------------------------------------------------

--
-- Table structure for table `dept_main`
--

CREATE TABLE IF NOT EXISTS `dept_main` (
  `dept` varchar(50) NOT NULL,
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dept_main`
--

INSERT INTO `dept_main` (`dept`, `id`) VALUES
('Localization', 1),
('Accounting', 2),
('Business Executive', 3),
('HRD', 4),
('Marketing', 5),
('Operations', 6);

-- --------------------------------------------------------

--
-- Table structure for table `emp_type`
--

CREATE TABLE IF NOT EXISTS `emp_type` (
  `type` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `emp_type`
--

INSERT INTO `emp_type` (`type`, `id`) VALUES
('Probational', 2),
('Regular', 3),
('Project Based', 4);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `empnum` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `sname` varchar(50) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `user_right` varchar(20) NOT NULL,
  `mrate` float NOT NULL,
  `payment_mode` int(1) NOT NULL DEFAULT '1',
  `position` varchar(50) NOT NULL,
  `dept` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `password` varchar(15) NOT NULL,
  `sdate` date NOT NULL,
  `bdate` date NOT NULL,
  `title` varchar(10) NOT NULL,
  `civil_status` varchar(10) NOT NULL,
  `hphone` varchar(20) NOT NULL,
  `mphone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `tax_status` varchar(10) NOT NULL,
  `emp_type` varchar(20) NOT NULL,
  `sssno` varchar(20) NOT NULL,
  `tinno` varchar(20) NOT NULL,
  `philno` varchar(20) NOT NULL,
  `pagibig` varchar(50) NOT NULL,
  `emp_status` varchar(20) NOT NULL,
  `shift_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`empnum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`empnum`, `mname`, `sname`, `fname`, `user_right`, `mrate`, `payment_mode`, `position`, `dept`, `gender`, `password`, `sdate`, `bdate`, `title`, `civil_status`, `hphone`, `mphone`, `email`, `address`, `zipcode`, `tax_status`, `emp_type`, `sssno`, `tinno`, `philno`, `pagibig`, `emp_status`, `shift_id`) VALUES
('2008-00196', 'Perez', 'Bautista', 'Kristine Elaine', 'superuser', 25000, 1, 'Operations Team Leader', 'Operations', 'F', 'teamnomads', '2011-03-03', '1991-05-15', 'Ms.', 'Single', '8240235', '09157662833', 'kepbautista@gmail.com', 'Bahay ni Lola', '171', 'ME2', 'Probational', '12', '12', '12', '12', 'Active', 6),
('2008-13916', 'Pura', 'Samaniego', 'Kim', 'employee', 11000, 1, 'Game Master', 'Localization', 'M', 'kimpurasamanieg', '1990-01-01', '1990-05-01', 'Ms.', 'Single', '', '', '', '', '', 'ME2', 'Regular', '13231', '1231', '32131', '31231', 'Active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_status`
--

CREATE TABLE IF NOT EXISTS `employee_status` (
  `id` int(3) NOT NULL,
  `desc` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_status`
--

INSERT INTO `employee_status` (`id`, `desc`) VALUES
(1, 'Married Employee whose spouse is unemployed'),
(2, 'Married Employee whose spouse is a non-resident citizen receiving income from foreign sources'),
(3, 'Married Employee whose spouse is engaged in business'),
(4, 'Single with dependent father/mother/brother/sister/senior citizen'),
(5, 'Single'),
(6, 'Zero Exemption for Employee with multiple employers for their employers'),
(7, 'Zero Exemption for those who failed to file Application for Registration'),
(8, 'Employed husband and husband claims exemptions of children'),
(9, 'Employed wife whose husband is also employed or engaged in business;husband waived claim for depende'),
(10, 'Single with qualified dependent children');

-- --------------------------------------------------------

--
-- Table structure for table `errorcodes`
--

CREATE TABLE IF NOT EXISTS `errorcodes` (
  `CODE` int(11) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `MESSAGE` longtext NOT NULL,
  `FURTHER_INFO` longtext,
  PRIMARY KEY (`NAME`),
  UNIQUE KEY `CODE` (`CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `errorcodes`
--

INSERT INTO `errorcodes` (`CODE`, `NAME`, `MESSAGE`, `FURTHER_INFO`) VALUES
(201, 'ABSENCES_AND_LATE_ALREADY', 'For this payperiod, absences and tardiness info have been already generated. If you want\r\n										to generate again, clear all records first.', NULL),
(453, 'DATE_SPECIFIED_NULL', 'The date you submitted is NULL.', NULL),
(404, 'EMPLOYEE_DOES_NOT_EXIST', 'The employee you have requested cannot be found on our records.', NULL),
(450, 'EMPLOYEE_NUMBER_REQUIRED', 'Please submit employee number.', NULL),
(200, 'INSERTION_FINAL_ERROR', 'All details are computed, but there is something that failed while inserting.', NULL),
(700, 'INVALID_DATE_FORMAT_INSUFFICIENT_DIGITS', 'The date submitted should be composed exactly of 10 characters, separators included', NULL),
(701, 'INVALID_DATE_FORMAT_ISO_INCONFORMANCE', 'The date submitted does not conform to the ISO Format YYYY/MM/DD where all of the characters should be numeric (Except for the separators).', NULL),
(704, 'INVALID_PAYPERIOD_OBJECT', 'There is something wrong with payperiod submitted. ', NULL),
(102, 'MISSING_ABSENCE_DETAILS', 'No absence details for this employee: you might have missed a day of checking attendance.', NULL),
(103, 'MISSING_TARDINESS_DETAILS', 'No tardiness record for this employee exists: you might have missed a day of checking attendance.', NULL),
(455, 'NEED_TO_LOGIN', 'The section you are trying to access requires you to be logged-in.', NULL),
(410, 'NON_EXISTENT_TIMESHEET', 'This timesheet is not existing.', NULL),
(101, 'NO_EMPLOYEE_EXISTS', 'There is no single employee in the database.', NULL),
(405, 'PAYMENT_MODE_NOT_FOUND', 'The specified payment mode can''t be found.', NULL),
(451, 'PAYMENT_MODE_REQUIRED', 'Please specify payment mode.', NULL),
(407, 'PAYPERIOD_NOT_FOUND', 'Pay period does not exist', NULL),
(452, 'PAYPERIOD_REQUIRED', 'Please specify payperiod.', NULL),
(403, 'UNKNOWN_FIELD_UPDATE_ATTEMPT', 'You have tried to update a field that does not exist', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `date` datetime NOT NULL,
  `user` varchar(70) NOT NULL,
  `action` varchar(70) NOT NULL,
  `person` varchar(70) NOT NULL,
  `table` varchar(70) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`date`, `user`, `action`, `person`, `table`, `id`) VALUES
('2011-06-04 21:04:09', 'Kristine Elaine Bautista', 'delete', 'Rose Ann Ilagan', 'employee', 1),
('2011-06-04 21:07:02', 'Kristine Elaine Bautista', 'delete', 'Rose Ann Ilagan', 'employee', 2),
('2011-06-04 21:13:04', 'Kristine Elaine Bautista', 'delete', 'Rose Ann Ilagan', 'employee', 3),
('2011-06-04 21:22:50', 'Kristine Elaine Bautista', 'delete', 'Dane Castiliogne', 'employee', 4),
('2011-06-07 17:11:34', 'Kristine Elaine Bautista', 'insert', 'Kim Samaniego', 'employee', 5),
('2011-06-07 17:12:09', 'Kristine Elaine Bautista', 'update', 'Kristine Elaine Bautista', 'employee', 6),
('2011-06-07 21:08:14', 'Kristine Elaine Bautista', 'update', 'Kim Samaniego', 'employee', 7),
('2011-06-07 21:16:05', 'Kristine Elaine Bautista', 'update', 'Kristine Elaine Bautista', 'employee', 8),
('2011-06-07 21:16:15', 'Kristine Elaine Bautista', 'update', 'Kim Samaniego', 'employee', 9),
('2011-06-07 23:15:14', 'Kristine Elaine Bautista', 'insert', 'ME1', 'tax_status', 10),
('2011-06-07 23:16:40', 'Kristine Elaine Bautista', 'insert', 'S1', 'tax_status', 11),
('2011-06-07 23:19:47', 'Kristine Elaine Bautista', 'insert', 'S1', 'tax_status', 12),
('2011-06-07 23:19:56', 'Kristine Elaine Bautista', 'delete', 'S1', 'tax_status', 13),
('2011-06-07 23:20:26', 'Kristine Elaine Bautista', 'insert', 'S2', 'tax_status', 14),
('2011-06-07 23:21:40', 'Kristine Elaine Bautista', 'insert', 'S3', 'tax_status', 15),
('2011-06-07 23:22:25', 'Kristine Elaine Bautista', 'insert', 's4', 'tax_status', 16),
('2011-06-07 23:23:35', 'Kristine Elaine Bautista', 'insert', 's', 'tax_status', 17),
('2011-06-07 23:23:52', 'Kristine Elaine Bautista', 'insert', 's', 'tax_status', 18),
('2011-06-07 23:23:56', 'Kristine Elaine Bautista', 'delete', 's', 'tax_status', 19),
('2011-06-07 23:23:59', 'Kristine Elaine Bautista', 'delete', 's', 'tax_status', 20);

-- --------------------------------------------------------

--
-- Table structure for table `leave`
--

CREATE TABLE IF NOT EXISTS `leave` (
  `empnum` varchar(20) NOT NULL,
  `filedate` date NOT NULL,
  `startdate` date NOT NULL,
  `returndate` date NOT NULL,
  `type` varchar(60) NOT NULL,
  `reason` varchar(60) NOT NULL,
  `approval` varchar(60) NOT NULL DEFAULT 'Not yet approved',
  PRIMARY KEY (`empnum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `leave`
--

INSERT INTO `leave` (`empnum`, `filedate`, `startdate`, `returndate`, `type`, `reason`, `approval`) VALUES
('1212122', '1990-01-01', '1990-01-01', '1990-01-01', 'vacation', 'qwdds', 'Not yet approved'),
('12211', '1990-02-03', '1990-07-01', '1993-08-04', 'bereavement', 'asssd', 'Not yet approved'),
('12222', '1990-04-01', '1990-01-01', '1990-01-08', 'bereavement', 'asa', 'Not yet approved'),
('13333', '2011-05-11', '2011-05-15', '2011-05-27', '0000-00-00', 'sick', ''),
('2008-00195', '1990-01-01', '1990-01-01', '1990-01-01', 'vacation', '', 'Not yet approved'),
('89992', '1992-03-04', '1993-03-04', '1993-04-04', 'emergency', 'i dunno', ''),
('89999', '1992-03-04', '1993-03-04', '1993-04-04', '0000-00-00', 'i dunno', '');

-- --------------------------------------------------------

--
-- Table structure for table `payment_mode`
--

CREATE TABLE IF NOT EXISTS `payment_mode` (
  `ID` int(11) NOT NULL,
  `TITLE` varchar(128) NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL,
  PRIMARY KEY (`TITLE`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_mode`
--

INSERT INTO `payment_mode` (`ID`, `TITLE`, `DESCRIPTION`) VALUES
(2, 'MONTHLY', 'EVERY MONTH'),
(1, 'SEMI-MONTHLY', 'EVERY KINSENAS');

-- --------------------------------------------------------

--
-- Table structure for table `payperiod`
--

CREATE TABLE IF NOT EXISTS `payperiod` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PAYMENT_MODE` int(11) NOT NULL,
  `START_DATE` date NOT NULL,
  `END_DATE` date NOT NULL,
  `TOTAL_WORK_DAYS` float NOT NULL,
  `END_OF_THE_MONTH` tinyint(1) DEFAULT '0' COMMENT 'Used for charges, e.g. like PAG-IBIG which requires deduction during end-of-the-months',
  `FINALIZED` tinyint(1) NOT NULL DEFAULT '0',
  `FINALIZED_BY` varchar(255) DEFAULT NULL,
  `FINALIZED_DATE` timestamp NULL DEFAULT NULL,
  `PAYROLL_FINALIZED` tinyint(1) NOT NULL DEFAULT '0',
  `PAYROLL_FINALIZED_BY` varchar(255) DEFAULT NULL,
  `PAYROLL_FINALIZED_DATE` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `payperiod`
--

INSERT INTO `payperiod` (`ID`, `PAYMENT_MODE`, `START_DATE`, `END_DATE`, `TOTAL_WORK_DAYS`, `END_OF_THE_MONTH`, `FINALIZED`, `FINALIZED_BY`, `FINALIZED_DATE`, `PAYROLL_FINALIZED`, `PAYROLL_FINALIZED_BY`, `PAYROLL_FINALIZED_DATE`) VALUES
(1, 1, '2011-06-01', '2011-06-22', 11, 0, 0, NULL, NULL, 0, NULL, NULL),
(2, 1, '2011-06-23', '2011-07-03', 11, 0, 0, NULL, NULL, 0, NULL, NULL),
(3, 1, '2011-06-23', '2011-06-30', 8, 1, 0, NULL, NULL, 0, NULL, NULL),
(4, 1, '2011-07-04', '2011-07-14', 11, 1, 0, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_absence`
--

CREATE TABLE IF NOT EXISTS `payroll_absence` (
  `empnum` varchar(255) NOT NULL,
  `payperiod` int(11) NOT NULL,
  `payment_mode` int(11) NOT NULL,
  `monthly_rate` float NOT NULL,
  `daily_rate` float NOT NULL,
  `absences_lwop_days` float NOT NULL,
  `absences_lwop_amount` float NOT NULL,
  `leave_sick_vacation_days` float NOT NULL,
  `leave_sick_vacation_amount` float NOT NULL,
  `suspension_days` float NOT NULL,
  `suspension_amount` float NOT NULL,
  `tardiness_min` float NOT NULL,
  `tardiness_amount` float NOT NULL,
  `total_amount` float NOT NULL,
  `paid_vl_days` float NOT NULL,
  `paid_sl_days` float NOT NULL,
  `paid_emergency_leave_days` float NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` varchar(255) NOT NULL,
  PRIMARY KEY (`empnum`,`payperiod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payroll_absence`
--


-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(127) NOT NULL,
  `DESCRIPTION` int(255) NOT NULL,
  PRIMARY KEY (`NAME`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `permission`
--


-- --------------------------------------------------------

--
-- Table structure for table `philhealth`
--

CREATE TABLE IF NOT EXISTS `philhealth` (
  `bracket` int(11) NOT NULL,
  `rangel` double NOT NULL,
  `rangeh` double NOT NULL,
  `base` double NOT NULL,
  `total` double NOT NULL,
  `pes` double NOT NULL,
  `per` double NOT NULL,
  `id` int(6) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `philhealth`
--

INSERT INTO `philhealth` (`bracket`, `rangel`, `rangeh`, `base`, `total`, `pes`, `per`, `id`) VALUES
(1, 0, 4999.99, 4000, 100, 50, 50, 20),
(2, 5000, 5999.99, 5000, 125, 62.5, 62.5, 21),
(3, 6000, 6999.99, 6000, 150, 75, 75, 22),
(4, 7000, 7999.99, 7000, 175, 87.5, 87.5, 23),
(5, 8000, 8999.99, 8000, 200, 100, 100, 24),
(6, 9000, 9999.99, 9000, 225, 112.5, 112.5, 25),
(7, 10000, 10999.99, 10000, 250, 125, 125, 26),
(8, 11000, 11999.99, 11000, 275, 137.5, 137.5, 27),
(9, 12000, 12999.99, 12000, 300, 150, 150, 28),
(10, 13000, 13999.99, 13000, 325, 162.5, 162.5, 29),
(11, 14000, 14999.99, 14000, 350, 175, 175, 30),
(12, 15000, 15999.99, 15000, 375, 187.5, 187.5, 31),
(13, 16000, 16999.99, 16000, 400, 200, 200, 32),
(14, 17000, 17999.99, 17000, 425, 212.5, 212.5, 33),
(15, 18000, 18999.99, 18000, 450, 225, 225, 34),
(16, 19000, 19999.99, 19000, 475, 237.5, 237.5, 35),
(17, 20000, 20999.99, 20000, 500, 250, 250, 36),
(18, 21000, 21999.99, 21000, 525, 262.5, 262.5, 37),
(19, 22000, 22999.99, 22000, 550, 275, 275, 38),
(20, 23000, 23999.99, 23000, 575, 287.5, 287.5, 39),
(21, 24000, 24999.99, 24000, 600, 300, 300, 40),
(22, 25000, 25999.99, 25000, 625, 312.5, 312.5, 41),
(23, 26000, 26999.99, 26000, 650, 325, 325, 42),
(24, 27000, 27999.99, 27000, 675, 337.5, 337.5, 43),
(25, 28000, 28999.99, 28000, 700, 350, 350, 44),
(26, 29000, 29999.99, 29000, 725, 362.5, 362.5, 45),
(27, 30000, 500000, 30000, 750, 375, 375, 46);

-- --------------------------------------------------------

--
-- Table structure for table `pos_main`
--

CREATE TABLE IF NOT EXISTS `pos_main` (
  `position` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `pos_main`
--

INSERT INTO `pos_main` (`position`, `id`) VALUES
('Accounting Associate', 1),
('Accounting Supervisor', 2),
('Game Master', 3),
('Graphic Artist', 4),
('HR Associate', 5),
('HR Manager', 7),
('HR Supervisor', 8),
('Marketing Associate', 9),
('Operations Team Leader', 11);

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE IF NOT EXISTS `salary` (
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `EmployeeNumber` varchar(50) NOT NULL,
  `EmployeeName` varchar(50) NOT NULL,
  `DailyRate` double NOT NULL,
  `PayPeriodRate` double NOT NULL,
  `AbsencesTardiness` double NOT NULL DEFAULT '0',
  `Overtime` double NOT NULL DEFAULT '0',
  `Holiday` double NOT NULL DEFAULT '0',
  `HolidayAdjustment` double NOT NULL DEFAULT '0',
  `TaxRefund` double NOT NULL DEFAULT '0',
  `NightDifferential` double NOT NULL DEFAULT '0',
  `GrossPay` double NOT NULL DEFAULT '0',
  `NonTax` double NOT NULL DEFAULT '0',
  `TaxShield` double NOT NULL DEFAULT '0',
  `TotalPay` double NOT NULL DEFAULT '0',
  `WithholdingBasis` double NOT NULL DEFAULT '0',
  `WithholdingTax` double NOT NULL DEFAULT '0',
  `SSS` double NOT NULL DEFAULT '0',
  `Philhealth` double NOT NULL DEFAULT '0',
  `Pagibig` double NOT NULL DEFAULT '0',
  `PagibigLoan` double NOT NULL DEFAULT '0',
  `SSSLoan` double NOT NULL DEFAULT '0',
  `CompanyLoan` double NOT NULL DEFAULT '0',
  `CellphoneCharges` double NOT NULL DEFAULT '0',
  `AdvancestoEmployee` double NOT NULL DEFAULT '0',
  `NetPay` double NOT NULL DEFAULT '0',
  `Status` varchar(50) DEFAULT NULL,
  KEY `EmployeeNumber` (`EmployeeNumber`),
  KEY `EmployeeNumber_2` (`EmployeeNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`start_date`, `end_date`, `EmployeeNumber`, `EmployeeName`, `DailyRate`, `PayPeriodRate`, `AbsencesTardiness`, `Overtime`, `Holiday`, `HolidayAdjustment`, `TaxRefund`, `NightDifferential`, `GrossPay`, `NonTax`, `TaxShield`, `TotalPay`, `WithholdingBasis`, `WithholdingTax`, `SSS`, `Philhealth`, `Pagibig`, `PagibigLoan`, `SSSLoan`, `CompanyLoan`, `CellphoneCharges`, `AdvancestoEmployee`, `NetPay`, `Status`) VALUES
('2011-06-01', '2011-06-22', '2008-00196', 'Bautista, Kristine Elaine Perez', 500, 12500, 0, 0, 0, 0, 0, 0, 12500, 0, 0, 12500, 11687.5, 1359.375, 500, 312.5, 0, 0, 0, 0, 0, 0, 10328.125, ''),
('2011-06-01', '2011-06-22', '2008-13916', 'Samaniego, Kim Pura', 500, 5500, 0, 0, 0, 0, 0, 0, 5500, 0, 0, 5500, 4995.8, 62.11, 366.7, 137.5, 0, 0, 0, 0, 0, 0, 4933.69, ''),
('2011-06-23', '2011-07-03', '2008-00196', 'Bautista, Kristine Elaine Perez', 0, 25000, 0, 0, 0, 0, 0, 0, 25000, 0, 0, 25000, 24087.5, 0, 500, 312.5, 100, 0, 0, 0, 0, 0, 24087.5, ''),
('2011-06-23', '2011-07-03', '2008-13916', 'Samaniego, Kim Pura', 0, 5500, 0, 0, 0, 0, 0, 0, 5500, 0, 0, 5500, 4995.8, 62.11, 366.7, 137.5, 0, 0, 0, 0, 0, 0, 4933.69, ''),
('2011-06-23', '2011-06-30', '2008-00196', 'Bautista, Kristine Elaine Perez', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL),
('2011-06-23', '2011-06-30', '2008-13916', 'Samaniego, Kim Pura', 500, 5500, 0, 0, 0, 0, 0, 0, 5500, 0, 0, 5500, 5400, 102.53, 0, 0, 100, 0, 0, 0, 0, 0, 5297.47, ''),
('2011-07-04', '2011-07-14', '2008-00196', 'Bautista, Kristine Elaine Perez', 0, 12500, 0, 0, 0, 0, 0, 0, 12500, 0, 0, 12500, 12400, 1537.5, 0, 0, 100, 0, 0, 0, 0, 0, 10862.5, ''),
('2011-07-04', '2011-07-14', '2008-13916', 'Samaniego, Kim Pura', 0, 5500, 0, 0, 0, 0, 0, 0, 5500, 0, 0, 5500, 5400, 102.53, 0, 0, 100, 0, 0, 0, 0, 0, 5297.47, '');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE IF NOT EXISTS `shift` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `POSITION_ID_FK` int(11) NOT NULL,
  `START_TIME` time NOT NULL,
  `END_TIME` time NOT NULL,
  `OVERFLOW` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'If the time starts on the current day and ends the next day (starting 00:00h)',
  `NIGHT_DIFF` time NOT NULL DEFAULT '00:00:00',
  `BREAKTIME` time NOT NULL DEFAULT '01:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` VALUES
(1, -1, '00:00:00', '09:00:00', 0, '05:00:00', '01:00:00' ),
(2, -1, '07:00:00', '16:00:00', 0, '00:00:00', '01:00:00' ),
(3, -1, '09:00:00', '18:00:00', 0, '00:00:00', '01:00:00' ),
(4, -1, '14:00:00', '23:00:00', 0, '05:00:00', '01:00:00'),
(5, -1, '15:00:00', '00:00:00', 1, '02:00:00', '01:00:00'),
(6, -1, '21:00:00', '06:00:00', 1, '07:00:00', '01:00:00'),
(7, -1, '23:00:00', '08:00:00', 1, '06:00:00', '01:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sss`
--

CREATE TABLE IF NOT EXISTS `sss` (
  `rangel` double NOT NULL,
  `rangeh` double NOT NULL,
  `ser` double NOT NULL,
  `see` double NOT NULL,
  `stotal` double NOT NULL,
  `ecer` double NOT NULL,
  `ter` double NOT NULL,
  `tee` double NOT NULL,
  `ttotal` double NOT NULL,
  `msc` double NOT NULL,
  `totalcont` double NOT NULL,
  `id` int(6) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `sss`
--

INSERT INTO `sss` (`rangel`, `rangeh`, `ser`, `see`, `stotal`, `ecer`, `ter`, `tee`, `ttotal`, `msc`, `totalcont`, `id`) VALUES
(1000, 1249.99, 33.33, 33.33, 105, 10, 80.7, 33.3, 114, 1000, 104, 45),
(1250, 1749.99, 106, 50, 156, 10, 116, 50, 166, 1500, 156, 46),
(1750, 2249.99, 141.3, 66.7, 208, 10, 151.3, 66.7, 218, 2000, 208, 47),
(2250, 2749.99, 176.7, 83.3, 260, 10, 186.7, 83.3, 270, 2500, 260, 48),
(2750, 3249.99, 212, 100, 312, 10, 222, 100, 322, 3000, 312, 49),
(3250, 3749.99, 247.3, 116.7, 365, 10, 257.3, 116.7, 374, 3500, 364, 50),
(3750, 4249.99, 282.7, 133.3, 416, 10, 292.7, 133.3, 426, 4000, 416, 51),
(4250, 4749.99, 318, 150, 468, 10, 328, 150, 478, 4500, 468, 52),
(4750, 5249.99, 353.3, 166.7, 521, 10, 363.3, 166.7, 530, 5000, 520, 53),
(5250, 5749.99, 388.7, 183.3, 572, 10, 398.7, 183.3, 582, 5500, 572, 54),
(5750, 6249.99, 424, 200, 624, 10, 434, 200, 634, 6000, 624, 55),
(6250, 6749.99, 459.3, 216.7, 676, 10, 469.3, 216.7, 686, 6500, 676, 56),
(6750, 7249.99, 494.7, 233.3, 728, 10, 504.7, 233.3, 738, 7000, 728, 57),
(7250, 7749.99, 530, 250, 780, 10, 540, 250, 790, 7500, 780, 58),
(7750, 8249.99, 565.3, 266.7, 832, 10, 575.3, 266.7, 842, 8000, 832, 59),
(8250, 8749.99, 600.7, 283.3, 884, 10, 610.7, 283.3, 894, 8500, 884, 60),
(8750, 9249.99, 636, 300, 936, 10, 646, 300, 946, 9000, 936, 61),
(9250, 9749.99, 671.3, 316.7, 988, 10, 681.3, 316.7, 998, 9500, 988, 62),
(9750, 10249.99, 706.7, 333.3, 1040, 10, 716.7, 333.3, 1050, 10000, 1040, 63),
(10250, 10749.99, 742, 350, 1092, 10, 752, 350, 1102, 10500, 1092, 64),
(10750, 11249.99, 777.3, 366.7, 1144, 10, 787.3, 366.7, 1154, 11000, 1144, 65),
(11250, 11749.99, 812.7, 383.3, 1196, 10, 822.7, 383.3, 1206, 11500, 1196, 66),
(11750, 12249.99, 848, 400, 1248, 10, 858, 400, 1258, 12000, 1248, 67),
(12250, 12749.99, 883.3, 416.7, 1300, 10, 893.3, 416.7, 1310, 12500, 1300, 68),
(12750, 13249.99, 918.7, 433.3, 1352, 10, 928.7, 433.3, 1362, 13000, 1352, 69),
(13250, 13749.99, 954, 450, 1404, 10, 964, 450, 1414, 13500, 1404, 70),
(13750, 14249.99, 989.3, 466.7, 1456, 10, 999.3, 466.7, 1466, 14000, 1456, 71),
(14250, 14749.99, 1024.7, 483.3, 1508, 10, 1034.7, 483.3, 1518, 14500, 1508, 72),
(14750, 500000, 1060, 500, 1560, 30, 1090, 500, 1590, 15000, 1560, 73);

-- --------------------------------------------------------

--
-- Table structure for table `tax_status`
--

CREATE TABLE IF NOT EXISTS `tax_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(10) NOT NULL,
  `desc` varchar(50) NOT NULL,
  `exemption` double NOT NULL,
  PRIMARY KEY (`id`,`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tax_status`
--

INSERT INTO `tax_status` (`id`, `status`, `desc`, `exemption`) VALUES
(8, 'ME2', 'MARRIED WHERE ONLY ONE OF THE SPOUSE IS EMPLOYED -', 100000),
(9, 'ME3', 'MARRIED WHERE ONLY ONE OF THE SPOUSE IS EMPLOYED -', 125000),
(10, 'ME4', 'MARRIED WHERE ONLY ONE OF THE SPOUSE IS EMPLOYED -', 150000),
(11, 'S', 'SINGLE OR EMPLOYED HUSBAND WHOSE WIFE IS ALSO EMPL', 50000),
(12, 'ME1', 'MARRIED WITH ONE DEPENDENT', 75000),
(13, 'S1', 'SINGLE WITH ONE DEPENDENT', 75000),
(15, 'S2', 'SINGLE WITH TWO DEPENDENT', 100000),
(16, 'S3', 'SINGLE WITH THREE DEPENDENT', 125000),
(17, 's4', 'single with four dependent', 150000);

-- --------------------------------------------------------

--
-- Table structure for table `timesheet`
--

CREATE TABLE IF NOT EXISTS `timesheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empnum` varchar(255) NOT NULL,
  `date_in` date NOT NULL,
  `time_in` time NOT NULL,
  `date_out` date NOT NULL,
  `time_out` time NOT NULL,
  `absence_reason` int(11) DEFAULT NULL,
  `shift_id` int(11) NOT NULL DEFAULT 1,
  `tardiness` time DEFAULT '00:00:00',
  `undertime` time DEFAULT '00:00:00',
  `overtime` time DEFAULT '00:00:00',
  `night_diff` time DEFAULT '00:00:00',
  `type` varchar(50) NOT NULL COMMENT 'int value, references values in table `daily_desc` which are REGULAR_WORKING_DAY|SPECIAL_HOLIDAY|LEGAL_HOLIDAY|REGULAR|HOLIDAY',
  `restday` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'This is reserved for times na, pumasok siya pero supposed to be restday niya. This is additional pay kasi.',
  `overtime_rate` int(11) NOT NULL DEFAULT '0' COMMENT 'If 0, this means when generating overtime cost, automatically find what rate to use (determine data from other columns), otherwise, specified in this.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `timesheet`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_main`
--

CREATE TABLE IF NOT EXISTS `user_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_right` varchar(20) CHARACTER SET latin1 NOT NULL,
  `privilege` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=156 ;

--
-- Dumping data for table `user_main`
--

INSERT INTO `user_main` (`id`, `user_right`, `privilege`, `type`) VALUES
(1, 'employee', 'viewslip', 1),
(2, 'superuser', 'viewslip', 0),
(20, 'superuser', 'viewemp', 1),
(21, 'superuser', 'editemp', 1),
(22, 'superuser', 'addemp', 1),
(23, 'superuser', 'allleave', 1),
(24, 'superuser', 'accleave', 1),
(25, 'superuser', 'position', 1),
(26, 'superuser', 'dept', 1),
(27, 'superuser', 'taxstatus', 1),
(28, 'superuser', 'shift', 1),
(29, 'superuser', 'sss', 1),
(30, 'superuser', 'phil', 1),
(31, 'superuser', 'wth', 1),
(32, 'superuser', 'viewpay', 1),
(33, 'superuser', 'leave', 1),
(34, 'employee', 'viewemp', 0),
(35, 'employee', 'editemp', 0),
(36, 'employee', 'addemp', 0),
(37, 'employee', 'allleave', 0),
(38, 'employee', 'accleave', 1),
(39, 'employee', 'position', 0),
(40, 'employee', 'dept', 0),
(41, 'employee', 'taxstatus', 0),
(42, 'employee', 'shift', 0),
(43, 'employee', 'sss', 0),
(44, 'employee', 'phil', 0),
(45, 'employee', 'wth', 0),
(46, 'employee', 'viewpay', 0),
(47, 'employee', 'leave', 1),
(90, 'superuser', 'timesheet', 1),
(91, 'superuser', 'type', 1),
(92, 'superuser', 'access', 1),
(93, 'employee', 'access', 1),
(94, 'employee', 'type', 0),
(95, 'employee', 'timesheet', 1),
(96, 'superuser', 'user', 1),
(97, 'employee', 'user', 0),
(152, 'superuser', 'day', 1),
(153, 'employee', 'day', 0),
(154, 'superuser', 'history', 1),
(155, 'employee', 'history', 0);

-- --------------------------------------------------------

--
-- Table structure for table `variables`
--

CREATE TABLE IF NOT EXISTS `variables` (
  `Name` varchar(20) NOT NULL,
  `Value` double NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `variables`
--

INSERT INTO `variables` (`Name`, `Value`) VALUES
('PagIbig', 100),
('WorkingDaysPerMonth', 22);

-- --------------------------------------------------------

--
-- Table structure for table `witholding_tax`
--

CREATE TABLE IF NOT EXISTS `witholding_tax` (
  `PAYMENT_MODE_ID_FK` int(11) NOT NULL,
  `BRACKET` int(11) NOT NULL,
  `EXEMPTION_DEFINITE` float NOT NULL,
  `EXEMPTION_PERCENT` float NOT NULL,
  `A_Z` float NOT NULL,
  `A_SME` float NOT NULL,
  `B_MES1` float NOT NULL,
  `B_MES2` float NOT NULL,
  `B_MES3` float NOT NULL,
  `B_MES4` float NOT NULL,
  PRIMARY KEY (`PAYMENT_MODE_ID_FK`,`BRACKET`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `witholding_tax`
--

INSERT INTO `witholding_tax` (`PAYMENT_MODE_ID_FK`, `BRACKET`, `EXEMPTION_DEFINITE`, `EXEMPTION_PERCENT`, `A_Z`, `A_SME`, `B_MES1`, `B_MES2`, `B_MES3`, `B_MES4`) VALUES
(1, 0, 0, 0, 0, 50, 75, 100, 125, 150),
(1, 1, 0, 0, 1, 1, 1, 1, 1, 1),
(1, 2, 0, 5, 0, 2083, 3125, 4167, 5208, 6250),
(1, 3, 20.83, 10, 417, 2500, 3542, 4583, 5625, 6667),
(1, 4, 104.17, 15, 1250, 3333, 4375, 5417, 6458, 7500),
(1, 5, 354.17, 20, 2917, 5000, 6042, 7083, 8125, 9167),
(1, 6, 937.5, 25, 5833, 7917, 8958, 10000, 11042, 12083),
(1, 7, 2083.33, 30, 10417, 12500, 13542, 14583, 15625, 16667),
(1, 8, 5208.33, 32, 20833, 22917, 23958, 25000, 26042, 27083),
(2, 0, 0, 0, 0, 50, 75, 100, 125, 150),
(2, 1, 0, 0, 1, 1, 1, 1, 1, 1),
(2, 2, 0, 5, 0, 4167, 6250, 8333, 10417, 12500),
(2, 3, 41.67, 10, 833, 5000, 7083, 9167, 11250, 13333),
(2, 4, 208.33, 15, 2500, 6667, 8750, 10833, 12917, 15000),
(2, 5, 708.33, 20, 5833, 10000, 12083, 14167, 16250, 18333),
(2, 6, 1875, 25, 11667, 15833, 17917, 20000, 22083, 24167),
(2, 7, 4166.67, 30, 20833, 25000, 27083, 29167, 31250, 33333),
(2, 8, 10416.7, 32, 41667, 45833, 47917, 50000, 52083, 54167);
