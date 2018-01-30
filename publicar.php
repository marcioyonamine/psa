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
  
  <?php include "menu/me_mapas.php"; ?>
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
case "inicio": 

/*
$evento = evento($_SESSION['id']);
$meta = metausuario($user->ID);
*/	 
if(isset($_POST['action'])){
	require "MapasSDK/vendor/autoload.php"; //carrega o sdk
	$url_mapas = $GLOBALS['url_mapas'];
	$chave01 = $meta['chave01'];
	$chave02 = $meta['chave02'];
	$chave03 = $GLOBALS['chave03'];

	$mapas = new MapasSDK\MapasSDK(
		$url_mapas,
		$chave01,
		$chave02,
		$chave03
	);

	if($_POST['action'] == 'publicar'){
	
	$new_event = $mapas->createEntity('event', [

    'name' => $evento['titulo'],
    'shortDescription' => substr($evento['sinopse'], 0, 400),
	'longDescription' => $evento['release'],
    'terms' => [
        'linguagem' => $evento['linguagem'];
        
    ],
    'classificacaoEtaria' => $evento['faixa_etaria'];
]);

$new_event = converterObjParaArray($new_event);

// Atualiza evento
$new_event['id'];
$sql_upd = "UPDATE sc_evento SET mapas = '".$new_event['id']."' WHERE idEvento = '".$_SESSION['id']."'";
$wpdb->query($sql_upd);

// acontecendo uma única vez no dia 28 de Setembro de 2017 às 12:00 com duração de 120min e preço Gratuíto
$oc = $evento['mapas']['ocorrencia'];


for($i = 0; $i < count($oc); $i++){

$oc_le = ocorrencia($evento['mapas']['ocorrencia']['idOcorrencia']);

if($oc[$i]['frequency'] == 'once'){	
$occurrence = $mapas->apiPost('eventOccurrence/create',[
    'eventId' => $new_event['id'],
    'spaceId' => $oc[$i]['spaceId'],
    'startsAt' => $oc[$i]['startsAt'],
    'duration' => $oc[$i]['duration'],
    // 'endsAt' => '14:00',
    'frequency' => $oc[$i]['frequency'],
    'startsOn' => $oc[$i]['startsOn'],
    'until' => '',
    'description' => $oc[$i]['description'],
    'price' => $oc[$i]['price']
]);
echo "<pre>";
var_dump($occurrence);
echo "</pre>";
}else{
// acontecendo Toda seg, qua e sex de 1 a 30 de setembro de 2017 às 10:00


	$occurrence = $mapas->apiPost('eventOccurrence/create',[
    'eventId' => $new_event['id'],
    'spaceId' => $oc[$i]['spaceId'],
    'startsAt' => $oc[$i]['startsAt'],
    'duration' => $oc[$i]['duration'],
    // 'endsAt' => '12:00',
    'frequency' => $oc[$i]['frequency'],
    'startsOn' => $oc[$i]['startsOn'],
    'until' => $oc[$i]['until'],
    'day' => $oc[$i]['day'],
    'description' => $oc[$i]['description'],
    'price' => $oc[$i]['price']
]);
echo "<pre>";
var_dump($occurrence);
echo "</pre>";

}

}
	} // publicar
	
$evento = evento($_SESSION['id']);
$meta = metausuario($user->ID);
}
?>






<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
				<h3>Publicar / Mapas Culturais</h3>
				<?php if($evento['mapas']['id'] != 0){?>
					<h1><a href="<?php echo $GLOBALS['url_mapas']."/evento/".$evento['mapas']['id'] ?>" target="_blank"> <?php echo $evento['objeto'];?></a></h1>
					<h2><?php if(isset($mensagem)){echo $mensagem;} ?></h2>
				<?php }else{?>	
					<h1><?php echo $evento['objeto'];?></h1>
					<h2><?php if(isset($mensagem)){echo $mensagem;} ?></h2>
				<?php } ?>
				</div>
        </div>
		<?php if(!isset($meta['chave01']) OR $meta['chave01'] == ""){?>
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
				<?php echo alerta("Não há chave cadastrada. É preciso cadastrar chaves para publicação na plataforma dos Mapas Culturais. Para cadastrar, clique <a href='usuario.php' >aqui</a>.","warning"); ?>
				</div>
        </div>
		<?php } ?>

		
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
				<p>Confira todas as informações.</p>
				<p>Ao enviar o evento, você disponibiliza as informações para todos os usuários do sistema:</p>
				<ul>
				<li>Se houver alguma contratação, a área financeira inicia a liberação da verba; </li>
				<li>A comunicação inicia seus trabalhos de divulgação; </li>
				<li>Os espaços e a produção iniciam seus planejamentos e pré-produção; </li>
				<li>Se não houver contratação, as informações já são disponibilizadas no CulturAZ. </li>

				</ul>
				<p>Se houver alguma pendência, o sistema não permitirá o envio.</p>
				</div>
        </div>
		<br /><br />
		
		
		
		<?php 
		if(isset($_SESSION['entidade'])){
		//verifica se todos os campos obrigatórios foram atualizados
			switch($_SESSION['entidade']){
			case 'mapas':
			
			$evento = evento($_SESSION['id']);
			?>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<h3>Dados do Evento</h3>
			<p>Linguagem principal: <?php echo $evento['linguagem']; ?></p>
			<p>Classificação etária: <?php echo $evento['faixa_etaria']; ?></p>
			<p>Sinopse: ( <?php echo strlen($evento['sinopse']); ?> caracteres . Acima de 400, o texto será cortado.)<br /><?php echo $evento['sinopse']; ?></p>
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
		<br /><br />
		<div class="row">
			<div class="col-md-offset-1 col-md-10">

				
			<form action="?" method="POST" class="form-horizontal">
			<?php if($evento['mapas']['id'] == 0){ ?>
			<input type="hidden" name="action" value="publicar">
			<input type="submit" class="btn btn-theme btn-lg btn-block" name="enviar" value="Publicar" />
			<?php }else{?>
			<input type="hidden" name="action" value="atualizar">
			<input type="submit" class="btn btn-theme btn-lg btn-block" name="enviar" value="Atualizar" />

			<?php  } ?>
			</form>	

			
			


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