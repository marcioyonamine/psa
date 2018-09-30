<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
//session_start();
	$_SESSION['entidade'] = 'evento';
?>


  <body>
  
  <?php include "menu/me_aprovacao.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
 <?php 
 switch($p){
case "inicio": 
if(isset($_POST['enviar'])){  // envia
	// muda status de dataEnvio para hoje
	// atualiza a agenda
	$idEvento = $_SESSION['id'];
	$hoje = date("Y-m-d H:i:s");
	global $wpdb;
	$sql_enviar = "UPDATE sc_evento SET dataEnvio = '$hoje' WHERE idEvento = '$idEvento'";
	$upd = $wpdb->query($sql_enviar);
	if($upd == 1){
		atualizarAgenda($idEvento);
		$mensagem = alerta("Evento enviado com sucesso.","success");
		gravarLog($sql_enviar, $user->ID);
	}else{
		$mensagem = alerta("Erro. Tente novamente.","warning");
		gravarLog($sql_enviar, $user->ID);
	}
	
}

if(isset($_POST['aprovar'])){
	$mensagem = "";
	foreach($_POST as $x=>$y){
		if(is_int($x)){
			$update = "UPDATE sc_evento SET status = '3' WHERE idEvento = '".$x."'";
			$w = $wpdb->query($update);
			if($w == 1){
				$e = evento($x);
				$mensagem .= alerta("O status do evento ".$e['titulo']." foi atualizado com sucesso.","success");
			}else{
				$mensagem .= alerta("Erro","warning");
			}	
		}


		
	}
}


if(isset($_SESSION['id'])){
	unset($_SESSION['id']);
}

if(isset($_GET['order'])){
	$order = ' ORDER BY nomeEvento ASC ';
}else{
	$order = ' ORDER BY idEvento DESC ';
}

?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Meus Eventos para Aprovação</h1>
					<?php if(isset($mensagem)){echo $mensagem;}?>
				</div>
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th><a href="?<?php if(isset($_GET['order'])){ echo "";}else{ echo "order"; } ?>">Título</a></th>
                  <th>Data</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
				<?php 
				global $wpdb;
					$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND status = '2' AND idRespAprovacao = '".$user->ID."' $order";					


				$res = $wpdb->get_results($sql_list,ARRAY_A);
				for($i = 0; $i < count($res); $i++){
					$evento = evento($res[$i]['idEvento']);
					
					?>
					<tr>
					  <td><?php echo $res[$i]['idEvento']; ?></td>
					  <td>
					
					  <a href="busca.php?p=view&tipo=evento&id=<?php echo $res[$i]['idEvento'] ?>" target=_blank>
						
					  <?php echo $evento['titulo']; ?>
					
						</a>
						
					  </td>

					  
					  <td><?php echo $evento['periodo']['legivel']; ?></td>
					  <td><?php echo $evento['status']; ?></td>
					  <td>	<form method="POST" action="?p=editar" class="form-horizontal" role="form">
							<input type="hidden" name="carregar" value="<?php echo $res[$i]['idEvento']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
							</form>
							</td>
					</tr>
				<?php } // fim do for?>	
				
              </tbody>
            </table>
          </div>

		</div>
</section>

<?php 
break;
case "serie": 

if(isset($_GET['order'])){
	$order = ' ORDER BY nomeEvento ASC ';
}else{
	$order = ' ORDER BY idEvento DESC ';
}

if(isset($_POST['enviar'])){  // envia
	// muda status de dataEnvio para hoje
	// atualiza a agenda
	$idEvento = $_SESSION['id'];
	$hoje = date("Y-m-d H:i:s");
	global $wpdb;
	$sql_enviar = "UPDATE sc_evento SET dataEnvio = '$hoje' WHERE idEvento = '$idEvento'";
	$upd = $wpdb->query($sql_enviar);
	if($upd == 1){
		atualizarAgenda($idEvento);
		$mensagem = alerta("Evento enviado com sucesso.","success");
	}else{
		$mensagem = alerta("Erro. Tente novamente.","warning");
	
	}
	
}
if(isset($_SESSION['id'])){
	unset($_SESSION['id']);
}
?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Meus Eventos para Aprovação</h1>
					<?php if(isset($mensagem)){echo $mensagem;}?>
				</div>
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th><a href="?<?php if(isset($_GET['order'])){ echo "";}else{ echo "order"; } ?>">Título</a></th>
                  <th>Data</th>
                  <th>Responsável</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
			  <form method="POST" action="?" class="form-horizontal" role="form">
				<?php 
				global $wpdb;
					$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND status = '2' AND idRespAprovacao = '".$user->ID."' $order";					


				$res = $wpdb->get_results($sql_list,ARRAY_A);
				for($i = 0; $i < count($res); $i++){
					$evento = evento($res[$i]['idEvento']);
					
					?>
					<tr>
					  <td><?php echo $res[$i]['idEvento']; ?></td>
					  <td>
					
					  <a href="busca.php?p=view&tipo=evento&id=<?php echo $res[$i]['idEvento'] ?>" target=_blank>
						
					  <?php echo $evento['titulo']; ?>
					
						</a>
						
					  </td>

					  
					  <td><?php echo $evento['periodo']['legivel']; ?></td>
					  <td><?php echo $evento['responsavel']; ?></td>
					  <td><input type="checkbox" class="form-check-input" id="exampleCheck1" name="<?php echo $res[$i]['idEvento'] ?>">
							</td>
					</tr>
				<?php } // fim do for?>	
              </tbody>
            </table>
<input type="submit" name="aprovar" value="Aprovar todos os eventos selecionados." class="btn btn-primary">
			</form>
			</div>

		</div>
</section>

 <?php 
break;
case "foradeprazo": 


?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Eventos</h1>
					<?php if(isset($mensagem)){echo $mensagem;}?>
				</div>
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Título</th>
                  <th>Data</th>
                  <th>Responsável</th>
				  <th></th>
				  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
				<?php 
				global $wpdb;
				$idUser = $user->ID;
				$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND status = '1' ORDER BY idEvento DESC";
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				for($i = 0; $i < count($res); $i++){

					
					
					
					$evento = evento($res[$i]['idEvento']);
					
					?>
					<tr>
					  <td><?php echo $res[$i]['idEvento']; ?></td>
					  <td><?php echo $evento['titulo']; ?></td>
					  <td><?php echo $evento['periodo']['legivel']; ?></td>
					  <td><?php echo $evento['responsavel']; ?></td>
					  <td></td>
					  <td></a></td>

					  <td>	<?php if($evento['dataEnvio'] == NULL){ ?>
							<form method="POST" action="?p=editar" class="form-horizontal" role="form">
							<input type="hidden" name="carregar" value="<?php echo $res[$i]['idEvento']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
							</form>
							<?php 
							}
					  ?></td>
					</tr>
					
				<?php 
					
				} // fim do for?>	
				
              </tbody>
            </table>
          </div>

		</div>
</section>

 

	 
<?php 	 
break;	 
 case "inserir":
 if(isset($_SESSION['id'])){
	unset($_SESSION['id']);
}

 ?>

 <script type="application/javascript">
	$(function()
	{
		$('#programa').change(function()
		{
			if( $(this).val() )
			{
				$('#projeto').hide();
				$('.carregando').show();
				$.getJSON('inc/projeto.ajax.php?programa=',{programa: $(this).val(), ajax: 'true'}, function(j)
				{
					var options = '<option value="0"></option>';	
					for (var i = 0; i < j.length; i++)
					{
						options += '<option value="' + j[i].id + '">' + j[i].projeto + '</option>';
					}	
					$('#projeto').html(options).show();
					$('.carregando').hide();
				});
			}
			else
			{
				$('#projeto').html('<option value="">-- Escolha um projeto --</option>');
			}
		});
	});
</script>
 
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Evento - Informações Gerais</h3>
                    <h1></h1>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
            </div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<!--<input type="checkbox" name="planejamento" id="subEvento" <?php //checar($campo['subEvento']) ?>/><label style="padding:0 10px 0 5px;"> Evento em planejamento?</label>-->
						</div>
					</div>
				<div class="form-group">
						<div class="col-md-offset-2">
							<label>Nome do Evento *</label>
							<input type="text" name="nomeEvento" class="form-control" id="inputSubject" value=""/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Programa</label>
							<select class="form-control" name="programa" id="programa" >
								<?php geraTipoOpcao("programa") ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Projeto</label>
							<select class="form-control" name="projeto" id="projeto" >
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Linguagem principal *</label>
							<select class="form-control" name="linguagem" id="inputSubject" >
								<?php geraTipoOpcao("linguagens") ?>
							</select>					
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Tipo de evento *</label>
							<select class="form-control" name="tipo_evento" id="inputSubject" >
								<?php geraTipoOpcao("tipo_evento") ?>
							</select>					
						</div>
					</div>
					<div class="form-group">
						<br />
						<p>O responsável e suplente devem estar cadastrados como usuários do sistema.</p>
						<div class="col-md-offset-2">
							<label>Primeiro responsável (Fiscal)</label>
							<select class="form-control" name="nomeResponsavel" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario();	?>							
							</select>	                
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Segundo responsável (Suplente)</label>
							<select class="form-control" name="suplente" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario();	?>							

								</select>	
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Autor*</label>
							<textarea name="autor" class="form-control" rows="10" placeholder="Artista, banda, coletivo, companhia, palestrantes, etc autor da obra/espetáculo."></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Nome do Grupo</label>
							<input type="text" name="nomeGrupo" class="form-control" maxlength="100" id="inputSubject" placeholder="Nome do coletivo, grupo teatral, etc." value=""/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Cidade do Autor/Grupo/Artista</label>
							<select class="form-control" name="artista_cidade" id="inputSubject" >
															<option></option>
								<?php geraTipoOpcao("artista_local") ?>
							</select>
						</div>
					</div>					
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Outra cidade</label>
							<input type="text" name="outra_cidade" class="form-control" maxlength="100" id="inputSubject" placeholder="" value=""/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Número de agentes envolvidos</label>
							<input type="text" name="n_agentes" class="form-control" maxlength="100" id="inputSubject" placeholder="" value=""/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Número de agentes envolvidos Santo André e Região</label>
							<input type="text" name="n_agentes_abc" class="form-control" maxlength="100" id="inputSubject" placeholder="" value=""/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Número de Inscrição CulturAZ (caso tenha sido selecionado via plataforma)</label>
							<input type="text" name="inscricao" class="form-control" maxlength="100" id="inputSubject" placeholder="" value=""/>
						</div> 
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Ficha técnica completa*</label>
							<textarea name="fichaTecnica" class="form-control" rows="10" placeholder="Elenco, técnicos, programa do concerto, outros profissionais envolvidos."><?php ////echo $campo["fichaTecnica"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Classificação/indicação etária</label>
							<select class="form-control" name="faixaEtaria" id="inputSubject" >
								<?php geraTipoOpcao("faixa_etaria") ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Sinopse *</label>
							<textarea name="sinopse" class="form-control" rows="10" placeholder="Texto para divulgação e sob editoria da area de comunicação. Não ultrapassar 400 caracteres."><?php //echo $campo["sinopse"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Release *</label>
							<textarea name="releaseCom" class="form-control" rows="10" placeholder="Texto auxiliar para as ações de comunicação. Releases do trabalho, pequenas biografias, currículos, etc"><?php ////echo $campo["releaseCom"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Links </label>
							<textarea name="linksCom" class="form-control" rows="10" placeholder="Links para auxiliar a divulgação e o jurídico. Site oficinal, vídeos, clipping, artigos, etc "><?php ////echo $campo["linksCom"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="inserir" value="1" />
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>



<?php 
break;
case "editar":

	global $wpdb;	
	
	if(isset($_SESSION['id'])){
		$id = $_SESSION['id'];
		$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$id'";
		$evento = $wpdb->get_row($sql_select,ARRAY_A);
	}

	if(isset($_POST['atualizar']) OR isset($_POST['inserir'])){
		$nomeEvento = addslashes($_POST["nomeEvento"]);
		$programa    = $_POST["programa"];
		$linguagem    = $_POST["linguagem"];
		$tipo_evento = $_POST["tipo_evento"];
		$projeto = $_POST["projeto"];
		$nomeResponsavel = $_POST["nomeResponsavel"];
		$suplente = $_POST["suplente"];
		$autor = addslashes($_POST["autor"]);
		$nomeGrupo = addslashes($_POST["nomeGrupo"]);
		$fichaTecnica = addslashes($_POST["fichaTecnica"]);
		$faixaEtaria = $_POST["faixaEtaria"];
		$sinopse = addslashes($_POST["sinopse"]);
		$releaseCom = addslashes($_POST["releaseCom"]);
		$linksCom = addslashes($_POST["linksCom"]);
		$artista_cidade = $_POST['artista_cidade'];
		$outra_cidade = $_POST['outra_cidade'];
		$n_agentes = $_POST['n_agentes'];
		$n_agentes_abc = $_POST['n_agentes_abc'];
		$inscricao = $_POST['inscricao'];
		
		

		if(isset($_POST['subEvento'])){
			$subEvento = $_POST['subEvento'];
		}else{
			$subEvento = NULL;
		}
		if(isset($_POST['planejamento'])) : $planejamento = 1; else: $planejamento = NULL; endif;
	}
	
	if(isset($_POST['carregar'])){
		$id = $_POST['carregar'];
		$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$id'";
		$evento = $wpdb->get_row($sql_select,ARRAY_A);	
		$_SESSION['id'] = $id;
	}
	
	$idUser = $user->ID;
	

	// Inserir evento
	if(isset($_POST['inserir'])){
		$sql = "INSERT INTO `sc_evento` (`idEvento`, `idTipo`, `idPrograma`, `idProjeto`, `idLinguagem`, `nomeEvento`, `idResponsavel`, `idSuplente`, `autor`, `nomeGrupo`, `fichaTecnica`, `faixaEtaria`, `sinopse`, `releaseCom`, `publicado`, `idUsuario`, `linksCom`, `subEvento`, `dataEnvio`, `ocupacao`, `planejamento`, `artista_local`, `cidade`, `n_agentes`, `n_agentes_abc`, `inscricao` ) 
		VALUES (NULL, '$tipo_evento', '$programa', '$projeto', '$linguagem', '$nomeEvento', '$nomeResponsavel', '$suplente', '$autor', '$nomeGrupo', '$fichaTecnica', '$faixaEtaria', '$sinopse', '$releaseCom', '1', '$idUser', '$linksCom', 'subEvento', NULL, NULL, '$planejamento','$artista_cidade','$outra_cidade', '$n_agentes','$n_agentes_abc','$inscricao')";		
		$ins = $wpdb->query($sql);
		if($ins){
			$mensagem = "Inserido com sucesso";
			$id = $wpdb->insert_id;
			$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$id'";
			$evento = $wpdb->get_row($sql_select,ARRAY_A);
			$_SESSION['id'] = $evento['idEvento'];
			gravarLog($sql, $user->ID);
			
		}else{
			$mensage = "Erro ao inserir";
			gravarLog($sql, $user->ID);
			
		}
		
	}

	if(isset($_POST['atualizar'])){
	$atualizar    = $_POST["atualizar"];	
		$sql_atualizar = "UPDATE sc_evento SET
		`idTipo` = '$tipo_evento',
		`idPrograma` = '$programa' ,
		`idProjeto` =  '$projeto',
		`idLinguagem` = '$linguagem',
		`nomeEvento` = '$nomeEvento',
		`idResponsavel` = '$nomeResponsavel',
		`idSuplente` = '$suplente',
		`autor` = '$autor',
		`nomeGrupo` = '$nomeGrupo',
		`fichaTecnica` = '$fichaTecnica',
		`faixaEtaria` = '$faixaEtaria',
		`sinopse` = '$sinopse',
		`releaseCom` = '$releaseCom',
		`linksCom` = '$linksCom',
		`planejamento` = '$planejamento',
		`subEvento` = '$subEvento',
		`artista_local` = '$artista_cidade',
		`cidade` = '$outra_cidade',
		`n_agentes` = '$n_agentes',
		`n_agentes_abc` = '$n_agentes_abc',
		`inscricao` = '$inscricao'
		
		WHERE `idEvento` = '$atualizar';
		";
		$atual = $wpdb->query($sql_atualizar);
		$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$atualizar'";
		$evento = $wpdb->get_row($sql_select,ARRAY_A);
		$_SESSION['id'] = $evento['idEvento'];
		
		if($atual == 1){
			$mensagem = alerta("Evento atualizado com sucesso.","success");
			gravarLog($sql_atualizar, $user->ID);
		}else{
			//$mensagem = "Erro ao atualizar.";
		}

	}
	

	
	
?>
 <script type="application/javascript">
	$(function()
	{
		$('#programa').change(function()
		{
			if( $(this).val() )
			{
				$('#projeto').hide();
				$('.carregando').show();
				$.getJSON('inc/projeto.ajax.php?programa=',{programa: $(this).val(), ajax: 'true'}, function(j)
				{
					var options = '<option value="0"></option>';	
					for (var i = 0; i < j.length; i++)
					{
						options += '<option value="' + j[i].id + '">' + j[i].projeto + '</option>';
					}	
					$('#projeto').html(options).show();
					$('.carregando').hide();
				});
			}
			else
			{
				$('#projeto').html('<option value="">-- Escolha um projeto --</option>');
			}
		});
	});
</script>

 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Evento - Informações Gerais</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<!--<input type="checkbox" name="planejamento" id="subEvento" <?php checar($evento['planejamento']) ?>/><label style="padding:0 10px 0 5px;"> Evento em planejamento?</label>-->
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Nome do Evento *</label>
							<input type="text" name="nomeEvento" class="form-control" id="inputSubject" value="<?php echo $evento['nomeEvento']; ?>"/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Programa</label>
							<select class="form-control" name="programa" id="programa" >
								<?php geraTipoOpcao("programa",$evento['idPrograma']) ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Projeto</label>
							<select class="form-control" name="projeto" id="projeto" >
								<?php geraTipoOpcao("projeto",$evento['idProjeto']) ?>								
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Linguagem principal *</label>
							<select class="form-control" name="linguagem" id="inputSubject" >
								<?php geraTipoOpcao("linguagens",$evento['idLinguagem']) ?>
							</select>					
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Tipo de evento *</label>
							<select class="form-control" name="tipo_evento" id="inputSubject" >
								<?php geraTipoOpcao("tipo_evento",$evento['idTipo']) ?>
							</select>					
						</div>
					</div>
					<div class="form-group">
						<br />
						<p>O responsável e suplente devem estar cadastrados como usuários do sistema.</p>
						<div class="col-md-offset-2">
							<label>Primeiro responsável (Fiscal)</label>
							<select class="form-control" name="nomeResponsavel" id="inputSubject" >
								<option value="0"></option>	
								<?php geraOpcaoUsuario($evento['idResponsavel'])	?>							

								</select>	                
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Segundo responsável (Suplente)</label>
							<select class="form-control" name="suplente" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario($evento['idSuplente'])	?>							

								</select>	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Autor*</label>
							<textarea name="autor" class="form-control" rows="10" placeholder="Artista, banda, coletivo, companhia, palestrantes, etc autor da obra/espetáculo."><?php echo $evento['autor']; ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Nome do Grupo</label>
							<input type="text" name="nomeGrupo" class="form-control" maxlength="100" id="inputSubject" placeholder="Nome do coletivo, grupo teatral, etc." value="<?php echo $evento['nomeGrupo']; ?>"/>
						</div> 
					</div>
										<div class="form-group">
						<div class="col-md-offset-2">
							<label>Cidade do Autor/Grupo/Artista</label>
							<select class="form-control" name="artista_cidade" id="inputSubject" >
								<option></option>
								<?php geraTipoOpcao("artista_local",$evento['artista_local']) ?>
							</select>
						</div>
					</div>					
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Outra cidade</label>
							<input type="text" name="outra_cidade" class="form-control" maxlength="100" id="inputSubject" placeholder="" value="<?php echo $evento['cidade']; ?>"/>
						</div> 
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Número de agentes envolvidos</label>
							<input type="text" name="n_agentes" class="form-control" maxlength="100" id="inputSubject" placeholder="" value="<?php echo $evento['n_agentes']; ?>"/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Número de agentes envolvidos Santo André e Região</label>
							<input type="text" name="n_agentes_abc" class="form-control" maxlength="100" id="inputSubject" placeholder="" value="<?php echo $evento['n_agentes_abc']; ?>"/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Número de Inscrição CulturAZ (caso tenha sido selecionado via plataforma)</label>
							<input type="text" name="inscricao" class="form-control" maxlength="100" id="inputSubject" placeholder="" value="<?php echo $evento['inscricao']; ?>"/>
						</div> 
					</div>
					
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Ficha técnica completa*</label>
							<textarea name="fichaTecnica" class="form-control" rows="10" placeholder="Elenco, técnicos, programa do concerto, outros profissionais envolvidos."><?php echo $evento["fichaTecnica"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Classificação/indicação etária</label>
							<select class="form-control" name="faixaEtaria" id="inputSubject" >
								<?php geraTipoOpcao("faixa_etaria",$evento['faixaEtaria']) ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Sinopse *</label>
							<textarea name="sinopse" class="form-control" rows="10" placeholder="Texto para divulgação e sob editoria da area de comunicação. Não ultrapassar 400 caracteres."><?php echo $evento["sinopse"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Release *</label>
							<textarea name="releaseCom" class="form-control" rows="10" placeholder="Texto auxiliar para as ações de comunicação. Releases do trabalho, pequenas biografias, currículos, etc"><?php echo $evento["releaseCom"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Links </label>
							<textarea name="linksCom" class="form-control" rows="10" placeholder="Links para auxiliar a divulgação e o jurídico. Site oficinal, vídeos, clipping, artigos, etc "><?php echo $evento["linksCom"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="atualizar" value="<?php echo $evento['idEvento']; ?>" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Atualizar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>


<?php 
break;
case "enviar":

?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Enviar eventos fora do prazo</h1>
				</div>
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Título</th>
                  <th>Data</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
				<?php 
				global $wpdb;
				$sql_list =  "SELECT idEvento FROM sc_evento AND publicado ='1' AND status = '1' ORDER BY idEvento DESC";
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				for($i = 0; $i < count($res); $i++){
					$evento = evento($res[$i]['idEvento']);
					
					?>
					<tr>
					  <td><?php echo $res[$i]['idEvento']; ?></td>
					  <td><?php echo $evento['titulo']; ?></td>
					  <td><?php echo $evento['programa']; ?></td>
					  <td><?php echo $evento['projeto']; ?></td>
					  <td>	
							<form method="POST" action="?p=editar" class="form-horizontal" role="form">
							<input type="hidden" name="carregar" value="<?php echo $res[$i]['idEvento']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
							</form>
							<?php 
					  
					  ?></td>
					</tr>
				<?php } // fim do for?>	
				
              </tbody>
            </table>
          </div>

		</div>
</section>
<?php 
break;
case "pedido":
if(isset($_GET['order'])){
	$order = ' ORDER BY nomeEvento ASC ';
}else{
	$order = ' ORDER BY sc_evento.idEvento DESC ';
}

?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Pedidos de Contratação</h1>
					<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
				</div>
        </div>
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">

				</div>
        </div>

		<?php 
		// se existe pedido, listar
		
		?>
		
    <div class="container">
        <div class="row">    
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
				<th>Num</th>

				<th>Liberação</th>
                  <th>Pessoa</th>
                  <th>Nome / Razão Social</th>
                  <th><a href="?p=pedido<?php if(isset($_GET['order'])){ echo ""; }else{ echo "&order"; }  ?>">Objeto</a></th>
				  <th>Período</th>
				  <th>Valor</th>
				  <th></th>
				  <th></th>
				  </tr>
              </thead>
              <tbody>
				<?php 
				$idUser = $user->ID;
				if(isset($_GET['f'])){
					$f = "AND (liberado = '0000-00-00' OR nLiberacao = '') ";
				}else{
					$f = "";
				}
				
				
				//$sql_seleciona = "SELECT * FROM sc_contratacao WHERE publicado = '1' AND (idEvento IN (SELECT idEvento FROM sc_evento WHERE dataEnvio IS NOT NULL  AND (idUsuario = '$idUser' OR idResponsavel = '$idUser' OR idSuplente = '$idUser') $order )) $f ";
				
				$sql_seleciona = "SELECT DISTINCT idPedidoContratacao,sc_evento.idEvento, valor FROM sc_contratacao,sc_evento WHERE sc_contratacao.publicado = 1 AND sc_evento.dataEnvio IS NOT NULL AND (idUsuario = '$idUser' OR idResponsavel = '$idUser' OR idSuplente = '$idUser') AND sc_contratacao.idEvento = sc_evento.idEvento $order";
				
				$peds = $wpdb->get_results($sql_seleciona,ARRAY_A);
				//echo $sql_seleciona;
				
				for($i = 0; $i < count($peds); $i++){
					if($peds[$i]['idEvento'] != 0 AND $peds[$i]['idEvento'] != NULL){
						$pedido = retornaPedido($peds[$i]['idPedidoContratacao']);
					}else{
						//$pedido = atividade($peds[$i]['idAtividade']);
						$pedido = retornaPedido($peds[$i]['idPedidoContratacao']);
					}
					//var_dump($pedido);
					?>
					<tr>
					  <td><?php echo $peds[$i]['idPedidoContratacao']; ?></td>
					  <td><?php if($pedido['liberado'] != '0000-00-00'){echo exibirDataBr($pedido['liberado']);} ?></td>

					  
					  <td><?php echo $pedido['tipoPessoa']; ?></td>
					  <td><?php echo $pedido['nome']; ?></td>
					  <td><?php echo $pedido['objeto']; ?></td>
					  <td><?php echo $pedido['periodo']; ?></td>
					  <td><?php echo dinheiroParaBr($peds[$i]['valor']); ?></td>
					  <?php if($pedido['tipo'] == 'Pessoa Física'){ ?>
					  <td>	
							<form method="POST" action="contratacao.php?p=editar_pf" class="form-horizontal" role="form">
							<input type="hidden" name="editar_pf" value="<?php echo $peds[$i]['idPessoa']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar Pessoa">
							</form>
							</td>
					<?php }else{ ?>
					  <td>	
							<form method="POST" action="contratacao.php?p=editar_pj" class="form-horizontal" role="form">
							<input type="hidden" name="editar_pj" value="<?php echo $peds[$i]['idPessoa']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar Pessoa">
							</form>
							</td>
					<?php } ?>

					  <td>	
							<form method="POST" action="contratacao.php?p=editar_pedido" class="form-horizontal" role="form">
							<input type="hidden" name="editar_pedido" value="<?php echo $peds[$i]['idPedidoContratacao']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar Pedido">
							</form>
							<?php 
					  
					  ?></td>
					  <td>	
							
							<?php 
					  
					  ?></td>

					  </tr>
				<?php } // fim do for?>	
				
              </tbody>
            </table>
          </div>

		
		
</div>
</section>


<?php 
break;
} // fim da switch p

?>
  
        </main>
      </div>
    </div>
	
<?php 
include "footer.php";
?>