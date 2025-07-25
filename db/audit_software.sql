-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2025 at 09:13 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `audit_software`
--

-- --------------------------------------------------------

--
-- Table structure for table `audits`
--

CREATE TABLE `audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `financial_year_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `priority` enum('low','medium','high','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'high',
  `workflow_status` enum('draft','ongoing','reviewed','approved','rejected','complete','reopened') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `reference_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audits`
--

INSERT INTO `audits` (`id`, `audit_number`, `financial_year_id`, `organization_id`, `title`, `slug`, `description`, `start_date`, `end_date`, `status`, `priority`, `workflow_status`, `reference_document`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, '0001', '3', 3, 'Et consectetur saepe', '0001-et-consectetur-saepe', NULL, '2025-07-23', '2025-07-31', 'active', 'high', 'ongoing', NULL, 1, '2025-07-24 10:48:05', '2025-07-25 11:30:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audit_and_step_pairs`
--

CREATE TABLE `audit_and_step_pairs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_id` int(11) NOT NULL,
  `audit_step_id` int(11) NOT NULL,
  `step_no` int(11) NOT NULL,
  `status` enum('draft','ongoing','reviewed','approved','rejected','returned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `audit_by` int(11) DEFAULT NULL,
  `reviewed_by` int(11) DEFAULT NULL,
  `rejected_for` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `returned_for` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_and_step_pairs`
--

INSERT INTO `audit_and_step_pairs` (`id`, `audit_id`, `audit_step_id`, `step_no`, `status`, `audit_by`, `reviewed_by`, `rejected_for`, `returned_for`, `created_at`, `updated_at`) VALUES
(6, 1, 1, 1, 'approved', 2, 4, NULL, NULL, '2025-07-24 10:50:12', '2025-07-25 11:12:56'),
(7, 1, 2, 2, 'returned', 2, 4, NULL, NULL, '2025-07-24 10:50:12', '2025-07-25 11:30:37'),
(8, 1, 3, 3, 'draft', NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(9, 1, 4, 4, 'draft', NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(10, 1, 5, 5, 'draft', NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12');

-- --------------------------------------------------------

--
-- Table structure for table `audit_and_step_question_pairs`
--

CREATE TABLE `audit_and_step_question_pairs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_id` int(11) NOT NULL,
  `audit_step_id` int(11) NOT NULL,
  `audit_step_pair_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `sorting_serial` int(11) NOT NULL,
  `closed_ended_answer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_answer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documents` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_and_step_question_pairs`
--

INSERT INTO `audit_and_step_question_pairs` (`id`, `audit_id`, `audit_step_id`, `audit_step_pair_id`, `question_id`, `sorting_serial`, `closed_ended_answer`, `text_answer`, `documents`, `submitted_by`, `created_at`, `updated_at`) VALUES
(26, 1, 1, 6, 1, 1, 'n/a', 'Et consequatur volu', 'assets/files/documents/1753379391_img-0516.JPG', NULL, '2025-07-24 10:50:12', '2025-07-24 11:49:51'),
(27, 1, 1, 6, 2, 2, 'yes', 'Consequatur numquam', 'assets/files/documents/1753379391_8903-2024-6480-63-signed-1.pdf', NULL, '2025-07-24 10:50:12', '2025-07-24 11:49:51'),
(28, 1, 1, 6, 3, 3, 'no', 'Ipsum explicabo Ear', 'assets/files/documents/1753379391_8903-2024-6480-63-signed.pdf', NULL, '2025-07-24 10:50:12', '2025-07-24 11:49:51'),
(29, 1, 1, 6, 4, 4, 'n/a', 'In illum dolores ma', 'assets/files/documents/1753379391_application.pdf', NULL, '2025-07-24 10:50:12', '2025-07-24 11:49:51'),
(30, 1, 1, 6, 5, 5, 'yes', 'Quod eaque omnis ull', 'assets/files/documents/1753379391_1102-2023-430-2911-2396-ds-1.pdf', NULL, '2025-07-24 10:50:12', '2025-07-24 11:49:51'),
(31, 1, 2, 7, 6, 1, 'yes', 'Labore blanditiis eo', NULL, NULL, '2025-07-24 10:50:12', '2025-07-25 11:30:19'),
(32, 1, 2, 7, 7, 2, 'no', 'Velit necessitatibu', NULL, NULL, '2025-07-24 10:50:12', '2025-07-25 11:30:19'),
(33, 1, 2, 7, 8, 3, 'n/a', 'Qui minima blanditii', NULL, NULL, '2025-07-24 10:50:12', '2025-07-25 11:30:19'),
(34, 1, 2, 7, 9, 4, 'yes', 'Rerum esse dolor ali', NULL, NULL, '2025-07-24 10:50:12', '2025-07-25 11:30:19'),
(35, 1, 2, 7, 10, 5, 'no', 'Eius quam et eaque o', NULL, NULL, '2025-07-24 10:50:12', '2025-07-25 11:30:19'),
(36, 1, 3, 8, 11, 1, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(37, 1, 3, 8, 12, 2, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(38, 1, 3, 8, 13, 3, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(39, 1, 3, 8, 14, 4, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(40, 1, 3, 8, 15, 5, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(41, 1, 4, 9, 16, 1, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(42, 1, 4, 9, 17, 2, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(43, 1, 4, 9, 18, 3, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(44, 1, 4, 9, 19, 4, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(45, 1, 4, 9, 20, 5, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(46, 1, 5, 10, 21, 1, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(47, 1, 5, 10, 22, 2, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(48, 1, 5, 10, 23, 3, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(49, 1, 5, 10, 24, 4, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(50, 1, 5, 10, 25, 5, NULL, NULL, NULL, NULL, '2025-07-24 10:50:12', '2025-07-24 10:50:12');

-- --------------------------------------------------------

--
-- Table structure for table `audit_auditors`
--

CREATE TABLE `audit_auditors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_auditors`
--

INSERT INTO `audit_auditors` (`id`, `audit_id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 1, 2, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(4, 1, 3, '2025-07-24 10:50:12', '2025-07-24 10:50:12');

-- --------------------------------------------------------

--
-- Table structure for table `audit_steps`
--

CREATE TABLE `audit_steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `step_no` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isa_reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_steps`
--

INSERT INTO `audit_steps` (`id`, `step_no`, `title`, `slug`, `isa_reference`, `description`, `created_by`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 'Impedit maiores et', '1753375129-impedit-maiores-et', 'Non ullamco aut non', NULL, 1, 'active', '2025-07-24 10:38:49', '2025-07-24 10:38:49', NULL, NULL),
(2, 2, 'Voluptate inventore', '1753375139-voluptate-inventore', 'Corporis cillum maxi', NULL, 1, 'active', '2025-07-24 10:38:59', '2025-07-24 10:38:59', NULL, NULL),
(3, 3, 'Quam in maiores haru', '1753375144-quam-in-maiores-haru', 'Dolor accusamus mini', NULL, 1, 'active', '2025-07-24 10:39:04', '2025-07-24 10:39:04', NULL, NULL),
(4, 4, 'Qui quibusdam nobis', '1753375149-qui-quibusdam-nobis', 'Sint qui quidem id n', NULL, 1, 'active', '2025-07-24 10:39:09', '2025-07-24 10:39:09', NULL, NULL),
(5, 5, 'Reprehenderit qui v', '1753375157-reprehenderit-qui-v', 'Delectus cum volupt', NULL, 1, 'active', '2025-07-24 10:39:17', '2025-07-24 10:39:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audit_step_questions`
--

CREATE TABLE `audit_step_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_step_id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_closed_ended` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no' COMMENT 'Is this a closed-ended question (Yes,No or N/A)?',
  `is_boolean_answer_required` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no' COMMENT 'Is answering the closed-ended question mandatory?',
  `has_text_answer` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no' COMMENT 'Does this question need a text answer?',
  `is_text_answer_required` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no' COMMENT 'Is the text answer mandatory?',
  `has_document` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no' COMMENT 'Does this question need a document upload?',
  `is_document_required` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no' COMMENT 'Is the document upload mandatory?',
  `sorting_serial` int(11) NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_step_questions`
--

INSERT INTO `audit_step_questions` (`id`, `audit_step_id`, `question`, `slug`, `is_closed_ended`, `is_boolean_answer_required`, `has_text_answer`, `is_text_answer_required`, `has_document`, `is_document_required`, `sorting_serial`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 'Dicta placeat iusto', '1753375172-dicta-placeat-iusto', 'yes', 'no', 'no', 'no', 'no', 'no', 1, 'active', '2025-07-24 10:39:32', '2025-07-24 10:39:59', NULL, NULL),
(2, 1, 'Dignissimos aut temp', '1753375177-dignissimos-aut-temp', 'yes', 'no', 'yes', 'yes', 'no', 'no', 2, 'active', '2025-07-24 10:39:37', '2025-07-24 10:39:37', NULL, NULL),
(3, 1, 'Voluptate minus omni', '1753375183-voluptate-minus-omni', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 3, 'active', '2025-07-24 10:39:43', '2025-07-24 10:39:59', NULL, NULL),
(4, 1, 'Dolorum atque conseq', '1753375188-dolorum-atque-conseq', 'no', 'yes', 'no', 'yes', 'yes', 'no', 4, 'active', '2025-07-24 10:39:48', '2025-07-24 10:39:48', NULL, NULL),
(5, 1, 'Vero eveniet volupt', '1753375195-vero-eveniet-volupt', 'yes', 'yes', 'no', 'no', 'yes', 'no', 5, 'active', '2025-07-24 10:39:55', '2025-07-24 10:40:00', NULL, NULL),
(6, 2, 'Elit vitae eveniet', '1753375209-elit-vitae-eveniet', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 1, 'active', '2025-07-24 10:40:09', '2025-07-24 10:40:42', NULL, NULL),
(7, 2, 'Nam eius duis archit', '1753375217-nam-eius-duis-archit', 'yes', 'no', 'no', 'yes', 'no', 'yes', 2, 'active', '2025-07-24 10:40:17', '2025-07-24 10:40:17', NULL, NULL),
(8, 2, 'Provident fugit ex', '1753375226-provident-fugit-ex', 'no', 'no', 'yes', 'yes', 'no', 'yes', 3, 'active', '2025-07-24 10:40:26', '2025-07-24 10:40:26', NULL, NULL),
(9, 2, 'Quae facilis molliti', '1753375232-quae-facilis-molliti', 'yes', 'yes', 'no', 'no', 'no', 'yes', 4, 'active', '2025-07-24 10:40:32', '2025-07-24 10:40:43', NULL, NULL),
(10, 2, 'Fuga Ipsum quis lab', '1753375238-fuga-ipsum-quis-lab', 'yes', 'yes', 'no', 'no', 'yes', 'no', 5, 'active', '2025-07-24 10:40:38', '2025-07-24 10:40:43', NULL, NULL),
(11, 3, 'Fuga Non nesciunt', '1753375253-fuga-non-nesciunt', 'no', 'yes', 'no', 'no', 'yes', 'yes', 1, 'active', '2025-07-24 10:40:53', '2025-07-24 10:40:53', NULL, NULL),
(12, 3, 'Sit aliquam eu mole', '1753375260-sit-aliquam-eu-mole', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 2, 'active', '2025-07-24 10:41:00', '2025-07-24 10:41:00', NULL, NULL),
(13, 3, 'Natus voluptas numqu', '1753375266-natus-voluptas-numqu', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 3, 'active', '2025-07-24 10:41:06', '2025-07-24 10:41:20', NULL, NULL),
(14, 3, 'Corporis sunt provid', '1753375271-corporis-sunt-provid', 'no', 'no', 'no', 'yes', 'no', 'no', 4, 'active', '2025-07-24 10:41:11', '2025-07-24 10:41:19', NULL, NULL),
(15, 3, 'Qui eos ab laborum s', '1753375276-qui-eos-ab-laborum-s', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 5, 'active', '2025-07-24 10:41:16', '2025-07-24 10:41:16', NULL, NULL),
(16, 4, 'In duis amet omnis', '1753375289-in-duis-amet-omnis', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 1, 'active', '2025-07-24 10:41:29', '2025-07-24 10:41:54', NULL, NULL),
(17, 4, 'Aute sunt quos sed', '1753375294-aute-sunt-quos-sed', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 2, 'active', '2025-07-24 10:41:34', '2025-07-24 10:41:34', NULL, NULL),
(18, 4, 'Ducimus vel nemo fa', '1753375300-ducimus-vel-nemo-fa', 'no', 'no', 'yes', 'no', 'no', 'no', 3, 'active', '2025-07-24 10:41:40', '2025-07-24 10:41:40', NULL, NULL),
(19, 4, 'Consequatur aspernat', '1753375305-consequatur-aspernat', 'no', 'yes', 'yes', 'no', 'no', 'no', 4, 'active', '2025-07-24 10:41:45', '2025-07-24 10:41:45', NULL, NULL),
(20, 4, 'Alias irure quia bla', '1753375310-alias-irure-quia-bla', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 5, 'active', '2025-07-24 10:41:50', '2025-07-24 10:41:53', NULL, NULL),
(21, 5, 'Pariatur Aliquid de', '1753375322-pariatur-aliquid-de', 'no', 'yes', 'yes', 'no', 'no', 'yes', 1, 'active', '2025-07-24 10:42:02', '2025-07-24 10:42:32', NULL, NULL),
(22, 5, 'Elit dicta qui sint', '1753375328-elit-dicta-qui-sint', 'yes', 'no', 'no', 'no', 'no', 'no', 2, 'active', '2025-07-24 10:42:08', '2025-07-24 10:42:08', NULL, NULL),
(23, 5, 'Ipsum accusantium at', '1753375333-ipsum-accusantium-at', 'no', 'yes', 'yes', 'no', 'no', 'no', 3, 'active', '2025-07-24 10:42:13', '2025-07-24 10:42:32', NULL, NULL),
(24, 5, 'Aut obcaecati nostru', '1753375338-aut-obcaecati-nostru', 'no', 'yes', 'yes', 'no', 'no', 'no', 4, 'active', '2025-07-24 10:42:18', '2025-07-24 10:42:18', NULL, NULL),
(25, 5, 'Ut quia ipsa ex eni', '1753375349-ut-quia-ipsa-ex-eni', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 5, 'active', '2025-07-24 10:42:29', '2025-07-24 10:42:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audit_supervisors`
--

CREATE TABLE `audit_supervisors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_supervisors`
--

INSERT INTO `audit_supervisors` (`id`, `audit_id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 1, 4, '2025-07-24 10:50:12', '2025-07-24 10:50:12'),
(4, 1, 6, '2025-07-24 10:50:12', '2025-07-24 10:50:12');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `slug`, `description`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'Cassady Kelley', 'cassady-kelley', 'Eum qui et sunt qui', 1, '2025-07-24 10:42:40', '2025-07-24 10:42:40', NULL, NULL),
(2, 'Petra Battle', 'petra-battle', 'Voluptatem at sint o', 1, '2025-07-24 10:42:45', '2025-07-24 10:42:45', NULL, NULL),
(3, 'Yardley Gould', 'yardley-gould', 'Ut lorem sed elit a', 1, '2025-07-24 10:42:57', '2025-07-24 10:42:57', NULL, NULL),
(4, 'Clinton Sellers', 'clinton-sellers', 'Minim suscipit omnis', 1, '2025-07-24 10:43:04', '2025-07-24 10:43:04', NULL, NULL),
(5, 'Alexa Battle', 'alexa-battle', 'Ea minus facilis lib', 1, '2025-07-24 10:43:10', '2025-07-24 10:43:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_years`
--

CREATE TABLE `financial_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `financial_year` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `financial_years`
--

INSERT INTO `financial_years` (`id`, `financial_year`, `description`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, '2022-23', 'Ducimus tempora exp', 1, '2025-07-24 10:45:07', '2025-07-24 10:45:07', NULL, NULL),
(2, '2023-24', NULL, 1, '2025-07-24 10:45:15', '2025-07-24 10:45:15', NULL, NULL),
(3, '2024-25', NULL, 1, '2025-07-24 10:45:24', '2025-07-24 10:45:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_07_08_170627_create_audit_steps_table', 1),
(6, '2025_07_08_170953_create_audit_step_questions_table', 1),
(7, '2025_07_12_115914_create_designations_table', 1),
(8, '2025_07_16_122957_create_audits_table', 1),
(9, '2025_07_17_055731_create_financial_years_table', 1),
(10, '2025_07_17_055900_create_audit_auditors_table', 1),
(11, '2025_07_17_055934_create_audit_supervisors_table', 1),
(12, '2025_07_17_060156_create_audit_and_step_pairs_table', 1),
(13, '2025_07_17_060358_create_audit_and_step_question_pairs_table', 1),
(14, '2025_07_18_091152_create_organizations_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `slug`, `email`, `mobile`, `phone`, `contact_person_name`, `contact_person_mobile`, `address`, `description`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'Alexis Fowler', 'alexis-fowler', 'hemofeno@mailinator.com', '01609659875', '+1 (329) 944-1271', 'Barclay Griffith', '01609659875', 'Itaque nihil ab quae', 'Do quidem inventore', 'active', 1, '2025-07-24 10:45:40', '2025-07-24 10:45:40', NULL, NULL),
(2, 'Hu Bridges', 'hu-bridges', 'gevuryn@mailinator.com', '01609659879', '+1 (165) 175-4847', 'Caryn Duke', '01609659879', 'Quas quis ea dolores', 'Qui blanditiis debit', 'active', 1, '2025-07-24 10:45:52', '2025-07-24 10:45:52', NULL, NULL),
(3, 'Luke Nash', 'luke-nash', 'zoxucujox@mailinator.com', '01609659873', '+1 (211) 287-7102', 'Jemima Hamilton', '01609659873', 'Quis asperiores cons', 'Sed officia quia ius', 'active', 1, '2025-07-24 10:46:15', '2025-07-24 10:46:47', NULL, NULL),
(4, 'Venus Browning', 'venus-browning', 'nedoduc@mailinator.com', '01785236965', '+1 (139) 863-2817', 'Clio Daugherty', '01785236965', 'Id esse sint verita', 'Ab fuga Eaque quos', 'active', 1, '2025-07-24 10:46:28', '2025-07-24 10:46:28', NULL, NULL),
(5, 'Fletcher Ferguson', 'fletcher-ferguson', 'vykywysyza@mailinator.com', '01986589854', '+1 (585) 933-1515', 'Aaron Henson', '01696358754', 'Corrupti irure libe', 'Magnam voluptatem i', 'active', 1, '2025-07-24 10:46:45', '2025-07-24 10:46:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('administrator','admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `designation_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_plain` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_login_at` datetime DEFAULT NULL,
  `last_logout_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `password_reset_code` int(11) DEFAULT NULL,
  `two_factor_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_expires_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `designation_id`, `name`, `email`, `mobile`, `password_plain`, `password`, `remember_token`, `image`, `cv_path`, `status`, `last_login_at`, `last_logout_at`, `created_at`, `updated_at`, `created_by`, `password_reset_code`, `two_factor_code`, `two_factor_expires_at`, `deleted_at`) VALUES
(1, 'administrator', NULL, 'Mr. Admin', 'administrator@mail.com', '12345679810', '123456', '$2y$10$bVT98uOKrDtTG3znAsB3U.e.0PPQ2WgVfkrQHLIeyz8Cie4Qww2sm', NULL, NULL, NULL, 'active', '2025-07-25 17:37:24', NULL, '2025-07-23 11:44:59', '2025-07-25 11:37:41', 1, NULL, NULL, NULL, NULL),
(2, 'admin', 4, 'Raymond Joyner', 'cany@mailinator.com', '01609605494', '123456', '$2y$10$D5p9xTp5QB9BpgBsYIRypuULocjfEn25TnX0/TFRlLGfF0g8kSNVC', 'ZJbJCmjiDrOigIvNAEBmx8Bpqgqn5RUUePOx56nHgoJ7zDo0dwngHoLujUHV', NULL, NULL, 'active', '2025-07-25 17:01:19', NULL, '2025-07-24 10:43:32', '2025-07-25 11:01:19', 1, NULL, NULL, NULL, NULL),
(3, 'admin', 2, 'Dale Cummings', 'nolofo@mailinator.com', '01698595874', '123456', '$2y$10$x1o7HYxVVnrhq7RUGHodguXuxlhwtnImMisE3RYhggi.5ML0WT1dm', NULL, NULL, NULL, 'active', NULL, NULL, '2025-07-24 10:43:47', '2025-07-24 10:49:26', 1, NULL, NULL, NULL, NULL),
(4, 'admin', 1, 'Jael Fitzpatrick', 'qiduqypamo@mailinator.com', '01625985874', '123456', '$2y$10$zE4pSCIYFHVbExuV0udI7e/u8I0xt/HWiAh0TmvJT0QtZn.v9w3yy', '7tpIDgK5HlJYUiIbBRPxYgk9GntDZJub4etFbU7kRl1kgAyYKspGn3xx7bhh', NULL, NULL, 'active', '2025-07-24 17:34:25', NULL, '2025-07-24 10:44:10', '2025-07-24 11:34:25', 1, NULL, NULL, NULL, NULL),
(5, 'admin', 1, 'Nichole Hunter', 'fuhikak@mailinator.com', '01596854878', '123456', '$2y$10$BBM.EKtCVRXeyYd6CgDz1.MOaf3q4XJugVLZsP2yed10eyL9RzFIO', NULL, NULL, NULL, 'active', NULL, NULL, '2025-07-24 10:44:36', '2025-07-24 10:49:27', 1, NULL, NULL, NULL, NULL),
(6, 'admin', 4, 'Bertha Holden', 'rucosive@mailinator.com', '01789659854', '123456', '$2y$10$TawgH7mQ64UpdgisEk226.WcLA/RBZ9.t.Xn8o4vzkVNqloNGUdC6', NULL, NULL, NULL, 'active', NULL, NULL, '2025-07-24 10:44:51', '2025-07-24 10:44:51', 1, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_and_step_pairs`
--
ALTER TABLE `audit_and_step_pairs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_and_step_question_pairs`
--
ALTER TABLE `audit_and_step_question_pairs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_auditors`
--
ALTER TABLE `audit_auditors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_steps`
--
ALTER TABLE `audit_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_step_questions`
--
ALTER TABLE `audit_step_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_supervisors`
--
ALTER TABLE `audit_supervisors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `financial_years`
--
ALTER TABLE `financial_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_and_step_pairs`
--
ALTER TABLE `audit_and_step_pairs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `audit_and_step_question_pairs`
--
ALTER TABLE `audit_and_step_question_pairs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `audit_auditors`
--
ALTER TABLE `audit_auditors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `audit_steps`
--
ALTER TABLE `audit_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `audit_step_questions`
--
ALTER TABLE `audit_step_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `audit_supervisors`
--
ALTER TABLE `audit_supervisors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_years`
--
ALTER TABLE `financial_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
