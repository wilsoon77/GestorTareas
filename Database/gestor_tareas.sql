-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 02:48 AM
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
-- Database: `gestor_tareas`
--

-- --------------------------------------------------------

--
-- Table structure for table `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `prioridad` varchar(255) NOT NULL,
  `completado` tinyint(1) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tareas`
--

INSERT INTO `tareas` (`id`, `titulo`, `descripcion`, `prioridad`, `completado`, `fecha_creacion`) VALUES
(1, 'Tarea 1', 'Esta es la Descripcion de tarea 1', 'baja', 1, '2025-04-10 17:38:52'),
(2, 'Tarea 2', 'Esta es la Descripcion de tarea 2', 'media', 1, '2025-04-10 17:54:06'),
(3, 'Tarea 3', 'Esta es la Descripcion de tarea 3', 'alta', 0, '2025-04-10 17:54:15'),
(4, 'Pagar servicios', ' Luz, agua e internet.', 'alta', 0, '2025-04-10 18:00:26'),
(5, 'Limpiar correo electrónico', ' Eliminar correos innecesarios y organizar por carpetas.', 'media', 0, '2025-04-10 18:00:57'),
(6, 'Leer 20 páginas de un libro', 'Continuar leyendo mi libro antes de dormir.', 'baja', 0, '2025-04-10 18:01:26'),
(7, 'Estudiar para el examen de programación', ' Repasar temas de PHP, SQL y Bootstrap.', 'alta', 0, '2025-04-10 18:01:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
