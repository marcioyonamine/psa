<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}

?>


  <body>
  
  <?php include "menu.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
 <?php 
 switch($p){
case "inicio": ?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Meus Eventos</h1>
				</div>
        </div>
    </div>
</section>

 
	 
<?php 	 
break;	 
 case "inserir":
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
				$.getJSON('projeto.ajax.php?programa=',{programa: $(this).val(), ajax: 'true'}, function(j)
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
								<option value="1"></option>	
							</select>	                
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Segundo responsável (Suplente)</label>
							<select class="form-control" name="suplente" id="inputSubject" >
								<option value="1"></option>
							</select>	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="checkbox" name="subEvento" id="subEvento" <?php //checar($campo['subEvento']) ?>/><label style="padding:0 10px 0 5px;"> Haverá evento(s) complementar(es) (sub-evento)?</label>
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

	session_start();

	$nomeEvento = $_POST["nomeEvento"];
	$programa    = $_POST["programa"];
	$linguagem    = $_POST["linguagem"];
	$tipo_evento = $_POST["tipo_evento"];
	$projeto = $_POST["projeto"];
	$nomeResponsavel    = $_POST["nomeResponsavel"];
	$suplente    = $_POST["suplente"];
	$autor    = $_POST["autor"];
	$nomeGrupo    = $_POST["nomeGrupo"];
	$fichaTecnica    = $_POST["fichaTecnica"];
	$faixaEtaria    = $_POST["faixaEtaria"];
	$sinopse    = $_POST["sinopse"];
	$releaseCom    = $_POST["releaseCom"];
	$linksCom    = $_POST["linksCom"];
	if(isset($_POST['subEvento'])){
		$subEvento = $_POST['subEvento'];
	}else{
		$subEvento = NULL;
	}
	
	$idUser = $user->ID;
	
	global $wpdb;	
	// Inserir evento
	if(isset($_POST['inserir'])){
		$sql = "INSERT INTO `sc_evento` (`idEvento`, `idTipo`, `idPrograma`, `idProjeto`, `idLinguagem`, `nomeEvento`, `idResponsavel`, `idSuplente`, `autor`, `nomeGrupo`, `fichaTecnica`, `faixaEtaria`, `sinopse`, `releaseCom`, `publicado`, `idUsuario`, `linksCom`, `subEvento`, `dataEnvio`, `ocupacao`) 
		VALUES (NULL, '$tipo_evento', '$programa', '$projeto', '$linguagem', '$nomeEvento', '$nomeResponsavel', '$suplente', '$autor', '$nomeGrupo', '$fichaTecnica', '$faixaEtaria', '$sinopse', '$releaseCom', '1', '$idUser', '$linksCom', 'subEvento', NULL, NULL)";		$ins = $wpdb->query($sql);
		if($ins){
			$mensagem = "Inserido com sucesso";
			$id = $wpdb->insert_id;
			$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$id'";
			$evento = $wpdb->get_row($sql_select,ARRAY_A);
			
		}else{
			$mensage = "Erro ao inserir".var_dump($ins);
			
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
		`subEvento` = '$subEvento'
		WHERE `idEvento` = '$atualizar';
		";
		$atual = $wpdb->query($sql_atualizar);
		$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$atualizar'";
		$evento = $wpdb->get_row($sql_select,ARRAY_A);
		if($atual == 1){
			$mensagem = "Evento atualizado com sucesso.";
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
				$.getJSON('projeto.ajax.php?programa=',{programa: $(this).val(), ajax: 'true'}, function(j)
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
								<option value="1"></option>	
							</select>	                
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Segundo responsável (Suplente)</label>
							<select class="form-control" name="suplente" id="inputSubject" >
								<option value="1"></option>
							</select>	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="checkbox" name="subEvento" id="subEvento" <?php //checar($campo['subEvento']) ?>/><label style="padding:0 10px 0 5px;"> Haverá evento(s) complementar(es) (sub-evento)?</label>
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
							$_SESSION['idEvento'] = $evento['idEvento'];
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
case "meuseventos":
?>
<h2>Section title</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Header</th>
                  <th>Header</th>
                  <th>Header</th>
                  <th>Header</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1,001</td>
                  <td>Lorem</td>
                  <td>ipsum</td>
                  <td>dolor</td>
                  <td>sit</td>
                </tr>
                <tr>
                  <td>1,002</td>
                  <td>amet</td>
                  <td>consectetur</td>
                  <td>adipiscing</td>
                  <td>elit</td>
                </tr>
                <tr>
                  <td>1,003</td>
                  <td>Integer</td>
                  <td>nec</td>
                  <td>odio</td>
                  <td>Praesent</td>
                </tr>
                <tr>
                  <td>1,003</td>
                  <td>libero</td>
                  <td>Sed</td>
                  <td>cursus</td>
                  <td>ante</td>
                </tr>
                <tr>
                  <td>1,004</td>
                  <td>dapibus</td>
                  <td>diam</td>
                  <td>Sed</td>
                  <td>nisi</td>
                </tr>
                <tr>
                  <td>1,005</td>
                  <td>Nulla</td>
                  <td>quis</td>
                  <td>sem</td>
                  <td>at</td>
                </tr>
                <tr>
                  <td>1,006</td>
                  <td>nibh</td>
                  <td>elementum</td>
                  <td>imperdiet</td>
                  <td>Duis</td>
                </tr>
                <tr>
                  <td>1,007</td>
                  <td>sagittis</td>
                  <td>ipsum</td>
                  <td>Praesent</td>
                  <td>mauris</td>
                </tr>
                <tr>
                  <td>1,008</td>
                  <td>Fusce</td>
                  <td>nec</td>
                  <td>tellus</td>
                  <td>sed</td>
                </tr>
                <tr>
                  <td>1,009</td>
                  <td>augue</td>
                  <td>semper</td>
                  <td>porta</td>
                  <td>Mauris</td>
                </tr>
                <tr>
                  <td>1,010</td>
                  <td>massa</td>
                  <td>Vestibulum</td>
                  <td>lacinia</td>
                  <td>arcu</td>
                </tr>
                <tr>
                  <td>1,011</td>
                  <td>eget</td>
                  <td>nulla</td>
                  <td>Class</td>
                  <td>aptent</td>
                </tr>
                <tr>
                  <td>1,012</td>
                  <td>taciti</td>
                  <td>sociosqu</td>
                  <td>ad</td>
                  <td>litora</td>
                </tr>
                <tr>
                  <td>1,013</td>
                  <td>torquent</td>
                  <td>per</td>
                  <td>conubia</td>
                  <td>nostra</td>
                </tr>
                <tr>
                  <td>1,014</td>
                  <td>per</td>
                  <td>inceptos</td>
                  <td>himenaeos</td>
                  <td>Curabitur</td>
                </tr>
                <tr>
                  <td>1,015</td>
                  <td>sodales</td>
                  <td>ligula</td>
                  <td>in</td>
                  <td>libero</td>
                </tr>
              </tbody>
            </table>
          </div>


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