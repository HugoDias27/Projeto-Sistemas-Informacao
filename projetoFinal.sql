DROP DATABASE projetofinal;
CREATE DATABASE projetofinal;
USE projetofinal;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: projetofinal
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` VALUES ('admin','1',1704713466),('cliente','3',1704713466),('funcionario','2',1704713466);

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` VALUES ('admin',1,NULL,NULL,NULL,1704713466,1704713466),('cliente',1,NULL,NULL,NULL,1704713466,1704713466),('createCarrinhoCompras',2,'Criar Carrinho de Compras',NULL,NULL,1704713466,1704713466),('createCategorias',2,'Criar categorias',NULL,NULL,1704713466,1704713466),('createDespesa',2,'Criar despesa',NULL,NULL,1704713465,1704713465),('createEstabelecimento',2,'Criar estabelecimento',NULL,NULL,1704713465,1704713465),('createFatura',2,'Criar fatura',NULL,NULL,1704713465,1704713465),('createFornecedor',2,'Criar fornecedor',NULL,NULL,1704713465,1704713465),('createFuncionario',2,'Criar funcionario',NULL,NULL,1704713465,1704713465),('createIvas',2,'Criar Ivas',NULL,NULL,1704713466,1704713466),('createMedicamento',2,'Criar um medicamento',NULL,NULL,1704713465,1704713465),('createReceita',2,'Criar receita medica',NULL,NULL,1704713465,1704713465),('createServico',2,'Criar servico',NULL,NULL,1704713466,1704713466),('createUser',2,'Criar user',NULL,NULL,1704713465,1704713465),('createUtente',2,'Criar utente',NULL,NULL,1704713465,1704713465),('deleteCarrinhoCompras',2,'Apagar Carrinho de Compras',NULL,NULL,1704713466,1704713466),('deleteCategorias',2,NULL,NULL,NULL,1704713466,1704713466),('deleteDespesa',2,'Apagar despesa',NULL,NULL,1704713465,1704713465),('deleteEstabelecimento',2,'Apagar o estabelecimento',NULL,NULL,1704713465,1704713465),('deleteFatura',2,'Apagar fatura',NULL,NULL,1704713466,1704713466),('deleteFornecedor',2,'Apagar fornecedor',NULL,NULL,1704713465,1704713465),('deleteFuncionario',2,'Apagar funcionario',NULL,NULL,1704713465,1704713465),('deleteIvas',2,'Apagar Ivas',NULL,NULL,1704713466,1704713466),('deleteMedicamento',2,'Apagar um medicamento',NULL,NULL,1704713465,1704713465),('deleteReceita',2,'Apagar a receita medica',NULL,NULL,1704713465,1704713465),('deleteServico',2,'Apagar servico',NULL,NULL,1704713466,1704713466),('deleteUser',2,'Apagar o user',NULL,NULL,1704713465,1704713465),('deleteUtente',2,'Apagar o utente',NULL,NULL,1704713465,1704713465),('funcionario',1,NULL,NULL,NULL,1704713466,1704713466),('updateCarrinhoCompras',2,'Editar Carrinho de Compras',NULL,NULL,1704713466,1704713466),('updateCategorias',2,'Atualizar categorias',NULL,NULL,1704713466,1704713466),('updateDespesa',2,'Editar despesa',NULL,NULL,1704713465,1704713465),('updateEstabelecimento',2,'Editar o estabelecimento',NULL,NULL,1704713465,1704713465),('updateFornecedor',2,'Editar o fornecedor',NULL,NULL,1704713465,1704713465),('updateFuncionario',2,'Editar o funcionario',NULL,NULL,1704713465,1704713465),('updateIvas',2,'Editar Ivas',NULL,NULL,1704713466,1704713466),('updateMedicamento',2,'Atualizar um medicamento',NULL,NULL,1704713465,1704713465),('updateServico',2,'Editar servico',NULL,NULL,1704713466,1704713466),('updateUser',2,'Editar o user',NULL,NULL,1704713465,1704713465),('updateUtente',2,'Editar o utente',NULL,NULL,1704713465,1704713465),('viewCarrinhoCompras',2,'Ver Carrinho de Compras',NULL,NULL,1704713466,1704713466),('viewCategorias',2,'Ver categorias',NULL,NULL,1704713466,1704713466),('viewDespesa',2,'Ver as despesas',NULL,NULL,1704713465,1704713465),('viewEstabelecimento',2,'Ver os estabelecimentos',NULL,NULL,1704713465,1704713465),('viewFatura',2,'Ver fatura',NULL,NULL,1704713465,1704713465),('viewFornecedor',2,'Ver os fornecedores',NULL,NULL,1704713465,1704713465),('viewFuncionario',2,'Ver os funcionarios',NULL,NULL,1704713465,1704713465),('viewIvas',2,'Ver Ivas',NULL,NULL,1704713466,1704713466),('viewMedicamento',2,'Ver os medicamentos',NULL,NULL,1704713465,1704713465),('viewReceita',2,'Ver as receitas medicas',NULL,NULL,1704713465,1704713465),('viewServico',2,'Ver servicos',NULL,NULL,1704713466,1704713466),('viewUser',2,'Ver os users',NULL,NULL,1704713465,1704713465),('viewUtente',2,'Ver os utentes',NULL,NULL,1704713465,1704713465);

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` VALUES ('funcionario','cliente'),('cliente','createCarrinhoCompras'),('funcionario','createCategorias'),('funcionario','createDespesa'),('admin','createEstabelecimento'),('funcionario','createFatura'),('admin','createFornecedor'),('admin','createFuncionario'),('funcionario','createIvas'),('funcionario','createMedicamento'),('funcionario','createReceita'),('funcionario','createServico'),('admin','createUser'),('funcionario','createUtente'),('cliente','deleteCarrinhoCompras'),('admin','deleteCategorias'),('admin','deleteDespesa'),('funcionario','deleteDespesa'),('admin','deleteEstabelecimento'),('admin','deleteFatura'),('admin','deleteFornecedor'),('admin','deleteFuncionario'),('funcionario','deleteMedicamento'),('admin','deleteReceita'),('admin','deleteServico'),('admin','deleteUser'),('admin','deleteUtente'),('admin','funcionario'),('cliente','updateCarrinhoCompras'),('funcionario','updateCategorias'),('funcionario','updateDespesa'),('admin','updateEstabelecimento'),('admin','updateFornecedor'),('admin','updateFuncionario'),('admin','updateIvas'),('funcionario','updateMedicamento'),('funcionario','updateServico'),('admin','updateUser'),('funcionario','updateUtente'),('cliente','viewCarrinhoCompras'),('cliente','viewCategorias'),('cliente','viewDespesa'),('funcionario','viewEstabelecimento'),('cliente','viewFatura'),('funcionario','viewFornecedor'),('admin','viewFuncionario'),('funcionario','viewIvas'),('cliente','viewMedicamento'),('cliente','viewReceita'),('cliente','viewServico'),('admin','viewUser'),('funcionario','viewUtente');

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB;

--
-- Table structure for table `carrinho_compras`
--

DROP TABLE IF EXISTS `carrinho_compras`;
CREATE TABLE `carrinho_compras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dta_venda` datetime DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `valortotal` double DEFAULT NULL,
  `ivatotal` double DEFAULT NULL,
  `cliente_id` int NOT NULL,
  `fatura_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_carrinho_compras_profiles1_idx` (`cliente_id`),
  KEY `fk_carrinho_compras_faturas1_idx` (`fatura_id`),
  CONSTRAINT `fk_carrinho_compras_faturas1` FOREIGN KEY (`fatura_id`) REFERENCES `faturas` (`id`),
  CONSTRAINT `fk_carrinho_compras_profiles1` FOREIGN KEY (`cliente_id`) REFERENCES `profiles` (`user_id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `carrinho_compras`
