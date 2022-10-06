-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2022 at 08:04 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `add_date` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `catID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bookid`, `name`, `description`, `price`, `author`, `add_date`, `image`, `catID`) VALUES
(6, 'Resisting Happiness', 'A True Story about Why We Sabotage Ourselves', '2', 'matthew kelly', '2022-09-27', '3544705163_bf93b21ca6f860b22862fb495157ee5e.jpg', 2),
(7, 'Never Split the Difference', ' Negotiating As If Your Life Depended On It', '5', 'chirs voss', '2022-09-27', '2396917264_10edeea9ba31edcd27e615f89715c89b.jpg', 2),
(8, 'You Are a Badass', ' How to Stop Doubting Your Greatness and Start Living an Awesome Life ', '7', 'Jen Sincero', '2022-09-27', '423507198_ed19b7359e71ccbe68ae0d2fd975b46a-s.jpg', 2),
(9, 'I am Malala:', 'The Story of the Girl Who Stood Up for Education', '8', 'malala', '2022-09-27', '4219984358_96921e068f4aa96042ff3d9425368769.jpg', 4),
(10, 'How to Win Every Argument', 'How to Win Every Argumentin your life ', '7', 'Madsen Pirie', '2022-09-27', '1034668494_76f4460e5e7d2ed6f9f351a3233372db.jpg', 4),
(11, 'Spoken English Learned Quickly', 'Spoken English Learned Quickly', '8', 'Lynn Lundquist', '2022-09-27', '4354792402_05294c6924d3058cb2125c7b76e61556.jpg', 4),
(12, 'The Art and Craft of Problem Solving', 'The Art and Craft of Problem Solving', '8', 'paul zeitz', '2022-09-27', '3401971315_015a954e1fd74465f581a09febf13901.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `catID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catID`, `name`, `description`, `date`) VALUES
(1, 'scientific  ', 'this category has scientific  books', '2022-09-24'),
(2, 'Most popular ', 'popular books ', '2022-09-25'),
(4, 'Academic & Education', 'learning books', '2022-09-25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `register_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `approve` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`, `email`, `fullname`, `register_date`, `status`, `approve`) VALUES
(1, 'mohamed ', '444444', 'mohamed192510@gmail.com', '\r\n', '0000-00-00', 1, 1),
(7, 'zakaria', 'dad3a37aa9d50688b5157698acfd7aee', 'zakaria@gmail.com', 'mohamed zakaria', '2022-09-22', 0, 1),
(8, 'ahmed', 'd4c5630db0ec3444ec43c0982a9e83d3', 'khaked@gmail.com', 'ahmed khaled', '2022-09-22', 0, 1),
(17, 'el3bd', '35f4c6935a5b12e153823758965bf557', 'el3bd@gmail.com', 'mohamed osma', '2022-09-24', 0, 1),
(18, 'yousry', 'f63f4fbc9f8c85d409f2f59f2b9e12d5', 'yousry@gmail.com', 'ahmed yousry', '2022-09-24', 0, 1),
(19, 'mahmoud', '21218cca77804d2ba1922c33e0151105', 'saber@gmail.com', 'mahmoud saber', '2022-09-24', 0, 0),
(20, 'shaker', '73882ab1fa529d7273da0db6b49cc4f3', 'shaker@gmail.com', 'mahmoud shaker', '2022-09-24', 0, 0),
(21, 'kamal', '73882ab1fa529d7273da0db6b49cc4f3', 'kamal@gmail.com', 'mahmoud kamal', '2022-09-24', 0, 0),
(23, 'mohameddd', '11ddbaf3386aea1f2974eee984542152', 'mohamed.fathy30112000@gmail.comdd', '', '2022-09-30', 0, 0),
(25, 'sara ', '21218cca77804d2ba1922c33e0151105', 'sarakhaled@gmail.com', 'sara khaled', '2022-10-05', 0, 1),
(26, 'dina', 'f63f4fbc9f8c85d409f2f59f2b9e12d5', 'dina@gmail.com', 'dina', '2022-10-05', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookid`),
  ADD KEY `catbook_1` (`catID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`catID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bookid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `catID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `catbook_1` FOREIGN KEY (`catID`) REFERENCES `categories` (`catID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
