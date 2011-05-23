-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 23, 2011 at 04:22 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `redbana_payroll`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `absence_reason`
--

INSERT INTO `absence_reason` (`ID`, `TITLE`, `DEDUCTIBLE`, `DESCRIPTION`, `DEDUCTION_RATE`, `ABSENCE_REASON_CATEGORY`, `TO_DISPLAY_DEDUCTIBLE`) VALUES
(1, 'ABSENT', 1, 'basta na lang hindi pumasok', 100, 1, 0),
(9, 'EMERGENCY_LEAVE', 0, 'With pay', NULL, 6, 1),
(8, 'EMERGENCY_LEAVE', 1, 'Without pay', 100, NULL, 1),
(11, 'HOLIDAY_BREAK', 0, 'Di pumasok kasi Holiday daw', NULL, NULL, 0),
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
  `bank` varchar(10) NOT NULL,
  `baccount` varchar(20) NOT NULL,
  `emp_status` varchar(20) NOT NULL,
  `shift_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`empnum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`empnum`, `mname`, `sname`, `fname`, `user_right`, `mrate`, `payment_mode`, `position`, `dept`, `gender`, `password`, `sdate`, `bdate`, `title`, `civil_status`, `hphone`, `mphone`, `email`, `address`, `zipcode`, `tax_status`, `emp_type`, `sssno`, `tinno`, `philno`, `pagibig`, `bank`, `baccount`, `emp_status`, `shift_id`) VALUES
('2008-00195', 'Ilagan', 'Castiliogne', 'Dane', 'Employee', 123, 3, 'Graphic Artist', 'Business Executive', 'M', 'EPfa5s7Wz0', '1990-01-01', '1990-03-01', 'Mr.', 'Single', '123', '123', 'roseann.scola@gmail.com', '123', '123', 'ME2', 'Regular', '123', '123', '123', '123', '0', '0', 'On-Leave', 0),
('2008-00196', 'Perez', 'Bautista', 'Kristine Elaine', 'Superuser', 11000, 3, 'Operations Team Leader', 'Operations', 'F', 'teamnomads', '2011-03-03', '1991-05-15', 'Ms.', 'Single', '8240235', '09157662833', 'kepbautista@gmail.com', 'Bahay ni Lola', '171', 'S', 'Probational', '12', '12', '12', '12', '0', '0', 'Active', 1),
('2008-00198', 'Abarintos', 'Ilagan', 'Rose Ann', 'Superuser', 5000, 3, 'Web Programmer', 'Operations', 'M', 'rozieanniewa', '1990-05-01', '1990-10-01', 'Ms.', 'Single', '5490773', '123', 'roseann.scola@gmail.com', 'paranaque', '1700', 'ME1', 'Regular', '111', '111', '111', '111', '0', '0', 'Active', 0);

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
-- Table structure for table `emp_type`
--

