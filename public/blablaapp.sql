-- phpMyAdmin SQL Dump
-- version 4.6.4deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 23, 2017 at 11:40 AM
-- Server version: 5.6.30-1
-- PHP Version: 7.0.12-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blablaapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `blacklist`
--

CREATE TABLE `blacklist` (
  `blog_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL,
  `blog_name` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `tema` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blogs_followers`
--

CREATE TABLE `blogs_followers` (
  `blog_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id_comment` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deleted_friendships`
--

CREATE TABLE `deleted_friendships` (
  `id` int(11) NOT NULL,
  `user_deleted` int(11) NOT NULL,
  `bad_friend` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id_faq` int(11) NOT NULL,
  `question` varchar(200) NOT NULL,
  `answer` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `friendship_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `friend_username` varchar(25) NOT NULL,
  `date_of_request` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id_request` int(11) NOT NULL,
  `requester` varchar(25) NOT NULL,
  `receiver` varchar(25) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accepted` smallint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id_notification` int(11) NOT NULL,
  `type` enum('new post','new comment','friendship_request','friendship_deleted','friendship_accepted','new_follower','friendship_confermed','friendship_refused','post_deleted','blog_deleted','request_refused') DEFAULT NULL,
  `id_blog` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `usr_generator` varchar(25) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id_post` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `photo_name` varchar(100) DEFAULT NULL,
  `title` varchar(25) DEFAULT NULL,
  `post_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('user','staff','admin','') NOT NULL DEFAULT 'user',
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `age` date DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `profipic` varchar(55) DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `role`, `name`, `surname`, `age`, `description`, `profipic`, `hidden`) VALUES
('admin', 'admin', 'admin', 'admino', 'admini', '2017-03-04', 'sono un admin e ti ammazzo la famiglia', '15230584_10153985568475759_6994266332696376061_n.jpg', 0),
('asf', 'ciao', 'user', 'vsdvsdv', 'ipugf', '0000-00-00', 'fwevwe', '', 0),
('dddddddd', 'ddddd', 'user', 'ddddd', 'ddddddddd', '2016-12-22', 'ddddd', NULL, 0),
('fffffffffff', 'ffff', 'user', 'fifo', 'egwg', '2016-09-07', 'fff', NULL, 0),
('fifi', 'fifi', 'user', 'sdfsdf', 'fsdfsf', '2017-01-04', 'rwgrgre', 'Schermata da 2017-02-07 10-55-56.png', 0),
('ggggggggggg', 'ggggg', 'user', 'gigione', 'diannello', '1996-09-03', 'ffffffffff', '15193627_1864979280402408_2522230929106938691_n.jpg', 0),
('gianni', 'sperti', 'user', 'gianni', 'sperti', '2016-10-03', 'erberberbebeb bertn rwtnbrtn rfgtnrtbrtntrn rgtbnrtnb rgtnt', '16195169_10211798693187523_392228635709330715_n.jpg', 0),
('giorgio', 'aurispa', 'user', 'giorgio', 'aurispa', '1992-06-10', 'ciao il mio nome Ã¨ giorgio e vi ammazzo la famiglia.con affetto', '14907011_584205341782665_7078466994765738801_n.jpg', 1),
('ifugd', 'ciao', 'user', 'pisueg', 'isudg', '0000-00-00', 'uhgduisg', '', 0),
('iudvsgy', 'ciao', 'user', 'psiudvg', 'siudg', '0000-00-00', 'uigfie', '', 0),
('oaugf', 'ciao', 'user', 'vsdv', 'vsdv', '0000-00-00', 'vsdv', '', 0),
('staff', 'staff', 'staff', 'staffo', 'staffani', '2016-01-13', 'sono uno staff', 'Schermata da 2017-04-04 09-48-26.png', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`username`,`blog_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `blogs_followers`
--
ALTER TABLE `blogs_followers`
  ADD PRIMARY KEY (`blog_id`,`username`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`);

--
-- Indexes for table `deleted_friendships`
--
ALTER TABLE `deleted_friendships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faq`);

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`friendship_id`),
  ADD UNIQUE KEY `username` (`username`,`friend_username`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id_request`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id_notification`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `deleted_friendships`
--
ALTER TABLE `deleted_friendships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id_faq` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `friendship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
