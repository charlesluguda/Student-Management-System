-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 08:19 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance1`
--

CREATE TABLE `attendance1` (
  `id` int(11) NOT NULL,
  `teacherID` int(11) DEFAULT NULL,
  `studentID` int(11) DEFAULT NULL,
  `attendance_status` varchar(255) DEFAULT NULL,
  `uploaded_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance1`
--

INSERT INTO `attendance1` (`id`, `teacherID`, `studentID`, `attendance_status`, `uploaded_date`, `created_at`) VALUES
(45, 22, 57, 'Present', '2024-06-14', '2024-06-12 18:43:19'),
(46, 22, 58, 'Present', '2024-06-14', '2024-06-12 18:43:19'),
(47, 22, 59, 'Present', '2024-06-14', '2024-06-12 18:43:19'),
(48, 22, 60, 'Present', '2024-06-14', '2024-06-12 18:43:20'),
(49, 22, 61, 'Present', '2024-06-14', '2024-06-12 18:43:20'),
(50, 22, 57, 'Present', '2024-06-07', '2024-06-12 20:28:15'),
(51, 22, 58, 'Present', '2024-06-07', '2024-06-12 20:28:15'),
(52, 22, 59, 'Present', '2024-06-07', '2024-06-12 20:28:16'),
(53, 22, 60, 'Present', '2024-06-07', '2024-06-12 20:28:16'),
(54, 22, 61, 'Present', '2024-06-07', '2024-06-12 20:28:16');

-- --------------------------------------------------------

--
-- Table structure for table `attendance2`
--

CREATE TABLE `attendance2` (
  `id` int(11) NOT NULL,
  `teacherID` int(11) DEFAULT NULL,
  `studentID` int(11) DEFAULT NULL,
  `subject_name` varchar(225) DEFAULT NULL,
  `attendance_status` varchar(255) DEFAULT NULL,
  `uploaded_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `attendance3`
--

