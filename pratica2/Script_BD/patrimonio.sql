-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 04-Abr-2023 às 21:08
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
-- Banco de dados: `patrimonio`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

DROP TABLE IF EXISTS `grupo`;
CREATE TABLE IF NOT EXISTS `grupo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cd_grupo` varchar(4) NOT NULL,
  `nm_grupo` varchar(120) NOT NULL,
  `ds_grupo` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`id`, `cd_grupo`, `nm_grupo`, `ds_grupo`) VALUES
(1, '5241', 'Moveis e Utensílios ', 0),
(2, '5239', 'Veiculos', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `nu_cnpj` varchar(14) NOT NULL,
  `sq_produto` int NOT NULL AUTO_INCREMENT,
  `nm_produto` varchar(120) NOT NULL,
  `ds_produto` text NOT NULL,
  `cd_grupo` varchar(4) NOT NULL,
  `sq_unidade` int NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `dt_desativacao` datetime NOT NULL,
  PRIMARY KEY (`sq_produto`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`nu_cnpj`, `sq_produto`, `nm_produto`, `ds_produto`, `cd_grupo`, `sq_unidade`, `dt_cadastro`, `dt_desativacao`) VALUES
('', 1, 'Carro', 'carro ', '5239', 3, '2023-04-04 17:47:52', '0000-00-00 00:00:00'),
('', 2, 'Geladeira', 'Geladeira de Inox', '5241', 2, '2023-04-04 18:07:35', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `setor`
--

DROP TABLE IF EXISTS `setor`;
CREATE TABLE IF NOT EXISTS `setor` (
  `nu_cnpj` varchar(14) NOT NULL,
  `sq_setor` int NOT NULL AUTO_INCREMENT,
  `nm_setor` varchar(120) NOT NULL,
  `dt_desativacao` datetime NOT NULL,
  `ds_endereco` varchar(255) NOT NULL,
  PRIMARY KEY (`sq_setor`),
  UNIQUE KEY `nu_cnpj` (`nu_cnpj`,`sq_setor`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `setor`
--

INSERT INTO `setor` (`nu_cnpj`, `sq_setor`, `nm_setor`, `dt_desativacao`, `ds_endereco`) VALUES
('', 1, 'Secretaria de Edu', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade`
--

DROP TABLE IF EXISTS `unidade`;
CREATE TABLE IF NOT EXISTS `unidade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_unidade` varchar(255) NOT NULL,
  `sigla` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `unidade`
--

INSERT INTO `unidade` (`id`, `nome_unidade`, `sigla`) VALUES
(1, 'Ampola', 'AMP'),
(2, 'Barra', 'BAR'),
(3, 'Unidade', 'UND');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
