-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2019 at 12:59 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tgne`
--

-- --------------------------------------------------------

--
-- Table structure for table `event_urls`
--

CREATE TABLE `event_urls` (
  `event_url_id` int(11) NOT NULL,
  `event_url` varchar(255) NOT NULL,
  `event_ref` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `file_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `file_title`, `file_url`, `file_event`) VALUES
(2, '10960410_532422213562971_7064841905710741232_o.jpg', 'files/', 3);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL,
  `image_title` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `image_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `image_title`, `image_url`, `image_event`) VALUES
(3, '8rDeuAI.png', 'uploads/8rDeuAI.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tgne_events`
--

CREATE TABLE `tgne_events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_location` varchar(255) NOT NULL,
  `event_date` varchar(255) NOT NULL,
  `event_host` varchar(255) NOT NULL,
  `event_details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tgne_events`
--

INSERT INTO `tgne_events` (`event_id`, `event_name`, `event_location`, `event_date`, `event_host`, `event_details`) VALUES
(3, 'Sample event', 'Nowhere Special', '2030-06-30', 'Alexander Ono', 'This event is so far into the future it will be visible to users downloading this project for years to come! Wow!'),
(4, 'A past event', 'Somewhere', '2010-09-23', 'Alexander Ono', 'This event has passed and helps show the site functionality of showing past events.');

-- --------------------------------------------------------

--
-- Table structure for table `tgne_feedback`
--

CREATE TABLE `tgne_feedback` (
  `feedback_id` int(11) NOT NULL,
  `feedback_user` int(11) NOT NULL,
  `feedback_event` int(11) NOT NULL,
  `feedback_rating` int(11) NOT NULL,
  `feedback_comments` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tgne_registrants`
--

CREATE TABLE `tgne_registrants` (
  `registrant_id` int(11) NOT NULL,
  `registrant_event` int(11) NOT NULL,
  `registrant_username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tgne_reports`
--

CREATE TABLE `tgne_reports` (
  `report_id` int(11) NOT NULL,
  `report_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tgne_users`
--

CREATE TABLE `tgne_users` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_surname` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_hashpass` varchar(255) NOT NULL,
  `user_usertype` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tgne_users`
--

INSERT INTO `tgne_users` (`user_id`, `user_firstname`, `user_surname`, `user_username`, `user_hashpass`, `user_usertype`, `user_email`) VALUES
(1, 'admin', 'admin', 'administrator', '$2y$10$4tbA5b14EcZbbUpyuOYSguYYM/cZtqGe.YD9RvwuIjQmT/BrjzQPW', 'admin', 'admin'),
(2, 'user', 'user', 'test_user', '$2y$10$kVy..ZWPfGa0lSP5kXcOjebqit5NGCOzdzWSArpGELIOD.lF55yv6', 'user', 'user'),
(3, 'staff', 'staff', 'test_staff', '$2y$10$3cUwRAuLJ1/ISiLviOh7qezp7W9jO70c1SQ6NcE/.AQ2Id3rVq.5O', 'staff', 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `thumbnails`
--

CREATE TABLE `thumbnails` (
  `thumbnail_id` int(11) NOT NULL,
  `thumbnail_title` varchar(255) NOT NULL,
  `thumbnail_url` varchar(255) NOT NULL,
  `thumbnail_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_urls`
--
ALTER TABLE `event_urls`
  ADD PRIMARY KEY (`event_url_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `tgne_events`
--
ALTER TABLE `tgne_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `tgne_feedback`
--
ALTER TABLE `tgne_feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `tgne_registrants`
--
ALTER TABLE `tgne_registrants`
  ADD PRIMARY KEY (`registrant_id`);

--
-- Indexes for table `tgne_reports`
--
ALTER TABLE `tgne_reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `tgne_users`
--
ALTER TABLE `tgne_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `thumbnails`
--
ALTER TABLE `thumbnails`
  ADD PRIMARY KEY (`thumbnail_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_urls`
--
ALTER TABLE `event_urls`
  MODIFY `event_url_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tgne_events`
--
ALTER TABLE `tgne_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tgne_feedback`
--
ALTER TABLE `tgne_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tgne_registrants`
--
ALTER TABLE `tgne_registrants`
  MODIFY `registrant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tgne_reports`
--
ALTER TABLE `tgne_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tgne_users`
--
ALTER TABLE `tgne_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `thumbnails`
--
ALTER TABLE `thumbnails`
  MODIFY `thumbnail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
