-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 17-Maio-2023 às 18:32
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `planejamento`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade`
--

DROP TABLE IF EXISTS `cidade`;
CREATE TABLE IF NOT EXISTS `cidade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `codigo_ibge` int NOT NULL,
  `estado_id` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `cidade`
--

INSERT INTO `cidade` (`id`, `nome`, `codigo_ibge`, `estado_id`) VALUES
(1, 'Salvador', 45416000, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta_receber`
--

DROP TABLE IF EXISTS `conta_receber`;
CREATE TABLE IF NOT EXISTS `conta_receber` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dt_emissao` datetime NOT NULL,
  `dt_vencimento` datetime NOT NULL,
  `dt_pagamento` datetime NOT NULL,
  `pessoa_id` int NOT NULL,
  `valor` double NOT NULL,
  `ano` text NOT NULL,
  `mes` text NOT NULL,
  `obs` text NOT NULL,
  `ativo` char(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contrato`
--

DROP TABLE IF EXISTS `contrato`;
CREATE TABLE IF NOT EXISTS `contrato` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente_id` int NOT NULL,
  `tipo_contrato_id` int NOT NULL,
  `ativo` varchar(3) NOT NULL,
  `dt_inicio` datetime NOT NULL,
  `dt_fim` datetime NOT NULL,
  `obs` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contrato_item`
--

DROP TABLE IF EXISTS `contrato_item`;
CREATE TABLE IF NOT EXISTS `contrato_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `servico_id` int NOT NULL,
  `contrato_id` int NOT NULL,
  `valor` double NOT NULL,
  `quantidade` int NOT NULL,
  `total` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uf` varchar(3) NOT NULL,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `estado`
--

INSERT INTO `estado` (`id`, `uf`, `nome`) VALUES
(1, 'BA', 'Bahia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fatura`
--

DROP TABLE IF EXISTS `fatura`;
CREATE TABLE IF NOT EXISTS `fatura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente_id` int NOT NULL,
  `dt_fatura` date NOT NULL,
  `mes` text NOT NULL,
  `ano` text NOT NULL,
  `total` int NOT NULL,
  `financeiro_gerado` int NOT NULL,
  `ativo` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fatura_conta_receber`
--

DROP TABLE IF EXISTS `fatura_conta_receber`;
CREATE TABLE IF NOT EXISTS `fatura_conta_receber` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fatura_id` int NOT NULL,
  `conta_receber_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fatura_item`
--

DROP TABLE IF EXISTS `fatura_item`;
CREATE TABLE IF NOT EXISTS `fatura_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `servico_id` int NOT NULL,
  `fatura_id` int NOT NULL,
  `valor` double NOT NULL,
  `quantidade` int NOT NULL,
  `total` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

DROP TABLE IF EXISTS `grupo`;
CREATE TABLE IF NOT EXISTS `grupo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`id`, `nome`) VALUES
(1, 'Industria');

-- --------------------------------------------------------

--
-- Estrutura da tabela `papel`
--

DROP TABLE IF EXISTS `papel`;
CREATE TABLE IF NOT EXISTS `papel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `papel`
--

INSERT INTO `papel` (`id`, `nome`) VALUES
(1, 'Cliente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

DROP TABLE IF EXISTS `pessoa`;
CREATE TABLE IF NOT EXISTS `pessoa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `nome_fantasia` varchar(120) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `codigo_nacional` text NOT NULL,
  `codigo_estadual` text NOT NULL,
  `codigo_municipal` text NOT NULL,
  `fone` text NOT NULL,
  `email` text NOT NULL,
  `observacao` text NOT NULL,
  `cep` text NOT NULL,
  `logradouro` text NOT NULL,
  `numero` text NOT NULL,
  `complemento` text NOT NULL,
  `bairro` text NOT NULL,
  `cidade_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `grupo_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`id`, `nome`, `nome_fantasia`, `tipo`, `codigo_nacional`, `codigo_estadual`, `codigo_municipal`, `fone`, `email`, `observacao`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade_id`, `created_at`, `updated_at`, `grupo_id`) VALUES
(1, 'Ramon Barbosa', 'Ramon', 'F', '85778905548', '41720-040', '41720-040', '73982229817', 'ramonplay2016@gmail.com', 'teste', '41.720-040', 'Avenida Jorge Amado', '370', 'asdsad', 'Imbui', 1, '2023-05-17 15:09:42', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa_papel`
--

DROP TABLE IF EXISTS `pessoa_papel`;
CREATE TABLE IF NOT EXISTS `pessoa_papel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pessoa_id` int NOT NULL,
  `papel_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `pessoa_papel`
--

INSERT INTO `pessoa_papel` (`id`, `pessoa_id`, `papel_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

DROP TABLE IF EXISTS `servico`;
CREATE TABLE IF NOT EXISTS `servico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `valor` double NOT NULL,
  `tipo_servico_id` int NOT NULL,
  `ativo` char(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_contrato`
--

DROP TABLE IF EXISTS `tipo_contrato`;
CREATE TABLE IF NOT EXISTS `tipo_contrato` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_servico`
--

DROP TABLE IF EXISTS `tipo_servico`;
CREATE TABLE IF NOT EXISTS `tipo_servico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
