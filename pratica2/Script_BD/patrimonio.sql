-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 10-Abr-2023 às 21:00
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
-- Estrutura da tabela `cidade`
--

DROP TABLE IF EXISTS `cidade`;
CREATE TABLE IF NOT EXISTS `cidade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nm_cidade` varchar(255) NOT NULL,
  `cep` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estado_id` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `cidade`
--

INSERT INTO `cidade` (`id`, `nm_cidade`, `cep`, `estado_id`) VALUES
(1, 'Salvador', '41720040', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `id` int NOT NULL,
  `nm_estado` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sigla` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `estado`
--

INSERT INTO `estado` (`id`, `nm_estado`, `sigla`) VALUES
(1, 'Bahia', 'BA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE IF NOT EXISTS `funcionario` (
  `nu_cpfFunc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nm_funcionario` varchar(255) NOT NULL,
  `nu_matricula` varchar(20) NOT NULL,
  `tp_genero` varchar(1) NOT NULL,
  `rua` varchar(120) NOT NULL,
  `bairro` varchar(120) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `cidade_id` int NOT NULL,
  `nu_rg` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `orgao_emissor` varchar(5) NOT NULL,
  PRIMARY KEY (`nu_cpfFunc`),
  UNIQUE KEY `nu_cpfFunc` (`nu_cpfFunc`),
  UNIQUE KEY `nu_matricula` (`nu_matricula`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`nu_cpfFunc`, `nm_funcionario`, `nu_matricula`, `tp_genero`, `rua`, `bairro`, `uf`, `cidade_id`, `nu_rg`, `orgao_emissor`) VALUES
('85778905548', 'Ramon Barbosa Souza', '2', 'M', 'Jorge Amado', 'Imbui', '1', 1, '8563552255', 'SSP');

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
-- Estrutura da tabela `locatao_setor`
--

DROP TABLE IF EXISTS `locatao_setor`;
CREATE TABLE IF NOT EXISTS `locatao_setor` (
  `sq_lotacao` int NOT NULL AUTO_INCREMENT,
  `nu_cpfFunc` varchar(11) NOT NULL,
  `cd_orgaoEstru` varchar(4) NOT NULL,
  `cd_unidEstru` varchar(4) NOT NULL,
  `cd_setorEstru` int NOT NULL,
  `dt_inicio` date NOT NULL,
  PRIMARY KEY (`sq_lotacao`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `locatao_setor`
--

INSERT INTO `locatao_setor` (`sq_lotacao`, `nu_cpfFunc`, `cd_orgaoEstru`, `cd_unidEstru`, `cd_setorEstru`, `dt_inicio`) VALUES
(1, '85778905548', '4', '4', 4, '0000-00-00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `orgao`
--

DROP TABLE IF EXISTS `orgao`;
CREATE TABLE IF NOT EXISTS `orgao` (
  `nu_cnpj` varchar(14) NOT NULL,
  `cd_orgao` varchar(5) NOT NULL,
  `dt_ano` year NOT NULL,
  `nm_orgao` varchar(120) NOT NULL,
  `tp_poder` char(1) NOT NULL,
  `nu_telefone` varchar(15) NOT NULL,
  `ds_email` varchar(120) NOT NULL,
  `dt_anoMes` varchar(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `orgao`
--

INSERT INTO `orgao` (`nu_cnpj`, `cd_orgao`, `dt_ano`, `nm_orgao`, `tp_poder`, `nu_telefone`, `ds_email`, `dt_anoMes`) VALUES
('00642856000160', '01', 2023, 'Câmera Municipal', '2', '99999999', 'teste@gmail.com', '202304');

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
('00642856000160', 1, 'Secretaria de Educação', '0000-00-00 00:00:00', 'Município Teste ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `setor_orgao_unid`
--

DROP TABLE IF EXISTS `setor_orgao_unid`;
CREATE TABLE IF NOT EXISTS `setor_orgao_unid` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nu_cnpj` varchar(14) NOT NULL,
  `sq_setor` int NOT NULL,
  `dt_ano` year NOT NULL,
  `cd_orgao` varchar(6) NOT NULL,
  `cd_unidOrcamentaria` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `setor_orgao_unid`
--

INSERT INTO `setor_orgao_unid` (`id`, `nu_cnpj`, `sq_setor`, `dt_ano`, `cd_orgao`, `cd_unidOrcamentaria`) VALUES
(4, '00642856000160', 1, 2023, '01', '0101');

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `unid_orcamentaria`
--

DROP TABLE IF EXISTS `unid_orcamentaria`;
CREATE TABLE IF NOT EXISTS `unid_orcamentaria` (
  `nu_cnpj` varchar(14) NOT NULL,
  `cd_unidOrcamentaria` varchar(5) NOT NULL,
  `dt_ano` year NOT NULL,
  `nm_unidOrcamentaria` varchar(120) NOT NULL,
  `nu_telefone` varchar(15) NOT NULL,
  `ds_email` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dt_anoMes` varchar(6) NOT NULL,
  PRIMARY KEY (`cd_unidOrcamentaria`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `unid_orcamentaria`
--

INSERT INTO `unid_orcamentaria` (`nu_cnpj`, `cd_unidOrcamentaria`, `dt_ano`, `nm_unidOrcamentaria`, `nu_telefone`, `ds_email`, `dt_anoMes`) VALUES
('00642856000160', '0101', 2023, 'Camara Municipal', '99999999', 'teste@gmail.com', '202304');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
