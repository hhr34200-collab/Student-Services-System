-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 23 يوليو 2026 الساعة 01:59
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_serviceses`
--

-- --------------------------------------------------------

--
-- بنية الجدول `appeals`
--

CREATE TABLE `appeals` (
  `appeal_id` bigint(20) UNSIGNED NOT NULL,
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `semester` enum('first','second') NOT NULL,
  `submission_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `appeals`
--

INSERT INTO `appeals` (`appeal_id`, `request_id`, `academic_year`, `semester`, `submission_date`, `created_at`, `updated_at`) VALUES
(8, 100, '2026/2027', 'second', '2026-07-01', '2026-07-13 00:22:25', '2026-07-13 00:22:25');

-- --------------------------------------------------------

--
-- بنية الجدول `appeal_items`
--

CREATE TABLE `appeal_items` (
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `appeal_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `appeal_items`
--

INSERT INTO `appeal_items` (`item_id`, `appeal_id`, `course_id`, `reason`, `created_at`, `updated_at`) VALUES
(9, 8, 32, 'اريد مراجعه الجمع', '2026-07-13 00:22:25', '2026-07-13 00:22:25');

-- --------------------------------------------------------

--
-- بنية الجدول `attachments`
--

CREATE TABLE `attachments` (
  `attachment_id` bigint(20) UNSIGNED NOT NULL,
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `attachments`
--

INSERT INTO `attachments` (`attachment_id`, `request_id`, `file_name`, `file_path`, `file_type`, `file_size`, `created_at`, `updated_at`, `is_verified`) VALUES
(57, 90, 'cvm.png', 'attachments/F54Lm3C6ghgVPAUSaJSF5AKIqvqui9vxyYnku50F.png', 'image/png', 86956, '2026-07-12 18:11:03', '2026-07-12 18:11:03', 0),
(58, 90, 'cvm.png', 'attachments/ZPXbjg5AecmyJvgEFWT22gmZerCGi6LG0EyHUx9h.png', 'image/png', 86956, '2026-07-12 18:11:05', '2026-07-12 18:11:05', 0),
(63, 98, 'تطبيق الكلسترنج 2.png', 'attachments/ja3CcTM23DOnXaiEeEZbv02zGx5jnVV3u85L5CJH.png', 'png', 67694, '2026-07-12 23:56:38', '2026-07-12 23:56:38', 0),
(65, 100, 'تطبيق المحاكه فالفير.png', 'attachments/vj0QWw9LXoqK0DzVVY03cfBgFo2f4nzaDErvwmvB.png', 'png', 89995, '2026-07-13 00:22:25', '2026-07-13 00:22:25', 0),
(66, 101, 'تطبيق الكلسترنج 2.png', 'attachments/nAwjpuy0t4sHdPgsBEDqRPan9RSTfe3ygVrn7HEt.png', 'png', 67694, '2026-07-13 02:01:10', '2026-07-13 02:01:10', 0),
(67, 101, 'تطبيق المحاكه فالفير.png', 'attachments/wsIzXTyX8XOHZvs5Tg3Oag5hmQ1CSM6JqmVtVX6b.png', 'image/png', 89995, '2026-07-13 02:06:10', '2026-07-13 02:06:10', 0),
(68, 102, 'تطبيق الكلسترنج 2.png', 'attachments/prMqpPCASVX17rVqhOkISBhSN6Jntn9KhAStRVpv.png', 'image/png', 67694, '2026-07-13 03:52:06', '2026-07-13 03:52:06', 0);

-- --------------------------------------------------------

--
-- بنية الجدول `colleges`
--

CREATE TABLE `colleges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `college_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `colleges`
--

INSERT INTO `colleges` (`id`, `college_name`, `created_at`, `updated_at`) VALUES
(2, 'كلية تكنولوجيا المعلمومات وعلوم الحاسوب', NULL, NULL),
(3, 'كلية التربية', '2026-07-04 15:44:38', '2026-07-04 15:44:38'),
(4, 'كليه الطب', '2026-07-10 16:01:45', '2026-07-10 16:01:45');

-- --------------------------------------------------------

--
-- بنية الجدول `courses`
--

CREATE TABLE `courses` (
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `level` enum('المستوى الأول','المستوى الثاني','المستوى الثالث','المستوى الرابع') NOT NULL,
  `semester` enum('first','second') NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `level`, `semester`, `status`, `created_at`, `updated_at`) VALUES
(30, 'مهارات حاسوب', 'المستوى الرابع', 'first', 'active', '2026-07-10 15:39:35', '2026-07-10 15:50:41'),
(31, 'برمجه 1', 'المستوى الثاني', 'first', 'active', '2026-07-10 16:02:26', '2026-07-10 16:02:26'),
(32, 'نظريه برمجه', 'المستوى الثالث', 'second', 'active', '2026-07-12 18:37:32', '2026-07-12 18:37:32'),
(33, 'التحليل والتصميم', 'المستوى الرابع', 'second', 'active', '2026-07-12 18:38:45', '2026-07-12 18:38:45');

-- --------------------------------------------------------

--
-- بنية الجدول `course_assignments`
--

CREATE TABLE `course_assignments` (
  `assignment_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `semester` enum('first','second') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `course_assignments`
--

INSERT INTO `course_assignments` (`assignment_id`, `course_id`, `department_id`, `employee_id`, `academic_year`, `semester`, `created_at`, `updated_at`) VALUES
(46, 32, 3, 13, '2026/2027', 'second', '2026-07-12 18:39:28', '2026-07-12 18:39:28'),
(47, 33, 3, 12, '2026/2027', 'second', '2026-07-12 18:40:21', '2026-07-12 18:43:42');

-- --------------------------------------------------------

--
-- بنية الجدول `course_departments`
--

CREATE TABLE `course_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `course_departments`
--

INSERT INTO `course_departments` (`id`, `course_id`, `department_id`, `created_at`, `updated_at`) VALUES
(4, 30, 3, NULL, NULL),
(5, 31, 3, NULL, NULL),
(6, 32, 3, NULL, NULL),
(7, 32, 5, NULL, NULL),
(8, 33, 3, NULL, NULL),
(9, 33, 5, NULL, NULL),
(10, 33, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `college_id`, `created_at`, `updated_at`) VALUES
(3, 'علوم حاسوب', 2, NULL, NULL),
(4, 'رياضيات', 3, '2026-07-04 15:45:07', '2026-07-04 15:45:07'),
(5, 'نظم معلومات', 2, '2026-07-12 17:03:06', '2026-07-12 17:03:06'),
(6, 'امن سبراني', 2, '2026-07-12 17:03:35', '2026-07-12 17:03:35');

-- --------------------------------------------------------

--
-- بنية الجدول `employees`
--

CREATE TABLE `employees` (
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `employee_number` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_number`, `full_name`, `college_id`, `department_id`, `job_title`, `phone`, `status`, `created_at`, `updated_at`) VALUES
(10, '142538', 'علي أحمد العقيلي', 2, 3, 'موظف شؤون الطلاب', '778196123', 'active', '2026-07-12 17:45:31', '2026-07-12 17:45:31'),
(11, '142539', 'اسامه سيف', 2, 3, 'رئيس القسم', '781963455', 'active', '2026-07-12 17:48:37', '2026-07-12 17:48:37'),
(12, '142540', 'عبدالعزيز ثوابه', 2, 3, 'عميد الكلية', '789456123', 'active', '2026-07-12 17:50:39', '2026-07-12 17:50:39'),
(13, '142541', 'محمد مكرد', 2, 3, 'رئيس قسم الأرشيف', '71485296', 'active', '2026-07-12 17:54:24', '2026-07-12 17:54:24');