--

INSERT INTO `carrinho_compras` VALUES (1,'2024-01-08 00:00:00',5,23.32,0.58,3,2);

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` VALUES (1,'saude_oral'),(2,'bens_beleza'),(3,'higiene');

--
-- Table structure for table `despesas`
--

DROP TABLE IF EXISTS `despesas`;
CREATE TABLE `despesas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `preco` double NOT NULL,
  `dta_despesa` datetime NOT NULL,
  `descricao` varchar(60) DEFAULT NULL,
  `estabelecimento_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_despesas_estabelecimentos1_idx` (`estabelecimento_id`),
  CONSTRAINT `fk_despesas_estabelecimentos1` FOREIGN KEY (`estabelecimento_id`) REFERENCES `estabelecimentos` (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `despesas`
--

INSERT INTO `despesas` VALUES (1,3500,'2023-10-25 00:00:00','Pagamento de Salários',1);

--
-- Table structure for table `estabelecimentos`
--

DROP TABLE IF EXISTS `estabelecimentos`;
CREATE TABLE `estabelecimentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `morada` varchar(45) NOT NULL,
  `telefone` int NOT NULL,
  `email` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `estabelecimentos`
--

INSERT INTO `estabelecimentos` VALUES (1,'Carolo Farmacêutica','Leiria',236550900,'carolofarmaceuticaleiria@gmail.com');

--
-- Table structure for table `faturas`
--

DROP TABLE IF EXISTS `faturas`;
CREATE TABLE `faturas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dta_emissao` datetime NOT NULL,
  `valortotal` double NOT NULL,
  `ivatotal` double NOT NULL,
  `cliente_id` int NOT NULL,
  `estabelecimento_id` int DEFAULT NULL,
  `emissor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_faturas_profiles1_idx` (`cliente_id`),
  KEY `fk_faturas_estabelecimentos1_idx` (`estabelecimento_id`),
  KEY `fk_faturas_profiles2_idx` (`emissor_id`),
  CONSTRAINT `fk_faturas_estabelecimentos1` FOREIGN KEY (`estabelecimento_id`) REFERENCES `estabelecimentos` (`id`),
  CONSTRAINT `fk_faturas_profiles1` FOREIGN KEY (`cliente_id`) REFERENCES `profiles` (`user_id`),
  CONSTRAINT `fk_faturas_profiles2` FOREIGN KEY (`emissor_id`) REFERENCES `profiles` (`user_id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `faturas`
--

INSERT INTO `faturas` VALUES (1,'2024-01-08 00:00:00',21.062,1.562,3,1,1),(2,'2024-01-08 00:00:00',23.32,0.58,3,NULL,NULL);

--
-- Table structure for table `fornecedores`
--

DROP TABLE IF EXISTS `fornecedores`;
CREATE TABLE `fornecedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `telefone` int NOT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `fornecedores`
--

INSERT INTO `fornecedores` VALUES (1,'MDM Pharma',239556000,'mdmpharma@gmail.com'),(2,'Stock Farmácias',239550600,'stocksfarmacias@gmail.com');

--
-- Table structure for table `fornecedores_produtos`
--

DROP TABLE IF EXISTS `fornecedores_produtos`;
CREATE TABLE `fornecedores_produtos` (
  `produto_id` int NOT NULL,
  `fornecedor_id` int NOT NULL,
  `data_importacao` datetime NOT NULL,
  `quantidade` int NOT NULL,
  `hora_importacao` time NOT NULL,
  PRIMARY KEY (`produto_id`,`fornecedor_id`),
  KEY `fk_produtos_has_fornecedores_fornecedores1_idx` (`fornecedor_id`),
  KEY `fk_produtos_has_fornecedores_produtos1_idx` (`produto_id`),
  CONSTRAINT `fk_produtos_has_fornecedores_fornecedores1` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`),
  CONSTRAINT `fk_produtos_has_fornecedores_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `fornecedores_produtos`
--

INSERT INTO `fornecedores_produtos` VALUES (1,1,'2024-01-08 00:00:00',20,'11:30:00'),(2,1,'2024-01-08 00:00:00',20,'11:50:00'),(3,1,'2024-01-04 00:00:00',20,'08:30:00'),(4,1,'2024-01-03 00:00:00',40,'11:57:00'),(5,1,'2024-01-02 00:00:00',20,'13:00:00'),(6,1,'2024-01-07 00:00:00',20,'12:06:00'),(7,2,'2024-01-08 00:00:00',22,'12:00:00'),(8,2,'2024-01-08 00:00:00',10,'12:00:00'),(9,1,'2023-12-28 00:00:00',21,'14:10:00'),(10,1,'2024-01-08 00:00:00',2,'13:20:00');

--
-- Table structure for table `imagens`
--

DROP TABLE IF EXISTS `imagens`;
CREATE TABLE `imagens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(60) NOT NULL,
  `produto_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_imagens_produtos1_idx` (`produto_id`),
  CONSTRAINT `fk_imagens_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `imagens`
--

INSERT INTO `imagens` VALUES (1,'652D9F82-7EF9-4605-94D5-2E97C655F30A',1),(2,'380375F9-62F5-44FF-B67F-440FC83C55CE',2),(3,'E994E0E4-9C6F-4B65-9B91-5C16F772A168',3),(4,'EFD8EDFA-7A40-4442-B942-7BD38CCE5751',4),(5,'5E8E96CE-3FBC-447D-B341-AEF628BD9A8C',5),(6,'24F09575-74F6-4514-B55E-509A47C3B4C6',6),(7,'C9C6C319-D1A8-49A9-9DCD-6D34B3E25988',7),(8,'C885FFB9-F889-4383-98A0-CBCF552226C1',8),(9,'671F978C-7FAE-42B5-A3C3-A1EA6A69F9BC',9),(10,'E25D9263-D508-4C0E-9E4B-AE93CAEF6FD5',10);

--
-- Table structure for table `ivas`
--

DROP TABLE IF EXISTS `ivas`;
CREATE TABLE `ivas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `percentagem` int NOT NULL,
  `vigor` tinyint(1) NOT NULL,
  `descricao` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `ivas`
