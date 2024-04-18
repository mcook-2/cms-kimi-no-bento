-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 11:14 AM
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
(1, 'General Topics', 20, '2024-04-17 20:59:34'),
(5, 'SUPER NEW', 20, '2024-04-17 20:59:34'),
(7, 'yoooooooooooooooooo', 20, '2024-04-17 20:59:34'),
(9, '1123123124', 20, '2024-04-17 20:59:34');

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
(8, 6, 20, 'hey this is super cool', 'how come i cant make cool stuiff like you', '2024-04-15 22:29:53'),
(9, 6, 20, '&#60;h1&#62; HUGE &#60;/H&#62;', '&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;&#60;h1&#62; HUGE &#60;/H&#62;', '2024-04-15 22:31:01'),
(10, 6, 20, '&#60;h2&#62;ehhhhhhhhhhhhh&#60;/h2&#62;', '&#60;h2&#62;ehhhhhhhhhhhhh&#60;/h2&#62;', '2024-04-15 22:31:36'),
(11, 9, 20, 'huhuhuh', 'iuogiugoiugiug', '2024-04-17 18:23:59'),
(12, 9, 20, 'oiophoihop', 'oijop0j[opjpoj', '2024-04-17 18:24:09');

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
(1, '', '&lt;p&gt;&lt;span title=&quot;Source:&amp;nbsp;Metal Gear Solid: Peace Walker&quot;&gt;&quot;&lt;em&gt;We have no nation, no philosophy, no ideology. We go where we&#039;re needed, fighting not for country, not for government, but for ourselves. We need n', 'BIG BOSS', '&lt;p&gt;&lt;strong&gt;Big Boss&lt;/strong&gt;, real name&amp;nbsp;&lt;strong&gt;John&lt;/strong&gt;,&lt;sup id=&quot;cite_ref-MGS4DB_3-0&quot; class=&quot;reference&quot;&gt;&lt;/sup&gt;also known as&amp;nbsp;&lt;strong&gt;Jack&lt;/strong&gt;, and formerly known as&amp;nbsp;&lt;strong&gt;Naked Snake&lt;/strong&gt;,&amp;nbsp;&lt;strong&gt;Vic Boss&lt;/strong&gt;,&lt;sup id=&quot;cite_ref-4&quot; class=&quot;reference&quot;&gt;&lt;/sup&gt;&lt;sup id=&quot;cite_ref-5&quot; class=&quot;reference&quot;&gt;&lt;/sup&gt;&lt;sup id=&quot;cite_ref-Vic_Boss_6-0&quot; class=&quot;reference&quot;&gt;&lt;/sup&gt;&lt;strong&gt;Ishmael&lt;/strong&gt;,&amp;nbsp;&lt;strong&gt;Saladin&lt;/strong&gt;, or simply&amp;nbsp;&lt;strong&gt;Snake&lt;/strong&gt;, was a renowned special forces operative and&amp;nbsp;&lt;a title=&quot;Mercenary&quot; href=&quot;https://metalgear.fandom.com/wiki/Mercenary&quot;&gt;mercenary&lt;/a&gt;&amp;nbsp;commander. He founded&amp;nbsp;&lt;a title=&quot;United States Army&quot; href=&quot;https://metalgear.fandom.com/wiki/United_States_Army&quot;&gt;U.S. Army&lt;/a&gt;&amp;nbsp;Special Forces Unit&amp;nbsp;&lt;a title=&quot;FOXHOUND&quot; href=&quot;https://metalgear.fandom.com/wiki/FOXHOUND&quot;&gt;FOXHOUND&lt;/a&gt;, along with the mercenary company&amp;nbsp;&lt;a title=&quot;Militaires Sans Fronti&amp;egrave;res&quot; href=&quot;https://metalgear.fandom.com/wiki/Militaires_Sans_Fronti%C3%A8res&quot;&gt;Militaires Sans Fronti&amp;egrave;res&lt;/a&gt;, and was one of the founding members of&amp;nbsp;&lt;a title=&quot;The Patriots&quot; href=&quot;https://metalgear.fandom.com/wiki/The_Patriots&quot;&gt;the Patriots&lt;/a&gt;. Big Boss later established the military states of&amp;nbsp;&lt;a title=&quot;Outer Heaven&quot; href=&quot;https://metalgear.fandom.com/wiki/Outer_Heaven&quot;&gt;Outer Heaven&lt;/a&gt;&amp;nbsp;and&amp;nbsp;&lt;a title=&quot;Zanzibar Land&quot; href=&quot;https://metalgear.fandom.com/wiki/Zanzibar_Land&quot;&gt;Zanzibar Land&lt;/a&gt; as bases for his companies, in order to realize his ambitions of creating a nation for soldiers. Consideed by some as &quot;The Greatest Warrior of the 20th Century,&quot; he earned such monikers as &quot;the Legendary Soldier&quot;&lt;sup id=&quot;cite_ref-7&quot; class=&quot;reference&quot;&gt;&lt;/sup&gt; and &quot;the Legendary Mercenary,&quot;&lt;sup id=&quot;cite_ref-8&quot; class=&quot;reference&quot;&gt;&lt;/sup&gt;feared in combat by both friend and foe as a hero and a madman.&lt;sup id=&quot;cite_ref-MG1_Manual_9-0&quot; class=&quot;reference&quot;&gt;&lt;/sup&gt;&lt;/p&gt;\r\n&lt;p&gt;During the&amp;nbsp;&lt;a title=&quot;Cold War&quot; href=&quot;https://metalgear.fandom.com/wiki/Cold_War&quot;&gt;Cold War&lt;/a&gt;, Big Boss was an apprentice to&amp;nbsp;&lt;a title=&quot;The Boss&quot; href=&quot;https://metalgear.fandom.com/wiki/The_Boss&quot;&gt;The Boss&lt;/a&gt;, the so-called &quot;Mother of Special Forces,&quot; and later served as a black ops field agent for the&amp;nbsp;&lt;a title=&quot;Central Intelligence Agency&quot; href=&quot;https://metalgear.fandom.com/wiki/Central_Intelligence_Agency&quot;&gt;CIA&lt;/a&gt;&#039;s&amp;nbsp;&lt;a title=&quot;FOX&quot; href=&quot;https://metalgear.fandom.com/wiki/FOX&quot;&gt;FOX Unit&lt;/a&gt;, under&amp;nbsp;&lt;a title=&quot;Zero&quot; href=&quot;https://metalgear.fandom.com/wiki/Zero&quot;&gt;Major Zero&lt;/a&gt;. Having his genetic code used as part of the government project&amp;nbsp;&lt;a title=&quot;Les Enfants Terribles&quot; href=&quot;https://metalgear.fandom.com/wiki/Les_Enfants_Terribles&quot;&gt;Les Enfants Terribles&lt;/a&gt;, Big Boss was the genetic father of&amp;nbsp;&lt;a title=&quot;Solid Snake&quot; href=&quot;https://metalgear.fandom.com/wiki/Solid_Snake&quot;&gt;Solid Snake&lt;/a&gt;&amp;nbsp;(his subordinate and later nemesis),&amp;nbsp;&lt;a title=&quot;Liquid Snake&quot; href=&quot;https://metalgear.fandom.com/wiki/Liquid_Snake&quot;&gt;Liquid Snake&lt;/a&gt;&amp;nbsp;and&amp;nbsp;&lt;a title=&quot;Solidus Snake&quot; href=&quot;https://metalgear.fandom.com/wiki/Solidus_Snake&quot;&gt;Solidus Snake&lt;/a&gt;. He was also the mental and physical template for his body double and former subordinate,&amp;nbsp;&lt;a title=&quot;Venom Snake&quot; href=&quot;https://metalgear.fandom.com/wiki/Venom_Snake&quot;&gt;Venom Snake&lt;/a&gt;, with whom he shared the title of &quot;Big Boss&quot;.&lt;/p&gt;', 1),
(11, '..\\uploads\\funguy1337\\0002.jpg', '&lt;p&gt;bfbds&lt;/p&gt;', '1231231', '&lt;p&gt;&lt;span style=&quot;background-color: #2dc26b;&quot;&gt;123123dasdffaws&lt;/span&gt;&lt;/p&gt;', 20);

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
(2, 1, 'Check out this sick Topic', '&#60;h1&#62;THERE IS SOME COOL STUFF&#38;nbsp;&#60;/h1&#62;', 20, '2024-04-15 21:48:41', 0),
(6, 7, 'ehhhhhhhhhhhhh', '&#60;p&#62;asdfafefewfwefewfefef&#60;/p&#62;', 20, '2024-04-15 22:11:19', 0),
(7, 1, 'fasdfasdfsdf', '&#60;p&#62;&#60;strong&#62;asafdasdasdfas f ewfqw&#60;/strong&#62;&#60;/p&#62;&#13;&#10;&#60;p&#62;&#38;nbsp;&#60;/p&#62;&#13;&#10;&#60;h1&#62;&#60;strong&#62;sdfgdfgdfgfg&#60;/strong&#62;&#60;/h1&#62;&#13;&#10;&#60;p style=&#34;text-align: right;&#34;&#62;&#38;nbsp;&#60;/p&#62;&#13;&#10;&#60;blockquote&#62;&#13;&#10;&#60;p style=&#34;text-align: right;&#34;&#62;&#60;strong&#62;sdfgdfgsdfgsdf ggre3wg 3ergh rggh&#60;/strong&#62;&#60;/p&#62;&#13;&#10;&#60;/blockquote&#62;', 20, '2024-04-16 01:38:09', 0),
(8, 5, 'duper new', '&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Everybody get up, it&#39;s time to slam now&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We got a real jam goin&#39; down&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Come on and slam, and welcome to the jam!&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Come on and slam, if you wanna jam!&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Hey you, whatcha gonna do?&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Hey you, whatcha gonna do?&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Hey you, whatcha gonna do?&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Hey you, whatcha gonna do?&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Party people in the house lets go&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;It&#39;s your boy &#34;Jay Ski&#34; a&#39;ight so&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Pass that thing and watch me flex&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Behind my back, you know what&#39;s next&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;To the jam, all in your face&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Wassup, just feel the bass&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Drop it, rock it, down the room&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Shake it, quake it, space KABOOM...&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Just work that body, work that body make sure you don&#39;t hurt no body&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Get wild and lose your mind take this thing into over-time&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Hey DJ, TURN IT UP&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;QCD gon&#39; burn it up&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon y&#39;all get on the floor so hey, let&#39;s go a&#39;ight&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Everybody get up, it&#39;s time to slam now&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We got a real jam goin&#39; down&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Wave your hands in the air if you feel fine&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We&#39;re gonna take it into overtime&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;C&#39;mon it&#39;s time to get hype say Whoop (there it is!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon all the fellas say Whoop (there it is!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon one time for the ladies say Whoop (there it is!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Now, all, the fellas say Whoop (there it is!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon and run, baby run&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon, c&#39;mon, do it, run baby run&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Yeah, you wanna hoop... so shoot, baby shoot&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Yeah, it&#39;s time to hoop... so shoot, baby shoot baby&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon and slam, and welcome to the jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon and slam, if you wanna jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon and slam, and welcome to the jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon and slam, if you wanna jam&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Slam, Bam, Thank you ma&#39;am, get on the floor and jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;If you see me on the microphone, girl you got me in a zone&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Move!) C&#39;mon, C&#39;mon and start the game&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Move!) Break it down, tell me your name&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Move!) We the team, I&#39;m the coach&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Move!) Let&#39;s dance all night from coast to coast&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Just slide!) Just slide, from left to right&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Just slide!) Just slide, yourself enlight&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;You see me, drop the bass, 3-1-1 all in your face&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Jam on it!) Jam on it, let&#39;s have some fun&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;(Jam on it!) Jam on it, One on One&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;You run the &#34;O&#34; and I run the &#34;D&#34;, so c&#39;mon baby just jam for me&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Everybody get up, it&#39;s time to slam now&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We got a real jam goin&#39; down&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Wave your hands in the air if you feel fine&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We&#39;re gonna take it into overtime&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Hey ladies! (Yeah!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all ready to stop? (NO!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all wanna know why? (Why?)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Cuz it&#39;s a Slam Jam!&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Fellas! (Yeah)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all ready to stop? (NO!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all wanna know why? (Why?)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Yo, it&#39;s time to Slam Jam!&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Everybody get up, it&#39;s time to slam now&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We got a real jam goin&#39; down&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb&#34;&#62;&#60;strong&#62;Wave your hands in the air if you feel fine&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;We&#39;re gonna take it into overtime&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Welcome to the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Here&#39;s your chance, do your dance at the Space Jam&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Alright...&#60;/strong&#62;&#60;/h5&#62;&#13;&#10;&#60;h5 class=&#34;ujudUb WRZytc&#34;&#62;&#60;strong&#62;C&#39;mon, everybody say &#34;Nah Nah Nah Nah Nah&#34;&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon, c&#39;mon, let me hear you say &#34;Hey ey ey O&#34;&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon, c&#39;mon, everybody &#34;Nah Nah Nah Nah Nah&#34;&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Just take the time to say &#34;Hey ey ey O&#34;&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Check it out, check it out&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all ready for this? (You know it!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Nah... y&#39;all ain&#39;t ready!&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all ready for this? (You know it!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon, check it out, y&#39;all ready to jam? (You know it!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Nah... I, I, I don&#39;t think so&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;Y&#39;all ready to jam? (You know it!)&#60;/strong&#62;&#60;br aria-hidden=&#34;true&#34;&#62;&#60;strong&#62;C&#39;mon!&#60;/strong&#62;&#60;/h5&#62;', 20, '2024-04-16 01:45:51', 0),
(9, 9, 'zzz', '&#60;p style=&#34;text-align: center;&#34;&#62;asdasdazxcacascasc&#60;/p&#62;', 20, '2024-04-17 18:22:22', 0),
(10, 7, 'HEY NOW ', '&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;&#13;&#10;&#60;p&#62;YOUR A ROCKSTAR&#60;/p&#62;', 20, '2024-04-17 18:30:55', 0);

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
(1, 'big_boss', 'what_a_thrill.snakeeater@gmail.com', 'But youre s0 supreme!', 666, '2024-04-18'),
(20, 'funguy1337', 'fake@gmail.com', 'PASSword123', 935, '2024-04-15');

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profiles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
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
