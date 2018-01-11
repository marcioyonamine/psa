<?php include "header.php"; ?>
<?php 
if(isset($_GET['edital'])){
	
	$projeto = $_GET['edital'];

	// atualiza ranking
	//verifica se existe o projeto no ranking
	$sql_ver = "SELECT id FROM ava_ranking WHERE edital = '$projeto'";
	$query_ver = $wpdb->get_results($sql_ver);
	if(count($query_ver) > 0){ // atualiza
		
		
	}else{ //insere
		$sql_insere = "INSERT INTO `ava_ranking` (`inscricao`, `edital`) SELECT inscricao, id_mapas FROM ava_inscricao WHERE id_mapas = '$projeto'";
		$query_insere = $wpdb->query($sql_insere);
		
	}

}


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
		  <?php 
		  $sel = "SELECT DISTINCT filtro FROM ava_ranking ORDER BY filtro ASC";
		  $res_fil = $wpdb->get_results($sel,ARRAY_A);
		  for($i = 0; $i < count($res_fil); $i++){
			  echo "<a href='ranking.php?edital=".$_GET['edital']."&filtro=".$res_fil[$i]['filtro']."' >".$res_fil[$i]['filtro']."</a> |  ";
		  }
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
					<th>Título</th>
                    <th>Proponente</th>
					<th>Cat</th>
                  <th>Área</th>
                  <th>Valor</th>
                  <th>Nota</th>
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
				
				$edital =  editais("",19);
				
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
				for($i = 0; $i < count($res); $i++){
					$id_insc = $res[$i]['inscricao'];
					$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$id_insc'";	
					$json = $wpdb->get_row($sel,ARRAY_A);	
					$res_json = converterObjParaArray(json_decode(($json['descricao'])));


				?>	
    			 <tr>
                  <td><a href="http://culturaz.santoandre.sp.gov.br/inscricao/<?php echo substr($json['inscricao'],3); ?>" target="_blank" ><?php echo $json['inscricao']; ?> </a></td>

                  <td><?php echo $res_json['3.1 - Título']; ?></td>
                  <td><?php echo $res_json['Agente responsável pela inscrição']; ?></td>
				<td><?php echo str_replace("CATEGORIA","",$res_json['3.2 - Categoria']); ?></td>
                  <td><?php echo $res_json['3.3 - Determine a área principal de enquadramento da proposta']; ?></td>
                  <td><?php echo $res_json['3.11 - Valor (em Reais)']; ?></td>
				  <td><?php echo $res[$i]['nota']; ?></td>
                  <td>
				  </td>
					</tr>
				<?php 

				} ?>	


				</tbody>
            </table>
          </div>      </div>
    </div>
	<div>
	<?php 
	
	?>
</div>
	<?php 
include "footer.php";
?>