CREATE TABLE IF NOT EXISTS `emp_type` (
  `type` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `emp_type`
--

INSERT INTO `emp_type` (`type`, `id`) VALUES
('Probational', 2),
('Regular', 3),
('Project Based', 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `payperiod`
--

INSERT INTO `payperiod` (`ID`, `PAYMENT_MODE`, `START_DATE`, `END_DATE`, `TOTAL_WORK_DAYS`, `END_OF_THE_MONTH`, `FINALIZED`, `FINALIZED_BY`, `FINALIZED_DATE`, `PAYROLL_FINALIZED`, `PAYROLL_FINALIZED_BY`, `PAYROLL_FINALIZED_DATE`) VALUES
(1, 1, '2011-04-08', '2011-04-23', 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(2, 1, '2011-04-24', '2011-05-07', 11, 0, 1, '2008-00196', '2011-05-22 17:10:02', 0, NULL, NULL),
(3, 1, '2011-05-08', '2011-05-23', 11, 0, 0, NULL, NULL, 0, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

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
('Operations Team Leader', 11),
('Manager', 12);

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE IF NOT EXISTS `salary` (
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `EmployeeNumber` varchar(50) NOT NULL,
  `DailyRate` double NOT NULL,
  `PayPeriodRate` double NOT NULL,
  `AbsencesTardiness` double NOT NULL DEFAULT '0',
  `Overtime` double NOT NULL DEFAULT '0',
  `Holiday` double NOT NULL DEFAULT '0',
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
  `AdvancestoOfficer` double NOT NULL DEFAULT '0',
  `CellphoneCharges` double NOT NULL DEFAULT '0',
  `AdvancestoEmployee` double NOT NULL DEFAULT '0',
  `NetPay` double NOT NULL DEFAULT '0',
  `Remarks` varchar(100) NOT NULL,
  `Status` varchar(50) NOT NULL,
  KEY `EmployeeNumber` (`EmployeeNumber`),
  KEY `EmployeeNumber_2` (`EmployeeNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`start_date`, `end_date`, `EmployeeNumber`, `DailyRate`, `PayPeriodRate`, `AbsencesTardiness`, `Overtime`, `Holiday`, `TaxRefund`, `NightDifferential`, `GrossPay`, `NonTax`, `TaxShield`, `TotalPay`, `WithholdingBasis`, `WithholdingTax`, `SSS`, `Philhealth`, `Pagibig`, `PagibigLoan`, `SSSLoan`, `CompanyLoan`, `AdvancestoOfficer`, `CellphoneCharges`, `AdvancestoEmployee`, `NetPay`, `Remarks`, `Status`) VALUES
('2011-03-15', '2011-03-31', '2008-00196', 500, 5500, 0, 0, 0, 0, 0, 5500, 0, 0, 5500, 5400, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, '', ''),
('2011-05-01', '2011-05-15', '2008-00196', 500, 5500, 0, 0, 0, 0, 0, 5500, 0, 0, 5500, 4858.3, 0, 366.7, 275, 0, 0, 0, 0, 0, 0, 0, 0, '', '');

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
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`ID`, `POSITION_ID_FK`, `START_TIME`, `END_TIME`, `OVERFLOW`, `NIGHT_DIFF`) VALUES
('', -1, '00:00:00', '09:00:00', 0, '05:00:00'),
('', -1, '07:00:00', '16:00:00', 0, '00:00:00'),
('', -1, '09:00:00', '18:00:00', 0, '00:00:00'),
('', -1, '14:00:00', '23:00:00', 0, '05:00:00'),
('', -1, '15:00:00', '00:00:00', 1, '02:00:00'),
('', -1, '21:00:00', '06:00:00', 1, '07:00:00'),
('', -1, '23:00:00', '08:00:00', 1, '06:00:00');
-----------------------------------------------------------

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tax_status`
--

INSERT INTO `tax_status` (`id`, `status`, `desc`, `exemption`) VALUES
(8, 'ME2', 'MARRIED WHERE ONLY ONE OF THE SPOUSE IS EMPLOYED -', 48000),
(9, 'ME3', 'MARRIED WHERE ONLY ONE OF THE SPOUSE IS EMPLOYED -', 56000),
(10, 'ME4', 'MARRIED WHERE ONLY ONE OF THE SPOUSE IS EMPLOYED -', 64000),
(11, 'S', 'SINGLE OR EMPLOYED HUSBAND WHOSE WIFE IS ALSO EMPL', 20000);

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
  `shift_id` int(11) NOT NULL,
  `tardiness` time DEFAULT '00:00:00',
  `undertime` time DEFAULT '00:00:00',
  `overtime` time DEFAULT '00:00:00',
  `night_diff` time DEFAULT '00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `timesheet`
--

INSERT INTO `timesheet` (`id`, `empnum`, `date_in`, `time_in`, `date_out`, `time_out`, `absence_reason`, `shift_id`, `undertime`, `overtime`, `night_diff`) VALUES
(1, '2008-00195', '2011-04-25', '00:00:00', '2011-04-25', '00:00:00', 0, 0, NULL, NULL, NULL),
(2, '2008-00196', '2011-04-25', '00:00:00', '2011-04-25', '00:00:00', NULL, 0, NULL, NULL, NULL),
(3, '2008-00198', '2011-04-25', '00:00:00', '2011-04-25', '00:00:00', NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `fname` varchar(60) NOT NULL,
  `mname` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `empnum` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `type` varchar(60) NOT NULL,
  `position` varchar(60) NOT NULL,
  `department` varchar(60) NOT NULL,
  `gender` char(1) NOT NULL,
  `startdate` date NOT NULL,
  `paymentmode` varchar(60) NOT NULL,
  PRIMARY KEY (`empnum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`fname`, `mname`, `lname`, `email`, `empnum`, `password`, `type`, `position`, `department`, `gender`, `startdate`, `paymentmode`) VALUES
('mary rose', 'bigata', 'garra', 'merose@gmail.com', '11111', 'mary', 'employee', '', '', '', '0000-00-00', ''),
('kim', 'pura', 'samaniego', 'kimsamaniego@gmail.com', '12345', 'karlene', 'superuser', '', '', '', '0000-00-00', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=116 ;

--
-- Dumping data for table `user_main`
--

INSERT INTO `user_main` (`id`, `user_right`, `privilege`, `type`) VALUES
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
(38, 'employee', 'accleave', 0),
(39, 'employee', 'position', 0),
(40, 'employee', 'dept', 0),
(41, 'employee', 'taxstatus', 0),
(42, 'employee', 'shift', 0),
(43, 'employee', 'sss', 0),
(44, 'employee', 'phil', 0),
(45, 'employee', 'wth', 0),
(46, 'employee', 'viewpay', 1),
(47, 'employee', 'leave', 1),
(90, 'superuser', 'timesheet', 1),
(91, 'superuser', 'type', 1),
(92, 'superuser', 'access', 1),
(93, 'employee', 'access', 0),
(94, 'employee', 'type', 0),
(95, 'employee', 'timesheet', 0),
(96, 'superuser', 'user', 1),
(97, 'employee', 'user', 0);

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

--
-- Constraints for dumped tables
--

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`EmployeeNumber`) REFERENCES `employee` (`empnum`) ON DELETE NO ACTION ON UPDATE CASCADE;
