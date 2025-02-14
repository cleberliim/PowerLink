-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 14/02/2025 às 10:59
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `powerlink`
--
CREATE DATABASE IF NOT EXISTS `powerlink` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `powerlink`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `bi`
--

DROP TABLE IF EXISTS `bi`;
CREATE TABLE IF NOT EXISTS `bi` (
  `id_menu` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `link_bi` varchar(255) NOT NULL DEFAULT '#',
  PRIMARY KEY (`id_menu`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `bi`
--

INSERT INTO `bi` (`id_menu`, `nome`, `descricao`, `criado_em`, `link_bi`) VALUES
(1, 'Financeiro', 'Exibe dados financeiros da empresa', '2025-02-06 16:38:35', 'https://app.powerbi.com/view?r=eyJrIjoiNTRiN2VmMTEtYTgwOS00NDQyLTllMmEtMjdiOTllY2RjZDkwIiwidCI6IjE0NmMwOWZmLTg1MGEtNDA5OS04ZGUxLWJlMGIxNDNjYjRlOCJ9'),
(2, 'Relatório de Vendas', 'Exibe informações sobre vendas realizadas', '2025-02-06 16:38:35', 'https://app.powerbi.com/view?r=eyJrIjoiNjRjNDA3ZDktZThkZi00N2ZmLWFjZDAtZGE3YmI5YjFkNjg1IiwidCI6IjE0NmMwOWZmLTg1MGEtNDA5OS04ZGUxLWJlMGIxNDNjYjRlOCJ9');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `criado_em`) VALUES
(5, 'Cleber de Lima Oliveira', 'cleberliim@outlook.com', '$2y$10$xycjJ9a8xzbsfTWoRDlTGeO866lnxKKNOsq6SsHNx7z1VFuROJqoy', '2025-02-14 10:38:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_bi`
--

DROP TABLE IF EXISTS `usuario_bi`;
CREATE TABLE IF NOT EXISTS `usuario_bi` (
  `id_usuario` int NOT NULL,
  `id_bi` int NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_bi`),
  KEY `id_bi` (`id_bi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuario_bi`
--

INSERT INTO `usuario_bi` (`id_usuario`, `id_bi`) VALUES
(5, 1),
(5, 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
