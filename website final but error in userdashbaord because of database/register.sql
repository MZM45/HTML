-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2023 at 10:18 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `register`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `appoint`
--

CREATE TABLE `appoint` (
  `SN` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `purpose` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appoint`
--

INSERT INTO `appoint` (`SN`, `user_id`, `name`, `date`, `purpose`) VALUES
(1, 1, 'demo', '2145-02-05', ' n nbhbhhv');

-- --------------------------------------------------------

--
-- Table structure for table `reg`
--

CREATE TABLE `reg` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `register_type` varchar(10) NOT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `cause_of_death` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reg`
--

INSERT INTO `reg` (`ID`, `user_id`, `name`, `dob`, `gender`, `address`, `father_name`, `mother_name`, `register_type`, `place_of_birth`, `cause_of_death`) VALUES
(1, 1, 'demo', '2023-09-21', 'female', 'vev d ', 'demodad', 'demomom', 'birth', 'cd n sjcb snc', '');

-- --------------------------------------------------------

--
-- Table structure for table `registry`
--

CREATE TABLE `registry` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registry`
--

INSERT INTO `registry` (`id`, `name`, `phone`, `email`, `username`, `password`) VALUES
(1, 'demo', '1234567', 'abc@hotmail.com', 'demo12', '$2y$10$fvXE8sK./RtbnRc9ZTmUr.YlbzTsvKd8w1vPhTFIyYwHuxUGVspW.'),
(2, 'demo2', '124568', 'djjshj@dkfn.com', 'demo2', '$2y$10$Wp8OdmJ7LaJZuVuQKMROv.br3mxZu.AMDB8WKLiweG3ARMhHEAyyO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appoint`
--
ALTER TABLE `appoint`
  ADD PRIMARY KEY (`SN`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reg`
--
ALTER TABLE `reg`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `test` (`user_id`);

--
-- Indexes for table `registry`
--
ALTER TABLE `registry`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appoint`
--
ALTER TABLE `appoint`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reg`
--
ALTER TABLE `reg`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `registry`
--
ALTER TABLE `registry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appoint`
--
ALTER TABLE `appoint`
  ADD CONSTRAINT `appoint_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `registry` (`id`);

--
-- Constraints for table `reg`
--
ALTER TABLE `reg`
  ADD CONSTRAINT `test` FOREIGN KEY (`user_id`) REFERENCES `registry` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
