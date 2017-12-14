<?php 

//Carrega WP como FW
require_once("../wp-load.php");
$user = wp_get_current_user();
if(!is_user_logged_in()): // Impede acesso de pessoas não autorizadas
      /*** REMEMBER THE PAGE TO RETURN TO ONCE LOGGED IN ***/
	  $_SESSION["return_to"] = $_SERVER['REQUEST_URI'];
      /*** REDIRECT TO LOGIN PAGE ***/
	  header("location: /");
endif;
//Carrega os arquivos de funções
require "inc/function.php";

if(!isset($_GET['id']) OR !isset($_GET['modelo'])){
	echo "<h1>Erro.</h1>";
	
}else{
	$pedido = retornaPedido($_GET['id']);
	//var_dump($pedido);
	
	
	
	
	switch ($_GET['modelo']){
	case 303: // Folha de Rosto	
	
		$file_name='folha_de_rosto.doc';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/force-download');
		header('Content-type: application/vnd.ms-word');
		header('Content-Type: application/download');
		header('Content-Disposition: attachment;filename='.$file_name);
		header('Content-Transfer-Encoding: binary ');

			?>
		<html>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
		<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
		</style>
		<br /><br /><br /> 
		<p class="style_01">À <br />
		Encarregatura de Protocolo <br />
		Sr. Encarregado</p>
		<br />
		<br />
		<br />
		
		<p class="paragrafo">Solicitamos a abertura de processo administrativo com os seguintes dados:</p>

		<br /><br />
		<p>Interessado: <?php echo $pedido['area']." - ".$pedido['cr']; ?></p>

		<br />
		<br />
		<br />
		<p>Assunto: Dispensa de Licitação - contratação da <?php echo $pedido['tipoPessoa']; ?> <b><?php echo $pedido['nome_razaosocial']  ?> </b> para representar <b><?php echo $pedido['nome_razaosocial']  ?> </b> no evento "<b><?php echo $pedido['objeto'] ?></b>" que fará parte da programação cultural da Secretaria de Cultura.</p>

		<br />
		<br />
		<br />

		<p>Atenciosamente,</p>
				<br />
		<br />
		<br />
		<center>
		<p>Santo André, <?php 
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		echo strftime('%A, %d de %B de %Y', strtotime('today'));
		
		?>. </center></p>
		
		<br /><br />
		
		<br /><br />
		
		<p><center><?php echo $pedido['usuario']; ?><br />
		<?php echo $pedido['cargo']; ?>	
		</p></center>
		
		<br /><br />
		
		<br /><br />
		
		<p class="rodape">------------------------------------------------------------</p>
		<p class="rodape">Secretaria de Cultura - <?php echo $pedido['area']; ?> <br />
		Praça IV Centenário, 02 - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, <br /> 
		Telefone (11) 4433-0711/ 4433-0632 / email: musica@santoandre.sp.gov.br</p>
		
		
		
		
		
		
		
		
	<?php 
	break;	
	case 304: // OS	
	?>

	<p>CR Requisitante: <?php echo $pedido['cr']; ?></p>
	<p>Nome da área requisitante: Secretaria de Cultura - <?php echo $pedido['area']; ?></p> 
	<p>Cód. Dotação: <?php echo $pedido['cod_dotacao']; ?></p>
	<p>Projeto: <?php echo $pedido['projeto']; ?></p>
	<p>Ficha: <?php echo $pedido['ficha']; ?></p>
	<p>Sub-elemente Despesa:</p>
	<p>Conta corrente codReduzido/DB:</p>
	<p>Fonte de Recurso: <?php echo $pedido['fonte']; ?></p>
	<p>Nome do Contato: <?php echo $pedido['usuario']; ?></p>
	<p>Telefone de Contato: <?php echo $pedido['telefone']; ?><p>
	<p>Data Período do evento: <?php echo $pedido['periodo']; ?><p>
	<p>Local de aplicação do serviço: <?php echo $pedido['local']; ?><p>
	<p>Especificação:
	<p>Contratação de <?php echo $pedido['tipoPessoa']; ?> <b><?php echo $pedido['nome_razaosocial']  ?>, representando com exclusividade as apresentações do(s) seguinte(s) artista(s) <?php  echo $pedido['autor'] ?> para  <?php echo $pedido['tipo']; ?> em <?php echo $pedido['local']; ?> no(s) dia(s)  <?php echo $pedido['periodo']; ?> </b></p>
	
	<p>Empresa: <?php echo $pedido['nome_razaosocial']  ?></p>
	<p>CNPJ: <?php echo $pedido['cpf_cnpj']  ?></p>
	<p>Endereço: <?php echo $pedido['end']  ?></p>
	<p>Email: </p>
	
	Valor total:
	
	Forma de pagamento:
	
	Banco
	
	
	
	
	
	<?php 
	echo '<pre>';
	var_dump($pedido);
	echo '</pre>';
	?>
	
	
	
	<?php 
	break;	
	case 305: //Justificativa	
	?>

	<?php 
	break;	
	case 306: //Gerencia de compra	
	?>

	<?php 
	break;	
	case 307: //Ordenador de Despesa	
	?>

	
	<?php 
	break;
	default:
	?>


	<?php 
   break;	
	}
	
	
}

