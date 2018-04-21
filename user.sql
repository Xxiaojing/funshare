-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2018 at 09:03 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `funshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `salted_password` varchar(128) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `profile_photo` varchar(128) NOT NULL,
  `label` varchar(128) NOT NULL,
  `private` tinyint(1) NOT NULL,
  `date_created` datetime(6) NOT NULL,
  `date_updated` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `salted_password`, `first_name`, `last_name`, `profile_photo`, `label`, `private`, `date_created`, `date_updated`) VALUES
(2, 'Rob', 'rob@gmail.com', '$2y$10$5APqkuCHbuxGK', '', '', '', '', 0, '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000'),
(8, 'Test', 'test@gmail.com', '$2y$10$Kyrkgx5dein7/61fUV05i.1nHbO7Ng.kzTpopvOMbOfpc8PYZyKTm', '', '', 'https://images.unsplash.com/photo-1505503076934-b9b847ee95ad?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=69ef6018f093728a7b2952c8', 'studygram ? ?22 | from Poland ?? | currently in Austria ?? ?4th year law student ? ?speaking/learning --> ?? ?? ?? ~~~ Contact ?', 0, '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000'),
(9, 'Kirsten', 'kirsten@gmail.com', '$2y$10$JJeySC5JCt5yPl5qIw3laeA55ftQG5hP0ZJF35mn3dpuoTr0uAKKi', 'Kirsten', 'Smith', '', '', 0, '2018-04-04 11:07:26.000000', '0000-00-00 00:00:00.000000'),
(10, 'James', 'james@gmail.com', '$2y$10$aX/II205VvRJeRjMO77Kz.nu61TbG/IczAKVAtSEr8q1Eu8HFyUEm', 'James', 'Smith', '', '', 0, '2018-04-04 11:15:22.000000', '0000-00-00 00:00:00.000000'),
(11, 'Yi', 'yi@gmail.com', '$2y$10$WpVFuQiIu8XUoNt5MhqVc.VCGAFvMsvZVK8rWwL9l7OTneQcpwPq2', 'Yi', 'Yang', '', '', 0, '2018-04-05 08:49:19.000000', '0000-00-00 00:00:00.000000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
