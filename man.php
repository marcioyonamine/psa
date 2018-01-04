<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';
}

?>
  <body>
  
  <?php include "menu/me_inicio.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
	<h1>Área de Manutenção</h1>		
<?php 
switch($p){
case 'inicio':
?>
  
<?php 
break;
case 'atualiza_categoria_ranking':  
if(isset($_GET['id_mapas'])){
	$id_mapas = $_GET['id_mapas'];
?>		  
<?php 
				$sql_sel_ins = "SELECT inscricao FROM ava_inscricao WHERE id_mapas = '$id_mapas'";
				$res = $wpdb->get_results($sql_sel_ins,ARRAY_A);
				
				
				for($i = 0; $i < count($res); $i++){
					$id_insc = $res[$i]['inscricao'];
					$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$id_insc'";	
					$json = $wpdb->get_row($sel,ARRAY_A);	
					$res_json = converterObjParaArray(json_decode(($json['descricao'])));
					$filtro = $res_json['3.2 - Categoria'];
					$sql_atualiza = "UPDATE ava_ranking SET filtro = '$filtro' WHERE inscricao = '$id_insc'";
					if($wpdb->query($sql_atualiza)){
						echo "$id_insc - Filtro atualizado.<br />";
					}else{
						echo "$id_insc - $sql_atualiza.<br />";
						
					}
				}
					
				}else{
					?>
					 <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Não há Edital indicado</h1>
				</div>
        </div>
		</div>
			<?php 	}

							
				?>


  
		  
<?php 
//break;
//case '':  
?>		  


<?php 
break;
}//fim da switch
?>		  
		  
        </main>
      </div>
    </div>
	
<?php 
include "footer.php";
?>