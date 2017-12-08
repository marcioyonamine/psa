-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 08-Dez-2017 às 14:09
-- Versão do servidor: 5.5.53-0+deb8u1
-- PHP Version: 5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `igsis`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `igsis_bancos`
--

CREATE TABLE IF NOT EXISTS `igsis_bancos` (
`ID` int(11) NOT NULL,
  `banco` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `codigo` varchar(10) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `igsis_bancos`
--

INSERT INTO `igsis_bancos` (`ID`, `banco`, `codigo`) VALUES
(1, 'Banco ABC Brasil S.A.', '246'),
(2, 'Banco ABN AMRO Real S.A.', '356'),
(3, 'Banco Alfa S.A.', '025'),
(4, 'Banco Alvorada S.A.', '641'),
(5, 'Banco Banerj S.A.', '029'),
(6, 'Banco Banestado S.A.', '038'),
(7, 'Banco Barclays S.A.', '740'),
(8, 'Banco BBM S.A.', '107'),
(9, 'Banco Beg S.A.', '031'),
(10, 'Banco Bem S.A.', '036'),
(11, 'Banco BM&F de Serviços de Liquidação e Custódia S.A', '096'),
(12, 'Banco BMC S.A.', '394'),
(13, 'Banco BMG S.A.', '318'),
(14, 'Banco BNP Paribas Brasil S.A.', '752'),
(15, 'Banco Boavista Interatlântico S.A.', '248'),
(16, 'Banco Bradesco S.A.', '237'),
(17, 'Banco Brascan S.A.', '225'),
(18, 'Banco Cacique S.A.', '263'),
(19, 'Banco Calyon Brasil S.A.', '222'),
(20, 'Banco Cargill S.A.', '040'),
(21, 'Banco Citibank S.A.', '745'),
(22, 'Banco Comercial e de Investimento Sudameris S.A.', '215'),
(23, 'Banco Cooperativo do Brasil S.A. – BANCOOB', '756'),
(24, 'Banco Cooperativo Sicredi S.A. – BANSICREDI', '748'),
(25, 'Banco Credit Suisse (Brasil) S.A.', '505'),
(26, 'Banco Cruzeiro do Sul S.A.', '229'),
(27, 'Banco da Amazônia S.A.', '003'),
(28, 'Banco Daycoval S.A.', '707'),
(29, 'Banco de Pernambuco S.A. – BANDEPE', '024'),
(30, 'Banco de Tokyo-Mitsubishi UFJ Brasil S.A.', '456'),
(31, 'Banco Dibens S.A.', '214'),
(32, 'Banco do Brasil S.A.', '001'),
(33, 'Banco do Estado de Santa Catarina S.A.', '027'),
(34, 'Banco do Estado de Sergipe S.A.', '047'),
(35, 'Banco do Estado do Pará S.A.', '037'),
(36, 'Banco do Estado do Rio Grande do Sul S.A.', '041'),
(37, 'Banco do Nordeste do Brasil S.A.', '004'),
(38, 'Banco Fator S.A.', '265'),
(39, 'Banco Fibra S.A.', '224'),
(40, 'Banco Finasa S.A.', '175'),
(41, 'Banco Fininvest S.A.', '252'),
(42, 'Banco GE Capital S.A.', '233'),
(43, 'Banco Gerdau S.A.', '734'),
(44, 'Banco Guanabara S.A.', '612'),
(45, 'Banco Ibi S.A. Banco Múltiplo', '063'),
(46, 'Banco Industrial do Brasil S.A.', '604'),
(47, 'Banco Industrial e Comercial S.A.', '320'),
(48, 'Banco Indusval S.A.', '653'),
(49, 'Banco Intercap S.A.', '630'),
(50, 'Banco Investcred Unibanco S.A.', '249'),
(51, 'Banco Itaú BBA S.A.', '184-8'),
(52, 'Banco Itaú Holding Financeira S.A.', '652'),
(53, 'Banco Itaú S.A.', '341'),
(54, 'Banco ItaúBank S.A', '479'),
(55, 'Banco J. P. Morgan S.A.', '376'),
(56, 'Banco J. Safra S.A.', '074'),
(57, 'Banco Luso Brasileiro S.A.', '600'),
(58, 'Banco Mercantil de São Paulo S.A.', '392'),
(59, 'Banco Mercantil do Brasil S.A.', '389'),
(60, 'Banco Merrill Lynch de Investimentos S.A.', '755'),
(61, 'Banco Nossa Caixa S.A.', '151'),
(62, 'Banco Opportunity S.A.', '045'),
(63, 'Banco Panamericano S.A.', '623'),
(64, 'Banco Paulista S.A.', '611'),
(65, 'Banco Pine S.A.', '643'),
(66, 'Banco Prosper S.A.', '638'),
(67, 'Banco Rabobank International Brasil S.A.', '747'),
(68, 'Banco Rendimento S.A.', '633'),
(69, 'Banco Rural Mais S.A.', '072'),
(70, 'Banco Rural S.A.', '453'),
(71, 'Banco Safra S.A.', '422'),
(72, 'Banco Santander Banespa S.A.', '033'),
(73, 'Banco Schahin S.A.', '250'),
(74, 'Banco Simples S.A.', '749'),
(75, 'Banco Société Générale Brasil S.A.', '366'),
(76, 'Banco Sofisa S.A.', '637'),
(77, 'Banco Sudameris Brasil S.A.', '347'),
(78, 'Banco Sumitomo Mitsui Brasileiro S.A.', '464'),
(79, 'Banco Triângulo S.A.', '634'),
(80, 'Banco UBS Pactual S.A.', '208'),
(81, 'Banco UBS S.A.', '247'),
(82, 'Banco Único S.A.', '116'),
(83, 'Banco Votorantim S.A.', '655'),
(84, 'Banco VR S.A.', '610'),
(85, 'Banco WestLB do Brasil S.A.', '370'),
(86, 'BANESTES S.A. Banco do Estado do Espírito Santo', '021'),
(87, 'Banif-Banco Internacional do Funchal (Brasil)S.A.', '719'),
(88, 'Bankpar Banco Multiplo S.A.', '204'),
(89, 'BB Banco Popular do Brasil S.A.', '073-6'),
(90, 'BPN Brasil Banco Mútiplo S.A.', '069-8'),
(91, 'BRB – Banco de Brasília S.A.', '070'),
(92, 'Caixa Econômica Federal', '104'),
(93, 'Citibank N.A.', '477'),
(94, 'Deutsche Bank S.A. – Banco Alemão', '487'),
(95, 'Dresdner Bank Brasil S.A. – Banco Múltiplo', '751'),
(96, 'Dresdner Bank Lateinamerika Aktiengesellschaft', '210'),
(97, 'Hipercard Banco Múltiplo S.A.', '062'),
(98, 'HSBC Bank Brasil S.A. – Banco Múltiplo', '399'),
(99, 'ING Bank N.V.', '492'),
(100, 'JPMorgan Chase Bank', '488'),
(101, 'Lemon Bank Banco Múltiplo S.A.', '065'),
(102, 'UNIBANCO – União de Bancos Brasileiros S.A.', '409'),
(103, 'Unicard Banco Múltiplo S.A.', '230');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `igsis_bancos`
--
ALTER TABLE `igsis_bancos`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `igsis_bancos`
--
ALTER TABLE `igsis_bancos`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=104;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
