-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 17-Nov-2017 às 12:19
-- Versão do servidor: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ava_anotacao`
--

DROP TABLE IF EXISTS `ava_anotacao`;
CREATE TABLE `ava_anotacao` (
  `id` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `inscricao` int(11) NOT NULL,
  `anotacao` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ava_categoria`
--

DROP TABLE IF EXISTS `ava_categoria`;
CREATE TABLE `ava_categoria` (
  `id` int(11) NOT NULL,
  `edital` int(11) NOT NULL,
  `mapas` varchar(60) NOT NULL,
  `valor_total` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ava_criterios`
--

DROP TABLE IF EXISTS `ava_criterios`;
CREATE TABLE `ava_criterios` (
  `id` int(11) NOT NULL,
  `criterio` longtext NOT NULL,
  `edital` int(11) NOT NULL,
  `fase` int(11) NOT NULL,
  `peso` int(11) NOT NULL,
  `nota_maxima` double(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ava_edital`
--

DROP TABLE IF EXISTS `ava_edital`;
CREATE TABLE `ava_edital` (
  `id` int(11) NOT NULL,
  `edital` varchar(140) NOT NULL,
  `id_mapas` int(11) NOT NULL,
  `avaliadores` longtext NOT NULL,
  `fases` tinyint(2) NOT NULL,
  `ms_criterios` tinyint(1) NOT NULL,
  `ms_avaliadores` tinyint(1) NOT NULL,
  `ms_fases` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ava_fase`
--

DROP TABLE IF EXISTS `ava_fase`;
CREATE TABLE `ava_fase` (
  `id` int(11) NOT NULL,
  `edital` int(11) NOT NULL,
  `fase` int(11) NOT NULL,
  `peso` int(11) NOT NULL,
  `inicio` date NOT NULL,
  `fim` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ava_inscricao`
--

DROP TABLE IF EXISTS `ava_inscricao`;
CREATE TABLE `ava_inscricao` (
  `id` int(11) NOT NULL,
  `id_mapas` int(11) NOT NULL,
  `inscricao` varchar(20) NOT NULL,
  `edital` int(11) NOT NULL,
  `aprovado` tinyint(1) NOT NULL,
  `descricao` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ava_nota`
--

DROP TABLE IF EXISTS `ava_nota`;
CREATE TABLE `ava_nota` (
  `id` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `inscricao` varchar(20) NOT NULL,
  `nota` float NOT NULL,
  `criterio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ava_ranking`
--

DROP TABLE IF EXISTS `ava_ranking`;
CREATE TABLE `ava_ranking` (
  `id` int(11) NOT NULL,
  `inscricao` varchar(20) NOT NULL,
  `nota` float NOT NULL,
  `edital` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ava_anotacao`
--
ALTER TABLE `ava_anotacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ava_categoria`
--
ALTER TABLE `ava_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ava_criterios`
--
ALTER TABLE `ava_criterios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ava_edital`
--
ALTER TABLE `ava_edital`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ava_fase`
--
ALTER TABLE `ava_fase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ava_inscricao`
--
ALTER TABLE `ava_inscricao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ava_nota`
--
ALTER TABLE `ava_nota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ava_ranking`
--
ALTER TABLE `ava_ranking`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ava_anotacao`
--
ALTER TABLE `ava_anotacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ava_categoria`
--
ALTER TABLE `ava_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ava_criterios`
--
ALTER TABLE `ava_criterios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ava_edital`
--
ALTER TABLE `ava_edital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ava_fase`
--
ALTER TABLE `ava_fase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ava_inscricao`
--
ALTER TABLE `ava_inscricao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `ava_nota`
--
ALTER TABLE `ava_nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ava_ranking`
--
ALTER TABLE `ava_ranking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
