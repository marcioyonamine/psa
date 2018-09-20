<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
?>


  <body>
  
  <?php include "menu/me_comunicacao.php"; ?>
      <link href="css/jquery-ui.css" rel="stylesheet">
 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 
 <script>
$(function() {
    $( ".calendario" ).datepicker();
	$(".cpf").mask("999.999.999-99");
	$(".cnpj").mask("99.999.999/9999-99");
	$( ".hora" ).mask("99:99");
	$( ".min" ).mask("999");
	$( ".cep" ).mask("99999-999");
	$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});

});



</script>
<?php include "inc/js_cep.php";?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
 <?php 
 switch($p){
case "inicio":
?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Comunicação</h1>
					<h2></h2>
					<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
				</div>
        </div>
		<?php 
	
		?>
</div>
</section>		
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
        </div>
          <div class="table-responsive">
		  
			<h3>Infraestrutura ATA</h3>	
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
				  <th></th>

				  </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
			<br />
			<h3>Infraestrutura</h3>	
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
				  <th></th>

				  </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
			<br />
			<h3>Comunicação</h3>	
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
				  <th></th>

				  </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
			<br />
			<h3>Apoio Institucional</h3>	
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
				  <th></th>

				  </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
			<br />
			
			</div>

		</div>
</section>		

<?php 
break;	 
case "revisao": //Lista as contratações
$mensagem = "";
if(isset($_POST['gerar'])){
	if($_POST['inicio'] == ""){
		$mensagem .= alerta("É preciso inserir uma data inicial","warning");
	}

	if($_POST['fim'] == ""){
		$mensagem .= alerta("É preciso inserir uma data final","warning");
	}
	
	if($_POST['inicio'] != "" AND $_POST['fim'] != ""){
		$sql = "SELECT DISTINCT idEvento FROM sc_agenda WHERE data >= '".exibirDataMysql($_POST['inicio'])."' AND data <= '".exibirDataMysql($_POST['fim'])."'  ORDER BY data,hora ASC";
		$id_evento = $wpdb->get_results($sql,ARRAY_A);
		
		
		
	}
	
	
	
}

?>
	<script type="text/javascript">
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

                    <h3>Revisão de Sinopses</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=agenda" class="form-horizontal" role="form">

					<div class="row">
						<div class="col-6">
							<label>Data Inicial</label>
							<input type="text" class="form-control calendario" name="inicio"> 
						</div>
						<div class="col-6">
							<label>Data Final</label>
							<input type="text" class="form-control calendario" name="fim"> 
						</div>
					</div>	
					<br />
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="gerar" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Buscar eventos">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
		<?php 
		if(isset($id_evento)){
			for($i = 0; $i < count($id_evento); $i++){
				$evento = evento($id_evento[$i]['idEvento']);
				//echo "<pre>";
				//echo var_dump($evento);
				//echo "</pre>";
				
				
				echo "<li>".$evento['titulo']." - ".$evento['periodo']['legivel']." - ".$evento['local']."</li>";		
				
			}
			
		}
		?>
		
		</div>
	</div>
</section>		

<?php 
break;
case "agenda":

$mensagem = "";
if(isset($_POST['gerar'])){
	if($_POST['inicio'] == ""){
		$mensagem .= alerta("É preciso inserir uma data inicial","warning");
	}

	if($_POST['fim'] == ""){
		$mensagem .= alerta("É preciso inserir uma data final","warning");
	}
	
	
	
	
}

?>
	<script type="text/javascript">
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

                    <h3>Agenda do Prefeito</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=agenda" class="form-horizontal" role="form">

					<div class="row">
						<div class="col-6">
							<label>Data Inicial</label>
							<input type="text" class="form-control calendario" name="inicio"> 
						</div>
						<div class="col-6">
							<label>Data Final</label>
							<input type="text" class="form-control calendario" name="fim"> 
						</div>
					</div>	
					<br />
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="gerar" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Buscar eventos">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
		   <div class="col-md-offset-2 col-md-8">
		<?php 
	if($_POST['inicio'] != "" AND $_POST['fim'] != ""){

		$inicio = exibirDataMysql($_POST['inicio']);
		$fim = somarDatas(exibirDataMysql($_POST['fim']),"+1");
		while($inicio != $fim ){
			echo "<b>".exibirDataBr($inicio)."</b><br />";
			$sql = "SELECT * FROM sc_agenda WHERE data = '".$inicio."' ORDER BY hora ASC";
			$id_evento = $wpdb->get_results($sql,ARRAY_A);
			$titulo = "";
			for($i =0; $i < count($id_evento); $i++){
				$evento = evento($id_evento[$i]['idEvento']);
				$local = tipo($id_evento[$i]['idLocal']);
				echo $evento['titulo']." - ".substr($id_evento[$i]['hora'],0,-3)."<br />";
				echo $local['tipo']."<br /><br />";
				
			}
			$inicio = somarDatas($inicio,"+1");
			
		}
	}
		?>
		
		</div>
	</div>
	</div>
</section>	
<?php 
break;
case "infra":

	$mensagem = "";
	if(isset($_POST['inserir'])){
		// limpa os checks
		$sql_limpa_check = "UPDATE sc_producao_ext SET valor = '' WHERE valor = 'on' AND id_evento = '".$_SESSION['id']."'";
		$wpdb->query($sql_limpa_check);
		
		foreach($_POST as $x=>$y){
			if($y != ""){
				$x = insereProducao($x,$y,$_SESSION['id']);
			}
		}
	}

?>
<section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Infraestrutura</h3>
                    <h1></h1>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
            </div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=infra" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<!--<input type="checkbox" name="planejamento" id="subEvento" <?php //checar($campo['subEvento']) ?>/><label style="padding:0 10px 0 5px;"> Evento em planejamento?</label>-->
						</div>
					</div>
					<?php 
					$sql_campo = "SELECT * FROM sc_lista_producao WHERE tipo = 'infra'";
					$campo = $wpdb->get_results($sql_campo,ARRAY_A);
					for($i = 0; $i < count($campo); $i++){
						$json_campo = json_decode($campo[$i]['descricao'],true);
						
						geraCampo($json_campo['tipo'],$campo[$i]['id'],$campo[$i]['titulo'],recuperaProducao($campo[$i]['id'],$_SESSION['id']));
						

					}
					?>

					<div class="form-group">
						<div class="col-md-offset-2">
					<?php 
			
			
					?>		
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
case "apoio":

	$mensagem = "";
	if(isset($_POST['inserir'])){
		// limpa os checks
		$sql_limpa_check = "UPDATE sc_producao_ext SET valor = '' WHERE valor = 'on' AND id_evento = '".$_SESSION['id']."'";
		$wpdb->query($sql_limpa_check);
		
		foreach($_POST as $x=>$y){
			if($y != ""){
				$x = insereProducao($x,$y,$_SESSION['id']);
			}
		}
	}

?>
<section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Apoio Institucional</h3>
                    <h1></h1>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
            </div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=apoio" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<!--<input type="checkbox" name="planejamento" id="subEvento" <?php //checar($campo['subEvento']) ?>/><label style="padding:0 10px 0 5px;"> Evento em planejamento?</label>-->
						</div>
					</div>
					<?php 
					$sql_campo = "SELECT * FROM sc_lista_producao WHERE tipo = 'apoio'";
					$campo = $wpdb->get_results($sql_campo,ARRAY_A);
					for($i = 0; $i < count($campo); $i++){
						$json_campo = json_decode($campo[$i]['descricao'],true);
						
						geraCampo($json_campo['tipo'],$campo[$i]['id'],$campo[$i]['titulo'],recuperaProducao($campo[$i]['id'],$_SESSION['id']));
						

					}
					?>

					<div class="form-group">
						<div class="col-md-offset-2">
					<?php 
			
			
					?>		
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
} // fim da switch p

?>
  
        </main>
      </div>
    </div>
	
<?php 
include "footer.php";
?>