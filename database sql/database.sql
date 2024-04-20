-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2024 at 06:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `knb_database`
--
CREATE DATABASE IF NOT EXISTS `knb_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `knb_database`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `user_id`, `date_created`) VALUES
(10, 'General Topics', 21, '2024-04-20 04:35:37'),
(11, 'Vegetarian/Vegan Bento', 21, '2024-04-20 04:44:03'),
(12, 'PHP admin died on me ', 21, '2024-04-20 04:44:57'),
(13, 'Chat', 21, '2024-04-20 04:45:27'),
(14, 'How many pages is this?', 21, '2024-04-20 04:45:57'),
(15, 'Weekly Bentos', 21, '2024-04-20 04:46:28'),
(16, 'TIME to RUSH', 21, '2024-04-20 04:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `topic_id`, `author_id`, `title`, `content`, `date_created`) VALUES
(13, 11, 21, 'wow ', 'so cool', '2024-04-20 04:35:50'),
(14, 12, 21, 'asdasd', 'hey know ', '2024-04-20 04:42:35'),
(15, 13, 21, 'nice', 'nice ', '2024-04-20 04:44:17'),
(16, 15, 21, 'wow ', 'not so cool', '2024-04-20 04:45:36');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `profiles_id` int(11) NOT NULL,
  `profiles_pfp` text NOT NULL,
  `profiles_about` varchar(255) DEFAULT NULL,
  `profiles_introtitle` varchar(100) DEFAULT NULL,
  `profiles_introtext` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`profiles_id`, `profiles_pfp`, `profiles_about`, `profiles_introtitle`, `profiles_introtext`, `user_id`) VALUES
(12, '../img/default_imgs/default_bento_2.png', 'Introduce your self here! whatever floats your boat', 'Hi! I am funguy1337', 'Welcome to my corner of the web. Take a look around and make yourself comfortable.', 21),
(13, '../img/default_imgs/cat_bento.png', 'Introduce your self here! whatever floats your boat', 'Hi! I am big_boss', 'Welcome to my corner of the web. Take a look around and make yourself comfortable.', 22);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `role_id` int(3) NOT NULL,
  `role_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(666, 'admin'),
(935, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `topic_content` text NOT NULL,
  `topic_starter_id` int(11) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `category_id`, `title`, `topic_content`, `topic_starter_id`, `date_created`, `reply_count`) VALUES
(11, 10, 'NEW TOPIC ', '&#60;p&#62;here is some new stuff&#60;/p&#62;', 21, '2024-04-20 04:35:37', 0),
(12, 10, 'Second topic', '&#60;p&#62;my php admin died so i have to retner all the data&#60;/p&#62;', 21, '2024-04-20 04:42:26', 0),
(13, 11, 'Check out this sick Topic', '&#60;p&#62;wow so cool&#60;/p&#62;', 21, '2024-04-20 04:44:03', 0),
(14, 12, 'No time left', '&#60;p&#62;have to renter all the data&#60;/p&#62;', 21, '2024-04-20 04:44:57', 0),
(15, 13, 'More pages ', '&#60;p&#62;need to make more pages before its too late&#60;/p&#62;', 21, '2024-04-20 04:45:27', 0),
(16, 14, 'More pages again ', '&#60;p&#62;still need to make more&#60;/p&#62;', 21, '2024-04-20 04:45:57', 0),
(17, 15, 'Weekly news', '&#60;p&#62;Post your weekly news!&#60;/p&#62;', 21, '2024-04-20 04:46:28', 0),
(18, 16, '3 more pages ', '&#60;p&#62;I actually have 14 mins left&#60;/p&#62;', 21, '2024-04-20 04:46:59', 0),
(19, 13, 'Almost there', '&#60;p&#62;visit this link for more info&#60;/p&#62;', 21, '2024-04-20 04:47:35', 0),
(20, 16, 'last but not least ', '&#60;p&#62;finally here we are&#60;/p&#62;', 21, '2024-04-20 04:47:56', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(30) NOT NULL,
  `role_id` int(3) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role_id`, `date_created`) VALUES
(21, 'funguy1337', 'fake@gmail.com', 'PASSword123', 935, '2024-04-19'),
(22, 'big_boss', 'what_a_thrill.snakeeater@gmail.com', 'But youre s0 supreme!', 666, '2024-04-19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `categories_ibfk_1` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`profiles_id`),
  ADD KEY `profiles_ibfk_1` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `topics_ibfk_2` (`topic_starter_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `FK_users_roles` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profiles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`topic_starter_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
