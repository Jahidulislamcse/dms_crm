SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `reminders`;
DROP TABLE IF EXISTS `reminder_templates`;
DROP TABLE IF EXISTS `requisition_team`;
DROP TABLE IF EXISTS `requisition_items`;
DROP TABLE IF EXISTS `requisitions`;
DROP TABLE IF EXISTS `target_deals`;
DROP TABLE IF EXISTS `target_items`;
DROP TABLE IF EXISTS `targets`;
DROP TABLE IF EXISTS `notifications`;
DROP TABLE IF EXISTS `worklogs`;
DROP TABLE IF EXISTS `content_posts`;
DROP TABLE IF EXISTS `meeting_attendees`;
DROP TABLE IF EXISTS `meetings`;
DROP TABLE IF EXISTS `expenses`;
DROP TABLE IF EXISTS `expense_categories`;
DROP TABLE IF EXISTS `invoice_items`;
DROP TABLE IF EXISTS `invoices`;
DROP TABLE IF EXISTS `task_approval_comments`;
DROP TABLE IF EXISTS `task_progresses`;
DROP TABLE IF EXISTS `tasks`;
DROP TABLE IF EXISTS `custom_statuses`;
DROP TABLE IF EXISTS `lead_timelines`;
DROP TABLE IF EXISTS `lead_requirements`;
DROP TABLE IF EXISTS `leads`;
DROP TABLE IF EXISTS `lead_stages`;
DROP TABLE IF EXISTS `client_services`;
DROP TABLE IF EXISTS `clients`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('owner','sales','smm','designer','motion','seo','developer') NOT NULL DEFAULT 'sales',
  `color` varchar(20) NOT NULL DEFAULT '#64748b',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `base_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(255) NOT NULL DEFAULT 'month',
  `description` text,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `assigned_smm` bigint unsigned DEFAULT NULL,
  `assigned_sales` bigint unsigned DEFAULT NULL,
  `status` enum('active','inactive','onboarding','paused') NOT NULL DEFAULT 'active',
  `billing_cycle` enum('monthly','quarterly','one-time') NOT NULL DEFAULT 'monthly',
  `advance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` text,
  `satisfaction_score` tinyint DEFAULT NULL,
  `onboarded_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clients_assigned_smm_foreign` (`assigned_smm`),
  KEY `clients_assigned_sales_foreign` (`assigned_sales`),
  CONSTRAINT `clients_assigned_sales_foreign` FOREIGN KEY (`assigned_sales`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `clients_assigned_smm_foreign` FOREIGN KEY (`assigned_smm`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `client_services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `service_id` bigint unsigned NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `qty` int NOT NULL DEFAULT 1,
  `custom_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_services_client_id_foreign` (`client_id`),
  KEY `client_services_service_id_foreign` (`service_id`),
  CONSTRAINT `client_services_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `client_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `lead_stages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(20) NOT NULL DEFAULT '#64748b',
  `order` int NOT NULL DEFAULT 0,
  `is_won` tinyint(1) NOT NULL DEFAULT 0,
  `is_lost` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `leads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `source` varchar(255) NOT NULL DEFAULT 'Website',
  `stage_id` bigint unsigned NOT NULL,
  `assigned_to` bigint unsigned NOT NULL,
  `created_by` bigint unsigned NOT NULL,
  `budget` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` text,
  `next_followup` date DEFAULT NULL,
  `converted_client_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leads_stage_id_foreign` (`stage_id`),
  KEY `leads_assigned_to_foreign` (`assigned_to`),
  KEY `leads_created_by_foreign` (`created_by`),
  KEY `leads_converted_client_id_foreign` (`converted_client_id`),
  CONSTRAINT `leads_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  CONSTRAINT `leads_converted_client_id_foreign` FOREIGN KEY (`converted_client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  CONSTRAINT `leads_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `leads_stage_id_foreign` FOREIGN KEY (`stage_id`) REFERENCES `lead_stages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `lead_requirements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` bigint unsigned NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `qty` int NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lead_requirements_lead_id_foreign` (`lead_id`),
  CONSTRAINT `lead_requirements_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `lead_timelines` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'note',
  `text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lead_timelines_lead_id_foreign` (`lead_id`),
  KEY `lead_timelines_user_id_foreign` (`user_id`),
  CONSTRAINT `lead_timelines_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lead_timelines_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `custom_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(20) NOT NULL DEFAULT '#64748b',
  `order` int NOT NULL DEFAULT 0,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `core_status` enum('pending','in_progress','done_pending_review','done') NOT NULL DEFAULT 'in_progress',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `custom_statuses_client_id_foreign` (`client_id`),
  CONSTRAINT `custom_statuses_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `assigned_to` bigint unsigned NOT NULL,
  `assigned_by` bigint unsigned NOT NULL,
  `service_id` bigint unsigned DEFAULT NULL,
  `parent_task_id` bigint unsigned DEFAULT NULL,
  `custom_status_id` bigint unsigned DEFAULT NULL,
  `status` enum('pending','in_progress','done_pending_review','done') NOT NULL DEFAULT 'pending',
  `priority` enum('high','medium','low') NOT NULL DEFAULT 'medium',
  `approval_status` enum('pending','approved','revision') DEFAULT NULL,
  `notes` text,
  `deadline` date DEFAULT NULL,
  `scheduled_date` date DEFAULT NULL,
  `estimated_hours` decimal(5,2) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `recurring_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `recurring_type` enum('daily','weekly','monthly') DEFAULT NULL,
  `recurring_interval` int NOT NULL DEFAULT 1,
  `recurring_end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_client_id_foreign` (`client_id`),
  KEY `tasks_assigned_to_foreign` (`assigned_to`),
  KEY `tasks_assigned_by_foreign` (`assigned_by`),
  KEY `tasks_service_id_foreign` (`service_id`),
  KEY `tasks_parent_task_id_foreign` (`parent_task_id`),
  KEY `tasks_custom_status_id_foreign` (`custom_status_id`),
  CONSTRAINT `tasks_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`),
  CONSTRAINT `tasks_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  CONSTRAINT `tasks_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tasks_custom_status_id_foreign` FOREIGN KEY (`custom_status_id`) REFERENCES `custom_statuses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tasks_parent_task_id_foreign` FOREIGN KEY (`parent_task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tasks_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `task_progresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `task_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `note` text NOT NULL,
  `done` int DEFAULT NULL,
  `total` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_progresses_task_id_foreign` (`task_id`),
  KEY `task_progresses_user_id_foreign` (`user_id`),
  CONSTRAINT `task_progresses_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `task_progresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `task_approval_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `task_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_approval_comments_task_id_foreign` (`task_id`),
  KEY `task_approval_comments_user_id_foreign` (`user_id`),
  CONSTRAINT `task_approval_comments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `task_approval_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(255) NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `advance_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('paid','partial','unpaid','cancelled') NOT NULL DEFAULT 'unpaid',
  `notes` text,
  `issued_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  KEY `invoices_client_id_foreign` (`client_id`),
  KEY `invoices_created_by_foreign` (`created_by`),
  CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `invoice_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint unsigned NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `qty` int NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `expense_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(20) NOT NULL DEFAULT '#64748b',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `category_id` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cash',
  `notes` text,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_category_id_foreign` (`category_id`),
  KEY `expenses_created_by_foreign` (`created_by`),
  CONSTRAINT `expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `expense_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `expenses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `meetings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned DEFAULT NULL,
  `lead_id` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `agenda` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time DEFAULT NULL,
  `duration` int NOT NULL DEFAULT 60,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('scheduled','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `outcome` text,
  `next_action` text,
  `next_followup` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meetings_client_id_foreign` (`client_id`),
  KEY `meetings_lead_id_foreign` (`lead_id`),
  KEY `meetings_created_by_foreign` (`created_by`),
  CONSTRAINT `meetings_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  CONSTRAINT `meetings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `meetings_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `meeting_attendees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meeting_attendees_meeting_id_foreign` (`meeting_id`),
  KEY `meeting_attendees_user_id_foreign` (`user_id`),
  CONSTRAINT `meeting_attendees_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `meeting_attendees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `content_posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `assigned_to` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `platform` enum('facebook','instagram','linkedin','twitter','tiktok','youtube','other') NOT NULL DEFAULT 'facebook',
  `post_type` varchar(255) NOT NULL DEFAULT 'image',
  `date` date NOT NULL,
  `status` enum('pending','scheduled','in_progress','done','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text,
  `brief` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `content_posts_client_id_foreign` (`client_id`),
  KEY `content_posts_assigned_to_foreign` (`assigned_to`),
  KEY `content_posts_created_by_foreign` (`created_by`),
  CONSTRAINT `content_posts_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `content_posts_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `content_posts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `worklogs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `task_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `qty_done` int NOT NULL DEFAULT 0,
  `qty_total` int NOT NULL DEFAULT 0,
  `quality_rating` tinyint DEFAULT NULL,
  `smm_feedback` text,
  `status` enum('pending','approved','revision') NOT NULL DEFAULT 'pending',
  `date` date NOT NULL,
  `reviewed_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `worklogs_user_id_foreign` (`user_id`),
  KEY `worklogs_client_id_foreign` (`client_id`),
  KEY `worklogs_task_id_foreign` (`task_id`),
  KEY `worklogs_reviewed_by_foreign` (`reviewed_by`),
  CONSTRAINT `worklogs_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  CONSTRAINT `worklogs_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `worklogs_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE SET NULL,
  CONSTRAINT `worklogs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `icon` varchar(10) NOT NULL DEFAULT 'pin',
  `bg_color` varchar(20) NOT NULL DEFAULT '#dbeafe',
  `message` text NOT NULL,
  `is_admin_only` tinyint(1) NOT NULL DEFAULT 0,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `targets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned NOT NULL,
  `month` varchar(255) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `targets_user_id_foreign` (`user_id`),
  KEY `targets_created_by_foreign` (`created_by`),
  CONSTRAINT `targets_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `targets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `target_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `target_id` bigint unsigned NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `qty` int NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `target_items_target_id_foreign` (`target_id`),
  CONSTRAINT `target_items_target_id_foreign` FOREIGN KEY (`target_id`) REFERENCES `targets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `target_deals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `target_id` bigint unsigned NOT NULL,
  `target_item_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `service_name` varchar(255) NOT NULL,
  `qty` int NOT NULL DEFAULT 1,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `target_deals_target_id_foreign` (`target_id`),
  KEY `target_deals_target_item_id_foreign` (`target_item_id`),
  KEY `target_deals_client_id_foreign` (`client_id`),
  CONSTRAINT `target_deals_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  CONSTRAINT `target_deals_target_id_foreign` FOREIGN KEY (`target_id`) REFERENCES `targets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `target_deals_target_item_id_foreign` FOREIGN KEY (`target_item_id`) REFERENCES `target_items` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `requisitions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` bigint unsigned DEFAULT NULL,
  `submitted_by` bigint unsigned NOT NULL,
  `reviewed_by` bigint unsigned DEFAULT NULL,
  `assigned_smm` bigint unsigned DEFAULT NULL,
  `converted_client_id` bigint unsigned DEFAULT NULL,
  `client_name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `total_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `advance_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `billing_cycle` enum('monthly','quarterly','one-time') NOT NULL DEFAULT 'monthly',
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `special_notes` text,
  `admin_notes` text,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `requisitions_lead_id_foreign` (`lead_id`),
  KEY `requisitions_submitted_by_foreign` (`submitted_by`),
  KEY `requisitions_reviewed_by_foreign` (`reviewed_by`),
  KEY `requisitions_assigned_smm_foreign` (`assigned_smm`),
  KEY `requisitions_converted_client_id_foreign` (`converted_client_id`),
  CONSTRAINT `requisitions_assigned_smm_foreign` FOREIGN KEY (`assigned_smm`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `requisitions_converted_client_id_foreign` FOREIGN KEY (`converted_client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  CONSTRAINT `requisitions_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE SET NULL,
  CONSTRAINT `requisitions_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `requisitions_submitted_by_foreign` FOREIGN KEY (`submitted_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `requisition_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `requisition_id` bigint unsigned NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `qty` int NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `requisition_items_requisition_id_foreign` (`requisition_id`),
  CONSTRAINT `requisition_items_requisition_id_foreign` FOREIGN KEY (`requisition_id`) REFERENCES `requisitions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `requisition_team` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `requisition_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `requisition_team_requisition_id_foreign` (`requisition_id`),
  KEY `requisition_team_user_id_foreign` (`user_id`),
  CONSTRAINT `requisition_team_requisition_id_foreign` FOREIGN KEY (`requisition_id`) REFERENCES `requisitions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `requisition_team_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `reminder_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('email','whatsapp','sms') NOT NULL DEFAULT 'whatsapp',
  `body` text NOT NULL,
  `days_before` int NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `reminders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint unsigned NOT NULL,
  `template_id` bigint unsigned DEFAULT NULL,
  `sent_by` bigint unsigned NOT NULL,
  `channel` enum('email','whatsapp','sms','manual') NOT NULL DEFAULT 'whatsapp',
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reminders_invoice_id_foreign` (`invoice_id`),
  KEY `reminders_template_id_foreign` (`template_id`),
  KEY `reminders_sent_by_foreign` (`sent_by`),
  CONSTRAINT `reminders_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reminders_sent_by_foreign` FOREIGN KEY (`sent_by`) REFERENCES `users` (`id`),
  CONSTRAINT `reminders_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `reminder_templates` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2024_01_01_000001_create_users_table', 1),
('2024_01_01_000002_create_services_table', 1),
('2024_01_01_000003_create_clients_table', 1),
('2024_01_01_000004_create_leads_table', 1),
('2024_01_01_000005_create_tasks_table', 1),
('2024_01_01_000006_create_invoices_table', 1),
('2024_01_01_000007_create_meetings_content_table', 1),
('2024_01_01_000008_create_targets_requisitions_table', 1);

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `color`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Mehedi Hasan', 'admin', NULL, '$2y$10$K8XXJh9Naqjzlx6SZNim7.j066CK6NzpAK6NnTg8pf7DhkDLa/3aK', 'owner', '#f59e0b', 1, NOW(), NOW()),
(2, 'Rahim Uddin', 'rahim', NULL, '$2y$10$FfSrJYeW3T7mnWrNivnioOKRMoatPQKEX6lfYCY.wbIr7ImLX1wSS', 'sales', '#3b82f6', 1, NOW(), NOW()),
(3, 'Karim Sheikh', 'karim', NULL, '$2y$10$vZrIQrwJ6hp5KuQ.QRt5xO8RnufvVAEdB1PnVQTfapAbX7sFObTGW', 'sales', '#8b5cf6', 1, NOW(), NOW()),
(4, 'Rafi Ahmed', 'rafi', NULL, '$2y$10$1g7tihwKPmR9iAloQ5iRMOdq8gIiCifoxQtmRxVhQTeDgmtlbPJvS', 'designer', '#ec4899', 1, NOW(), NOW()),
(5, 'Nafi Islam', 'nafi', NULL, '$2y$10$y.PB4OiVk1r6EEu6H0DzsOUJyqnpxBYyWZRxD1MpztiplEuC3zUp.', 'motion', '#14b8a6', 1, NOW(), NOW()),
(6, 'Sara Begum', 'sara', NULL, '$2y$10$IHEB7QVw2SHGXXaeV6YJ4uRdvqp3s2Vpx.4cvKtDLgB.5.OlMIgYW', 'smm', '#f97316', 1, NOW(), NOW()),
(7, 'Tariq Hassan', 'tariq', NULL, '$2y$10$2UEolnffaV8Rn6XFcFw4W.LTw.bA6bQ0V8sh03PpV2GFMhv8rq5Pu', 'seo', '#10b981', 1, NOW(), NOW());

INSERT INTO `services` (`id`, `name`, `base_price`, `unit`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Social Media Management', 8000.00, 'month', 1, NOW(), NOW()),
(2, 'Social Media Design', 500.00, 'post', 1, NOW(), NOW()),
(3, 'SEO Package', 5000.00, 'month', 1, NOW(), NOW()),
(4, 'Website Design & Dev', 25000.00, 'project', 1, NOW(), NOW()),
(5, 'Motion Graphics', 2000.00, 'video', 1, NOW(), NOW()),
(6, 'Content Writing', 300.00, 'article', 1, NOW(), NOW()),
(7, 'Paid Ads Management', 5000.00, 'month', 1, NOW(), NOW()),
(8, 'Photography', 3000.00, 'session', 1, NOW(), NOW()),
(9, 'Video Production', 8000.00, 'video', 1, NOW(), NOW());

INSERT INTO `lead_stages` (`id`, `name`, `color`, `order`, `is_won`, `is_lost`, `created_at`, `updated_at`) VALUES
(1, 'New Lead', '#94a3b8', 1, 0, 0, NOW(), NOW()),
(2, 'Contacted', '#3b82f6', 2, 0, 0, NOW(), NOW()),
(3, 'Meeting Done', '#8b5cf6', 3, 0, 0, NOW(), NOW()),
(4, 'Proposal', '#f59e0b', 4, 0, 0, NOW(), NOW()),
(5, 'Negotiation', '#f97316', 5, 0, 0, NOW(), NOW()),
(6, 'Won', '#10b981', 6, 1, 0, NOW(), NOW()),
(7, 'Lost', '#ef4444', 7, 0, 1, NOW(), NOW());

INSERT INTO `expense_categories` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Office Rent', '#3b82f6', NOW(), NOW()),
(2, 'Utilities', '#8b5cf6', NOW(), NOW()),
(3, 'Software', '#ec4899', NOW(), NOW()),
(4, 'Marketing', '#f59e0b', NOW(), NOW()),
(5, 'Salaries', '#10b981', NOW(), NOW()),
(6, 'Equipment', '#f97316', NOW(), NOW()),
(7, 'Miscellaneous', '#64748b', NOW(), NOW());

INSERT INTO `custom_statuses` (`id`, `client_id`, `name`, `color`, `order`, `is_default`, `core_status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Pending', '#94a3b8', 1, 1, 'pending', NOW(), NOW()),
(2, NULL, 'In Progress', '#3b82f6', 2, 1, 'in_progress', NOW(), NOW()),
(3, NULL, 'Review', '#8b5cf6', 3, 1, 'done_pending_review', NOW(), NOW()),
(4, NULL, 'Done', '#10b981', 4, 1, 'done', NOW(), NOW());

INSERT INTO `reminder_templates` (`id`, `name`, `type`, `body`, `days_before`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Friendly Reminder', 'whatsapp', 'Assalamu Alaikum {{client_name}},\n\nThis is a friendly reminder that invoice {{invoice_number}} for {{amount}} is due on {{due_date}}.\n\nPlease arrange payment at your earliest convenience.\n\nThank you!\n{{company_name}}', 7, 1, NOW(), NOW()),
(2, 'Urgent Reminder', 'whatsapp', 'Dear {{client_name}},\n\nYour invoice {{invoice_number}} of {{amount}} was due on {{due_date}}.\n\nKindly clear the payment today to avoid service interruption.\n\n{{company_name}}', 1, 1, NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
