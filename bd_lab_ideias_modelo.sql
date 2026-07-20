-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/06/2026 às 20:28
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

CREATE DATABASE IF NOT EXISTS `bd_lab_ideias` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd_lab_ideias`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_lab_ideias`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `ideia`
--

CREATE TABLE `ideia` (
  `id` int(11) NOT NULL,
  `titulo` varchar(40) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `participa`
--

CREATE TABLE `participa` (
  `fk_projeto_id` int(11) DEFAULT NULL,
  `fk_participacao_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `participacao`
--

CREATE TABLE `participacao` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) DEFAULT NULL,
  `ano` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `participante`
--

CREATE TABLE `participante` (
  `id` int(11) NOT NULL,
  `nome_completo` varchar(60) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `projeto`
--

CREATE TABLE `projeto` (
  `id` int(11) NOT NULL,
  `titulo` varchar(40) DEFAULT NULL,
  `resumo` varchar(300) DEFAULT NULL,
  `descricao` varchar(600) DEFAULT NULL,
  `situacao` varchar(60) DEFAULT NULL,
  `inicio` date DEFAULT NULL,
  `termino` date DEFAULT NULL,
  `fk_ideia_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `realiza`
--

CREATE TABLE `realiza` (
  `fk_projeto_id` int(11) DEFAULT NULL,
  `fk_participante_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(40) DEFAULT NULL,
  `senha` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `ideia`
--
ALTER TABLE `ideia`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `participa`
--
ALTER TABLE `participa`
  ADD KEY `FK_participa_1` (`fk_projeto_id`),
  ADD KEY `FK_participa_2` (`fk_participacao_id`);

--
-- Índices de tabela `participacao`
--
ALTER TABLE `participacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `participante`
--
ALTER TABLE `participante`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_projeto_2` (`fk_ideia_id`);

--
-- Índices de tabela `realiza`
--
ALTER TABLE `realiza`
  ADD KEY `FK_realiza_1` (`fk_projeto_id`),
  ADD KEY `FK_realiza_2` (`fk_participante_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `participa`
--
ALTER TABLE `participa`
  ADD CONSTRAINT `FK_participa_1` FOREIGN KEY (`fk_projeto_id`) REFERENCES `projeto` (`id`),
  ADD CONSTRAINT `FK_participa_2` FOREIGN KEY (`fk_participacao_id`) REFERENCES `participacao` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `projeto`
--
ALTER TABLE `projeto`
  ADD CONSTRAINT `FK_projeto_2` FOREIGN KEY (`fk_ideia_id`) REFERENCES `ideia` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `realiza`
--
ALTER TABLE `realiza`
  ADD CONSTRAINT `FK_realiza_1` FOREIGN KEY (`fk_projeto_id`) REFERENCES `projeto` (`id`),
  ADD CONSTRAINT `FK_realiza_2` FOREIGN KEY (`fk_participante_id`) REFERENCES `participante` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
