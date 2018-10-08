<?php include "header.php"; ?>

  <body>
  
  <?php include "menu/menu_editais.php"; ?>
 
  <?php 
  
  if(isset($_GET['p'])){
	  $p = $_GET['p'];
  }else{
	  $p = 'inicio';
  }
  
  switch($p){
  case 'inicio':
  
  ?>
 
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Mercocidades - Vídeo</h1>

          <h2>Obras inscritas</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Título</th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

			<?php 
			$sql_filmes = "SELECT * FROM sc_mercocidades";
			$edital = $wpdb->get_results($sql_filmes,ARRAY_A);
			for($i = 0; $i < count($edital); $i++){
			?>		
			  
				<tr>
                  <td><?php echo $edital[$i]['id']; ?></td>
                  <td><?php echo $edital[$i]['COL27']; ?></td>
                  <td><?php echo $edital[$i]['COL32']; ?></td>
                  <td><?php echo $edital[$i]['COL2']; ?></td>
                  <td>
			<form action="?" method="GET" class="form-horizontal">
			<input type="hidden" name="p" value="view">
			<input type="hidden" name="id" value="<?php echo $edital[$i]['id']; ?>">
			<input type="hidden" name="id" value="<?php echo $edital[$i]['id']; ?>">
			<input type="submit" class="btn btn-theme btn-lg btn-block" name="detalhes" value="Detalhes" />
			</form>					  </td>

				  </tr>
			<?php } ?>		


				</tbody>
            </table>
          </div>
<?php 
break;
case 'view':
$id = $_GET['id'];
$sql = "SELECT * FROM sc_mercocidades WHERE id= '$id'";
$filme = $wpdb->get_row($sql,ARRAY_A);

?>	
	
	
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
	<h1><?php echo $filme['COL27']; ?></h1>		
	
						 <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
				<p>de : <?php echo $filme['COL2']; ?> ( <?php echo $filme['COL15']; ?> / <?php echo $filme['COL28']; ?>  )</p>
				<p>cidade : <?php echo $filme['COL8']; ?></p>
				<p>contato : <?php echo $filme['COL9']; ?></p>
				<p>categoria : <?php echo $filme['COL32']; ?></p>
				<p>sinopse : <?php echo $filme['COL35']; ?></p>
				
				
				<p><a href="<?php echo $filme['COL31'];  ?>" target=_blank ><?php echo $filme['COL31'];  ?> </a><?php if($filme['COL34'] != ""){ echo $filme['COL34'];} ?></p>
				
				<?php 

				
				?>

				</div>
        </div>
		</div>
	
<?php 
break;
  } // fim da switch
  ?>
          </main>
      </div>
    </div>
  
  <?php 
include "footer.php";
?>