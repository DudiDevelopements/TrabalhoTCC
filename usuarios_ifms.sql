-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2024 at 04:23 PM
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
-- Database: `usuarios_ifms`
--
CREATE DATABASE IF NOT EXISTS `usuarios_ifms` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `usuarios_ifms`;

-- --------------------------------------------------------

--
-- Table structure for table `administradores`
--

CREATE TABLE `administradores` (
  `id` int(30) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(512) NOT NULL,
  `data_nasc` date DEFAULT NULL,
  `senha` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administradores`
--

INSERT INTO `administradores` (`id`, `nome`, `email`, `data_nasc`, `senha`) VALUES
(1, 'Helmuth', 'helmuthossinaga@gmail.com', NULL, 'helmuth123'),
(2, 'Marcilio', 'marcilio@gmail.com', '2006-09-01', '123');

-- --------------------------------------------------------

--
-- Table structure for table `envios`
--

CREATE TABLE `envios` (
  `id` int(255) NOT NULL,
  `id_aluno` int(255) NOT NULL,
  `email` varchar(512) NOT NULL,
  `turma` varchar(30) NOT NULL,
  `prof` varchar(512) DEFAULT NULL,
  `tipo` varchar(120) DEFAULT NULL,
  `obs` varchar(512) DEFAULT NULL,
  `path` varchar(2048) NOT NULL,
  `validado` tinyint(1) NOT NULL,
  `horario_enviado` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `carga_horaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `envios`
--

INSERT INTO `envios` (`id`, `id_aluno`, `email`, `turma`, `prof`, `tipo`, `obs`, `path`, `validado`, `horario_enviado`, `carga_horaria`) VALUES
(7, 1, 'supergamerbr39@gmail.com', '20210', 'Helmuth', 'Prática profissional integradora e/ou vivência acadêmica', '', '../arquivos/comprovantes_aluno/1/1Marcilio6608aadb0a4275.87293664.png', 0, '2024-03-31 00:14:19.042386', 13800),
(8, 1, 'marcilinhobarbosa@hotmail.com', '20210', 'Helmuth', 'Unidade curriculares optativas/eletivas', 'te amo', '../arquivos/comprovantes_aluno/1/1Marcilio6608f4848ed2c8.20106534.png', 0, '2024-03-31 05:28:36.585800', NULL),
(9, 2, 'marci@gmail.om', '1029', 'Helmuth', 'Práticas artístico-culturais', '', '../arquivos/comprovantes_aluno/2/2Joao6608f4ba919844.75342543.png', 0, '2024-03-31 05:29:30.596723', NULL),
(10, 2, 'jao@love66', '10210', 'Helmuth', 'Prática profissional integradora e/ou vivência acadêmica', '', '../arquivos/comprovantes_aluno/2/2Joao6608f58f802d20.60562053.png', 0, '2024-03-31 05:33:03.525403', NULL),
(11, 1, 'supergamerbr39@gmail.com', '1029', 'Paulo', 'Prática profissional integradora e/ou vivência acadêmica', '', '../arquivos/comprovantes_aluno/1/1Marcilio660a046e7a3db9.12920021.png', 0, '2024-04-01 00:48:46.501512', NULL),
(12, 3, 'marcilinhobarbosa@hotmail.com', '3090', 'Paulo', 'Práticas artístico-culturais', '', '../arquivos/comprovantes_aluno/3/3Barbosa660a2b4ae337d3.06347388.png', 0, '2024-04-01 03:34:34.931056', NULL),
(13, 1, 'supergamerbr39@gmail.com', '20210', 'Helmuth', 'Práticas desportivas', '', '../arquivos/comprovantes_aluno/1/1Marcilio660a3238e51a83.43506350.png', 0, '2024-04-01 04:04:08.939138', NULL),
(14, 1, 'marcilinhobarbosa@hotmail.com', '10210', 'Paulo', 'Projeto de ensino, pesquisa ou extensão', '', '../arquivos/comprovantes_aluno/1/1Marcilio660a34cdcde203.59565008.png', 0, '2024-04-01 04:15:09.844330', 0),
(15, 1, 'supergamerbr39@gmail.com', '10210', 'Helmuth', 'Prática profissional integradora e/ou vivência acadêmica', '', '../arquivos/comprovantes_aluno/1/1Marcilio660a35abe8d210.12267440.png', 0, '2024-04-01 04:18:51.954485', 0),
(16, 4, 'supergamerbr39@gmail.com', '10210', 'Helmuth', 'Projeto de ensino, pesquisa ou extensão', '', '../arquivos/comprovantes_aluno/4/4Zaibro660a3d5e78e258.70923848.png', 0, '2024-04-01 04:51:42.495449', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recebidos`
--

CREATE TABLE `recebidos` (
  `id` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `carga_horaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(30) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `cpf`, `nome`, `data_nascimento`) VALUES
(1, '066.764.291-95', 'Marcilio', '2006-09-01'),
(2, '495.153.301-49', 'Joao', '1973-04-14'),
(3, '562.657.861-72', 'Barbosa', '1975-12-08'),
(4, '111.111.111-11', 'Zaibro', '2008-04-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `envios`
--
ALTER TABLE `envios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aluno` (`id_aluno`);

--
-- Indexes for table `recebidos`
--
ALTER TABLE `recebidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `envios`
--
ALTER TABLE `envios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `recebidos`
--
ALTER TABLE `recebidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `envios`
--
ALTER TABLE `envios`
  ADD CONSTRAINT `envios_ibfk_1` FOREIGN KEY (`id_aluno`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
