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
  
  <?php include "menu/me_evento.php"; ?>
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
$evento = evento($_SESSION['id']);

?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Enviar / Finalizar</h1>
					<h2><?php echo $evento['objeto'];?></h2>
				</div>
        </div>
		<?php 
		if(isset($_SESSION['entidade'])){
		//verifica se todos os campos obrigatórios foram atualizados
			switch($_SESSION['entidade']){
			case 'evento':
			
			$evento = evento($_SESSION['id']);
			?>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<h3>Dados do Evento</h3>
			<p>Programa: <?php echo $evento['programa']; ?></p>
			<p>Projeto: <?php echo $evento['projeto']; ?></p>
			<p>Linguagem principal: <?php echo $evento['linguagem']; ?></p>
			<p>Responsável: <?php echo $evento['responsavel']; ?></p>
			<p>Autor/Artista: <?php echo $evento['autor']; ?></p>
			<p>Ficha técnica: <?php echo $evento['grupo']; ?></p>
			<p>Classificação etária: <?php echo $evento['faixa_etaria']; ?></p>
			<p>Sinopse: <br /><?php echo $evento['sinopse']; ?></p>
			<p>Release: <br /><?php echo $evento['release']; ?></p>
			<p>Links: <?php //echo $evento['links']; ?></p>
			<p>Ocorrências:<br /> <?php
			$sql_lista_ocorrencia = "SELECT idOcorrencia FROM sc_ocorrencia WHERE idEvento = '".$_SESSION['id']."' AND publicado = '1'";
			$res = $wpdb->get_results($sql_lista_ocorrencia,ARRAY_A);
			if(count($res)){
				for($i = 0; $i < count($res); $i++){
					$ocorrencia = ocorrencia($res[$i]['idOcorrencia']);
					echo $ocorrencia['tipo']."<br />";
					echo $ocorrencia['data']."<br />";
					echo $ocorrencia['local']."<br /><br />";
					
					}
				
			}else{
				echo "Não há ocorrências cadastradas.";
				
			}


			//echo $evento['']; ?></p>
			<p>Arquivos:<br /> <?php $arquivo = listaArquivos("evento",$_SESSION['id']); 
		
			for($i = 0; $i < count($arquivo); $i++){
				echo "<a href='upload/".$arquivo[$i]['arquivo']."' target='_blank' >".$arquivo[$i]['arquivo']."</a><br />";	
				
			}
			
			
			
			?></p>
	
			</div>
		</div>  
		

		<?php /*
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<h3>Dados de Contratação</h3>
			<p>Programa: <?php echo $evento['']; ?></p>
			<p>Projeto: <?php echo $evento['']; ?></p>
			<p>Linguagem principal: <?php echo $evento['']; ?></p>
			<p>Tipo de evento: <?php echo $evento['']; ?></p>
			<p>Responsável: <?php echo $evento['']; ?></p>
			<p>Autor/Artista: <?php echo $evento['']; ?></p>
			<p>Ficha técnica: <?php echo $evento['']; ?></p>
			<p>Classificação etária: <?php echo $evento['']; ?></p>
			<p>Sinopse: <?php echo $evento['']; ?></p>
			<p>Release: <?php echo $evento['']; ?></p>
			<p>Links: <?php echo $evento['']; ?></p>
			<p>Ocorrências: <?php echo $evento['']; ?></p>
			<p>Arquivos: <?php echo $evento['']; ?></p>
	
			</div>
		</div>  		
		*/	?>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<h3>Pendências</h3>
			<?php $pendencia = verificaEvento($_SESSION['id']);
			if($pendencia['erros'] == 0){
				echo "<p>Não há pendencias.</p>";
				
			}
			
			
			echo "<p>".$pendencia['relatorio']."</p>";
			?>

			</div>
		</div>  		

		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<?php if($evento['planejamento'] == 1){ ?>
			<form action="?" method="POST" class="form-horizontal">
			<input type="submit" class="btn btn-theme btn-lg btn-block" name="agenda" value="Atualizar Agenda" />
			</form>

			<?php } ?>
			</div>
		</div>  
			
			
			
			
			
			
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<?php if($evento['planejamento'] == 1){ ?>
			<form action="?" method="POST" class="form-horizontal">
			<input type="submit" class="btn btn-theme btn-lg btn-block" name="agenda" value="Atualizar Agenda" />
			</form>

			<?php } ?>
			</div>
		</div>  
			
			
			
			<?php
			break;
			}
		?>

		<?php
		}
		?>
		
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