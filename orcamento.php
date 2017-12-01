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
							<label>Descricao *</label>
							<input type="text" name="descricao" class="form-control" id="inputSubject" value="<?php echo $orcamento['descricao']; ?>"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Fonte</label>
							<select class="form-control" name="natureza" id="projeto" >
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
							<input type="text" name="valor" class="form-control" id="inputSubject" value="<?php echo $orcamento['ano_base']; ?>"/>
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
							<input type="hidden" name="atualizar" value="<?php echo $orcamento['idEvento']; ?>" />
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
case "editar":

	global $wpdb;	
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
							<label>Descricao *</label>
							<input type="text" name="descricao" class="form-control" id="inputSubject" value="<?php echo $orcamento['descricao']; ?>"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Fonte</label>
							<select class="form-control" name="natureza" id="projeto" >
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
							<input type="text" name="valor" class="form-control" id="inputSubject" value="<?php echo $orcamento['ano_base']; ?>"/>
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
							<input type="hidden" name="atualizar" value="<?php echo $orcamento['idEvento']; ?>" />
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
							<?php echo geraOpcaoDotacao('2017'); ?>
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
?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Movimentações Orçamentárias</h1>
				</div>
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Título</th>
                  <th>Dotação</th>
                  <th>Tipo</th>
                  <th>Valor</th>
				  </tr>
              </thead>
              <tbody>
				<?php 
				global $wpdb;
				$sql_list =  "SELECT * FROM sc_mov_orc ORDER BY data DESC";
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				for($i = 0; $i < count($res); $i++){
					$dot = recuperaDados("sc_orcamento",$res[$i]['idOrc'],"id");
					$tipo = tipo($res[$i]['tipo']);
					?>
					<tr>
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
if(isset($_GET['ano'])){
	$ano = " AND ano_base = '".$_GET['ano']."' ";	
}else{
	$ano = " AND ano_base = '".date('Y')."' ";	
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
					  <th>#</th>
				<th>Dotação</th>
                  <th>Val Ini</th>
                  <th>Val Con</th>
                  <th>Val Des</th>
                  <th>Val Sup</th>
                  <th>Val Res</th>
                  <th>Val Total</th>

				  </tr>
              </thead>
              <tbody>
				<?php 
				global $wpdb;
				$sql_list =  "SELECT id FROM sc_orcamento WHERE publicado = '1' $ano ORDER BY id ASC";
				//echo $sql_list;
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				$total_orc = 0;
				$total_con = 0;
				$total_des = 0;
				$total_sup = 0;
				$total_res = 0;
				$total_tot = 0;
				
				for($i = 0; $i < count($res); $i++){
					$orc = orcamento($res[$i]['id']);
					$total = $orc['total'] - $orc['contigenciado'] + $orc['descontigenciado'] + $orc['suplementado'];
					?>
					<tr>
					  <td><?php echo $res[$i]['id']; ?></td>
					  <td title="<?php echo $orc['descricao']; ?>"><?php echo $orc['dotacao']; ?></td>
					  <td><?php echo dinheiroParaBr($orc['total']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['contigenciado']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['descontigenciado']); ?></td>
					  <td><?php echo dinheiroParaBr($orc['suplementado']); ?></td>
					  <td><?php //echo $orc['total']; ?></td>
					  <td><?php echo dinheiroParaBr($total); ?></td>
					  <td>	
							<form method="POST" action="?p=editar" class="form-horizontal" role="form">
							<input type="hidden" name="carregar" value="<?php echo $res[$i]['id']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
							</form>
							<?php 
					  
					  ?></td>
					</tr>
				<?php 
				$total_orc = $total_orc + $orc['total'];
				$total_con = $total_con + $orc['contigenciado'];
				$total_des = $total_des + $orc['descontigenciado'];
				$total_sup = $total_sup + $orc['suplementado'];
				//$total_res = $total_res;
				$total_tot = $total_tot + $total;					
					
					
					
					
				} // fim do for?>	
				<tr>
						<td></<td>
					  <td>TOTAL:</td>
					  <td><?php echo dinheiroParaBr($total_orc); ?></td>
					  <td><?php echo dinheiroParaBr($total_con); ?></td>
					  <td><?php echo dinheiroParaBr($total_des); ?></td>
					  <td><?php echo dinheiroParaBr($total_sup); ?></td>
					  <td><?php //echo $orc['total']; ?></td>
					  <td><?php echo dinheiroParaBr($total_tot); ?></td>
					  <td>	
					  
					  </td>
				
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