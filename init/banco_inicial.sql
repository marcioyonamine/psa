-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12-Dez-2017 às 12:10
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

CREATE TABLE `sc_agenda` (
  `idAgenda` int(12) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `idLocal` int(11) NOT NULL,
  `idInstituicao` int(11) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `idOcorrencia` int(11) NOT NULL,
  `idCinema` int(11) DEFAULT NULL,
  `rel_publico` int(11) NOT NULL,
  `rel_relatorio` longtext NOT NULL,
  `rel_data` int(11) NOT NULL,
  `rel_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_arquivo`
--

CREATE TABLE `sc_arquivo` (
  `idArquivo` int(4) NOT NULL,
  `id` int(6) NOT NULL,
  `entidade` varchar(15) NOT NULL,
  `tipo` int(11) NOT NULL,
  `arquivo` longtext NOT NULL,
  `datatime` datetime NOT NULL,
  `usuario` int(11) NOT NULL,
  `publicado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_atividade`
--

CREATE TABLE `sc_atividade` (
  `id` int(11) NOT NULL,
  `titulo` varchar(160) NOT NULL,
  `idRes` int(4) NOT NULL,
  `idSuplente` int(11) NOT NULL,
  `idProjeto` int(4) NOT NULL,
  `idPrograma` int(4) NOT NULL,
  `periodo_inicio` date NOT NULL,
  `periodo_fim` date NOT NULL,
  `ano_base` int(4) NOT NULL,
  `descricao` longtext NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `publicado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_contratacao`
--

CREATE TABLE `sc_contratacao` (
  `idPedidoContratacao` int(11) UNSIGNED ZEROFILL NOT NULL,
  `idEvento` int(11) NOT NULL,
  `idAtividade` int(11) NOT NULL,
  `tipoPessoa` int(1) DEFAULT NULL,
  `idRepresentante01` int(11) DEFAULT NULL,
  `idPessoa` int(11) DEFAULT NULL,
  `integrantesGrupo` longtext NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `valorPorExtenso` varchar(120) DEFAULT NULL,
  `formaPagamento` longtext,
  `dotacao` int(11) DEFAULT NULL,
  `anexo` longtext,
  `observacao` longtext,
  `publicado` int(1) DEFAULT NULL,
  `valorIndividual` decimal(10,2) DEFAULT NULL,
  `idRepresentante02` int(11) DEFAULT NULL,
  `instituicao` int(3) DEFAULT NULL,
  `executante` int(11) DEFAULT NULL,
  `NumeroProcesso` varchar(30) DEFAULT NULL,
  `NumeroNotaEmpenho` varchar(8) DEFAULT NULL,
  `DataEmissaoNotaEmpenho` date DEFAULT NULL,
  `DataEntregaNotaEmpenho` date DEFAULT NULL,
  `IdUsuarioContratos` int(3) DEFAULT NULL,
  `IdAssinatura` int(2) DEFAULT NULL,
  `IdExecutante` int(6) DEFAULT NULL,
  `justificativa` longtext,
  `parecerArtistico` longtext,
  `estado` varchar(20) DEFAULT NULL,
  `aprovacaoFinanca` tinyint(1) DEFAULT NULL,
  `parcelas` int(2) DEFAULT NULL,
  `idContratos` int(3) DEFAULT NULL,
  `idDetalhamentoAcao` int(11) NOT NULL,
  `DataProposta` datetime DEFAULT NULL,
  `DataReserva` datetime DEFAULT NULL,
  `DataContrato` datetime DEFAULT NULL,
  `AmparoLegal` longtext,
  `ComplementoDotacao` varchar(255) DEFAULT NULL,
  `Finalizacao` longtext,
  `idPenalidade` int(11) DEFAULT NULL,
  `DataJuridico` datetime NOT NULL,
  `DataPublicacao` datetime NOT NULL,
  `DataContabilidade` datetime NOT NULL,
  `DataPagamento` datetime NOT NULL,
  `nProcesso` varchar(20) DEFAULT NULL,
  `extratoLiquidacao` int(11) DEFAULT NULL,
  `retencoesINSS` int(11) DEFAULT NULL,
  `retencoesISS` int(11) DEFAULT NULL,
  `retencoesIRRF` int(11) DEFAULT NULL,
  `notaFiscal` varchar(10) DEFAULT NULL,
  `descricaoNF` varchar(200) DEFAULT NULL,
  `qtdApresentacoes` int(3) DEFAULT NULL,
  `planejamento` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_evento`
--

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
  `ocupacao` tinyint(1) DEFAULT NULL,
  `planejamento` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_mov_orc`
--

CREATE TABLE `sc_mov_orc` (
  `id` int(11) NOT NULL,
  `titulo` varchar(160) NOT NULL,
  `tipo` int(4) NOT NULL,
  `operacao` int(4) NOT NULL,
  `idOrc` int(11) NOT NULL,
  `data` date NOT NULL,
  `valor` double(10,2) NOT NULL,
  `descricao` longtext NOT NULL,
  `idUsuario` tinyint(3) NOT NULL,
  `publicado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_ocorrencia`
--

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
-- Estrutura da tabela `sc_orcamento`
--

CREATE TABLE `sc_orcamento` (
  `id` int(11) NOT NULL,
  `unidade` int(3) NOT NULL,
  `projeto` int(4) DEFAULT NULL,
  `ficha` int(4) DEFAULT NULL,
  `dotacao` varchar(36) DEFAULT NULL,
  `descricao` varchar(66) DEFAULT NULL,
  `natureza` varchar(20) DEFAULT NULL,
  `fonte` int(2) DEFAULT NULL,
  `funcao` int(2) DEFAULT NULL,
  `valor` double(10,2) NOT NULL,
  `obs` longtext NOT NULL,
  `publicado` tinyint(1) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `ano_base` int(4) NOT NULL,
  `visualizar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_pf`
--

CREATE TABLE `sc_pf` (
  `Id_PessoaFisica` int(11) NOT NULL,
  `Nome` varchar(70) NOT NULL,
  `NomeArtistico` varchar(70) DEFAULT NULL,
  `RG` varchar(20) DEFAULT NULL,
  `CPF` char(14) NOT NULL,
  `CCM` char(11) DEFAULT NULL,
  `IdEstadoCivil` int(11) DEFAULT NULL,
  `DataNascimento` date DEFAULT NULL,
  `LocalNascimento` varchar(100) DEFAULT NULL,
  `Nacionalidade` varchar(20) DEFAULT 'Brasileiro(a)',
  `CEP` varchar(11) DEFAULT NULL,
  `Numero` int(11) DEFAULT NULL,
  `Complemento` varchar(20) DEFAULT NULL,
  `Telefone1` varchar(15) NOT NULL,
  `Telefone2` varchar(15) DEFAULT NULL,
  `Telefone3` varchar(15) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `DRT` varchar(15) DEFAULT NULL,
  `Funcao` varchar(50) DEFAULT NULL,
  `InscricaoINSS` varchar(50) DEFAULT NULL,
  `Pis` varchar(50) DEFAULT NULL,
  `OMB` varchar(50) DEFAULT NULL,
  `DataAtualizacao` date NOT NULL,
  `Observacao` longtext,
  `IdUsuario` int(11) NOT NULL,
  `tipoDocumento` int(1) DEFAULT NULL,
  `codBanco` int(3) DEFAULT NULL,
  `agencia` varchar(12) DEFAULT NULL,
  `conta` varchar(12) DEFAULT NULL,
  `cbo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_pj`
--

CREATE TABLE `sc_pj` (
  `Id_PessoaJuridica` int(11) NOT NULL,
  `RazaoSocial` varchar(100) NOT NULL,
  `CNPJ` char(18) NOT NULL,
  `CCM` char(11) DEFAULT NULL,
  `CEP` varchar(11) DEFAULT NULL,
  `Numero` int(11) DEFAULT NULL,
  `Complemento` varchar(20) DEFAULT NULL,
  `Telefone1` varchar(15) NOT NULL,
  `Telefone2` varchar(15) DEFAULT NULL,
  `Telefone3` varchar(15) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `DataAtualizacao` date NOT NULL,
  `Observacao` longtext,
  `IdUsuario` int(11) NOT NULL,
  `codBanco` int(3) DEFAULT NULL,
  `agencia` varchar(12) DEFAULT NULL,
  `conta` varchar(12) DEFAULT NULL,
  `rep_nome` varchar(120) NOT NULL,
  `rep_rg` varchar(30) NOT NULL,
  `rep_cpf` varchar(30) NOT NULL,
  `rep_nacionalidade` varchar(60) NOT NULL,
  `rep_civil` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_tipo`
--

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
(116, 'Ruas de Lazer', '{\"responsavel\":\"6\",\"programa\":\"27\",\"descricao\":\"\"}', 'projeto'),
(202, 'Museu de Santo André Dr. Octaviano Armando  Gaiarsa', '{\"mapas\":\"3\"}', 'local'),
(203, 'Casa do Olhar Luiz Sacilotto', '{\"mapas\":\"5\"}', 'local'),
(204, 'ELD - Centro de Dança de Santo André', '{\"mapas\":\"6\"}', 'local'),
(205, 'Emia Aron Feldman - Escola Municipal de Iniciação Artística', '{\"mapas\":\"7\"}', 'local'),
(206, 'ELCV - Escola Livre de Cinema e Vídeo', '{\"mapas\":\"8\"}', 'local'),
(207, 'Teatro Conchita de Moraes', '{\"mapas\":\"9\"}', 'local'),
(208, 'Espaço Permanente do Acervo de Arte Contemporânea de Santo André - Pinacoteca', '{\"mapas\":\"10\"}', 'local'),
(209, 'Salão de Exposições', '{\"mapas\":\"11\"}', 'local'),
(210, 'Teatro Municipal de Santo André Antonio Houaiss', '{\"mapas\":\"12\"}', 'local'),
(211, 'Saguão do Teatro Municipal de Santo André', '{\"mapas\":\"13\"}', 'local'),
(212, 'Auditório Heleny Guariba', '{\"mapas\":\"14\"}', 'local'),
(213, 'Concha Acústica da Praça do Carmo', '{\"mapas\":\"15\"}', 'local'),
(214, 'Feira de Artesanato - Paço Municipal', '{\"mapas\":\"16\"}', 'local'),
(215, 'Feira de Artesanato - Rua Cesário Mota', '{\"mapas\":\"17\"}', 'local'),
(216, 'Feira de Artesanato - Praça do Carmo', '{\"mapas\":\"18\"}', 'local'),
(217, 'Feira de Artesanato - Ipiranguinha', '{\"mapas\":\"19\"}', 'local'),
(218, 'Feira de Artesanato - Jaçatuba', '{\"mapas\":\"20\"}', 'local'),
(219, 'Biblioteca Nair Lacerda', '{\"mapas\":\"21\"}', 'local'),
(220, 'Biblioteca Distrital Cecília Meireles', '{\"mapas\":\"22\"}', 'local'),
(221, 'Biblioteca Cata Preta', '{\"mapas\":\"23\"}', 'local'),
(222, 'Biblioteca Parque Erasmo', '{\"mapas\":\"24\"}', 'local'),
(223, 'Biblioteca Praça Internacional', '{\"mapas\":\"25\"}', 'local'),
(224, 'Biblioteca Vila Humaitá', '{\"mapas\":\"27\"}', 'local'),
(225, 'Biblioteca de Paranapiacaba Ábia Ferreira Francisco', '{\"mapas\":\"28\"}', 'local'),
(226, 'Biblioteca Vila Floresta', '{\"mapas\":\"30\"}', 'local'),
(227, 'Biblioteca Vila Linda', '{\"mapas\":\"31\"}', 'local'),
(228, 'Biblioteca Vila Palmares', '{\"mapas\":\"32\"}', 'local'),
(229, 'Espaço Infantil (Biblioteca Nair Lacerda)', '{\"mapas\":\"35\"}', 'local'),
(230, 'Espaço dos Escritores da Região', '{\"mapas\":\"36\"}', 'local'),
(231, 'Espaço Permanente de Fotografia João Colovatti', '{\"mapas\":\"37\"}', 'local'),
(232, 'Espaço Reflexos', '{\"mapas\":\"38\"}', 'local'),
(233, 'Gibiteca Municipal', '{\"mapas\":\"39\"}', 'local'),
(234, 'Salão Nobre Burle Marx', '{\"mapas\":\"41\"}', 'local'),
(235, 'Palco do Saguão do Teatro Municipal de Santo André', '{\"mapas\":\"46\"}', 'local'),
(236, 'Biblioteca do Museu de Santo André', '{\"mapas\":\"48\"}', 'local'),
(237, 'Palco do Parque Central', '{\"mapas\":\"50\"}', 'local'),
(238, 'Palco do Parque da Juventude', '{\"mapas\":\"51\"}', 'local'),
(239, 'Espaço da Cantina do Parque Pref. Celso Daniel', '{\"mapas\":\"52\"}', 'local'),
(240, 'Coreto da Chácara Pignatari', '{\"mapas\":\"53\"}', 'local'),
(241, 'Palco da SEDE DA BANDA LIRA, Parque Ipiranguinha', '{\"mapas\":\"54\"}', 'local'),
(242, 'Calçadão da Oliveira Lima', '{\"mapas\":\"55\"}', 'local'),
(243, 'Calçadão da Rua Eliza Fláquer', '{\"mapas\":\"56\"}', 'local'),
(244, 'Travessa Diana', '{\"mapas\":\"57\"}', 'local'),
(245, 'Estacionamento do Paço Municipal de Santo André', '{\"mapas\":\"58\"}', 'local'),
(246, 'Parlatório do Paço Municipal de Santo André', '{\"mapas\":\"60\"}', 'local'),
(247, 'Vila de Paranapiacaba', '{\"mapas\":\"65\"}', 'local'),
(248, 'Praça do Antigo Mercado', '{\"mapas\":\"66\"}', 'local'),
(249, 'Largo dos Padeiros', '{\"mapas\":\"67\"}', 'local'),
(250, 'Bar do Campo', '{\"mapas\":\"68\"}', 'local'),
(251, 'Clube União Lyra Serrano', '{\"mapas\":\"71\"}', 'local'),
(252, 'Sala Especial do Museu de Santo André', '{\"mapas\":\"73\"}', 'local'),
(253, 'BIBLIOTECA DO CENTRO DE DANÇA - BCD', '{\"mapas\":\"75\"}', 'local'),
(254, 'Estação Prefeito Celso Daniel', '{\"mapas\":\"76\"}', 'local'),
(255, 'Figueira – “Ficus macrophilla Desfontaines ex persoon\"', '{\"mapas\":\"79\"}', 'local'),
(256, 'Residência de Bernardino Queiroz dos Santos – Casa do Olhar Luiz Sacilotto', '{\"mapas\":\"80\"}', 'local'),
(257, 'Residência de Dona Paulina Isabel de Queiroz – Casa da Palavra Mário Quintana', '{\"mapas\":\"81\"}', 'local'),
(258, 'Biblioteca Vila Sá', '{\"mapas\":\"84\"}', 'local'),
(259, 'CESA Vila Humaitá - Sala Multiuso', '{\"mapas\":\"90\"}', 'local'),
(260, 'CESA Vila Floresta - Sala Multiuso', '{\"mapas\":\"91\"}', 'local'),
(261, 'CESA Cata Preta - Sala Multiuso', '{\"mapas\":\"92\"}', 'local'),
(262, 'CESA Jardim Santo André - Sala Multiuso', '{\"mapas\":\"93\"}', 'local'),
(263, 'CESA Jardim Santo Alberto - Sala Multiuso', '{\"mapas\":\"94\"}', 'local'),
(264, 'CESA Parque Andreense - Sala Multiuso', '{\"mapas\":\"98\"}', 'local'),
(265, 'CESA Vila Sá - Sala Multiuso', '{\"mapas\":\"99\"}', 'local'),
(266, 'CESA Parque Erasmo - Sala Multiuso', '{\"mapas\":\"101\"}', 'local'),
(267, 'CESA Parque Novo Oratório - Sala Multiuso', '{\"mapas\":\"102\"}', 'local'),
(268, 'Associação dos Moradores Jardim Ana Maria - Sala Multiuso', '{\"mapas\":\"103\"}', 'local'),
(269, 'Feira Livre do Vinil - FIP 2016', '{\"mapas\":\"104\"}', 'local'),
(270, 'Biblioteca Santo Alberto', '{\"mapas\":\"105\"}', 'local'),
(271, 'CEU das Artes Jd. Marek', '{\"mapas\":\"109\"}', 'local'),
(272, 'Sala de Reuniões da SCT', '{\"mapas\":\"112\"}', 'local'),
(273, 'Cine-Teatro Carlos Gomes', '{\"mapas\":\"117\"}', 'local'),
(274, 'Casa da Palavra Mário Quintana', '{\"mapas\":\"135\"}', 'local'),
(275, 'Parque Prefeito Celso Daniel', '{\"mapas\":\"136\"}', 'local'),
(276, 'PARQUE JAÇATUBA - PARQUE REGIONAL DA CRIANÇA PALHAÇO ESTREMILIQUE', '{\"mapas\":\"137\"}', 'local'),
(277, 'CHÁCARA PIGNATARI - Parque Regional Prof. Antônio Pezzolo', '{\"mapas\":\"138\"}', 'local'),
(278, 'Biblioteca CEU MAREK', '{\"mapas\":\"142\"}', 'local'),
(279, 'Departamento de Cultura', '{\"mapas\":\"145\"}', 'local'),
(280, 'BRINQUEDOTECA', '{\"mapas\":\"146\"}', 'local'),
(281, 'LUDOTECA', '{\"mapas\":\"148\"}', 'local'),
(282, 'Casa Fox (Casa da Memória)', '{\"mapas\":\"163\"}', 'local'),
(283, 'ELT - ESCOLA LIVRE DE TEATRO', '{\"mapas\":\"170\"}', 'local'),
(284, 'GINÁSIO NOÊMIA ASSUNÇÃO', '{\"mapas\":\"184\"}', 'local'),
(285, 'Biblioteca Vila Floresta', '{\"mapas\":\"30\"}', 'local'),
(286, 'Contigenciamento', '-', 'mov_orc'),
(287, 'Descontigenciamento', '+', 'mov_orc'),
(288, 'Suplemento', '+', 'mov_orc'),
(289, 'Gabinete da Secretaria de Cultura', '', 'unidade'),
(290, 'Departamento de Cultura', '', 'unidade'),
(291, 'Departamento de Lazer e Recreação', '', 'unidade'),
(292, 'Departamento de Projetos Especiais', '', 'unidade'),
(293, 'Casado(a)', '', 'civil'),
(294, 'Divorciado(a)', '', 'civil'),
(295, 'Solteiro(a)', '', 'civil'),
(296, 'Viuvo(a)', '', 'civil'),
(297, 'Não informado', '', 'civil'),
(298, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sc_agenda`
--
ALTER TABLE `sc_agenda`
  ADD PRIMARY KEY (`idAgenda`);

--
-- Indexes for table `sc_arquivo`
--
ALTER TABLE `sc_arquivo`
  ADD PRIMARY KEY (`idArquivo`);

--
-- Indexes for table `sc_atividade`
--
ALTER TABLE `sc_atividade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sc_contratacao`
--
ALTER TABLE `sc_contratacao`
  ADD PRIMARY KEY (`idPedidoContratacao`);

--
-- Indexes for table `sc_evento`
--
ALTER TABLE `sc_evento`
  ADD PRIMARY KEY (`idEvento`);

--
-- Indexes for table `sc_mov_orc`
--
ALTER TABLE `sc_mov_orc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sc_ocorrencia`
--
ALTER TABLE `sc_ocorrencia`
  ADD PRIMARY KEY (`idOcorrencia`),
  ADD KEY `ig_ocorrencia_FKIndex1` (`ig_comunicao_idCom`);

--
-- Indexes for table `sc_orcamento`
--
ALTER TABLE `sc_orcamento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sc_pf`
--
ALTER TABLE `sc_pf`
  ADD PRIMARY KEY (`Id_PessoaFisica`);

--
-- Indexes for table `sc_pj`
--
ALTER TABLE `sc_pj`
  ADD PRIMARY KEY (`Id_PessoaJuridica`);

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
  MODIFY `idAgenda` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `sc_arquivo`
--
ALTER TABLE `sc_arquivo`
  MODIFY `idArquivo` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `sc_atividade`
--
ALTER TABLE `sc_atividade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `sc_contratacao`
--
ALTER TABLE `sc_contratacao`
  MODIFY `idPedidoContratacao` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `sc_evento`
--
ALTER TABLE `sc_evento`
  MODIFY `idEvento` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `sc_mov_orc`
--
ALTER TABLE `sc_mov_orc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sc_ocorrencia`
--
ALTER TABLE `sc_ocorrencia`
  MODIFY `idOcorrencia` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `sc_orcamento`
--
ALTER TABLE `sc_orcamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
--
-- AUTO_INCREMENT for table `sc_pf`
--
ALTER TABLE `sc_pf`
  MODIFY `Id_PessoaFisica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sc_pj`
--
ALTER TABLE `sc_pj`
  MODIFY `Id_PessoaJuridica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sc_tipo`
--
ALTER TABLE `sc_tipo`
  MODIFY `id_tipo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
