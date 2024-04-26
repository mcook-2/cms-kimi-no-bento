-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2024 at 10:20 AM
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
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `date_created`) VALUES
(1, 'General Topics', '2024-04-25 19:38:37'),
(2, 'Weekly Bentos', '2024-04-25 19:38:48'),
(3, 'Bento Box Basics', '2024-04-25 19:39:37'),
(4, 'Bento recipes', '2024-04-25 19:40:22'),
(5, 'Items for sale', '2024-04-25 19:41:29'),
(6, 'General Chat', '2024-04-25 19:41:44'),
(7, 'General Bento Discussion', '2024-04-25 19:42:09');

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
(1, 2, 2, 'Spring Bento Challenge?', 'Just wanting to see if anyone is interested in doing a Spring themed Bento? This forum looked a little dusty so I thought I would ask.', '2024-04-25 20:01:28'),
(2, 3, 2, 'How Bento Boxes Are Made', 'https://www.youtube.com/watch?v=lSbIHFt7Q1E', '2024-04-25 20:04:42'),
(3, 6, 5, 'Im a milk dud', 'check it out imma milk dud&#13;&#10;', '2024-04-26 02:49:31'),
(4, 1, 3, 'random ', 'this is so random', '2024-04-26 07:58:03');

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
(1, '../img/default_imgs/dog.jpg', '&lt;p&gt;Introduce your self here! whatever floats your boat&lt;/p&gt;', 'Hi! I am big_boss', '&lt;p&gt;Welcome to my corner of the web. Take a look around and make yourself comfortable.&amp;nbsp;&lt;/p&gt;', 2),
(2, '../img/default_imgs/default_bento_2.png', 'Introduce your self here! whatever floats your boat', 'Hi! I am funguy1337', 'Welcome to my corner of the web. Take a look around and make yourself comfortable.', 3),
(4, '../uploads/milk_dud/milk_dud_pfp.png', 'Introduce your self here! whatever floats your boat', 'Hi! I am milk_dud', 'Welcome to my corner of the web. Take a look around and make yourself comfortable.', 5);

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
  `img_url` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `category_id`, `title`, `topic_content`, `topic_starter_id`, `img_url`, `date_created`, `reply_count`) VALUES
