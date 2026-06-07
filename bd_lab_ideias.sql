-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2026 at 10:28 PM
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
-- Database: `bd_lab_ideias`
--

-- --------------------------------------------------------

--
-- Table structure for table `ideias`
--

CREATE TABLE `ideias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ideias`
--

INSERT INTO `ideias` (`id`, `titulo`, `descricao`, `email`, `created_at`) VALUES
(1, 'Ideia1', 'Descrição da ideia 1.', 'emailexemplo1@gmail.com', '2025-10-04 01:47:18'),
(2, 'Ideia2', 'Descrição da Ideia2.', 'emailexemplo2@gmail.com', '2025-10-09 15:38:52'),
(3, 'Ideia3', 'Descrição da ideia 3.', 'emailexemplo3@gmail.com', '2025-10-16 13:42:35'),
(4, 'Ideia5', 'Descrição da ideia 5.', 'emailexemplo4@gmail.com', '2025-10-16 14:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `participantes`
--

CREATE TABLE `participantes` (
  `id` int(11) NOT NULL,
  `id_projeto` int(11) NOT NULL,
  `nome_completo` varchar(150) NOT NULL,
  `tipo` enum('bolsista','voluntário','coordenador','colaborador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participantes`
--

INSERT INTO `participantes` (`id`, `id_projeto`, `nome_completo`, `tipo`) VALUES
(18, 6, 'Sandro Oliveira Dorneles', 'coordenador'),
(19, 6, 'Lucas Kunrath', 'voluntário'),
(20, 6, 'Rafael', 'voluntário'),
(21, 6, 'Tiago Cinto', 'colaborador'),
(22, 7, 'Sandro Oliveira Dorneles', 'coordenador'),
(23, 7, 'Ivan Lucas Schaurich', 'bolsista'),
(24, 7, 'Guilherme Martins Glaeser', 'voluntário'),
(25, 7, 'Moser Silva Fagundes', 'colaborador'),
(26, 8, 'Sandro Oliveira Dorneles', 'coordenador'),
(27, 8, 'Guilherme Martins Glaeser', 'bolsista'),
(28, 8, 'Ivan Lucas Schaurich', 'voluntário'),
(29, 5, 'Sandro Oliveira Dorneles', 'coordenador'),
(30, 5, 'Kauã Klassmann', 'bolsista'),
(31, 5, 'Guilherme Martins Glaeser', 'voluntário'),
(32, 5, 'Tiago Cinto', 'colaborador');

-- --------------------------------------------------------

--
-- Table structure for table `projetos`
--

CREATE TABLE `projetos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `resumo` text NOT NULL,
  `descricao` text NOT NULL,
  `situacao` enum('planejamento','em andamento','concluído') NOT NULL DEFAULT 'planejamento',
  `periodo_situacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projetos`
--

INSERT INTO `projetos` (`id`, `titulo`, `resumo`, `descricao`, `situacao`, `periodo_situacao`) VALUES
(5, 'SECE', 'O IFRS campus Feliz busca aproximar alunos do mercado por meio de estágios, gerenciados pelo setor responsável. Devido ao alto volume de dúvidas repetidas, propõe-se um chatbot no site para automatizar respostas e agilizar o atendimento.', 'O IFRS campus Feliz oferece cursos de níveis médio e superior que possibilitam a realização de estágios, obrigatórios ou não, com o objetivo de aproximar os alunos do mercado de trabalho. O setor de estágio do campus organiza e controla o processo, exigindo a entrega de documentos e relatórios. Devido ao grande volume de dúvidas semelhantes enviadas por e-mail, surgiu a necessidade de automatizar as respostas por meio de um chatbot integrado ao site da instituição, visando agilizar e tornar o atendimento mais eficiente.', 'planejamento', 2024),
(6, 'App de ajuda nas Enchentes', 'Devido às enchentes no RS, surgiu a proposta de um aplicativo para conectar voluntários e afetados, começando pelo Vale do Caí. O app contará com geolocalização, pedidos de ajuda, eventos e doações. O objetivo é facilitar a organização da assistência em desastres climáticos.', 'Devido às enchentes no Rio Grande do Sul em maio, identificou-se a dificuldade na mobilização de ajuda por falta de comunicação entre voluntários e pessoas afetadas. Como solução, propõe-se a criação de um aplicativo que facilite essa conexão, especialmente na região do Vale do Caí, com potencial de expansão para todo o estado. O objetivo é desenvolver um modelo teórico do app, que contará com interface simples, sistema de geolocalização similar ao Google Maps e funcionalidades como criação de eventos, pedidos de ajuda e gerenciamento de doações (alimentos, roupas, mão de obra, etc.). O app visa tornar mais eficiente a organização da assistência em desastres climáticos atuais e futuros.', 'planejamento', 2024),
(7, 'MCHAT Digital', 'O projeto propõe uma página web para automatizar o diagnóstico do TEA em crianças, com base em respostas dos pais a um questionário. O sistema usará uma fórmula matemática para gerar diagnósticos automáticos. O objetivo é agilizar o processo e garantir diagnósticos mais precoces e precisos.', 'O projeto propõe a criação de uma página web para tornar mais eficiente o diagnóstico do Transtorno do Espectro Autista (TEA) em crianças, automatizando o processo atualmente feito manualmente por médicos com o apoio de instituições como a APAE. O sistema online permitirá que os pais respondam remotamente a um questionário cujas respostas serão analisadas por uma fórmula matemática, gerando um diagnóstico automático. O objetivo é agilizar o processo, otimizando o tempo dos profissionais de saúde e promovendo um diagnóstico precoce e preciso, essencial para garantir melhor qualidade de vida aos pacientes.', 'em andamento', 2025),
(8, 'Site Laboratório de Ideias', 'O projeto Laboratório de Ideias do IFRS Campus Feliz transforma demandas em projetos práticos. Para organizar as iniciativas, será criado um site com informações dos projetos, autores e ilustrações. O site também permitirá o envio de novas ideias por externos.', 'O projeto Laboratório de Ideias, do IFRS Campus Feliz, visa reunir e debater demandas para transformá-las em projetos práticos. Diante do número crescente de iniciativas desenvolvidas, surgiu a necessidade de criar um site que reúna informações sobre todos os projetos já realizados, seus autores, ilustrações e dados relevantes. O site também permitirá que pessoas externas ao projeto submetam novas ideias ou demandas, contribuindo para a continuidade e renovação das ações do projeto.', 'em andamento', 2025);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  `senha` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `senha`) VALUES
(1, 'administrador', '40cb919763c4eb696921211ca4c63171e24958ed84b5076a3c65afa9cb711906');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ideias`
--
ALTER TABLE `ideias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_projeto` (`id_projeto`);

--
-- Indexes for table `projetos`
--
ALTER TABLE `projetos`
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
-- AUTO_INCREMENT for table `ideias`
--
ALTER TABLE `ideias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `participantes`
--
ALTER TABLE `participantes`
  ADD CONSTRAINT `participantes_ibfk_1` FOREIGN KEY (`id_projeto`) REFERENCES `projetos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
