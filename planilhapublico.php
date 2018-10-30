<?php 
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

if(isset($_GET['ano'])){
	$ano = $_GET['ano'];
}else{
	$ano = date('Y');
}

if(isset($_GET['mes'])){
	$mes = $_GET['mes'];
}else{
	$mes = date('m');
}

$ultimo_dia = ultimoDiaMes($ano,$mes);

?>
<style>
body{
	font-size:10px;
}
.pieChart{
	float: right;
	
	
}
</style>
<table border='1'>
	<tr>
		<th>Mapas</th>
		<th>Bartira</th>
		<th>Evento</th>
		<th>Local</th>

		<th>Dias úteis</th>
		<th>Público</th>
		<th>Responsável</th>
	</tr>

<?php 
// busca no calendário
$sql = "SELECT DISTINCT idEvento, idLocal FROM sc_agenda WHERE idLocal <> '0' AND data >= '".$ano."-".$mes."-01' AND data <= '".$ano."-".$mes."-".$ultimo_dia."' ORDER BY idEvento";
$e = $wpdb->get_results($sql,ARRAY_A);

for($i = 0; $i < count($e); $i++){
$evento = evento($e[$i]['idEvento']);
$local = tipo($e[$i]['idLocal']);

?>
<tr>
	<td><?php echo $evento['idMapas']; ?></td>
	<td><?php echo $e[$i]['idEvento']; ?></td>
	<td><?php echo $evento['titulo']; ?></td>
	<td><?php echo $local['tipo']; ?></td>
	<td></td>
	<td></td>
	<td><?php echo $evento['responsavel']; ?></td>



</tr>

<?php 	
	
}

?>

<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>



</tr>







</table>


