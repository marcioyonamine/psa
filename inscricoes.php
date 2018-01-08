<?php include "header.php"; ?>

  <body>
  
  <?php include "menu/menu_editais.php"; ?>

<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';
}


switch($p){
	case "inicio":
	$edital =  273;
	$aval = verificaAvaliacao($user->ID,$edital);
	//var_dump($aval);
?>

  
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Inscrições</h1>


          <p>Para ter acesso aos detalhes dos projetos, é necessário que esteja logado no CulturAZ e que faça parte da equipe de pareceristas. <a href="http://culturaz.santoandre.sp.gov.br/autenticacao/" target="_blanck">Clique para logar</a></p>
		  <p>
		  Você tem <strong><?php echo $aval['zeradas']?></strong> inscrições zerada(s) ou sem avaliação e <strong><?php echo $aval['anotacao']?></strong> com o campo observação em branco.
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
				$id = $user->ID;
				$x = opcaoDados($tipo,$id);
				$g = $x['edital'][1];
				
				$edital =  editais("",19);

				
				$sql_sel_ins = "SELECT avaliadores FROM ava_edital WHERE id_mapas = '273'";
				$sel = $wpdb->get_row($sql_sel_ins,ARRAY_A);

				$res = json_decode($sel['avaliadores'],true);
				$inscritos = $res[$g];
				//var_dump($res);
				for($i = 0; $i < count($res[$g]); $i++){
					$id_insc = $res[$g][$i];
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
				  <td><?php echo somaNotas($json['inscricao'],$user->ID); ?></td>
                  <td>
				  <form method="POST" action="avaliacao.php" class="form-horizontal" role="form">
							<input type="hidden" name="carregar" value="<?php echo $json['inscricao']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Avaliar">
							</form></td>
					</tr>
				<?php 

				} ?>	


				</tbody>
            </table>
          </div>

<?php 
break;
case 'all':

?>
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Inscrições</h1>


          <p>Para ter acesso aos detalhes dos projetos, é necessário que esteja logado no CulturAZ e que faça parte da equipe de pareceristas. <a href="http://culturaz.santoandre.sp.gov.br/autenticacao/" target="_blanck">Clique para logar</a></p>
		<!--<div><select>
		<option></option>
		<input class="btn btn-sm btn-default" type="submit" value="Filtrar" />
		</select></div>-->
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
					<th>#</th>
					<th>CulturAZ</th>
					<th>Título</th>
                    <th>Proponente</th>
					<th>Cat</th>
                  <th>Área</th>
                  <th>Valor</th>
                  <th>N1</th>
                  <th>N2</th>
                  <th>NM</th>
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
				$pag = 20;

				
				$sql_sel_ins = "SELECT inscricao FROM ava_inscricao";
				$res = $wpdb->get_results($sql_sel_ins,ARRAY_A);
				
				
				for($i = 0; $i < count($res); $i++){
					$id_insc = $res[$i]['inscricao'];
					$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$id_insc'";	
					$json = $wpdb->get_row($sel,ARRAY_A);	
					$res_json = converterObjParaArray(json_decode(($json['descricao'])));
					$nota = nota($id_insc);
					//var_dump($nota);
					
					if($i%$pag != 0 OR $i == 0){
					
				?>	
    			 <tr>
				 <td><?php echo $i+1; ?></td>
                  <td><a href="http://culturaz.santoandre.sp.gov.br/inscricao/<?php echo substr($json['inscricao'],3); ?>" target="_blank" ><?php echo $json['inscricao']; ?> </a></td>

                  <td><?php echo $res_json['3.1 - Título']; ?></td>
                  <td><?php echo $res_json['Agente responsável pela inscrição']; ?></td>
				  <td><?php echo str_replace("CATEGORIA","",$res_json['3.2 - Categoria']); ?></td>
                  <td><?php echo $res_json['3.3 - Determine a área principal de enquadramento da proposta']; ?></td>
                  <td><?php echo $res_json['3.11 - Valor (em Reais)']; ?></td>
				  <td><?php if(isset($nota['pareceristas'][0])){echo $nota['pareceristas'][0]['nota'];}?></td>
				  <td><?php if(isset($nota['pareceristas'][1])){echo $nota['pareceristas'][1]['nota'];}?></td>
				  <td><?php if(isset($nota['media'])){echo $nota['media'];}?></td>
                 
					</tr>
				<?php }else{

					?>
                <tr>
					<th>#</th>
					<th>CulturAZ</th>
					<th>Título</th>
                    <th>Proponente</th>
					<th>Cat</th>
                  <th>Área</th>
                  <th>Valor</th>
                  <th>N1</th>
                  <th>N2</th>
                  <th>NM</th>
				  </tr>

				<tr>
				 <td><?php echo $i+1; ?></td>
                  <td><a href="http://culturaz.santoandre.sp.gov.br/inscricao/<?php echo substr($json['inscricao'],3); ?>" target="_blank" ><?php echo $json['inscricao']; ?> </a></td>

                  <td><?php echo $res_json['3.1 - Título']; ?></td>
                  <td><?php echo $res_json['Agente responsável pela inscrição']; ?></td>
				  <td><?php echo str_replace("CATEGORIA","",$res_json['3.2 - Categoria']); ?></td>
                  <td><?php echo $res_json['3.3 - Determine a área principal de enquadramento da proposta']; ?></td>
                  <td><?php echo $res_json['3.11 - Valor (em Reais)']; ?></td>
				  <td><?php if(isset($nota['pareceristas'][0])){echo $nota['pareceristas'][0]['nota'];}?></td>
				  <td><?php if(isset($nota['pareceristas'][1])){echo $nota['pareceristas'][1]['nota'];}?></td>
				  <td><?php if(isset($nota['media'])){echo $nota['media'];}?></td>
                 
					</tr>
					
					
				<?php	}

				} ?>	


				</tbody>
            </table>
          </div>
<?php
break;
} //fim switch
?>
		  </main>
      </div>
    </div>
	
<?php 
include "footer.php";
?>