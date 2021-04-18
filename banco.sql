-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           5.7.29 - MySQL Community Server (GPL)
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para join
CREATE DATABASE IF NOT EXISTS `join` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `join`;

-- Copiando estrutura para tabela join.tb_categoria_produto
CREATE TABLE IF NOT EXISTS `tb_categoria_produto` (
                                                      `id_categoria_planejamento` int(11) NOT NULL AUTO_INCREMENT,
                                                      `nome_categoria` varchar(150) DEFAULT NULL,
                                                      PRIMARY KEY (`id_categoria_planejamento`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela join.tb_produto
CREATE TABLE IF NOT EXISTS `tb_produto` (
                                            `id_produto` int(11) NOT NULL AUTO_INCREMENT,
                                            `id_categoria_produto` int(11) DEFAULT NULL,
                                            `data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                            `nome_produto` varchar(150) DEFAULT NULL,
                                            `valor_produto` float(10,2) NOT NULL DEFAULT '0.00',
                                            PRIMARY KEY (`id_produto`),
                                            KEY `IXFK_tb_produto_tb_categoria_produto` (`id_categoria_produto`) USING BTREE,
                                            CONSTRAINT `FK_tb_produto_tb_categoria_produto` FOREIGN KEY (`id_categoria_produto`) REFERENCES `tb_categoria_produto` (`id_categoria_planejamento`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
