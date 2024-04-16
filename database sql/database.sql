-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 05:41 AM
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
DROP DATABASE IF EXISTS `knb_database`;
CREATE DATABASE `knb_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `knb_database`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `user_id`) VALUES
(1, 'General Topics', 20),
(5, 'SUPER NEW', 20),
(7, 'yoooooooooooooooooo', 20);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `topic_id`, `author_id`, `title`, `content`, `created_at`) VALUES
(8, 6, 20, 'hey this is super cool', 'how come i cant make cool stuiff like you', '2024-04-15 22:29:53'),
(9, 6, 20, '&#60;h1&#62; HUGE &#60;/H&#62;', '&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;', '2024-04-15 22:31:01'),
(10, 6, 20, '&#60;h2&#62;ehhhhhhhhhhhhh&#60;/h2&#62;', '&#60;h2&#62;ehhhhhhhhhhhhh&#60;/h2&#62;', '2024-04-15 22:31:36');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `profiles_id` int(11) NOT NULL,
  `profiles_about` varchar(255) DEFAULT NULL,
  `profiles_introtitle` varchar(100) DEFAULT NULL,
  `profiles_introtext` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`profiles_id`, `profiles_about`, `profiles_introtitle`, `profiles_introtext`, `user_id`) VALUES
(11, '&lt;p&gt;heyeyey&lt;/p&gt;', 'loldeleldeoledodeldol', '&lt;p&gt;&lt;span style=&quot;background-color: #2dc26b;&quot;&gt;dsfasdfsdfewfwqegvwegq234gf3gh4&lt;/span&gt;&lt;/p&gt;', 20);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `category_id`, `title`, `topic_content`, `topic_starter_id`, `created_at`, `reply_count`) VALUES
(2, 1, 'Check out this sick Topic', '&#60;h1&#62;THERE IS SOME COOL STUFF&#38;nbsp;&#60;/h1&#62;', 20, '2024-04-15 21:48:41', 0),
(6, 7, 'ehhhhhhhhhhhhh', '&#60;p&#62;asdfafefewfwefewfefef&#60;/p&#62;', 20, '2024-04-15 22:11:19', 0),
(7, 1, 'fasdfasdfsdf', '&#60;p&#62;&#60;strong&#62;asafdasdasdfas f ewfqw&#60;/strong&#62;&#60;/p&#62;&#13;&#10;&#60;p&#62;&#38;nbsp;&#60;/p&#62;&#13;&#10;&#60;h1&#62;&#60;strong&#62;sdfgdfgdfgfg&#60;/strong&#62;&#60;/h1&#62;&#13;&#10;&#60;p style=&#34;text-align: right;&#34;&#62;&#38;nbsp;&#60;/p&#62;&#13;&#10;&#60;blockquote&#62;&#13;&#10;&#60;p style=&#34;text-align: right;&#34;&#62;&#60;strong&#62;sdfgdfgsdfgsdf ggre3wg 3ergh rggh&#60;/strong&#62;&#60;/p&#62;&#13;&#10;&#60;/blockquote&#62;', 20, '2024-04-16 01:38:09', 0),
(8, 5, 'duper new', '&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Everybody get up, it&#39;s time to slam now&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We got a real jam goin&#39; down&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Come on and slam, and welcome to the jam!&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Come on and slam, if you wanna jam!&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Hey you, whatcha gonna do?&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Hey you, whatcha gonna do?&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Hey you, whatcha gonna do?&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Hey you, whatcha gonna do?&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Party people in the house lets go&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;It&#39;s your boy &#34;Jay Ski&#34; a&#39;ight so&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Pass that thing and watch me flex&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Behind my back, you know what&#39;s next&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;To the jam, all in your face&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Wassup, just feel the bass&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Drop it, rock it, down the room&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Shake it, quake it, space KABOOM...&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Just work that body, work that body make sure you don&#39;t hurt no body&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Get wild and lose your mind take this thing into over-time&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Hey DJ, TURN IT UP&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;QCD gon&#39; burn it up&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon y&#39;all get on the floor so hey, let&#39;s go a&#39;ight&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Everybody get up, it&#39;s time to slam now&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We got a real jam goin&#39; down&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Wave your hands in the air if you feel fine&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We&#39;re gonna take it into overtime&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;C&#39;mon it&#39;s time to get hype say Whoop (there it is!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon all the fellas say Whoop (there it is!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon one time for the ladies say Whoop (there it is!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Now, all, the fellas say Whoop (there it is!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon and run, baby run&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon, c&#39;mon, do it, run baby run&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Yeah, you wanna hoop... so shoot, baby shoot&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Yeah, it&#39;s time to hoop... so shoot, baby shoot baby&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon and slam, and welcome to the jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon and slam, if you wanna jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon and slam, and welcome to the jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon and slam, if you wanna jam&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Slam, Bam, Thank you ma&#39;am, get on the floor and jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;If you see me on the microphone, girl you got me in a zone&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Move!) C&#39;mon, C&#39;mon and start the game&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Move!) Break it down, tell me your name&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Move!) We the team, I&#39;m the coach&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Move!) Let&#39;s dance all night from coast to coast&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Just slide!) Just slide, from left to right&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Just slide!) Just slide, yourself enlight&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;You see me, drop the bass, 3-1-1 all in your face&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Jam on it!) Jam on it, let&#39;s have some fun&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Jam on it!) Jam on it, One on One&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;You run the &#34;O&#34; and I run the &#34;D&#34;, so c&#39;mon baby just jam for me&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Everybody get up, it&#39;s time to slam now&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We got a real jam goin&#39; down&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Wave your hands in the air if you feel fine&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We&#39;re gonna take it into overtime&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Hey ladies! (Yeah!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all ready to stop? (NO!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all wanna know why? (Why?)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Cuz it&#39;s a Slam Jam!&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Fellas! (Yeah)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all ready to stop? (NO!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all wanna know why? (Why?)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Yo, it&#39;s time to Slam Jam!&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Everybody get up, it&#39;s time to slam now&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We got a real jam goin&#39; down&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Wave your hands in the air if you feel fine&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We&#39;re gonna take it into overtime&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb WRZytc&#34;&#62;&#60;strong&#62;C&#39;mon, everybody say &#34;Nah Nah Nah Nah Nah&#34;&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon, c&#39;mon, let me hear you say &#34;Hey ey ey O&#34;&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon, c&#39;mon, everybody &#34;Nah Nah Nah Nah Nah&#34;&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Just take the time to say &#34;Hey ey ey O&#34;&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Check it out, check it out&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all ready for this? (You know it!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Nah... y&#39;all ain&#39;t ready!&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all ready for this? (You know it!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon, check it out, y&#39;all ready to jam? (You know it!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Nah... I, I, I don&#39;t think so&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all ready to jam? (You know it!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon!&#60;/strong&#62;&#60;/h5&#62;', 20, '2024-04-16 01:45:51', 0);

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
  `creation_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role_id`, `creation_date`) VALUES
(20, 'funguy1337', 'fake@gmail.com', 'PASSword123', 935, '2024-04-15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profiles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--
ALTER TABLE `categories`
ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`topic_starter_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
