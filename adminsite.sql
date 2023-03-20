-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2023 at 12:04 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adminsite`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ImageSync` ()   BEGIN 
UPDATE product_images cp INNER join products p On p.product_id_sf = cp.sf_id SET cp.product_id = p.id WHERE cp.product_id IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `syncProductToCategory` ()   BEGIN 
UPDATE category_products cp INNER join products p On p.product_id_sf = cp.sf_id SET cp.product_id = p.id WHERE cp.product_id IS NULL;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `state_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 'Jaipur', 1, '2023-03-16 05:04:53', '2023-03-16 05:04:53'),
(2, 2, 2, 'Dholpur', 1, '2023-03-16 05:11:01', '2023-03-16 05:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'India', 1, '2023-03-16 03:44:00', '2023-03-16 03:44:00');

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
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2022_03_02_094528_create_roles_table', 2),
(5, '2022_03_02_100426_create_modules_table', 3),
(6, '2022_03_02_100945_create_categories_table', 4),
(7, '2022_03_02_101723_create_companies_table', 5),
(8, '2022_03_02_102456_create_certificates_table', 6),
(9, '2022_03_02_103928_create_custom_fields_table', 7),
(10, '2022_03_02_104532_create_products_table', 8),
(11, '2022_03_02_110439_create_product_images_table', 8),
(12, '2022_03_02_125154_create_category_product_table', 9),
(13, '2014_10_12_000000_create_users_table', 10),
(14, '2022_03_02_132554_create_user_custom_fields_table', 11),
(15, '2022_03_02_133410_create_complaints_table', 12),
(16, '2022_03_02_134138_create_complaint_images_table', 13),
(17, '2022_03_02_134606_create_contracts_table', 14),
(18, '2022_03_02_140203_create_locations_table', 15),
(19, '2022_03_03_045927_create_orders_table', 16),
(20, '2022_03_03_050801_create_order_product_table', 17),
(21, '2022_03_03_051908_create_permissions_table', 18),
(22, '2022_03_03_052915_create_product_assignments_table', 19),
(23, '2022_03_04_071642_make_date_of_birth_nullable_on_users_table', 20),
(24, '2022_03_04_072227_make_position_nullable_on_users_table', 21),
(25, '2022_03_04_072542_make_company_id_nullable_on_users_table', 22),
(26, '2022_03_04_072816_make_role_id_nullable_on_users_table', 23),
(27, '2022_03_07_092641_make_certificate_type_enum_on_certificates_table', 24),
(28, '2022_03_07_094607_make_permuted_module_id_text_on_permissions_table', 25),
(29, '2022_03_07_100325_make_drop_is_allowed_on_permissions_table', 26),
(30, '2022_03_07_100529_create_settings_table', 27),
(31, '2022_03_08_103403_make_parent_id_char_on_categories_table', 28),
(32, '2022_03_08_110532_make_parent_id_change_char_on_categories_table', 29),
(33, '2022_03_08_112936_create_areas_table', 30),
(34, '2022_03_08_113102_create_user_area_relation_table', 30),
(35, '2022_03_11_055839_make_drop_manage_newsletter_subscribers_on_roles_table', 31),
(36, '2022_03_11_060201_add_is_newsletter_to_users_table', 32),
(37, '2016_06_01_000001_create_oauth_auth_codes_table', 33),
(46, '2016_01_26_115212_create_permissions_table', 35),
(47, '2016_01_26_115523_create_permission_role_table', 35),
(48, '2016_02_09_132439_create_permission_user_table', 36),
(49, '2016_01_15_105324_create_roles_table', 37),
(50, '2016_01_15_114412_create_role_user_table', 37);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
('10583d7d-4b1c-4fdf-9267-d99b566a6cd5', 'test module 1', 1, '2022-03-10 01:50:31', '2022-03-10 01:50:31'),
('81a92e7e-ce2d-4d72-b45f-1858e6862261', 'test module 3', 0, '2022-03-11 01:41:08', '2022-03-11 01:41:51'),
('df319ac2-aec2-4808-81f6-f77b1f2de690', 'test module 2', 0, '2022-03-10 01:50:49', '2022-03-10 01:50:57');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('1116259bc9d5be9e1ae8b5ae734980089fd54bc90dba30384f851571936517b1b44f6321d458ff98', '447047c8-7cc9-44b8-947a-7e21dc58ff98', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-24 06:24:47', '2022-03-24 06:24:47', '2023-03-24 11:54:47'),
('12f1929519cf3789d8fdbfc31a9d13c6b8ea521040b286f1115317c5e9ac9fb17541282324bf0958', '7b014fab-89a0-4123-bc5a-25343a8ba3d8', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-21 03:37:34', '2022-03-21 03:37:34', '2023-03-21 09:07:34'),
('1a7aea7e1c513a2c83e4d7c776132a636419514fbdbc930919d18b70725b19a29c89a164a664886c', 'e052ce0a-fe99-4417-a9fd-adb99afb81c3', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-16 05:27:31', '2022-03-16 05:27:31', '2023-03-16 10:57:31'),
('25155f8f41347b6470434aa0cc142129271863a1f63d7a8b4be51bf9aa46e64cd54dc770cd7fef98', '88f9cb84-6bac-48aa-b825-05d381dc901b', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-24 06:15:02', '2022-03-24 06:15:02', '2023-03-24 11:45:02'),
('2607ad594e27a41ae59d83625311430615bbe0717dd10f9b5c769b117527213be864e7cb7b72cf95', 'e52c7718-3a73-4198-8222-a26f8704401f', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-22 01:36:53', '2022-03-22 01:36:53', '2023-03-22 07:06:53'),
('2829292cfe827af82d4927928af547dc44a189b5869b427092ca3ec344661e92798a722c883010d5', 'ee12dd63-3494-43b2-885f-173120d08f69', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-05-20 01:41:25', '2022-05-20 01:41:25', '2023-05-20 07:11:25'),
('3a7972022a2cd87e2e5f19b9d88c0d5a3fd9a5fc258869d496b6b70efcc2edc95143f8fa44dfb738', '781d2915-df00-48e0-a852-44834f97d933', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-15 08:10:54', '2022-03-15 08:10:54', '2023-03-15 13:40:54'),
('436f6f515fe71ade23ab48d1436d9826004c06f9c899205effa1addd596baeb36dcc4e3b8e19a81e', '7b014fab-89a0-4123-bc5a-25343a8ba3d8', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-24 05:33:12', '2022-03-24 05:33:12', '2023-03-24 11:03:12'),
('49eb282ccfc76ca1fb271c27a819d976ad6fdf0833fc948baa8f835e3b7bd7bfe6f300e612589758', 'ee12dd63-3494-43b2-885f-173120d08f69', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-22 05:52:10', '2022-03-22 05:52:10', '2023-03-22 11:22:10'),
('4ff3d4b511597779976e7f1167ee9c1069b08728161ba54d393c560376bf2b2571a8d4e0e8617f75', 'e52c7718-3a73-4198-8222-a26f8704401f', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-22 01:38:11', '2022-03-22 01:38:11', '2023-03-22 07:08:11'),
('554c4bf600b1458c784afcad14bfc893361e95e550bc4935f05b1a8f642ee1d536dbecaac425bc12', 'ee12dd63-3494-43b2-885f-173120d08f69', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-06-08 01:07:54', '2022-06-08 01:07:54', '2023-06-08 06:37:54'),
('65d7ed499e2d6e4d6ce0960aa6277579a93a72a37fd08dfb0b4ff4550b28b28772c7bdc00202dddc', 'e52c7718-3a73-4198-8222-a26f8704401f', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-21 01:42:07', '2022-03-21 01:42:07', '2023-03-21 07:12:07'),
('65da402cfb133544d59f8ffded56e42d3858b6a712f984d30d89a8dd6dfe0e47510afda502f6a9f0', 'e7f60ee4-b079-4eda-8bc0-5559d2b25355', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-04-25 04:22:58', '2022-04-25 04:22:58', '2023-04-25 09:52:58'),
('691243c9b65815dc6b1cb08f91a859ebfd453d19024c98f2826f153a393ffbb4a8aeb74764e505ad', '781d2915-df00-48e0-a852-44834f97d933', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-15 08:22:24', '2022-03-15 08:22:24', '2023-03-15 13:52:24'),
('6ebf5dacfd6aa1a89de73be7ad7cdd8282a5fdff311a5faf20f133b1fd7b1b11d7af0b03a7d3779a', '478a58f8-cddb-4342-abf8-659c1f4e1cd6', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-04-25 04:21:58', '2022-04-25 04:21:58', '2023-04-25 09:51:58'),
('741f9794ec0414befdf0d90ca78ac4b66b02a1890804fb2cf1fc1a34aa45d01e6ac75251fd889b7a', 'bbc7d09f-2442-413d-a2d7-668259102304', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-16 06:28:23', '2022-03-16 06:28:23', '2023-03-16 11:58:23'),
('78a595d0c7e39ae8eff53057043c55d7c8c6b9e2aebc3efae24ad555a31c5e266e28949d7e5615df', '7b014fab-89a0-4123-bc5a-25343a8ba3d8', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-24 05:40:30', '2022-03-24 05:40:30', '2023-03-24 11:10:30'),
('86e62dddba68e98e02764eba60a3af94ce57b6c9459cbb62d557f2ae7ac7343487c6d4e4d631af61', '35b67ad0-1b23-4255-be1f-0fbc2179628a', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-15 08:03:56', '2022-03-15 08:03:56', '2023-03-15 13:33:56'),
('88c0ed23c5d90ee9ca5d329310e897032e031c8c07971bbda8cef486a72a07669a7e5e1b94d86518', '781d2915-df00-48e0-a852-44834f97d933', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-15 08:04:16', '2022-03-15 08:04:16', '2023-03-15 13:34:16'),
('88ef6d2855010960d54b55158d2b42af98f61c4b159b312a5675adc5a41546ae1f6c7dc165694af4', '781d2915-df00-48e0-a852-44834f97d933', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-15 08:19:41', '2022-03-15 08:19:41', '2023-03-15 13:49:41'),
('8f359e93a0604994d58197ef96b7d01b8f2cc60d2e83aa35a127dbd878fa02c807cbfe2638133dcf', '2d8130f4-4078-438a-9ee4-b5a7a5371652', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-15 07:53:10', '2022-03-15 07:53:10', '2023-03-15 13:23:10'),
('9dbac67a83492fe4e0cf16dbad27ea7817a1efec4f44ca8960de0eefbe6673cbf52b2e3caea4251f', 'e74f23c8-0c4b-4027-9c63-8b5f9d23ec2c', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-21 03:35:39', '2022-03-21 03:35:39', '2023-03-21 09:05:39'),
('a177f96ed821a95aec3f561122db0856983a701c387ce0de887b3e3de248fc78be9d8be8537898bc', '0522a414-b973-4216-acb0-8b046cd1d02d', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-04-25 04:28:32', '2022-04-25 04:28:32', '2023-04-25 09:58:32'),
('a38cc40d1c6dac2a4a307448b53b2456367a95fa42fa8a8d8b4fb202a928329aab635280eaf573a8', 'e52c7718-3a73-4198-8222-a26f8704401f', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-17 04:05:16', '2022-03-17 04:05:16', '2023-03-17 09:35:16'),
('ad8a6e3880dc8432236d118d54fb0bfcb0cd98184ced5384c55f1d46b836cfa232ca9037d2294c98', '781d2915-df00-48e0-a852-44834f97d933', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-15 08:21:35', '2022-03-15 08:21:35', '2023-03-15 13:51:35'),
('af597061e7f0a906b26fe5d6aca3ddc4b1181690b0c8de7c6d65988ea7a5b32cf3981aa414f95708', 'e52c7718-3a73-4198-8222-a26f8704401f', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-16 06:14:55', '2022-03-16 06:14:55', '2023-03-16 11:44:55'),
('b034427ecb2d67f3d06e6496c8b8d8026057002e4e7cf6e780d42940c2d990fd9ac38016aea635e3', 'ee12dd63-3494-43b2-885f-173120d08f69', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-22 05:52:45', '2022-03-22 05:52:45', '2023-03-22 11:22:45'),
('b4e3f5a718f2448c5b0b37573f5c555d8faa4b27a643ac313831b49a19a1f20601163ce64acbd8cb', 'e52c7718-3a73-4198-8222-a26f8704401f', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-22 01:38:52', '2022-03-22 01:38:52', '2023-03-22 07:08:52'),
('b998a9faec237c966f739b0f473974dd14dc4a39982468292c41a3e113d0778ac927325e0115c104', '781d2915-df00-48e0-a852-44834f97d933', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-15 08:18:51', '2022-03-15 08:18:51', '2023-03-15 13:48:51'),
('c933a0a9d8ffde956cfbee6105d26089f886539d0cc2c4717f4435a05f3fca2b8df85a80fd935f5b', '781d2915-df00-48e0-a852-44834f97d933', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-15 08:18:43', '2022-03-15 08:18:43', '2023-03-15 13:48:43'),
('d2c89300b2617a4cfc1a28074ce34cc1c455568556f455d9d4f0972f26375eccdf449900e9a8f089', '781d2915-df00-48e0-a852-44834f97d933', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-15 08:21:58', '2022-03-15 08:21:58', '2023-03-15 13:51:58'),
('d6756ba3a945093707ee7319baa9d960c323779f5b7665fd47b265160c1ab106a3ff03ea8234b7cb', '23cfb5df-d874-4dda-bb62-7a0953a8cdb7', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-04-25 04:30:09', '2022-04-25 04:30:09', '2023-04-25 10:00:09'),
('d7f519b5efb67b3912b0b277979468ea87a06710d9957812271cba639791f2bd5297e72a15eb4431', 'e52c7718-3a73-4198-8222-a26f8704401f', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-16 06:18:54', '2022-03-16 06:18:54', '2023-03-16 11:48:54'),
('f2c2c53b57860faff172b59fa8c417a01d57de83314fb5101254002c18ba2343bc06519d270c64ad', '5fd2ad09-c463-423f-8339-2ae1a2a3993b', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-16 04:53:03', '2022-03-16 04:53:03', '2023-03-16 10:23:03'),
('f789d76d866e16038873d3bfa64ea4dd4ba8043f0facf33770f6f2205e26a730776b827a49e84813', 'ee12dd63-3494-43b2-885f-173120d08f69', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-06-14 03:39:25', '2022-06-14 03:39:25', '2023-06-14 09:09:25'),
('f9bf677281d01a1c343af836b9e85f877a420004161570df9b979bbdce4a5fb0a7ddb8b1f05cba71', '781d2915-df00-48e0-a852-44834f97d933', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-03-15 08:20:48', '2022-03-15 08:20:48', '2023-03-15 13:50:48'),
('fd1ae30ae1429db123980c89ac1e0ec18eada2d9372ebb61c6ebebaeeef463a6e3e283118836a026', 'ee12dd63-3494-43b2-885f-173120d08f69', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-04-26 00:34:09', '2022-04-26 00:34:09', '2023-04-26 06:04:09'),
('fe9c0cd8ceb62cc25e8b8281ae33d563d844f49ac5b922a7b47d29aebee78fc1c9c7edf2940f63f7', '5f6e6e57-cf3b-4160-9b89-ce11cb30b1bf', '95d31d53-fa41-44fe-98aa-55315f33f734', 'MyApp', '[]', 0, '2022-04-25 04:24:49', '2022-04-25 04:24:49', '2023-04-25 09:54:49');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
('95d31d53-fa41-44fe-98aa-55315f33f734', NULL, 'MyQuip Personal Access Client', 'hWZzhrJdegZ7P6joSQoEdExOXeuNINHPEoDXFWyb', NULL, 'http://localhost', 1, 0, 0, '2022-03-15 04:50:26', '2022-03-15 04:50:26'),
('95d31d54-3335-4d5f-a405-8a69609c9d35', NULL, 'MyQuip Password Grant Client', 'luvO8bbzHoG7BJC9jrw8AOPxCvU2WMtM2pBIa7oG', 'users', 'http://localhost', 0, 1, 0, '2022-03-15 04:50:26', '2022-03-15 04:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, '95d31d53-fa41-44fe-98aa-55315f33f734', '2022-03-15 04:50:26', '2022-03-15 04:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `description`, `model`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'List Categories', 'list.categories', '', 'Category', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(6, 'Create Category', 'create.categories', 'Can Create Category', 'Category', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(7, 'Edit Category', 'edit.categories', 'Can edit categories', 'Category', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(8, 'Delete Category', 'delete.categories', 'Can delete categories', 'Category', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(9, 'Sync Products', 'sync.products', 'Can list products', 'Product', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(10, 'View Product', 'view.products', '', 'Product', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(11, 'Create Product', 'create.products', 'Can create new products', 'Product', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(12, 'Edit Product', 'edit.products', 'Can edit products', 'Product', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(13, 'Delete Product', 'delete.products', 'Can delete products', 'Product', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(14, 'Product Assign', 'assign.products', 'Can list products', 'Product', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(15, 'Assigned Product ', 'assigned.products', 'assigned products', 'Product', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(16, 'View Orders', 'view.orders', '', 'Order', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(17, 'Status Change Order', 'statuschange.orders', '', 'Order', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(18, 'List Orders', 'list.orders', '', 'Order', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(19, 'List Companies', 'list.companies', '', 'Company', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(20, 'Create Company', 'create.companies', '', 'Company', '2022-07-14 00:47:57', '2022-07-14 00:47:57', '0000-00-00 00:00:00'),
(21, 'Edit Companies', 'edit.companies', '', 'Company', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(22, 'Delete Company', 'delete.companies', '', 'Company', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(23, 'List Manufactures', 'list.manufactures', '', 'Manufacturer', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(24, 'Create Manufacture', 'create.manufactures', '', 'Manufacturer', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(25, 'Edit Manufacture', 'edit.manufactures', '', 'Manufacturer', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(26, 'Delete Manufacture', 'delete.manufactures', '', 'Manufacturer', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(27, 'List Projects', 'list.projects', '', 'Project', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(28, 'Create Project', 'create.projects', '', 'Project', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(29, 'Edit Project', 'edit.projects', '', 'Project', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(30, 'Delete Project', 'delete.projects', '', 'Project', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(31, 'List Areas', 'list.areas', '', 'Area', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(32, 'Create Area', 'create.areas', '', 'Area', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(33, 'Edit Area', 'edit.areas', '', 'Area', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(34, 'Delete Area', 'delete.areas', '', 'Area', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(35, 'List Users', 'list.users', '', 'User', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(36, 'List Territory Manager\r\n', 'list.territory', '', 'User', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL),
(37, 'List Technicians', 'list.technicians', '', 'User', '2022-07-14 00:47:57', '2022-07-14 00:47:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 2, '2023-03-16 01:17:33', '2023-03-16 01:17:33', NULL),
(2, 6, 2, '2023-03-16 01:17:33', '2023-03-16 01:17:33', NULL),
(3, 7, 2, '2023-03-16 01:17:33', '2023-03-16 01:17:33', NULL),
(4, 8, 2, '2023-03-16 01:17:33', '2023-03-16 01:17:33', NULL),
(5, 9, 2, '2023-03-16 01:17:33', '2023-03-16 01:17:33', NULL),
(6, 10, 2, '2023-03-16 01:17:33', '2023-03-16 01:17:33', NULL),
(7, 11, 2, '2023-03-16 01:17:33', '2023-03-16 01:17:33', NULL),
(8, 12, 2, '2023-03-16 01:17:33', '2023-03-16 01:17:33', NULL),
(9, 13, 2, '2023-03-16 01:17:33', '2023-03-16 01:17:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `level`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin', NULL, 1, '2023-03-16 01:11:37', '2023-03-16 01:11:37', NULL),
(2, 'Super Admin', 'super-admin', NULL, 1, '2023-03-16 01:12:10', '2023-03-16 01:12:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '4009e52c-e44f-4a4f-aca3-dbce6a3cb9c1', NULL, NULL, NULL),
(2, 2, '082f5ecc-f335-4fc4-8d0f-d4e7234045c0', NULL, NULL, NULL),
(3, 2, '4057f617-7d0d-46de-ad78-6beb1779abcb', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 'Rajasthan', 1, '2023-03-16 03:56:00', '2023-03-16 03:56:00'),
(3, 2, 'UP', 1, '2023-03-16 04:00:46', '2023-03-16 05:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `postcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `role_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lname`, `image`, `company_id`, `email`, `email_verified_at`, `password`, `phone`, `city`, `state`, `country`, `postcode`, `remember_token`, `is_active`, `role_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('082f5ecc-f335-4fc4-8d0f-d4e7234045c0', 'Test', 'Test', NULL, NULL, 'test@gmail.com', NULL, '$2y$10$HL8SvPqdC1e20BkMlEyJKuaXaGKYB13a58UyRBkE/gJQgFVA/LdJS', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2', '4009e52c-e44f-4a4f-aca3-dbce6a3cb9c1', '2023-03-15 06:39:24', '2023-03-15 06:39:24', NULL),
('4009e52c-e44f-4a4f-aca3-dbce6a3cb9c1', 'Master', 'Admin', '0556583835821101678946218.jpg', NULL, 'admin@gmail.com', NULL, '$2y$10$ttAF/VtApGocXam978OK7uJO1Qunby2Hk1XpjtmsN8x0NgEJhD8XS', NULL, NULL, NULL, NULL, NULL, 'lT8lOmfLrlEezt9hljMfI78A8QVCfe10nw1nEkhoXpu2Dv0g1fg14UJAMqhz', 1, '1', NULL, '2022-03-04 01:59:31', '2023-03-16 00:26:58', NULL),
('4057f617-7d0d-46de-ad78-6beb1779abcb', 'Sub', 'Admin', NULL, NULL, 'subadmin@gmail.com', NULL, '$2y$10$ttAF/VtApGocXam978OK7uJO1Qunby2Hk1XpjtmsN8x0NgEJhD8XS', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2', NULL, '2022-07-14 06:24:14', '2022-07-14 06:24:14', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_user_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_foreign` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permission_user`
--
ALTER TABLE `permission_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
