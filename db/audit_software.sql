-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2025 at 05:06 PM
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
(1, '0001', '1', 1, 'Deserunt incididunt', '0001-deserunt-incididunt', NULL, '2025-08-12', '2025-08-30', 'active', 'high', 'ongoing', NULL, 1, '2025-08-01 05:34:37', '2025-08-04 10:05:14', NULL, NULL);

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
(5, 1, 1, 1, 'approved', 2, 3, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2025-08-01 05:40:25', '2025-08-01 10:54:20'),
(6, 1, 2, 2, 'ongoing', 2, NULL, NULL, NULL, '2025-08-01 05:40:25', '2025-08-04 10:05:14');

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
  `text_answer` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documents` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_and_step_question_pairs`
--

INSERT INTO `audit_and_step_question_pairs` (`id`, `audit_id`, `audit_step_id`, `audit_step_pair_id`, `question_id`, `sorting_serial`, `closed_ended_answer`, `text_answer`, `documents`, `submitted_by`, `created_at`, `updated_at`) VALUES
(5, 1, 1, 5, 1, 1, 'n/a', 'Eum velit ratione qu', NULL, NULL, '2025-08-01 05:40:25', '2025-08-01 05:41:02'),
(6, 1, 1, 5, 2, 2, 'yes', 'Nisi distinctio Per', NULL, NULL, '2025-08-01 05:40:25', '2025-08-01 05:41:02'),
(7, 1, 2, 6, 3, 1, 'no', 'In vitae expedita si', 'assets/files/documents/audit/2024-25/joelle-banks/1754323251_audifair-logo.png', NULL, '2025-08-01 05:40:25', '2025-08-04 10:00:51'),
(8, 1, 2, 6, 4, 2, 'yes', 'Est deserunt fugiat', 'assets/files/documents/audit/2024-25/joelle-banks/1754323502_camscanner-02-08-2025-1214.pdf', NULL, '2025-08-01 05:40:25', '2025-08-04 10:05:02');

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
(3, 1, 2, '2025-08-01 05:40:25', '2025-08-01 05:40:25');

-- --------------------------------------------------------

--
-- Table structure for table `audit_balance_sheets`
--

CREATE TABLE `audit_balance_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_id` int(11) NOT NULL,
  `balance_sheet` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance_sheet_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_balance_sheets`
--

INSERT INTO `audit_balance_sheets` (`id`, `audit_id`, `balance_sheet`, `balance_sheet_path`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(13, 1, '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n  <head>\r\n      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n      <meta name=\"generator\" content=\"PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet\" />\r\n      <title>SPL&amp;OCI</title>\r\n      <meta name=\"created\" content=\"2006-09-16T00:00:00+00:00\" />\r\n      <meta name=\"modified\" content=\"2025-08-03T09:47:58+00:00\" />\r\n    <style type=\"text/css\">\r\n      html { font-family:Calibri, Arial, Helvetica, sans-serif; font-size:11pt; background-color:white }\r\n      a.comment-indicator:hover + div.comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em }\r\n      a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em }\r\n      div.comment { display:none }\r\n      table { border-collapse:collapse }\r\n      .b { text-align:center }\r\n      .e { text-align:center }\r\n      .f { text-align:right }\r\n      .inlineStr { text-align:left }\r\n      .n { text-align:right }\r\n      .s { text-align:left }\r\n      .floatright { float:right }\r\n      .floatleft { float:left }\r\n      td.style0, th.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style1, th.style1 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:18pt }\r\n      td.style2, th.style2 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style3, th.style3 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style4, th.style4 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style5, th.style5 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style6, th.style6 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style7, th.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style8, th.style8 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:16pt }\r\n      td.style9, th.style9 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style10, th.style10 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style11, th.style11 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#00B0F0; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style12, th.style12 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FF0000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style13, th.style13 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style14, th.style14 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#00B050; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style15, th.style15 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#00B0F0; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style16, th.style16 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; font-style:italic; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style17, th.style17 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#00B0F0; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style18, th.style18 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#00B050; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style19, th.style19 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#FF0000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style20, th.style20 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#7030A0; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style21, th.style21 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style22, th.style22 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style23, th.style23 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style24, th.style24 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style25, th.style25 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style26, th.style26 { vertical-align:middle; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style27, th.style27 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style28, th.style28 { vertical-align:middle; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style29, th.style29 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      td.style30, th.style30 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:\'Calibri\'; font-size:11pt }\r\n      table.sheet0 col.col0 { width:214.5pt }\r\n      table.sheet0 col.col1 { width:5.25pt }\r\n      table.sheet0 col.col2 { width:45.75pt }\r\n      table.sheet0 col.col3 { width:5.25pt }\r\n      table.sheet0 col.col4 { width:90.75pt }\r\n      table.sheet0 col.col5 { width:5.25pt }\r\n      table.sheet0 col.col6 { width:105.75pt }\r\n      table.sheet0 col.col7 { width:45.75pt }\r\n      table.sheet0 col.col8 { width:42pt }\r\n      table.sheet0 col.col9 { width:42pt }\r\n      table.sheet0 col.col10 { width:42pt }\r\n      table.sheet0 col.col11 { width:42pt }\r\n      table.sheet0 col.col12 { width:42pt }\r\n      table.sheet0 col.col13 { width:42pt }\r\n      table.sheet0 tr { height:15pt }\r\n      table.sheet0 tr.row1 { height:21pt }\r\n      table.sheet0 tr.row2 { height:21pt }\r\n      table.sheet0 tr.row4 { height:4.5pt }\r\n      table.sheet0 tr.row9 { height:14.5pt }\r\n      table.sheet0 tr.row10 { height:14.5pt }\r\n      table.sheet0 tr.row19 { height:14.5pt }\r\n      table.sheet0 tr.row22 { height:29pt }\r\n      table.sheet0 tr.row27 { height:15pt }\r\n      table.sheet0 tr.row28 { height:15pt }\r\n      table.sheet0 tr.row55 { height:29pt }\r\n      table.sheet0 tr.row65 { height:15pt }\r\n      table.sheet0 tr.row66 { height:15pt }\r\n@page page0 { margin-left: 0.7in; margin-right: 0.7in; margin-top: 0.75in; margin-bottom: 0.75in; size: portrait; }\r\n.navigation {page-break-after: always;}\r\n.scrpgbrk, div + div {page-break-before: always;}\r\n@media screen {\r\n  .gridlines td {border: 1px solid black;}\r\n  .gridlines th {border: 1px solid black;}\r\n  body>div {margin-top: 5px;}\r\n  body>div:first-child {margin-top: 0;}\r\n  .scrpgbrk {margin-top: 1px;}\r\n}\r\n@media print {\r\n  .gridlinesp td {border: 1px solid black;}\r\n  .gridlinesp th {border: 1px solid black;}\r\n  .navigation {display: none;}\r\n}\r\n    </style>\r\n  </head>\r\n\r\n  <body>\r\n<div style=\'page: page0\'>\r\n    <table border=\'0\' cellpadding=\'0\' cellspacing=\'0\' id=\'sheet0\' class=\'sheet0 gridlines\'>\r\n        <col class=\"col0\" />\r\n        <col class=\"col1\" />\r\n        <col class=\"col2\" />\r\n        <col class=\"col3\" />\r\n        <col class=\"col4\" />\r\n        <col class=\"col5\" />\r\n        <col class=\"col6\" />\r\n        <col class=\"col7\" />\r\n        <col class=\"col8\" />\r\n        <col class=\"col9\" />\r\n        <col class=\"col10\" />\r\n        <col class=\"col11\" />\r\n        <col class=\"col12\" />\r\n        <col class=\"col13\" />\r\n        <tbody>\r\n          <tr class=\"row0\">\r\n            <td class=\"column0 style0\">&nbsp;</td>\r\n            <td class=\"column1 style0\">&nbsp;</td>\r\n            <td class=\"column2 style0\">&nbsp;</td>\r\n            <td class=\"column3 style0\">&nbsp;</td>\r\n            <td class=\"column4 style0\">&nbsp;</td>\r\n            <td class=\"column5 style0\">&nbsp;</td>\r\n            <td class=\"column6 style0\">&nbsp;</td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style17 s style17\" colspan=\"6\" rowspan=\"3\">(Comment 1: the blue highlighted values will change from year to year or organization to organization. So, Users should have the option to select the date for calender/ give input.) </td>\r\n          </tr>\r\n          <tr class=\"row1\">\r\n            <td class=\"column0 style8 s\">Statement of Financial Position (Balance Sheet)</td>\r\n            <td class=\"column1 style0\">&nbsp;</td>\r\n            <td class=\"column2 style0\">&nbsp;</td>\r\n            <td class=\"column3 style0\">&nbsp;</td>\r\n            <td class=\"column4 style0\">&nbsp;</td>\r\n            <td class=\"column5 style0\">&nbsp;</td>\r\n            <td class=\"column6 style0\">&nbsp;</td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row2\">\r\n            <td class=\"column0 style8 s\"><span style=\"font-weight:bold; text-decoration:normal; font-style:normal; color:#000000; font-family:\'Calibri\'; font-size:16pt\">As at </span><span style=\"font-weight:bold; text-decoration:normal; font-style:normal; color:#00B0F0; font-family:\'Calibri\'; font-size:16pt\">30 June 2025</span></td>\r\n            <td class=\"column1 style0\">&nbsp;</td>\r\n            <td class=\"column2 style0\">&nbsp;</td>\r\n            <td class=\"column3 style0\">&nbsp;</td>\r\n            <td class=\"column4 style0\">&nbsp;</td>\r\n            <td class=\"column5 style0\">&nbsp;</td>\r\n            <td class=\"column6 style0\">&nbsp;</td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row3\">\r\n            <td class=\"column0 style5 null\"></td>\r\n            <td class=\"column1 style0\">&nbsp;</td>\r\n            <td class=\"column2 style0\">&nbsp;</td>\r\n            <td class=\"column3 style0\">&nbsp;</td>\r\n            <td class=\"column4 style0\">&nbsp;</td>\r\n            <td class=\"column5 style0\">&nbsp;</td>\r\n            <td class=\"column6 style16 s\">Amount in Taka</td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row4\">\r\n            <td class=\"column0 style5 null\"></td>\r\n            <td class=\"column1 style0\">&nbsp;</td>\r\n            <td class=\"column2 style0\">&nbsp;</td>\r\n            <td class=\"column3 style0\">&nbsp;</td>\r\n            <td class=\"column4 style0\">&nbsp;</td>\r\n            <td class=\"column5 style0\">&nbsp;</td>\r\n            <td class=\"column6 style0\">&nbsp;</td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row5\">\r\n            <td class=\"column0 style13 s\">Particulars</td>\r\n            <td class=\"column1 style2 null\"></td>\r\n            <td class=\"column2 style14 s\">Note</td>\r\n            <td class=\"column3 style2 null\"></td>\r\n            <td class=\"column4 style15 s\">As at 30 June 2025</td>\r\n            <td class=\"column5 style2 null\"></td>\r\n            <td class=\"column6 style15 s\">As at 30 June 2024</td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style18 s style18\" colspan=\"6\" rowspan=\"3\">(Comment 2: User should have the option to insert note number as reference in the green highlighted cell column. Some cells might have no value if there are no notes.)</td>\r\n          </tr>\r\n          <tr class=\"row6\">\r\n            <td class=\"column0 style4 s\">Assets</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row7\">\r\n            <td class=\"column0 style4 s\">Non-current assets</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row8\">\r\n            <td class=\"column0 style7 s\">Property, plant and equipment</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row9\">\r\n            <td class=\"column0 style7 s\">Right-of-use assets</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style19 s style19\" colspan=\"6\" rowspan=\"5\">(Comment 3: The balance of the red highlighted values should be equal for their respective columns. That is, As at 30 June 2025: Total assets=Total equity and liabilities. And, As at 30 June 2024: Total assets=Total equity and liabilities. Otherwise, system will raise flag to User.)</td>\r\n          </tr>\r\n          <tr class=\"row10\">\r\n            <td class=\"column0 style7 s\">Investments</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row11\">\r\n            <td class=\"column0 style7 s\">Investment property</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row12\">\r\n            <td class=\"column0 style7 s\">Intangible assets</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row13\">\r\n            <td class=\"column0 style7 s\">Financial assets (non-current)</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row14\">\r\n            <td class=\"column0 style7 s\">Deferred tax assets</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row15\">\r\n            <td class=\"column0 style7 s\">Other non-current assets</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style20 s style20\" colspan=\"6\" rowspan=\"3\">(Can give + and - sign in from of amount and mathematical formula will consider those sign while calculating.)</td>\r\n          </tr>\r\n          <tr class=\"row16\">\r\n            <td class=\"column0 style4 s\">Total non-current assets</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style27 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style27 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row17\">\r\n            <td class=\"column0 style7 null\"></td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row18\">\r\n            <td class=\"column0 style4 s\">Current assets</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row19\">\r\n            <td class=\"column0 style7 s\">Inventories / Project supplies</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style29 s style29\" colspan=\"6\" rowspan=\"2\">(All amounts will be rounded off to the nearest Taka so that they do not include decimals or fractions.)</td>\r\n          </tr>\r\n          <tr class=\"row20\">\r\n            <td class=\"column0 style7 s\">Trade and other receivables</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row21\">\r\n            <td class=\"column0 style7 s\">Advances, deposits and prepayments</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style30 null\"></td>\r\n            <td class=\"column9 style30 null\"></td>\r\n            <td class=\"column10 style30 null\"></td>\r\n            <td class=\"column11 style30 null\"></td>\r\n            <td class=\"column12 style30 null\"></td>\r\n            <td class=\"column13 style30 null\"></td>\r\n          </tr>\r\n          <tr class=\"row22\">\r\n            <td class=\"column0 style7 s\">Current account (receivable) with subsidiaries and sister concerns</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row23\">\r\n            <td class=\"column0 style7 s\">Financial assets (current)</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row24\">\r\n            <td class=\"column0 style7 s\">Cash and cash equivalents</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row25\">\r\n            <td class=\"column0 style4 s\">Total current assets</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style27 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style27 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row26\">\r\n            <td class=\"column0 style7 null\"></td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row27\">\r\n            <td class=\"column0 style12 s\">Total assets</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style28 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style28 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row28\">\r\n            <td class=\"column0 style7 null\"></td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row29\">\r\n            <td class=\"column0 style4 s\">Equity and liabilities</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row30\">\r\n            <td class=\"column0 style4 s\">Equity</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row31\">\r\n            <td class=\"column0 style7 s\">Share capital / Fund balance</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row32\">\r\n            <td class=\"column0 style7 s\">Share premium</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row33\">\r\n            <td class=\"column0 style7 s\">Share money deposits</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row34\">\r\n            <td class=\"column0 style7 s\">Retained earnings / Accumulated fund</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row35\">\r\n            <td class=\"column0 style7 s\">Revaluation reserve</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row36\">\r\n            <td class=\"column0 style7 s\">Tax holiday reserve</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row37\">\r\n            <td class=\"column0 style7 s\">Fair value reserve</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row38\">\r\n            <td class=\"column0 style7 s\">Other reserves</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row39\">\r\n            <td class=\"column0 style7 s\">Non-controlling interest</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row40\">\r\n            <td class=\"column0 style4 s\">Total equity</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style27 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style27 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row41\">\r\n            <td class=\"column0 style7 null\"></td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row42\">\r\n            <td class=\"column0 style4 s\">Non-current liabilities</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row43\">\r\n            <td class=\"column0 style7 s\">Long-term borrowings (non-current portion)</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row44\">\r\n            <td class=\"column0 style7 s\">Lease liabilities (non-current portion)</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row45\">\r\n            <td class=\"column0 style7 s\">Provisions (non-current)</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row46\">\r\n            <td class=\"column0 style7 s\">Deferred tax liabilities</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row47\">\r\n            <td class=\"column0 style7 s\">Employee benefit obligations</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row48\">\r\n            <td class=\"column0 style4 s\">Total non-current liabilities</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style27 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style27 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row49\">\r\n            <td class=\"column0 style7 null\"></td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row50\">\r\n            <td class=\"column0 style4 s\">Current liabilities</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row51\">\r\n            <td class=\"column0 style7 s\">Trade and other payables</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row52\">\r\n            <td class=\"column0 style7 s\">Long-term borrowings (current portion)</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row53\">\r\n            <td class=\"column0 style7 s\">Short-term borrowings</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row54\">\r\n            <td class=\"column0 style7 s\">Lease liabilities (current portion)</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row55\">\r\n            <td class=\"column0 style7 s\">Current account (payable) with subsidiaries and sister concerns</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row56\">\r\n            <td class=\"column0 style7 s\">Interest payable</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row57\">\r\n            <td class=\"column0 style7 s\">Unclaimed dividend</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row58\">\r\n            <td class=\"column0 style7 s\">Accruals and provisions (current)</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row59\">\r\n            <td class=\"column0 style7 s\">Other current liabilities</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row60\">\r\n            <td class=\"column0 style7 s\">Current tax liabilities</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row61\">\r\n            <td class=\"column0 style4 s\">Total current liabilities</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style27 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style27 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row62\">\r\n            <td class=\"column0 style7 null\"></td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row63\">\r\n            <td class=\"column0 style4 s\">Total liabilities</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style27 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style27 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row64\">\r\n            <td class=\"column0 style7 null\"></td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style7 null\"></td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style7 null\"></td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n          <tr class=\"row65\">\r\n            <td class=\"column0 style12 s\">Total equity and liabilities</td>\r\n            <td class=\"column1 style10 null\"></td>\r\n            <td class=\"column2 style10 null\"></td>\r\n            <td class=\"column3 style10 null\"></td>\r\n            <td class=\"column4 style28 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column5 style10 null\"></td>\r\n            <td class=\"column6 style28 n\">&nbsp;&nbsp;-   </td>\r\n            <td class=\"column7 style0\">&nbsp;</td>\r\n            <td class=\"column8 style0\">&nbsp;</td>\r\n            <td class=\"column9 style0\">&nbsp;</td>\r\n            <td class=\"column10 style0\">&nbsp;</td>\r\n            <td class=\"column11 style0\">&nbsp;</td>\r\n            <td class=\"column12 style0\">&nbsp;</td>\r\n            <td class=\"column13 style0\">&nbsp;</td>\r\n          </tr>\r\n    </tbody></table>\r\n</div>\r\n  </body>\r\n</html>\r\n', 'assets/files/documents/audit/2024-25/joelle-banks/1755445338_financial-statements-format.xlsx', 2, '2025-08-17 09:42:18', '2025-08-17 09:42:18', NULL, NULL);

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
(1, 1, 'Eveniet recusandae', '1754047906-eveniet-recusandae', 'Minus quaerat illum', NULL, 1, 'active', '2025-08-01 05:31:46', '2025-08-01 05:31:55', NULL, NULL),
(2, 2, 'Excepturi quo deseru', '1754047912-excepturi-quo-deseru', 'Ad non eiusmod volup', NULL, 1, 'active', '2025-08-01 05:31:52', '2025-08-01 05:31:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audit_step_questions`
--

CREATE TABLE `audit_step_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_step_id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(1, 1, 'Esse aperiam non ra', '1754047933-esse-aperiam-non-ra', 'no', 'no', 'no', 'no', 'yes', 'no', 1, 'active', '2025-08-01 05:32:13', '2025-08-01 05:39:32', NULL, NULL),
(2, 1, 'Illum dolores qui d', '1754047955-illum-dolores-qui-d', 'yes', 'yes', 'no', 'no', 'no', 'no', 2, 'active', '2025-08-01 05:32:35', '2025-08-01 05:39:39', NULL, NULL),
(3, 2, 'Amet nihil reprehen', '1754047967-amet-nihil-reprehen', 'no', 'no', 'no', 'yes', 'yes', 'yes', 1, 'active', '2025-08-01 05:32:47', '2025-08-04 09:18:11', NULL, NULL),
(4, 2, 'Deserunt et consecte', '1754047971-deserunt-et-consecte', 'no', 'yes', 'no', 'no', 'yes', 'yes', 2, 'active', '2025-08-01 05:32:51', '2025-08-01 05:32:51', NULL, NULL);

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
(3, 1, 3, '2025-08-01 05:40:25', '2025-08-01 05:40:25');

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
(1, 'Zephania Hickman', 'zephania-hickman', 'Iusto esse possimus', 1, '2025-08-01 05:33:02', '2025-08-01 05:33:02', NULL, NULL),
(2, 'Dolan Howard', 'dolan-howard', 'Dolor consequatur v', 1, '2025-08-01 05:33:07', '2025-08-01 05:33:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_forms`
--

CREATE TABLE `dynamic_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_step_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_json` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dynamic_forms`
--

INSERT INTO `dynamic_forms` (`id`, `audit_step_id`, `question_id`, `title`, `form_json`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'User Registration Form', '[{\"type\":\"text\",\"required\":true,\"label\":\"Name\",\"placeholder\":\"Name\",\"className\":\"form-control\",\"name\":\"text-1759339945729-0\",\"access\":false,\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Email\",\"placeholder\":\"Email\",\"className\":\"form-control\",\"name\":\"text-1759339970624-0\",\"access\":false,\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Mobile\",\"placeholder\":\"Mobile\",\"className\":\"form-control\",\"name\":\"text-1759339985806-0\",\"access\":false,\"subtype\":\"text\"},{\"type\":\"date\",\"required\":true,\"label\":\"Date of Birth\",\"placeholder\":\"Date of Birth\",\"className\":\"form-control\",\"name\":\"date-1759340148775-0\",\"access\":false,\"subtype\":\"date\"},{\"type\":\"textarea\",\"required\":false,\"label\":\"Short Description\",\"description\":\"Write something about yourself\",\"placeholder\":\"Short Description\",\"className\":\"form-control\",\"name\":\"textarea-1759340021440-0\",\"access\":false,\"subtype\":\"textarea\"},{\"type\":\"paragraph\",\"subtype\":\"p\",\"label\":\"<strong style=\\\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\\\">Lorem Ipsum<\\/strong><span style=\\\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\\\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/span>\",\"access\":false},{\"type\":\"file\",\"required\":true,\"label\":\"Photo\",\"placeholder\":\"Photo\",\"className\":\"form-control\",\"name\":\"file-1759340111067-0\",\"access\":false,\"multiple\":false},{\"type\":\"signature\",\"required\":false,\"label\":\"Signature\",\"name\":\"signature-1759340178722-0\",\"access\":false}]', 1, '2025-10-01 11:37:31', '2025-10-01 13:46:50'),
(2, 2, 4, 'Acknowledgement Form', '[{\"type\":\"date\",\"required\":false,\"label\":\"Date\",\"description\":\"Type Visit Date\",\"placeholder\":\"Date\",\"className\":\"form-control\",\"name\":\"date-1759390096976-0\",\"access\":false,\"subtype\":\"date\"},{\"type\":\"select\",\"required\":false,\"label\":\"DISTRICT\",\"className\":\"form-control\",\"name\":\"select-1759391359722-0\",\"access\":false,\"multiple\":false,\"values\":[{\"label\":\"A\",\"value\":\"B\",\"selected\":true},{\"label\":\"C\",\"value\":\"D\",\"selected\":false},{\"label\":\"E\",\"value\":\"F\",\"selected\":false}]},{\"type\":\"text\",\"required\":true,\"label\":\"Client Name\",\"placeholder\":\"Client Name\",\"className\":\"form-control\",\"name\":\"text-1759389927074-0\",\"access\":false,\"subtype\":\"text\",\"maxlength\":100},{\"type\":\"text\",\"required\":false,\"label\":\"Company Name\",\"placeholder\":\"Company Name\",\"className\":\"form-control\",\"name\":\"text-1759389961267-0\",\"access\":false,\"subtype\":\"text\",\"maxlength\":100},{\"type\":\"textarea\",\"required\":false,\"label\":\"Audit Summery\",\"description\":\"Write Shortly about Audit Summery\",\"placeholder\":\"Audit Summery\",\"className\":\"form-control\",\"name\":\"textarea-1759389986480-0\",\"access\":false,\"subtype\":\"textarea\",\"maxlength\":5000,\"rows\":5},{\"type\":\"autocomplete\",\"required\":true,\"label\":\"Audit Status\",\"className\":\"form-control\",\"name\":\"autocomplete-1759390036204-0\",\"access\":false,\"requireValidOption\":true,\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true},{\"label\":\"Option 2\",\"value\":\"option-2\",\"selected\":false},{\"label\":\"Option 3\",\"value\":\"option-3\",\"selected\":false}]},{\"type\":\"radio-group\",\"required\":false,\"label\":\"Client Satisfied ?\",\"inline\":false,\"name\":\"radio-group-1759390140573-0\",\"access\":false,\"other\":false,\"values\":[{\"label\":\"Yes\",\"value\":\"No\",\"selected\":true},{\"label\":\"No\",\"value\":\"No\",\"selected\":false}]},{\"type\":\"paragraph\",\"subtype\":\"p\",\"label\":\"<strong style=\\\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\\\">Lorem Ipsum</strong><span style=\\\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\\\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span>\",\"access\":false},{\"type\":\"signature\",\"required\":false,\"label\":\"Submitted By\",\"placeholder\":\"Submitted By\",\"name\":\"signature-1759390365918-0\",\"access\":false}]', 1, '2025-10-02 01:34:01', '2025-10-02 01:50:16'),
(3, 1, 1, 'Default Render Check', '[{\"type\":\"autocomplete\",\"required\":true,\"label\":\"Search City\",\"className\":\"form-control\",\"name\":\"autocomplete-1759508088595-0\",\"access\":false,\"requireValidOption\":false,\"values\":[{\"label\":\"Dhaka\",\"value\":\"Rangpur\",\"selected\":true},{\"label\":\"Sylhet\",\"value\":\"Barisal\",\"selected\":false},{\"label\":\"Kurigram\",\"value\":\"Lalmonirhat\",\"selected\":false}]},{\"type\":\"select\",\"required\":true,\"label\":\"Select\",\"className\":\"form-control\",\"name\":\"select-1759464304839-0\",\"access\":false,\"multiple\":false,\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true},{\"label\":\"Option 2\",\"value\":\"option-2\",\"selected\":false},{\"label\":\"Option 3\",\"value\":\"option-3\",\"selected\":false}]},{\"type\":\"text\",\"required\":false,\"label\":\"Name\",\"description\":\"Name\",\"placeholder\":\"Name\",\"className\":\"form-control\",\"name\":\"text-1759464208746-0\",\"access\":false,\"subtype\":\"text\"},{\"type\":\"file\",\"required\":true,\"label\":\"Profile Photo\",\"placeholder\":\"Profile Photo\",\"className\":\"form-control\",\"name\":\"file-1759508148771-0\",\"access\":false,\"multiple\":false},{\"type\":\"file\",\"required\":false,\"label\":\"Group Photo\",\"description\":\"Select Multiple\",\"placeholder\":\"Group Photo\",\"className\":\"form-control\",\"name\":\"file-1759508184996-0\",\"access\":false,\"multiple\":true},{\"type\":\"textarea\",\"required\":true,\"label\":\"About Yourself\",\"placeholder\":\"About Yourself\",\"className\":\"form-control\",\"name\":\"textarea-1759464297617-0\",\"access\":false,\"subtype\":\"textarea\"},{\"type\":\"date\",\"required\":false,\"label\":\"Date of Birth\",\"description\":\"Date of Birth\",\"placeholder\":\"Date of Birth\",\"className\":\"form-control\",\"name\":\"date-1759464258411-0\",\"access\":false,\"subtype\":\"date\"},{\"type\":\"checkbox-group\",\"required\":false,\"label\":\"Checkbox Group\",\"toggle\":false,\"inline\":false,\"name\":\"checkbox-group-1759464322604-0\",\"access\":false,\"other\":false,\"values\":[{\"label\":\"Name\",\"value\":\"Name\",\"selected\":true},{\"label\":\"Email\",\"value\":\"Email\",\"selected\":false},{\"label\":\"Mobile\",\"value\":\"Mobile\",\"selected\":false}]},{\"type\":\"radio-group\",\"required\":false,\"label\":\"Radio Group\",\"inline\":false,\"name\":\"radio-group-1759464368666-0\",\"access\":false,\"other\":false,\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":false},{\"label\":\"Option 2\",\"value\":\"option-2\",\"selected\":false},{\"label\":\"Option 3\",\"value\":\"option-3\",\"selected\":false}]},{\"type\":\"paragraph\",\"subtype\":\"p\",\"label\":\"<strong style=\\\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\\\">Lorem Ipsum</strong><span style=\\\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\\\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span>\",\"access\":false},{\"type\":\"signature\",\"required\":false,\"label\":\"Signature\",\"name\":\"signature-1759465136768-0\",\"access\":false},{\"type\":\"paragraph\",\"subtype\":\"p\",\"label\":\"Terms and Condition<br><strong style=\\\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\\\">Lorem Ipsum</strong><span style=\\\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\\\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span>\",\"access\":false}]', 1, '2025-10-02 22:06:31', '2025-10-03 10:17:13'),
(4, 1, 2, 'Acknowledgement Form', '[{\"type\":\"header\",\"subtype\":\"h2\",\"label\":\"Acknowledgement Form\",\"access\":false},{\"type\":\"text\",\"required\":true,\"label\":\"Name\",\"placeholder\":\"Name\",\"className\":\"form-control\",\"name\":\"text-1759513122597-0\",\"access\":false,\"subtype\":\"text\"},{\"type\":\"text\",\"subtype\":\"email\",\"required\":false,\"label\":\"Text Field\",\"placeholder\":\"Email\",\"className\":\"form-control\",\"name\":\"text-1759513148634-0\",\"access\":false},{\"type\":\"date\",\"required\":true,\"label\":\"Date of Birth\",\"placeholder\":\"Date of Birth\",\"className\":\"form-control\",\"name\":\"date-1759513243729-0\",\"access\":false,\"subtype\":\"date\"},{\"type\":\"radio-group\",\"required\":true,\"label\":\"Gender\",\"inline\":false,\"name\":\"radio-group-1759513299499-0\",\"access\":false,\"other\":false,\"values\":[{\"label\":\"Male\",\"value\":\"Male\",\"selected\":false},{\"label\":\"Female\",\"value\":\"Female\",\"selected\":false}]},{\"type\":\"textarea\",\"required\":true,\"label\":\"Short Bio\",\"placeholder\":\"Short Bio\",\"className\":\"form-control\",\"name\":\"textarea-1759513196606-0\",\"access\":false,\"subtype\":\"textarea\"}]', 1, '2025-10-03 11:43:44', '2025-10-03 11:43:44');

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
(1, '2024-25', NULL, 1, '2025-08-01 05:33:52', '2025-08-01 05:33:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_step_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `order` int(11) NOT NULL DEFAULT 0,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `multiple` tinyint(1) NOT NULL DEFAULT 0,
  `placeholder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paragraph` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_responses`
--

CREATE TABLE `form_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(11) NOT NULL,
  `audit_step_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `response_json` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `submitted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_responses`
--

INSERT INTO `form_responses` (`id`, `form_id`, `audit_step_id`, `question_id`, `response_json`, `submitted_by`, `created_at`, `updated_at`) VALUES
(5, 1, 1, 1, '{\"text-1759339945729-0\":\"Reprehenderit volupt\",\"text-1759339970624-0\":\"Ad quis commodi obca\",\"text-1759339985806-0\":\"Laboris dolore place\",\"date-1759340148775-0\":\"02-Mar-1995\",\"textarea-1759340021440-0\":\"Ut iste voluptas sim\",\"file-1759340111067-0\":\"assets\\/files\\/forms\\/1759349053_download.png\",\"signature-1759340178722-0\":\"assets\\/files\\/forms\\/signatures\\/68dd893d21806.png\"}', 1, '2025-10-01 14:04:13', '2025-10-01 14:04:13'),
(6, 3, 1, 1, '{\"autocomplete-1759508088595-0\":\"Rangpur\",\"select-1759464304839-0\":\"option-2\",\"text-1759464208746-0\":null,\"file-1759508148771-0\":\"assets\\/files\\/forms\\/1759508298_download-1.jpeg\",\"file-1759508184996-0\":[\"assets\\/files\\/forms\\/1759508298_download.jpeg\",\"assets\\/files\\/forms\\/1759508298_download.png\",\"assets\\/files\\/forms\\/1759508298_images.png\"],\"textarea-1759464297617-0\":\"Lomem ipsum\",\"date-1759464258411-0\":\"2025-10-25\",\"checkbox-group-1759464322604-0\":[\"Name\",\"Email\",\"Mobile\"],\"radio-group-1759464368666-0\":\"option-1\",\"signature-1759465136768-0\":\"assets\\/files\\/forms\\/signatures\\/68dff74aca028.png\"}', 1, '2025-10-03 10:18:18', '2025-10-03 10:18:18');

-- --------------------------------------------------------

--
-- Table structure for table `form_submissions`
--

CREATE TABLE `form_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` bigint(20) UNSIGNED NOT NULL,
  `audit_step_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_submission_files`
--

CREATE TABLE `form_submission_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` int(11) NOT NULL,
  `field_id` int(11) DEFAULT NULL,
  `field_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `mime` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(14, '2025_07_18_091152_create_organizations_table', 1),
(15, '2025_08_06_154724_create_audit_balance_sheets_table', 2),
(33, '2025_09_29_162436_create_forms_table', 3),
(34, '2025_09_29_162519_create_form_fields_table', 3),
(35, '2025_09_29_162553_create_form_submissions_table', 3),
(36, '2025_09_29_162619_create_form_submission_files_table', 3),
(37, '2025_09_30_175122_create_dynamic_forms_table', 3),
(38, '2025_09_30_175436_create_form_responses_table', 3);

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
(1, 'Joelle Banks', 'joelle-banks', 'zyfolun@mailinator.com', '01609605494', '+1 (229) 954-2197', 'Ferdinand Daniels', '01609605494', 'Aliqua Duis et enim', 'Sed proident volupt', 'active', 1, '2025-08-01 05:34:04', '2025-08-01 05:34:04', NULL, NULL);

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
(1, 'administrator', NULL, 'Mr. Admin', 'administrator@mail.com', '01609605494', '123456', '$2y$10$5nj0xCCi3gjsmPY/8qt1Meb1mHcQ9B9YknOT1XetfxgTOWtC2KUo6', 'JJ6Mc7xhUNx7EBNGr6kV0yzg5PK2dxjotWdaFYX41w8g8ESRYu34FwyHN3XU', NULL, NULL, 'active', '2025-10-03 16:02:46', NULL, '2025-07-26 10:07:17', '2025-10-03 10:02:46', 1, NULL, NULL, NULL, NULL),
(2, 'admin', 2, 'Winifred Head', 'neqepucym@mailinator.com', '01609605496', '123456', '$2y$10$r63zOh4KPaS9uBmKWZKh4e93IK8msoUJOX.DOmENNkFiBc9mhDE6a', NULL, NULL, NULL, 'active', '2025-08-17 15:36:51', NULL, '2025-08-01 05:33:24', '2025-08-17 09:36:51', 1, NULL, NULL, NULL, NULL),
(3, 'admin', 2, 'Reese Hodge', 'tobuqive@mailinator.com', '01609605495', '123456', '$2y$10$pUqh8cGjeYGfEmPZDLkVEeO0OiHf/hCJ0aZWz9LEPv0o.FOM/8y1m', NULL, NULL, NULL, 'active', '2025-08-07 16:45:31', NULL, '2025-08-01 05:33:38', '2025-08-07 10:45:31', 1, NULL, NULL, NULL, NULL);

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
-- Indexes for table `audit_balance_sheets`
--
ALTER TABLE `audit_balance_sheets`
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
-- Indexes for table `dynamic_forms`
--
ALTER TABLE `dynamic_forms`
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
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_responses`
--
ALTER TABLE `form_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_submissions`
--
ALTER TABLE `form_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_submission_files`
--
ALTER TABLE `form_submission_files`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `audit_and_step_question_pairs`
--
ALTER TABLE `audit_and_step_question_pairs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `audit_auditors`
--
ALTER TABLE `audit_auditors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `audit_balance_sheets`
--
ALTER TABLE `audit_balance_sheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `audit_steps`
--
ALTER TABLE `audit_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audit_step_questions`
--
ALTER TABLE `audit_step_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `audit_supervisors`
--
ALTER TABLE `audit_supervisors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dynamic_forms`
--
ALTER TABLE `dynamic_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_years`
--
ALTER TABLE `financial_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_responses`
--
ALTER TABLE `form_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `form_submissions`
--
ALTER TABLE `form_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_submission_files`
--
ALTER TABLE `form_submission_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