-- --------------------------------------------------------

--
-- بنية الجدول `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_06_12_200721_create_roles_table', 1),
(2, '2026_06_12_200722_create_colleges_table', 1),
(3, '2026_06_12_200723_create_departments_table', 1),
(4, '2026_06_12_200802_create_students_table', 1),
(5, '2026_06_12_200803_create_users_table', 1),
(6, '2026_06_12_201104_create_employees_table', 1),
(7, '2026_06_12_201200_create_permissions_table', 1),
(8, '2026_06_12_201201_create_role_permissions_table', 1),
(9, '2026_06_12_222019_create_services_table', 1),
(10, '2026_06_12_222130_create_requests_table', 1),
(11, '2026_06_12_222655_create_stop_enrollments_table', 1),
(12, '2026_06_12_223151_create_attachments_table', 1),
(13, '2026_06_12_223407_create_notifications_table', 1),
(14, '2026_06_14_212627_add_type_to_notifications_table', 2),
(15, '2026_06_20_193759_modify_notification_type_enum', 3),
(16, '2026_06_21_220447_create_jobs_table', 4),
(17, '2026_06_23_204724_create_reopen_enrollments_table', 5),
(18, '2026_06_24_220327_add_academic_status_to_students_table', 6),
(19, '2026_06_24_221847_add_approved_at_to_requests_table', 7),
(20, '2026_06_26_185444_create_request_approvals_table', 8),
(21, '2026_06_26_185654_add_unique_to_role_permissions', 9),
(22, '2026_06_26_185922_add_unique_to_role_name_in_roles_table', 9),
(23, '2026_06_26_190126_add_unique_to_permission_name_in_permissions_table', 9),
(24, '2026_06_28_221900_update_employees_table_structure', 10),
(25, '2026_06_29_184629_add_phone_to_users_table', 11),
(26, '2026_06_29_220721_add_unique_to_request_number_in_requests_table', 12),
(27, '2026_07_02_145137_create_courses_table', 13),
(28, '2026_07_02_145224_create_course_assignments_table', 13),
(29, '2026_07_02_145316_create_appeals_table', 13),
(30, '2026_07_02_145326_create_appeal_items_table', 13),
(31, '2026_07_02_223213_remove_department_id_from_courses_table', 14),
(32, '2026_07_02_224201_create_course_departments_table', 14),
(33, '2026_07_02_225430_modify_course_assignments_table', 15),
(34, '2026_07_05_113054_update_request_status_enum', 16),
(35, '2026_07_07_011942_add_request_fields_to_notifications_table', 17),
(36, '2026_07_07_204805_add_review_started_at_to_requests_table', 17),
(37, '2026_07_08_185248_add_student_reply_to_requests_table', 18);

-- --------------------------------------------------------

--
-- بنية الجدول `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('submitted','received','approved','rejected','review','warning','success','info') NOT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `request_id`, `title`, `message`, `type`, `action_url`, `is_read`, `created_at`, `updated_at`) VALUES
(135, 17, NULL, 'تم إرسال الطلب', 'تم إرسال طلبك بنجاح وهو الآن بانتظار المراجعة من قبل الموظف المختص.', 'submitted', 'http://127.0.0.1:8000/my-requests/89', 1, '2026-07-12 17:24:15', '2026-07-12 18:04:29'),
(137, 17, 90, 'تم إرسال الطلب', 'تم إرسال طلبك بنجاح وهو الآن بانتظار المراجعة من قبل الموظف المختص.', 'submitted', 'http://127.0.0.1:8000/my-requests/90', 1, '2026-07-12 18:05:29', '2026-07-12 18:10:11'),
(138, 18, 90, 'طلب جديد', 'قام الطالب نسيبة عبده عبدالله جماله بإرسال طلب وقف قيد جديد.', 'info', 'http://127.0.0.1:8000/employee/request/90', 1, '2026-07-12 18:05:29', '2026-07-12 18:13:09'),
(139, 17, 90, 'طلبك قيد المراجعة', 'تم استلام الطلب وبدأت مراجعته من قبل موظف شؤون الطلاب.', 'review', 'http://127.0.0.1:8000/my-requests/90', 1, '2026-07-12 18:09:03', '2026-07-12 18:10:11'),
(140, 17, 90, 'تمت إعادة الطلب', 'يرجى استكمال الطلب. السبب: البطاقه الشخصيه', 'warning', 'http://127.0.0.1:8000/employee/request/90', 1, '2026-07-12 18:09:54', '2026-07-12 18:10:11'),
(141, 18, 90, 'تم استكمال الطلب', 'قام الطالب باستكمال الطلب رقم REQ-2026-000001', 'review', 'http://127.0.0.1:8000/employee/request/90', 1, '2026-07-12 18:11:03', '2026-07-12 18:13:09'),
(142, 17, 90, 'تم إرسال الاستكمال', 'تم إرسال استكمال الطلب رقم REQ-2026-000001 إلى شؤون الطلاب.', 'success', 'http://127.0.0.1:8000/my-requests/90', 1, '2026-07-12 18:11:04', '2026-07-12 18:12:27'),
(143, 18, 90, 'تم استكمال الطلب', 'قام الطالب باستكمال الطلب رقم REQ-2026-000001', 'review', 'http://127.0.0.1:8000/employee/request/90', 1, '2026-07-12 18:11:05', '2026-07-12 18:13:09'),
(144, 17, 90, 'تم إرسال الاستكمال', 'تم إرسال استكمال الطلب رقم REQ-2026-000001 إلى شؤون الطلاب.', 'success', 'http://127.0.0.1:8000/my-requests/90', 1, '2026-07-12 18:11:05', '2026-07-12 18:12:27'),
(145, 17, 90, 'تحديث حالة الطلب', 'تمت مراجعة طلبك من شؤون الطلاب وتحويله إلى رئيس القسم.', 'review', 'http://127.0.0.1:8000/my-requests/90', 1, '2026-07-12 18:14:59', '2026-07-12 18:24:42'),
(146, 19, 90, 'طلب جديد', 'تم تحويل طلب جديد إليك للمراجعة.', 'info', 'http://127.0.0.1:8000/employee/request/90', 0, '2026-07-12 18:15:00', '2026-07-12 18:15:00'),
(147, 17, 90, 'تحديث حالة الطلب', 'تم اعتماد طلبك من رئيس القسم وتحويله إلى عميد الكلية.', 'review', 'http://127.0.0.1:8000/my-requests/90', 1, '2026-07-12 18:15:51', '2026-07-12 18:24:42'),
(148, 20, 90, 'طلب جديد', 'تم تحويل طلب جديد إليك للمراجعة.', 'info', 'http://127.0.0.1:8000/employee/request/90', 0, '2026-07-12 18:15:51', '2026-07-12 18:15:51'),
(149, 17, 90, 'تحديث حالة الطلب', 'تم اعتماد طلبك من عميد الكلية وتحويله إلى قسم الأرشيف.', 'review', 'http://127.0.0.1:8000/my-requests/90', 1, '2026-07-12 18:17:01', '2026-07-12 18:24:42'),
(150, 21, 90, 'طلب جديد', 'تم تحويل طلب جديد إليك للمراجعة.', 'info', 'http://127.0.0.1:8000/employee/request/90', 0, '2026-07-12 18:17:01', '2026-07-12 18:17:01'),
(151, 17, 90, 'تم اعتماد الطلب', 'تم اعتماد طلبك نهائياً وأرشفته.', 'success', 'http://127.0.0.1:8000/my-requests/90', 1, '2026-07-12 18:18:35', '2026-07-12 18:24:42'),
(166, 22, 98, 'تم إرسال الطلب', 'تم إرسال طلبك بنجاح وهو الآن بانتظار المراجعة من قبل الموظف المختص.', 'submitted', 'http://127.0.0.1:8000/my-requests/98', 1, '2026-07-12 23:56:38', '2026-07-12 23:58:06'),
(167, 18, 98, 'طلب جديد', 'قام الطالب افنان عبده عبدالله جماله بإرسال طلب وقف قيد جديد.', 'info', 'http://127.0.0.1:8000/employee/request/98', 1, '2026-07-12 23:56:38', '2026-07-13 03:49:16'),
(168, 22, 98, 'طلبك قيد المراجعة', 'تم استلام الطلب وبدأت مراجعته من قبل موظف شؤون الطلاب.', 'review', 'http://127.0.0.1:8000/my-requests/98', 1, '2026-07-12 23:57:04', '2026-07-12 23:58:06'),
(169, 22, 98, 'تمت إعادة الطلب', 'يرجى استكمال الطلب. السبب: يرجى ارفاق صورة البطاقه الشخصية', 'warning', 'http://127.0.0.1:8000/employee/request/98', 1, '2026-07-12 23:57:32', '2026-07-12 23:58:06'),
(172, 23, NULL, 'تم إرسال طلب التظلم', 'تم إرسال طلب التظلم بنجاح وهو الآن بانتظار المراجعة من قبل الموظف المختص.', 'submitted', NULL, 1, '2026-07-13 00:22:25', '2026-07-13 00:23:02'),
(173, 23, 100, 'طلبك قيد المراجعة', 'تم استلام الطلب وبدأت مراجعته من قبل موظف شؤون الطلاب.', 'review', 'http://127.0.0.1:8000/my-requests/100', 1, '2026-07-13 01:59:34', '2026-07-13 02:00:10'),
(174, 23, 101, 'تم إرسال الطلب', 'تم إرسال طلبك بنجاح وهو الآن بانتظار المراجعة من قبل الموظف المختص.', 'submitted', 'http://127.0.0.1:8000/my-requests/101', 0, '2026-07-13 02:01:10', '2026-07-13 02:01:10'),
(175, 18, 101, 'طلب جديد', 'قام الطالب اياد حاتم عبداللطيف المغبشي بإرسال طلب وقف قيد جديد.', 'info', 'http://127.0.0.1:8000/employee/request/101', 1, '2026-07-13 02:01:10', '2026-07-13 03:49:16'),
(176, 23, 101, 'طلبك قيد المراجعة', 'تم استلام الطلب وبدأت مراجعته من قبل موظف شؤون الطلاب.', 'review', 'http://127.0.0.1:8000/my-requests/101', 0, '2026-07-13 02:01:24', '2026-07-13 02:01:24'),
(177, 23, 101, 'تمت إعادة الطلب', 'يرجى استكمال الطلب. السبب: ارفق البطاقه الشخصية', 'warning', 'http://127.0.0.1:8000/employee/request/101', 0, '2026-07-13 02:01:41', '2026-07-13 02:01:41'),
(178, 23, 101, 'تمت إعادة الطلب', 'يرجى استكمال الطلب. السبب: ارفق البطاقه الشخصية', 'warning', 'http://127.0.0.1:8000/employee/request/101', 0, '2026-07-13 02:05:13', '2026-07-13 02:05:13'),
(179, 18, 101, 'تم استكمال الطلب', 'قام الطالب باستكمال الطلب رقم REQ-2026-000004', 'review', 'http://127.0.0.1:8000/employee/request/101', 1, '2026-07-13 02:06:10', '2026-07-13 03:49:16'),
(180, 23, 101, 'تم إرسال الاستكمال', 'تم إرسال استكمال الطلب رقم REQ-2026-000004 إلى شؤون الطلاب.', 'success', 'http://127.0.0.1:8000/my-requests/101', 0, '2026-07-13 02:06:10', '2026-07-13 02:06:10'),
(181, 24, 102, 'تم إرسال الطلب', 'تم إرسال طلبك بنجاح وهو الآن بانتظار المراجعة من قبل الموظف المختص.', 'submitted', 'http://127.0.0.1:8000/my-requests/102', 1, '2026-07-13 03:48:09', '2026-07-13 03:51:35'),
(182, 18, 102, 'طلب جديد', 'قام الطالب تسنيم عبده عبدالله جماله بإرسال طلب وقف قيد جديد.', 'info', 'http://127.0.0.1:8000/employee/request/102', 1, '2026-07-13 03:48:10', '2026-07-13 03:49:16'),
(183, 24, 102, 'طلبك قيد المراجعة', 'تم استلام الطلب وبدأت مراجعته من قبل موظف شؤون الطلاب.', 'review', 'http://127.0.0.1:8000/my-requests/102', 1, '2026-07-13 03:49:29', '2026-07-13 03:51:35'),
(184, 24, 102, 'تمت إعادة الطلب', 'يرجى استكمال الطلب. السبب: يجب ارفاق البطاقة الجامعية', 'warning', 'http://127.0.0.1:8000/employee/request/102', 1, '2026-07-13 03:50:58', '2026-07-13 03:51:35'),
(185, 18, 102, 'تم استكمال الطلب', 'قام الطالب باستكمال الطلب رقم REQ-2026-000005', 'review', 'http://127.0.0.1:8000/employee/request/102', 0, '2026-07-13 03:52:06', '2026-07-13 03:52:06'),
(186, 24, 102, 'تم إرسال الاستكمال', 'تم إرسال استكمال الطلب رقم REQ-2026-000005 إلى شؤون الطلاب.', 'success', 'http://127.0.0.1:8000/my-requests/102', 0, '2026-07-13 03:52:06', '2026-07-13 03:52:06'),
(187, 24, 102, 'تحديث حالة الطلب', 'تمت مراجعة طلبك من شؤون الطلاب وتحويله إلى رئيس القسم.', 'review', 'http://127.0.0.1:8000/my-requests/102', 0, '2026-07-13 03:53:09', '2026-07-13 03:53:09'),
(188, 19, 102, 'طلب جديد', 'تم تحويل طلب جديد إليك للمراجعة.', 'info', 'http://127.0.0.1:8000/employee/request/102', 0, '2026-07-13 03:53:09', '2026-07-13 03:53:09');

