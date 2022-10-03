-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: mariadb
-- Generation Time: Oct 03, 2022 at 07:44 PM
-- Server version: 10.6.10-MariaDB-1:10.6.10+maria~ubu2004
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crs`
--
CREATE DATABASE IF NOT EXISTS `crs` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `crs`;

-- --------------------------------------------------------

--
-- Table structure for table `rental_facility`
--

CREATE TABLE `rental_facility` (
  `id` int(11) NOT NULL,
  `park` varchar(4) NOT NULL,
  `facility` text NOT NULL,
  `capacity/size` text NOT NULL,
  `price` text NOT NULL,
  `amenities_include` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rental_facility`
--

INSERT INTO `rental_facility` (`id`, `park`, `facility`, `capacity/size`, `price`, `amenities_include`) VALUES
(1, 'CLNE', 'Classroom', '21\' x 24\'', '1/2 day 8am-noon or 1pm to 5pm  $78.00', 'Smart board'),
(2, 'CLNE', 'Classroom', '21\' x 24\'', 'All day   $153.00', 'Smart board'),
(3, 'CLNE', 'Auditorium', '33\' x 24\'', '1/2 day 8am-noon or 1pm to 5pm  $100.00', 'Video projection equipment'),
(4, 'CLNE', 'Auditorium', '33\' x 24\'', 'All day  $175.00', 'Video projection equipment'),
(5, 'CLNE', 'Classroom/Auditorium', '60 people', '1/2 day 8am-noon or 1pm to 5pm  $150.00', 'This space is a combination of the classroom & auditorium spaces and their amenities.'),
(6, 'CLNE', 'Classroom/Auditorium', '60 people', 'All day $ 300.00', 'This space is a combination of the classroom & auditorium spaces and their amenities.'),
(7, 'CLNE', 'Shelter', '120 people', '$98.00/day', 'Fireplace'),
(8, 'CRMO', 'Auditorium', '966 sq. ft.', '1/2 day 8am-noon or 1pm to 5pm   $103.00', ''),
(9, 'CRMO', 'Auditorium', '966 sq. ft.', 'All day   $178.00', ''),
(10, 'CRMO', 'Classroom', '472 sq. ft.', '1/2 day 8am-noon or 1pm to 5pm  $78.00', ''),
(11, 'CRMO', 'Classroom', '472 sq. ft.', 'All day  $153.00', ''),
(12, 'CRMO', 'Shelter', '90 people', '$73.00/day', ''),
(13, 'DISW', 'Classroom', '506 sq. feet', '1/2 day   8am-noon or 1pm to 5pm  $75.00', ''),
(14, 'DISW', 'Classroom', '506 sq. feet', 'All day    $150.00', ''),
(15, 'DISW', 'Auditorium', '589 sq. feet', '1/2 day   8am-noon or 1pm to 5pm  $100.00', ''),
(16, 'DISW', 'Auditorium', '589 sq. feet', 'All day     $175.00', ''),
(17, 'ENRI', 'Shelter', '96 people', '$98.00/day', ''),
(18, 'ENRI', 'Shelter', '60 people', '$73.00/day', ''),
(19, 'FALA', 'Community Bldg.', '70 people at tables, 120 people in chairs', '$188.00/day', 'Kitchen, fireplace, grills, boat ramp, beach'),
(20, 'FALA', 'Shelter', '45 people', '$35.00/day', 'Swim beach, fishing, trails'),
(21, 'FALA', 'Shelter', '60 people', '$73.00/day', 'Hiking, biking, fishing, swimming'),
(22, 'FALA', 'Shelter', '100 people', '$98.00/day', 'Hiking, biking, fishing, swimming'),
(23, 'FOFI', 'Classroom', '', '1/2 day 8am-noon or 1pm to 5pm   $78.00', 'Beach, picnicking,'),
(24, 'FOFI', 'Classroom', '', 'All day   $153.00', 'refreshment stand (seasonal), outdoor showers'),
(25, 'GOCR', 'Auditorium', '60 people at tables, 90 people in chairs', '1/2 day 8am-noon or 1pm to 5pm $103.00', ''),
(26, 'GOCR', 'Auditorium', '60 people at tables, 90 people in chairs', 'All day  $178.00', ''),
(27, 'GOCR', 'Outdoor classroom', '30 to 40 people', '1/2 day 8am-noon or 1pm to 5pm  $53.00', ''),
(28, 'GOCR', 'Outdoor classroom', '31 to 40 people', 'All day  $78.00', ''),
(29, 'GOCR', 'Shelter', '32 people', '$48.00/day', 'Grill'),
(30, 'GOCR', 'Shelter', '64 people', '$73.00/day', 'Grill'),
(31, 'HARI', 'Grove Auditorium', '150 People', '$150/ day, $75/ 4 hours', 'Video projection equipment,  room can be divided'),
(32, 'HARI', 'Spruce Room', 'Board Room, 16 people', '$150/ day, $75/4 hours', 'Video projection equipment'),
(33, 'HARI', 'Haw River Lounge', '15 people', '$150/ day, $75/ 4 hours', 'Fireplace, TV, DVD player'),
(34, 'HARI', 'Fisher Board Room', '15 people', '$150/ day, 75/ 4 hours', 'TV, DVD player'),
(35, 'HARI', 'Mitchell Conference Room', '15 people', '$150/ day, 75/ 4 hours', 'TV, DVD player'),
(36, 'HARI', 'The Heron\'s Roost', '150 people', '$150/ day, 75/ 4 hours', 'Video projection equipment, fireplace'),
(37, 'HARI', 'The Fox\'s Den', '50 people', '$150/ day, 75/ 4 hours', 'Video projection equipment, fireplace'),
(38, 'HARO', 'Shelter', '72 people', '$98.00/day', 'Fireplace & grill'),
(39, 'HARO', 'Shelter', '24 people', '$48.00/day', 'Fireplace & grill'),
(40, 'HARO', 'Shelter', '56 people', '$73.00/day', 'Fireplace & grill'),
(41, 'JONE', 'Auditorium', '75 people', '1/2 day 8am-noon or 1pm to 5pm  $103.00', ''),
(42, 'JONE', 'Auditorium', '75 people', 'All day    $178.00', ''),
(43, 'JONE', 'Classroom', '35 people', '1/2 day  8am-noon or 1pm to 5pm  $78.00', ''),
(44, 'JONE', 'Classroom', '35 people', 'All day  $153.00', ''),
(45, 'JONE', 'Shelter', '100 people', '$98.00/day', 'Swimming, canoeing, boating, volleyball'),
(46, 'JORD', 'Shelter', '30 people', '$48.00/day', 'Electricity & grill'),
(47, 'JORD', 'Shelter', '60 people', '$73.00/day', 'Electricity, fireplace & grill'),
(48, 'JORD', 'Shelter', '100 people', '$98.00/day', 'Electricity, fireplace & grill'),
(49, 'JORD', 'White Oak Recreation Area', '500 people', '$1,253.00/day', 'Private and exclusive use of:  Shelter, boat ramp, volleyball court, catering pad, horseshoes, and swimming area'),
(50, 'JORI', 'Auditorium', '75-100 people', '1/2 day 8am-noon or 1pm to 5pm  $103.00', ''),
(51, 'JORI', 'Auditorium', '75-100 people', 'All day    $178.00', ''),
(52, 'JORI', 'Shelter', '12-16 people', '$33.00/day', 'Grill'),
(53, 'KELA', 'Community Bldg.', '100 people', '$188.00/day', 'Kitchen, fireplace, grill, restrooms'),
(54, 'KELA', 'Shelter', '30 people', '$48.00/day', 'Grill'),
(55, 'KELA', 'Shelter', '60 people', '$73.00/day', 'Grill'),
(56, 'KELA', 'Conference Room', '15 people', '1/2 day  8am-noon or 1pm to 5pm  $78.00', ''),
(57, 'KELA', 'Conference Room', '15 people', 'All day   $153.00', ''),
(58, 'LAJA', 'Shelter', '100 people', '$98.00/day', 'Concession stand, swimming, canoeing'),
(59, 'LANO', 'Community Bldg.', '147 people', '$188.00/day', 'Kitchen, fireplace'),
(60, 'LANO', 'Shelter', '96 people', '$98.00/day', ''),
(61, 'LURI', 'Shelter', '100 people', '$98.00/day', 'Horseshoes, canoe/kayaking, boat ramp, trails, playfield, fishing'),
(62, 'MARI', 'Shelter', '100 people', '$95.00/day', 'Hiking trails, fishing pond'),
(63, 'MEMI', 'Auditorium', '70 people', '1/2 day  8am-noon or 1pm to 5pm  $103.00', ''),
(64, 'MEMI', 'Auditorium', '70 people', 'All day   $178.00', ''),
(65, 'MEMI', 'Classroom', '30 people', '1/2 day  8am-noon or 1pm to 5pm  $78.00', ''),
(66, 'MEMI', 'Classroom', '30 people', 'All day   $153.00', ''),
(67, 'MEMI', 'Outdoor classroom', '30 people', '1/2 day  8am-noon or 1pm to 5pm  $53.00', ''),
(68, 'MEMI', 'Outdoor classroom', '30 people', 'All day $78.00', ''),
(69, 'MEMI', 'Shelter', '60-70 people', '$73.00/day', ''),
(70, 'MEMO', 'Shelter', '70 people', '$73.00/day', 'Fireplace & grill'),
(71, 'MEMO', 'Classroom', '25 people', '1/2 day  8am-noon or 1pm to 5pm  $78.00', ''),
(72, 'MEMO', 'Classroom', '25 people', 'All day   $153.00', ''),
(73, 'MOJE', 'Shelter', '75 people', '$73.00/day', 'Fireplace and large grill'),
(74, 'MOMI', 'Classroom', '25 people', '1/2 day  8am-noon or 1pm to 5pm   $78.00', 'Concession stand, gift shop, museum'),
(75, 'MOMI', 'Classroom', '25 people', 'All day   $153.00', 'Concession stand, gift shop, museum'),
(76, 'MOMI', 'Lounge', '75 people', '1/2 day  8am-noon or 1pm to 5pm   $103.00', 'Restaurant'),
(77, 'MOMI', 'Lounge', '75 people', 'All day   $178.00', 'Restaurant'),
(78, 'MOMI', 'Shelter', '16 people', '$33.00/day', 'Fireplace'),
(79, 'MOMO', 'Community Bldg.', '110 people', '$188.00/day', 'Kitchen & restrooms'),
(80, 'MOMO', 'Shelter', '24 people', '$48.00/day', ''),
(81, 'MOMO', 'Shelter', '36 people', '$73.00/day', ''),
(82, 'MOMO', 'Shelter', '60 people', '$98.00/day', ''),
(83, 'NERI', 'Community Bldg.', '85 people', '$188.00/day', 'Meeting room, kitchen, restrooms'),
(84, 'NERI', 'Classroom', '48 people', '1/2 day  8am-noon or 1pm to 5pm  $78.00', ''),
(85, 'NERI', 'Classroom', '48 people', 'All day  $153.00', ''),
(86, 'NERI', 'Conference Room', '15 people', '1/2 day  8am-noon or 1pm to 5pm   $78.00', ''),
(87, 'NERI', 'Conference Room', '15 people', 'All day $153.00', ''),
(88, 'NERI', 'Shelter', '75 people', '$98.00/day', 'Fireplace & grill'),
(89, 'NERI', 'Shelter', '50 people', '$73.00/day', 'Grill'),
(90, 'PETT', 'Shelter', '12 people', '$33.00/day', 'Fishing pier'),
(91, 'PETT', 'Shelter', '36 people', '$73.00/day', 'Grill and boat ramp'),
(92, 'PIMO', 'Shelter', '35 people', '$73.00/day', 'Grill'),
(93, 'RARO', 'Classroom', '35 people', '1/2 day 8am-noon or 1pm to 5pm  $75.00', ''),
(94, 'RARO', 'Classroom', '35 people', 'All day   $150.00', ''),
(95, 'RARO', 'Auditorium', '60 people', '1/2 day  8am-noon or 1pm to 5pm   $100.00', ''),
(96, 'RARO', 'Auditorium', '60 people', 'All day   $175.00', ''),
(97, 'RARO', 'Shelter', '48 people', '$70.00/day', ''),
(98, 'RARO', 'Amphitheater', '50 people', '', ''),
(99, 'SILA', 'Classroom', '30 people', '1/2day 8am-noon or 1pm to 5pm  $78.00', ''),
(100, 'SILA', 'Classroom', '30 people', 'All day   $153.00', ''),
(101, 'SOMO', 'Auditorium', '76 people', '1/2 day 8am-noon or 1pm to 5pm  $103.00', ''),
(102, 'SOMO', 'Auditorium', '76 people', 'All day  $178.00', ''),
(103, 'SOMO', 'Classroom', '25 people', '1/2 day 8am-noon or 1pm to 5pm  $78.00', ''),
(104, 'SOMO', 'Classroom', '25 people', 'All day  $153.00', ''),
(105, 'SOMO', 'Shelter', '80 people', '$98.00/day', 'Fireplace & grill'),
(106, 'STMO', 'Shelter', '60 people', '$73.00/day', 'Fireplace, grill, electricity'),
(107, 'STMO', 'Shelter', '100 people', '$98.00/day', ''),
(108, 'WEWO', 'Auditorium', '70 people', '1/2 day 8am-noon or 1pm to 5pm  $103.00', ''),
(109, 'WEWO', 'Auditorium', '70 people', 'All day   $178.00', ''),
(110, 'WEWO', 'Classroom', '35 people', '1/2 day 8am-noon or 1pm to 5pm  $78.00', ''),
(111, 'WEWO', 'Classroom', '35 people', 'All day   $153.00', ''),
(112, 'WIUM', 'Shelter', '20 people', '$33.00/day', 'Fireplace & grill'),
(113, 'WIUM', 'Shelter', '60 people', '$73.00/day', 'Fireplace & grill'),
(114, 'WIUM', 'Shelter', '100 people', '$98.00/day', 'Fireplace & grill'),
(115, 'WIUM', 'Shelter', '125 people', '$98.00/day', 'Fireplace & grill'),
(116, 'HARI', 'Oak Dining Hall', '100 people', '$150/ day, 75/ 4 hours', ''),
(117, 'GORG', 'Shelter', '100 people', '$98.00/day', 'Fireplace, grill, electricity, water, restrooms'),
(118, 'GORG', 'Shelter', '100 people', 'reservable thru park office ', 'Fireplace, grill, electricity, water, restrooms'),
(119, 'GORG', 'Classroom', '40 people', 'reservable thru park office ', 'tables, chairs, sinks'),
(120, 'GORG', 'Auditorium', '75 people', 'reservable thru park office ', 'tables, chairs, complete AV system'),
(121, 'HABE', 'Auditorium', '75 people', '$178.00 all day   $103.00 half day', 'Podium, microphone, LCD projector, dry erase board'),
(125, 'HABE', 'Gazebo', '30 people', '$33.00', '2 picnic tables with a view of the water');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rental_facility`
--
ALTER TABLE `rental_facility`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rental_facility`
--
ALTER TABLE `rental_facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
