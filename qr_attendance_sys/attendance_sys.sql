
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




CREATE TABLE `admin` (
  `admin_id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int NOT NULL,
  `sid` int NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent','Holiday') COLLATE utf8mb4_general_ci DEFAULT 'Absent',
  `recorded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `sid`, `date`, `status`, `recorded_at`) VALUES
(4, 40, '2024-09-24', 'Present', '2024-09-24 02:02:22'),
(6, 42, '2024-09-24', 'Present', '2024-09-24 02:22:34'),
(7, 43, '2024-09-24', 'Present', '2024-09-24 02:45:47'),
(8, 44, '2024-09-24', 'Present', '2024-09-24 02:57:42');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `posted_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `student_details` (
  `sid` int NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `image` blob,
  `fathers_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mothers_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `grade` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `section` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dob` date NOT NULL,
  `mobileno` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `qr_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `student_details` (`sid`, `first_name`, `last_name`, `address`, `image`, `fathers_name`, `mothers_name`, `grade`, `section`, `gender`, `dob`, `mobileno`, `email`, `qr_code`, `created_date`) VALUES
(40, 'shyam', 'maharjan', 'patan', 0x2e2e2f75706c6f6164732f41492067656e65726174656420496d616765732e6a7067, 'ram', 'gita', '5', 'A', 'Male', '2003-01-03', '9830157895', 'shyam@gmail.com', 'student_40.png', '2024-09-24 02:01:20'),
(42, 'Neer', 'Shrestha', 'Gwarko', 0x2e2e2f75706c6f6164732f41492067656e65726174656420496d616765732e6a7067, 'Jhalak Shrestha', 'Dil Maya Shrestha', '9', 'A', 'Male', '2002-10-10', '9812345678', 'neer@gmail.com', 'student_42.png', '2024-09-24 02:21:57'),
(43, 'Hari', 'Dhakal', 'patan-1', 0x2e2e2f75706c6f6164732f696d6167652e706e67, 'Ram', 'SIta', '4', 'C', 'Male', '2003-01-03', '9865328574', 'hari@gmail.com', 'student_43.png', '2024-09-24 02:44:07'),
(44, 'ABC', 'ABC', 'ACB', 0x2e2e2f75706c6f6164732f696d6167652e706e67, 'ACB', 'ABC', '1', 'A', 'Male', '2000-10-11', '9815245758', 'ABC@gmail.com', 'student_44.png', '2024-09-24 02:55:51');


ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id` (`sid`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `student_details`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `admin`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `attendance`
  MODIFY `attendance_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `notices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `student_details`
  MODIFY `sid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `student_details` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;