-- --------------------------------------------------------

--
-- بنية الجدول `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `reopen_enrollments`
--

CREATE TABLE `reopen_enrollments` (
  `reopen_id` bigint(20) UNSIGNED NOT NULL,
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `request_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `requests`
--

CREATE TABLE `requests` (
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `request_number` varchar(255) NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `current_employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('submitted','student_affairs_review','department_head_review','dean_review','archive_review','approved','returned_to_student','returned_to_student_affairs','returned_to_department_head','rejected') NOT NULL DEFAULT 'submitted',
  `approved_at` timestamp NULL DEFAULT NULL,
  `review_started_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `student_reply` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `requests`
--

INSERT INTO `requests` (`request_id`, `request_number`, `student_id`, `service_id`, `current_employee_id`, `status`, `approved_at`, `review_started_at`, `notes`, `student_reply`, `created_at`, `updated_at`) VALUES
(90, 'REQ-2026-000001', 10, 1, NULL, 'approved', '2026-07-12 18:18:35', NULL, 'البطاقه الشخصيه', NULL, '2026-07-12 18:05:29', '2026-07-12 18:18:35'),
(98, 'REQ-2026-000002', 11, 1, 10, 'returned_to_student', NULL, NULL, 'يرجى ارفاق صورة البطاقه الشخصية', NULL, '2026-07-12 23:56:38', '2026-07-12 23:57:32'),
(100, 'REQ-2026-000003', 12, 3, 10, 'student_affairs_review', NULL, NULL, NULL, NULL, '2026-07-13 00:22:25', '2026-07-13 01:59:34'),
(101, 'REQ-2026-000004', 12, 1, 10, 'student_affairs_review', NULL, NULL, 'ارفق البطاقه الشخصية', NULL, '2026-07-13 02:01:09', '2026-07-13 02:06:09'),
(102, 'REQ-2026-000005', 14, 1, 11, 'student_affairs_review', NULL, NULL, 'يجب ارفاق البطاقة الجامعية', 'سيتم ارفاقها', '2026-07-13 03:48:09', '2026-07-13 03:53:08');

-- --------------------------------------------------------

--
-- بنية الجدول `request_approvals`
--

CREATE TABLE `request_approvals` (
  `approval_id` bigint(20) UNSIGNED NOT NULL,
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `stage` enum('student_affairs','department_head','dean','archive') NOT NULL,
  `approval_text` text NOT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `approval_status` enum('saved','forwarded','approved','rejected','archived') NOT NULL DEFAULT 'saved',
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `request_approvals`
--

INSERT INTO `request_approvals` (`approval_id`, `request_id`, `employee_id`, `stage`, `approval_text`, `is_locked`, `approval_status`, `approved_at`, `created_at`, `updated_at`) VALUES
(9, 90, 10, 'student_affairs', 'تمت مراجعه جميع المرفقات والبيانات', 1, 'saved', '2026-07-12 18:14:51', '2026-07-12 18:14:51', '2026-07-12 18:14:51'),
(10, 90, 11, 'department_head', 'تمت الموافقه', 1, 'saved', '2026-07-12 18:15:40', '2026-07-12 18:15:40', '2026-07-12 18:15:40'),
(11, 90, 12, 'dean', 'تمت الموافقه', 1, 'saved', '2026-07-12 18:16:51', '2026-07-12 18:16:51', '2026-07-12 18:16:51'),
(12, 90, 13, 'archive', 'تمت الارشفه', 1, 'saved', '2026-07-12 18:18:27', '2026-07-12 18:18:27', '2026-07-12 18:18:27'),
(13, 102, 10, 'student_affairs', 'جميع البيانات صحيحة', 1, 'saved', '2026-07-13 03:52:58', '2026-07-13 03:52:58', '2026-07-13 03:52:58');

-- --------------------------------------------------------

--
-- بنية الجدول `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Employee', NULL, NULL),
(3, 'Student', NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `services`
--

CREATE TABLE `services` (
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'وقف القيد', 'إيقاف الدراسة مؤقتاً', 'active', NULL, '2026-07-03 16:58:58'),
(2, 'إعادة القيد', 'إستئناف الدراسة بعد فترة الايقاف', 'active', NULL, '2026-07-13 00:26:03'),
(3, 'التظلم', 'خدمة إلكترونية تتيح للطالب تقديم طلب تظلم من نتيجة الاختبارات لمقرر أو أكثر', 'active', NULL, '2026-07-05 15:02:24'),
(9, 'الانسحاب من الدراسة', 'طلب الانسحاب النهائي أو المؤقت من الجامعة وفق اللوائح', 'inactive', '2026-07-03 16:55:00', '2026-07-03 16:55:14'),
(10, 'التحويل بين الكليات', 'طلب التحويل من كلية إلى أخرى وفق الشروط', 'inactive', '2026-07-03 16:55:54', '2026-07-03 16:59:04'),
(11, 'بيان حالة', 'استخراج بيان بالحالة الأكاديمية للطالب', 'inactive', '2026-07-03 16:58:54', '2026-07-03 16:59:09'),
(12, 'تغيير التخصص', 'طلب تغيير التخصص الأكاديمي وفق الضوابط.', 'inactive', '2026-07-03 16:59:51', '2026-07-03 17:07:58');

-- --------------------------------------------------------

--
-- بنية الجدول `stop_enrollments`
--

CREATE TABLE `stop_enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `semester` enum('first','second') NOT NULL,
  `stop_period` enum('semester','academic_year') NOT NULL,
  `reason` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `previous_stop_count` int(11) NOT NULL DEFAULT 0,
  `request_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `stop_enrollments`
--

INSERT INTO `stop_enrollments` (`id`, `request_id`, `academic_year`, `semester`, `stop_period`, `reason`, `created_at`, `updated_at`, `previous_stop_count`, `request_date`) VALUES
(70, 90, '2026/2027', 'first', 'semester', 'اسباب شخصيه', '2026-07-12 18:05:29', '2026-07-12 18:05:29', 0, '2026-07-01'),
(71, 98, '2026/2027', 'second', 'semester', 'اسباب مرضيه', '2026-07-12 23:56:38', '2026-07-12 23:56:38', 0, '2026-07-15'),
(72, 101, '2026/2027', 'second', 'semester', 'اسباب شخصية', '2026-07-13 02:01:09', '2026-07-13 02:01:09', 0, '2026-07-01'),
(73, 102, '2026/2027', 'second', 'semester', 'اسباب شخصية', '2026-07-13 03:48:09', '2026-07-13 03:48:09', 0, '2028-06-01');

-- --------------------------------------------------------

--
-- بنية الجدول `students`
--

CREATE TABLE `students` (
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `student_number` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `level` varchar(255) NOT NULL,
  `academic_status` enum('active','stopped','graduated','dismissed','withdrawn') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `students`
--

INSERT INTO `students` (`student_id`, `student_number`, `full_name`, `college_id`, `department_id`, `level`, `academic_status`, `created_at`, `updated_at`) VALUES
(9, '20260001', 'رباب إبراهيم عبدالحفيظ المغبشي', 2, 3, 'المستوى الرابع', 'active', '2026-07-12 16:39:51', '2026-07-12 16:39:51'),
(10, '20260002', 'نسيبة عبده عبدالله جماله', 2, 3, 'المستوى الرابع', 'stopped', '2026-07-12 16:41:07', '2026-07-12 18:25:41'),
(11, '20260003', 'افنان عبده عبدالله جماله', 2, 3, 'المستوى الثاني', 'active', '2026-07-12 16:56:07', '2026-07-13 00:10:24'),
(12, '20260004', 'اياد حاتم عبداللطيف المغبشي', 2, 3, 'المستوى الثالث', 'active', '2026-07-12 16:56:57', '2026-07-12 16:57:10'),
(13, '20260005', 'ربا ابراهيم عبدالحفيظ المغبشي', 2, 3, 'المستوى الأول', 'active', '2026-07-12 16:58:13', '2026-07-12 16:58:13'),
(14, '20260006', 'تسنيم عبده عبدالله جماله', 2, 3, 'المستوى الثاني', 'active', '2026-07-12 16:58:59', '2026-07-12 16:58:59'),
(15, '20260007', 'صهيب عبده عبدالله جماله', 2, 3, 'المستوى الثالث', 'stopped', '2026-07-12 16:59:58', '2026-07-12 17:05:42'),
(16, '20260008', 'محمد إبراهيم عبدالحفيظ المغبشي', 2, 3, 'المستوى الثالث', 'active', '2026-07-12 17:00:59', '2026-07-12 17:00:59'),
(17, '20260009', 'يعقوب عبده عبدالله جماله', 2, 5, 'المستوى الثاني', 'active', '2026-07-12 17:02:24', '2026-07-12 17:05:26');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `student_id`, `employee_id`, `email`, `phone`, `email_verified_at`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(6, 'admin', NULL, NULL, 'admin@admin.com', NULL, NULL, '$2y$12$bXz5Oh1FG/sW8o04A6kjbubaJSJdsPjmhFoAFizB1uHsvhPQmPsui', 1, NULL, '2026-06-29 17:11:36', '2026-06-29 17:11:36'),
(16, 'رباب', 9, NULL, 'rabab123@gmail.com', '781449729', NULL, '$2y$12$f3xCvNgIR4cLJIXITQXUguL72/H20EmJ/QbGchBo4Y6sN0M3yNJDu', 3, NULL, '2026-07-12 17:14:58', '2026-07-12 17:14:58'),
(17, 'نسيبه', 10, NULL, 'nosiba123@gmail.com', '781234568', NULL, '$2y$12$2.jX/7Y/jVVY8kmHGsP5O.ls30nsDCGXu8OBPvIQkNm.DCyinqT9q', 3, NULL, '2026-07-12 17:16:36', '2026-07-12 17:16:36'),
(18, 'علي احمد', NULL, 10, 'ali123@gmail.com', NULL, NULL, '$2y$12$qPFKkeTi5uJKYpHzlSEFRerVkU.j/JxeVmifyM/O95o1tcj71jUJm', 2, NULL, '2026-07-12 17:45:32', '2026-07-12 17:45:32'),
(19, 'اسامه سيف', NULL, 11, 'osamh123@gmail.com', NULL, NULL, '$2y$12$e/bxMBcUlisHdVk5UiCwOO5fQBMp/s82WEZ4ppE3OkAIS3bY6OSaW', 2, NULL, '2026-07-12 17:48:37', '2026-07-12 17:48:37'),
(20, 'عبدالعزيز', NULL, 12, 'abd123@gmail.com', NULL, NULL, '$2y$12$QnKK9TCYnETu6KWvOE2Z3OY48GsWT4i4cBm57g/wFUPI.CB/.vmBK', 2, NULL, '2026-07-12 17:50:39', '2026-07-12 17:50:39'),
(21, 'مكرد', NULL, 13, 'mohmed123@gmail.com', NULL, NULL, '$2y$12$6Eiy2x/Na9uCj3AuikWNyuEoAU296bnV8k9xSHF2UqDUZ/C3JIFq2', 2, NULL, '2026-07-12 17:54:25', '2026-07-12 17:54:25'),
(22, 'افنان عبده عبدالله جماله', 11, NULL, 'afnan123@gmail.com', '778945612', NULL, '$2y$12$DcxYO3zfUHMuy9a7VSvdFO/G/Tf5ATN5aVjLIF7IfmI6ht6i5fvF6', 3, NULL, '2026-07-12 23:55:26', '2026-07-13 00:10:24'),
(23, 'اياد', 12, NULL, 'eyad1234@gmail.com', '778945612', NULL, '$2y$12$Ux8vXdTqGEEkdl3sUd62guPqMZc2tmwgjarbYq/FHn35.hRhjRb7m', 3, NULL, '2026-07-13 00:14:54', '2026-07-13 00:14:54'),
(24, 'تسنيم', 14, NULL, 'tsnem123@gmail.com', '781449729', NULL, '$2y$12$6KGuVCyYATpQLxO8bb.3Q.NCxel/TfHxQqoRgApUMP8yx8Xvtt/MK', 3, NULL, '2026-07-13 03:42:04', '2026-07-13 03:42:04'),
(25, 'ربا', 13, NULL, 'roba123@gmail.com', '7781449729', NULL, '$2y$12$lYieo6LVdrlw7FS7yIBOh.I37.ejhIpT2wgYpuqYPdaNC6qaqJrKO', 3, NULL, '2026-07-13 03:45:39', '2026-07-13 03:45:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appeals`
--
ALTER TABLE `appeals`
  ADD PRIMARY KEY (`appeal_id`),
  ADD UNIQUE KEY `appeals_request_id_unique` (`request_id`);

--
-- Indexes for table `appeal_items`
--
ALTER TABLE `appeal_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `appeal_items_appeal_id_foreign` (`appeal_id`),
  ADD KEY `appeal_items_course_id_foreign` (`course_id`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `attachments_request_id_foreign` (`request_id`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_assignments`
--
ALTER TABLE `course_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD UNIQUE KEY `course_assignment_unique` (`course_id`,`department_id`,`employee_id`,`academic_year`,`semester`),
  ADD KEY `course_assignments_employee_id_foreign` (`employee_id`),
  ADD KEY `course_assignments_department_id_foreign` (`department_id`);

--
-- Indexes for table `course_departments`
--
ALTER TABLE `course_departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_departments_course_id_department_id_unique` (`course_id`,`department_id`),
  ADD KEY `course_departments_department_id_foreign` (`department_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_college_id_foreign` (`college_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `employees_employee_number_unique` (`employee_number`),
  ADD KEY `employees_college_id_foreign` (`college_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_request_id_foreign` (`request_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_permission_name_unique` (`permission_name`);

--
-- Indexes for table `reopen_enrollments`
--
ALTER TABLE `reopen_enrollments`
  ADD PRIMARY KEY (`reopen_id`),
  ADD KEY `reopen_enrollments_request_id_foreign` (`request_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`),
  ADD UNIQUE KEY `requests_request_number_unique` (`request_number`),
  ADD KEY `requests_student_id_foreign` (`student_id`),
  ADD KEY `requests_service_id_foreign` (`service_id`),
  ADD KEY `requests_current_employee_id_foreign` (`current_employee_id`);

--
-- Indexes for table `request_approvals`
--
ALTER TABLE `request_approvals`
  ADD PRIMARY KEY (`approval_id`),
  ADD KEY `request_approvals_request_id_foreign` (`request_id`),
  ADD KEY `request_approvals_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_role_name_unique` (`role_name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `stop_enrollments`
--
ALTER TABLE `stop_enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stop_enrollments_request_id_unique` (`request_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `students_student_number_unique` (`student_number`),
  ADD KEY `students_college_id_foreign` (`college_id`),
  ADD KEY `students_department_id_foreign` (`department_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `users_student_id_foreign` (`student_id`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_employee_id_foreign` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appeals`
--
ALTER TABLE `appeals`
  MODIFY `appeal_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `appeal_items`
--
ALTER TABLE `appeal_items`
  MODIFY `item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `attachment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `course_assignments`
--
ALTER TABLE `course_assignments`
  MODIFY `assignment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `course_departments`
--
ALTER TABLE `course_departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reopen_enrollments`
--
ALTER TABLE `reopen_enrollments`
  MODIFY `reopen_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `request_approvals`
--
ALTER TABLE `request_approvals`
  MODIFY `approval_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `stop_enrollments`
--
ALTER TABLE `stop_enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `appeals`
--
ALTER TABLE `appeals`
  ADD CONSTRAINT `appeals_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`request_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `appeal_items`
--
ALTER TABLE `appeal_items`
  ADD CONSTRAINT `appeal_items_appeal_id_foreign` FOREIGN KEY (`appeal_id`) REFERENCES `appeals` (`appeal_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appeal_items_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON UPDATE CASCADE;

--
-- قيود الجداول `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`request_id`) ON DELETE CASCADE;

--
-- قيود الجداول `course_assignments`
--
ALTER TABLE `course_assignments`
  ADD CONSTRAINT `course_assignments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_assignments_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `course_assignments_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON UPDATE CASCADE;

--
-- قيود الجداول `course_departments`
--
ALTER TABLE `course_departments`
  ADD CONSTRAINT `course_departments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_departments_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`request_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `reopen_enrollments`
--
ALTER TABLE `reopen_enrollments`
  ADD CONSTRAINT `reopen_enrollments_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`request_id`) ON DELETE CASCADE;

--
-- قيود الجداول `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `requests_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;

--
-- قيود الجداول `request_approvals`
--
ALTER TABLE `request_approvals`
  ADD CONSTRAINT `request_approvals_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_approvals_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`request_id`) ON DELETE CASCADE;

--
-- قيود الجداول `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `stop_enrollments`
--
ALTER TABLE `stop_enrollments`
  ADD CONSTRAINT `stop_enrollments_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`request_id`) ON DELETE CASCADE;

--
-- قيود الجداول `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
