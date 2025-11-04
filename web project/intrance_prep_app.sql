-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2025 at 07:44 PM
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
-- Database: `intrance_prep_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`) VALUES
(9, 'Aptitude'),
(3, 'Biology'),
(5, 'Chemistry'),
(8, 'Civics'),
(1, 'English'),
(6, 'Geography'),
(7, 'History'),
(10, 'ICT'),
(2, 'Math'),
(4, 'Physics');

-- --------------------------------------------------------

--
-- Table structure for table `course_titles`
--

CREATE TABLE `course_titles` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_titles`
--

INSERT INTO `course_titles` (`id`, `course_id`, `title`) VALUES
(1, 1, 'Grammar'),
(2, 1, 'Vocabulary'),
(3, 1, 'Reading Comprehension'),
(4, 1, 'Writing Skills'),
(5, 1, 'Literature'),
(6, 2, 'Algebra'),
(7, 2, 'Geometry'),
(8, 2, 'Trigonometry'),
(9, 2, 'Calculus'),
(10, 2, 'Statistics'),
(11, 3, 'Genetics'),
(12, 3, 'Ecosystem'),
(13, 3, 'Energy Transformation'),
(14, 3, 'Photosynthesis'),
(15, 3, 'Cell Structure'),
(16, 4, 'Mechanics'),
(17, 4, 'Thermodynamics'),
(18, 4, 'Optics'),
(19, 4, 'Electromagnetism'),
(20, 4, 'Modern Physics'),
(21, 5, 'Atomic Structure'),
(22, 5, 'Periodic Table'),
(23, 5, 'Chemical Bonding'),
(24, 5, 'Stoichiometry'),
(25, 5, 'Acids and Bases'),
(26, 6, 'Physical Geography'),
(27, 6, 'Climate and Weather'),
(28, 6, 'Map Reading'),
(29, 6, 'Population Studies'),
(30, 6, 'Natural Resources'),
(31, 7, 'Ancient Civilizations'),
(32, 7, 'Medieval Period'),
(33, 7, 'Renaissance'),
(34, 7, 'Modern History'),
(35, 7, 'World Wars'),
(36, 8, 'Constitution'),
(37, 8, 'Government Structure'),
(38, 8, 'Rights and Responsibilities'),
(39, 8, 'Elections'),
(40, 8, 'Political Parties'),
(41, 9, 'Logical Reasoning'),
(42, 9, 'Quantitative Aptitude'),
(43, 9, 'Data Interpretation'),
(44, 9, 'Verbal Ability'),
(45, 9, 'Problem Solving'),
(46, 10, 'Computer Basics'),
(47, 10, 'Operating Systems'),
(48, 10, 'Networking'),
(49, 10, 'Programming Fundamentals'),
(50, 10, 'Databases');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `pdf_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `title_id`, `pdf_url`, `created_at`) VALUES
(1, 1, 'materials/grammar.pdf', '2025-06-09 16:38:00'),
(2, 2, 'materials/Vocabulary.pdf', '2025-06-09 17:00:07'),
(3, 3, 'materials/Reading_Comprehension.pdf', '2025-06-09 17:00:07'),
(4, 4, 'materials/Writing_Skills.pdf', '2025-06-09 17:00:07'),
(5, 5, 'materials/Literature.pdf', '2025-06-09 17:00:07'),
(6, 6, 'materials/Algebra.pdf', '2025-06-09 17:00:08'),
(7, 7, 'materials/Geometry.pdf', '2025-06-09 17:00:08'),
(8, 8, 'materials/Trigonometry.pdf', '2025-06-09 17:00:08'),
(9, 9, 'materials/Calculus.pdf', '2025-06-09 17:00:08'),
(10, 10, 'materials/Statistics.pdf', '2025-06-09 17:00:08'),
(11, 11, 'materials/Genetics.pdf', '2025-06-09 17:00:08'),
(12, 12, 'materials/Ecosystem.pdf', '2025-06-09 17:00:08'),
(13, 13, 'materials/Energy_Transformation.pdf', '2025-06-09 17:00:08'),
(14, 14, 'materials/Photosynthesis.pdf', '2025-06-09 17:00:08'),
(15, 15, 'materials/Cell_Structure.pdf', '2025-06-09 17:00:08'),
(16, 16, 'materials/Mechanics.pdf', '2025-06-09 17:00:08'),
(17, 17, 'materials/Thermodynamics.pdf', '2025-06-09 17:00:08'),
(18, 18, 'materials/Optics.pdf', '2025-06-09 17:00:08'),
(19, 19, 'materials/Electromagnetism.pdf', '2025-06-09 17:00:08'),
(20, 20, 'materials/Modern_Physics.pdf', '2025-06-09 17:00:08'),
(21, 21, 'materials/Atomic_Structure.pdf', '2025-06-09 17:00:08'),
(22, 22, 'materials/Periodic_Table.pdf', '2025-06-09 17:00:08'),
(23, 23, 'materials/Chemical_Bonding.pdf', '2025-06-09 17:00:08'),
(24, 24, 'materials/Stoichiometry.pdf', '2025-06-09 17:00:08'),
(25, 25, 'materials/Acids_and_Bases.pdf', '2025-06-09 17:00:08'),
(26, 26, 'materials/Physical_Geography.pdf', '2025-06-09 17:00:08'),
(27, 27, 'materials/Climate_and_Weather.pdf', '2025-06-09 17:00:08'),
(28, 28, 'materials/Map_Reading.pdf', '2025-06-09 17:00:08'),
(29, 29, 'materials/Population_Studies.pdf', '2025-06-09 17:00:08'),
(30, 30, 'materials/Natural_Resources.pdf', '2025-06-09 17:00:08'),
(31, 31, 'materials/Ancient_Civilizations.pdf', '2025-06-09 17:00:08'),
(32, 32, 'materials/Medieval_Period.pdf', '2025-06-09 17:00:08'),
(33, 33, 'materials/Renaissance.pdf', '2025-06-09 17:00:08'),
(34, 34, 'materials/Modern_History.pdf', '2025-06-09 17:00:08'),
(35, 35, 'materials/World_Wars.pdf', '2025-06-09 17:00:08'),
(36, 36, 'materials/Constitution.pdf', '2025-06-09 17:00:08'),
(37, 37, 'materials/Government_Structure.pdf', '2025-06-09 17:00:08'),
(38, 38, 'materials/Rights_and_Responsibilities.pdf', '2025-06-09 17:00:08'),
(39, 39, 'materials/Elections.pdf', '2025-06-09 17:00:08'),
(40, 40, 'materials/Political_Parties.pdf', '2025-06-09 17:00:08'),
(41, 41, 'materials/Logical_Reasoning.pdf', '2025-06-09 17:00:09'),
(42, 42, 'materials/Quantitative_Aptitude.pdf', '2025-06-09 17:00:09'),
(43, 43, 'materials/Data_Interpretation.pdf', '2025-06-09 17:00:09'),
(44, 44, 'materials/Verbal_Ability.pdf', '2025-06-09 17:00:09'),
(45, 45, 'materials/Problem_Solving.pdf', '2025-06-09 17:00:09'),
(46, 46, 'materials/Computer_Basics.pdf', '2025-06-09 17:00:09'),
(47, 47, 'materials/Operating_Systems.pdf', '2025-06-09 17:00:09'),
(48, 48, 'materials/Networking.pdf', '2025-06-09 17:00:09'),
(49, 49, 'materials/Programming_Fundamentals.pdf', '2025-06-09 17:00:09'),
(50, 50, 'materials/Databases.pdf', '2025-06-09 17:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_option` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `title_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(1, 11, 'What is the basic unit of heredity?', 'Gene', 'Cell', 'Nucleus', 'Chromosome', 'A'),
(2, 11, 'What does DNA stand for?', 'Deoxyribonucleic Acid', 'Dinucleic Acid', 'Double Helix Acid', 'None of the above', 'A'),
(3, 11, 'Which scientist is known as the father of genetics?', 'Charles Darwin', 'Gregor Mendel', 'Louis Pasteur', 'James Watson', 'B'),
(4, 11, 'What is the shape of the DNA molecule?', 'Single helix', 'Triple helix', 'Double helix', 'Flat spiral', 'C'),
(5, 11, 'Which base pairs with adenine in DNA?', 'Cytosine', 'Thymine', 'Guanine', 'Uracil', 'B'),
(6, 11, 'How many chromosomes does a typical human cell have?', '23', '46', '44', '48', 'B'),
(7, 11, 'Which of the following is NOT a nucleotide base in DNA?', 'Adenine', 'Thymine', 'Uracil', 'Guanine', 'C'),
(8, 11, 'Where is DNA located in a cell?', 'Ribosome', 'Cytoplasm', 'Nucleus', 'Mitochondria', 'C'),
(9, 11, 'Which process creates two identical copies of DNA?', 'Transcription', 'Translation', 'Replication', 'Mutation', 'C'),
(10, 11, 'What carries genetic information from DNA to the ribosome?', 'rRNA', 'tRNA', 'mRNA', 'Enzyme', 'C'),
(11, 1, 'Which of the following is a noun?', 'Run', 'Beautiful', 'Book', 'Quickly', 'C'),
(12, 1, 'Identify the past tense of “go”.', 'Go', 'Goed', 'Went', 'Gone', 'C'),
(13, 1, 'Which word is an adjective?', 'Cat', 'Happy', 'Run', 'Water', 'B'),
(14, 1, 'Choose the correct article: ___ apple a day.', 'A', 'An', 'The', 'No article', 'B'),
(15, 1, 'Which is a pronoun?', 'He', 'Desk', 'Tall', 'Swim', 'A'),
(16, 1, 'Select the adverb.', 'Quick', 'Quickly', 'Quickness', 'Quicker', 'B'),
(17, 1, 'Identify the conjunction:', 'And', 'Blue', 'Speak', 'Under', 'A'),
(18, 1, 'Which sentence is correct?', 'She don’t like it.', 'She doesn’t like it.', 'She not like it.', 'She no like it.', 'B'),
(19, 1, 'Find the proper noun:', 'city', 'Paris', 'happiness', 'running', 'B'),
(20, 1, 'Choose the plural form of “Child”.', 'Childs', 'Children', 'Childes', 'Child', 'B'),
(21, 6, 'What is x if 2x + 5 = 13?', '4', '5', '6', '7', 'A'),
(22, 6, 'Solve: 3(x – 2) = 9', 'x = 5', 'x = 3', 'x = 6', 'x = 4', 'A'),
(23, 6, 'Simplify: x^2 * x^3 = ?', 'x^5', 'x^6', 'x^9', 'x^8', 'A'),
(24, 6, 'Factor: x^2 - 9 = ?', '(x+3)(x+3)', '(x-3)(x-3)', '(x+3)(x-3)', 'x(x-9)', 'C'),
(25, 6, 'What is the slope of the line y = 2x + 3?', '2', '3', '0', '-2', 'A'),
(26, 6, 'Solve: x/3 = 7 → x = ?', '21', '24', '18', '10', 'A'),
(27, 6, 'Expression 4(x + 2) = ?', '4x + 2', 'x + 8', '4x + 8', '8x + 4', 'C'),
(28, 6, 'If x = -2, what is x^2?', '2', '4', '-4', '0', 'B'),
(29, 6, 'Solve 5x = 20 → x = ?', '4', '5', '3', '2', 'A'),
(30, 6, 'What is the value of 0*x?', 'undefined', '0', 'x', '1', 'B'),
(31, 16, 'What is Newton’s first law?', 'Force = mass×acceleration', 'Every action has equal opposite reaction', 'Object in motion stays in motion unless acted upon', 'Frictionless motion only', 'C'),
(32, 16, 'Unit of force is:', 'Joule', 'Newton', 'Watt', 'Pascal', 'B'),
(33, 16, 'Formula for acceleration is:', 'a = v×t', 'a = v/t', 'a = u+v', 'a = m×v', 'B'),
(34, 16, 'What unit measures mass?', 'Newton', 'Meter', 'Kilogram', 'Pascal', 'C'),
(35, 16, 'What is 9.8 m/s²?', 'Speed', 'Gravity acceleration', 'Velocity', 'None', 'B'),
(36, 16, 'Velocity is defined as:', 'Speed in a given direction', 'Distance ÷ time', 'Force ÷ area', 'Mass × acceleration', 'A'),
(37, 16, 'What is momentum?', 'Mass × velocity', 'Mass + velocity', 'Force × time', 'Energy ÷ mass', 'A'),
(38, 16, 'Which is a scalar quantity?', 'Velocity', 'Acceleration', 'Speed', 'Displacement', 'C'),
(39, 16, 'What does friction do?', 'Aids motion', 'Opposes motion', 'Generates mass', 'Enhances energy', 'B'),
(40, 16, 'What is work?', 'Force × time', 'Mass × acceleration', 'Force × displacement', 'Power ÷ time', 'C'),
(41, 21, 'What particles are found in the nucleus?', 'Electrons and protons', 'Protons and neutrons', 'Neutrons only', 'Electrons only', 'B'),
(42, 21, 'The atomic number is the number of:', 'Electrons', 'Protons', 'Neutrons', 'Protons + neutrons', 'B'),
(43, 21, 'Electrons carry a charge of:', 'Positive', 'Negative', 'Neutral', 'None', 'B'),
(44, 21, 'In a neutral atom, number of electrons equals:', 'Number of protons', 'Number of neutrons', 'Mass number', 'Atomic mass', 'A'),
(45, 21, 'The nucleus has a ____ charge.', 'Positive', 'Negative', 'Neutral', 'Variable', 'A'),
(46, 21, 'What determines an element’s identity?', 'Mass number', 'Atomic mass', 'Atomic number', 'Electron count', 'C'),
(47, 21, 'Which instrument measures atomic mass?', 'Mass spectrometer', 'Microscope', 'Voltmeter', 'Spectroscope', 'A'),
(48, 21, 'Protons have charge:', '+1', '0', '-1', '+2', 'A'),
(49, 21, 'What does the nucleus contain?', 'Protons and electrons', 'Protons and neutrons', 'Electrons and neutrons', 'All subatomic particles', 'B'),
(50, 21, 'Electrons orbit the ____.', 'Nucleus', 'Electron cloud', 'Neutron', 'Proton', 'A'),
(51, 31, 'Which is the earliest known civilization?', 'Roman', 'Egyptian', 'Greek', 'Mayan', 'B'),
(52, 31, 'The Pyramids are located in:', 'Greece', 'China', 'Egypt', 'Mexico', 'C'),
(53, 31, 'The Code of Hammurabi originated in:', 'Rome', 'Babylon', 'Athens', 'Carthage', 'B'),
(54, 31, 'Which ancient civilization used cuneiform?', 'Egypt', 'Mesopotamia', 'India', 'China', 'B'),
(55, 31, 'The Great Wall belonged to:', 'Egyptians', 'Romans', 'Chinese', 'Persians', 'C'),
(56, 31, 'Which river is associated with Egypt?', 'Nile', 'Amazon', 'Tigris', 'Ganges', 'A'),
(57, 31, 'Stonehenge is located in:', 'France', 'Egypt', 'England', 'Germany', 'C'),
(58, 31, 'The Hanging Gardens were in:', 'Babylon', 'Rome', 'Athens', 'Egypt', 'A'),
(59, 31, 'Which civilization worshipped Jupiter?', 'Egyptian', 'Greek', 'Roman', 'Mayan', 'C'),
(60, 31, 'The Rosetta Stone helped decipher:', 'Greek', 'Egyptian hieroglyphs', 'Latin', 'Cuneiform', 'B'),
(61, 36, 'A constitution is a set of:', 'Laws only', 'Principles and laws', 'Religious beliefs', 'Economic plans', 'B'),
(62, 36, 'Who interprets the constitution?', 'Legislature', 'Judiciary', 'Executive', 'Police', 'B'),
(63, 36, 'Which protects individual rights?', 'Dictatorship', 'Constitution', 'Monarchy', 'Oligarchy', 'B'),
(64, 36, 'Constitutional law governs:', 'Behavior only', 'State actions', 'Economy', 'Education', 'B'),
(65, 36, 'What prevents abuse of power?', 'Constitution', 'No law', 'Public opinion', 'Economy', 'A'),
(66, 36, 'Separation of powers means dividing into:', '2 branches', '3 branches', '4 branches', '1 branch', 'B'),
(67, 36, 'Which branch makes laws?', 'Executive', 'Legislative', 'Judiciary', 'Local', 'B'),
(68, 36, 'Which branch enforces laws?', 'Legislative', 'Judiciary', 'Executive', 'Police', 'C'),
(69, 36, 'Who resolves constitutional disputes?', 'Judiciary', 'Executive', 'Legislature', 'Citizens', 'A'),
(70, 36, 'A constitution can be:', 'Flexible or rigid', 'Only rigid', 'Only flexible', 'None', 'A'),
(71, 41, 'If A is taller than B and B is taller than C, who is shortest?', 'A', 'B', 'C', 'Cannot say', 'C'),
(72, 41, 'What is the next number in sequence? 2,4,6,8,...', '9', '10', '11', '12', 'B'),
(73, 41, 'All roses are flowers, some flowers fade. Is it true that some roses fade?', 'Yes', 'No', 'Cannot say', 'All does', 'C'),
(74, 41, 'If it rains, the ground gets wet. It is raining → ?', 'Ground dry', 'Ground wet', 'Cannot say', 'Rain stops', 'B'),
(75, 41, 'Dog is to bark as cat is to ?', 'Moo', 'Meow', 'Neigh', 'Roar', 'B'),
(76, 41, 'Which is a logical statement?', 'All birds swim', 'Some fish fly', 'No humans are mortal', 'All bachelors unmarried', 'D'),
(77, 41, 'If today is Friday, tomorrow is Sunday? → ?', 'Yes', 'No', 'Maybe', 'Cannot say', 'B'),
(78, 41, 'Choose the odd one: Apple, Banana, Carrot, Grape', 'Apple', 'Banana', 'Carrot', 'Grape', 'C'),
(79, 41, 'Which is not a vowel?', 'A', 'E', 'I', 'R', 'D'),
(80, 41, '5 + (3 * 2) = ?', '11', '16', '10', '13', 'A'),
(81, 48, 'What does LAN stand for?', 'Large Area Network', 'Local Area Network', 'Long Area Network', 'Light Area Network', 'B'),
(82, 48, 'Which device is used to forward packets between networks?', 'Modem', 'Router', 'Switch', 'Printer', 'B'),
(83, 48, 'IP stands for:', 'Internet Protocol', 'Internal Protocol', 'Internet Procedure', 'Internal Procedure', 'A'),
(84, 48, 'Which is a wireless networking standard?', 'Ethernet', 'Wi-Fi', 'Bluetooth', 'USB', 'B'),
(85, 48, 'What does DNS do?', 'Translate domain names to IP', 'Control network speed', 'Secure network', 'Manage files', 'A'),
(86, 48, 'Default subnet mask for IP 192.168.0.1 is:', '255.255.0.0', '255.255.255.0', '255.0.0.0', '255.255.255.255', 'B'),
(87, 48, 'Which protocol is used for secure web browsing?', 'HTTP', 'FTP', 'SSH', 'HTTPS', 'D'),
(88, 48, 'MAC address is assigned to:', 'Network card', 'Computer', 'Server', 'Website', 'A'),
(89, 48, 'Which is a network cable type?', 'HDMI', 'USB', 'Ethernet', 'VGA', 'C'),
(90, 48, 'Which is a private IP range?', '8.8.8.8', '192.168.1.0', '172.16.0.0', 'Both B and C', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `remember_me`
--

CREATE TABLE `remember_me` (
  `email` varchar(255) NOT NULL,
  `token` char(64) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remember_me`
--

INSERT INTO `remember_me` (`email`, `token`, `expires_at`) VALUES
('mah90@gmail.com', '354e653fb9abd10859b85b1c134bb459b36205575b9abc8bc241c6e0ae7d329b', '2025-07-10 07:52:59'),
('khalid909@gmail.com', '583d92d3bcae211cc7fed8658a6caa05213386b34ab28f6707f917b01be74acf', '2025-07-10 13:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `type` enum('quiz','material') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`id`, `course_id`, `title`, `type`) VALUES
(1, 1, 'Grammar', 'quiz'),
(2, 1, 'Vocabulary', 'quiz'),
(3, 1, 'Reading Comprehension', 'quiz'),
(4, 1, 'Writing Skills', 'quiz'),
(5, 1, 'Literature', 'quiz'),
(6, 1, 'Grammar', 'material'),
(7, 1, 'Vocabulary', 'material'),
(8, 1, 'Reading Comprehension', 'material'),
(9, 1, 'Writing Skills', 'material'),
(10, 1, 'Literature', 'material'),
(11, 2, 'Algebra', 'quiz'),
(12, 2, 'Geometry', 'quiz'),
(13, 2, 'Trigonometry', 'quiz'),
(14, 2, 'Calculus', 'quiz'),
(15, 2, 'Statistics', 'quiz'),
(16, 2, 'Algebra', 'material'),
(17, 2, 'Geometry', 'material'),
(18, 2, 'Trigonometry', 'material'),
(19, 2, 'Calculus', 'material'),
(20, 2, 'Statistics', 'material'),
(21, 3, 'Genetics', 'quiz'),
(22, 3, 'Ecosystem', 'quiz'),
(23, 3, 'Energy Transformation', 'quiz'),
(24, 3, 'Photosynthesis', 'quiz'),
(25, 3, 'Cell Structure', 'quiz'),
(26, 3, 'Genetics', 'material'),
(27, 3, 'Ecosystem', 'material'),
(28, 3, 'Energy Transformation', 'material'),
(29, 3, 'Photosynthesis', 'material'),
(30, 3, 'Cell Structure', 'material'),
(31, 4, 'Mechanics', 'quiz'),
(32, 4, 'Thermodynamics', 'quiz'),
(33, 4, 'Optics', 'quiz'),
(34, 4, 'Electromagnetism', 'quiz'),
(35, 4, 'Modern Physics', 'quiz'),
(36, 4, 'Mechanics', 'material'),
(37, 4, 'Thermodynamics', 'material'),
(38, 4, 'Optics', 'material'),
(39, 4, 'Electromagnetism', 'material'),
(40, 4, 'Modern Physics', 'material'),
(41, 5, 'Atomic Structure', 'quiz'),
(42, 5, 'Periodic Table', 'quiz'),
(43, 5, 'Chemical Bonding', 'quiz'),
(44, 5, 'Stoichiometry', 'quiz'),
(45, 5, 'Acids and Bases', 'quiz'),
(46, 5, 'Atomic Structure', 'material'),
(47, 5, 'Periodic Table', 'material'),
(48, 5, 'Chemical Bonding', 'material'),
(49, 5, 'Stoichiometry', 'material'),
(50, 5, 'Acids and Bases', 'material'),
(51, 6, 'Physical Geography', 'quiz'),
(52, 6, 'Climate and Weather', 'quiz'),
(53, 6, 'Map Reading', 'quiz'),
(54, 6, 'Population Studies', 'quiz'),
(55, 6, 'Natural Resources', 'quiz'),
(56, 6, 'Physical Geography', 'material'),
(57, 6, 'Climate and Weather', 'material'),
(58, 6, 'Map Reading', 'material'),
(59, 6, 'Population Studies', 'material'),
(60, 6, 'Natural Resources', 'material'),
(61, 7, 'Ancient Civilizations', 'quiz'),
(62, 7, 'Medieval Period', 'quiz'),
(63, 7, 'Renaissance', 'quiz'),
(64, 7, 'Modern History', 'quiz'),
(65, 7, 'World Wars', 'quiz'),
(66, 7, 'Ancient Civilizations', 'material'),
(67, 7, 'Medieval Period', 'material'),
(68, 7, 'Renaissance', 'material'),
(69, 7, 'Modern History', 'material'),
(70, 7, 'World Wars', 'material'),
(71, 8, 'Constitution', 'quiz'),
(72, 8, 'Government Structure', 'quiz'),
(73, 8, 'Rights and Responsibilities', 'quiz'),
(74, 8, 'Elections', 'quiz'),
(75, 8, 'Political Parties', 'quiz'),
(76, 8, 'Constitution', 'material'),
(77, 8, 'Government Structure', 'material'),
(78, 8, 'Rights and Responsibilities', 'material'),
(79, 8, 'Elections', 'material'),
(80, 8, 'Political Parties', 'material'),
(81, 9, 'Logical Reasoning', 'quiz'),
(82, 9, 'Quantitative Aptitude', 'quiz'),
(83, 9, 'Data Interpretation', 'quiz'),
(84, 9, 'Verbal Ability', 'quiz'),
(85, 9, 'Problem Solving', 'quiz'),
(86, 9, 'Logical Reasoning', 'material'),
(87, 9, 'Quantitative Aptitude', 'material'),
(88, 9, 'Data Interpretation', 'material'),
(89, 9, 'Verbal Ability', 'material'),
(90, 9, 'Problem Solving', 'material'),
(91, 10, 'Computer Basics', 'quiz'),
(92, 10, 'Operating Systems', 'quiz'),
(93, 10, 'Networking', 'quiz'),
(94, 10, 'Programming Fundamentals', 'quiz'),
(95, 10, 'Databases', 'quiz'),
(96, 10, 'Computer Basics', 'material'),
(97, 10, 'Operating Systems', 'material'),
(98, 10, 'Networking', 'material'),
(99, 10, 'Programming Fundamentals', 'material'),
(100, 10, 'Databases', 'material');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `name`, `password`, `created_at`) VALUES
('gashawkalkidan700@gmail.com', 'kalkidan', '$2y$10$3WiEkMXFsqPFO5c1TWaJN.tPa4T6TpZYpiql86.vfYB0/aysGwKmG', '2025-06-10 07:08:58'),
('ghenok0000@gmail.com', 'henok', '$2y$10$SQlL8PkUPFen60GJNsDIg.niZfaiz8zDabHdMBfmSgd8DaikgiEpS', '2025-06-10 07:09:26'),
('kerry@gmail.com', 'keriam', '$2y$10$uuRWLO/ay3AbJgkvbPh5suZJvgzNnej/Wue4rZjmacpAKNPDn/dKW', '2025-06-10 06:15:33'),
('khalid909@gmail.com', 'khalid', '$2y$10$6mOL3LxG3rfNkM7h2GSSNuQ0bEcprzR0TwTt3CMpl2oSkYJk2kn42', '2025-06-10 11:04:34'),
('khalid@gmail.com', 'khalid', '$2y$10$GguDgQybNRPf/6.cBrJLO.88RH5.lL.04ztZFRsFQJtX3mylyLvAq', '2025-06-08 15:40:16'),
('mah90@gmail.com', 'Mahmud Abdu', '$2y$10$dfIMLdjjtDEBSXXqXnonRuQfPj8s7YvnEvyEi5kRZ/2z/4zBvFYu2', '2025-06-08 19:06:43'),
('naol90@gmail.com', 'Naol', '$2y$10$ogkqJrTclsqnh.DKW2PHXexKIYHj3GFGHYU2I6XcPL./C4xjPNIDy', '2025-06-09 13:27:28'),
('naol@gmail.com', 'Naol', '$2y$10$Ly3vGsBxib4pz/aHvgnxfu4s6iDKSLtBewNNJObwISOhvM9Y69w0W', '2025-06-08 18:22:20');

-- --------------------------------------------------------

--
-- Table structure for table `user_stats`
--

CREATE TABLE `user_stats` (
  `id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `total_questions` int(11) DEFAULT 0,
  `correct_answers` int(11) DEFAULT 0,
  `wrong_answers` int(11) DEFAULT 0,
  `biology_questions` int(11) DEFAULT 0,
  `physics_questions` int(11) DEFAULT 0,
  `chemistry_questions` int(11) DEFAULT 0,
  `math_questions` int(11) DEFAULT 0,
  `english_questions` int(11) DEFAULT 0,
  `history_questions` int(11) DEFAULT 0,
  `geography_questions` int(11) DEFAULT 0,
  `civics_questions` int(11) DEFAULT 0,
  `economics_questions` int(11) DEFAULT 0,
  `ict_questions` int(11) DEFAULT 0,
  `aptitude_questions` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_stats`
--

INSERT INTO `user_stats` (`id`, `user_email`, `total_questions`, `correct_answers`, `wrong_answers`, `biology_questions`, `physics_questions`, `chemistry_questions`, `math_questions`, `english_questions`, `history_questions`, `geography_questions`, `civics_questions`, `economics_questions`, `ict_questions`, `aptitude_questions`) VALUES
(1, 'mah90@gmail.com', 40, 16, 24, 10, 0, 10, 0, 0, 10, 0, 10, 0, 0, 0),
(2, 'naol90@gmail.com', 10, 3, 7, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'kerry@gmail.com', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'gashawkalkidan700@gmail.com', 10, 6, 4, 5, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'ghenok0000@gmail.com', 5, 5, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'khalid909@gmail.com', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `course_titles`
--
ALTER TABLE `course_titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title_id` (`title_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title_id` (`title_id`);

--
-- Indexes for table `remember_me`
--
ALTER TABLE `remember_me`
  ADD PRIMARY KEY (`token`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `user_stats`
--
ALTER TABLE `user_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `course_titles`
--
ALTER TABLE `course_titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `user_stats`
--
ALTER TABLE `user_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_titles`
--
ALTER TABLE `course_titles`
  ADD CONSTRAINT `course_titles_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `course_titles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `titles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `remember_me`
--
ALTER TABLE `remember_me`
  ADD CONSTRAINT `remember_me_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `titles`
--
ALTER TABLE `titles`
  ADD CONSTRAINT `titles_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
