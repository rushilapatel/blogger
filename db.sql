-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 26, 2017 at 08:33 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `blogdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_admin`
--

CREATE TABLE `blog_admin` (
  `adminId` int(11) NOT NULL,
  `adminName` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_admin`
--

INSERT INTO `blog_admin` (`adminId`, `adminName`, `password`, `email`) VALUES
(1, 'Demo', '$2y$10$wJxa1Wm0rtS2BzqKnoCPd.7QQzgu7D/aLlMR5Aw3O.m9jx3oRJ5R2', 'demo@demo.com');

-- --------------------------------------------------------

--
-- Table structure for table `blog_blogger`
--

CREATE TABLE `blog_blogger` (
  `bloggerId` int(11) NOT NULL,
  `bloggerEmail` varchar(255) NOT NULL,
  `bloggerName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userType` varchar(8) NOT NULL DEFAULT 'viewer'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_blogger`
--

INSERT INTO `blog_blogger` (`bloggerId`, `bloggerEmail`, `bloggerName`, `password`, `userType`) VALUES
(2, 'rushil@gmail.com', 'rushil', '$2y$10$NkZ0qeg1ZZ1AJgB6FCJBvOmH1IhItUB3rCvIhr7QFMdSkt.Xd3CIu', 'blogger'),
(3, 'parthivm20@gmail.com', 'parthiv', '$2y$10$7ztZCSsLa4duqjIC2Tf3Oeqc4M7R9O5hsbZ1dheY0077HN/MVkmQq', 'blogger'),
(4, 'vikas', 'vikas', '$2y$10$WpUm2orKfl4opG5GEDyh3etne5jsqsDfVeYsOYqmHo2iilqz/g4Tu', 'blogger'),
(10, 'swapnil', 'swapnil', '$2y$10$noMrvHf9gMnTrwqJLlD9quUWCQsFcMNRRHxuXc6os6QJ.Qw6AiiEq', 'viewer');

-- --------------------------------------------------------

--
-- Table structure for table `blog_follow`
--

CREATE TABLE `blog_follow` (
  `bloggerId` int(11) NOT NULL,
  `followingId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_follow`
--

INSERT INTO `blog_follow` (`bloggerId`, `followingId`) VALUES
(3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `blog_post`
--

CREATE TABLE `blog_post` (
  `postId` int(11) UNSIGNED NOT NULL,
  `postTitle` varchar(255) DEFAULT NULL,
  `postDesc` text,
  `postCont` text,
  `postDate` datetime DEFAULT NULL,
  `bloggerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_post`
--

INSERT INTO `blog_post` (`postId`, `postTitle`, `postDesc`, `postCont`, `postDate`, `bloggerId`) VALUES
(1, 'Bendless Love', '<p>That\'s right, baby. I ain\'t your loverboy Flexo, the guy you love so much. You even love anyone pretending to be him! Interesting. No, wait, the other thing: tedious. Hey, guess what you\'re accessories to. The alien mothership is in orbit here. If we can hit that bullseye, the rest of the dominoes will fall like a house of cards. Checkmate.</p>', '<h2>The Mutants Are Revolting</h2>\r\n<p>We don\'t have a brig. And until then, I can never die? We need rest. The spirit is willing, but the flesh is spongy and bruised. And yet you haven\'t said what I told you to say! How can any of us trust you?</p>\r\n<ul>\r\n<li>Oh, but you can. But you may have to metaphorically make a deal with the devil. And by \"devil\", I mean Robot Devil. And by \"metaphorically\", I mean get your coat.</li>\r\n<li>Bender?! You stole the atom.</li>\r\n<li>I was having the most wonderful dream. Except you were there, and you were there, and you were there!</li>\r\n</ul>\r\n<h3>The Series Has Landed</h3>\r\n<p>Fry! Stay back! He\'s too powerful! No. We\'re on the top. Fry, you can\'t just sit here in the dark listening to classical music.</p>\r\n<h4>Future Stock</h4>\r\n<p>Does anybody else feel jealous and aroused and worried? We\'re also Santa Claus! You\'re going back for the Countess, aren\'t you? Well, let\'s just dump it in the sewer and say we delivered it.</p>\r\n<ol>\r\n<li>Spare me your space age technobabble, Attila the Hun!</li>\r\n<li>You guys realize you live in a sewer, right?</li>\r\n<li>I guess if you want children beaten, you have to do it yourself.</li>\r\n<li>Yeah. Give a little credit to our public schools.</li>\r\n</ol>\r\n<h5>The Why of Fry</h5>\r\n<p>Who are you, my warranty?! Shinier than yours, meatbag. Dr. Zoidberg, that doesn\'t make sense. But, okay! Yes, except the Dave Matthews Band doesn\'t rock.</p>', '2013-05-29 00:00:00', 2),
(3, 'How Hermes Requisitioned His Groove Back', '<p>You\'re going back for the Countess, aren\'t you? Wow! A superpowers drug you can just rub onto your skin? You\'d think it would be something you\'d have to freebase. Now Fry, it\'s been a few years since medical school, so remind me. Disemboweling in your species: fatal or non-fatal? I don\'t want to be rescued. Leela, are you alright? You got wanged on the head.</p>', '<h2>The Luck of the Fryrish</h2>\r\n<p>Professor, make a woman out of me. I am the man with no name, Zapp Brannigan! Good man. Nixon\'s pro-war and pro-family. The alien mothership is in orbit here. If we can hit that bullseye, the rest of the dominoes will fall like a house of cards. Checkmate. Fry, you can\'t just sit here in the dark listening to classical music.</p>\r\n<ul>\r\n<li>Who are those horrible orange men?</li>\r\n<li>Is today\'s hectic lifestyle making you tense and impatient?</li>\r\n</ul>\r\n<h3>Lethal Inspection</h3>\r\n<p>Oh, but you can. But you may have to metaphorically make a deal with the devil. And by \"devil\", I mean Robot Devil. And by \"metaphorically\", I mean get your coat. No. We\'re on the top. Does anybody else feel jealous and aroused and worried? Well I\'da done better, but it\'s plum hard pleading a case while awaiting trial for that there incompetence. It must be wonderful.</p>\r\n<h4>Where No Fan Has Gone Before</h4>\r\n<p>Who are those horrible orange men? Bender, we\'re trying our best. Please, Don-Bot&hellip; look into your hard drive, and open your mercy file! Wow! A superpowers drug you can just rub onto your skin? You\'d think it would be something you\'d have to freebase. WINDMILLS DO NOT WORK THAT WAY! GOOD NIGHT! Look, last night was a mistake.</p>\r\n<ol>\r\n<li>I\'m sorry, guys. I never meant to hurt you. Just to destroy everything you ever believed in.</li>\r\n<li>Stop it, stop it. It\'s fine. I will \'destroy\' you!</li>\r\n<li>You guys realize you live in a sewer, right?</li>\r\n</ol>\r\n<h5>Fear of a Bot Planet</h5>\r\n<p>Why yes! Thanks for noticing. Hey, guess what you\'re accessories to. Yes, except the Dave Matthews Band doesn\'t rock. Take me to your leader! Daddy Bender, we\'re hungry.</p>', '2013-06-05 23:20:24', 2),
(6, 'The Cyber House Rules', '<p>You guys realize you live in a sewer, right? Uh, is the puppy mechanical in any way? Come, Comrade Bender! We must take to the streets! I daresay that Fry has discovered the smelliest object in the known universe! Good news, everyone! There\'s a report on TV with some very bad news!</p>', '<h2>The Luck of the Fryrish</h2>\r\n<p>Professor, make a woman out of me. I am the man with no name, Zapp Brannigan! Good man. Nixon\'s pro-war and pro-family. The alien mothership is in orbit here. If we can hit that bullseye, the rest of the dominoes will fall like a house of cards. Checkmate. Fry, you can\'t just sit here in the dark listening to classical music.</p>\r\n<ul>\r\n<li>Who are those horrible orange men?</li>\r\n<li>Is today\'s hectic lifestyle making you tense and impatient?</li>\r\n</ul>\r\n<h3>Lethal Inspection</h3>\r\n<p>Oh, but you can. But you may have to metaphorically make a deal with the devil. And by \"devil\", I mean Robot Devil. And by \"metaphorically\", I mean get your coat. No. We\'re on the top. Does anybody else feel jealous and aroused and worried? Well I\'da done better, but it\'s plum hard pleading a case while awaiting trial for that there incompetence. It must be wonderful.</p>\r\n<h4>Where No Fan Has Gone Before</h4>\r\n<p>Who are those horrible orange men? Bender, we\'re trying our best. Please, Don-Bot&hellip; look into your hard drive, and open your mercy file! Wow! A superpowers drug you can just rub onto your skin? You\'d think it would be something you\'d have to freebase. WINDMILLS DO NOT WORK THAT WAY! GOOD NIGHT! Look, last night was a mistake.</p>\r\n<ol>\r\n<li>I\'m sorry, guys. I never meant to hurt you. Just to destroy everything you ever believed in.</li>\r\n<li>Stop it, stop it. It\'s fine. I will \'destroy\' you!</li>\r\n<li>You guys realize you live in a sewer, right?</li>\r\n</ol>\r\n<h5>Fear of a Bot Planet</h5>\r\n<p>Why yes! Thanks for noticing. Hey, guess what you\'re accessories to. Yes, except the Dave Matthews Band doesn\'t rock. Take me to your leader! Daddy Bender, we\'re hungry.</p>', '2013-06-06 08:28:35', 2),
(7, 'XYZ', 'abcd efgh.\r\nkdndo odeei.\r\nkjefjio.fjfo\r\n', 'idfnoiqai\r\nefniioef\r\nnnef  faefnf efjef f fef', NULL, 3),
(8, 'Hello', '<p>dfjnfienf difnaifnaefaJ IWEUQKWBFQFEUJ NIJDFBFB IERFWIFBF</p>', '<p>NJEWFRIFNEBF O WIQNFEF IQWE INQWRB NWIJDFNQFNQ EF; AJIFAQIF.</p>', NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `blog_post_comment`
--

CREATE TABLE `blog_post_comment` (
  `commentId` int(11) NOT NULL,
  `postId` int(11) UNSIGNED NOT NULL,
  `bloggerId` int(11) NOT NULL,
  `comment_description` text NOT NULL,
  `comment_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_post_comment`
--

INSERT INTO `blog_post_comment` (`commentId`, `postId`, `bloggerId`, `comment_description`, `comment_created`) VALUES
(1, 1, 3, 'Very Nice', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `blog_post_like`
--

CREATE TABLE `blog_post_like` (
  `postId` int(11) UNSIGNED NOT NULL,
  `bloggerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_post_like`
--

INSERT INTO `blog_post_like` (`postId`, `bloggerId`) VALUES
(1, 2),
(6, 2),
(8, 2),
(3, 4),
(6, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_admin`
--
ALTER TABLE `blog_admin`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `blog_blogger`
--
ALTER TABLE `blog_blogger`
  ADD PRIMARY KEY (`bloggerId`),
  ADD UNIQUE KEY `email` (`bloggerEmail`);

--
-- Indexes for table `blog_post`
--
ALTER TABLE `blog_post`
  ADD PRIMARY KEY (`postId`),
  ADD KEY `bloggerId` (`bloggerId`);

--
-- Indexes for table `blog_post_comment`
--
ALTER TABLE `blog_post_comment`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `bloggerId` (`bloggerId`),
  ADD KEY `postId` (`postId`,`bloggerId`);

--
-- Indexes for table `blog_post_like`
--
ALTER TABLE `blog_post_like`
  ADD PRIMARY KEY (`postId`,`bloggerId`),
  ADD KEY `bloggerId` (`bloggerId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_admin`
--
ALTER TABLE `blog_admin`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `blog_blogger`
--
ALTER TABLE `blog_blogger`
  MODIFY `bloggerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `blog_post`
--
ALTER TABLE `blog_post`
  MODIFY `postId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `blog_post_comment`
--
ALTER TABLE `blog_post_comment`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_post`
--
ALTER TABLE `blog_post`
  ADD CONSTRAINT `blog_post_ibfk_1` FOREIGN KEY (`bloggerId`) REFERENCES `blog_blogger` (`bloggerId`);

--
-- Constraints for table `blog_post_comment`
--
ALTER TABLE `blog_post_comment`
  ADD CONSTRAINT `blog_post_comment_ibfk_1` FOREIGN KEY (`bloggerId`) REFERENCES `blog_blogger` (`bloggerId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_post_comment_ibfk_2` FOREIGN KEY (`postId`) REFERENCES `blog_post` (`postId`);

--
-- Constraints for table `blog_post_like`
--
ALTER TABLE `blog_post_like`
  ADD CONSTRAINT `blog_post_like_ibfk_1` FOREIGN KEY (`bloggerId`) REFERENCES `blog_blogger` (`bloggerId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_post_like_ibfk_2` FOREIGN KEY (`postId`) REFERENCES `blog_post` (`postId`) ON DELETE CASCADE ON UPDATE CASCADE;
