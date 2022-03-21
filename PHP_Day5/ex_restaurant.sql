-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2022 at 03:13 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ex_restaurant`
--
CREATE DATABASE IF NOT EXISTS `ex_restaurant` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ex_restaurant`;

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `dish_id` int(11) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `birth` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(50) DEFAULT NULL,
  `status` enum('adm','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `lname`, `birth`, `email`, `password`, `picture`, `status`) VALUES
(1, 'Mark', 'Boomber', '1981-11-01', 'boomber1981@gmail.com', 'boomber1981', '6235cb610ce95.png', 'user'),
(2, 'Anna', 'Boomber', '1981-01-01', 'boomber@gmail.com', '1981', 'paper-0.png', 'user'),
(3, 'Susanna', 'Whither', '1986-12-11', 'whither86@gmail.com', 'whithersu', 'elf-3.jpg', 'user'),
(4, 'Susanna', 'Black', '1991-12-01', 'blacksusanna@gmail.com', 'black1991', 'admavatar.png', 'adm'),
(5, 'Rein', 'Zippermann', '1980-02-01', 'zippermann@gmail.com', '123123', 'admavatar.png', 'user'),
(6, 'Bob', 'Dilan', '1986-07-25', 'dilan.bob86@gmail.com', 'dilan86', 'plant-949111_960_720', 'user'),
(7, 'Bob', 'Reinboy', '1988-06-25', 'reinboy.bob86@gmail.com', 'bobreinb88', '', 'user'),
(8, 'Mark', 'Grey', '1982-03-01', 'grey@gmail.com', 'grey', NULL, 'user'),
(9, 'Anna', 'Big', '1981-11-01', 'big@mail.com', '111', NULL, 'user'),
(10, 'Lanna', 'klein', '2022-03-10', 'klein@mail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'avatar.png', 'user'),
(11, 'Rihard', 'Zippermann', '2022-01-11', 'zippermann1@gmail.com', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'avatar.png', 'adm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`dish_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