--

INSERT INTO `ivas` VALUES (1,6,1,''),(2,13,1,'');

--
-- Table structure for table `linha_faturas`
--

DROP TABLE IF EXISTS `linha_faturas`;
CREATE TABLE `linha_faturas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dta_venda` datetime NOT NULL,
  `quantidade` int NOT NULL,
  `precounit` double NOT NULL,
  `valoriva` double NOT NULL,
  `valorcomiva` double NOT NULL,
  `subtotal` double NOT NULL,
  `fatura_id` int NOT NULL,
  `receita_medica_id` int DEFAULT NULL,
  `servico_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_linha_faturas_faturas1_idx` (`fatura_id`),
  KEY `fk_linha_faturas_receitas_medica1_idx` (`receita_medica_id`),
  KEY `fk_linha_faturas_servicos1_idx` (`servico_id`),
  CONSTRAINT `fk_linha_faturas_faturas1` FOREIGN KEY (`fatura_id`) REFERENCES `faturas` (`id`),
  CONSTRAINT `fk_linha_faturas_receitas_medica1` FOREIGN KEY (`receita_medica_id`) REFERENCES `receitas_medica` (`id`),
  CONSTRAINT `fk_linha_faturas_servicos1` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `linha_faturas`
--

INSERT INTO `linha_faturas` VALUES (1,'2024-01-08 00:00:00',1,5.6,0.728,6.328,6.328,1,NULL,3),(2,'2024-01-08 00:00:00',2,6.95,0.417,7.367,14.734,1,1,NULL);

