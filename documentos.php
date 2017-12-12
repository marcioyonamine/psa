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
	switch ($_GET['modelo']){
	case 303: // Folha de Rosto	
	
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=folha_de_rosto.doc");

	?>
		<html>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
		<body>
		<style type='text/css'>
		.style_01 {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		</style>
		<br /><br /><br /> 
		<p>À <br />
		Encarregatura de Protocolo <br />
		Sr. Encarregado</p>
		<br />
		<br />
		<br />
		
		<p>Solicitamos a abertura de processo administrativo com os seguintes dados:</p>

		<br /><br />
		Interessado: (Colocar a váriavel)

		<br />
		<br />
		<br />
		<p>Assunto: Dispensa de Licitação - contratação <variavel> para representar <variavel> para o projeto <variavel></p>

		<br />
		<br />
		<br />

		<p>Atenciosamente,</p>
				<br />
		<br />
		<br />
		<p>Santo André, <variavel> </p>
		
		
		
		
		
		
		
	<?php 
	break;	
	case 304: // OS	
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

