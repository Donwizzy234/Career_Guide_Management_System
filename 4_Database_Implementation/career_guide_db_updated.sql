-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 03:19 PM
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
-- Database: `career_guide_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'admin', '$2y$10$e70x4qYJN59Q2ceUkrCsf.of2wgEFMewW3jUjex3q7GFZ6VwWY92y', '2025-11-19 08:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `careers`
--

CREATE TABLE `careers` (
  `career_id` int(11) NOT NULL,
  `career_name` varchar(120) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `careers`
--

INSERT INTO `careers` (`career_id`, `career_name`, `description`) VALUES
(1, 'Software Developer', 'Builds software applications and systems.'),
(2, 'Nurse', 'Provides healthcare and patient support.'),
(3, 'Accountant', 'Manages financial records and transactions.'),
(4, 'Lawyer', 'Represents clients in legal matters.');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `option_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `career_id` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`option_id`, `question_id`, `option_text`, `career_id`, `score`) VALUES
(1, 1, 'I love programming and creating software solutions.', 1, 2),
(2, 1, 'I prefer hands-on patient care and empathy-driven work.', 2, 1),
(3, 1, 'Working with numbers and ledgers appeals to me.', 3, 1),
(4, 1, 'I enjoy arguing a case and researching law.', 4, 1),
(5, 2, 'Debugging code and testing thoroughly.', 1, 2),
(6, 2, 'Administering medications and following protocols.', 2, 2),
(7, 2, 'Preparing accurate financial statements.', 3, 2),
(8, 2, 'Drafting precise legal documents.', 4, 2),
(9, 3, 'I would like to care for patients and support their health.', 2, 2),
(10, 3, 'I like building tools that help people digitally.', 1, 1),
(11, 3, 'I prefer managing budgets to support services.', 3, 1),
(12, 3, 'I would advocate for people\'s rights and needs.', 4, 1),
(13, 4, 'Using analytics to improve software systems.', 1, 2),
(14, 4, 'Monitoring patient metrics and outcomes.', 2, 1),
(15, 4, 'Analyzing financial data for decisions.', 3, 2),
(16, 4, 'Researching case law statistics.', 4, 1),
(17, 5, 'Following coding standards and best practices.', 1, 1),
(18, 5, 'Adhering to clinical protocols and safety rules.', 2, 2),
(19, 5, 'Applying tax and accounting regulations.', 3, 2),
(20, 5, 'Interpreting and applying laws.', 4, 2),
(21, 6, 'Working on a software development team.', 1, 2),
(22, 6, 'Coordinating with nurses and healthcare staff.', 2, 2),
(23, 6, 'Collaborating with finance teams.', 3, 1),
(24, 6, 'Working with colleagues on legal cases.', 4, 1),
(25, 7, 'Researching algorithms and technical papers.', 1, 2),
(26, 7, 'Reading clinical studies and care guidelines.', 2, 2),
(27, 7, 'Studying financial regulations and reports.', 3, 1),
(28, 7, 'Reading case law and legal precedents.', 4, 2),
(29, 8, 'Responding to urgent bugs and incidents.', 1, 1),
(30, 8, 'Handling emergencies and critical patient needs.', 2, 2),
(31, 8, 'Fast-paced audit seasons appeal to me.', 3, 1),
(32, 8, 'Courtroom schedules and hearings excite me.', 4, 1),
(33, 9, 'Designing user interfaces and features.', 1, 2),
(34, 9, 'Designing patient care plans creatively.', 2, 1),
(35, 9, 'Creating novel accounting solutions.', 3, 1),
(36, 9, 'Formulating novel legal strategies.', 4, 2),
(37, 10, 'Automating tasks with software.', 1, 2),
(38, 10, 'Using medical equipment and digital records.', 2, 2),
(39, 10, 'Implementing accounting software and controls.', 3, 2),
(40, 10, 'Using legal research databases.', 4, 1),
(41, 11, 'Mentoring junior developers and explaining code.', 1, 2),
(42, 11, 'Educating patients about their care.', 2, 2),
(43, 11, 'Training staff on accounting practices.', 3, 1),
(44, 11, 'Explaining legal rights and procedures.', 4, 1),
(45, 12, 'Writing algorithms that rely on numerical methods.', 1, 1),
(46, 12, 'Interpreting clinical statistics.', 2, 1),
(47, 12, 'Preparing and analyzing financial statements.', 3, 2),
(48, 12, 'Quantitative legal analysis and damages calculation.', 4, 1),
(49, 13, 'Interviewing users to shape software features.', 1, 1),
(50, 13, 'Listening and supporting patients in care.', 2, 2),
(51, 13, 'Advising clients on financial planning.', 3, 1),
(52, 13, 'Interviewing clients and witnesses for cases.', 4, 2),
(53, 14, 'Following software development sprints.', 1, 2),
(54, 14, 'Following treatment plans step by step.', 2, 2),
(55, 14, 'Closing monthly financial cycles.', 3, 2),
(56, 14, 'Following case procedures towards resolution.', 4, 1),
(57, 15, 'Building side projects and independent coding.', 1, 2),
(58, 15, 'Working independently during shifts.', 2, 1),
(59, 15, 'Running your own accounting practice.', 3, 2),
(60, 15, 'Operating as an independent legal counsel.', 4, 2),
(61, 16, 'Learning new programming languages and frameworks.', 1, 2),
(62, 16, 'Learning new medical procedures and treatments.', 2, 2),
(63, 16, 'Keeping up with tax laws and accounting standards.', 3, 2),
(64, 16, 'Keeping up with changes in law and precedent.', 4, 1),
(65, 17, 'Handling production incidents calmly.', 1, 1),
(66, 17, 'Working through medical emergencies.', 2, 2),
(67, 17, 'Managing tight fiscal deadlines.', 3, 1),
(68, 17, 'Handling courtroom pressure during trials.', 4, 2),
(69, 18, 'Negotiating project scope with stakeholders.', 1, 1),
(70, 18, 'Persuading patients to follow care plans.', 2, 1),
(71, 18, 'Negotiating contracts and financial terms.', 3, 1),
(72, 18, 'Arguing cases and persuading judges or juries.', 4, 2),
(73, 19, 'Prototyping hardware-software integrations.', 1, 1),
(74, 19, 'Hands-on patient care and practical procedures.', 2, 2),
(75, 19, 'Reviewing physical receipts and ledgers.', 3, 1),
(76, 19, 'Inspecting evidence and preparing exhibits.', 4, 1),
(77, 20, 'Pursuing senior developer and certification paths.', 1, 2),
(78, 20, 'Gaining nursing certifications and specializations.', 2, 2),
(79, 20, 'Becoming a certified accountant or CPA.', 3, 2),
(80, 20, 'Becoming a senior advocate or obtaining bar credentials.', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_text`) VALUES
(1, 'I enjoy solving logical puzzles and writing code.'),
(2, 'I prefer tasks that require attention to detail and accuracy.'),
(3, 'I enjoy helping others directly and being part of their recovery.'),
(4, 'I enjoy analyzing data and spotting trends.'),
(5, 'I like clear rules and working within established regulations.'),
(6, 'I enjoy collaborating in teams to deliver projects.'),
(7, 'I enjoy research and long-form reading.'),
(8, 'I prefer work that is fast-paced and can be unpredictable.'),
(9, 'I enjoy creative problem solving and designing new things.'),
(10, 'I prefer using tools and technology to improve processes.'),
(11, 'I enjoy teaching, mentoring, or explaining complex ideas.'),
(12, 'I am comfortable with numbers and quantitative reasoning.'),
(13, 'I enjoy talking to people and understanding their stories.'),
(14, 'I like structured tasks with clear outcomes.'),
(15, 'I prefer autonomy and being able to set my own methods.'),
(16, 'I enjoy learning new technologies and keeping skills current.'),
(17, 'I remain calm under pressure and handle stressful situations well.'),
(18, 'I enjoy negotiating and persuading others.'),
(19, 'I enjoy hands-on practical tasks more than desk work.'),
(20, 'I like jobs that allow clear professional progression and certification.');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `interest_area` varchar(150) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `full_name`, `email`, `gender`, `interest_area`, `password_hash`, `registered_at`) VALUES
(1, 'Ilono Ikenna Wisdom', 'onoliwisdom@gmail.com', 'Male', 'doctor', '$2y$10$3D5BHN9G21prlZKjE0CpGeFthKI4SlzNePRBaCJKKOSd.O5GeEBUG', '2025-11-19 11:27:23'),
(2, 'Ozioko Obinna Great', 'ozioko@gmail.com', 'Male', 'medicine', '$2y$10$2qBRoCFrspRIL07RsKFn/epOyQuAq2qtJm5BJe/olIqoupU.lqFF.', '2025-11-21 00:33:53'),
(3, 'Abolarin Oluwaferanmin Isaac', 'abolarin@gmail.com', 'Male', 'engineering', '$2y$10$lcSQfGeAlg9WbEiuhOA8U.iTkF8qyDUa67gUPTBnKioZSCJLcBdTm', '2025-11-22 00:42:12'),
(4, 'Nwankwo Chinyeye Esther', 'nwankwo@gmail.com', 'Female', 'nursing', '$2y$10$LQFe/0ate9DBuO4K5tX99eO6OuytP.RqkHPkgl6i/BYeKIyr7SLtm', '2025-11-22 00:45:16');

-- --------------------------------------------------------

--
-- Table structure for table `student_scores`
--

CREATE TABLE `student_scores` (
  `score_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `career_id` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_scores`
--

INSERT INTO `student_scores` (`score_id`, `student_id`, `career_id`, `score`) VALUES
(21, 1, 1, 2),
(22, 1, 2, 2),
(23, 1, 1, 1),
(24, 1, 2, 1),
(25, 1, 2, 2),
(26, 1, 1, 2),
(27, 1, 2, 2),
(28, 1, 1, 1),
(29, 1, 4, 2),
(30, 1, 2, 2),
(31, 1, 1, 2),
(32, 1, 3, 2),
(33, 1, 4, 2),
(34, 1, 3, 2),
(35, 1, 3, 2),
(36, 1, 4, 1),
(37, 1, 2, 2),
(38, 1, 4, 2),
(39, 1, 3, 1),
(40, 1, 1, 2),
(41, 2, 1, 2),
(42, 2, 1, 2),
(43, 2, 4, 1),
(44, 2, 3, 2),
(45, 2, 3, 2),
(46, 2, 1, 2),
(47, 2, 2, 2),
(48, 2, 1, 1),
(49, 2, 2, 1),
(50, 2, 4, 1),
(51, 2, 3, 1),
(52, 2, 3, 2),
(53, 2, 3, 1),
(54, 2, 3, 2),
(55, 2, 1, 2),
(56, 2, 4, 1),
(57, 2, 1, 1),
(58, 2, 1, 1),
(59, 2, 1, 1),
(60, 2, 3, 2),
(61, 3, 4, 1),
(62, 3, 3, 2),
(63, 3, 4, 1),
(64, 3, 4, 1),
(65, 3, 4, 2),
(66, 3, 4, 1),
(67, 3, 4, 2),
(68, 3, 3, 1),
(69, 3, 1, 2),
(70, 3, 3, 2),
(71, 3, 2, 2),
(72, 3, 2, 1),
(73, 3, 4, 2),
(74, 3, 1, 2),
(75, 3, 3, 2),
(76, 3, 3, 2),
(77, 3, 2, 2),
(78, 3, 3, 1),
(79, 3, 4, 1),
(80, 3, 4, 2),
(81, 4, 3, 1),
(82, 4, 1, 2),
(83, 4, 2, 2),
(84, 4, 4, 1),
(85, 4, 2, 2),
(86, 4, 3, 1),
(87, 4, 1, 2),
(88, 4, 4, 1),
(89, 4, 4, 2),
(90, 4, 1, 2),
(91, 4, 2, 2),
(92, 4, 3, 2),
(93, 4, 2, 2),
(94, 4, 1, 2),
(95, 4, 3, 2),
(96, 4, 4, 1),
(97, 4, 3, 1),
(98, 4, 1, 1),
(99, 4, 1, 1),
(100, 4, 3, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `careers`
--
ALTER TABLE `careers`
  ADD PRIMARY KEY (`career_id`),
  ADD UNIQUE KEY `career_name` (`career_name`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `career_id` (`career_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_scores`
--
ALTER TABLE `student_scores`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `career_id` (`career_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `career_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_scores`
--
ALTER TABLE `student_scores`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `options_ibfk_2` FOREIGN KEY (`career_id`) REFERENCES `careers` (`career_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_scores`
--
ALTER TABLE `student_scores`
  ADD CONSTRAINT `student_scores_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_scores_ibfk_2` FOREIGN KEY (`career_id`) REFERENCES `careers` (`career_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