--
-- Table structure for table `linhas_carrinho`
--

DROP TABLE IF EXISTS `linhas_carrinho`;
CREATE TABLE `linhas_carrinho` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantidade` int NOT NULL,
  `precounit` double NOT NULL,
  `valoriva` double NOT NULL,
  `valorcomiva` double NOT NULL,
  `subtotal` double NOT NULL,
  `carrinho_compra_id` int NOT NULL,
  `produto_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_linhas_carrinho_carrinho_compras1_idx` (`carrinho_compra_id`),
  KEY `fk_linhas_carrinho_produtos1_idx` (`produto_id`),
  CONSTRAINT `fk_linhas_carrinho_carrinho_compras1` FOREIGN KEY (`carrinho_compra_id`) REFERENCES `carrinho_compras` (`id`),
  CONSTRAINT `fk_linhas_carrinho_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `linhas_carrinho`
--

INSERT INTO `linhas_carrinho` VALUES (1,3,2.7,0.16,2.86,8.58,1,1),(2,2,6.95,0.42,7.37,14.74,1,2);

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `prescricao_medica` tinyint(1) NOT NULL,
  `preco` double NOT NULL,
  `quantidade` int NOT NULL,
  `categoria_id` int DEFAULT NULL,
  `iva_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produtos_categorias1_idx` (`categoria_id`),
  KEY `fk_produtos_ivas1_idx` (`iva_id`),
  CONSTRAINT `fk_produtos_categorias1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  CONSTRAINT `fk_produtos_ivas1` FOREIGN KEY (`iva_id`) REFERENCES `ivas` (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` VALUES (1,'Ben-U-Ron, 500 mg x 20 comp',0,2.7,17,NULL,1),(2,'Brufen, 400 mg x 20 comp rev',1,6.95,18,NULL,1),(3,'Brufen Sem Açúcar, 20 mg/mL-200mL',1,7.12,20,NULL,1),(4,'Corega POWER MAX FIXAÇÃO+CONFORTO Creme',0,12.64,40,1,1),(5,'Iraltone Champô fortificante, Frasco 400ml',0,21.28,20,2,1),(6,'Vichy Homme Mousse de barbear anti-irritações',0,11.2,20,3,1),(7,'Corega Total Pastilha de limpeza diária',0,12.22,36,1,2),(8,'Uriage Age Lift Peel Creme de noite pele nova',0,43.49,10,2,2),(9,'Vichy Dercos Aminexil Clinical 5 monodoses H',0,59.9,21,3,2),(10,'Concerta 18mg',1,20,0,NULL,2);

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `n_utente` int DEFAULT NULL,
  `nif` int NOT NULL,
  `morada` varchar(30) NOT NULL,
  `telefone` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_profiles_user1_idx` (`user_id`),
  CONSTRAINT `fk_profiles_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` VALUES (1,NULL,270263195,'Leiria',236550000,1),(2,NULL,236682652,'Leiria',236550000,2),(3,123456789,291704336,'Leiria',964000500,3);

--
-- Table structure for table `receitas_medica`
--

DROP TABLE IF EXISTS `receitas_medica`;
CREATE TABLE `receitas_medica` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` int NOT NULL,
  `local_prescricao` varchar(45) NOT NULL,
  `medico_prescricao` varchar(45) NOT NULL,
  `dosagem` int NOT NULL,
  `data_validade` datetime NOT NULL,
  `telefone` int NOT NULL,
  `valido` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `posologia` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_receitas_medica_profiles1_idx` (`user_id`),
  KEY `fk_receitas_medica_produtos1_idx` (`posologia`),
  CONSTRAINT `fk_receitas_medica_produtos1` FOREIGN KEY (`posologia`) REFERENCES `produtos` (`id`),
  CONSTRAINT `fk_receitas_medica_profiles1` FOREIGN KEY (`user_id`) REFERENCES `profiles` (`user_id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `receitas_medica`
