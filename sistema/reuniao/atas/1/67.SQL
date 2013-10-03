-- phpMyAdmin SQL Dump
-- version 2.8.0.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 24, 2006 at 11:28 AM
-- Server version: 4.1.21
-- PHP Version: 4.4.2
-- 
-- Database: `heliomed_meucondominio`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `adtivos`
-- 

CREATE TABLE `adtivos` (
  `id_adtivos` int(10) unsigned NOT NULL auto_increment,
  `FKid_regimentosCol` int(10) unsigned NOT NULL default '0',
  `arquivo` blob,
  `aditivo` text,
  PRIMARY KEY  (`id_adtivos`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `adtivos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `area_custos`
-- 

CREATE TABLE `area_custos` (
  `id_area_custos` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(50) default NULL,
  `tipo` varchar(50) default NULL,
  PRIMARY KEY  (`id_area_custos`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `area_custos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `areas_lazer`
-- 

CREATE TABLE `areas_lazer` (
  `id_areas_lazer` int(10) unsigned NOT NULL auto_increment,
  `FKid_condominiosCol` int(10) unsigned NOT NULL default '0',
  `nome` varchar(50) default NULL,
  `tamanho` float default NULL,
  `situacao` tinyint(1) default NULL,
  PRIMARY KEY  (`id_areas_lazer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `areas_lazer`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `atas_reunioes`
-- 

CREATE TABLE `atas_reunioes` (
  `id_atas_reunioes` int(10) unsigned NOT NULL auto_increment,
  `FKid_membroscondominioCol` int(10) unsigned NOT NULL default '0',
  `data_insercao` datetime default NULL,
  `nome_arquivo` varchar(50) default NULL,
  PRIMARY KEY  (`id_atas_reunioes`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `atas_reunioes`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `atividades`
-- 

CREATE TABLE `atividades` (
  `id_atividades` int(10) unsigned NOT NULL auto_increment,
  `FKid_membroscondominioCol` int(10) unsigned NOT NULL default '0',
  `FKid_niveis_prioridadesCol` int(10) unsigned NOT NULL default '0',
  `descricao` varchar(110) default NULL,
  `data_realizacao` datetime default NULL,
  `situacao` tinyint(1) default NULL,
  PRIMARY KEY  (`id_atividades`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `atividades`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `centro_custos`
-- 

CREATE TABLE `centro_custos` (
  `id_centro_custos` int(10) unsigned NOT NULL auto_increment,
  `FKid_area_custosCol` int(10) unsigned NOT NULL default '0',
  `numero` int(10) unsigned default NULL,
  `nome` varchar(100) default NULL,
  PRIMARY KEY  (`id_centro_custos`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `centro_custos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `condominios`
-- 

CREATE TABLE `condominios` (
  `id_condominios` int(10) unsigned NOT NULL auto_increment,
  `qtd_apartamentos` int(10) unsigned default NULL,
  `tipo_logradouro` varchar(50) default NULL,
  `logradouro` varchar(50) default NULL,
  `numero_logradouro` varchar(10) default NULL,
  `bairro_logradouro` varchar(30) default NULL,
  `cep_logradouro` varchar(8) default NULL,
  `cidade_logradouro` varchar(25) default NULL,
  `uf_logradouro` char(2) default NULL,
  `CNPJ` varchar(14) default NULL,
  `telefone` varchar(25) default NULL,
  `qtd_blocos` int(10) unsigned default NULL,
  `situacao` tinyint(1) default NULL,
  PRIMARY KEY  (`id_condominios`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `condominios`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `criticas_sugestoes`
-- 

CREATE TABLE `criticas_sugestoes` (
  `id_criticas_sugestoes` int(10) unsigned NOT NULL auto_increment,
  `FKid_niveis_prioridadesCol` int(10) unsigned NOT NULL default '0',
  `FKid_membroscondominioCol` int(10) unsigned NOT NULL default '0',
  `data_envio` date default NULL,
  `mensagem` text,
  `situacao` varchar(20) default NULL,
  `visualizacao` varchar(30) default NULL,
  `destinatario` int(10) unsigned default NULL,
  `tipo` varchar(20) default NULL,
  `data_recebimento` datetime default NULL,
  `data_resolucao` datetime default NULL,
  PRIMARY KEY  (`id_criticas_sugestoes`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `criticas_sugestoes`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `destinatarios`
-- 

CREATE TABLE `destinatarios` (
  `FKid_membroscondominioCol` int(10) unsigned NOT NULL default '0',
  `FKid_mensagensCol` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `destinatarios`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `destinatarios_visualizadores`
-- 

CREATE TABLE `destinatarios_visualizadores` (
  `FKid_criticas_sugestoesCol` int(10) unsigned NOT NULL default '0',
  `FKid_membroscondominioCol` int(10) unsigned NOT NULL default '0',
  `tipo` tinyint(1) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `destinatarios_visualizadores`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `funcionarios_condominio`
-- 

CREATE TABLE `funcionarios_condominio` (
  `id_funcionarios_condominio` int(10) unsigned NOT NULL auto_increment,
  `FKid_condominiosCol` int(10) unsigned NOT NULL default '0',
  `FKid_tipos_funcionariosCol` int(10) unsigned NOT NULL default '0',
  `nome` varchar(50) default NULL,
  `data_nascimento` int(10) unsigned default NULL,
  `cpf` varchar(10) default NULL,
  `telefone` varchar(25) default NULL,
  `celular` varchar(25) default NULL,
  `email` varchar(50) default NULL,
  `login` varchar(25) default NULL,
  `senha` varchar(32) default NULL,
  `situacao` tinyint(1) default NULL,
  PRIMARY KEY  (`id_funcionarios_condominio`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `funcionarios_condominio`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `membros_condominio`
-- 

CREATE TABLE `membros_condominio` (
  `id_membroscondominio` int(10) unsigned NOT NULL default '0',
  `FKid_condominiosCol` int(10) unsigned NOT NULL default '0',
  `FKid_tipo_usuariosCol` int(10) unsigned NOT NULL default '0',
  `nome` varchar(50) default NULL,
  `data_nascimento` date default NULL,
  `cpf` varchar(10) default NULL,
  `telefone` varchar(25) NOT NULL default '',
  `celular` varchar(25) NOT NULL default '',
  `email` varchar(50) default NULL,
  `numero_apartamento` int(10) unsigned default NULL,
  `login` varchar(25) default NULL,
  `senha` varchar(32) default NULL,
  `proprietario` tinyint(1) default NULL,
  `situacao` tinyint(1) default NULL,
  PRIMARY KEY  (`id_membroscondominio`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `membros_condominio`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `mensagens`
-- 

CREATE TABLE `mensagens` (
  `id_mensagens` int(10) unsigned NOT NULL auto_increment,
  `FKid_membroscondominioCol` int(10) unsigned NOT NULL default '0',
  `mensagem` varchar(110) default NULL,
  `data_envio` datetime NOT NULL default '0000-00-00 00:00:00',
  `situacao` tinyint(1) default NULL,
  PRIMARY KEY  (`id_mensagens`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `mensagens`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `modulos`
-- 

CREATE TABLE `modulos` (
  `id_modulos` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(30) default NULL,
  PRIMARY KEY  (`id_modulos`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- 
-- Dumping data for table `modulos`
-- 

INSERT INTO `modulos` VALUES (1, 'Super Usuário');
INSERT INTO `modulos` VALUES (2, 'Tipos Permissão');
INSERT INTO `modulos` VALUES (3, 'Permissões');
INSERT INTO `modulos` VALUES (4, 'Tipos Usuários');
INSERT INTO `modulos` VALUES (5, 'Modulos');
INSERT INTO `modulos` VALUES (6, 'Participante');
INSERT INTO `modulos` VALUES (7, 'Atas Reunão');
INSERT INTO `modulos` VALUES (8, 'Mensagens');
INSERT INTO `modulos` VALUES (9, 'Destinatários');
INSERT INTO `modulos` VALUES (10, 'Publico Alvo');
INSERT INTO `modulos` VALUES (11, 'Atividades');
INSERT INTO `modulos` VALUES (12, 'Destinatário Visualizadores');
INSERT INTO `modulos` VALUES (13, 'Membro Condomínio');
INSERT INTO `modulos` VALUES (14, 'Reservas');
INSERT INTO `modulos` VALUES (15, 'Recursos Lazer');
INSERT INTO `modulos` VALUES (16, 'Níveis Prioridade');
INSERT INTO `modulos` VALUES (17, 'Críticas Sugestões');
INSERT INTO `modulos` VALUES (18, 'Condomínios');
INSERT INTO `modulos` VALUES (19, 'Areas Lazer');
INSERT INTO `modulos` VALUES (20, 'Objetos Lazer');
INSERT INTO `modulos` VALUES (21, 'Tipos Funcionários');
INSERT INTO `modulos` VALUES (22, 'Funcionários Condomínio');
INSERT INTO `modulos` VALUES (23, 'Regimentos');
INSERT INTO `modulos` VALUES (24, 'Servicos Terceirizados');
INSERT INTO `modulos` VALUES (25, 'Receita Despesa');
INSERT INTO `modulos` VALUES (26, 'Centro Custos');
INSERT INTO `modulos` VALUES (27, 'Aditivos');
INSERT INTO `modulos` VALUES (28, 'Tipos Servicos');
INSERT INTO `modulos` VALUES (29, 'Servidores');
INSERT INTO `modulos` VALUES (30, 'Area Custos');

-- --------------------------------------------------------

-- 
-- Table structure for table `niveis_prioridades`
-- 

CREATE TABLE `niveis_prioridades` (
  `id_niveis_prioridades` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(60) default NULL,
  PRIMARY KEY  (`id_niveis_prioridades`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `niveis_prioridades`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `objetos_lazer`
-- 

CREATE TABLE `objetos_lazer` (
  `id_objetos_lazer` int(10) unsigned NOT NULL auto_increment,
  `FKid_areas_lazerCol` int(10) unsigned NOT NULL default '0',
  `nome` varchar(50) default NULL,
  `idade_minima_utilizacao` int(10) unsigned default NULL,
  `tempo_minimo_reserva` time default NULL,
  `tempo_maximo_reserva` time default NULL,
  `descricao` text,
  `aviso` text,
  `situacao` tinyint(1) default NULL,
  PRIMARY KEY  (`id_objetos_lazer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `objetos_lazer`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `participante`
-- 

CREATE TABLE `participante` (
  `FKid_atas_reunioesCol` int(10) unsigned NOT NULL default '0',
  `FKid_membroscondominioCol` int(10) unsigned NOT NULL default '0',
  `funcao` varchar(50) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `participante`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `permissoes`
-- 

CREATE TABLE `permissoes` (
  `FKid_modulosCol` int(10) unsigned NOT NULL default '0',
  `FKid_tipos_permissoesCol` int(10) unsigned NOT NULL default '0',
  `FKid_tipo_usuariosCol` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`FKid_modulosCol`,`FKid_tipos_permissoesCol`,`FKid_tipo_usuariosCol`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `permissoes`
-- 

INSERT INTO `permissoes` VALUES (1, 1, 1);
INSERT INTO `permissoes` VALUES (1, 1, 2);
INSERT INTO `permissoes` VALUES (1, 1, 3);
INSERT INTO `permissoes` VALUES (1, 1, 4);
INSERT INTO `permissoes` VALUES (1, 1, 5);
INSERT INTO `permissoes` VALUES (1, 1, 6);
INSERT INTO `permissoes` VALUES (1, 1, 7);
INSERT INTO `permissoes` VALUES (1, 1, 8);
INSERT INTO `permissoes` VALUES (1, 1, 9);
INSERT INTO `permissoes` VALUES (1, 1, 10);
INSERT INTO `permissoes` VALUES (1, 1, 11);
INSERT INTO `permissoes` VALUES (1, 1, 12);
INSERT INTO `permissoes` VALUES (1, 1, 13);
INSERT INTO `permissoes` VALUES (1, 1, 14);
INSERT INTO `permissoes` VALUES (1, 1, 15);
INSERT INTO `permissoes` VALUES (1, 1, 16);
INSERT INTO `permissoes` VALUES (1, 1, 17);
INSERT INTO `permissoes` VALUES (1, 1, 18);
INSERT INTO `permissoes` VALUES (1, 1, 19);
INSERT INTO `permissoes` VALUES (1, 1, 20);
INSERT INTO `permissoes` VALUES (1, 1, 21);
INSERT INTO `permissoes` VALUES (1, 1, 22);
INSERT INTO `permissoes` VALUES (1, 1, 23);
INSERT INTO `permissoes` VALUES (1, 1, 24);
INSERT INTO `permissoes` VALUES (1, 1, 25);
INSERT INTO `permissoes` VALUES (1, 1, 26);
INSERT INTO `permissoes` VALUES (1, 1, 27);
INSERT INTO `permissoes` VALUES (1, 1, 28);
INSERT INTO `permissoes` VALUES (1, 1, 29);
INSERT INTO `permissoes` VALUES (1, 1, 30);
INSERT INTO `permissoes` VALUES (1, 2, 1);
INSERT INTO `permissoes` VALUES (1, 2, 2);
INSERT INTO `permissoes` VALUES (1, 2, 3);
INSERT INTO `permissoes` VALUES (1, 2, 4);
INSERT INTO `permissoes` VALUES (1, 2, 5);
INSERT INTO `permissoes` VALUES (1, 2, 6);
INSERT INTO `permissoes` VALUES (1, 2, 7);
INSERT INTO `permissoes` VALUES (1, 2, 8);
INSERT INTO `permissoes` VALUES (1, 2, 9);
INSERT INTO `permissoes` VALUES (1, 2, 10);
INSERT INTO `permissoes` VALUES (1, 2, 11);
INSERT INTO `permissoes` VALUES (1, 2, 12);
INSERT INTO `permissoes` VALUES (1, 2, 13);
INSERT INTO `permissoes` VALUES (1, 2, 14);
INSERT INTO `permissoes` VALUES (1, 2, 15);
INSERT INTO `permissoes` VALUES (1, 2, 16);
INSERT INTO `permissoes` VALUES (1, 2, 17);
INSERT INTO `permissoes` VALUES (1, 2, 18);
INSERT INTO `permissoes` VALUES (1, 2, 19);
INSERT INTO `permissoes` VALUES (1, 2, 20);
INSERT INTO `permissoes` VALUES (1, 2, 21);
INSERT INTO `permissoes` VALUES (1, 2, 22);
INSERT INTO `permissoes` VALUES (1, 2, 23);
INSERT INTO `permissoes` VALUES (1, 2, 24);
INSERT INTO `permissoes` VALUES (1, 2, 25);
INSERT INTO `permissoes` VALUES (1, 2, 26);
INSERT INTO `permissoes` VALUES (1, 2, 27);
INSERT INTO `permissoes` VALUES (1, 2, 28);
INSERT INTO `permissoes` VALUES (1, 2, 29);
INSERT INTO `permissoes` VALUES (1, 2, 30);
INSERT INTO `permissoes` VALUES (1, 3, 1);
INSERT INTO `permissoes` VALUES (1, 3, 2);
INSERT INTO `permissoes` VALUES (1, 3, 3);
INSERT INTO `permissoes` VALUES (1, 3, 4);
INSERT INTO `permissoes` VALUES (1, 3, 5);
INSERT INTO `permissoes` VALUES (1, 3, 6);
INSERT INTO `permissoes` VALUES (1, 3, 7);
INSERT INTO `permissoes` VALUES (1, 3, 8);
INSERT INTO `permissoes` VALUES (1, 3, 9);
INSERT INTO `permissoes` VALUES (1, 3, 10);
INSERT INTO `permissoes` VALUES (1, 3, 11);
INSERT INTO `permissoes` VALUES (1, 3, 12);
INSERT INTO `permissoes` VALUES (1, 3, 13);
INSERT INTO `permissoes` VALUES (1, 3, 14);
INSERT INTO `permissoes` VALUES (1, 3, 15);
INSERT INTO `permissoes` VALUES (1, 3, 16);
INSERT INTO `permissoes` VALUES (1, 3, 17);
INSERT INTO `permissoes` VALUES (1, 3, 18);
INSERT INTO `permissoes` VALUES (1, 3, 19);
INSERT INTO `permissoes` VALUES (1, 3, 20);
INSERT INTO `permissoes` VALUES (1, 3, 21);
INSERT INTO `permissoes` VALUES (1, 3, 22);
INSERT INTO `permissoes` VALUES (1, 3, 23);
INSERT INTO `permissoes` VALUES (1, 3, 24);
INSERT INTO `permissoes` VALUES (1, 3, 25);
INSERT INTO `permissoes` VALUES (1, 3, 26);
INSERT INTO `permissoes` VALUES (1, 3, 27);
INSERT INTO `permissoes` VALUES (1, 3, 28);
INSERT INTO `permissoes` VALUES (1, 3, 29);
INSERT INTO `permissoes` VALUES (1, 3, 30);
INSERT INTO `permissoes` VALUES (1, 4, 1);
INSERT INTO `permissoes` VALUES (1, 4, 2);
INSERT INTO `permissoes` VALUES (1, 4, 3);
INSERT INTO `permissoes` VALUES (1, 4, 4);
INSERT INTO `permissoes` VALUES (1, 4, 5);
INSERT INTO `permissoes` VALUES (1, 4, 6);
INSERT INTO `permissoes` VALUES (1, 4, 7);
INSERT INTO `permissoes` VALUES (1, 4, 8);
INSERT INTO `permissoes` VALUES (1, 4, 9);
INSERT INTO `permissoes` VALUES (1, 4, 10);
INSERT INTO `permissoes` VALUES (1, 4, 11);
INSERT INTO `permissoes` VALUES (1, 4, 12);
INSERT INTO `permissoes` VALUES (1, 4, 13);
INSERT INTO `permissoes` VALUES (1, 4, 14);
INSERT INTO `permissoes` VALUES (1, 4, 15);
INSERT INTO `permissoes` VALUES (1, 4, 16);
INSERT INTO `permissoes` VALUES (1, 4, 17);
INSERT INTO `permissoes` VALUES (1, 4, 18);
INSERT INTO `permissoes` VALUES (1, 4, 19);
INSERT INTO `permissoes` VALUES (1, 4, 20);
INSERT INTO `permissoes` VALUES (1, 4, 21);
INSERT INTO `permissoes` VALUES (1, 4, 22);
INSERT INTO `permissoes` VALUES (1, 4, 23);
INSERT INTO `permissoes` VALUES (1, 4, 24);
INSERT INTO `permissoes` VALUES (1, 4, 25);
INSERT INTO `permissoes` VALUES (1, 4, 26);
INSERT INTO `permissoes` VALUES (1, 4, 27);
INSERT INTO `permissoes` VALUES (1, 4, 28);
INSERT INTO `permissoes` VALUES (1, 4, 29);
INSERT INTO `permissoes` VALUES (1, 4, 30);

-- --------------------------------------------------------

-- 
-- Table structure for table `publico_alvo`
-- 

CREATE TABLE `publico_alvo` (
  `FKid_membroscondominioCol` int(10) unsigned NOT NULL default '0',
  `FKid_atividadesCol` int(10) unsigned NOT NULL default '0',
  `compareceu` tinyint(1) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `publico_alvo`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `receita_despesa`
-- 

CREATE TABLE `receita_despesa` (
  `id_receita_despesa` int(10) unsigned NOT NULL auto_increment,
  `FKid_centro_custosCol` int(10) unsigned NOT NULL default '0',
  `FKid_condominiosCol` int(10) unsigned NOT NULL default '0',
  `documento` varchar(20) default NULL,
  `data_emissao` date default NULL,
  `data_vencimento` date default NULL,
  `valor` float default NULL,
  `forma_pagamento` varchar(30) default NULL,
  `observacao` text,
  `pagante_fornecedor` varchar(150) default NULL,
  `valor_pago` float default NULL,
  `situacao` tinyint(1) default NULL,
  `data_pagamento_recebimento` datetime default NULL,
  PRIMARY KEY  (`id_receita_despesa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `receita_despesa`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `recursos_lazer`
-- 

CREATE TABLE `recursos_lazer` (
  `id_recursos_lazer` int(10) unsigned NOT NULL auto_increment,
  `FKid_objetos_lazerCol` int(10) unsigned NOT NULL default '0',
  `nome` varchar(50) default NULL,
  `descricao` text,
  `aviso` text,
  `situacao` tinyint(1) default NULL,
  PRIMARY KEY  (`id_recursos_lazer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `recursos_lazer`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `regimentos`
-- 

CREATE TABLE `regimentos` (
  `id_regimentos` int(10) unsigned NOT NULL auto_increment,
  `FKid_condominiosCol` int(10) unsigned NOT NULL default '0',
  `arquivo` blob,
  `regimento` text,
  `situacao` tinyint(1) default NULL,
  PRIMARY KEY  (`id_regimentos`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `regimentos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `reservas`
-- 

CREATE TABLE `reservas` (
  `id_reservas` int(10) unsigned NOT NULL auto_increment,
  `FKid_objetos_lazerCol` int(10) unsigned NOT NULL default '0',
  `FKid_membroscondominioCol` int(10) unsigned NOT NULL default '0',
  `data_inicio` datetime default NULL,
  `data_fim` datetime default NULL,
  PRIMARY KEY  (`id_reservas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `reservas`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `servicos_tercerizados`
-- 

CREATE TABLE `servicos_tercerizados` (
  `id_servicos_tercerizados` int(10) unsigned NOT NULL auto_increment,
  `FKid_condominiosCol` int(10) unsigned NOT NULL default '0',
  `FKid_tipos_servicosCol` int(10) unsigned NOT NULL default '0',
  `FKid_servidoresCol` int(10) unsigned NOT NULL default '0',
  `valor` float default NULL,
  `copia_nota` blob,
  `data_prestacao` date default NULL,
  PRIMARY KEY  (`id_servicos_tercerizados`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `servicos_tercerizados`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `servidores`
-- 

CREATE TABLE `servidores` (
  `id_servidores` int(10) unsigned NOT NULL auto_increment,
  `cpf` varchar(10) default NULL,
  `cnpj` varchar(14) default NULL,
  `nome_contato` varchar(50) default NULL,
  `telefone_contato` varchar(25) default NULL,
  `celular_contato` varchar(25) default NULL,
  `nome_servidor` varchar(50) default NULL,
  `telefone_servidor` varchar(50) default NULL,
  `celular_servidor` varchar(50) default NULL,
  PRIMARY KEY  (`id_servidores`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `servidores`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `super_usuarios`
-- 

CREATE TABLE `super_usuarios` (
  `id_super_usuarios` int(10) unsigned NOT NULL auto_increment,
  `FKid_tipo_usuariosCol` int(10) unsigned NOT NULL default '0',
  `nome` varchar(50) default NULL,
  `login` varchar(25) default NULL,
  `senha_alteracao` varchar(32) default NULL,
  `senha_criacao_condominio` varchar(32) default NULL,
  `senha` varchar(32) default NULL,
  PRIMARY KEY  (`id_super_usuarios`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `super_usuarios`
-- 

INSERT INTO `super_usuarios` VALUES (1, 1, 'helio', 'helio', 'c7614b0671db456e8d490bcc6fe26641', 'c7614b0671db456e8d490bcc6fe26641', 'c7614b0671db456e8d490bcc6fe26641');

-- --------------------------------------------------------

-- 
-- Table structure for table `tipo_usuarios`
-- 

CREATE TABLE `tipo_usuarios` (
  `id_tipo_usuarios` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(13) default NULL,
  PRIMARY KEY  (`id_tipo_usuarios`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `tipo_usuarios`
-- 

INSERT INTO `tipo_usuarios` VALUES (1, 'Super Usuário');
INSERT INTO `tipo_usuarios` VALUES (2, 'Síndico');
INSERT INTO `tipo_usuarios` VALUES (3, 'Sub-Síndico');
INSERT INTO `tipo_usuarios` VALUES (4, 'Empregado');
INSERT INTO `tipo_usuarios` VALUES (5, 'Usuário');
INSERT INTO `tipo_usuarios` VALUES (6, 'Administrador');
INSERT INTO `tipo_usuarios` VALUES (7, 'Conselheiro');

-- --------------------------------------------------------

-- 
-- Table structure for table `tipos_funcionarios`
-- 

CREATE TABLE `tipos_funcionarios` (
  `id_tipos_funcionarios` int(10) unsigned NOT NULL auto_increment,
  `nome` char(100) default NULL,
  PRIMARY KEY  (`id_tipos_funcionarios`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `tipos_funcionarios`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `tipos_permissoes`
-- 

CREATE TABLE `tipos_permissoes` (
  `id_tipos_permissoes` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(7) default NULL,
  PRIMARY KEY  (`id_tipos_permissoes`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `tipos_permissoes`
-- 

INSERT INTO `tipos_permissoes` VALUES (1, 'Alterar');
INSERT INTO `tipos_permissoes` VALUES (2, 'Inserir');
INSERT INTO `tipos_permissoes` VALUES (3, 'Excluir');

-- --------------------------------------------------------

-- 
-- Table structure for table `tipos_servicos`
-- 

CREATE TABLE `tipos_servicos` (
  `id_tipos_servicos` int(10) unsigned NOT NULL auto_increment,
  `nome` char(100) default NULL,
  PRIMARY KEY  (`id_tipos_servicos`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `tipos_servicos`
-- 

