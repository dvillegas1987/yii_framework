-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 27, 2019 at 02:55 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cet30`
--

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `codigo` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`codigo`, `descripcion`) VALUES
(1, 'DIRECCION'),
(2, 'DOCENTE'),
(3, 'ALUMNO');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(250) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `authKey` varchar(250) DEFAULT NULL,
  `accessToken` varchar(250) DEFAULT NULL,
  `activate` tinyint(1) NOT NULL DEFAULT 0,
  `verification_code` varchar(250) DEFAULT NULL,
  `role` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `adjunto_foto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `email`, `password`, `nombre`, `apellido`, `authKey`, `accessToken`, `activate`, `verification_code`, `role`, `adjunto_foto`) VALUES
(37, 'direccion', 'delfor87@gmail.com', 'fspnNv1HxCoj6', 'direccion', 'direccion', 'b5b1f93fe05bbc2f7b3d90e9545aca78adee41441a0685ca026c1ad1801cd3153fd94efae8480ffcf3bcba453dadd60d2a50bd01eefd4e83938fbda873863ffcafad744b929e37a1512cd01919e6e2a5d7360d9f93c813ba5568896a708f44b4211e2efe', '7cb04d2e906dc9b126ebf43ca9eb7de3be6a9fc263618f2c33e5f5a3d243f2181cb29411e49972e2461b921b3374b62255d8e60f94c7e544a51619a3c348430a4ac5ef0346eca856dce0d560c146f7a61575c0d7e571f6dde1449157c73caf470f957793', 1, '', 1, 'uploads/foto_perfil/foto_default.jpg'),
(38, 'alumno', 'delfor87@gmail.com', 'fsPIowGcf4hx2', 'alumno', 'alumno', 'b1107b780f3734fc5d83ddd1cd4080f0ed2039e19ca5cf145fbcbb253be57db857ec033c89561b408ac3cbaeca41e077ac3b0f9fddc04135687ae5862d24c0fa3a11592e53a9f7e48f6008b156697f6ab23668643bc56dbdef3dfcdb31eb7b9ef1d7bedf', '54b066ae3d7d59a56d84ca8a2378aaebe472d12561997b61856cbfdfc575d59be401922c2d04e9d7f3e2cb1c2738f7940915d7030743fde6b7032bb70dc792c3b35bba9799a626d6d6c2e10ffb432b3cacb720670a30e45e0f208b0a5536fa85c465a1f7', 1, '', 3, 'uploads/foto_perfil/foto_default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_usuario_rol` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `codigo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
