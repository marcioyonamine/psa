<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
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
case "inicio": //Lista as contratações

if(isset($_SESSION['idPessoa'])){
	unset($_SESSION['idPessoa']);
	unset($_SESSION['tipo']);
}



if($_SESSION['entidade'] == 'evento'){
	$e = evento($_SESSION['id']);
	$n = $e['titulo'];
}else{
	$e = atividade($_SESSION['id']);
	$n = $e['titulo'];
}



if(isset($_POST['prod'])){

	foreach($_POST as $post=>$valor){
		if($post != 'prod'){
			insereAta($_SESSION['id'],substr($post,3),dinheiroDeBr($valor));
		}	
	}
}
 
 
?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Infraesturtura</h1>
					<h2><?php echo $n;?></h2>
					<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
				</div>
        </div>
		<?php 
		// se existe pedido, listar
		$total = 0;
		$sql = "SELECT * FROM sc_ata ORDER BY cod";
		$peds = $wpdb->get_results($sql,ARRAY_A);
		?>
		
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Cód</th>
                  <th>Infra</th>
                  <th>Descrição</th>
                  <th>Valor/Diária</th>
				  <th width='5%'>Qde</th>

				  </tr>
              </thead>
              <tbody>
			<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
				<?php 
				for($i = 0; $i < count($peds); $i++){
					?>
					<tr>
					  <td><?php echo $peds[$i]['cod']; ?></td>
					  <td><?php echo $peds[$i]['nome']; ?></td>
					  <td><?php echo $peds[$i]['descricao']; ?></td>
					  <td><?php echo dinheiroParaBr($peds[$i]['valor_diaria']); ?></td>
					<td><input type="text" name="id_<?php echo $peds[$i]['id']; ?>" value="<?php echo recAta($_SESSION['id'],$peds[$i]['id']); ?>" ></td>
					<?php $total = $total + ($peds[$i]['valor_diaria'] * recAta($_SESSION['id'],$peds[$i]['id']));?>
					  </tr>
				<?php } // fim do for?>	
				<tr>
				<td></td>
				<td>Total:</td>
				<td><?php echo dinheiroParaBr($total);?></td>
				<td></td>
				<td>
				<input type="hidden" name="prod">
				<input type="submit" class="btn btn-theme btn-sm btn-block" value="Salvar"></form></td></tr>
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