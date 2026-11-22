-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 22, 2026 at 03:32 AM
-- Server version: 8.4.3
-- PHP Version: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_rental_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int NOT NULL,
  `booking_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` int NOT NULL,
  `car_id` int NOT NULL,
  `pickup_date` datetime NOT NULL,
  `return_date` datetime NOT NULL,
  `pickup_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_days` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Confirmed','Rejected','Cancelled','Ongoing','Completed','Overdue') COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `special_requests` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `booking_number`, `customer_id`, `car_id`, `pickup_date`, `return_date`, `pickup_location`, `return_location`, `total_days`, `total_amount`, `status`, `special_requests`, `created_at`, `updated_at`) VALUES
(1, 'BK-20261101-001', 3, 1, '2026-11-10 09:00:00', '2026-11-13 09:00:00', 'Airport Station, Dhaka', 'Gulshan 2, Dhaka', 3, 150.00, 'Confirmed', 'Child safety seat needed', '2026-11-10 11:01:39', '2026-11-10 11:01:39'),
(2, 'BK-20261102-002', 4, 2, '2026-11-15 10:00:00', '2026-11-17 10:00:00', 'Uttara Sector 4', 'Uttara Sector 4', 2, 240.00, 'Pending', 'Require full tank gas', '2026-11-10 11:01:39', '2026-11-10 11:01:39'),
(3, 'DG20261110111CAD', 5, 3, '2026-11-11 00:00:00', '2026-12-11 00:00:00', 'dhaka', 'dhanmondi', 30, 7500.00, 'Pending', 'please go first', '2026-11-10 14:38:19', '2026-11-10 14:38:19'),
(4, 'DG20261121191610375', 8, 5, '2026-11-23 01:14:00', '2026-11-25 01:14:00', 'dhaka', 'dhanmondi', 2, 40000.00, 'Confirmed', 'Good condition!', '2026-11-21 19:16:10', '2026-11-21 19:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `booking_services`
--

CREATE TABLE `booking_services` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `service_id` int NOT NULL,
  `price_applied` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_services`
--

INSERT INTO `booking_services` (`id`, `booking_id`, `service_id`, `price_applied`) VALUES
(1, 1, 1, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int NOT NULL,
  `brand_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `logo`, `created_at`) VALUES
(1, 'Toyota', 'toyota_logo.png', '2026-11-10 11:01:39'),
(2, 'Honda', 'honda_logo.png', '2026-11-10 11:01:39'),
(3, 'BMW', 'bmw_logo.png', '2026-11-10 11:01:39'),
(4, 'Porsche', 'porsche_logo.png', '2026-11-21 08:56:51'),
(5, 'Bantly', 'bantly_logo.png', '2026-11-21 08:58:53'),
(7, 'Mercedes', '1795270152_mercedes_logo.png', '2026-11-21 14:09:12');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int NOT NULL,
  `category_id` int NOT NULL,
  `brand_id` int NOT NULL,
  `model_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_plate` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int NOT NULL,
  `seating_capacity` int NOT NULL,
  `fuel_type` enum('Petrol','Diesel','Hybrid','Electric') COLLATE utf8mb4_unicode_ci NOT NULL,
  `transmission` enum('Automatic','Manual') COLLATE utf8mb4_unicode_ci NOT NULL,
  `daily_rate` decimal(10,2) NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('available','rented','maintenance','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `category_id`, `brand_id`, `model_name`, `license_plate`, `year`, `seating_capacity`, `fuel_type`, `transmission`, `daily_rate`, `featured_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Corolla Axio', 'DHAKA-METRO-GA-11-2233', 2020, 5, 'Hybrid', 'Automatic', 50.00, 'corolla.jpg', 'available', '2026-11-10 11:01:39', '2026-11-10 11:01:39'),
(3, 3, 3, '5 Series 530i', 'DHAKA-METRO-CHA-99-0011', 2023, 5, 'Petrol', 'Automatic', 250.00, 'bmw5.jpg', 'available', '2026-11-10 11:01:39', '2026-11-10 11:01:39'),
(4, 1, 1, 'axio', '1234567', 1900, 8, 'Hybrid', 'Automatic', 5678.00, '1795250310_corolla_axio.jpg', 'rented', '2026-11-21 08:38:30', '2026-11-21 08:38:30'),
(5, 3, 5, 'bantly', '555-55', 2020, 4, 'Electric', 'Manual', 20000.00, '1795251696_bently.jpeg', 'available', '2026-11-21 09:01:36', '2026-11-21 09:01:36'),
(6, 3, 6, 'Mercedes-Benz ', '22-222', 2018, 4, 'Electric', 'Automatic', 30000.00, '1795269554_Mercedes GT AMG 63S.jpeg', 'available', '2026-11-21 13:59:14', '2026-11-21 13:59:14');

