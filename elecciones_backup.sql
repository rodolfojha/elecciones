/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.13-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: callcenter
-- ------------------------------------------------------
-- Server version	10.11.13-MariaDB-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `assigned_to` bigint(20) unsigned DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `status` enum('waiting','assigned','contacted','completed') NOT NULL DEFAULT 'waiting',
  `course_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clients_assigned_to_foreign` (`assigned_to`),
  KEY `clients_course_id_foreign` (`course_id`),
  CONSTRAINT `clients_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `clients_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_materials`
--

DROP TABLE IF EXISTS `course_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_materials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('video','pdf','image','document') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` varchar(255) DEFAULT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_materials_course_id_foreign` (`course_id`),
  CONSTRAINT `course_materials_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_materials`
--

LOCK TABLES `course_materials` WRITE;
/*!40000 ALTER TABLE `course_materials` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `duration_minutes` int(11) DEFAULT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `courses_created_by_foreign` (`created_by`),
  CONSTRAINT `courses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_completed_clients`
--

DROP TABLE IF EXISTS `message_completed_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `message_completed_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `message_completed_clients_message_id_client_id_unique` (`message_id`,`client_id`),
  KEY `message_completed_clients_client_id_foreign` (`client_id`),
  CONSTRAINT `message_completed_clients_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `message_completed_clients_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_completed_clients`
--

LOCK TABLES `message_completed_clients` WRITE;
/*!40000 ALTER TABLE `message_completed_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_completed_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `frequency` int(11) NOT NULL DEFAULT 5 COMMENT 'Frecuencia en segundos entre cada mensaje',
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_user_id_foreign` (`user_id`),
  CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_01_31_000000_add_role_to_users_table',1),
(5,'2025_10_31_000001_create_clients_table',1),
(6,'2025_11_01_002408_create_courses_table',1),
(7,'2025_11_01_002420_create_course_materials_table',1),
(8,'2025_11_05_233923_add_course_id_to_clients_table',1),
(9,'2025_11_13_004647_create_contacts_table',1),
(10,'2025_11_13_004648_create_messages_table',1),
(11,'2025_11_13_030809_create_message_completed_clients_table',1),
(12,'2025_11_17_211656_add_frequency_to_messages_table',1),
(13,'2025_12_06_010414_create_voters_table',2),
(14,'2025_12_06_191806_add_mesa_to_voters_table',3),
(15,'2025_12_06_234821_add_trabajador_role_to_users_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('00Crzzyf3Fhh1VIyIocCIgjJRHCKV57lsNbZwkWO',NULL,'93.174.93.12','Mozilla/5.0 (Linux; Android 9; ONEPLUS A6013) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3880.5 Mobile Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0d6Y1JOd1czbTJ3QXJSdEtJdkJCQ3JJSXJYQnBNR0tSdkxXcnNxMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765214863),
('04lSViguxLd4ZxhcyFZkiOT4xzHmosjHDPU7SL9W',NULL,'118.212.122.3','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoibGRESEladXFXWFM3WHBMcFA5S29JZ2dQWTJLSkloREFxMk14bEhDMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765196820),
('0ALG0AHQw4al7UEYvqCWCUDahEj8kWuwL1POjiU6',NULL,'216.180.246.198','\'Mozilla/5.0 (compatible; GenomeCrawlerd/1.0; +https://www.nokia.com/genomecrawler)\'','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnVUOVFScW8ya0tCaWoyaG9BRUlJT2FWVjlRd1p3bXVpSHhOUWpkYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765269261),
('0ExvistA30AFxVycLZM0gROVuLbhaGW2ANX76GWd',NULL,'66.132.153.125','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWGw5TEJvWVlQQ1pFM2d3NGxObFYycDhzNFJZb29WZ3k3bGJFV2xSMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765460047),
('0l8LryMMcEAp9gt0qi3SAu1AyUANcVOPpJuxsWKy',NULL,'92.63.197.197','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/600.2.5 (KHTML, like Gecko) Version/7.1.2 Safari/537.85.11','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXVYODBjRXBlQVNIUElaR3FWakFKSXo3UTlUTVRnVXoyUFliODlXZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765239547),
('0XAZoLcvkLt6kteVoOd2jtTB0EPIP70g9DU8yUro',NULL,'2a06:4882:3000::2e','Mozilla/5.0 (compatible; InternetMeasurement/1.0; +https://internet-measurement.com/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUlhzRHR2MmhtT2t6VzA5RUpoRVRXM05lWGxyS1NNcXdqWjhNTXdZcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9bMjAwMTo0MWQwOjIwMDU6MTAwOjpjZTBdIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765293598),
('1G4a0nZWVK5x69hahUQlzX05KWFt3XSh5P0r57Gl',NULL,'114.26.125.177','libredtail-http','YTozOntzOjY6Il90b2tlbiI7czo0MDoibUZWMno2Njhza2VYSGRzSG9mTmpqNEE3UGNTbjJTTEl6NG1JaEpRMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTQ2OiJodHRwOi8vNTcuMTMxLjMzLjI1MS9pbmRleC5waHA/ZnVuY3Rpb249Y2FsbF91c2VyX2Z1bmNfYXJyYXkmcz0lMkZpbmRleCUyRiU1Q3RoaW5rJTVDYXBwJTJGaW52b2tlZnVuY3Rpb24mdmFycyU1QjAlNUQ9bWQ1JnZhcnMlNUIxJTVEJTVCMCU1RD1IZWxsbyI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765249097),
('1P6rh0BuCumsYQJYlJvvO5Q0Jw5pCY7mHjHA83Op',NULL,'213.21.239.49','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZVJJZVg4SWlLSzZSVGdRTE5Hc1pQNzloVW8xOXpiVkg2bmU5UXgwdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765300009),
('1YSURhGhUo2WYuLvTkM5ecRrCoiB07Unh4BAer3u',NULL,'185.180.140.10','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUk1DTVBoZzVseDZIMTA3dVUwbTVFUThaZzFTRGJqeFl6T0lwS0ZPeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765303831),
('2I8EUjUIpYN1HxxLmYvXiqPzupEBeWv2Gee4Tp7N',NULL,'129.45.84.93','nextjsscan/1.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSEhOUHFvenpCVjRjSkxNQXVDU0pxSXlhY2t6c29mczZqTXJPTjB4MSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765338939),
('2uMVvxkwa9dZv7fkgqiE10vJ0CRbiY3z1cPHwEtm',NULL,'152.32.190.153','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaFJSZjVMMzQ5UlBSS1FZcFBHMFp6NktIWjI4WE1QanpNWTI2V2hUTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765239491),
('3ZcGEQN76An3dEaUjlrwN858TJVQire0h4SgWSth',NULL,'223.166.22.141','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYmVWek5HUExPMTZ1RzVRTE1BcHp0Q3prZHNRZUV5bVh0TzlXOFhpdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765196803),
('3ZeBOkY13ztOa5JAAyeJ8v1vOxYmLwPLParHNOiQ',NULL,'85.53.233.32','','YTozOntzOjY6Il90b2tlbiI7czo0MDoibXV4ZjhzZHBnVkxSOUdkMzVKU2VyUDRiUzZ0cUpmVnhFUUp6R3phNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765317018),
('4iPJxi3yI6WwIMJhqlz6Zf4cMARo4jkYAaXFoavu',NULL,'114.26.125.177','libredtail-http','YTozOntzOjY6Il90b2tlbiI7czo0MDoic2EzaWE2Q3Z4Mndabm1ZM2J2ZHFCZndEc2JUd1JrZHc5VHFPOG9RVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTQ2OiJodHRwOi8vNTcuMTMxLjMzLjI1MS9pbmRleC5waHA/ZnVuY3Rpb249Y2FsbF91c2VyX2Z1bmNfYXJyYXkmcz0lMkZpbmRleCUyRiU1Q3RoaW5rJTVDYXBwJTJGaW52b2tlZnVuY3Rpb24mdmFycyU1QjAlNUQ9bWQ1JnZhcnMlNUIxJTVEJTVCMCU1RD1IZWxsbyI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765249096),
('4KGoZBZE3Mv8EGJbej86abkjbStu4A3K2rzHdxMf',NULL,'45.156.129.57','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZzhVaDRvZ2luUWlNWDdQcDhqbkdhYmo3bGpucjNBVnlPeXJvTUp1eSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765435445),
('4qzMO1w5lab4M5eAXz8sruU5zxvdVQE1oo1SsJZ5',NULL,'184.105.247.252','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYmFDZjk5RW84WkFmSVUyV1FOS1JBY2NybVNGUGpqT3c4ekF5SjgyeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765238594),
('4U9krqRD8gbJLTNEK2vgCY50zvmYJ4ldYIQQM4bd',NULL,'141.98.11.98','Go-http-client/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUkzT2F5MzVVakh0ZXJrSldQd1RhNk5Qa1ZGV29Ia2RaRXlFRDdvQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765316153),
('4UHEDvL7acIQf0HOoVKxmVMxswPwq2Xn9NHJOK7F',NULL,'93.174.93.12','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSDhtVm1RN2ZOY0Jsa2RkSk81YmMxSkpKeTF6Qng0QVpYUUFPR3BTeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765417524),
('5MlqG2rxDpIhVgwQQeEy5xfOlZuS9KYOzUxB37Jm',NULL,'152.32.190.153','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVEdQbUU2TTFCYVlJNHYwVUZjSUdEMlk4Z003T0UyTm5wdVpOdE1CQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765239482),
('5XdQcIica4Niz4whrWhUeY7ntyvGLckgX2Hpbya3',NULL,'141.98.11.140','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiU1lKdWx2MnZweDNITlJXRmxPNHQ2QWlZNm9VaGdVbk5sdHZGaXQwbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765267376),
('63wLwsXWXfAxIAI8OQfryJxVRimbRVdTjAfrbrf9',NULL,'204.76.203.18','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMmNNUkhwaG9EaWgyM25CM2dBR2c5Z3ZwRjB3cG5ObnRyR2ZHeGhSdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765234686),
('6AwN9RraaJ0lwBLPvte74hlejkKJ8KcBtOSSWjjm',NULL,'87.121.84.177','Go-http-client/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiamxSTFpNYXpYZk1ueGxsSmxrR1lTc3ViRVd6SXlGSWZYWWVrNWpHbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTg6Imh0dHA6Ly9leGFtcGxlLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765481968),
('6ihqvOGDd9yejTIkWGYLHBJTyLAq4sPxRUQ7UQml',NULL,'134.122.44.74','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnkyQWRuZW1VSFRCWjViT3JXWnlPa1NwSXM2YmYzWXRSeGZQWUtKeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765230022),
('6IW1yHsiPTnubbN5etNsNLVe4ZFj7xmC5zcmXNE8',NULL,'172.105.246.139','curl/7.54.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVW9GUDFRenFTRDVvUjBDcVpDd2RYZUpNYk80V3lWem4zY1RHUEljeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly92cHMtNDliYTliYzcudnBzLm92aC5uZXQiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765311782),
('6jXmoPZZemhMruD5K1zQ39KvVBeUxA9cJ14H0QOV',NULL,'184.105.247.252','Mozilla/5.0 (Kubuntu; Linux x86_64; rv:125.0) Gecko/20100101 Firefox/125.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYjd1TFJxcmNFWnRvVUZwdzJmRUZoQTUweHBDNmFiZTJXMW9aWmIzRCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765238613),
('7MZthd92qe5Qmd2lRgqKoRCoJyJUgHhG8VzOKpOV',NULL,'93.174.93.12','Mozilla/5.0 (Linux; Android 9; SM-G950F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.143 Mobile Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoibHhzODltVGQxQUVxeHByaGJzUTBBZkx0b2luNXozYW4zQ2VTZlRVbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765315366),
('82MfZ97seyfVLoPQ5WtMf5fgOCMQJXVQOAPfoczl',NULL,'35.233.5.189','python-requests/2.32.5','YTozOntzOjY6Il90b2tlbiI7czo0MDoidk9ENjQ2T0lPZGdrN2xFTmdRUzN2Y0lHOUx4c1ZHbE9pTjVoRnpuayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765218557),
('85uBX0mxy3KehvUpiDqZbl7JxeNUbfuenAD89afs',NULL,'104.155.20.12','python-requests/2.32.5','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ2xTQjRpRVNWdEl3aHg2dTJUZEExOTRUeUdSRUF2dHRmOTdYV3FsSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765460802),
('8PE9VNZWcLCGtX77ScyTWAlaiI7qXbH0oIKBvgZ9',NULL,'165.22.61.50','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.5615.137 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXE0Zjh6OWVWY2JTdzVnUWV2WWREV1JBbEgwOFI2bG9sOEhTb2kwNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765294218),
('9mfTXokcrBtaODj36VzDDEcp4FpZOzVBiYNFfIbF',NULL,'3.137.73.221','cypex.ai/scanning Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoidUd6VTFHd092ZGt5eGtxTEpIdVhGbExQMjlFZFI2RmJ6YW5mRjlMcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765256491),
('a1bivJoiFl4rX3nhVK8WBZ2D4Zho0KCDDTJqeKda',NULL,'167.94.138.32','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ29MS3JQTGpWRkE4SHl2Qk5KUUh1M3hZOTZrTzhvelJiQk5KOXlNUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765429765),
('a3JrKRFnBA8Cj5ouETpZibEdDsE3GUCNMMvQHZv4',NULL,'65.21.1.72','node','YTozOntzOjY6Il90b2tlbiI7czo0MDoidWZ1RGd0aEd0MVVrcVJiakxLWDZZTzNobTN1dTJOekRuM2NHanROUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765318461),
('AAfVM0dPBY1wIDpWRoBKTKedm5fJnuqP6OEVGKRk',NULL,'172.105.246.139','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMlRCZ3o4SGFuYVBZWHdzUVFkNkpFUWZvM2Q2ZEZpUWhQeUZLdFdZNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765311781),
('aAn7OyCm3yD2jssbRMcb9chvMma300BWurSwnqCA',NULL,'91.231.89.131','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGZjSnFPYjlJVzhBTXZIT0UxR2xzNENPcndRM1ZiYnJJWkVNa0NNcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765193291),
('aDVzd5cVD3V7F9eOiyQfuV4i6iEv0FxTLKF3B2ah',NULL,'167.94.138.166','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmRZbmhLREZ1bFZmRHpIM3JDNGNDOUtXaWUycW9ubHRSMnhkeXQ3UiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765223387),
('AjZ8astOEQhl80rUJqTzfEYwAz7OAAqm15ys7GX2',NULL,'152.32.190.153','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWW45R3laUVhhYU9uM3FEdmVIbFdCeW05dTFHUHlCMWhZYVJCaVVYTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765239492),
('ARoXkANg4qhtQ7Y7rGlGtQTUgaI7hpOgNgvwSvbS',NULL,'114.26.125.177','libredtail-http','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRTk1cllHM3l0SDk0WmxzbUVmY1JQSXhxc3IxeDgzWWVjTG4xMll6NiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODg6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2luZGV4LnBocD9sYW5nPS4uJTJGLi4lMkYuLiUyRi4uJTJGLi4lMkYuLiUyRi4uJTJGLi4lMkZ0bXAlMkZpbmRleDEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765249098),
('BbisguoBYSTwer8NbAnRAqaEDb0Vc8wNZlj08fED',NULL,'87.121.84.177','Go-http-client/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUlh4Y2JzbEJwZDFxWTVDZXNpb3RIRDRJRkNUdmJGMXE4RXB3OEhBMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTg6Imh0dHA6Ly9leGFtcGxlLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765481968),
('Bp8Snjl8HqOqRHQ46OI93saJS2EOBUxKRNl2LNle',NULL,'89.42.231.241','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiTGRYeDdjOHNjSEpUaEU3WVlVVFhHVDJzeHJSWTQ1VmI4b21HYkRLZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765474974),
('BUGKFdkj6mje9xuKISJviN2Bi9qRiVonRauraNXz',NULL,'167.94.138.32','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVnZXenFiODZsdlROQ2h2dGN0R3RtT3A5bHF1QXBIVnNqRU52MEZibiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765429770),
('BWYBUXf2kZ1ItGrfnwOezAuEnTLIS3Z35gGr5Wu1',NULL,'54.196.48.233','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUWFpMlQ5UFMwRW9rRWFWa0dXYUo4MG03Wk9FclB2WTZkRkdIZmhLcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765469706),
('bZQb3vVeQq2qf0v2ymZpCGRPrM4QeEI0svnypoM4',NULL,'176.65.132.67','','YTozOntzOjY6Il90b2tlbiI7czo0MDoibjF0Z1NLdjNTczlXR3R2Q1dTNDNtcUR4WHB0N21LOGZ5VjZNeTNBOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765456922),
('cBqT8eLl24ks5JHpDPFURoQS96HTNkolSSdXgHf4',NULL,'128.14.227.179','libredtail-http','YTozOntzOjY6Il90b2tlbiI7czo0MDoiM1VIUkJJWkl2WDhSZUNMZzA2V0tvTUxORlZja0NqS0lQQmlHcDZwQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODg6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2luZGV4LnBocD9sYW5nPS4uJTJGLi4lMkYuLiUyRi4uJTJGLi4lMkYuLiUyRi4uJTJGLi4lMkZ0bXAlMkZpbmRleDEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765257511),
('Cnim4jFr7mv2xlhIbrFyUv3ZXZD75KwG8Y3f9Nau',NULL,'79.124.40.174','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVVFLQmpmMWZIM2RYb0czaFRGV2swQkxBUk1YTUdRTnR6UkloZ0NoWiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxLz9YREVCVUdfU0VTU0lPTl9TVEFSVD1waHBzdG9ybSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765283446),
('cy3VDv5bNNElO6DJ1hIknEpJMWz19DUWOUBxo1Ap',NULL,'3.137.73.221','cypex.ai/scanning Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWHc5a1dySm5KdlcxS3A3S2tmdllhQ1Y0WFhvcEJybjlQTlZYbzNOTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765256562),
('D8C9n1g6xXqsScOY2ANS8uPdoo9sdbd7qN7Uwg27',NULL,'5.187.35.158','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiR0FwMWRaU1NNVFl4aE9CdDROeGp0M0lKVnpoN205eWw5ZUlwOU1vVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765331926),
('D9bwQCRHbIRJKYPzdafQKJcMmTXdo0JT2xirII53',NULL,'66.132.153.125','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVFkcGt0UGNkdVVwZ2VDQ0xrM1RFa0w2RGFLbVp3S2ZzVVlvTElXQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765460052),
('Dj5279f5DG6uEB1emgf1VqOEheenXfJaFPwF72Xm',NULL,'37.120.93.147','Mozilla','YTozOntzOjY6Il90b2tlbiI7czo0MDoiU2dIcEpuQUlmcTZzelF0QXZ4MkNHdGpLVmxnMDcxMFNlRDAyM1RXciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765212023),
('DSPoTLDYyAedJTI3tOiQPjao5N6sNl5NJ4Tj27qh',NULL,'114.26.125.177','libredtail-http','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDhxOHBycXVJNEhKNnZka05oUXExTmk5T3o5SThrN3RnSm1qV0RzciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTk5OiJodHRwOi8vNTcuMTMxLjMzLjI1MS9pbmRleC5waHA/JTJGJTNDJTNGZWNobyUyOG1kNSUyOCUyMmhpJTIyJTI5JTI5JTNCJTNGJTNFJTIwJTJGdG1wJTJGaW5kZXgxLnBocD0mY29uZmlnLWNyZWF0ZSUyMCUyRj0mbGFuZz0uLiUyRi4uJTJGLi4lMkYuLiUyRi4uJTJGLi4lMkYuLiUyRi4uJTJGdXNyJTJGbG9jYWwlMkZsaWIlMkZwaHAlMkZwZWFyY21kIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765249098),
('dsPUjY2M9vS8y83b1Ohe54iSZXdXSBF0WHU4ehnB',NULL,'79.148.117.166','','YTozOntzOjY6Il90b2tlbiI7czo0MDoibWZhTExYVUxrYlJjV3JQajNsOWh5UFd0UzhjQm9JcFVNa3FmNkdUMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765205660),
('ducJH8ilJtZsvhSk1qlfj2BfYnFH25ZLwFh1gH7W',NULL,'91.230.168.30','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoibjVLVXhCWE9SekdXVVI1QWFqQ1BXNngzQWdxOTlGQTUxd001YzRsVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765191360),
('E0tdh8qNGUuxZDxOej8ii33yH863Mq6W83kY4Q0T',NULL,'165.22.61.50','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.5615.137 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWE5XSEE0WTdENXo2TEd6dUgzR2YyWUdsSXNtQnZicjI3TndOQmwwNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765294185),
('E1gFMWSAyrqmsUnk8LuXoRO4yoasxC4PIhse3YpJ',NULL,'45.156.129.135','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaVlXQU12WmFidktyUnFwNk5lNVdYeDJMeTZ4YmtuUVVlYU91WVE4ViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765332348),
('E1shFcMZNsVV7uneRC8mLVgjwPtY2FCckRheAXTc',NULL,'165.22.61.50','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.5615.137 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoidTJHNVYyYm81WW1hSXA0WVpNeWN1cmNmckhDVmh6OUxWMmxDY29mayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765294205),
('E87MTiI8YvRxwAwH03ooIFmopc5ER3MQymxt1xXv',NULL,'103.136.147.163','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUHhIeHUwSjVEVjh5elI5bUplZzM2aFRFblJFRGVoZ29HdklVQXoxaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765203810),
('EEH65ackt2WLvWuijoARdOMkYiHJ9QodjYk7QHLb',NULL,'198.235.24.10','Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMVBxRW1jc2Q2WGpHeGtWbnpIUnBFU2V6VWp5Mm1XV1hzMXV4NUN3VSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765445773),
('egryhSkEQp3UBQsJ28a9bvx7jXzfxezkfWQZHGmF',NULL,'91.224.92.109','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiT1pEb1Rrc0Q5aGxOREJaNnNEZGprQm9DTFdCZktQc1J2dlNva2xCMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765200586),
('F6ew8mPwNppQDMWbYamuIrADdbiBWT4Z6RG5Q1DH',NULL,'190.120.251.31','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNzNaUlpNMTF4MzV3YjZ2TWFsdHZiT1pUTGVvSVE4V2Nhdm1sNE1RRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765418822),
('FiJUqsX6ZM3pm56WbfhiyODBhrOadWWGdvGlU7F6',NULL,'176.65.148.66','Mozilla/5.0 (compatible; Let\'s Encrypt validation server; +https://www.letsencrypt.org  )','YToyOntzOjY6Il90b2tlbiI7czo0MDoic01ZRWxnOTdrVTY0eTVqSnBNOEZoSGtjdmgwRHZUWnpuMjIzT3A5VyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765337821),
('FjVCkwQqBFXIuJlrcK9Ca7hhR6oGPJQIq6DLnUdx',NULL,'87.121.84.177','Go-http-client/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmxKSDlIQzlvbVNTOXk4WWMxWnBjYWdYWFVUR2RYQks5bkhyZkpWViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9leGFtcGxlLmNvbS9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765481968),
('fmEeASSLnRrLnk5Y1mC5eXwiDiDDwtJbHtiRxgSt',NULL,'134.122.44.74','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWFLV0ZTckZkV1JZV1o5T2hTelNkQ212anJBRXJ1Qjd1NUt4MlRZciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765230022),
('fMKX07OxQkndtvDCyhCJH9fIyh1Ibh1jSDNf3lwj',NULL,'171.105.76.116','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoic2N5VzgxcTNkZDdDRHI3N3ZEUVpVQjFIbzRJanJ1ZTJuTUhGNFB0bCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765196817),
('FNpesdYssREC64Z8dsLdzUDlVIQXdndtLDZMWhQk',NULL,'172.236.228.202','Mozilla/5.0 (Macintosh; Intel Mac OS X 13_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaTRTTXE2UG1nSkZ5aFprbGloOVB3Y1VISkxMYldSR2U0RVZ4RGdIWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765254641),
('G811lWsWo9sdwW1q5XpSPs5fwHutxSYENDMb74io',NULL,'5.187.35.158','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiZlV0empNV2ptWlN3ZWp3OXFZUzRCUlBYMWFvVUNaZ09XNklJTm5GRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765293125),
('glAg1z3cxWgUiTwyy0fupjk1dx9PvjYbjdnae1hD',NULL,'5.187.35.158','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiNHM2anRjaDFBdmFxc2cwU2pINjE0Um9BQTJiWHhRVGh2VjFzUG1PeiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765260091),
('gmg9iotvl2cKRr1C2EbTgHUKFUnwIWPxBCiLmA0q',NULL,'141.98.11.98','Go-http-client/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiT1ZBRGdHY3ExSERmdDM2bkhaSTVBeU83dU02R1FjNlV0eldpdzl0ZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765330481),
('gOfnQMgtmk8m4EsDeSlegwFSjC99VqEP7DrIcrb4',NULL,'172.236.228.202','Mozilla/5.0 (Macintosh; Intel Mac OS X 13_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoicVVyUm82d3JRR3dTWHdTRHJ1T2REdjNXZktPTzl3NDQ5dEZZb2RuYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765254641),
('GtqXb6jmydKF5mLPwErn7CPgMy6BJohked8ZCts5',NULL,'20.65.194.183','Mozilla/5.0 zgrab/0.x','YTozOntzOjY6Il90b2tlbiI7czo0MDoiY1FKR1M3ZXNmRmkya2tSSUxMRVE3STBkeWFYZmJFQ1o4TG5vdk9RWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765469815),
('HeAivByA4YClEVBzSlu5z3qPa6hisBuQp3lOJkhO',NULL,'144.123.78.137','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaEpaUkJON3NHeWNRQXZLS0JCY2t1SkZWcXpiM3NyT3NNMkFqSUFkVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765196774),
('hjvmqpWYh9mGPA2G1RwyTEwJdPI9IiElpwMcZ6Vu',NULL,'152.32.190.153','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoic2dtR0NQYjJEbHhJVkhCdWwwN0dFcjNJYndOTHJKalNKSkF6dUJMbCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765239496),
('hoO9nZmTa2Tqc1zSvQpjXPhD3qvcWkvJ6OtmJ91W',NULL,'162.216.150.64','Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWE1NY2xKQU4zeEFrcHNrdXVBaUZwZUhndURvd3BSWkdLTkFQYXBtNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765319583),
('i51HkMqdbD9Tqsp0ilkP5NXllkIFjKVO7jj15l17',NULL,'45.156.129.48','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ1RQaTFRWEhLMmhDM0JoUHNtZ200YnZGMGx3SXlvUHRTQ253YUxkayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765216857),
('I75R1VmoSbbSSfNbOstZg64FmbZHtQ37qGOrU0NF',NULL,'142.93.226.62','Mozilla/5.0 (compatible; Nmap Scripting Engine; https://nmap.org/book/nse.html)','YTozOntzOjY6Il90b2tlbiI7czo0MDoieWhtVnE2YmZ2c0toallMVjd1dFB0dDdxTG1VQXhaU0NieTFJR2ZuWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly92cHMtNDliYTliYzcudnBzLm92aC5uZXQiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765260613),
('IBYaeLS6usFRJUzx1iUZJoSGVpeJXqjjuWsy61Kw',5,'95.18.20.186','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTGJjWU42UllZblAxOGxtam5JOW8wc1JaR1M2WjNGM29qVXM1Z245TSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czo5OiJkYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=',1765307966),
('iC7WzRAcNiAskeZk5j7bc60o9TlJtpUZq2HhDBH2',NULL,'178.163.44.50','Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ1J1YnRSVmFsUU9wbHhMaWRIc08xNE91dWw0SlhSQXZXSjlJZU1ZSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765236901),
('IfFORijpBSW3UzHcbSGmuINhNb5fiV9oOPBLsePL',NULL,'172.105.246.139','curl/7.54.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoieUwwZWdLOTlmNkVKR2NzeVBZRTVmNHFOY0I0ZHFHOFEyRzZkRmszdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly92cHMtNDliYTliYzcudnBzLm92aC5uZXQiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765311781),
('IkPNajOwudRa9DZcA7USfqlUw6skl5jGyQZuNwvF',NULL,'143.110.240.211','Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSVppTFVORkY0S1NSOG1SYUpZR09YeTJvSzNIck9aZjExQzBYS0ZRaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765297577),
('iL46pTp1LWGeo1090e2XWEP8RIdz1zI8nWSiIkTa',NULL,'79.124.40.174','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoieElETzF3ZTk3S0dOVUxDNUVwRlZQUHFWR2xwc0dxUng3WEZvd1dkMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765190967),
('IwWSDfzu14e0LvzIxgubvqLJjE5XlCZqd8dOO83K',NULL,'213.21.239.49','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiT3VXNDZzbXp3WGZ4MWU2V0JZbmY3QzNsTHNqc1hzaGdsenNKcXhoUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765300009),
('J7g4qUV3kX9RCC5WhgtJgJ0bDLSvhhCKbJFlKnQr',NULL,'87.121.84.177','Go-http-client/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiak9pYTE2dkVQcFA4Nzg4SHZBd2EzM2ZJQmtRRlIwZjI5Z3ZjVnQ3TSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9leGFtcGxlLmNvbS9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765481968),
('JbkR8bZZ9aG6WI76yWRpl97q2AMzepQnpNJUbpW9',NULL,'176.31.182.147','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGp0OTdrVDRIY0tJZmI2ZXdlZHBxNzF0WGNMamQzTU1PVGRsdTdzZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765334344),
('jnnuhSyD9d5lnyryqn9OAtgTXyt0M8yB2NeWl4Mk',NULL,'23.23.43.140','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRWtteDNaR1gxdFYwcU84QjJYa2xNRkV5ZFdYaGh2a2hzQmhraThnYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765222941),
('JR4tICSgXEDcd9bkClDV1dDPpjXAFCqaUJZbOL6v',NULL,'45.156.129.135','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSFluT3Q1WThhM01TRm91WUlacTdWRXJjZEt1Z1lqRXpnQU9NWWZXTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765332347),
('jraAOliQt4ynjwqdvPWhVvwS5sIMIepoKw5Tat5b',NULL,'216.126.239.29','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVXNRNDN1bkxMN3ozYWFkMUZQYTZtMnVTUml3RVV3dW9Oc2RWMm95MSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765194003),
('K0hGOd5mN1XHZNglYyRqvLg9iS31nShrKAXsnBdS',NULL,'45.156.129.52','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUDdydlJnNEExeFh0TVBQVzQ4dkhJMnZJaUljVUVCbksxWlh1enJ1TSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765426223),
('KdzcbP1J4xQhdJrKUJyfNgCUwGxH74WHQrc7523j',NULL,'147.185.133.1','Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUzJFS2tQM3hSaW0zYzVkVEhsUmZ0SnBtUldZVXJBRXl0Q0xHRGlPUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765266562),
('kHb5cyJ5nXfpCSOy8xFYfc7z0LggaQuZ8t7y7y8N',NULL,'141.98.11.98','Go-http-client/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaDFlSnF3aHB4T09lMndYekNuanZna2VOS3RJd21YeFFWbWFITHNzdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765316153),
('KhYmJvsZGxvNy0rCocQP7QqoIZFGluthmU6F9646',NULL,'149.100.11.243','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0dHRjJqOEVONUNxd2RwajhNWFVoZ1NJUWJQR0xsaENZMnM2cTYwRCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765254070),
('Ki1esgpjX3YsnlUdx6iszaSyWCQpE6Ag1s0jP5mK',NULL,'205.210.31.234','Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTkVkUURZaGs4V2pBSklaS1cydHozVzBmNkVZb2F4OUJyYlVVSlVlMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765320138),
('KIwYup3MmTVwV9YDBhl4fi09wQRsUAf3N6LCXD1p',NULL,'79.124.40.174','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoicWZOWUE3M1ZvVEt1c1ZwQUN6aTFYaVI3MXZUWmhKNVNLcUZGa2pPNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765283446),
('l0P8KK5hZMiGmt3w2m843e2EulZUohWqBSdXoEnw',NULL,'176.65.132.67','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSkQzdjZrY0pLa2t0emZMVUdnTzhRclFPMHhab09QZHdRU3F0b0tMQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765432547),
('l8VD9eGfppN2RUN0jwX5BQcWHO20CYRBTHc2najA',NULL,'78.153.140.151','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.2; WOW64; Trident/6.0; .NET4.0E; .NET4.0C; .NET CLR 3.5.30729; .NET CLR 2.0.50727; .NET CLR 3.0.30729; Zune 4.7; Tablet PC 2.0)','YTozOntzOjY6Il90b2tlbiI7czo0MDoicXJnT1c4MmNzeXV0WW5wRHg0TVJWTEpKYUNYcWNua3NBTmF6bGoweiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxLz9waHBpbmZvPS0xIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765246850),
('LHIzxPsYoeDhsxe0GGhiUZgGvEz6Kn8R0Y0owbbQ',NULL,'45.156.129.46','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ1k1c1JWalhxNWowS2J4VnJldlFoRkZkeG0wdURZeDZMZlZxQm9ESiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765446156),
('LSYT6hjcKkNkuhGH64g33kxoAerMf2SmARWmOsNU',NULL,'152.32.190.153','','YTozOntzOjY6Il90b2tlbiI7czo0MDoieG4zUXFldVBpVjRRU25oQ0ZjVFJBNHdnd0RUSVFQOEdhRU9ncUlrOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765239481),
('lwIu90XK2m3TX2HA4q7J6OqIOqFYYUhzwjL1kFOU',NULL,'91.196.152.2','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoianpGaGpGZjFxQWpldXI5bWlieDJiRERMN3NVREFjSkc1ODc1VXI0MSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765192546),
('lWR1ZhhhQoNaUwB3bBr2L4UL2KAAYurgQmCFc3Ai',NULL,'162.216.150.64','Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZWlUV0VHYTZMOEtsbXkyc09FcXp6MGRuRWpndW11MGtYbXllVmV0WiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765319583),
('M9fnk2dHbY3S5THh5H4NfZJ42lMxfCxwzRTrWRRD',NULL,'128.14.227.179','libredtail-http','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTm9EcXg2bE9iTDY2dkFYd1ZWajltRnpXeUdjN2hjakg4dHVuUHV2QyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTk5OiJodHRwOi8vNTcuMTMxLjMzLjI1MS9pbmRleC5waHA/JTJGJTNDJTNGZWNobyUyOG1kNSUyOCUyMmhpJTIyJTI5JTI5JTNCJTNGJTNFJTIwJTJGdG1wJTJGaW5kZXgxLnBocD0mY29uZmlnLWNyZWF0ZSUyMCUyRj0mbGFuZz0uLiUyRi4uJTJGLi4lMkYuLiUyRi4uJTJGLi4lMkYuLiUyRi4uJTJGdXNyJTJGbG9jYWwlMkZsaWIlMkZwaHAlMkZwZWFyY21kIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765257510),
('MaTm4wMQ5lKztGnppZ4xKZoumjDlFlaNw39wRZnD',NULL,'45.156.128.45','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoibjdaYkxLOTNwQ1F0RjJmQkpSVTlyd252V0s5cXhzNWt6SEp5SzdJUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765473606),
('mf4FHP7Kan3LlqSbWSucNHkeBOoawOTJHR1hTG4E',NULL,'205.210.31.245','Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTDBjTnVvVUVOWndXZk4zaFlidWZ0ODVPQ2lLaE1FcHpURlI3V3hiNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765338304),
('mS78YZ09MdBQfYAZdPfTO9ViIAM1oeI2XH6zFSpQ',NULL,'194.187.176.43','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:65.0) Gecko/20100101 Firefox/65.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoicFJONXhxZmZQSUc5Y1p0RjhWaVBqVXI5OG5hYWtXdXY2VDdxZHNuciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765450426),
('MtLnyueo9pygawGgBhyqYqckIploWIsKKXn1KeNY',NULL,'184.105.247.252','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSmxmck10SXI4VGxjcllRREVKbTZnSDRWY1dnY1F6RHBWQXRLQXFXcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765238593),
('mTysWFWpivkfHT3bY8LwbUI9WmYluEtEwPRZS0Ow',NULL,'128.14.227.179','libredtail-http','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOVNYVEdXakxpVGh4THByVFJGZ2pKWmtpUU5MeXVJOG5KNTJqS3NEYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTQ2OiJodHRwOi8vNTcuMTMxLjMzLjI1MS9pbmRleC5waHA/ZnVuY3Rpb249Y2FsbF91c2VyX2Z1bmNfYXJyYXkmcz0lMkZpbmRleCUyRiU1Q3RoaW5rJTVDYXBwJTJGaW52b2tlZnVuY3Rpb24mdmFycyU1QjAlNUQ9bWQ1JnZhcnMlNUIxJTVEJTVCMCU1RD1IZWxsbyI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765257508),
('mvE65fmo2cpD7Zjz1meh6NYCX26rJk4NasmTjbpL',NULL,'65.21.1.72','node','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUzVEZVpvdk5MZTVQaG9GV0taVFZQZGN5YmZQWHIwWEF1VUdNamhrQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765318461),
('MwdLtRfD1Jq6H2ZcNGZInMDGEb3LWjX6rYd1QucR',NULL,'176.65.148.66','Mozilla/5.0 (compatible; Let\'s Encrypt validation server; +https://www.letsencrypt.org  )','YTozOntzOjY6Il90b2tlbiI7czo0MDoidFFGQU4zbEtDenh0Rkw5SFphOGJDMHFxZ2RQUEMxekdUVFF1SXoxSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765337822),
('MWN2iPeUQdL8erADimO1NcBOLIMl3NXRNDOMqLT1',NULL,'91.231.89.107','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQnMwN2wzRlA0bE5NYURHQUY5SlU2SDZaRTBzY0x5MVlTdXQzaHZRRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765192931),
('Mwul2zp4kCt7ZSohLqoPVKPGME74Ro0skI8660XV',NULL,'172.105.246.139','curl/7.54.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSFZ5VThnMjhyMUUzS0JjWXFSS3lsbkprQlZjR085cDJmQUF3Z3Z6VCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly92cHMtNDliYTliYzcudnBzLm92aC5uZXQiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765311781),
('mWuRhF6hwNsiN4wmjMwGQInU85y5VeTqnEZnma9Z',NULL,'71.6.232.30','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaDEwcHdaVDNrdDdBdXNiWUVIV2RJZGlwc2dpNlJrNnFKM21DSkpaSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765194899),
('nb9v6vmzJgILckHPWGja4xppJ4XbMH8nu9ppTgCe',NULL,'5.187.35.158','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiZ3VsaWRRWlRMcmxUdUZORGNOcHY1QVphVXFaTFBZSGtHZnFjaWJaSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765458564),
('NgTKCjXOKfF6syOGV7zJka0gKcIgaJAfjOMIto0t',NULL,'204.76.203.8','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRUZxQmQ2dWJFOXBuR3FvSjZqR3RIT21haWI4ZGl4VGk4b0w5bmxDVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765484563),
('NJNES9CHrmUBK3tLE80nMHYLjBcPQ4zyTVv4hs8X',NULL,'5.187.35.158','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoicEN5M21DcmVyc1VsZ3RySjJUNnQ0WUd1OTdLbjJ0cG45VUZoSXpFcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765203070),
('nnG7huUeldrbc8GW3IkhbXnvGuYpCyGhlY52Kcdm',NULL,'45.156.87.46','','YTozOntzOjY6Il90b2tlbiI7czo0MDoic2czVERQMnFBaE9GeFpaODJDajJHRHpmRUlHTEcwc0pabFFlVXNNRCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765338040),
('novJxv4Bjd2k5k4iP6fjjvXoKsg7blG1FR9GUlUR',NULL,'93.174.93.12','Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; MDA Pro/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiM2t1dGtzOVU3U2EwRVFVWWhTc245NFJWRjJzeFhyVzBmdWs0VVlMRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765299008),
('nZpHLEN2sz5v9AbRMgiym0CpxCU6DC1NL27BuPZN',NULL,'172.105.246.139','curl/7.54.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoid21DTXZlVXJJV01KYzN3dDVIZVc3eHZIelYyNFYwQVVrNFlFMUVraCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly92cHMtNDliYTliYzcudnBzLm92aC5uZXQiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765311782),
('NZRbrOsu4MqvSXe1d93nXtDmmVbVrb6fHj3jfNkF',NULL,'198.235.24.173','Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTHFtOWs1SUhuVXNlT2pQYU5DdVJjOEVLSG1BaXFIc0hhZzA5MEdBQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765237853),
('o1d0xXfnZWpxmWVmktL2wVKBPMvAXCKBtxfnQnAr',NULL,'89.42.231.241','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiTXVuRDltd1FhUzY4NHBzYk16UmRlYzhUQWgwVlNraVhtR3dLR0JuOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765469548),
('O999PrqeQ3akQTsT8eiYEZZyDibYuOXl8sGYLxFg',NULL,'141.98.11.140','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYlFTbklMVEhQeUEwOEFORjNQUFpBSWlmYjZBVUcyN1BBSFpMWkNpeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765333718),
('OHPK5raGITUNB5TOPxIAkKhUL31rTgntU8I0hZuc',NULL,'2.59.157.54','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVmRUVUZzejZjT1FIUFpFd2VDSUNxdHZrbkJNNEhOYTROa1I1WDlOcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765485359),
('OiM8tM4lc1Wh3tYf69JadJu78Xev1rlckqyX0Ig9',NULL,'184.105.247.252','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.56','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSXM5WHAweldTSnJpYlVJU0NKb3RLRkI0bTRQZWNsa0IxTTA0WWFCYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765238530),
('OvLwXCdnyrDALzNF33W6YfV4PCFnv6ZqjoTom9GF',NULL,'37.120.93.147','Mozilla','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTTQ3U2ppeWtzcmlUbHRwZGJEb2hROThKSmY1OE1DekNidGR2cG44aiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765212023),
('P9ubDAzLdkEQidTinK7ujC1fJchOPUbIKPMpg8JC',NULL,'172.105.246.139','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2RsbVl2RTZEZ3VQS3VzZHBoOEozaU1HMmVydWZ0ZFJpMDk3VmdkdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765311781),
('Pe8RaygyBjFvZ91jhlyGFfxaBfR2PklpZ0RlBPtq',NULL,'5.187.35.158','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiZmx2c3NJazNpd3RSUUNIVVRWTTlLMW1FTm9VMk9iVzBDakJVMG1HZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765418634),
('pLfLRKVtJQ4sIyO4c2dN0EESNOYzBPvogOgR1QqD',NULL,'167.94.138.166','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQWk5VzlnZmJkc1NZQ3dNMW1ZaElJYmZWR2hoWFlXd2pYS2l5c3NaVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765223589),
('PW0Ssr3FTw5lgRNWOHWDdsB7yHYg5GYi9rT8QTz1',NULL,'2a06:4883:3000::29','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSHJZcmhwV0J4WXVoMXJzekthSG1rblRMZGVnbUoxR3VQcDhLWWwzcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765293613),
('pwP2SWcPmbWpYYnfr1q1YArsPreSm5ZiPp2vqoCw',NULL,'221.13.86.57','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoid0t3engwMFkxYWFEZWdjalZDU1pOQTJEOExqbG5YYmlTRVZ3VFVRTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765196837),
('PWr6Pcf88wPxTcfF3gdCc8PbNRMcPxF72RkmRU5o',NULL,'172.105.246.139','curl/7.54.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoid1NMVjN0ZVdpVXNFZmxHT1hFeVJMc2Izd2ZtYmNoaEZoTXFHUkJIMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly92cHMtNDliYTliYzcudnBzLm92aC5uZXQvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765311781),
('q2S0YQtQDHOrfLGTWCOTBqbGzmYJ4Vx5bcynVy7a',NULL,'45.156.129.48','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQnQ2dnFHdnpCdDM2QnNhWkRhMDIyZ0JUODd4T3B0QlhSTm1qSWR3dCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765216857),
('Q9WQ09Ffmt9d4HZqWJ0SG7poJFhW7AHJUfMD8QSg',NULL,'137.184.70.191','Mozilla/5.0 zgrab/0.x','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWG5HZ09jc2pDcTBzU0JYNkRVV1QxUkk4NGtHZWxJZlJqTjkxdmVuTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765252992),
('qDEipjA990gDeOfdGsTd36YpnJgohHNY4GBVjFVa',NULL,'216.180.246.111','\'Mozilla/5.0 (compatible; GenomeCrawlerd/1.0; +https://www.nokia.com/genomecrawler)\'','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSnRCa1VraDdwOEtKMUtsYnNlbEFZNGxDTFdabXVaem5tZjNBZmw3SiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765420000),
('QEqHkPzthoq6aDor5g8vFoqs1e6GWlOq4wItA3A8',NULL,'176.65.148.246','Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoibHFqV094Z1k5NG9VREI0WVJNVGJVaUp1cVZjWEtpZGY2R2R0TWxJYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765295659),
('qiIyqfkbTC5x1rba1hBXaGDTYoWCEPDKM4iqRoLE',NULL,'34.140.92.201','python-requests/2.32.5','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOVFRWU5waDBkbERidU1PRjlyWmdtd1IxY1pnYnhtU0NlYXJiNGlGbCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765285505),
('qOj3YOFRTwXBPjtu1W7VXKx3IO2IjwV5cXL6PuR8',NULL,'169.197.85.173','python-requests/2.32.3','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMWNzWTk2RDJkdkkyT2pxZjU0Y1JmMmdVOXhicG9pSEdtUGtJa0VBbCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765429214),
('QWSluw0BXtAAPejv5E3NKAZV3Fl97m1LvoosFDoQ',NULL,'167.94.138.166','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSnRyTjRpS3pwYjE1a1NSdGxjYTF2NnA0OXJGODZmenJjSlBwTldNYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765223381),
('R0FQJoINEzVzUGVqwAhprDLWsD0LPpdXBq7Jv4TB',NULL,'79.124.40.174','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXlZVGczODB0ZE51SzFqc2lZZjlDakVmRUNVMFlzeVdxemhJVFZuSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765465149),
('rjvYQWXseA8u4WHnhEpfkfE6l7POW8Ru3G6OP5Fa',NULL,'172.105.246.139','curl/7.54.0','YToyOntzOjY6Il90b2tlbiI7czo0MDoiSDFOcXo1VnBNaFlHTzllbmYxQkNPTXBFYjZoQzR0c1FjQ2Q0b0ZkTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765311782),
('RRRmhjHBDNpccQ9DVSUFrVaYdtmOAAlOMlZWj2Zg',NULL,'79.124.40.174','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZkEwMDFjQzhxRHpHMmFyVTlRSFoza2JMNms4NUdIcHExb0ZDRTNESCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxLz9YREVCVUdfU0VTU0lPTl9TVEFSVD1waHBzdG9ybSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765465149),
('S0KK1YzJo3NQqxxLy3eCA67FuZGNLrvu5OJJHMP8',NULL,'40.76.99.43','Mozilla/5.0 zgrab/0.x','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVTdETEFsbTlkQ2NmQUx6MTY2enZiNGlmS21rRlN5amNIYUNibXBFZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765312524),
('SFUavQcuKrin7P13XHasg6Hx2x76o9IDbp5ZofJQ',NULL,'216.180.246.111','\'Mozilla/5.0 (compatible; GenomeCrawlerd/1.0; +https://www.nokia.com/genomecrawler)\'','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNjBGbWVyaDZ5TVN0T1NSS0ZENHowVEZPTFRZdjlCUlZybm45VmtTdCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765419979),
('SQdaCAtXXFytHkO3uudbFrT9FwH9JfY44VDJY25c',NULL,'66.132.153.125','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVDRJRlVWa2w4elVOZ2ZCOXZOMXZlTFY5cklSVWVPUVhrVTMyUUNSYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765460046),
('T8S9j6KvqXVyfCGzbaXVmOY6UbDqXzH8s4g4xAc3',NULL,'216.180.246.198','\'Mozilla/5.0 (compatible; GenomeCrawlerd/1.0; +https://www.nokia.com/genomecrawler)\'','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYlE0UFRneWVIZWFTZXJtckxWNWVUQmhsbnY2SWJyR1N4SGhDN0RqMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765269452),
('ThhCIiZDFLLOGyvIFO0zySv359rBGcE2HRlZNIn7',NULL,'165.22.61.50','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.5615.137 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGt1OFAxQkFVbTBBeVNGZDJodnY3VEEzcnl1elBkQzVoUkJidU95diI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765294193),
('TKBWRU32M9KfSRQ3iUQf8O2yYejvBELeqmrA4YUo',NULL,'221.13.86.57','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGU5UWIwOTJnNTl6TUtzZlEzekFWWU1UeGxDS1VES1VhRGxsTHQ1WSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765196836),
('TlovT6VXq4mGtLbl2oumBJYRBb8yrx70IeSJz4SB',NULL,'194.187.176.43','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:65.0) Gecko/20100101 Firefox/65.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoidjdqaFhCdnQ2bXc4NFZ0ZTNNT2xqblRPaXY2Q2xRbVM5QW42Mlc0WiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765450426),
('tNzAUwVEgCpb4p0hQ3ea79lxykigLBwd3irCp02e',NULL,'167.94.138.32','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiN1JvYXEzWWZpU2NLUmdrVXVIcVVqSkNKV0J4dHNQV0MyWEoySWVjNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765429766),
('TQTymuiUxIU4VtEVuT7RiEInpv72126tmNwttQxN',NULL,'3.131.215.38','cypex.ai/scanning Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoieXU0NDZsZE51bmNKZ1VjdVN1am5MNUJGUEpmcGlUUjlaOEVtbzdMMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765341362),
('TY3bUa2vxlF1b16wtdPPyOr0BsZUw8rzdUFHvM5s',NULL,'172.105.246.139','curl/7.54.0','YToyOntzOjY6Il90b2tlbiI7czo0MDoiRUJ3Mkh0S29WQlQzWHdaejFsWlYxdFQyRlVDMnlpaHZESndueUxwSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765311782),
('Tz2ugxcwrNcYQhkBXn2B0LQQCL0suHG9AQyvABaI',NULL,'3.137.73.221','cypex.ai/scanning Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoicmdldG1kd2VhMDBxMDF2amlIMDdNRERWbmxSeGtzalJaWDJIOUV2TSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765256561),
('U5Is6yXGqODHT3e1NI2PxhWYhw0Z39bcKMIcV7qW',NULL,'216.180.246.198','\'Mozilla/5.0 (compatible; GenomeCrawlerd/1.0; +https://www.nokia.com/genomecrawler)\'','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ3ROUDNZRWxiVjk5NkZjT2trVHBZaVNxeHdHRW9XdGpnMzN1dVVoUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765269301),
('UHUk5HlFSj5s8SAAGfw1CtajN1t8bEuvhdG5GHxo',NULL,'147.185.133.1','Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity','YTozOntzOjY6Il90b2tlbiI7czo0MDoibVdsSzlmYjZYcE40Y2hQd081TVBPakVhRGQ5Ynpad1ZaaUMwWG9ZOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765266562),
('UJkt3byqjwxdzbh47ib8loEo09i1lj95ZHLPt7oT',NULL,'195.184.76.123','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQUJKVDNpWEJucThlaW5wckVYajhmTDZxa0FabWwzU2FTOTg0UmxOOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765191490),
('uJwE5lRuN9wX6W3vrFTHEuortJsZLmtz8w1wVEck',NULL,'45.156.129.57','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZThHczFUN09qYnFpakRha1IyS0VhMVBrY1BoODNRYld1YzdGMDBVQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765435445),
('ulBTerZ1Bs256zfjQMqrz3l4gpgUmrQePm7GHGau',NULL,'5.187.35.158','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiMTlHN1ZnaXRXUlhqYW5TbGxGZDhmUlJQeWNLakFmVnNOdDNZSjRxVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765309763),
('UtH5DgZDKXWgoBRs2YeECpW8rzPjyoLVKf7U2nmC',NULL,'185.247.137.159','Mozilla/5.0 (compatible; InternetMeasurement/1.0; +https://internet-measurement.com/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZkxsV3h3VUs1Y0IyREJDdjJNQk01Q2hhUGl2R00wNHI3ZG51cFkxQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765309237),
('UUb2mC55SyanDBCcUsa1aTcYk42bsParFy4wSoQt',NULL,'172.105.246.139','curl/7.54.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSG9qcjdIbUlmTHpDN29RTHhtZEt2RXUwbks1aXg2NFhaS0MyQTh3VSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly92cHMtNDliYTliYzcudnBzLm92aC5uZXQvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765311782),
('UuxSptrzIIo7Cd53BzNyQppji1PdI4jSbWMRhQj0',NULL,'185.180.140.131','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoieWJWVDhGZDNSMnZHWnhuTlJyc1A1cXRpNXhuMlZnejRSZWY5aDM0TyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765302673),
('vajOxulGiuuQbd3Y0tGvCpqI3GkTj38WrSHjc4S2',NULL,'71.6.199.87','Mozilla/5.0 zgrab/0.x','YTozOntzOjY6Il90b2tlbiI7czo0MDoiS2o1bEFBV1p3S1pWeU5NZVc0bjNNOW11Q0JiY1V4czVJckdRazVDQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765338377),
('VcVKUsYlQ0N09gOeWMgYSQbk4N2KhGxceoKiz71i',NULL,'45.156.129.52','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYWdHM1hzZk9IWnJaOVBPZFhHMDlHaEdlM2tDQWhZdFFucWFHUHVJViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765426223),
('Vi7u4g1ayKEOemVJNV1EQxFaAqT5EMqkeibICB0w',NULL,'45.140.19.64','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNTIyTXY5M3FIWnBuNmN3VThSSVRDRlBiaDhSRzkxYW12dHhKWU5VdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765225112),
('vMNuotqjsJESNkvrdXlbUYSkA4Hly0j1yC6D8EVl',NULL,'205.210.31.234','Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGVyTzAzZmR1YXRKbUZ3Q2swa21nakxiWllVSDFyMEJoNUxQNjFPZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765320138),
('wdSRpnv3PKvaT9Dcuwla0VRlqSJKHw74LAa19sf7',NULL,'172.105.246.139','curl/7.54.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoic2JTR3RnZ0N4NlR6Z3dNc2hpVVgyRkhJaVRBT29Tb0phQUkzdVBRNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly92cHMtNDliYTliYzcudnBzLm92aC5uZXQvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765311782),
('wfbPfChcbkDmPqrIf1fe0F8l9wAk5SGbsApAuehj',NULL,'103.137.36.101','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/601.7.7 (KHTML, like Gecko) Version/9.1.2 Safari/601.7.7','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUUp3d3NINWF2VXJrbWt4dE1TY1lJVW4yQmRMMXhmSlBrRUN1MWJBaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765292091),
('wjjjze5Ppoagzalz9YNzgXk2MnpezC1b5hH4IqV2',NULL,'195.226.207.13','Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYXp5bXVocklMMTJCYlVwVDdwRE5XMWlEeDJWNnVwU0FFd1ZMVEVNbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765245076),
('WtR9mzmGq4LBaB2r2WfSc8sZtEspkc1FrsqTd6dS',NULL,'185.180.140.131','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoibHRveTUzM2NYR3RpWkRlbmFOcUdSc216S0Z6N0xockJ0VUppV2dPNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765302673),
('wTwhxvBfMwCvfWz8ZXCyZn7ZJSQdPU1Xg2V0EXPw',NULL,'45.140.19.64','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1B4NGt2TUd4eWIwWWRUa3V1ekNQMGEwZU8wTUd0MWZab3F0c3ptbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765225112),
('wuSahFsXhekFJwo1iM0Nkzcmj58oMBzBnU0rRW5s',NULL,'100.24.34.255','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiU0ZPeE0wOGxOemhDRVdkT3RYNjBEMkkwWGFqYVlnaVZlM3B0ckZDdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765297049),
('x4A0JAreJX8BBlc76Q5NV3qUtek6HVuSUSOhIm0p',NULL,'172.105.246.139','','YTozOntzOjY6Il90b2tlbiI7czo0MDoibGxxWjJZOFp6THZGQjFYYmdsSDNxUXVhZ0Y0N2gyWTc0b0hKMTl0ciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly92cHMtNDliYTliYzcudnBzLm92aC5uZXQiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765311792),
('xbCabDjHBlmsOllErFI9XLaPEZRNFa8xX4Zp8uRR',NULL,'87.236.176.122','Mozilla/5.0 (compatible; InternetMeasurement/1.0; +https://internet-measurement.com/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaUxSaWNUTm53ekhpYXVHaWN0R1ZFd2k1Y25NTXlGRkRUQ0RUREdwUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly92cHMtNDliYTliYzcudnBzLm92aC5uZXQvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765329941),
('XdHfJaPXErkzdAyTQ1jnU2xdW64QGtDUVynF26uJ',NULL,'5.187.35.158','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoieEx6NEZtdDNCS3U5NEdXeFdXWXZrdWhJblNIczVBS2hndlc1QnBobCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765226477),
('xEfDU0Nn0D3vLKU7g72OQWcG1NlM6Tkh4YS8eSzq',NULL,'141.98.11.98','Go-http-client/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSktQTjdJNHJZVVJBT0VyY2RWdmNPV09iZ1ZXQzZvSUJpVFNkeTBYRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765330481),
('XjI3J6DbCHB2CrILm58ea8NAaN4qy5X2KHqept5E',NULL,'167.99.223.83','Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVJNZ2pKTWZLSnd6bEt0bGxaRkhrRnNCY3V2NGxDck5Zb3IwR2Q3eSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765481534),
('XJqPd1OY0CS1zcw82H2knq4YadGy10G33RysREcp',NULL,'5.187.35.158','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiZnZqa0ZLeTJHNjFKcTByNUt4WHVsT05uVU50c3poR3F5eFh5U2p2ciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765424223),
('XnEacgYCcYq3qfYv9M19yrouJgSUKcBKuxSnQxoW',NULL,'167.94.138.61','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoicFhIdDh4RkladFV0dHBsNDR1QXlLdXp1a2tuTzYweTJMZ05qZHZuZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765266641),
('xptTIIeaXHzAsqbB1WAGuMg2YSAjBTWplJlzPIGP',NULL,'176.65.132.67','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTVVBN2wwaVlGMUxrbGEzZzBHQ0Z2WFBzMHQwVUhMUGRhelVLakVSSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765481567),
('xqK87sKlLlJ1Ue3b7IHtE4ofapJ7QcoDFBa9DqYv',NULL,'20.171.8.149','Mozilla/5.0 zgrab/0.x','YTozOntzOjY6Il90b2tlbiI7czo0MDoieUFydFc2c21GQkd2ZnNpQklseFM0WGFKaHJNVFdHMEtYV0txRmdtZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765239859),
('Y0qyHZD09scWFNRPVRdi1oOTJ1DNY6tVbWHln8aC',NULL,'128.14.227.179','libredtail-http','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMTRHTVlvdjhqc0RBN2pySEIzRVRWeVBwcXlENGJLMm9jaUdYdzVISiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTQ2OiJodHRwOi8vNTcuMTMxLjMzLjI1MS9pbmRleC5waHA/ZnVuY3Rpb249Y2FsbF91c2VyX2Z1bmNfYXJyYXkmcz0lMkZpbmRleCUyRiU1Q3RoaW5rJTVDYXBwJTJGaW52b2tlZnVuY3Rpb24mdmFycyU1QjAlNUQ9bWQ1JnZhcnMlNUIxJTVEJTVCMCU1RD1IZWxsbyI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765257509),
('ycKW6uJRizJaz4QqbgKOTdRcNd0aLpm8C6Ejp1Bv',NULL,'45.156.129.46','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYzI1RTM3MmNaOTM4NnFvc0xkd0ZNQXBkOVRSUHFjTE52ZFo0VVNwYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765446156),
('ydoc3apTOWEiuNXWkPHkgw7MLuGp3rlswnfxozFb',NULL,'167.94.138.61','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnZvTWZjcEJJa1luN2tyTGFyZFFSSmZVVlY1YXBtTENBMWdNY3h5QyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765266645),
('yFDENelF5SREWgI6W6gAyIqmc67Q3oXIVse4o2eP',NULL,'91.224.92.109','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiMllBTDFwUjV2NFg0YWZjc0R3UWx0SEduMmJXNkJoVjdiSVlQRU1kNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765191256),
('yJCxDca7dWUwXKUlj8Xz2wWCebjMYmjbAxADHC2q',NULL,'142.93.226.62','Mozilla/5.0 (compatible; Nmap Scripting Engine; https://nmap.org/book/nse.html)','YTozOntzOjY6Il90b2tlbiI7czo0MDoieDBGNjhweXNhUjQ1QTFpNlZEQlpDbndlRzVuVExZQm1MUnBCbjhpViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly92cHMtNDliYTliYzcudnBzLm92aC5uZXQvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765260613),
('yjcyENznGrCU2L56DYtL57qJ7W9qqzVxEP3kpRyS',NULL,'5.187.35.158','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoiZG9pSVo3bnJOQlZxdHB4YWJ0VUpJQjE2c3I1Q1lhdFFtQldlYlNleSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765286849),
('Ykq5s2z8Kbfy0ZOvzBWKfEmxRYHeahe0dt7zmm1L',NULL,'172.105.246.139','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTDhKTlJQTlc3RmptZGliYlpTSTN3bUYxMmhuNXVMZThiYU1yZmNSaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly8xMjcuMC4xLjEiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765311792),
('yQVoCbRz4QQibisxALibL25J7GW4z8MbjRWexlvl',NULL,'35.187.31.145','python-requests/2.32.5','YTozOntzOjY6Il90b2tlbiI7czo0MDoiU3NnMVdyd2d2THR0VUZVN25EbkpEMzBHbGJxN3J2UFNGNlVuMkw0ZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765427702),
('zAu8527eL1lkOD0yPHX8tcseeFfJ8jI8uPOAFf2B',NULL,'161.35.50.176','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoidFB3dmhWcFhUN3lzYkt6Uzk1Y2ZIM0ExdklTU3B3RUNMeExkSXBnOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765441798),
('zdU0o8SuG61QYsUn8reD71RayS2mx6c3UYBUbkxz',NULL,'89.42.231.241','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46','YToyOntzOjY6Il90b2tlbiI7czo0MDoib2ZscWpZcVQ1OUF2QnVON25iMEFyY3ZKVVNHaUJ2bm5WdkN0YkJVcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765480380),
('ZEqoyxAdj3SMdG9ij90e8tT28MBVTHsEpnS9Llez',NULL,'45.156.128.45','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiY2ZNQU9HbnFVME5GUHVVTG1HYW5HWTA1OTRMVWZaTlV2eG11eHgxaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765473606),
('Zi7cR5EoOoFdQUL5XhPXDHqb1jxpf6uqf00flQPD',NULL,'165.154.11.210','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11','YTozOntzOjY6Il90b2tlbiI7czo0MDoibUQ2RmF4SWlWUlVpTDJGSTlFcWdNVW1oM2liZFhkdXBUWDA1Y2xnWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765330490),
('ZIxq7k2r6STILKEOZGLao1qY0ASi0XhVcxQVO68L',NULL,'167.94.138.61','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoieEw3NkNpU1VxOWw4RkdZSENOR2pnd3licWx4YkF4ZlQwSjJpVGJxaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765266663),
('Zjuhdeb0tZIedwBrOy7We1la4HrF7uEKjZZjb8zf',NULL,'165.154.11.210','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Edg/120.0.0.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZlJHcWlFVUNUME16dUdRMzlhY2F0aXRKVDg4UlA0MjJ6bWlRRG9ibSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765330485),
('ZMMZKFYn7dvebE0msgGdlX3gAoZtf2cZwivURqBF',NULL,'141.98.11.140','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNUtucGJ3WEhFRU5rRlpRREFrVE12OHdUazcyODZWV0ZPUGI2SEFWdCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1765303307),
('ZquQUSqTD5Qmo14nL0gIvX6qnKGoYNb7GDNVH4M1',NULL,'79.124.40.174','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiU3lmbGNzZ3NRb3pRS3phUUxuekNjWmlSZmN6UWJ1czdjWUNiMG1LciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxLz9YREVCVUdfU0VTU0lPTl9TVEFSVD1waHBzdG9ybSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765190967),
('zwcu62nclmiJu4jO8IOLuTvwKgxXx5lB7cb7sWpr',NULL,'216.180.246.111','\'Mozilla/5.0 (compatible; GenomeCrawlerd/1.0; +https://www.nokia.com/genomecrawler)\'','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYnNsTUNNNUhFcFpPeERwcHRqaDQ1TU1Ja20xZ2xjUkl0SUpuN05pdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765420124),
('Zwd3FcIIjj9M9zciJigB348WcgUQTpdyy5X7LKWG',NULL,'195.184.76.119','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoieW9SbFhCNzIwQnhvMnUwY2ZMcmt4dURVTDF4OEx1anpEeFNJbE85eiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765191610),
('zWs8FdT6G0SFk0Ff4MRvuj6EPPb40uB750TyE96U',NULL,'185.180.140.10','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoibklWWUp2bkxjUWNWbmVqRjF1TzFpVG5VcURyd2ltbENieFNCNmM2ZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly81Ny4xMzEuMzMuMjUxL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1765303831);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','operator','trabajador') DEFAULT 'operator',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(2,'Administrador','admin@elecciones.com','admin',NULL,'$2y$12$qfY5NlGaax1MufoRbEVQ1.u4GxecIrFDoF52CZWeicJzk6JAMQ0j2','CYGwDmqSKmcuP1VvnaG7Gpd7a2jqx4L1vUUGR9NQCSll2gOsDqPsFuMXdvcQ','2025-12-05 23:15:36','2025-12-05 23:15:36'),
(3,'Pedro Gonzales','pedro@gmail.com','trabajador',NULL,'$2y$12$2yaI.EOVd0jyjoqocKWkCeTxAMmKNO7sW1i9dsk6bYnw0KL8mivb.',NULL,'2025-12-06 23:58:42','2025-12-06 23:58:42'),
(4,'maria','maria@gmail.com','trabajador',NULL,'$2y$12$krOo6plwaeylzvtNwe3LJeCJSn3K/t1iDgM/LnpmuQMddbWTDS6PO',NULL,'2025-12-07 00:05:48','2025-12-07 00:05:48'),
(5,'Prueba','prueba@gmail.com','trabajador',NULL,'$2y$12$blc/coL8pvw0oteIyqCLl.BgRTivMonHwd2kiJejPYecdBZrvScfK',NULL,'2025-12-09 19:12:43','2025-12-09 19:12:43');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voters`
--

DROP TABLE IF EXISTS `voters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `voters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `cedula` varchar(255) NOT NULL,
  `departamento` varchar(255) DEFAULT NULL,
  `municipio` varchar(255) DEFAULT NULL,
  `puesto_votacion` varchar(255) DEFAULT NULL,
  `direccion_puesto` text DEFAULT NULL,
  `mesa` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `voters_cedula_unique` (`cedula`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voters`
--

LOCK TABLES `voters` WRITE;
/*!40000 ALTER TABLE `voters` DISABLE KEYS */;
INSERT INTO `voters` VALUES
(1,'pedro','gonzales','1098602532','BOLIVAR','CARTAGENA','UNIV. TECNOLG. DE BOLIVAR - MA','ROOM 215. CITY HALL PHILADELPHIA PA','33','04241956747',NULL,'activo','2025-12-06 19:42:10','2025-12-06 19:42:10'),
(2,'pedrito','lopez','1098602534','SANTANDER','BUCARAMANGA','IE CENTRO PILOTO SIMON BOLIVAR','ROOM 215. CITY HALL PHILADELPHIA PA','18','04241956747',NULL,'activo','2025-12-06 19:48:43','2025-12-06 19:48:43');
/*!40000 ALTER TABLE `voters` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-11 20:42:16
