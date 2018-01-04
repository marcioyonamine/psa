<?php include "header.php"; ?>
<?php 
if(isset($_POST['gravar'])){
	$inscricao = $_POST['carregar'];
	$sql_verifica = "SELECT id FROM ava_nota WHERE inscricao = '$inscricao' AND usuario = '".$user->ID."'";
	$res = $wpdb->get_results($sql_verifica,ARRAY_A);
	$usuario = $user->ID;
	if(count($res) > 0){ // existe, atualiza
	 	foreach($_POST as $key => $value){
			if(is_numeric($value) OR $value == ""){
				$sql_atualiza = "UPDATE ava_nota SET nota = '$value' WHERE usuario = '$usuario' AND criterio = '$key' AND inscricao = '$inscricao'";
				$ins = $wpdb->query($sql_atualiza);
				//echo $sql_atualiza;

			}
		}
	
	
		$mensagem = "Notas lançadas";
		
	}else{ // não existe, atualiza
	 	foreach($_POST as $key => $value){
			if((is_numeric($value) OR $value == "")){
			$sql_insere = "INSERT INTO `ava_nota` (`id`, `usuario`, `inscricao`, `nota`, `criterio`) VALUES (NULL, '$usuario', '$inscricao', '$value', '$key');";
				$ins = $wpdb->query($sql_insere);
				//echo $sql_insere;
			}
		}

		$mensagem = "Notas atualizadas";
	}
}
?>


  <body>
    <link href="css/jquery-ui.css" rel="stylesheet">
 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 
 <script>
$(function() {
	$( ".nota" ).mask("9.9");
});
  </script>
  <?php include "menu/menu_editais.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Dashboard</h1>

          <h2></h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Critério</th>
                  <th>Nota</th>
                </tr>
              </thead>
              <tbody>
			  <form method="POST" action="?" class="form-horizontal" role="form">
				<?php 
				
				$sql = "SELECT * FROM ava_criterios WHERE edital = '273'";
				$res = $wpdb->get_results($sql,ARRAY_A);
				for($i = 0; $i < count($res); $i++){
				?>	
                <tr>
                  <td><?php echo $res[$i]['criterio']?></td>
					<td><input type="text" class="form-control nota" name="<?php echo $res[$i]['id']; ?>" value="<?php echo retornaNota($res[$i]['id'],$user->ID); ?>"></td>
				  </tr>
				  
				<?php } ?>

				</tbody>

            </table>
								<input type="hidden" name="carregar" value="<?php echo $_POST['carregar']; ?>" >
				<input type="submit" class="btn btn-theme btn-lg btn-block"  name="gravar" value="Gravar">
				  </form>
			</div>
        </main>
      </div>
    </div>
	<div>
	<?php 
	if(isset($_POST['gravar'])){
	$inscricao = $_POST['carregar'];
	$sql_verifica = "SELECT id FROM ava_nota WHERE inscricao = '$inscricao AND usuario = '".$user->ID."'";
	$res = $wpdb->get_results($sql_verifica,ARRAY_A);

	foreach($_POST as $key => $value){
		echo $value."<br />";
		
	}
	
	if(count($res) > 0){ // existe, atualiza

	
		$mensagem = "Notas lançadas";
		
	}else{ // não existe, atualiza
	//$sql = "INSERT INTO `ava_nota` (`id`, `usuario`, `inscricao`, `nota`, `criterio`) VALUES (NULL, '".$user->ID."', '".$inscricao."', '".$."', '')";
		$mensagem = "Notas atualizadas";
	}
}
	
	?>
</div>
	<?php 
include "footer.php";
?>