-- --------------------------------------------------------

--
-- Table structure for table `car_damage_reports`
--

CREATE TABLE `car_damage_reports` (
  `report_id` int NOT NULL,
  `booking_id` int NOT NULL,
  `staff_id` int NOT NULL,
  `pickup_time` datetime NOT NULL,
  `return_time` datetime DEFAULT NULL,
  `fuel_level_pickup` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fuel_level_return` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `damage_description` text COLLATE utf8mb4_unicode_ci,
  `repair_cost` decimal(10,2) DEFAULT '0.00',
  `status` enum('Pending','Inspected','Resolved') COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `car_damage_reports`
--

INSERT INTO `car_damage_reports` (`report_id`, `booking_id`, `staff_id`, `pickup_time`, `return_time`, `fuel_level_pickup`, `fuel_level_return`, `damage_description`, `repair_cost`, `status`, `created_at`) VALUES
(1, 1, 2, '2026-11-10 09:15:00', '2026-11-13 08:45:00', 'Full', 'Full', 'No new scratches or damage noted during return inspection.', 0.00, 'Resolved', '2026-11-10 11:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `car_images`
--

CREATE TABLE `car_images` (
  `image_id` int NOT NULL,
  `car_id` int NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_primary` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `car_images`
--

INSERT INTO `car_images` (`image_id`, `car_id`, `image_url`, `is_primary`, `created_at`) VALUES
(1, 1, 'corolla_front.jpg', 1, '2026-11-10 11:01:39'),
(2, 1, 'corolla_inside.jpg', 0, '2026-11-10 11:01:39'),
(3, 2, 'prado_front.jpg', 1, '2026-11-10 11:01:39'),
(4, 3, 'bmw_front.jpg', 1, '2026-11-10 11:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `category_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`, `created_at`) VALUES
(1, 'Sedan', 'Comfortable 4-door vehicles suitable for family and business travel', '2026-11-10 11:01:39'),
(2, 'SUV', 'Spacious Sports Utility Vehicles built for all terrains', '2026-11-10 11:01:39'),
(3, 'Luxury', 'High-end executive vehicles delivering premium experience', '2026-11-10 11:01:39'),
(7, 'Porsche', 'Sport Utility Vehicle', '2026-11-21 12:32:25'),
(8, 'Bantly', 'It\'s a luxury car', '2026-11-21 12:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Available','Assigned','Off-duty') COLLATE utf8mb4_unicode_ci DEFAULT 'Available',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_id`, `full_name`, `license_number`, `phone`, `status`, `created_at`) VALUES
(1, 'Abul Kalam', 'DL-DH-98765', '+8801533333333', 'Assigned', '2026-11-10 11:01:39'),
(2, 'Monir Hossain', 'DL-DH-12345', '+8801644444444', 'Available', '2026-11-10 11:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `driver_assignments`
--

CREATE TABLE `driver_assignments` (
  `assignment_id` int NOT NULL,
  `booking_id` int NOT NULL,
  `driver_id` int NOT NULL,
  `assigned_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `driver_assignments`
--

INSERT INTO `driver_assignments` (`assignment_id`, `booking_id`, `driver_id`, `assigned_at`) VALUES
(1, 1, 1, '2026-11-10 11:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `maintenance_id` int NOT NULL,
  `car_id` int NOT NULL,
  `service_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('Scheduled','In-Progress','Completed') COLLATE utf8mb4_unicode_ci DEFAULT 'Scheduled',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`maintenance_id`, `car_id`, `service_details`, `cost`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, 2, 'Engine oil change and brake pad inspection', 150.00, '2026-10-01', '2026-10-02', 'Completed', '2026-11-10 11:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int NOT NULL,
  `booking_id` int NOT NULL,
  `transaction_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('Cash','Credit Card','Debit Card','Bank Transfer','bKash/Nagad') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `verification_status` enum('Pending','Verified','Failed','Refunded') COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `remarks` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `transaction_id`, `payment_amount`, `payment_method`, `payment_date`, `verification_status`, `remarks`) VALUES
(1, 1, 'TXN-BK1-889922', 150.00, 'bKash/Nagad', '2026-11-10 11:01:39', 'Verified', 'Payment received via mobile banking');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int NOT NULL,
  `booking_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `car_id` int NOT NULL,
  `rating` int DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `booking_id`, `customer_id`, `car_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 3, 1, 5, 'Great condition car and smooth handover process!', '2026-11-10 11:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int NOT NULL,
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `description`, `created_at`) VALUES
(1, 'Admin', 'System Administrator with full permissions', '2026-11-10 11:01:39'),
(2, 'Staff', 'Staff/Manager for handling vehicle handovers, returns, and damage inspection', '2026-11-10 11:01:39'),
(3, 'Customer', 'Registered user who can browse vehicles and place bookings', '2026-11-10 11:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int NOT NULL,
  `service_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `price`, `description`) VALUES
(1, 'Child Safety Seat', 10.00, 'Baby / child seat installed'),
(2, 'Additional Driver', 25.00, 'Permission for an extra registered driver'),
(3, 'GPS Navigation', 15.00, 'Portable satellite navigation system');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default_avatar.png',
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `full_name`, `email`, `phone`, `password`, `address`, `profile_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ismail Hossain', 'admin@gmail.com', '+8801700000001', '$2y$12$UpZ5/Uu/kwfY1RCme.EOK.nsGuOOmhSGmrJfDwTpnER.Xer.dYVGe', 'Dhaka, Bangladesh', 'uploads/profiles/admin_6b01f89d7b4a2.png', 'active', '2026-11-10 11:01:39', '2026-11-21 20:01:33'),
(2, 2, 'Rafiqul Islam', 'staff.rafiq@carrental.com', '+8801700000002', '$2y$10$e8q4V3...hashed_pass...', 'Dhanmondi, Dhaka', 'default_avatar.png', 'active', '2026-11-10 11:01:39', '2026-11-10 11:01:39'),
(3, 3, 'Tanvir Ahmed', 'tanvir@example.com', '+8801811111111', '$2y$12$dfZ5h13eVy5XdXjNmhdjUeMroId9hm31ff9/3nkilkoSnwqAxAmPa', 'Gulshan, Dhaka', 'default_avatar.png', 'active', '2026-11-10 11:01:39', '2026-11-10 13:59:16'),
(4, 3, 'Nusrat Jahan', 'nusrat@example.com', '+8801922222222', '$2y$10$e8q4V3...hashed_pass...', 'Uttara, Dhaka', 'default_avatar.png', 'active', '2026-11-10 11:01:39', '2026-11-10 11:01:39'),
(8, 3, 'Nafiz Ahmed', 'nafiz9@gmail.com', '01319497798', '$2y$12$frdF421UWDfxxv5RMKwWDuIeyE/6f8b2BHlb6q3RHc2kTMp93BIEO', 'trishal', 'default_avatar.png', 'active', '2026-11-21 18:33:52', '2026-11-21 18:33:52');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `wishlist_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `car_id` int NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`wishlist_id`, `customer_id`, `car_id`, `added_at`) VALUES
(1, 3, 3, '2026-11-10 11:01:39'),
(2, 4, 1, '2026-11-10 11:01:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD UNIQUE KEY `booking_number` (`booking_number`);

--
-- Indexes for table `booking_services`
--
ALTER TABLE `booking_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`),
  ADD UNIQUE KEY `brand_name` (`brand_name`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD UNIQUE KEY `license_plate` (`license_plate`);

--
-- Indexes for table `car_damage_reports`
--
ALTER TABLE `car_damage_reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `car_images`
--
ALTER TABLE `car_images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `license_number` (`license_number`);

--
-- Indexes for table `driver_assignments`
--
ALTER TABLE `driver_assignments`
  ADD PRIMARY KEY (`assignment_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`maintenance_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD UNIQUE KEY `user_car_unique` (`customer_id`,`car_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `booking_services`
--
ALTER TABLE `booking_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `car_damage_reports`
--
ALTER TABLE `car_damage_reports`
  MODIFY `report_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `car_images`
--
ALTER TABLE `car_images`
  MODIFY `image_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `driver_assignments`
--
ALTER TABLE `driver_assignments`
  MODIFY `assignment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `maintenance_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `wishlist_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
