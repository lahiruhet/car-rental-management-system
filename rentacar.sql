-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2023 at 07:36 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentacar`
--
CREATE DATABASE IF NOT EXISTS `rentacar` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rentacar`;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `CarID` int(11) NOT NULL,
  `Make` varchar(50) NOT NULL,
  `Model` varchar(50) NOT NULL,
  `Year` int(11) NOT NULL,
  `RentalPrice` decimal(10,2) NOT NULL,
  `Available` tinyint(1) NOT NULL DEFAULT 1,
  `ViewCar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`CarID`, `Make`, `Model`, `Year`, `RentalPrice`, `Available`, `ViewCar`) VALUES
(1, 'Toyota', 'Corolla', 2021, '15750.00', 0, '../assets/img/avatars/cars/Toyota_Corolla_Design_VVT-i_HEV_1.8_Front.jpg'),
(2, 'Honda', 'Civic', 2022, '17500.00', 1, '../assets/img/avatars/cars/Honda_Civic_SR_VTEC_1.0_Front.jpg'),
(3, 'Ford', 'Escape', 2020, '21000.00', 1, '../assets/img/avatars/cars/Ford_Escape_SEL,_front_7.11.20.jpg'),
(4, 'Chevrolet', 'Malibu', 2021, '19250.00', 0, '../assets/img/avatars/cars/Chevrolet_Malibu_(facelift)_LT,_front_10.19.19.jpg'),
(5, 'Nissan', 'Altima', 2022, '19250.00', 0, '../assets/img/avatars/cars/Nissan_Altima_SL_2.5L_front_3.22.19.jpg'),
(6, 'Toyota', 'Hiace', 2020, '12000.00', 0, '../assets/img/avatars/cars/Toyota_HiAce_(front).jpg'),
(7, 'Mercedes-Benz', 'Vito', 2021, '14000.00', 1, '../assets/img/avatars/cars/Mercedes-Benz_V_250_d_Exclusive_AMG_Line_Lang_(V_447)_–_Frontansicht,_29._Juni_2016,_Düsseldorf.jpg'),
(8, 'Volkswagen', 'Transporter', 2022, '13000.00', 0, '../assets/img/avatars/cars/Volkswagen_Transporter_BlueMotion.jpg'),
(9, 'Ford', 'Transit', 2021, '12500.00', 1, '../assets/img/avatars/cars/Ford_Transit_350_2.2.jpg'),
(10, 'Renault', 'Trafic', 2020, '11000.00', 1, '../assets/img/avatars/cars/Renault_Trafic_SL27_Business+_Energy_1.6_Front.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `ReservationID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `CarID` int(11) NOT NULL,
  `PickupDate` date NOT NULL,
  `ReturnDate` date NOT NULL,
  `TotalPrice` decimal(10,2) NOT NULL,
  `Status` varchar(12) NOT NULL DEFAULT 'Upcoming'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`ReservationID`, `UserID`, `CarID`, `PickupDate`, `ReturnDate`, `TotalPrice`, `Status`) VALUES
(1, 2, 1, '2023-03-01', '2023-03-02', '15750.00', 'Completed'),
(8, 2, 5, '2023-03-07', '2023-03-17', '19250.00', 'Upcoming'),
(12, 11, 8, '2023-03-16', '2023-03-17', '13000.00', 'Upcoming');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserType` enum('user','admin') NOT NULL DEFAULT 'user',
  `Avatar` varchar(255) NOT NULL DEFAULT '../assets/img/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `UserType`, `Avatar`) VALUES
(1, 'admin', 'admin', 'admin', '../assets/img/avatars/default.png'),
(2, 'lahiru', 'lahiru', 'user', '../assets/img/avatars/3.png'),
(8, 'sadew', 'sadew', 'user', '../assets/img/avatars/4.png'),
(9, 'dewmini', 'dewmini', 'user', '../assets/img/avatars/6.png'),
(10, 'ashab', 'ashab', 'user', '../assets/img/avatars/1.png'),
(11, 'amaya', 'amaya', 'user', '../assets/img/avatars/5.png'),
(13, 'ishara', 'ishara', 'user', '../assets/img/avatars/2.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`CarID`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`ReservationID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `CarID` (`CarID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `CarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `ReservationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`CarID`) REFERENCES `cars` (`CarID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
