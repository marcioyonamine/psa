<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
//session_start();

?>


  <body>
  
  <?php include "menu/me_arquivo.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
 <?php 
 switch($p){
case "inicio": 


?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<?php
					// listar o evento; criar um if para cada tipo de upload
					$evento = evento($_SESSION['id']);
					?>
					<h1><?php echo $evento['titulo']; ?></h1>
				</div>
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Arquivo</th>
                  <th>Envio</th>
                  <th>Por</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
				<?php 
				$id = $_SESSION['id'];
				$entidade = $_SESSION['entidade'];

				global $wpdb;
				$sql_list =  "SELECT * FROM sc_arquivo WHERE id = '$id' AND entidade = '$entidade' AND publicado = '1' ORDER BY id DESC";
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				for($i = 0; $i < count($res); $i++){
					$evento = evento($res[$i]['id']);
					
					
					?>
					<tr>
					  <td><?php echo $res[$i]['id']; ?></td>
					  <td><a href="upload/<?php echo $res[$i]['arquivo']; ?>" target=_blank > <?php echo $res[$i]['arquivo']; ?></a></td>
					  <td><?php echo exibirDataHoraBr($res[$i]['datatime']); ?></td>
					  <td><?php $u = get_userdata($res[$i]['usuario']); echo $u->display_name; ?></td>
					  <td>	
							<form method="POST" action="?" class="form-horizontal" role="form">
							<input type="hidden" name="apagar" value="<?php echo $res[$i]['idArquivo']; ?>" />
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
 case "inserir":


 ?>
 <section id="enviar" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
				<div class="section-heading">
					<h2>Envio de Arquivos</h2>
					<p>Nesta página, você envia os arquivos como o rider, mapas de cenas e luz, logos de parceiros, programação de filmes de mostras de cinema, etc. O tamanho máximo do arquivo deve ser 60MB.</p>
					<p> Em caso de envio de fotografia, considerar as seguintes especificações técnicas:<br />
					- formato: horizontal <br />
					- tamanho: mínimo de 300dpi”</p>
<?php
	if( isset( $_POST['enviar'] ) )
	{
		$pathToSave = 'upload/';
		// A variavel $_FILES é uma variável do PHP, e é ela a responsável
		// por tratar arquivos que sejam enviados em um formulário
		// Nesse caso agora, a nossa variável $_FILES é um array com 3 dimensoes
		// e teremos de trata-lo, para realizar o upload dos arquivos
		// Quando é definido o nome de um campo no form html, terminado por []
		// ele é tratado como se fosse um array, e por isso podemos ter varios
		// campos com o mesmo nome
		$i = 0;
		$msg = array( );
		$arquivos = array( array( ) );
		foreach(  $_FILES as $key=>$info )
		{
			foreach( $info as $key=>$dados )
			{
				for( $i = 0; $i < sizeof( $dados ); $i++ )
				{
					$arquivos[$i][$key] = $info[$key][$i];
				}
			}
		}
		$i = 1;
		foreach( $arquivos as $file )
		{
			// Verificar se o campo do arquivo foi preenchido
			if( $file['name'] != '' )
			{
				$pre = date('Ymdhis')."_";
				$data =  date('Y-m-d H:i:s');
				$arquivoTmp = $file['tmp_name'];
				$arquivo = $pathToSave.$pre.semAcento($file['name']);
				$arquivo_base = $pre.semAcento($file['name']);
				if(file_exists($arquivo))
				{
					echo "O arquivo ".$arquivo_base." já existe! Renomeie e tente novamente<br />";
				}
				else
				{
					global $wpdb;
					$entidade = $_SESSION['entidade'];
					$id = $_SESSION['id'];
					$tipo = '';
					$usuario = $user->ID;
					$sql = "INSERT INTO `sc_arquivo` (`idArquivo`, `id`, `entidade`, `tipo`, `arquivo`, `datatime`, `usuario`, `publicado`) 
					VALUES (NULL, $id, '$entidade', '$tipo', '$arquivo_base', '$data', '$usuario', '1')";
					$wpdb->query($sql);
					if( !move_uploaded_file( $arquivoTmp, $arquivo ) )
					{
						$msg[$i] = 'Erro no upload do arquivo '.$i;
					}
					else
					{
						$msg[$i] = sprintf('Upload do arquivo %s foi um sucesso!',$i);
					}
				}
			}
			$i++;
		}
		// Imprimimos as mensagens geradas pelo sistema
		foreach( $msg as $e )
		{
			echo " <div id = 'mensagem_upload'>";
			printf('%s<br>', $e);
			echo " </div>";
		}
	}
?>
					<br />
					<div class = "center">
						<form method='POST' enctype='multipart/form-data'>
							<p><input type='file' name='arquivo[]'></p>
							<p><input type='file' name='arquivo[]'></p>
							<p><input type='file' name='arquivo[]'></p>
							<p><input type='file' name='arquivo[]'></p>
							<p><input type='file' name='arquivo[]'></p>
							<p><input type='file' name='arquivo[]'></p>
							<p><input type='file' name='arquivo[]'></p>
							<p><input type='file' name='arquivo[]'></p>
							<p><input type='file' name='arquivo[]'></p>

							<br>
							<input type='submit' value='Enviar' name='enviar'>
						</form>
					</div>
				</div>
			</div>
		</div>	  
	</div>
</section>


<?php 
break;
case "editar":

	global $wpdb;	
	session_start();
	
	if(isset($_SESSION['idEvento'])){
		$id = $_SESSION['idEvento'];
		$sql_select = "SELECT * FROM sc_atividade WHERE id = '$id'";
		$evento = $wpdb->get_row($sql_select,ARRAY_A);
	}

	if(isset($_POST['atualizar']) OR isset($_POST['inserir'])){
		$nomeEvento = addslashes($_POST["nomeEvento"]);
		$programa    = $_POST["programa"];
		$projeto = $_POST["projeto"];
		$nomeResponsavel    = $_POST["nomeResponsavel"];
		$suplente    = $_POST["suplente"];
		$ano    = $_POST["ano"];
		$descricao    = addslashes($_POST["descricao"]);
		$data_inicio = exibirDataMysql($_POST["data_inicio"]);
		if($_POST["data_final"] != ''){
			$data_final   = exibirDataMysql($_POST["data_final"]);
		}else{
			$data_final = '0000-00-00';
		}
	}
	
	if(isset($_POST['carregar'])){
		$id = $_POST['carregar'];
		$sql_select = "SELECT * FROM sc_atividade WHERE id = '$id'";
		$evento = $wpdb->get_row($sql_select,ARRAY_A);	
		$_SESSION['idEvento'] = $id;
	}
	
	$idUser = $user->ID;
	

	// Inserir evento
	if(isset($_POST['inserir'])){
		$sql = "INSERT INTO `sc_atividade` (`titulo`, `idRes`, `idSuplente`, `idProjeto`, `idPrograma`, `periodo_inicio`, `periodo_fim`, `ano_base`, `descricao`, `id_usuario`, `publicado`) 
		VALUES ('$nomeEvento', '$nomeResponsavel', '$suplente', '$projeto', '$programa', '$data_inicio', '$data_final', '$ano', '$descricao', '$idUser', '1')";
		$ins = $wpdb->query($sql);
		if($ins){
			$mensagem = "Inserido com sucesso";
			$id = $wpdb->insert_id;
			$sql_select = "SELECT * FROM sc_atividade WHERE id = '$id'";
			$evento = $wpdb->get_row($sql_select,ARRAY_A);
			$_SESSION['idEvento'] = $evento['id'];
			
		}else{
			$mensage = "Erro ao inserir".var_dump($ins);
			
		}
		
	}

	if(isset($_POST['atualizar'])){
	$atualizar    = $_POST["atualizar"];	
		$sql_atualizar = "UPDATE sc_atividade SET
		`idPrograma` = '$programa' ,
		`idProjeto` =  '$projeto',
		`titulo` = '$nomeEvento',
		`idRes` = '$nomeResponsavel',
		`idSuplente` = '$suplente',
		`ano_base` = '$ano',
		`descricao` = '$descricao'
		WHERE `id` = '$atualizar';
		";
		$atual = $wpdb->query($sql_atualizar);
		$sql_select = "SELECT * FROM sc_atividade WHERE id = '$atualizar'";
		$evento = $wpdb->get_row($sql_select,ARRAY_A);
		$_SESSION['idEvento'] = $evento['id'];
		
		if($atual == 1){
			$mensagem = "Evento atualizado com sucesso.";
		}else{
			$mensagem = $sql_atualizar;
		}

	}
	

	
	
?>
   <link href="css/jquery-ui.css" rel="stylesheet">
 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 

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
    $( ".calendario" ).datepicker();
	$( ".hora" ).mask("99:99");
	$( ".min" ).mask("999");
	$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
		
	});

