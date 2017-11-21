-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 21-Nov-2017 às 16:28
-- Versão do servidor: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_agenda`
--

DROP TABLE IF EXISTS `sc_agenda`;
CREATE TABLE `sc_agenda` (
  `idAgenda` int(12) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `idLocal` int(11) NOT NULL,
  `idInstituicao` int(11) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `idOcorrencia` int(11) NOT NULL,
  `idCinema` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_evento`
--

DROP TABLE IF EXISTS `sc_evento`;
CREATE TABLE `sc_evento` (
  `idEvento` int(6) NOT NULL,
  `idTipo` int(3) NOT NULL,
  `idPrograma` int(2) NOT NULL,
  `idProjeto` int(11) NOT NULL,
  `idLinguagem` int(11) NOT NULL,
  `nomeEvento` varchar(240) NOT NULL,
  `idResponsavel` int(4) NOT NULL,
  `idSuplente` int(4) NOT NULL,
  `autor` longtext NOT NULL,
  `nomeGrupo` varchar(100) NOT NULL,
  `fichaTecnica` longtext NOT NULL,
  `faixaEtaria` varchar(12) NOT NULL,
  `sinopse` longtext NOT NULL,
  `releaseCom` longtext NOT NULL,
  `publicado` int(1) DEFAULT NULL,
  `idUsuario` int(3) DEFAULT NULL,
  `linksCom` longtext,
  `subEvento` int(1) DEFAULT NULL,
  `dataEnvio` datetime DEFAULT NULL,
  `ocupacao` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_ocorrencia`
--

DROP TABLE IF EXISTS `sc_ocorrencia`;
CREATE TABLE `sc_ocorrencia` (
  `idOcorrencia` int(8) NOT NULL,
  `idTipoOcorrencia` int(8) DEFAULT NULL,
  `ig_comunicao_idCom` int(8) DEFAULT NULL,
  `local` int(3) DEFAULT NULL,
  `idEvento` int(6) DEFAULT NULL,
  `segunda` int(1) DEFAULT NULL,
  `terca` int(1) DEFAULT NULL,
  `quarta` int(1) DEFAULT NULL,
  `quinta` int(1) DEFAULT NULL,
  `sexta` int(1) DEFAULT NULL,
  `sabado` int(1) DEFAULT NULL,
  `domingo` int(1) DEFAULT NULL,
  `dataInicio` date DEFAULT NULL,
  `dataFinal` date DEFAULT NULL,
  `horaInicio` time DEFAULT NULL,
  `horaFinal` time DEFAULT NULL,
  `timezone` int(3) DEFAULT NULL,
  `diaInteiro` int(1) DEFAULT NULL,
  `diaEspecial` int(1) DEFAULT NULL,
  `libras` int(1) DEFAULT NULL,
  `audiodescricao` int(1) DEFAULT NULL,
  `valorIngresso` decimal(10,2) DEFAULT NULL,
  `retiradaIngresso` int(2) DEFAULT NULL,
  `localOutros` varchar(120) DEFAULT NULL,
  `lotacao` int(7) DEFAULT NULL,
  `reservados` int(4) DEFAULT NULL,
  `duracao` int(4) DEFAULT NULL,
  `precoPopular` decimal(10,2) DEFAULT NULL,
  `frequencia` varchar(120) DEFAULT NULL,
  `publicado` int(1) DEFAULT NULL,
  `idSubEvento` int(8) DEFAULT NULL,
  `idCinema` int(6) DEFAULT NULL,
  `virada` tinyint(1) DEFAULT NULL,
  `observacao` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_tipo`
--

DROP TABLE IF EXISTS `sc_tipo`;
CREATE TABLE `sc_tipo` (
  `id_tipo` int(3) NOT NULL,
  `tipo` varchar(150) NOT NULL,
  `descricao` longtext NOT NULL,
  `abreviatura` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sc_tipo`
--

INSERT INTO `sc_tipo` (`id_tipo`, `tipo`, `descricao`, `abreviatura`) VALUES
(1, 'AÇÃO CULTURAL TERRITORIAL', 'Processo de mapeamento, organização articulação, capacitação e potencialização de agentes e iniciativas das comunidades locais da cidade, para que assumam o protagonismo na ocupação de espaços e equipamentos públicos, bem como na realização de ações culturais e de lazer nos territórios.', 'programa'),
(2, 'Artes Circenses', '', 'linguagens'),
(3, 'Artes Integradas', '', 'linguagens'),
(4, 'Artes Visuais\r\n', '', 'linguagens'),
(5, 'Audiovisual', '', 'linguagens'),
(6, 'Cinema\r\n', '', 'linguagens'),
(7, 'Cultura Digital', '', 'linguagens'),
(8, 'Cultura Indígena', '', 'linguagens'),
(9, 'Cultura Tradicional', '', 'linguagens'),
(10, 'Dança', '', 'linguagens'),
(11, 'Exposição', '', 'linguagens'),
(12, 'Hip Hop', '', 'linguagens'),
(13, 'Livro e Literatura', '', 'linguagens'),
(14, 'Música Popular', '', 'linguagens'),
(15, 'Música Erudita', '', 'linguagens'),
(16, 'Palestra, Debate ou Encontro', '', 'linguagens'),
(17, 'Rádio', '', 'linguagens'),
(18, 'Teatro', '', 'linguagens'),
(19, 'Outros', '', 'linguagens'),
(20, 'DIÁLOGO E PARTICIPAÇÃO', 'Potencialização dos fóruns, conselhos, grupos organizados, associação de amigos e demais arranjos da sociedade civil para que dialoguem e atuem conjuntamente com a Administração pública na formatação e implantação  das políticas de Cultura e Lazer', 'programa'),
(21, 'INCENTIVO À CRIAÇÃO ARTÍSTICA', 'Ações de incentivo à criação ofertadas através das Escolas Livres, EMIA e Territórios de Cultura...', 'programa'),
(22, 'FOMENTO À PRODUÇÃO CULTURAL & ECONOMIA DA CULTURA', 'Editais / convocatórias, rodadas de negócios, capacitação para projetos, assessoria aos produtores...', 'programa'),
(23, 'COMUNICAÇÃO E INFORMAÇÃO CULTURAL /LAZER', 'Organização de informações de dados culturais e de lazer e potencialização dos meios de comunicação / divulgação / acesso (georeferenciamento, plataforma CulturAZ, Agenda Cultural, redes sociais...)', 'programa'),
(24, 'GESTÃO DE EQUIPAMENTOS E DA CULTURA E LAZER', 'Capacitação, reposição e reorganização  de RH, atualização de equipamentos, adequação funcionamento dos equipamentos/serviços, plano de identidade visual... Reformas, manutenções e aquisições de novos equipamentos.', 'programa'),
(25, 'DIFUSÃO CULTURAL E CONTEÚDOS DIGITAIS', 'Eventos, acervos digitalizados, ocupação de equipamentos, mais lazer, mediações de leitura...', 'programa'),
(26, 'INCENTIVO À LEITURA ', '', 'programa'),
(27, 'DIFUSÃO DO LAZER', '', 'programa'),
(28, 'LAZER COMUNITÁRIO', '', 'programa'),
(29, 'Livre', '', 'faixa_etaria'),
(30, '10 anos', '', 'faixa_etaria'),
(31, '12 anos', '', 'faixa_etaria'),
(32, '14 anos', '', 'faixa_etaria'),
(33, '16 anos', '', 'faixa_etaria'),
(34, '18 anos', '', 'faixa_etaria'),
(35, 'Memória / Patrimônio', '', 'linguagens'),
(36, 'Lazer', '', 'linguagens'),
(37, 'CICLO', '', 'tipo_evento'),
(38, 'CONCURSO', '', 'tipo_evento'),
(39, 'CONFERÊNCIA', '', 'tipo_evento'),
(40, 'CONGRESSO', '', 'tipo_evento'),
(41, 'CONVENÇÃO', '', 'tipo_evento'),
(42, 'CURSO', '', 'tipo_evento'),
(43, 'ENCONTROS', '', 'tipo_evento'),
(44, 'ENCONTROS', '', 'tipo_evento'),
(45, 'FEIRA', '', 'tipo_evento'),
(46, 'FESTA POPULAR', '', 'tipo_evento'),
(47, 'FESTA RELIGIOSA', '', 'tipo_evento'),
(48, 'FESTIVAL', '', 'tipo_evento'),
(49, 'FÓRUM', '', 'tipo_evento'),
(50, 'JORNADA', '', 'tipo_evento'),
(51, 'MOSTRA', '', 'tipo_evento'),
(52, 'OFICINA', '', 'tipo_evento'),
(53, 'PALESTRA', '', 'tipo_evento'),
(54, 'PARADA/DESFILE', '', 'tipo_evento'),
(55, 'PERFORMANCE', '', 'tipo_evento'),
(56, 'PROGRAMA', '', 'tipo_evento'),
(57, 'REUNIÃO', '', 'tipo_evento'),
(58, 'SARAU', '', 'tipo_evento'),
(59, 'SEMINÁRIO', '', 'tipo_evento'),
(60, 'SIMPÓSIO', '', 'tipo_evento'),
(61, 'SHOW', '', 'tipo_evento'),
(62, 'WORKSHOP', '', 'tipo_evento'),
(71, 'Ação educativa', '{\"responsavel\":\"3\",\"programa\":\"1\",\"descricao\":\"\"}', 'projeto'),
(72, 'Bibliotecas Ramais', '{\"responsavel\":\"5\",\"programa\":\"1\",\"descricao\":\"???\"}', 'projeto'),
(73, 'processos colaborativos ', '{\"responsavel\":\"5\",\"programa\":\"1\",\"descricao\":\"Desenvolver processos colaborativos com a populau00e7u00e3o dos bairros (festivais, inventu00e1rio participativo do patrimu00f4nio, etc) \"}', 'projeto'),
(74, 'Inserção do Mais Lazer (Experimental) ', '{\"responsavel\":\"6\",\"programa\":\"1\",\"descricao\":\"\"}', 'projeto'),
(75, 'Muito Prazer, Somos... ', '{\"responsavel\":\"5\",\"programa\":\"1\",\"descricao\":\"Desenvolver e executar projetos em conjunto com as comunidades/agentes culturais dos bairros.  \"}', 'projeto'),
(76, 'Bairros: incluindo memórias, incluindo cidadãos', '{\"responsavel\":\"3\",\"programa\":\"1\",\"descricao\":\"formau00e7u00e3o continuada para professores da rede pu00fablica municipal (EMEIF /EJA) \"}', 'projeto'),
(77, 'Reconhecimento de paisagens', '{\"responsavel\":\"3\",\"programa\":\"1\",\"descricao\":\"Inventu00e1rio participativo dos Bens Culturais de Santo Andru00e9\"}', 'projeto'),
(78, 'Santo André Múltiplos Tons ', '{\"responsavel\":\"5\",\"programa\":\"1\",\"descricao\":\"Realizar au00e7u00f5es culturais em parques  e/ou espau00e7os pu00fablicos descentralizados \"}', 'projeto'),
(79, 'Descentralizar as ações da OSSA ', '{\"responsavel\":\"5\",\"programa\":\"1\",\"descricao\":\"Descentralizar as au00e7u00f5es da OSSA (Orquestra Sinfu00f4nica de Santo Andru00e9)\"}', 'projeto'),
(80, 'Territórios de Cultura ', '{\"responsavel\":\"5\",\"programa\":\"1\",\"descricao\":\"(Oficinas descentralizadas)\"}', 'projeto'),
(81, 'Hackatons', '{\"responsavel\":\"3\",\"programa\":\"23\",\"descricao\":\"Realizar encontros de programadores para o desenvolvimento/ aperfeiu00e7oamento de aplicativos culturais\"}', 'projeto'),
(82, 'Plataforma CulturAZ ', '{\"responsavel\":\"3\",\"programa\":\"23\",\"descricao\":\"\"}', 'projeto'),
(83, 'Produção de material de divulgação ', '{\"responsavel\":\"3\",\"programa\":\"23\",\"descricao\":\"Elaboar Clipping, releases, artes, vu00eddeos e agenda cultural.\"}', 'projeto'),
(84, 'Sistema de controle de Fluxo de Informação', '{\"responsavel\":\"3\",\"programa\":\"23\",\"descricao\":\"Eventos / Indicadores / Oru00e7to da SC\"}', 'projeto'),
(85, 'Estimular a criação de Associação de Amigos de Equipamentos Culturais e de Lazer', '{\"responsavel\":\"3\",\"programa\":\"20\",\"descricao\":\"\"}', 'projeto'),
(86, 'Fortalecer os Conselhos ', '{\"responsavel\":\"3\",\"programa\":\"20\",\"descricao\":\"(Polu00edticas Culturais, Patrimu00f4nio, CEU das Artes) \"}', 'projeto'),
(87, 'Plano Municipal de Cultura', '{\"responsavel\":\"3\",\"programa\":\"20\",\"descricao\":\"\"}', 'projeto'),
(88, 'Aniversário da Cidade -2018', '{\"responsavel\":\"3\",\"programa\":\"25\",\"descricao\":\"\"}', 'projeto'),
(89, 'Calendário Cultural ', '{\"responsavel\":\"5\",\"programa\":\"25\",\"descricao\":\"programau00e7u00e3o contu00ednua nos equipamentos culturais\"}', 'projeto'),
(90, 'Plataforma terceirizada de Gestão de acervos (Consórcio)', '{\"responsavel\":\"3\",\"programa\":\"25\",\"descricao\":\"Digitalizar e Inserir informau00e7u00f5es disponu00edveis em Plataforma tercerizada de Gestu00e3o de acervos (Consu00f3rcio Intermunicipal)\"}', 'projeto'),
(91, 'Festival de Inverno de Paranapiacaba - 2018', '{\"responsavel\":\"3\",\"programa\":\"25\",\"descricao\":\"\"}', 'projeto'),
(92, 'Comunicação Visual ', '{\"responsavel\":\"3\",\"programa\":\"25\",\"descricao\":\"Implantar Comunicau00e7u00e3o Visual para os equipamentos de Cultura - Identificau00e7u00e3o dos Bens Tombados\"}', 'projeto'),
(93, 'Sistema de Catalogação e busca dos Acervos ', '{\"responsavel\":\"3\",\"programa\":\"25\",\"descricao\":\"Sistema de Catalogau00e7u00e3o e busca dos Acervos de Artes Visuais / Museu / biblioteca / Fundo de cultura / escolas livres / bens materiais e imateriais\"}', 'projeto'),
(94, 'Domingo no Paço', '{\"responsavel\":\"6\",\"programa\":\"27\",\"descricao\":\"\"}', 'projeto'),
(95, 'Mais Lazer', '{\"responsavel\":\"6\",\"programa\":\"27\",\"descricao\":\"\"}', 'projeto'),
(96, 'Democratizar o acesso a programação cultural', '{\"responsavel\":\"3\",\"programa\":\"22\",\"descricao\":\"\"}', 'projeto'),
(97, 'Democratizar o acesso ao uso dos equipamentos culturais', '{\"responsavel\":\"5\",\"programa\":\"22\",\"descricao\":\"\"}', 'projeto'),
(98, 'Banco de Projetos', '{\"responsavel\":\"3\",\"programa\":\"22\",\"descricao\":\"Implementau00e7u00e3o de Banco de Projetos de produtores culturais.\"}', 'projeto'),
(99, 'Adequação de Equipamentos Culturais', '{\"responsavel\":\"3\",\"programa\":\"24\",\"descricao\":\"\"}', 'projeto'),
(100, 'Adequação de quadros da SC', '{\"responsavel\":\"3\",\"programa\":\"24\",\"descricao\":\"\"}', 'projeto'),
(101, 'Obras de Arte Pública', '{\"responsavel\":\"5\",\"programa\":\"24\",\"descricao\":\"\"}', 'projeto'),
(102, 'Obras de Arte Pública', '{\"responsavel\":\"5\",\"programa\":\"24\",\"descricao\":\"\"}', 'projeto'),
(103, 'Projeto Carlos Gomes', '{\"responsavel\":\"3\",\"programa\":\"24\",\"descricao\":\"\"}', 'projeto'),
(104, 'Reforma do Teatro Municipal ', '{\"responsavel\":\"3\",\"programa\":\"24\",\"descricao\":\"\"}', 'projeto'),
(105, 'Reforma do Teatro Municipal ', '{\"responsavel\":\"3\",\"programa\":\"24\",\"descricao\":\"\"}', 'projeto'),
(106, 'GESTÃO E DIFUSÃO DA MEMÓRIA', 'Gestão e difusão de acervos, inventário participativo, educação patrimonial...', 'programa'),
(107, '\"Transformações urbanas\" (Exposições)', '{\"responsavel\":\"3\",\"programa\":\"106\",\"descricao\":\"\"}', 'projeto'),
(108, 'Monitoramento de bens tombados', '{\"responsavel\":\"3\",\"programa\":\"106\",\"descricao\":\"\"}', 'projeto'),
(109, 'difusão dos produtos das Escolas ', '{\"responsavel\":\"5\",\"programa\":\"21\",\"descricao\":\"Desenvolver projeto de difusu00e3o dos produtos das Escolas \"}', 'projeto'),
(110, 'Escolas Livres e EMIA ', '{\"responsavel\":\"5\",\"programa\":\"21\",\"descricao\":\"(Teatro, Danu00e7a e Cinema e vu00eddeo)\"}', 'projeto'),
(111, 'intercâmbios com processos de formação', '{\"responsavel\":\"5\",\"programa\":\"21\",\"descricao\":\"Realizar intercu00e2mbios com processos de formau00e7u00e3o de outros municu00edpios\"}', 'projeto'),
(112, 'Modernização de Bibliotecas', '{\"responsavel\":\"5\",\"programa\":\"26\",\"descricao\":\"\"}', 'projeto'),
(113, 'Práticas Corporais', '{\"responsavel\":\"6\",\"programa\":\"28\",\"descricao\":\"\"}', 'projeto'),
(114, 'Práticas Corporais', '{\"responsavel\":\"6\",\"programa\":\"28\",\"descricao\":\"\"}', 'projeto'),
(115, 'Ruas de Lazer', '{\"responsavel\":\"6\",\"programa\":\"27\",\"descricao\":\"\"}', 'projeto'),
(116, 'Ruas de Lazer', '{\"responsavel\":\"6\",\"programa\":\"27\",\"descricao\":\"\"}', 'projeto');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sc_agenda`
--
ALTER TABLE `sc_agenda`
  ADD PRIMARY KEY (`idAgenda`);

--
-- Indexes for table `sc_evento`
--
ALTER TABLE `sc_evento`
  ADD PRIMARY KEY (`idEvento`);

--
-- Indexes for table `sc_ocorrencia`
--
ALTER TABLE `sc_ocorrencia`
  ADD PRIMARY KEY (`idOcorrencia`),
  ADD KEY `ig_ocorrencia_FKIndex1` (`ig_comunicao_idCom`);

--
-- Indexes for table `sc_tipo`
--
ALTER TABLE `sc_tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sc_agenda`
--
ALTER TABLE `sc_agenda`
  MODIFY `idAgenda` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sc_evento`
--
ALTER TABLE `sc_evento`
  MODIFY `idEvento` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `sc_ocorrencia`
--
ALTER TABLE `sc_ocorrencia`
  MODIFY `idOcorrencia` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sc_tipo`
--
ALTER TABLE `sc_tipo`
  MODIFY `id_tipo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