--

INSERT INTO `receitas_medica` VALUES (1,1234,'Leiria','Pedro Francisco',1,'2024-01-10 00:00:00',236559000,1,3,10),(2,5678,'Leiria','Pedro Francisco',1,'2024-01-12 00:00:00',239556000,1,3,3),(3,9632,'Leiria','Pedro Francisco',2,'2024-01-13 00:00:00',239556000,0,3,2);

--
-- Table structure for table `servicos`
--

DROP TABLE IF EXISTS `servicos`;
CREATE TABLE `servicos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `duracao` time NOT NULL,
  `preco` double NOT NULL,
  `iva_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_servicos_ivas1_idx` (`iva_id`),
  CONSTRAINT `fk_servicos_ivas1` FOREIGN KEY (`iva_id`) REFERENCES `ivas` (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `servicos`
--

INSERT INTO `servicos` VALUES (1,'Recolha de Sangue','02:00:00',1.6,1),(2,'Teste Covid-19','01:00:00',1.2,1),(3,'Vacina da Gripe','01:00:00',5.6,2);

--
-- Table structure for table `servicos_estabelecimentos`
--

DROP TABLE IF EXISTS `servicos_estabelecimentos`;
CREATE TABLE `servicos_estabelecimentos` (
  `estabelecimento_id` int NOT NULL,
  `servico_id` int NOT NULL,
  PRIMARY KEY (`estabelecimento_id`,`servico_id`),
  KEY `fk_estabelecimentos_has_servicos_servicos1_idx` (`servico_id`),
  KEY `fk_estabelecimentos_has_servicos_estabelecimentos1_idx` (`estabelecimento_id`),
  CONSTRAINT `fk_estabelecimentos_has_servicos_estabelecimentos1` FOREIGN KEY (`estabelecimento_id`) REFERENCES `estabelecimentos` (`id`),
  CONSTRAINT `fk_estabelecimentos_has_servicos_servicos1` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`)
) ENGINE=InnoDB;

