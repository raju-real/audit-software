-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2025 at 07:06 PM
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
  `workflow_status` enum('draft','ongoing','reviewed','approved','rejected','complete','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
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
(1, '0001', '2', 3, 'Deserunt quidem cons', '0001-deserunt-quidem-cons', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', '2025-07-30', '2025-07-31', 'active', 'medium', 'draft', NULL, 1, '2025-07-18 10:34:00', '2025-07-18 10:36:19', NULL, NULL),
(2, '0002', '1', 4, 'Molestiae vel in do', '0002-molestiae-vel-in-do', NULL, '2025-07-16', '2025-07-31', 'active', 'low', 'draft', '1752903116_.pdf', 1, '2025-07-18 23:31:56', '2025-07-18 23:31:56', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audit_and_step_pairs`
--

CREATE TABLE `audit_and_step_pairs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_id` int(11) NOT NULL,
  `audit_step_id` int(11) NOT NULL,
  `step_no` int(11) NOT NULL,
  `status` enum('ongoing','complete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ongoing',
  `reviewed_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_and_step_pairs`
--

INSERT INTO `audit_and_step_pairs` (`id`, `audit_id`, `audit_step_id`, `step_no`, `status`, `reviewed_by`, `created_at`, `updated_at`) VALUES
(26, 2, 1, 1, 'ongoing', NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(27, 2, 2, 2, 'ongoing', NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(28, 2, 3, 3, 'ongoing', NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(29, 2, 4, 4, 'ongoing', NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(30, 2, 5, 5, 'ongoing', NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(31, 1, 1, 1, 'ongoing', NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(32, 1, 2, 2, 'ongoing', NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(33, 1, 3, 3, 'ongoing', NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(34, 1, 4, 4, 'ongoing', NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(35, 1, 5, 5, 'ongoing', NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44');

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
(419, 2, 1, 26, 1, 1, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(420, 2, 1, 26, 2, 2, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(421, 2, 1, 26, 3, 3, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(422, 2, 1, 26, 4, 4, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(423, 2, 1, 26, 5, 5, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(424, 2, 2, 27, 8, 1, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(425, 2, 2, 27, 9, 2, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(426, 2, 2, 27, 10, 3, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(427, 2, 2, 27, 11, 4, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(428, 2, 2, 27, 12, 5, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(429, 2, 3, 28, 13, 1, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(430, 2, 3, 28, 14, 2, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(431, 2, 3, 28, 15, 3, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(432, 2, 3, 28, 16, 4, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(433, 2, 3, 28, 17, 5, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(434, 2, 4, 29, 22, 5, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(435, 2, 5, 30, 26, 4, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(436, 2, 5, 30, 27, 5, NULL, NULL, NULL, NULL, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(437, 1, 1, 31, 1, 1, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(438, 1, 1, 31, 2, 2, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(439, 1, 1, 31, 3, 3, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(440, 1, 1, 31, 4, 4, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(441, 1, 1, 31, 5, 5, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(442, 1, 2, 32, 8, 1, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(443, 1, 2, 32, 9, 2, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(444, 1, 2, 32, 10, 3, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(445, 1, 2, 32, 11, 4, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(446, 1, 2, 32, 12, 5, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(447, 1, 3, 33, 13, 1, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(448, 1, 3, 33, 14, 2, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(449, 1, 3, 33, 15, 3, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(450, 1, 3, 33, 16, 4, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(451, 1, 3, 33, 17, 5, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(452, 1, 4, 34, 22, 5, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(453, 1, 5, 35, 26, 4, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(454, 1, 5, 35, 27, 5, NULL, NULL, NULL, NULL, '2025-07-19 04:02:44', '2025-07-19 04:02:44');

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
(25, 2, 2, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(26, 2, 5, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(27, 1, 2, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(28, 1, 3, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(29, 1, 4, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(30, 1, 5, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(31, 1, 6, '2025-07-19 04:02:44', '2025-07-19 04:02:44');

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
(1, 1, 'Dolore assumenda cor', '1752668461-dolore-assumenda-cor', 'Eius in ab sit moll', NULL, 1, 'active', '2025-07-16 06:21:01', '2025-07-16 06:26:04', NULL, NULL),
(2, 2, 'Minim est nesciunt', '1752668466-minim-est-nesciunt', 'Magnam tempora volup', NULL, 1, 'active', '2025-07-16 06:21:06', '2025-07-16 06:21:06', NULL, NULL),
(3, 3, 'Eu nisi aut itaque n', '1752668471-eu-nisi-aut-itaque-n', 'Labore fugiat libero', NULL, 1, 'active', '2025-07-16 06:21:11', '2025-07-16 06:21:11', NULL, NULL),
(4, 4, 'Et odio reprehenderi', '1752668477-et-odio-reprehenderi', 'Voluptas qui qui lab', NULL, 1, 'active', '2025-07-16 06:21:17', '2025-07-16 06:24:41', NULL, NULL),
(5, 5, 'Ex a quas nisi atque', '1752668484-ex-a-quas-nisi-atque', 'Et nihil enim alias', NULL, 1, 'active', '2025-07-16 06:21:24', '2025-07-16 06:21:24', NULL, NULL);

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
(1, 1, 'Consequatur Ea quae', '1752668494-consequatur-ea-quae', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 1, 'active', '2025-07-16 06:21:34', '2025-07-16 06:21:34', NULL, NULL),
(2, 1, 'Quidem enim in ab re', '1752668500-quidem-enim-in-ab-re', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 2, 'active', '2025-07-16 06:21:40', '2025-07-16 06:21:40', NULL, NULL),
(3, 1, 'Commodo nobis accusa', '1752668505-commodo-nobis-accusa', 'no', 'no', 'no', 'yes', 'no', 'yes', 3, 'active', '2025-07-16 06:21:45', '2025-07-16 06:21:45', NULL, NULL),
(4, 1, 'Quia obcaecati natus', '1752668512-quia-obcaecati-natus', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 4, 'active', '2025-07-16 06:21:52', '2025-07-16 06:22:15', NULL, NULL),
(5, 1, 'Officia repudiandae', '1752668520-officia-repudiandae', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 5, 'active', '2025-07-16 06:22:00', '2025-07-16 06:22:00', NULL, NULL),
(6, 1, 'Tenetur aut est enim', '1752668526-tenetur-aut-est-enim', 'no', 'yes', 'yes', 'no', 'no', 'no', 6, 'inactive', '2025-07-16 06:22:06', '2025-07-19 03:58:29', NULL, NULL),
(7, 1, 'Consequatur suscipit', '1752668532-consequatur-suscipit', 'no', 'no', 'yes', 'no', 'no', 'no', 7, 'inactive', '2025-07-16 06:22:12', '2025-07-19 03:58:28', NULL, NULL),
(8, 2, 'Sint corporis id et magnam.', '1752668600-sint-corporis-id-et-magnam', 'no', 'no', 'no', 'no', 'no', 'no', 1, 'active', '2025-07-16 06:23:20', '2025-07-16 06:23:50', NULL, NULL),
(9, 2, 'Ad mollit aliquip re', '1752668607-ad-mollit-aliquip-re', 'yes', 'yes', 'no', 'no', 'no', 'no', 2, 'active', '2025-07-16 06:23:27', '2025-07-16 06:23:50', NULL, NULL),
(10, 2, 'Itaque velit sit om', '1752668613-itaque-velit-sit-om', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 3, 'active', '2025-07-16 06:23:33', '2025-07-16 06:23:49', NULL, NULL),
(11, 2, 'Temporibus dolore qu', '1752668621-temporibus-dolore-qu', 'no', 'no', 'no', 'no', 'yes', 'no', 4, 'active', '2025-07-16 06:23:41', '2025-07-16 06:23:41', NULL, NULL),
(12, 2, 'Voluptatem Earum ne', '1752668626-voluptatem-earum-ne', 'yes', 'no', 'no', 'yes', 'yes', 'no', 5, 'active', '2025-07-16 06:23:46', '2025-07-16 06:23:46', NULL, NULL),
(13, 3, 'Delectus delectus', '1752668640-delectus-delectus', 'no', 'no', 'no', 'yes', 'yes', 'no', 1, 'active', '2025-07-16 06:24:00', '2025-07-16 06:24:30', NULL, NULL),
(14, 3, 'Ut eius alias quo du', '1752668647-ut-eius-alias-quo-du', 'yes', 'no', 'no', 'no', 'yes', 'no', 2, 'active', '2025-07-16 06:24:07', '2025-07-16 06:24:31', NULL, NULL),
(15, 3, 'Labore obcaecati eum', '1752668654-labore-obcaecati-eum', 'no', 'yes', 'no', 'no', 'no', 'yes', 3, 'active', '2025-07-16 06:24:14', '2025-07-16 06:24:30', NULL, NULL),
(16, 3, 'Corporis ipsum quibu', '1752668660-corporis-ipsum-quibu', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 4, 'active', '2025-07-16 06:24:20', '2025-07-16 06:24:20', NULL, NULL),
(17, 3, 'Vel cum porro cupida', '1752668667-vel-cum-porro-cupida', 'no', 'no', 'no', 'no', 'no', 'no', 5, 'active', '2025-07-16 06:24:27', '2025-07-16 06:24:27', NULL, NULL),
(18, 4, 'Lorem in voluptas ad', '1752668688-lorem-in-voluptas-ad', 'no', 'no', 'yes', 'yes', 'yes', 'no', 1, 'inactive', '2025-07-16 06:24:48', '2025-07-16 06:24:48', NULL, NULL),
(19, 4, 'Ut eum beatae quia a', '1752668693-ut-eum-beatae-quia-a', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 2, 'inactive', '2025-07-16 06:24:53', '2025-07-16 06:24:53', NULL, NULL),
(20, 4, 'Rem commodo adipisic', '1752668698-rem-commodo-adipisic', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 3, 'inactive', '2025-07-16 06:24:58', '2025-07-16 06:24:58', NULL, NULL),
(21, 4, 'Minima aut sed dolor', '1752668705-minima-aut-sed-dolor', 'yes', 'no', 'yes', 'no', 'yes', 'no', 4, 'inactive', '2025-07-16 06:25:05', '2025-07-16 06:25:05', NULL, NULL),
(22, 4, 'Sint eum deserunt oc', '1752668716-sint-eum-deserunt-oc', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 5, 'active', '2025-07-16 06:25:16', '2025-07-16 06:25:16', NULL, NULL),
(23, 5, 'Sequi id quia provid', '1752668731-sequi-id-quia-provid', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 1, 'inactive', '2025-07-16 06:25:31', '2025-07-16 06:25:31', NULL, NULL),
(24, 5, 'Qui voluptate repell', '1752668737-qui-voluptate-repell', 'no', 'no', 'no', 'yes', 'no', 'no', 2, 'inactive', '2025-07-16 06:25:37', '2025-07-16 06:25:37', NULL, NULL),
(25, 5, 'Temporibus exercitat', '1752668746-temporibus-exercitat', 'no', 'no', 'no', 'no', 'yes', 'yes', 3, 'inactive', '2025-07-16 06:25:46', '2025-07-16 06:25:46', NULL, NULL),
(26, 5, 'Laborum Laborum Do', '1752668751-laborum-laborum-do', 'no', 'no', 'yes', 'yes', 'no', 'no', 4, 'active', '2025-07-16 06:25:51', '2025-07-16 06:25:51', NULL, NULL),
(27, 5, 'Aliqua Minim beatae', '1752668756-aliqua-minim-beatae', 'no', 'yes', 'no', 'yes', 'yes', 'no', 5, 'active', '2025-07-16 06:25:56', '2025-07-16 06:25:56', NULL, NULL);

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
(21, 2, 4, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(22, 2, 6, '2025-07-19 04:02:21', '2025-07-19 04:02:21'),
(23, 1, 3, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(24, 1, 4, '2025-07-19 04:02:44', '2025-07-19 04:02:44'),
(25, 1, 6, '2025-07-19 04:02:44', '2025-07-19 04:02:44');

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
(1, 'Mikayla Short', 'mikayla-short', 'Voluptate in perspic', 1, '2025-07-16 06:27:02', '2025-07-16 06:27:02', NULL, NULL),
(2, 'Margaret Clemons', 'margaret-clemons', 'Fugiat ullamco volup', 1, '2025-07-16 06:27:08', '2025-07-16 06:27:08', NULL, NULL),
(3, 'Lionel Hoffman', 'lionel-hoffman', 'Explicabo Dolorem c', 1, '2025-07-16 06:27:13', '2025-07-16 06:27:13', NULL, NULL),
(4, 'Hamilton Nicholson', 'hamilton-nicholson', 'Aliquid assumenda to', 1, '2025-07-16 06:27:19', '2025-07-16 06:27:19', NULL, NULL),
(5, 'Hope Melendez', 'hope-melendez', 'Maiores dicta enim a', 1, '2025-07-16 06:27:24', '2025-07-16 06:27:24', NULL, NULL);

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
(1, '2023-24', '2023-24 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2025-07-17 00:45:03', '2025-07-17 00:45:03', NULL, NULL),
(2, '2024-25', '2024-25', 1, '2025-07-17 00:49:06', '2025-07-17 00:49:15', NULL, NULL),
(3, 'dsfsdf', NULL, 1, '2025-07-17 00:49:24', '2025-07-17 00:51:48', '2025-07-17 00:51:48', 1);

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
(15, '2025_07_17_055731_create_financial_years_table', 4),
(24, '2025_07_18_091152_create_organizations_table', 8),
(29, '2025_07_16_122957_create_audits_table', 9),
(30, '2025_07_17_055900_create_audit_auditors_table', 9),
(31, '2025_07_17_055934_create_audit_supervisors_table', 9),
(34, '2025_07_17_060156_create_audit_and_step_pairs_table', 10),
(35, '2025_07_17_060358_create_audit_and_step_question_pairs_table', 10);

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
(1, 'Mikayla Leon', 'mikayla-leon', 'tihet@mailinator.com', '01609605491', '+1 (573) 355-1281', 'Ruby Haynes', '01609605491', 'Molestiae sint verit', 'Voluptate et illo te', 'active', 1, '2025-07-18 03:22:31', '2025-07-18 03:23:59', NULL, NULL),
(2, 'Yoshi Landry', 'yoshi-landry', 'zeguwiqulo@mailinator.com', '01609605492', '+1 (328) 795-3316', 'Odette Slater', '01609605492', 'Magnam expedita dolo', 'Delectus laboriosam', 'active', 1, '2025-07-18 03:24:32', '2025-07-18 03:24:32', NULL, NULL),
(3, 'Karyn Doyle', 'karyn-doyle', 'duruwev@mailinator.com', '01609605493', '+1 (642) 427-3555', 'Austin Hood', '01609605493', 'Id enim et quia maxi', 'Sunt et aute tempor', 'active', 1, '2025-07-18 03:24:44', '2025-07-18 03:24:49', NULL, NULL),
(4, 'Dominique Irwin', 'dominique-irwin', 'qikakilygi@mailinator.com', '01789632597', '+1 (764) 943-5141', 'Tasha French', '01905486598', 'Minima vitae asperio', 'Id pariatur Non aut', 'active', 1, '2025-07-18 03:25:09', '2025-07-18 03:25:09', NULL, NULL),
(5, 'Hanae Dillard', 'hanae-dillard', 'xobecyxoky@mailinator.com', '01609605487', '+1 (353) 608-9933', 'Glenna Finley', '01609605487', 'Ipsum irure cillum v', 'Velit occaecat ullam', 'inactive', 1, '2025-07-18 03:25:23', '2025-07-18 03:25:23', NULL, NULL),
(6, 'Ethics Advance Technology Limited', 'ethics-advance-technology-limited', 'qutehomypa@mailinator.com', '01609605494', '+1 (254) 846-6655', 'Abbot Fuller', '01609605494', 'Cillum consequatur', 'Do excepturi volupta', 'active', 1, '2025-07-18 09:50:32', '2025-07-18 09:50:32', NULL, NULL);

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
(1, 'administrator', NULL, 'Mr. Admin', 'administrator@mail.com', '12345679810', '123456', '$2y$10$uCTGAO09MxzXjg62Tw.T8uMRFaeK.2XRZlcUGPOffOwGX.rgzBXrG', 'wVSqEKIsM2hRJ3srqXIHq22PQbbLDM0mKns6mMqnhEGzWaNTgryxsY1TdPAR', NULL, NULL, 'active', '2025-07-19 15:43:42', NULL, '2025-07-16 05:57:51', '2025-07-19 09:43:42', 1, NULL, NULL, NULL, NULL),
(2, 'admin', 5, 'Marvin Lyons', 'sulasyfosi@mailinator.com', '01603695874', '123456', '$2y$10$SyNxeHXUIbmMTdDRQascbeduhSI0u6tv5.5/43WPbhiCkPkOa9d.q', 'ohzmKqXdMehtjTYd7cZWkvUaOBCnvfR8LJIIBPDa2CA1fvG3LfmtD1yf9KLL', NULL, NULL, 'active', '2025-07-19 09:14:45', NULL, '2025-07-16 06:27:41', '2025-07-19 03:15:11', 1, NULL, NULL, NULL, NULL),
(3, 'admin', 1, 'Maxine Dominguez', 'bikuj@mailinator.com', '01603269587', '123456', '$2y$10$UeEQL2h8g3nMeb7zUKwRNeJ0f1OUHTXYY2BTe9oQa7Rl0CjisHw2u', NULL, NULL, NULL, 'active', NULL, NULL, '2025-07-16 06:27:56', '2025-07-16 06:28:45', 1, NULL, NULL, NULL, NULL),
(4, 'admin', 3, 'Fritz Johnston', 'xepupo@mailinator.com', '01256895769', 'Pa$$w0rd!', '$2y$10$X4hrzSdVFSNKQqQtMbhhpOkJD6wgcD4UJCO95IlHQqAaEBqd6ZiC.', NULL, NULL, NULL, 'active', NULL, NULL, '2025-07-16 06:28:08', '2025-07-18 06:14:18', 1, NULL, NULL, NULL, NULL),
(5, 'admin', 5, 'Joy Frye', 'lunuqaviro@mailinator.com', '01632698587', 'Pa$$w0rd!', '$2y$10$gXYvicaJKohLOO6Ybk5/dOkvb0hMjtSYjJTO2rVrJ.iN6scDDQfNy', NULL, NULL, NULL, 'active', NULL, NULL, '2025-07-16 06:28:39', '2025-07-16 06:28:44', 1, NULL, NULL, NULL, NULL),
(6, 'admin', 1, 'Hamish Contreras', 'dagydyv@mailinator.com', '01752652549', 'Pa$$w0rd!', '$2y$10$CJetpR8hdpjzXzCQa.raJeVjoA5pow36pbRiwOA6XLD9P9udtUV4O', NULL, NULL, NULL, 'active', NULL, NULL, '2025-07-16 06:28:57', '2025-07-18 06:14:19', 1, NULL, NULL, NULL, NULL);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audit_and_step_pairs`
--
ALTER TABLE `audit_and_step_pairs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `audit_and_step_question_pairs`
--
ALTER TABLE `audit_and_step_question_pairs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=455;

--
-- AUTO_INCREMENT for table `audit_auditors`
--
ALTER TABLE `audit_auditors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `audit_steps`
--
ALTER TABLE `audit_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `audit_step_questions`
--
ALTER TABLE `audit_step_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `audit_supervisors`
--
ALTER TABLE `audit_supervisors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
