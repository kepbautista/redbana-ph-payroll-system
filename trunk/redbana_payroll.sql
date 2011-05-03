-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 03, 2011 at 03:35 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `redbana_payroll`
--

CREATE DATABASE `redbana_payroll` ;# 1 row(s) affected.

-- --------------------------------------------------------

--
-- Table structure for table `base_pay`
--

CREATE TABLE IF NOT EXISTS `base_pay` (
  `ID` int(11) NOT NULL,
  `POSITION` varchar(244) NOT NULL,
  `AMOUNT` float NOT NULL,
  PRIMARY KEY (`POSITION`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `base_pay`
--


-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(128) NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL,
  PRIMARY KEY (`NAME`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `department`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `START_DATE` date NOT NULL,
  `END_DATE` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `payperiod`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `per` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `philhealth`
--

INSERT INTO `philhealth` (`bracket`, `rangel`, `rangeh`, `base`, `total`, `pes`, `per`) VALUES
(1, 4999.99, 0, 4000, 100, 50, 50),
(2, 5000, 5999.99, 5000, 125, 62.5, 62.5),
(3, 6000, 6999.99, 6000, 150, 75, 75),
(4, 7000, 7999.99, 7000, 175, 87.5, 87.5),
(5, 8000, 8999.99, 8000, 200, 100, 100),
(6, 9000, 9999.99, 9000, 225, 112.5, 112.5),
(7, 10000, 10999.99, 10000, 250, 125, 125),
(8, 11000, 11999.99, 11000, 275, 137.5, 137.5),
(9, 12000, 12999.99, 12000, 300, 150, 150),
(10, 13000, 13999.99, 13000, 325, 162.5, 162.5),
(11, 14000, 14999.99, 14000, 350, 175, 175),
(12, 15000, 15999.99, 15000, 375, 187.5, 187.5),
(13, 16000, 16999.99, 16000, 400, 200, 200),
(14, 17000, 17999.99, 17000, 425, 212.5, 212.5),
(15, 18000, 18999.99, 18000, 450, 225, 225),
(16, 19000, 19999.99, 19000, 475, 237.5, 237.5),
(17, 20000, 20999.99, 20000, 500, 250, 250),
(18, 21000, 21999.99, 21000, 525, 262.5, 262.5),
(19, 22000, 22999.99, 22000, 550, 275, 275),
(20, 23000, 23999.99, 23000, 575, 287.5, 287.5),
(21, 24000, 24999.99, 24000, 600, 300, 300),
(22, 25000, 25999.99, 25000, 625, 312.5, 312.5),
(23, 26000, 26999.99, 26000, 650, 325, 325),
(24, 27000, 27999.99, 27000, 675, 337.5, 337.5),
(25, 28000, 28999.99, 28000, 700, 350, 350),
(26, 29000, 29999.99, 29000, 725, 362.5, 362.5),
(27, 30000, 50000, 30000, 750, 375, 375);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(128) NOT NULL,
  `DESCRIPTION` int(255) NOT NULL,
  PRIMARY KEY (`TITLE`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `position`
--


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
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `shift`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `sss`
--

INSERT INTO `sss` (`rangel`, `rangeh`, `ser`, `see`, `stotal`, `ecer`, `ter`, `tee`, `ttotal`, `msc`, `totalcont`, `id`) VALUES
(1000, 1249.99, 70.7, 33.33, 104, 10, 80.7, 33.3, 114, 1000, 104, 45),
(1250, 1749.99, 106, 50, 156, 10, 116, 50, 166, 1500, 156, 46),
(1750, 2249.99, 141.3, 66.7, 208, 10, 151.3, 66.7, 218, 2000, 208, 47),
(2250, 2749.99, 176.7, 83.3, 260, 10, 186.7, 83.3, 270, 2500, 260, 48),
(2750, 3249.99, 212, 100, 312, 10, 222, 100, 322, 3000, 312, 49),
(3250, 3749.99, 247.3, 116.7, 364, 10, 257.3, 116.7, 374, 3500, 364, 50),
(3750, 4249.99, 282.7, 133.3, 416, 10, 292.7, 133.3, 426, 4000, 416, 51),
(4250, 4749.99, 318, 150, 468, 10, 328, 150, 478, 4500, 468, 52),
(4750, 5249.99, 353.3, 166.7, 520, 10, 363.3, 166.7, 530, 5000, 520, 53),
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
(14750, 10749.99, 1060, 500, 1560, 30, 1090, 500, 1590, 15000, 1560, 73);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`fname`, `mname`, `lname`, `email`, `empnum`, `password`, `type`, `position`, `department`, `gender`, `startdate`, `paymentmode`) VALUES
('mary rose', 'bigata', 'garra', 'merose@gmail.com', '11111', 'mary', 'employee', '', '', '', '0000-00-00', ''),
('kim', 'pura', 'samaniego', 'kimsamaniego@gmail.com', '12345', 'karlene', 'superuser', '', '', '', '0000-00-00', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `witholding_tax`
--

INSERT INTO `witholding_tax` (`PAYMENT_MODE_ID_FK`, `BRACKET`, `EXEMPTION_DEFINITE`, `EXEMPTION_PERCENT`, `A_Z`, `A_SME`, `B_MES1`, `B_MES2`, `B_MES3`, `B_MES4`) VALUES
(1, 0, -1, -1, 0, 50, 75, 100, 125, 150),
(1, 1, 0, 0, 1, 1, 1, 1, 1, 1),
(1, 2, 0, 5, 0, 2083, 3125, 4167, 5208, 6250),
(1, 3, 20.83, 10, 417, 2500, 3542, 4583, 5625, 6667),
(1, 4, 104.17, 15, 1250, 3333, 4375, 5417, 6458, 7501),
(1, 5, 354.17, 20, 2917, 5000, 6042, 7083, 8125, 9167),
(1, 6, 432.69, 25, 2692, 3654, 4135, 4615, 5096, 5577),
(1, 7, 2083.33, 30, 10417, 12500, 13542, 14583, 15625, 16667),
(1, 8, 5208.33, 32, 20833, 22917, 23958, 25000, 26042, 27083),
(2, 0, -1, -1, 0, 50, 75, 100, 125, 150),
(2, 1, 0, 0, 1, 1, 1, 1, 1, 1),
(2, 2, 0, 5, 0, 4167, 6250, 8333, 10417, 12500),
(2, 3, 41.67, 10, 833, 5000, 7083, 9167, 11250, 13333),
(2, 4, 208.33, 15, 2500, 6667, 0, 0, 0, 0),
(2, 5, 708.33, 20, 5833, 10000, 12083, 14167, 16250, 18333),
(2, 6, 1875, 25, 11667, 15833, 17917, 20000, 22083, 24167),
(2, 7, 4166.67, 30, 20833, 25000, 27083, 29167, 31250, 33333),
(2, 8, 10416.7, 32, 41667, 45833, 47917, 50000, 52083, 54167);