CREATE TABLE `attendance3` (
  `id` int(11) NOT NULL,
  `teacherID` int(11) DEFAULT NULL,
  `studentID` int(11) DEFAULT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `attendance_status` varchar(255) DEFAULT NULL,
  `uploaded_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `attendance4`
--

CREATE TABLE `attendance4` (
  `id` int(11) NOT NULL,
  `teacherID` int(11) DEFAULT NULL,
  `studentID` int(11) DEFAULT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `attendance_status` varchar(255) DEFAULT NULL,
  `uploaded_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `attendance5`
--

CREATE TABLE `attendance5` (
  `id` int(11) NOT NULL,
  `teacherID` int(11) DEFAULT NULL,
  `studentID` int(11) DEFAULT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `attendance_status` varchar(255) DEFAULT NULL,
  `uploaded_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `attendance6`
--

CREATE TABLE `attendance6` (
  `id` int(11) NOT NULL,
  `teacherID` int(11) DEFAULT NULL,
  `studentID` int(11) DEFAULT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `attendance_status` varchar(255) DEFAULT NULL,
  `uploaded_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `attendance7`
--

CREATE TABLE `attendance7` (
  `id` int(11) NOT NULL,
  `teacherID` int(11) DEFAULT NULL,
  `studentID` int(11) DEFAULT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `attendance_status` varchar(255) DEFAULT NULL,
  `uploaded_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(10) NOT NULL,
  `studentID` int(10) NOT NULL,
  `comment` text NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentID`, `studentID`, `comment`, `dateCreated`) VALUES
(2, 60, 'Please We need you on monday of 23/4/2024 at school. Please come bila kukosa ', '2024-06-08 10:22:57'),
(3, 59, 'Unaombwa kufika shule sikuya jumatano, tafadhali zingatia hili', '2024-06-08 11:41:58'),
(22, 59, 'Come to school', '2024-06-10 13:19:58'),
(23, 59, 'Hi Brter', '2024-06-10 13:25:18'),
(24, 59, 'COme to scholl on monday', '2024-06-10 13:28:18'),
(25, 59, '  testing body', '2024-06-10 13:41:01'),
(26, 59, 'Njo shule', '2024-06-14 12:44:19'),
(27, 59, 'Notification Issue', '2024-06-19 15:00:31'),
(28, 59, 'Notification Issue', '2024-06-19 15:01:15');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `eventID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventID`, `title`, `date`, `time`, `location`, `description`) VALUES
(14, 'SHOOL MEETING', '2025-06-12', '08:00:00', 'At School', 'Fika bila kujosa, Ni mhimu sana '),
(15, 'Kutuma email kwa wote', '2222-12-12', '11:11:00', 'Scchool', 'Najaribu kutuma email notification'),
(16, 'SMS NORMAL', '2222-02-12', '22:02:00', 'Shulen', '12UEIHFDSBJCJ'),
(17, 'SMS NORMAL', '2222-02-12', '22:02:00', 'Shulen', '12UEIHFDSBJCJ'),
(18, 'SMS NORMAL', '2222-02-12', '22:02:00', 'Shulen', '12UEIHFDSBJCJ');

-- --------------------------------------------------------

--
-- Table structure for table `eventstrial`
--

CREATE TABLE `eventstrial` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `eventstrial`
--

INSERT INTO `eventstrial` (`id`, `title`, `description`, `date`, `created_at`) VALUES
(1, 'Kikao', 'Uje bro', '2024-05-30 15:16:00', '2024-06-19 12:16:18'),
(2, 'sss', 'sss', '2024-06-22 15:45:00', '2024-06-19 12:45:29'),
(3, 'dada', 'dada', '2024-06-21 16:01:00', '2024-06-19 13:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `resultID` int(11) NOT NULL,
  `studentID` int(11) DEFAULT NULL,
  `mathematics` int(11) DEFAULT NULL,
  `science` int(11) DEFAULT NULL,
  `english` int(11) DEFAULT NULL,
  `history` int(11) DEFAULT NULL,
  `geography` int(11) DEFAULT NULL,
  `total_marks` int(11) DEFAULT NULL,
  `average` int(11) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `std1_results`
--

CREATE TABLE `std1_results` (
  `result_id` int(11) NOT NULL,
  `studentID` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `kiswahili` int(11) DEFAULT NULL,
  `history` int(11) DEFAULT NULL,
  `science` int(11) DEFAULT NULL,
  `english` int(11) DEFAULT NULL,
  `mathematics` int(11) DEFAULT NULL,
  `total_marks` int(11) DEFAULT NULL,
  `average` decimal(8,2) DEFAULT NULL,
  `grade` varchar(11) DEFAULT NULL,
  `position` decimal(11,0) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `std1_results`
--

INSERT INTO `std1_results` (`result_id`, `studentID`, `fullname`, `kiswahili`, `history`, `science`, `english`, `mathematics`, `total_marks`, `average`, `grade`, `position`, `semester`, `month`) VALUES
(130, 60, 'Daudi Morice Shayo', 77, 43, 54, 54, 50, 278, '55.60', 'C', '1', 'Annually', 'September'),
(131, 59, 'Deogratius Morice Shayo', 99, 34, 21, 54, 66, 274, '54.80', 'C', '2', 'Annually', 'September'),
(132, 61, 'Felician Morice Shayo', 57, 12, 23, 56, 66, 214, '42.80', 'C', '5', 'Annually', 'September'),
(133, 58, 'Johnathan Amos Haruna', 65, 54, 20, 17, 66, 222, '44.40', 'C', '3', 'Annually', 'September'),
(134, 57, 'Mohammed Amos John', 67, 55, 34, 0, 66, 222, '44.40', 'C', '3', 'Annually', 'September');

-- --------------------------------------------------------

--
-- Table structure for table `std2_results`
--

CREATE TABLE `std2_results` (
  `result_id` int(11) NOT NULL,
  `studentID` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `kiswahili` int(11) DEFAULT NULL,
  `history` int(11) DEFAULT NULL,
  `science` int(11) DEFAULT NULL,
  `english` int(11) DEFAULT NULL,
  `mathematics` int(11) DEFAULT NULL,
  `total_marks` int(11) DEFAULT NULL,
  `average` decimal(8,2) DEFAULT NULL,
  `grade` varchar(11) DEFAULT NULL,
  `position` int(5) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `std3_results`
--

CREATE TABLE `std3_results` (
  `result_id` int(11) NOT NULL,
  `studentID` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `kiswahili` int(11) DEFAULT NULL,
  `history` int(11) DEFAULT NULL,
  `science` int(11) DEFAULT NULL,
  `english` int(11) DEFAULT NULL,
  `mathematics` int(11) DEFAULT NULL,
  `total_marks` int(11) DEFAULT NULL,
  `average` decimal(8,2) DEFAULT NULL,
  `grade` varchar(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `std3_results`
--

INSERT INTO `std3_results` (`result_id`, `studentID`, `fullname`, `kiswahili`, `history`, `science`, `english`, `mathematics`, `total_marks`, `average`, `grade`, `position`, `semester`, `month`) VALUES
(1, 66, 'Amen Juma Ally', NULL, NULL, 33, NULL, NULL, 33, '6.60', 'F', 2, 'Annually', 'September'),
(2, 69, 'Haruna Johnathan Ally', NULL, NULL, 22, NULL, NULL, 22, '4.40', 'F', 3, 'Annually', 'September'),
(3, 67, 'John Johnathan Ally', NULL, NULL, 56, NULL, NULL, 56, '11.20', 'F', 1, 'Annually', 'September');

-- --------------------------------------------------------

--
-- Table structure for table `std4_results`
--

CREATE TABLE `std4_results` (
  `result_id` int(11) NOT NULL,
  `studentID` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `kiswahili` int(11) DEFAULT NULL,
  `history` int(11) DEFAULT NULL,
  `science` int(11) DEFAULT NULL,
  `english` int(11) DEFAULT NULL,
  `mathematics` int(11) DEFAULT NULL,
  `total_marks` int(11) DEFAULT NULL,
  `average` decimal(8,2) DEFAULT NULL,
  `grade` varchar(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `std5_results`
--

CREATE TABLE `std5_results` (
  `result_id` int(11) NOT NULL,
  `studentID` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `kiswahili` int(11) DEFAULT NULL,
  `history` int(11) DEFAULT NULL,
  `science` int(11) DEFAULT NULL,
  `english` int(11) DEFAULT NULL,
  `mathematics` int(11) DEFAULT NULL,
  `total_marks` int(11) DEFAULT NULL,
  `average` decimal(8,2) DEFAULT NULL,
  `grade` varchar(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `std6_results`
--

CREATE TABLE `std6_results` (
  `result_id` int(11) NOT NULL,
  `studentID` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `kiswahili` int(11) DEFAULT NULL,
  `history` int(11) DEFAULT NULL,
  `science` int(11) DEFAULT NULL,
  `english` int(11) DEFAULT NULL,
  `mathematics` int(11) DEFAULT NULL,
  `total_marks` int(11) DEFAULT NULL,
  `average` decimal(10,0) DEFAULT NULL,
  `grade` varchar(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `std7_results`
--

CREATE TABLE `std7_results` (
  `result_id` int(11) NOT NULL,
  `studentID` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `kiswahili` int(11) DEFAULT NULL,
  `history` int(11) DEFAULT NULL,
  `science` int(11) DEFAULT NULL,
  `english` int(11) DEFAULT NULL,
  `mathematics` int(11) DEFAULT NULL,
  `total_marks` int(11) DEFAULT NULL,
  `average` decimal(8,2) DEFAULT NULL,
  `grade` varchar(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentID` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dateOfbirth` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentID`, `firstname`, `middlename`, `lastname`, `gender`, `username`, `email`, `dateOfbirth`, `phone`, `picture`, `class`, `password`) VALUES
(57, 'Mohammed', 'Amos', 'John', 'Male', 'mohammed', 'mo@gmaill.com', '2024-06-09', '0767434345', 'deo.jpg', '1', '$2y$10$5YyHTi0p/G9uDbU4ZHRti.o1a4ow97bdHsfHrqSq4KIpSdXMmgLxK'),
(58, 'Johnathan', 'Amos', 'Haruna', 'Male', 'haruna', 'jo@gmaill.com', '2024-06-09', '0767434345', 'go.jpg', '1', '$2y$10$PL1Z7rl9sHHTgGQCukDUqesvbiHspKn32e8.TS/T15K/JJAT6FPw2'),
(59, 'Deogratius', 'Morice', 'Shayo', 'Male', 'deo', 'deoshayo123@gmail.com', '2024-06-09', '0767434345', 'deo.jpg', '1', '$2y$10$aPJNIBotSa6rUhiK1Fk.Eej/KgIZVwt2saRrlVR.0FNqXUQLuekL.'),
(60, 'Daudi', 'Morice', 'Shayo', 'Male', 'daudi', 'deogratiusshayo99@gmail.com', '2024-06-09', '0767434345', 'images (2).jpg', '1', '$2y$10$QpCZnPVjAhCs7tuz4oXkjOpqNFDsyzDFiLPfOzxTKrg55FWwWRiTq'),
(61, 'Felician', 'Morice', 'Shayo', 'Male', 'feli', 'deogratiusshayo@gmail.com', '2024-06-09', '0767434345', 'images (2).jpg', '1', '$2y$10$bsxhQEHKri3enc2JyjHQFOVSeeFeusowMai4IHJPcG4wX62f4mRYS'),
(62, 'Eva', 'Morice', 'Shayo', 'Female', 'eva', 'eva@gmail.com', '2024-06-09', '0767434345', 'deo.jpg', '2', '$2y$10$99TbEY74ESQEse7bvbGapuKoIjDZqq.FfKwNYJ91i.HhmOd7uWJ0a'),
(63, 'Neema', 'Morice', 'Shayo', 'Female', 'neema', 'neema@gmail.com', '2024-06-09', '0767434345', 'images (2).jpg', '2', '$2y$10$wkfsZzjrAcP81p8qUju.Lud8oQSUZwJdWQHNpSE80MDHJRGxLBWOW'),
(64, 'Fortunatha', 'Morice', 'Shayo', 'Female', 'fortunatha', 'fortu@gmail.com', '2024-06-09', '0767434345', 'images (2).jpg', '2', '$2y$10$hnKwUKiqNiAI4Otx2I/gA.fUnfHwnZyg1NWAfCJynzQajQXM8ZQ9C'),
(65, 'Digna', 'Morice', 'Shayo', 'Female', 'digna', 'digna@gmail.com', '2024-06-09', '0767434345', 'here.png', '2', '$2y$10$wquko0hM7wbEC8MghhWHFOLPeAFXWlKxYU9q24C3ilAXxPL/JWuzq'),
(66, 'Amen', 'Juma', 'Ally', 'Female', 'amen', 'amen@gmail.com', '2024-06-09', '0767434345', 'go.jpg', '3', '$2y$10$N.g.bG.lLd5Q3mc0HhtFEOV6nv6VIWl3OZ4c45xMx.z8H91gbAZrq'),
(67, 'John', 'Johnathan', 'Ally', 'Female', 'johnas', 'jonathans@gmaill.com', '2024-06-09', '0767434345', 'computer-icons-power-symbol-login-button.jpg', '3', '$2y$10$T4GHNi1ukmo76oIhj4ef4./4LVRMn2RShb0R2pFNaOf/AAO1nrAJ6'),
(68, 'Amani', 'Johnathan', 'Ally', 'Female', 'amani', 'aman@gmaill.com', '2024-06-09', '0767434345', 'computer-icons-power-symbol-login-button.jpg', '2', '$2y$10$w2XnkFDfpUTkTPhqC.XKKeg9llJAhEhHe6jSBhsynZxrf6fHmiBsm'),
(69, 'Haruna', 'Johnathan', 'Ally', 'Male', 'amo', 'haruna@gmaill.com', '2024-06-09', '0767434345', 'go.jpg', '3', '$2y$10$xxjDbXiZgT1FE8JSgaFHeeU8U74/Xdz7rXcTTBxxhs5Kv7w/CPYnK');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `teacherID` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `class` int(11) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `teacherID`, `subject_name`, `class`, `teacher_name`, `email`) VALUES
(52, 18, 'Kiswahili', 1, 'Nkata Nkata', 'nkata@gmail.com'),
(53, 18, 'History', 1, 'Nkata Nkata', 'nkata@gmail.com'),
(54, 18, 'Geography', 1, 'Nkata Nkata', 'nkata@gmail.com'),
(55, 20, 'Kiswahili', 2, 'Daud Shayo', 'deogratiusshayo99@gmail.com'),
(57, 20, 'mathematics', 2, 'Daud Shayo', 'deogratiusshayo99@gmail.com'),
(58, 20, 'science', 1, 'Daud Shayo', 'deogratiusshayo99@gmail.com'),
(59, 19, 'science', 3, 'Deo Deo', 'deoshayo123@gmail.com'),
(60, 18, 'History', 3, 'Nkata Nkata', 'nkata@gmail.com'),
(61, 18, 'English', 1, 'Nkata Nkata', 'nkata@gmail.com'),
(62, 18, 'mathematics', 1, 'Nkata Nkata', 'nkata@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

CREATE TABLE `suggestions` (
  `suggestionID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `suggestion` text NOT NULL,
  `posted_date` datetime NOT NULL DEFAULT current_timestamp(),
  `is_read` varchar(255) NOT NULL DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suggestions`
--

INSERT INTO `suggestions` (`suggestionID`, `name`, `suggestion`, `posted_date`, `is_read`) VALUES
(12, 'Deogratius Morice Shayo', 'Hi there I have to go to the bank and I will be there in about that I just got home from work ', '2024-06-08 12:19:09', 'Read'),
(13, 'Deogratius Morice Shayo', 'Afterwards if you want to come over and watch the kids tonight ', '2024-06-08 12:19:26', 'Read'),
(14, 'Deogratius Morice Shayo', 'Justine Bateman you have a great birthday 💐', '2024-06-08 12:19:47', 'unread'),
(15, 'Deogratius Morice Shayo', 'Njoo basi tu nimeamua kumlipa mtu mzima za wewe ndo maana m mzima za wewe ', '2024-06-08 12:20:07', 'Read');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacherID` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `classteacher` int(2) DEFAULT NULL,
  `picture` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacherID`, `firstname`, `lastname`, `username`, `email`, `classteacher`, `picture`, `role`, `password`) VALUES
(18, 'Nkata', 'Nkata', 'nkata', 'nkata@gmail.com', NULL, 'computer-icons-power-symbol-login-button.jpg', 'user', '$2y$10$Qe/ymKR7yE7tWCVDkciT5OU/1Cu4yudkrJ8NHTl92W5BjOiNEDb4u'),
(19, 'Deo', 'Deo', 'deo', 'deoshayo123@gmail.com', NULL, 'go.jpg', 'admin', '$2y$10$VQsvvs7GfLZ0NcYlYfWy2eQELTOOmRNeeVVyWlGf7DV3Ik4sl/9Ly'),
(20, 'Daud', 'Shayo', 'daudi', 'deogratiusshayo99@gmail.com', 2, 'deo.jpg', 'user', '$2y$10$W5ObAI.jnjHrK1EA0nXeVOEoUACqlOkJvGYG.ZYxoscf8Ln1tI3QC'),
(22, 'FELICIAN', 'MORICE', 'feli', 'feliia@gmail.com', 1, 'deo.jpg', 'user', '$2y$10$awMfV4cax0YU9fYrhku.heWtGagsrbiIV03SNoSByX0ichwr491Iy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance1`
--
ALTER TABLE `attendance1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_studentID` (`studentID`),
  ADD KEY `fk_teacherID` (`teacherID`);

--
-- Indexes for table `attendance2`
--
ALTER TABLE `attendance2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_StudentID2` (`studentID`),
  ADD KEY `FK_TeacherID2` (`teacherID`);

--
-- Indexes for table `attendance3`
--
ALTER TABLE `attendance3`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_StudentID3` (`studentID`),
  ADD KEY `FK_TeacherID3` (`teacherID`);

--
-- Indexes for table `attendance4`
--
ALTER TABLE `attendance4`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_StudentID4` (`studentID`),
  ADD KEY `FK_TeacherID4` (`teacherID`);

--
-- Indexes for table `attendance5`
--
ALTER TABLE `attendance5`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_StudentID5` (`studentID`),
  ADD KEY `FK_TeacherID5` (`teacherID`);

--
-- Indexes for table `attendance6`
--
ALTER TABLE `attendance6`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_StudentID6` (`studentID`),
  ADD KEY `FK_TeacherID6` (`teacherID`);

--
-- Indexes for table `attendance7`
--
ALTER TABLE `attendance7`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_StudentID7` (`studentID`),
  ADD KEY `FK_TeacherID7` (`teacherID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `fk_studentID12` (`studentID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `eventstrial`
--
ALTER TABLE `eventstrial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`resultID`),
  ADD KEY `result` (`studentID`);

--
-- Indexes for table `std1_results`
--
ALTER TABLE `std1_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `fk_student_id` (`studentID`);

--
-- Indexes for table `std2_results`
--
ALTER TABLE `std2_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `fk_student` (`studentID`);

--
-- Indexes for table `std3_results`
--
ALTER TABLE `std3_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `fk_studentS` (`studentID`);

--
-- Indexes for table `std4_results`
--
ALTER TABLE `std4_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `fk_result` (`studentID`);

--
-- Indexes for table `std5_results`
--
ALTER TABLE `std5_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `fk_students_id` (`studentID`);

--
-- Indexes for table `std6_results`
--
ALTER TABLE `std6_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `fk_student6_id` (`studentID`);

--
-- Indexes for table `std7_results`
--
ALTER TABLE `std7_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `fk_student7_id` (`studentID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studentID`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `subjects_ibfk_1` (`teacherID`);

--
-- Indexes for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD PRIMARY KEY (`suggestionID`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacherID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance1`
--
ALTER TABLE `attendance1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `attendance2`
--
ALTER TABLE `attendance2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance3`
--
ALTER TABLE `attendance3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance4`
--
ALTER TABLE `attendance4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance5`
--
ALTER TABLE `attendance5`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance6`
--
ALTER TABLE `attendance6`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance7`
--
ALTER TABLE `attendance7`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `eventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `eventstrial`
--
ALTER TABLE `eventstrial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `resultID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `std1_results`
--
ALTER TABLE `std1_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `std2_results`
--
ALTER TABLE `std2_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `std3_results`
--
ALTER TABLE `std3_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `std4_results`
--
ALTER TABLE `std4_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `std5_results`
--
ALTER TABLE `std5_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `std6_results`
--
ALTER TABLE `std6_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `std7_results`
--
ALTER TABLE `std7_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `suggestions`
--
ALTER TABLE `suggestions`
  MODIFY `suggestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance1`
--
ALTER TABLE `attendance1`
  ADD CONSTRAINT `fk_studentID` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_teacherID` FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`teacherID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance2`
--
ALTER TABLE `attendance2`
  ADD CONSTRAINT `FK_StudentID2` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TeacherID2` FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`teacherID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance3`
--
ALTER TABLE `attendance3`
  ADD CONSTRAINT `FK_StudentID3` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TeacherID3` FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`teacherID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance4`
--
ALTER TABLE `attendance4`
  ADD CONSTRAINT `FK_StudentID4` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TeacherID4` FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`teacherID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance5`
--
ALTER TABLE `attendance5`
  ADD CONSTRAINT `FK_StudentID5` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TeacherID5` FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`teacherID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance6`
--
ALTER TABLE `attendance6`
  ADD CONSTRAINT `FK_StudentID6` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TeacherID6` FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`teacherID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance7`
--
ALTER TABLE `attendance7`
  ADD CONSTRAINT `FK_StudentID7` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TeacherID7` FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`teacherID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_studentID12` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `result` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `std1_results`
--
ALTER TABLE `std1_results`
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `std2_results`
--
ALTER TABLE `std2_results`
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `std3_results`
--
ALTER TABLE `std3_results`
  ADD CONSTRAINT `fk_studentS` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `std4_results`
--
ALTER TABLE `std4_results`
  ADD CONSTRAINT `fk_result` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `std5_results`
--
ALTER TABLE `std5_results`
  ADD CONSTRAINT `fk_students_id` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `std6_results`
--
ALTER TABLE `std6_results`
  ADD CONSTRAINT `fk_student6_id` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `std7_results`
--
ALTER TABLE `std7_results`
  ADD CONSTRAINT `fk_student7_id` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`teacherID`) REFERENCES `teachers` (`teacherID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