</script>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Atividades - Informações Gerais</h3>
                    <h1></h1>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
            </div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Nome da Atividade *</label>
							<input type="text" name="nomeEvento" class="form-control" id="inputSubject" value="<?php echo $evento['titulo']; ?>"/>
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
						<br />
						<p>O responsável e suplente devem estar cadastrados como usuários do sistema.</p>
						<div class="col-md-offset-2">
							<label>Primeiro responsável (Fiscal)</label>
							<select class="form-control" name="nomeResponsavel" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario($evento['idRes']);	?>							
							</select>	                
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Segundo responsável (Suplente)</label>
							<select class="form-control" name="suplente" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario($evento['idSuplente']);	?>							

								</select>	
						</div>
					</div>
            <div class="form-group">
				<div class="col-md-offset-2">
					<label>Data de Início:</label>
                    <input type='text' class="form-control calendario" name="data_inicio" value="<?php echo exibirDataBr($evento['periodo_inicio']); ?>"/>
				</div>
			</div>
            <div class="form-group">
				<div class="col-md-offset-2">
					<label>Data de Encerramento:</label>
                    <input type='text' class="form-control calendario" name="data_final" value="<?php echo exibirDataBr($evento['periodo_fim']); ?>"/>
                </div>
            </div>
					<div class="form-group">
						<div class="col-md-offset-2">
						<div class="col-md-offset-2">
							<label>Ano Base *</label>
							<input type="text" name="ano" class="form-control" id="inputSubject" value="<?php echo $evento['ano_base']; ?>"/>
						</div> 
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descrição*</label>
							<textarea name="descricao" class="form-control" rows="10" placeholder="Artista, banda, coletivo, companhia, palestrantes, etc autor da obra/espetáculo."><?php echo $evento['descricao']; ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="atualizar" value="<?php echo $evento['id']; ?>" />
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