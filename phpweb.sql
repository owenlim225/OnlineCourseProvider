-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2025 at 02:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `is_purchased` tinyint(1) DEFAULT 0,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `instructor` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_title`, `description`, `instructor`, `price`, `image`, `created_at`) VALUES
(1, 'Game Development Fundamentals with Unity', 'Learn the basics of Unity and build your first 2D and 3D games from scratch using C#. Perfect for beginners.', 'Dr. Christian Jude Villaber', 59.00, '682070a079315_course-7.png', '2025-05-11 09:30:56'),
(2, 'Mastering Unreal Engine for Game Design', 'Dive deep into Unreal Engine 5 and discover tools for cinematic visuals and AAA-level game mechanics.', 'James Carter', 89.00, 'course-8.jpg', '2025-05-11 09:32:06'),
(3, 'Pixel Art and Animation for Games', 'Learn to create stunning pixel art characters, environments, and animations for 2D games.', 'Elisa Mapanoo', 45.00, 'course-9.jpeg', '2025-05-11 09:33:03'),
(5, 'Game UI/UX Design: Interfaces that Engage', 'Learn to create intuitive menus, HUDs, and user flows that enhance the player experience.', 'Sherwin Limosnero', 75.00, '682072c365ecc_course-3.png', '2025-05-11 09:34:42'),
(6, 'Sound Design and Music Composition for Games', 'Craft immersive soundscapes and dynamic soundtracks that elevate gameplay and emotion.', 'Sherwin Limosnero', 55.00, 'course-5.png', '2025-05-11 09:35:14'),
(7, '2D Game Development with Godot Engine', 'Build complete 2D games easily using the lightweight open-source Godot engine and GDScript.', 'Carlos Jimenez', 49.00, 'course-11.jpg', '2025-05-11 09:36:01'),
(8, '3D Game Art: Modeling, Texturing & Rigging', 'Learn Blender-based workflows to create game-ready characters and props. Modeling, Sculpting Texturing, and more.', 'Natalie Kovacs', 79.00, '68207412f31fb_img5.jpg', '2025-05-11 09:36:26'),
(9, 'Mobile Game Development with Unity', 'Create, optimize, and publish mobile games for Android and iOS using Unity’s mobile toolkit.', 'Farhan Qureshi', 69.00, 'course-12.png', '2025-05-11 09:37:23'),
(10, 'Level Design: From Greybox to Playable', 'Master the process of creating engaging levels that players love from layout to lighting and polish.', 'Ashlie Argana', 58.00, '682072baac196_course-15.jpeg', '2025-05-11 09:37:56'),
(11, 'Indie Game Team Management: Leading Small Teams to Launch', 'Manage small indie teams effectively and guide your game project from concept to launch with agile tools and clear communication.', 'Harvey Casula', 54.00, '6820735c91b36_course-16.jpg', '2025-05-11 09:38:39'),
(12, 'Narrative Design for Interactive Storytelling', 'Develop compelling branching narratives and integrate dialogue systems in games to create rich, interactive storytelling experiences.', 'Jairus Alano', 62.00, '682072ce91fb4_course-2.png', '2025-05-11 09:39:10'),
(13, 'VR Game Development with Unity and Oculus', 'Build immersive VR experiences and understand key design principles for virtual reality to create engaging, user-centered gameplay.', 'Harvey Casula', 89.00, '6820726e18319_course-14.jpg', '2025-05-11 09:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `full_name`, `email`, `mobile`, `country`, `payment_method`, `total_amount`, `order_status`, `created_at`) VALUES
(1, 4, 'marcus oten', 'asd@gmail.com', '09875454323', 'Philippines', 'gcash', 148.00, 'completed', '2025-05-11 09:42:40'),
(2, 4, 'tetete', 'asd@gmail.com', '09875454323', 'Philippines', 'maya', 79.00, 'completed', '2025-05-11 10:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `purchased_courses`
--

CREATE TABLE `purchased_courses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `purchased_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchased_courses`
--

INSERT INTO `purchased_courses` (`id`, `user_id`, `course_id`, `order_id`, `purchased_at`) VALUES
(1, 4, 1, 1, '2025-05-11 09:42:40'),
(2, 4, 2, 1, '2025-05-11 09:42:40'),
(3, 4, 8, 2, '2025-05-11 10:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `password`, `contact`, `is_admin`, `created_at`) VALUES
(1, 'zxc', 'zxc', 'zxc@gmail.com', '$2y$10$DYJc.Tl6Rc18pPmQTq0ieO/C9Fo.kGvvN4WXROF6MSdFjUglUzWmm', '09703017634', 0, '2025-04-14 07:38:17'),
(3, 'admin', 'admin', 'admin@gmail.com', '$2y$10$nIqAgSC89mTKJjfzqhO8lerYlCM8s/a51YuXzVLJzfFUrp6.c/mL.', '09871232312', 1, '2025-05-11 09:15:26'),
(4, 'hatdog', 'asd', 'asd@gmail.com', '$2y$10$FsieeDOxOjL/kHFgJgvqDeypZJkx2o97Mn.Y3Ccmlen6zXawdVgDe', '09875454323', 0, '2025-05-11 09:42:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `idx_cart_user` (`user_id`),
  ADD KEY `idx_cart_status` (`is_purchased`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `idx_orders_user` (`user_id`);

--
-- Indexes for table `purchased_courses`
--
ALTER TABLE `purchased_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `idx_purchased_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchased_courses`
--
ALTER TABLE `purchased_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `purchased_courses`
--
ALTER TABLE `purchased_courses`
  ADD CONSTRAINT `purchased_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchased_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchased_courses_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
