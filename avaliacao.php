<?php include "header.php"; ?>
<?php 
if(isset($_POST['gravar'])){
	$inscricao = $_POST['carregar'];
	$sql_verifica = "SELECT id FROM ava_nota WHERE inscricao = '$inscricao AND usuario = '".$user->ID."'";
	$res = $wpdb->get_results($sql_verifica,ARRAY_A);
	if(count($res) > 0){ // existe, atualiza
		
		
	}else{ // não existe, atualiza
	$sql = "INSERT INTO `ava_nota` (`id`, `usuario`, `inscricao`, `nota`, `criterio`) VALUES (NULL, '".$user->ID."', '".$inscricao."', '".$."', '')";
		
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
	$( ".nota" ).mask("9,9");
});
  </script>
  <?php include "menu/menu_editais.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Dashboard</h1>

          <h2>Section title</h2>
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
					<td><input type="text" class="form-control nota" name="<?php echo $res[$i]['id']; ?>"></td>
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
	
<?php 
include "footer.php";
?>