(1, 1, '&#60;p&#62;Topics that doesn&#39;t fit anywhere else.&#60;/p&#62;', '&#60;p&#62;Post Topics that dont fit anywhere else&#60;/p&#62;', 2, NULL, '2024-04-25 19:44:22', 0),
(2, 2, 'Where we discuss special weekly themes/events/mini-challenges', '&#60;p&#62;Weekly updates on themes/events/mini-challenges!&#60;/p&#62;', 3, 'uploads/funguy1337/weekly-bento.jpg', '2024-04-25 19:46:34', 0),
(3, 3, 'Bento Basics', '&#60;h3&#62;What is a bento?&#60;/h3&#62;&#13;&#10;&#60;p&#62;Bento (written 弁当), or obento (お弁当) to use the honorific term, is the Japanese word for a meal served in a box. Beyond that basic definition though, just about anything goes as to what kind of box or container is used, as well as what is put inside that box,.&#60;/p&#62;&#13;&#10;&#60;h3&#62;Different types of bento&#60;/h3&#62;&#13;&#10;&#60;p&#62;(See also:&#38;nbsp;&#60;a href=&#34;http://justbento.com/handbook/bento-basics/popular-homemade-bento-types&#34;&#62;Types of homemade bento&#60;/a&#62;.)&#60;/p&#62;&#13;&#10;&#60;p&#62;There are several different kinds of bento, with different purposes.&#38;nbsp;&#60;em&#62;Makunouchi bento&#60;/em&#62;&#38;nbsp;are elaborate bento meals presented at formal meals, meant to be eaten at table. This is the type you will see served in restaurants, arranged in elegant lacquered boxes.&#38;nbsp;&#60;em&#62;Kouraku bento&#60;/em&#62;&#38;nbsp;are picnic bento, to be shared by a group of people enjoying themselves outdoors - the most popular settings is while enjoying the cherry blossoms in spring (&#60;em&#62;(o)hahanami&#60;/em&#62;).&#38;nbsp;&#60;em&#62;Ekiben&#60;/em&#62;&#38;nbsp;(a shortened form of&#38;nbsp;&#60;em&#62;eki bento&#60;/em&#62;) are boxed meals sold at train stations for travellers (though nowadays you can buy&#38;nbsp;&#60;em&#62;ekiben&#60;/em&#62;&#38;nbsp;at many other places, such as department store food halls or convenience stores).&#60;/p&#62;&#13;&#10;&#60;p&#62;The kind of bento that have garnered the most attention recently, especially outside of Japan are what are called&#38;nbsp;&#60;strong&#62;kyaraben&#60;/strong&#62;&#38;nbsp;or&#38;nbsp;&#60;strong&#62;charaben&#60;/strong&#62;, &#39;cute bento&#39; &#39;art bento&#39; or &#39;entertaining bento&#39; (&#60;em&#62;entertain-bento&#60;/em&#62;), extremely elaborately decorated small works of art, as exemplified by the work presented on sites like&#38;nbsp;&#60;a href=&#34;http://e-obento.com/&#34;&#62;e-obento&#60;/a&#62;&#38;nbsp;(Japanese). These are usually made by mothers for their small children. There can be a high level of competitiveness in this arena - there are tons of contests and such that feature these bentos.&#60;/p&#62;&#13;&#10;&#60;p&#62;Finally, there&#39;s the plain simple bento that most people bring to work or school for lunch. It&#39;s important to note that&#38;nbsp;&#60;strong&#62;most Japanese people do&#38;nbsp;&#60;em&#62;not&#60;/em&#62;&#38;nbsp;spend their time making elaborate charaben or &#39;cute bento&#39;&#60;/strong&#62;&#38;nbsp;- that&#39;s more in the realm of a hobby and craft rather than practical everyday living. The type of bento that JustBento concentrates on for the most part are&#38;nbsp;&#60;strong&#62;practical, tasty, healthy everyday bento lunches&#60;/strong&#62;.&#60;/p&#62;&#13;&#10;&#60;h3&#62;My bento inspiration&#60;/h3&#62;&#13;&#10;&#60;p&#62;As with a lot of things, my first inspiration for making bento lunches is my mother. Even with three kids and a full time job, my mother always managed to make delicious lunches for us to bring to school. They weren&#39;t always the very prettiest, but they were tasty, filling and healthy. I also take inspiration from other members of my family - my sisters and aunts and my late grandmothers. Finally, I also refer to a number of Japanese bento books.&#60;/p&#62;&#13;&#10;&#60;h3&#62;My bento philosophy&#60;/h3&#62;&#13;&#10;&#60;p&#62;Here is the basic bento philosophy that&#39;s behind the bento examples presented on this site.&#60;/p&#62;&#13;&#10;&#60;ul&#62;&#13;&#10;&#60;li&#62;I use bentos to incorporate some healthy food into my daily eating. Therefore I use as much vegetables and vegetable products as possible, watch the amount of oil and fat, and try to stay away from processed foods. (An sausage cut to look like a tiny octopus, aka an &#34;octodog&#34; or &#34;octopus wiener&#34;, may be cute, and I include such things on occasions, but they aren&#39;t the most healthy food.)&#60;/li&#62;&#13;&#10;&#60;li&#62;Along the healthy-eating lines, I try to keep the total caloric value of my bento lunches under 600 calories. This works out well within an 1800-2200 calorie daily allowance, which is what&#39;s recommended for a female of my height and activity level. It&#39;s quite easy to increase or decrease the amount though according to how much you want to eat. (See how to select the right bento box link below.)&#60;/li&#62;&#13;&#10;&#60;li&#62;The maximum time I want to spend on assembling my obento is 30 minutes. Most of the time I want it done under 20 minutes. (The approximate time taken for each bento is always indicated for the Complete Bentos featured.)&#60;/li&#62;&#13;&#10;&#60;li&#62;It has to be tasty and&#38;nbsp;&#60;strong&#62;safe to eat&#60;/strong&#62;&#38;nbsp;at room temperature, (with a few exceptions), leak- and spoil-resistant, and filling.&#60;/li&#62;&#13;&#10;&#60;li&#62;They should look appetizing, but I don&#39;t spend that much time making them really pretty and fancy. I like to keep things simple.&#60;/li&#62;&#13;&#10;&#60;li&#62;Since I want to save money by bringing my bento rather than eating out, I try to keep the cost down as much as possible.&#60;/li&#62;&#13;&#10;&#60;/ul&#62;&#13;&#10;&#60;p&#62;Please also keep in mind that most of my bento are made with adult eaters in mind, rather than kids. They can be adapted for kids of course by perhaps reducing the quantities, or just used as-is for teenagers.&#60;/p&#62;&#13;&#10;&#60;h3&#62;About 80% vegetarian/vegan&#60;/h3&#62;&#13;&#10;&#60;p&#62;Since one of my main objectives is to make my bentos healthy, many are totally vegetarian or vegan, while all rely heavily on vegetable products. Meat is not used often as a main ingredient. However, some dishes do use non-vegetarian flavoring or texturizing ingredients, such as oyster sauce, fish sauce, dried bonito flakes or dried shrimp, and eggs. I&#39;ve indicated when an obento is 100% vegetarian/vegan or not. Many bentos that are not vegetarian can be adapted to become so if needed. (I also use things like a little bit of sugar, tomato ketchup and so on as flavoring on occasion.)&#60;/p&#62;&#13;&#10;&#60;h3&#62;Incorporating brown rice and alternative whole grains&#60;/h3&#62;&#13;&#10;&#60;p&#62;Rice is the base for Japanese style bentos, and I have chosen to use brown rice (&#60;em&#62;genmai&#60;/em&#62;) in most cases, since it&#39;s nutritionally superior to white rice. White can be used instead. About half of the bentos presented here have Japanese flavors, but there are also plenty of not-Japanese bentos.&#60;/p&#62;&#13;&#10;&#60;h3&#62;1:1:2 (or more) carb:protein:vegetable ratio&#60;/h3&#62;&#13;&#10;&#60;p&#62;The traditional Japanese bento ratio of rice or carb (&#60;em&#62;shushoku&#60;/em&#62;), protein and other (usually vegetables) components is 4:2:1, or 4 parts rice to 2 parts protein to 1 part other ingredients. The recommended ratio, advocated by various nutritionists, for people trying to lose weight or eat healthily is 3:2:1. I aim more for a 1:1 ratio in terms of volume between rice and protein, with the rest taken up by lots of vegetables. In other words I try to have a bit less rice or other carb, and a lot more veggies. There is usually 3/4 to 1 cup of rice, which is about 160 to 220 calories, in each ~600 calorie bento box.&#60;/p&#62;', 3, NULL, '2024-04-25 19:49:24', 0),
(4, 4, 'Talk about bento-friendly recipe ideas and recipe questions here', '&#60;p&#62;Post your&#38;nbsp;recipe ideas and recipe questions here! &#60;/p&#62;', 3, 'uploads/funguy1337/recipe_cheat_sheet.jpg', '2024-04-25 19:52:44', 0),
(5, 5, 'List items you want to sell here.', '&#60;p&#62;Forum to post any items to sell!&#60;/p&#62;', 2, NULL, '2024-04-25 19:54:04', 0),
(6, 6, '&#60;p&#62;Stuff that doesn&#39;t fit anywhere else.&#38;nbsp;&#60;/p&#62;', '&#60;p&#62;chat away...!&#60;/p&#62;', 2, 'uploads/big_boss/random_chat.gif', '2024-04-25 19:57:53', 0),
(7, 7, 'Bento talk that doesn&#39;t fit elsewhere', '&#60;h1&#62;bento related comments &#60;em&#62;ONLY!!&#60;/em&#62;&#60;/h1&#62;', 2, NULL, '2024-04-25 19:59:14', 0),
(8, 3, 'Bento Equipment', '&#60;p&#62;Bento boxes, cutters, bento-making appliances and gear&#60;/p&#62;', 2, NULL, '2024-04-25 20:09:02', 0),
(9, 4, 'Bento recipe cookbook', '&#60;p&#62;A collection of member contributed individual bento-friendly recipes.&#60;/p&#62;', 2, NULL, '2024-04-25 20:10:06', 0),
(10, 6, '&#60;p&#62;Introductions&#60;/p&#62;', '&#60;p&#62;Come on in and introduce yourself!&#60;/p&#62;', 2, NULL, '2024-04-25 20:16:59', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role_id` int(3) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `role_id`, `date_created`) VALUES
(2, 'big_boss', 'what_a_thrill.snakeeater@gmail.com', '$2y$10$eIpLjbLMc4ytKG4TUhMXvebyJK7hTd7fnyNEeP6Ej8ltME1L/2Jya', 666, '2024-04-25'),
(3, 'funguy1337', 'fake@gmail.com', '$2y$10$fce5vk2DDngcVorSiekVsOxM6DovuzUxkEgZY.uq9qpwA1.MEL.qq', 935, '2024-04-25'),
(5, 'milk_dud', 'milk.dud@gmail.com', '$2y$10$m/K.XRgTtF/kcJFCdOIxEujUqC2/ATSPtgbPjFGoFsWgoPH6FVTfu', 935, '2024-04-25');

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profiles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

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
