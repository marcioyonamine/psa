<?php include "header.php"; ?>
<?php 

/*
// gera ranking

$edital = $_GET['edital'];
$sql_gera = "SELECT DISTINCT inscricao FROM ava_nota WHERE edital = '$edital'";
$resultados = $wpdb->get_results($sql_gera,ARRAY_A);

//echo $sql_gera;
//echo "<br />";
//var_dump($resultados);

for($i = 0; $i < count($resultados); $i++){
	//verifica quantos usuários deram nota
	$sql_user = "SELECT DISTINCT usuario FROM ava_nota WHERE inscricao ='".$resultados[$i]['inscricao']."'";
	$usuarios = $wpdb->get_results($sql_user,ARRAY_A);	
	$n_user = count($usuarios);
	// contamos todos os valores
	$sql_notas = "SELECT nota FROM ava_nota WHERE inscricao = '".$resultados[$i]['inscricao']."'";
	$notas = $wpdb->get_results($sql_notas,ARRAY_A);	
	$total = 0;
	for($k = 0; $k < count($notas); $k++){
		$total = $total + $notas[$k]['nota'];
	}
	$inscricao = $resultados[$i]['inscricao'];
	$nota_media = $total/$n_user;
	
	$sql_insc = "SELECT descricao FROM ava_inscricao WHERE inscricao = '$inscricao'";
	$insc_json = $wpdb->get_results($sql_insc,ARRAY_A);
	$insc = json_decode($insc_json[0]['descricao'],true);
	$categoria = $insc['3.2 - Categoria'];
	//echo "<pre>";
	//var_dump($insc);
	//echo "</pre>";
	$sql_atualiza = "UPDATE ava_ranking SET
	nota = '$nota_media',
	filtro = '$categoria'
	WHERE inscricao = '$inscricao'
	";
	$atualiza = $wpdb->query($sql_atualiza);
	
	//echo $resultados[$i]['inscricao']." = ".$total." | média = ".$total/$n_user." Categoria: $categoria<br />"; 
	
	
	
}

*/

?>


  <body>
    <link href="css/jquery-ui.css" rel="stylesheet">
 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 
 <script>
$(function() {
	$( ".nota" ).mask("9.9");
});
  </script>
  <?php include "menu/menu_editais.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Inscrições</h1>


          <p>Para ter acesso aos detalhes dos projetos, é necessário que esteja logado no CulturAZ e que faça parte da equipe de pareceristas. <a href="http://culturaz.santoandre.sp.gov.br/autenticacao/" target="_blanck">Clique para logar</a></p>
		  <p>
		  <?php /*
		  if(isset($_GET['filtro'])){
			  $f = $_GET['filtro'];
		  }else{
			  $f = '0';
		  }
		  $sel = "SELECT DISTINCT filtro FROM ava_ranking ORDER BY filtro ASC";
		  $res_fil = $wpdb->get_results($sel,ARRAY_A);
		  for($i = 0; $i < count($res_fil); $i++){
			  if($f != $res_fil[$i]['filtro']){
				echo "<a href='ranking.php?edital=".$_GET['edital']."&filtro=".$res_fil[$i]['filtro']."' >".$res_fil[$i]['filtro']."</a> |  ";
			  }else{
				  echo $res_fil[$i]['filtro']." | ";
			  }
		  }
		  */
		  ?>
		  
		  </p>
		  

		<!--<div><select>
		<option></option>
		<input class="btn btn-sm btn-default" type="submit" value="Filtrar" />
		</select></div>-->
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
					<th>CulturAZ</th>
					<th>Proponente</th>
                    <th>Título</th>
					<th>Nota01</th>
					<th>Nota02</th>

					<th>Nota Final</th>
					<th></th>
				  </tr>
              </thead>
              <tbody>
				<?php 
				global $wpdb;
				$tipo = 'usuario';
				$id = 1;
				$x = opcaoDados($tipo,$id);
				$g = $x['edital'][1];
				
				$edital =  editais("",21);
				
				if(isset($_GET['order'])){
					$order = "ORDER BY nota DESC, filtro ASC";
				}else{
					$order = "ORDER BY nota DESC";
				}
				if(isset($_GET['filtro'])){
					$filtro = "AND filtro LIKE '".$_GET['filtro']."'";
				//var_dump($_GET['filtro']);

				}else{
					$filtro = "";
				}
				
				

				$ranking = "SELECT inscricao, nota FROM ava_ranking WHERE edital = '".$_GET['edital']."' $filtro  $order";
				$res = $wpdb->get_results($ranking,ARRAY_A);
				
				//var_dump($res);
				$k = 1;
				for($i = 0; $i < count($res); $i++){
					$id_insc = $res[$i]['inscricao'];
					$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$id_insc'";	
					$json = $wpdb->get_row($sel,ARRAY_A);	
					$res_json = converterObjParaArray(json_decode(($json['descricao'])));
					$nota = nota($res[$i]['inscricao']);

				?>	
    			 <tr>
                  <td><a href="http://culturaz.santoandre.sp.gov.br/inscricao/<?php echo substr($json['inscricao'],3); ?>" target="_blank" ><?php echo $json['inscricao']; ?> </a></td>

                  <td><?php echo $res_json['Agente responsável pela inscrição - Nome completo ou Razão Social']; ?></td>
				<td><?php echo $res_json['Título']; ?></td>
				<td><?php if(isset($nota[0]['nota'])){ echo $nota[0]['nota']; } ?></td>
				<td><?php if(isset($nota[1]['nota'])){ echo $nota[1]['nota']; } ?></td>
				<td><?php echo $res[$i]['inscricao']; ?></td>
                  <td>
				 </td>
					</tr>
				<?php 
					$k++;
				} ?>	


				</tbody>
            </table>
          </div>      </div>
    </div>
	<div>
	<?php 
	
	?>
</div>
</main>
	<?php 
include "footer.php";
?>