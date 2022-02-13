-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2021 at 04:26 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(12, 'Hand Made', 'Hand Made Item', 0, 2, 0, 0, 0),
(13, 'Computers', 'computers Item', 0, 0, 0, 0, 0),
(14, 'Cell Phones', 'Cell Phones Item', 0, 3, 0, 0, 0),
(15, 'Clothing', 'Clothing Item', 0, 4, 0, 0, 0),
(16, 'Tools', 'Home Tools', 0, 5, 0, 0, 0),
(17, 'Nokia', 'Nokia Phones', 13, 2, 0, 0, 0),
(19, 'boxes', 'very best', 16, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_ID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_ID`, `comment`, `status`, `comment_date`, `item_ID`, `user_ID`) VALUES
(7, 'hello i amm khalid', 0, '2021-07-14', 10, 5),
(8, 'yes thats very good', 1, '2021-07-28', 11, 2),
(9, 'this is very nice toys\r\n', 1, '2021-07-28', 13, 1),
(10, 'this is very nice toys\r\n', 1, '2021-07-28', 13, 1),
(11, 'this is very nice toys\r\n', 0, '2021-07-28', 13, 1),
(12, 'this is abig data and hardwere', 1, '2021-07-28', 12, 7),
(13, 'this is abig data and hardwere', 0, '2021-07-28', 12, 7),
(14, 'this is abig data and hardwere', 0, '2021-07-28', 12, 1),
(15, 'this is very nice data', 1, '2021-07-28', 12, 1),
(16, 'this is very nice data', 0, '2021-07-28', 12, 1),
(17, 'this is very nice data', 0, '2021-07-28', 12, 1),
(18, 'this is very nice data', 0, '2021-07-28', 12, 1),
(19, 'this is very nice data', 0, '2021-07-28', 12, 1),
(20, 'this is very nice data', 0, '2021-07-28', 12, 1),
(21, 'this is very nice data', 0, '2021-07-28', 12, 1),
(22, 'this is very nice data', 0, '2021-07-28', 12, 1),
(23, 'this is very nice data', 0, '2021-07-28', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `add_date` date NOT NULL,
  `country_made` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rating` smallint(6) NOT NULL,
  `approve` tinyint(4) NOT NULL DEFAULT 0,
  `cat_ID` int(11) NOT NULL,
  `member_ID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_ID`, `Name`, `Description`, `Price`, `add_date`, `country_made`, `image`, `status`, `rating`, `approve`, `cat_ID`, `member_ID`, `tags`) VALUES
(7, 'Speaker', 'very good spreaker', '$10', '2021-07-13', 'japan', '', '1', 0, 0, 13, 2, ''),
(8, 'i phone 7 plus', 'very good cell phone', '$1300', '2021-07-13', 'USA', '', '2', 0, 1, 14, 7, ''),
(9, 'T-shirt', 'nice T-shirt', '$9', '2021-07-13', 'Germany', '', '1', 0, 1, 15, 5, ''),
(10, 'keyboard', 'nice keyboard to use', '$15', '2021-07-14', 'Egypt', '', '3', 0, 1, 13, 4, ''),
(11, 'projector', 'HD quality', '$230', '2021-07-14', 'UAE', '', '1', 0, 0, 13, 2, ''),
(12, 'Hardware', '1 tera his space', '$500', '2021-07-14', 'USA', '', '1', 0, 0, 13, 7, ''),
(13, 'Toys', 'Best For Children', '$30', '2021-07-25', 'Poland', '', '2', 0, 0, 12, 1, ''),
(14, 'Mouse', 'Important For Any PC', '33', '2021-07-25', 'USA', '', '1', 0, 0, 13, 1, ''),
(15, 'Mouse', 'Important For Any PC', '33', '2021-07-25', 'USA', '', '1', 0, 1, 13, 1, ''),
(16, 'stories', 'very nice stories', '15', '2021-07-31', 'saudi arabia', '', '1', 0, 0, 12, 1, 'handmade, stories, computers'),
(17, 'Wooding game', 'best play', '$99', '2021-08-03', 'USA', '', '1', 0, 0, 12, 1, 'msalah, wood, handmade'),
(18, 'Diablo |||', 'good Playstation game', '55', '2021-08-03', 'USA', '', '1', 0, 1, 13, 1, 'computers, playstation'),
(19, 'Wipes', 'very nice to hand', '10', '2021-08-03', 'egypt', '', '1', 0, 1, 12, 1, 'handmade, cleaner'),
(20, 'thfyh', 'hfhtfhtnyjyf yuf yhyf ', '55', '2021-08-03', 'gjngy', '', '1', 0, 1, 16, 1, 'handmade, cleaner');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL COMMENT 'To identify users',
  `username` varchar(255) NOT NULL COMMENT 'username to login',
  `password` varchar(255) NOT NULL COMMENT 'password to login',
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `groupID` int(11) NOT NULL DEFAULT 0 COMMENT 'identify user group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'saler rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'user approval',
  `Date` date NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`, `email`, `fullname`, `groupID`, `TrustStatus`, `RegStatus`, `Date`, `avatar`) VALUES
(1, 'mohamed', '601f1889667efaebb33b8c12572835da3f027f78', 'mohamed.salah7901@gmail.com', 'mohamed salah', 1, 0, 1, '0000-00-00', ''),
(2, 'ahmed', '3d48a4fc63ab3f1ef500999d34e5051990e70b8e', 'ahmed@gmail.com', 'ahmed essam', 0, 0, 1, '2021-06-18', ''),
(4, 'nagwaa', '227b39264604e64df908869f15c75b20a351dc2f', 'nagwa_khalid@gmail.com', 'nagwa khalid essam', 0, 0, 1, '2021-06-18', ''),
(5, 'khalid', 'ccbe91b1f19bd31a1365363870c0eec2296a61c1', 'khalid@gmail.com', 'khalid osama', 0, 0, 0, '2021-06-19', ''),
(7, 'nahla', 'ed7863564afcda90d7222274dadbbed1cbb32396', 'nahla_alaa@gmail.com', 'nahla alaa essam', 0, 0, 1, '2021-06-18', ''),
(9, 'alaa', 'ccbe91b1f19bd31a1365363870c0eec2296a61c1', 'alaa@gmail.com', 'alaa osama', 0, 0, 1, '2021-07-19', ''),
(10, 'ola', '381664f19845e3d57c071007c0139a428bf459d4', 'ola@kdlah', 'ola mahmoud', 0, 0, 1, '2021-07-12', ''),
(11, 'Ismail', '1a2bf0adea0f4b41ed9f7a02d31fa535d5743f3e', 'ismail@gmail.com', '', 0, 0, 0, '2021-07-19', ''),
(12, 'amiir', '601f1889667efaebb33b8c12572835da3f027f78', 'amiir@gmail.com', 'amiir adel', 0, 0, 1, '2021-09-11', ''),
(13, 'kjgkjgd', 'dfe961aeed90d0de45399e988ae2e069ee827bfc', 'vgfrs@sdffds', 'advsdfgvs', 0, 0, 1, '2021-09-11', '90508161_download.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_ID`),
  ADD KEY `item_comment` (`item_ID`),
  ADD KEY `user_comments` (`user_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_ID`),
  ADD KEY `member_1` (`member_ID`),
  ADD KEY `cat_1` (`cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To identify users', AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `item_comment` FOREIGN KEY (`item_ID`) REFERENCES `items` (`item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_comments` FOREIGN KEY (`user_ID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`member_ID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