--
-- Dumping data for table `servicos_estabelecimentos`
--

INSERT INTO `servicos_estabelecimentos` VALUES (1,3);

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB;

--
-- Dumping data for table `user`
--

INSERT INTO `user` VALUES (1,'admin','Rt3T6-TpKJO81Y7QMcUauqi0cPTxcNA3','$2y$13$ZYwWJvd.Z2N/MEvqiUSt8uOrSSI9uFvZB77GGS/ue/wibjz831DGe',NULL,'admin@admin.pt',10,1704713397,1704713397,NULL),(2,'Pedro Francisco','lElsS5qqfSGfkBZhw6_CyzvjNeS7PPE9','$2y$13$VQm61j5ZJ4BgRKawVYC7CO0OEdi1/oE1VbLxqB5zCfajxTNEodUu2',NULL,'pedrofrancisco@gmail.com',10,1704713423,1704713423,NULL),(3,'Tiago Saramago','YjtNoMJya8Ammr1GQOgB6ShjqgyRHLbv','$2y$13$P/U..lMOnyiI8C0L3E3zRegksmSLpU8fOIXuG94cJtKX0Gy578eq2',NULL,'tiagosaramago@sapo.pt',10,1704713441,1704713441,NULL);

CREATE TABLE IF NOT EXISTS `prestacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `valor` DOUBLE NOT NULL,
  `data` DATE NOT NULL,
  `id_utilizador` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_prestacoes_profiles_idx` (`id_utilizador` ASC) VISIBLE,
  CONSTRAINT `fk_prestacoes_profiles`
    FOREIGN KEY (`id_utilizador`)
    REFERENCES `projetofinal`.`profiles` (`id`))
ENGINE = InnoDB;


/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-08 14:34:04
