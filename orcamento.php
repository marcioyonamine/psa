<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'visaogeral';	
}
//session_start();
	$_SESSION['entidade'] = 'orcamento';
?>


  <body>
  
  <?php include "menu/me_orcamento.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
 <?php 
 switch($p){
case "inicio": 
case "listar": 
if(isset($_SESSION['id'])){
	unset($_SESSION['id']);
}
?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Dotações</h1>
				</div>
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
				<th>Ficha</th>
                  <th>Projeto</th>
                  <th>Dotação</th>
                  <th>Descricao</th>
                  <th>Valor</th>
                  <th>Ano Base</th>

				  </tr>
              </thead>
              <tbody>
				<?php 
				global $wpdb;
				$sql_list =  "SELECT * FROM sc_orcamento ORDER BY projeto DESC";
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				for($i = 0; $i < count($res); $i++){
					
					?>
					<tr>
					  <td><?php echo $res[$i]['ficha']; ?></td>
					  <td><?php echo $res[$i]['projeto']; ?></td>
					  <td><?php echo $res[$i]['dotacao']; ?></td>
					  <td><?php echo $res[$i]['descricao']; ?></td>
					  <td><?php echo dinheiroParaBr($res[$i]['valor']); ?></td>
					  <td><?php echo $res[$i]['ano_base']; ?></td>
					  <td>	
							<form method="POST" action="?p=editar" class="form-horizontal" role="form">
							<input type="hidden" name="carregar" value="<?php echo $res[$i]['id']; ?>" />
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

                    <h3>Dotação</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Unidade</label>
							<select class="form-control" name="unidade" id="projeto" >
							<?php geraTipoOpcao('unidade'); ?>
								</select>
						</div>
					</div>
				<div class="form-group">
						<div class="col-md-offset-2">
							<label>Projeto *</label>
							<input type="text" name="projeto" class="form-control" id="inputSubject" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Ficha *</label>
							<input type="text" name="ficha" class="form-control" id="inputSubject" />
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Dotação *</label>
							<input type="text" name="dotacao" class="form-control" id="inputSubject" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descricao *</label>
							<input type="text" name="descricao" class="form-control" id="inputSubject" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Natureza *</label>
							<input type="text" name="natureza" class="form-control" id="inputSubject" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Fonte</label>
							<select class="form-control" name="fonte" id="projeto" >
								<option value="1" >1</option>							
								<option value="2" >2</option>							
								<option value="3" >3</option>							
								<option value="4" >4</option>							
								<option value="5" >5</option>							
								<option value="6" >6</option>							

								</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Valor</label>
							<input type="text" name="valor" class="form-control" id="inputSubject" />
						</div>
					</div>
				<div class="form-group">
						<div class="col-md-offset-2">
							<label>Ano Base</label>
							<input type="text" name="ano" class="form-control" id="inputSubject" value="2018" />
						</div> 
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Observação</label>
							<textarea name="autor" class="form-control" rows="10" ></textarea>
						</div> 
					</div>
		
						<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="inserir" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir">
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

	if((isset($_POST['inserir'])) OR (isset($_POST['atualizar']))){
	 $projeto = $_POST["projeto"];
	  $ficha  = $_POST["ficha"];
	  $dotacao = $_POST["dotacao"];
	  $descricao  = $_POST["descricao"];
	  $natureza   = $_POST["natureza"];
	  $fonte   = $_POST["fonte"];
		$unidade = $_POST['unidade'];
	  $valor  = dinheiroDeBr($_POST["valor"]);
	  $ano_base  = $_POST["ano"];
	  $obs  = addslashes($_POST["autor"]);
	}
	$idUser = $user->ID;
	
	if(isset($_POST['inserir'])){
		$sql = "INSERT INTO `sc_orcamento` (`projeto`, `ficha`, `unidade`, `dotacao`, `descricao`, `natureza`, `fonte`,  `valor`, `obs`, `publicado`, `idUsuario`, `ano_base`) 
		VALUES ('$projeto','$ficha', '$unidade', '$dotacao', '$descricao', '$natureza', '$fonte', '$valor', '$obs', '1', '$idUser', '$ano_base')";	
		$r = $wpdb->query($sql);
		$orcamento =  recuperaDados('sc_orcamento',$wpdb->insert_id,'id');	
		
	}

	if(isset($_POST['atualizar'])){
		$idOrc = $_POST['atualizar'];
		$sql = "UPDATE sc_orcamento SET
		`projeto` = '$projeto', 
		`ficha` = '$ficha', 
		`dotacao` = '$dotacao', 
		`descricao` = '$descricao', 
		`natureza` = '$natureza', 
		`fonte` = '$fonte',  
		`valor`= '$valor', 
		`obs` = '$obs', 
		`unidade` = '$unidade', 
		`idUsuario` =  '$idUser', 
		`ano_base` = '$ano_base'
		WHERE id = '$idOrc'
		"; 	
		//echo $sql;
		$r = $wpdb->query($sql);
		$orcamento =  recuperaDados('sc_orcamento',$idOrc,'id');	
	}
 
	if(isset($_POST['carregar'])){
		$orcamento =  recuperaDados('sc_orcamento',$_POST['carregar'],'id');	
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

                    <h3>Dotação</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
					<!-- Verificar com a área
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Visualizar?</label>
							<select class="form-control" name="visualizar" id="projeto" >
							<option value='0'></option>
							<option value='1'></option>
							
							</select>
						</div>
					</div>-->

				<div class="form-group">
						<div class="col-md-offset-2">
							<label>Unidade</label>
							<select class="form-control" name="unidade" id="projeto" >
							<?php geraTipoOpcao('unidade',$orcamento['unidade']); ?>
								</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Projeto *</label>
							<input type="text" name="projeto" class="form-control" id="inputSubject" value="<?php echo $orcamento['projeto']; ?>"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Ficha *</label>
							<input type="text" name="ficha" class="form-control" id="inputSubject" value="<?php echo $orcamento['ficha']; ?>"/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Dotação *</label>
							<input type="text" name="dotacao" class="form-control" id="inputSubject" value="<?php echo $orcamento['dotacao']; ?>"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Natureza *</label>
							<input type="text" name="natureza" class="form-control" id="inputSubject" value="<?php echo $orcamento['natureza']; ?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descricao *</label>
							<input type="text" name="descricao" class="form-control" id="inputSubject" value="<?php echo $orcamento['descricao']; ?>"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Fonte</label>
							<select class="form-control" name="fonte" id="projeto" >
								<option value="1" <?php checado($orcamento['fonte'],array(1)); ?>>1</option>							
								<option value="2" <?php checado($orcamento['fonte'],array(2)); ?>>2</option>							
								<option value="3" <?php checado($orcamento['fonte'],array(3)); ?>>3</option>							
								<option value="4" <?php checado($orcamento['fonte'],array(4)); ?>>4</option>							
								<option value="5" <?php checado($orcamento['fonte'],array(5)); ?>>5</option>							
								<option value="6" <?php checado($orcamento['fonte'],array(6)); ?>>6</option>							

								</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Valor</label>
							<input type="text" name="valor" class="form-control" id="inputSubject" value="<?php echo dinheiroParaBr($orcamento['valor']); ?>"/>
						</div>
					</div>
				<div class="form-group">
						<div class="col-md-offset-2">
							<label>Ano Base</label>
							<input type="text" name="ano" class="form-control" id="inputSubject" value="<?php echo $orcamento['ano_base']; ?>"/>
						</div> 
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Observação</label>
							<textarea name="autor" class="form-control" rows="10" ><?php echo $orcamento['obs']; ?></textarea>
						</div> 
					</div>
		
						<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="atualizar" value="<?php echo $orcamento['id']; ?>" />
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
case "mov_inserir":
?>
  <link href="css/jquery-ui.css" rel="stylesheet">
 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 
 <script>
$(function() {
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

                    <h3>Movimentação Orçamentária</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=mov_editar" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Titulo *</label>
							<input type="text" name="titulo" class="form-control" id="inputSubject" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Tipo de movimentação</label>
							<select class="form-control" name="tipo" id="inputSubject" >
							<option>Escolha uma opção</option>
							<?php echo geraTipoOpcao("mov_orc") ?>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Dotação</label>
							<select class="form-control" name="dotacao" id="inputSubject" >
							<option>Escolha uma opção</option>
							<?php echo geraOpcaoDotacao('2018'); ?>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Valor *</label>
							<input type="text" name="valor" class="form-control valor" id="inputSubject" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Data *</label>
							<input type="text" name="data" class="form-control calendario"  />
						</div>
					</div>					
					
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descição / Observação*</label>
							<textarea name="descricao" class="form-control" rows="10" ></textarea>
						</div> 
					</div>	
						<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="mov_inserir" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir Movimentação">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php 
break;
case "mov_editar":

if(isset($_POST['mov_inserir']) OR isset($_POST['mov_editar']) ){
  $titulo = addslashes($_POST["titulo"]);
  $tipo = $_POST["tipo"];
  $dotacao = $_POST["dotacao"];
  $valor = dinheiroDeBr($_POST["valor"]);
	if($_POST["data"] = '' OR $_POST["data"] = '0000-00-00'){
		$data = date('Y-m-d');
	}else{
		$data = exibirDataMysql($_POST["data"]);	
	}
  $descricao = addslashes($_POST["descricao"]);
}

if(isset($_POST['mov_inserir'])){
	global $wpdb;
	$idUsuario = $user->ID;
	$sql = "INSERT INTO `sc_mov_orc` (`titulo`, `tipo`, `idOrc`, `data`, `valor`, `descricao`, `idUsuario`, `publicado`) 
		VALUES ('$titulo', '$tipo', '$dotacao', '$data', '$valor', '$descricao', '$idUsuario', '1')";
	$ins = $wpdb->query($sql);
	$id_orc = $wpdb->insert_id;
	$mov = $wpdb->get_row("SELECT * FROM sc_mov_orc WHERE id =  '$id_orc'",ARRAY_A);
	
}



?>
    <link href="css/jquery-ui.css" rel="stylesheet">
 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 
 <script>
$(function() {
    $( ".calendario" ).datepicker();
	$( ".hora" ).mask("99:99");
	$( ".min" ).mask("999");
	$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
});



</script>



</script>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Movimentação Orçamentária</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=mov_editar" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Titulo *</label>
							<input type="text" name="titulo" class="form-control" id="inputSubject" value="<?php echo $mov['titulo'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Tipo de movimentação</label>
							<select class="form-control" name="tipo" id="inputSubject" >
							<option value='0'>Escolha uma opção</option>
							<?php echo geraTipoOpcao("mov_orc",$mov['tipo']) ?>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Dotação</label>
							<select class="form-control" name="dotacao" id="inputSubject" >
							<option value='0'>Escolha uma opção</option>
							<?php echo geraOpcaoDotacao('2017',$mov['dotacao']); ?>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Valor *</label>
							<input type="text" name="valor" class="form-control valor" id="inputSubject"  value="<?php echo dinheiroParaBr($mov['valor']) ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Data *</label>
							<input type="text" name="data" class="form-control calendario"   value="<?php echo exibirDataBr($mov['data']) ?>"/>
						</div>
					</div>					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descição / Observação*</label>
							<textarea name="descricao" class="form-control" rows="10" ><?php echo $mov['descricao'] ?></textarea>
						</div> 
					</div>	
						<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="mov_editar" value="<?php echo $mov['id'] ?>" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir Movimentação">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php 
break;
case "mov_listar":
if(isset($_POST['deletar'])){
	$mensagem = "Teste 123";
	global $wpdb;
	$id = $_POST['deletar'];
	$sql_del = "UPDATE sc_mov_orc SET publicado = '0' WHERE id = '$id'";
	$upd = $wpdb->query($sql_del);
	if($upd == 1){
		$mensagem = "<div class='alert alert-success'>
  <strong>Movimentação deletada com sucesso.</strong>
</div>"	;
	}else{
		$mensagem = "<div class='alert alert-warning'>
  <strong>Erro.Tente novamente.</strong>
</div>"	;
		
	}
	
}

?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Movimentações Orçamentárias</h1>
					<?php if(isset($mensagem)){echo $mensagem;}?>
				</div>
				
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
				<th>#</th>
                  <th>Data</th>
                  <th>Título</th>
                  <th>Dotação</th>
                  <th>Tipo</th>
                  <th>Valor</th>
				  <th></th>
				  <th></th>
				  </tr>
              </thead>
              <tbody>

				<?php 
				global $wpdb;
				$sql_list =  "SELECT * FROM sc_mov_orc WHERE publicado = '1' ORDER BY data DESC";
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				for($i = 0; $i < count($res); $i++){
					$dot = recuperaDados("sc_orcamento",$res[$i]['idOrc'],"id");
					$tipo = tipo($res[$i]['tipo']);
					?>
					<tr>
					 <td><?php echo $res[$i]['id']; ?></td>

					  <td><?php echo exibirDataBr($res[$i]['data']); ?></td>
					  <td><?php echo $res[$i]['titulo']; ?></td>
					  <td><?php echo $dot['dotacao'] ?></td>
					  <td><?php echo $tipo['tipo']; ?></td>
					  <td><?php echo dinheiroParaBr($res[$i]['valor']); ?></td>
					  <td>	
							<form method="POST" action="?p=editar" class="form-horizontal" role="form">
							<input type="hidden" name="carregar" value="<?php echo $res[$i]['id']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
							</form>
							<?php 
					  
					  ?></td>
					  <td>
							<form method="POST" action="?p=mov_listar" class="form-horizontal" role="form">
							<input type="hidden" name="deletar" value="<?php echo $res[$i]['id']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Deletar">
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
case "visaogeral": 

if(isset($_GET['unidade']) AND $_GET['unidade'] != 0 ){
	$unidade = " AND unidade ='".$_GET['unidade']."' ";	
}else{
	$unidade = "";
}

if(isset($_GET['fonte']) AND $_GET['fonte'] != 0 ){
	$fonte = " AND fonte ='".$_GET['fonte']."' ";
	$fonte_option = $_GET['fonte']; 	
}else{
	$fonte = "";
	$fonte_option = 0; 	

	}


if(isset($_GET['ano'])){
	$ano = " AND ano_base = '".$_GET['ano']."' ";	
}else{
	$ano = " AND ano_base = '2018' ";	
}

if(isset($_GET['projeto']) AND $_GET['projeto'] != 0 ){
	$projeto = " AND projeto = '".$_GET['projeto']."' ";	
}else{
	$projeto = "";	
}

if(isset($_GET['ficha']) AND $_GET['ficha'] != 0){
	$ficha = " AND ficha = '".$_GET['ficha']."' ";	
}else{
	$ficha = "";	
}

//filtros projeto e ficha
?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Dotações</h1>
				</div>
        </div>
		<h3>Filtro</h3>
		<div class="col-md-offset-1 col-md-10">
			<form method="GET" action="orcamento.php?p=visaogeral&ano=2018" class="form-horizontal" role="form">
				<div class="form-group">
					<div class="col-md-offset-2">
							<label>Unidade *</label>
							<select class="form-control" name="unidade" id="inputSubject" >
							<option value='0'>Escolha uma opção</option>
							<?php echo geraTipoOpcao('unidade',$_GET['unidade']); ?>
							<option value='0'>Todas as unidades</option>
							</select>
					</div>
					</div>		
				<div class="form-group">
					<div class="col-md-offset-2">
							<label>Fonte *</label>
							<select class="form-control" name="fonte" id="inputSubject" >
							<option value= '0'>Escolha uma opção</option>
							<option <?php echo select(1,$fonte_option) ?> >1</option>
							<option <?php echo select(2,$fonte_option) ?> >2</option>
							<option <?php echo select(3,$fonte_option) ?> >3</option>
							<option <?php echo select(4,$fonte_option) ?> >4</option>
							<option <?php echo select(5,$fonte_option) ?> >5</option>
							<option <?php echo select(6,$fonte_option) ?> >6</option>
							<option value= '0'>Todas as opções</option>

							</select>
					</div>
					</div>		

					<div class="form-group">
					<div class="col-md-offset-2">
						<input type="submit" class="btn btn-theme btn-sm btn-block" value="Aplicar">
							</form>
							</select>
					</div>
			</div>		
		
		</form>			
		</div>		
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
					  
				<th width='10%'>Proj/Fic</th>
				<th width='10%'>Nat/Fon</th>
                  <th>Val Ini</th>
                  <th>Val Con</th>
                  <th>Val Des</th>
                  <th>Val Sup</th>
                  <th>Val Lib</th>
				  <th>Val Pla</th>	
                  <th>Saldo Lib</th> <!-- O saldo Planejado é o Saldo Liberado - Valor Planejado -->
                  <th>Saldo Pla</th>

				  </tr>
              </thead>
              <tbody>
			  <form method="POST" action="?" />
				<?php 
				global $wpdb;
				$sql_list =  "SELECT id FROM sc_orcamento WHERE publicado = '1' $ano $unidade $fonte $projeto $ficha ORDER BY id ASC";
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				$total_orc = 0;
				$total_con = 0;
				$total_des = 0;
				$total_sup = 0;
				$total_res = 0;
				$total_tot = 0;
				$total_pla = 0;
				$total_lib = 0;
				
				for($i = 0; $i < count($res); $i++){
					$orc = orcamento($res[$i]['id']);
					$total = $orc['total'] - $orc['contigenciado'] + $orc['descontigenciado'] + $orc['suplementado'] - $orc['liberado'];
					
					if($i % 10 == 0 AND $i != 0){
					?>
					               <tr>
					  
				<th width='10%'>Proj/Fic</th>
				<th width='10%'>Nat/Fon</th>
				<th>Val Ini</th>
                  <th>Val Con</th>
                  <th>Val Des</th>
                  <th>Val Sup</th>
                  <th>Val Lib</th>
				  <th>Val Pla</th>	
                  <th>Saldo Lib</th> <!-- O saldo Planejado é o Saldo Liberado - Valor Planejado -->
                  <th>Saldo Pla</th>
                  <th></th>

				  </tr>
						<tr>

					  <td title="<?php echo $orc['descricao']; ?>"><a href="?p=historico&id=<?php echo $res[$i]['id']?>" target='_blank' ><?php echo $orc['visualizacao']; ?></a></td>
					  <td><?php echo $orc['natureza']; ?></td>
					  <td><?php echo dinheiroParaBr($orc['total']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['contigenciado']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['descontigenciado']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['suplementado']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['liberado']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['planejado']) ?><?php //var_dump($orc); ?></td>
					  <td><?php echo dinheiroParaBr($total); ?></td>
					  <td><?php echo dinheiroParaBr($total - $orc['planejado']); ?></td>				
					
					
					<?php
					}else{
					
					?>
                    
					<tr>

					  <td title="<?php echo $orc['descricao']; ?>"><a href="?p=historico&id=<?php echo $res[$i]['id']?>" target='_blank' ><?php echo $orc['visualizacao']; ?></a></td>
					  <td><?php echo $orc['natureza']; ?></td>
					  <td><?php echo dinheiroParaBr($orc['total']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['contigenciado']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['descontigenciado']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['suplementado']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['liberado']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['planejado']) ?><?php //var_dump($orc); ?></td>
					  <td><?php echo dinheiroParaBr($total); ?></td>
					  <td><?php echo dinheiroParaBr($total - $orc['planejado']); ?></td>
	<!--<td>	
							<form method="POST" action="?p=editar" class="form-horizontal" role="form">
							<input type="hidden" name="carregar" value="<?php echo $res[$i]['id']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
							</form>
							<?php 
					  
					  ?></td>-->
					</tr>
                    
                    
				<?php 
					}
				$total_orc = $total_orc + $orc['total'];
				$total_con = $total_con + $orc['contigenciado'];
				$total_des = $total_des + $orc['descontigenciado'];
				$total_sup = $total_sup + $orc['suplementado'];
				$total_lib = $total_lib + $orc['liberado'];
				$total_pla = $total_pla + $orc['planejado'];
				
				//$total_res = $total_res;
				$total_tot = $total_tot + $total;					
					
					
					
					
				} // fim do for?>	
				<tr>
					  <td>TOTAL:</td>
					  <td></td>
					  <td><?php echo dinheiroParaBr($total_orc); ?></td>
					  <td><?php echo dinheiroParaBr($total_con); ?></td>
					  <td><?php echo dinheiroParaBr($total_des); ?></td>
					  <td><?php echo dinheiroParaBr($total_sup); ?></td>
					  <td><?php echo dinheiroParaBr($total_lib); ?></td>
					  <td><?php echo dinheiroParaBr($total_pla); ?></td>
					  <td><?php echo dinheiroParaBr($total_tot); ?></td>
					  <td><?php echo dinheiroParaBr($total_tot - $total_pla); ?></td>
						<td></td>
				
				</tr>
				</tbody>
            </table>
          </div>

		</div>
</section>

<?php 
break;
case 'historico':
$id_hist = $_GET['id'];
$historico = orcamento($id_hist);
?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Movimentação Orçamentária - Histórico</h1>
					<h3><?php echo $historico['visualizacao']." / ".$historico['descricao'];?> </h3>
				</div>
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
				<th>#</th>
					  <th>Data</th>
				<th>Tipo</th>
				<th>Título</th>
                  <th>Descrição</th>
                  <th>Valor</th>
				  </tr>
              </thead>
              <tbody>
			  <tr>
			  <td></td>
			  <td>Inicial</td>
			  <td>Orçamento aprovado</td>
			  <td></td>
			  <td><?php echo dinheiroParaBr($historico['total']);?></td>

			  </tr>
			  
				<?php 
						
				for($i = 0; $i < count($historico['historico']); $i++){
					$tipo = tipo($historico['historico'][$i]['tipo']);
					if($historico['historico'][$i]['tipo'] == 286){
						$valor = "(".dinheiroParaBr($historico['historico'][$i]['valor']).")";
					}else{
						$valor = dinheiroParaBr($historico['historico'][$i]['valor']);
					}
					?>
					<tr>
						<td><?php echo $historico['historico'][$i]['id']; ?></td>
					  <td><?php echo exibirDataBr($historico['historico'][$i]['data']); ?></td>
					  <td><?php echo  $tipo['tipo']; ?></td>
					  <td><?php echo $historico['historico'][$i]['titulo']; ?></td>
					  <td><?php echo $historico['historico'][$i]['descricao']; ?></td>
					  <td><?php echo $valor; ?></td>

					  </tr>
				<?php 
					
					
				} // fim do for?>	
				<tr>
						<td><td>
					  <td></td>
								  <td>Total em <?php echo date('d/m/Y') ?></td>
					  <td><?php echo dinheiroParaBr($historico['total'] - $historico['contigenciado'] + $historico['descontigenciado'] + $historico['suplementado']); ?></td>
	
				</tr>
				
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