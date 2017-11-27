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
  
  <?php include "menu/me_contratacao.php"; ?>
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
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
 <?php 
 switch($p){
case "inicio": //Lista as contratações
?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Contratações</h1>
				</div>
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Nome/Razão Social</th>
                  <th>Tipo de Pessoa</th>
                  <th>Valor</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
				<?php 
				global $wpdb;
				if($_SESSION['entidade'] == 'evento'){
					$entidade = " idEvento = '".$_SESSION['id']."' ";	
				}else if($_SESSION['entidade'] == 'atividade'){
					$entidade = " idAtividade = '".$_SESSION['id']."' ";	
				}
				$sql_list =  "SELECT idPedidoContratacao FROM sc_contratacao WHERE $entidade ORDER BY idEvento DESC";
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				for($i = 0; $i < count($res); $i++){
					
					?>
					<tr>
					  <td><?php echo $res[$i]['idPedidoContratacao']; ?></td>
					  <td><?php //echo $evento['titulo']; ?></td>
					  <td><?php //echo $evento['programa']; ?></td>
					  <td><?php //echo $evento['projeto']; ?></td>
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
 case "inserir": //inserir contratação
 ?>


	<?php 
	switch ($_GET['t']){ // tipo de contratacao
	case 'apf':
	?>	
 
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Contratação - Artístico Pessoa Física</h3>
                    <h1></h1>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
            </div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
				</form>
			</div>
		</div>
	</div>
</section>
	<?php 
	break;
	case 'apj':
	?>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Contratação - Artístico Pessoa Jurídica</h3>
                    <h1></h1>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
            </div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
				</form>
			</div>
		</div>
	</div>
</section>
	<?php 
	break;
	case 'pf':
	?>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Contratação - Não-Artístico Pessoa Física</h3>
                    <h1></h1>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
            </div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
				</form>
			</div>
		</div>
	</div>
</section>
	<?php 
	break;
	case 'pj':
	?>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Contratação - Não Artístico Pessoa Jurídica</h3>
                    <h1></h1>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
            </div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
				</form>
			</div>
		</div>
	</div>
</section>
		<?php 
	break;
	case 'orc':
	?>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Orçamento - Previsão</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

	</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar&t=orc" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Dotação</label>
							<select class="form-control" name="dotacao" >
								<?php geraOpcaoDotacao() ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Tipo de Pessoa</label>
							<select class="form-control" name="tipo_pessoa" >
								<option value='1'>Pessoa Física</option>
								<option value='2'>Pessoa Jurídica</option>
							</select>
						</div>
					</div>
				<div class="form-group">
						<div class="col-md-offset-2">
							<label>Valor *</label>
							<input type="text" name="valor" class="form-control valor" id="inputSubject" value=""/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descrição *</label>
							<textarea name="descricao" class="form-control" rows="10""></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="atualizar" value="<?php echo $evento['idEvento']; ?>" />
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
	} // fim da switch insere contratacao
	?>
	
<?php 
break;
case "editar":

	global $wpdb;	
	
	
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

	<?php 
	switch ($_GET['t']){ // tipo de contratacao
	case 'apf':
	?>	

	<?php } ?>	
	
	<?php 
	switch ($_GET['t']){ // tipo de contratacao
	case 'apf':
	?>	
 
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Contratação - Artístico Pessoa Física</h3>
                    <h1></h1>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
            </div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
				</form>
			</div>
		</div>
	</div>
</section>
	<?php 
	break;
	case 'apj':
	?>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Contratação - Artístico Pessoa Jurídica</h3>
                    <h1></h1>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
            </div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
				</form>
			</div>
		</div>
	</div>
</section>
	<?php 
	break;
	case 'pf':
	?>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Contratação - Não-Artístico Pessoa Física</h3>
                    <h1></h1>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
            </div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
				</form>
			</div>
		</div>
	</div>
</section>
	<?php 
	break;
	case 'pj':
	?>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Contratação - Não Artístico Pessoa Jurídica</h3>
                    <h1></h1>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
            </div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar" class="form-horizontal" role="form">
				</form>
			</div>
		</div>
	</div>
</section>
		<?php 
	break;
	case 'orc':
	
	
	?>
	 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Orçamento - Previsão</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

	</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar&t=orc" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Dotação</label>
							<select class="form-control" name="dotacao" >
								<?php geraOpcaoDotacao() ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Tipo de Pessoa</label>
							<select class="form-control" name="tipo_pessoa" >
								<option value='1'>Pessoa Física</option>
								<option value='2'>Pessoa Jurídica</option>
							</select>
						</div>
					</div>
				<div class="form-group">
						<div class="col-md-offset-2">
							<label>Valor *</label>
							<input type="text" name="valor" class="form-control valor" id="inputSubject" value=""/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descrição *</label>
							<textarea name="descricao" class="form-control" rows="10""></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="atualizar" value="<?php echo $evento['idEvento']; ?>" />
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
</section>

	<?php
	break;
	} // fim da switch edita contratacao
	?>



<?php 
break;
case "meuseventos":
?>
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