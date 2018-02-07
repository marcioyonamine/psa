<?php 
/*
Calendário para os eventos Pré-CulturAZ

+ Listar filtros (quais?)
+ Aplicar cores
+ 

*/
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
?>

<?php //require_once("../../wp-load.php"); ?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />

    <title><?php echo $GLOBALS['site_title']; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/scpsa.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
 <script src="js/jquery-3.2.1.js"></script>
<link href='calendario/fullcalendar.min.css' rel='stylesheet' />
<link href='calendario/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='calendario/lib/moment.min.js'></script>
<script src='calendario/lib/jquery.min.js'></script>
<script src='calendario/fullcalendar.min.js'></script>
<script src='calendario/locale/pt-br.js'></script>
<script>

	$(document).ready(function() {
		
		var initialLocaleCode = 'pt-br';
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},
			defaultDate: '<?php echo date('Y-m-d'); ?>',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
			<?php 
			global $wpdb;
			$local = "";
			$linguagem = "";
			$projeto = "";
			if(isset($_GET['p'])){
				switch($_GET['p']){
					case "aniversario":
					$aniversario = " AND sc_evento.categoria <> '' ";
					break;
				}
			}else{
				$aniversario = "";
				
			}
			
			if(isset($_GET['filtro'])){
				if($_GET['local'] == 0){
					$local = "";
				}else{
					$local = " AND idLocal = '".$_GET['local']."' ";
				}
				
				if($_GET['linguagem'] == 0){
					$linguagem = "";
				}else{
					$linguagem = " AND idLinguagem = '".$_GET['linguagem']."' ";
				}
				
				if($_GET['projeto'] == 0){
					$projeto = "";
				}else{
					$projeto = " AND idProjeto = '".$_GET['projeto']."' ";
				}
				
			}
			
			$sql_busca = "SELECT sc_evento.idEvento,nomeEvento,data,hora,mapas,dataEnvio FROM sc_agenda, sc_evento WHERE sc_evento.idEvento = sc_agenda.idEvento $aniversario $linguagem $local $projeto";
			$res = $wpdb->get_results($sql_busca,ARRAY_A);
			for($i = 0; $i < count($res); $i++){
				$title = $res[$i]['nomeEvento'];
				$data = $res[$i]['data'];
				$hora = $res[$i]['hora'];
				echo "{title: '".$title."',";
				echo "start: '".$data."T".$hora."',";
				echo " url:'busca.php?p=view&tipo=evento&id=".$res[$i]['idEvento']."'";	
				if($res[$i]['dataEnvio'] == NULL){
					echo " , backgroundColor: 'red'";
				}else
				if($res[$i]['mapas'] != 0){
					echo " , backgroundColor: 'green'";	
				}
				echo "},";
			}
			?>
			]
 
		});
		
	});

</script>
<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 900px;
		margin: 0 auto;
		margin-top: 40px;
		
	}
	@media (min-width: 992px){
	#calendar{
		padding-left: 150px;
	}
	
}

</style>
</head>
<body>


<?php include "menu/me_agenda.php"; ?>


	<div id='calendar'>
	<?php //echo $sql_busca; ?>
	<br /><br />
	Legendas
	<p style="background:red; color: white; align = center;" >Não enviados</p> 
	<p style="background:#0275d8; color: white; align = center;" >Enviados</p> 
	<p style="background:green; color: white; align = center;" >Publicados no CulturAZ</p> 
	</div>
	<div>

	</div>
	
<?php 
include "footer.php";
?>
