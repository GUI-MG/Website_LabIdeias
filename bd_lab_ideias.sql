-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/06/2026 às 22:02
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

--
-- Despejando dados para a tabela `participante`
--

INSERT INTO `participante` (`id`, `nome_completo`, `tipo`) VALUES
(1, 'Sandro Oliveira Dorneles', 'coordenador'),
(2, 'Lucas Kunrath', 'voluntário'),
(3, 'Rafael', 'voluntário'),
(4, 'Tiago Cinto', 'colaborador'),
(5, 'Sandro Oliveira Dorneles', 'coordenador'),
(6, 'Ivan Lucas Schaurich', 'bolsista'),
(7, 'Guilherme Martins Glaeser', 'voluntário'),
(8, 'Moser Silva Fagundes', 'colaborador'),
(9, 'Sandro Oliveira Dorneles', 'coordenador'),
(10, 'Guilherme Martins Glaeser', 'bolsista'),
(11, 'Ivan Lucas Schaurich', 'voluntário'),
(12, 'Sandro Oliveira Dorneles', 'coordenador'),
(13, 'Kauã Klassmann', 'bolsista'),
(14, 'Guilherme Martins Glaeser', 'voluntário'),
(15, 'Tiago Cinto', 'colaborador'),
(16, 'Sandro Oliveira Dorneles', 'coordenador'),
(17, 'Ivan Lucas Schaurich', 'voluntário'),
(18, 'Guilherme Martins Glaeser', 'voluntário'),
(19, 'Michel Nathan Schauren', 'bolsista'),
(20, 'Eloisa Rambo Winter', 'bolsista'),
(21, 'Thais Hillebrand Link', 'bolsista'),
(22, 'Alan Eduardo Federhen', 'voluntário'),
(23, 'Lucas Marques Gritti', 'voluntário'),
(24, 'Sandro Oliveira Dorneles', 'coordenador'),
(25, 'Sandro Oliveira Dorneles', 'coordenador');

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
  `inicio` year(4) DEFAULT NULL,
  `termino` year(4) DEFAULT NULL,
  `fk_ideia_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `projeto`
--

INSERT INTO `projeto` (`id`, `titulo`, `resumo`, `descricao`, `situacao`, `inicio`, `termino`, `fk_ideia_id`) VALUES
(1, 'SECE', 'O IFRS campus Feliz busca aproximar alunos do mercado por meio de estágios, gerenciados pelo setor responsável. Devido ao alto volume de dúvidas repetidas, propõe-se um chatbot no site para automatizar respostas e agilizar o atendimento.', 'O IFRS campus Feliz oferece cursos de níveis médio e superior que possibilitam a realização de estágios, obrigatórios ou não, com o objetivo de aproximar os alunos do mercado de trabalho. O setor de estágio do campus organiza e controla o processo, exigindo a entrega de documentos e relatórios. Devido ao grande volume de dúvidas semelhantes enviadas por e-mail, surgiu a necessidade de automatizar as respostas por meio de um chatbot integrado ao site da instituição, visando agilizar e tornar o atendimento mais eficiente.', 'planejamento', '2024', '2024', NULL),
(2, 'App de ajuda nas Enchentes', 'Devido às enchentes no RS, surgiu a proposta de um aplicativo para conectar voluntários e afetados, começando pelo Vale do Caí. O app contará com geolocalização, pedidos de ajuda, eventos e doações. O objetivo é facilitar a organização da assistência em desastres climáticos.', 'Devido às enchentes no Rio Grande do Sul em maio, identificou-se a dificuldade na mobilização de ajuda por falta de comunicação entre voluntários e pessoas afetadas. Como solução, propõe-se a criação de um aplicativo que facilite essa conexão, especialmente na região do Vale do Caí, com potencial de expansão para todo o estado. O objetivo é desenvolver um modelo teórico do app, que contará com interface simples, sistema de geolocalização similar ao Google Maps e funcionalidades como criação de eventos, pedidos de ajuda e gerenciamento de doações (alimentos, roupas, mão de obra, etc.). O app vi', 'planejamento', '2024', '2024', NULL),
(3, 'MCHAT Digital', 'O projeto propõe uma página web para automatizar o diagnóstico do TEA em crianças, com base em respostas dos pais a um questionário. O sistema usará uma fórmula matemática para gerar diagnósticos automáticos. O objetivo é agilizar o processo e garantir diagnósticos mais precoces e precisos.', 'O projeto propõe a criação de uma página web para tornar mais eficiente o diagnóstico do Transtorno do Espectro Autista (TEA) em crianças, automatizando o processo atualmente feito manualmente por médicos com o apoio de instituições como a APAE. O sistema online permitirá que os pais respondam remotamente a um questionário cujas respostas serão analisadas por uma fórmula matemática, gerando um diagnóstico automático. O objetivo é agilizar o processo, otimizando o tempo dos profissionais de saúde e promovendo um diagnóstico precoce e preciso, essencial para garantir melhor qualidade de vida aos', 'em andamento', '2025', NULL, NULL),
(4, 'Site Laboratório de Ideias', 'O projeto Laboratório de Ideias do IFRS Campus Feliz transforma demandas em projetos práticos. Para organizar as iniciativas, será criado um site com informações dos projetos, autores e ilustrações. O site também permitirá o envio de novas ideias por externos.', 'O projeto Laboratório de Ideias, do IFRS Campus Feliz, visa reunir e debater demandas para transformá-las em projetos práticos. Diante do número crescente de iniciativas desenvolvidas, surgiu a necessidade de criar um site que reúna informações sobre todos os projetos já realizados, seus autores, ilustrações e dados relevantes. O site também permitirá que pessoas externas ao projeto submetam novas ideias ou demandas, contribuindo para a continuidade e renovação das ações do projeto.', 'em andamento', '2025', NULL, NULL),
(5, 'Comunica++', 'Indivíduos com Transtorno do Espectro Autista tendem a apresentar dificuldade de comunicação verbal e demais limitações. A proposta deste projeto é desenvolver um aplicativo de comunicação alternativa que auxilie pessoas não verbais a se expressarem de forma prática e intuitiva.', 'Este projeto consiste no desenvolvimento de um aplicativo de comunicação alternativa projetado para apoiar indivíduos com Transtorno do Espectro Autista (TEA) e outras pessoas não verbais que enfrentam severas barreiras de interação. A solução visa mitigar as frustrações e as dificuldades comportamentais causadas pela limitação na fala, oferecendo uma ferramenta prática e intuitiva para a expressão diária de sentimentos, desejos e necessidades. Ao facilitar a conexão com o ambiente social, a plataforma atua diretamente na promoção da autonomia, na redução do isolamento e no fortalecimento do b', 'planejamento', '2026', NULL, NULL),
(6, 'Cuidados de idosos', 'Hoje em dia familiares e cuidadores podem ter dificuldades no acompanhamento de medicamentos e tratamentos de idosos necessitados. Por isso busca-se criar um sistema para auxiliar no cuidado e monitoramento de idosos e pessoas com alguma necessidade específica.', 'Este projeto consiste no desenvolvimento de um sistema inteligente de monitoramento e auxílio ao cuidado de idosos e pessoas com necessidades específicas, criado para enfrentar diretamente os desafios do envelhecimento populacional e a escassez de cuidadores qualificados. A solução tecnológica busca otimizar o acompanhamento de rotinas médicas, mitigar riscos de quedas e oferecer respostas rápidas a emergências e limitações decorrentes de doenças neurodegenerativas, como o Alzheimer. Ao integrar um suporte contínuo, seguro e acessível tanto para famílias quanto para instituições de longa perma', 'planejamento', '2026', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `realiza`
--

CREATE TABLE `realiza` (
  `fk_projeto_id` int(11) DEFAULT NULL,
  `fk_participante_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `realiza` (`fk_projeto_id`, `fk_participante_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 12),
(4, 13),
(4, 14),
(4, 15),
(4, 16),
(5, 17),
(5, 18),
(5, 19),
(5, 20),
(5, 24),
(6, 21),
(6, 22),
(6, 23),
(6, 25);

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
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ideia`
--
ALTER TABLE `ideia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `participacao`
--
ALTER TABLE `participacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `participante`
--
ALTER TABLE `participante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `projeto`
--
ALTER TABLE `projeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
