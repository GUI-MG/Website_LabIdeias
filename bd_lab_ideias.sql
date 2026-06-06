-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/06/2026 às 20:39
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

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

CREATE DATABASE IF NOT EXISTS `bd_lab_ideias` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd_lab_ideias`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ideias`
--

CREATE TABLE `ideias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ideias`
--

INSERT INTO `ideias` (`id`, `titulo`, `descricao`, `email`, `created_at`) VALUES
(1, 'Ideia1', 'Descrição da ideia 1.', 'emailexemplo1@gmail.com', '2025-10-04 01:47:18'),
(2, 'Ideia2', 'Descrição da Ideia2.', 'emailexemplo2@gmail.com', '2025-10-09 15:38:52'),
(3, 'Ideia3', 'Descrição da ideia 3.', 'emailexemplo3@gmail.com', '2025-10-16 13:42:35'),
(4, 'Ideia5', 'Descrição da ideia 5.', 'emailexemplo4@gmail.com', '2025-10-16 14:31:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `old_participantes`
--

CREATE TABLE `old_participantes` (
  `id` int(11) NOT NULL,
  `id_projeto` int(11) NOT NULL,
  `nome_completo` varchar(150) NOT NULL,
  `tipo` enum('bolsista','voluntário','coordenador','colaborador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `old_participantes`
--

INSERT INTO `old_participantes` (`id`, `id_projeto`, `nome_completo`, `tipo`) VALUES
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
-- Estrutura para tabela `old_projetos`
--

CREATE TABLE `old_projetos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `resumo` text NOT NULL,
  `descricao` text NOT NULL,
  `situacao` enum('planejamento','em andamento','concluído') NOT NULL DEFAULT 'planejamento',
  `inicio` year(4) DEFAULT NULL,
  `termino` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `old_projetos`
--

INSERT INTO `old_projetos` (`id`, `titulo`, `resumo`, `descricao`, `situacao`, `inicio`, `termino`) VALUES
(5, 'SECE', 'O IFRS campus Feliz busca aproximar alunos do mercado por meio de estágios, gerenciados pelo setor responsável. Devido ao alto volume de dúvidas repetidas, propõe-se um chatbot no site para automatizar respostas e agilizar o atendimento.', 'O IFRS campus Feliz oferece cursos de níveis médio e superior que possibilitam a realização de estágios, obrigatórios ou não, com o objetivo de aproximar os alunos do mercado de trabalho. O setor de estágio do campus organiza e controla o processo, exigindo a entrega de documentos e relatórios. Devido ao grande volume de dúvidas semelhantes enviadas por e-mail, surgiu a necessidade de automatizar as respostas por meio de um chatbot integrado ao site da instituição, visando agilizar e tornar o atendimento mais eficiente.', 'planejamento', '2024', NULL),
(6, 'App de ajuda nas Enchentes', 'Devido às enchentes no RS, surgiu a proposta de um aplicativo para conectar voluntários e afetados, começando pelo Vale do Caí. O app contará com geolocalização, pedidos de ajuda, eventos e doações. O objetivo é facilitar a organização da assistência em desastres climáticos.', 'Devido às enchentes no Rio Grande do Sul em maio, identificou-se a dificuldade na mobilização de ajuda por falta de comunicação entre voluntários e pessoas afetadas. Como solução, propõe-se a criação de um aplicativo que facilite essa conexão, especialmente na região do Vale do Caí, com potencial de expansão para todo o estado. O objetivo é desenvolver um modelo teórico do app, que contará com interface simples, sistema de geolocalização similar ao Google Maps e funcionalidades como criação de eventos, pedidos de ajuda e gerenciamento de doações (alimentos, roupas, mão de obra, etc.). O app visa tornar mais eficiente a organização da assistência em desastres climáticos atuais e futuros.', 'planejamento', '2024', NULL),
(7, 'MCHAT Digital', 'O projeto propõe uma página web para automatizar o diagnóstico do TEA em crianças, com base em respostas dos pais a um questionário. O sistema usará uma fórmula matemática para gerar diagnósticos automáticos. O objetivo é agilizar o processo e garantir diagnósticos mais precoces e precisos.', 'O projeto propõe a criação de uma página web para tornar mais eficiente o diagnóstico do Transtorno do Espectro Autista (TEA) em crianças, automatizando o processo atualmente feito manualmente por médicos com o apoio de instituições como a APAE. O sistema online permitirá que os pais respondam remotamente a um questionário cujas respostas serão analisadas por uma fórmula matemática, gerando um diagnóstico automático. O objetivo é agilizar o processo, otimizando o tempo dos profissionais de saúde e promovendo um diagnóstico precoce e preciso, essencial para garantir melhor qualidade de vida aos pacientes.', 'em andamento', '2025', NULL),
(8, 'Site Laboratório de Ideias', 'O projeto Laboratório de Ideias do IFRS Campus Feliz transforma demandas em projetos práticos. Para organizar as iniciativas, será criado um site com informações dos projetos, autores e ilustrações. O site também permitirá o envio de novas ideias por externos.', 'O projeto Laboratório de Ideias, do IFRS Campus Feliz, visa reunir e debater demandas para transformá-las em projetos práticos. Diante do número crescente de iniciativas desenvolvidas, surgiu a necessidade de criar um site que reúna informações sobre todos os projetos já realizados, seus autores, ilustrações e dados relevantes. O site também permitirá que pessoas externas ao projeto submetam novas ideias ou demandas, contribuindo para a continuidade e renovação das ações do projeto.', 'em andamento', '2025', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `participantes`
--

CREATE TABLE `participantes` (
  `id` int(11) NOT NULL,
  `nome_completo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `participantes`
--

INSERT INTO `participantes` (`id`, `nome_completo`) VALUES
(1, 'Sandro Oliveira Dorneles'),
(2, 'Lucas Kunrath'),
(3, 'Rafael'),
(4, 'Tiago Cinto'),
(5, 'Ivan Lucas Schaurich'),
(6, 'Guilherme Martins Glaeser'),
(7, 'Moser Silva Fagundes'),
(8, 'Kauã Klassmann'),
(9, 'Michel Nathan Schauren'),
(10, 'Eloisa Rambo Winter'),
(11, 'Thais Hillebrand Link'),
(12, 'Alan Eduardo Federhen'),
(13, 'Lucas Marques Gritti');

-- --------------------------------------------------------

--
-- Estrutura para tabela `partic_proj_relacao`
--

CREATE TABLE `partic_proj_relacao` (
  `id_partc` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `tipo` enum('bolsista','voluntário','coordenador','colaborador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `partic_proj_relacao`
--

INSERT INTO `partic_proj_relacao` (`id_partc`, `id_proj`, `tipo`) VALUES
(1, 1, 'coordenador'),
(1, 2, 'coordenador'),
(1, 3, 'coordenador'),
(1, 4, 'coordenador'),
(2, 2, 'voluntário'),
(3, 2, 'voluntário'),
(4, 1, 'colaborador'),
(4, 2, 'colaborador'),
(5, 3, 'bolsista'),
(5, 4, 'voluntário'),
(6, 3, 'voluntário'),
(6, 4, 'bolsista'),
(7, 3, 'colaborador'),
(8, 1, 'bolsista'),
(9, 4, 'colaborador'),
(9, 6, 'bolsista'),
(10, 5, 'bolsista'),
(11, 5, 'bolsista'),
(12, 3, 'colaborador'),
(12, 6, 'voluntário'),
(13, 5, 'voluntário');

-- --------------------------------------------------------

--
-- Estrutura para tabela `projetos`
--

CREATE TABLE `projetos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `resumo` text NOT NULL,
  `descricao` text NOT NULL,
  `situacao` enum('planejamento','em andamento','concluído') NOT NULL DEFAULT 'planejamento',
  `inicio` year(4) NOT NULL,
  `termino` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `projetos`
--

INSERT INTO `projetos` (`id`, `titulo`, `resumo`, `descricao`, `situacao`, `inicio`, `termino`) VALUES
(1, 'SECE', 'O IFRS campus Feliz busca aproximar alunos do mercado por meio de estágios, gerenciados pelo setor responsável. Devido ao alto volume de dúvidas repetidas, propõe-se um chatbot no site para automatizar respostas e agilizar o atendimento.', 'O IFRS campus Feliz oferece cursos de níveis médio e superior que possibilitam a realização de estágios, obrigatórios ou não, com o objetivo de aproximar os alunos do mercado de trabalho. O setor de estágio do campus organiza e controla o processo, exigindo a entrega de documentos e relatórios. Devido ao grande volume de dúvidas semelhantes enviadas por e-mail, surgiu a necessidade de automatizar as respostas por meio de um chatbot integrado ao site da instituição, visando agilizar e tornar o atendimento mais eficiente.', 'planejamento', '2024', '2024'),
(2, 'App de ajuda nas Enchentes', 'Devido às enchentes no RS, surgiu a proposta de um aplicativo para conectar voluntários e afetados, começando pelo Vale do Caí. O app contará com geolocalização, pedidos de ajuda, eventos e doações. O objetivo é facilitar a organização da assistência em desastres climáticos.', 'Devido às enchentes no Rio Grande do Sul em maio, identificou-se a dificuldade na mobilização de ajuda por falta de comunicação entre voluntários e pessoas afetadas. Como solução, propõe-se a criação de um aplicativo que facilite essa conexão, especialmente na região do Vale do Caí, com potencial de expansão para todo o estado. O objetivo é desenvolver um modelo teórico do app, que contará com interface simples, sistema de geolocalização similar ao Google Maps e funcionalidades como criação de eventos, pedidos de ajuda e gerenciamento de doações (alimentos, roupas, mão de obra, etc.). O app visa tornar mais eficiente a organização da assistência em desastres climáticos atuais e futuros.', 'planejamento', '2024', '2024'),
(3, 'MCHAT Digital', 'O projeto propõe uma página web para automatizar o diagnóstico do TEA em crianças, com base em respostas dos pais a um questionário. O sistema usará uma fórmula matemática para gerar diagnósticos automáticos. O objetivo é agilizar o processo e garantir diagnósticos mais precoces e precisos.', 'O projeto propõe a criação de uma página web para tornar mais eficiente o diagnóstico do Transtorno do Espectro Autista (TEA) em crianças, automatizando o processo atualmente feito manualmente por médicos com o apoio de instituições como a APAE. O sistema online permitirá que os pais respondam remotamente a um questionário cujas respostas serão analisadas por uma fórmula matemática, gerando um diagnóstico automático. O objetivo é agilizar o processo, otimizando o tempo dos profissionais de saúde e promovendo um diagnóstico precoce e preciso, essencial para garantir melhor qualidade de vida aos pacientes.', 'em andamento', '2025', NULL),
(4, 'Site Laboratório de Ideias', 'O projeto Laboratório de Ideias do IFRS Campus Feliz transforma demandas em projetos práticos. Para organizar as iniciativas, será criado um site com informações dos projetos, autores e ilustrações. O site também permitirá o envio de novas ideias por externos.', 'O projeto Laboratório de Ideias, do IFRS Campus Feliz, visa reunir e debater demandas para transformá-las em projetos práticos. Diante do número crescente de iniciativas desenvolvidas, surgiu a necessidade de criar um site que reúna informações sobre todos os projetos já realizados, seus autores, ilustrações e dados relevantes. O site também permitirá que pessoas externas ao projeto submetam novas ideias ou demandas, contribuindo para a continuidade e renovação das ações do projeto.', 'em andamento', '2025', NULL),
(5, 'Comunica++', 'Indivíduos com Transtorno do Espectro Autista tendem a apresentar dificuldade de comunicação verbal e demais limitações. A proposta deste projeto é desenvolver um aplicativo de comunicação alternativa que auxilie pessoas não verbais a se expressarem de forma prática e intuitiva.', '...', 'planejamento', '2026', NULL),
(6, 'Cuidados de idosos', 'Certas doenças, principalmente o Alzaimer, são responsáveis por dificultar a vida de idosos que esquecem de atividades rotineiras. Esse projeto visa criar um aplicativo que auxilie idosos e seus familiares.', '...', 'planejamento', '2026', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  `senha` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `senha`) VALUES
(1, 'administrador', '40cb919763c4eb696921211ca4c63171e24958ed84b5076a3c65afa9cb711906');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `ideias`
--
ALTER TABLE `ideias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `old_participantes`
--
ALTER TABLE `old_participantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_projeto` (`id_projeto`);

--
-- Índices de tabela `old_projetos`
--
ALTER TABLE `old_projetos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `partic_proj_relacao`
--
ALTER TABLE `partic_proj_relacao`
  ADD PRIMARY KEY (`id_partc`,`id_proj`),
  ADD KEY `id_proj` (`id_proj`);

--
-- Índices de tabela `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ideias`
--
ALTER TABLE `ideias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `old_participantes`
--
ALTER TABLE `old_participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `old_projetos`
--
ALTER TABLE `old_projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `old_participantes`
--
ALTER TABLE `old_participantes`
  ADD CONSTRAINT `old_participantes_ibfk_1` FOREIGN KEY (`id_projeto`) REFERENCES `old_projetos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `partic_proj_relacao`
--
ALTER TABLE `partic_proj_relacao`
  ADD CONSTRAINT `partic_proj_relacao_ibfk_1` FOREIGN KEY (`id_partc`) REFERENCES `participantes` (`id`),
  ADD CONSTRAINT `partic_proj_relacao_ibfk_2` FOREIGN KEY (`id_proj`) REFERENCES `projetos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
