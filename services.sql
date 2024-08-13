-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2024 at 09:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `services`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `adder` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `payment` varchar(30) NOT NULL,
  `queries` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `provider_id`, `fname`, `lname`, `contact`, `adder`, `date`, `payment`, `queries`) VALUES
(1, 4, 'sahnaj', 'khatun', '9819870888', 'Nikal', '2024-08-14', 'cash', 'Display problem'),
(2, 6, 'czbczbzcb', 'xcbczbczbz', '7', '9', '0004-06-04', 'cash', ''),
(3, 6, 'dsgdsagadsg', 'fsasfsadfas', '9835544555', 'dgsdagaafha', '2024-08-16', 'cash', 'fdsaggadsgadsg');

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `descr` varchar(1000) NOT NULL,
  `adder` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `profession` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `providers`
--

INSERT INTO `providers` (`id`, `name`, `contact`, `descr`, `adder`, `email`, `city`, `latitude`, `longitude`, `password`, `photo`, `profession`) VALUES
(4, 'Majibul Raeen', '9819870888', 'hello guys', 'sinurjoda', 'masjit ', 'Lalitpur', '27.6717377', '85.3199265', '12345678', '66b8e7fbf106a.jpg', 'mobile'),
(6, 'bcvzbvbs', '9804867811', 'dfshdsfhfdshfds', 'fddshdfsbvs', 'fdshfdshfds', 'Lalitpur', '27.6717359', '85.3199484', 'gfdgsfdgsdf', '66b9f9a87efbf.jpg', 'mobile'),
(7, 'sdasdsgasd', '9815822345', 'dsagsadgsadgagdsagsad', 'Dhanusha', 'majibul@gmail.com', 'Kathmandu', '27.6717379', '85.3199279', '12345678', '66ba0e0e42279.jpg', 'electrician'),
(8, 'dsafdsagads', '9852121354', 'dsagagagasagadsaga', 'hasalaoa', 'majibul@gmail.com', 'Kathmandu', '27.671727', '85.3199363', 'majibul', '66ba0ecc436b5.jpg', 'electrician'),
(9, 'gdsagadsgsad', '56787887', 'adsasdgasdgasgsadgasdga', '879', 'majibuldgdhs@gmail.com', 'Kathmandu', '27.6717329', '85.3199414', 'majibul', '66bae5c05aeda.jpg', 'electrician');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
