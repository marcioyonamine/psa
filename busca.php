<?php include "header.php"; ?>

  <body>
  
  <?php include "menu/me_inicio.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Busca</h1>
<?php 
if(isset($_POST['busca'])){
	$busca = $_POST['busca'];
	// eventos
	$sql_evento = "SELECT idEvento FROM sc_evento WHERE nomeEveno LIKE '%$busca%' OR
			autor  LIKE '%$busca%' OR
			nomeGrupo  LIKE '%$busca%' OR
			fichaTecnica  LIKE '%$busca%' OR
			sinopse  LIKE '%$busca%' OR
			releaseCom  LIKE '%$busca%'"; 
	$res = 		
}	
		?>
		 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <p>A busca compreende eventos, contratos, pessoas físicas e jurídicas e espaços</p>
					
			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?" class="form-horizontal" role="form">
					<div class="row">
						<div class="col-12">
						<label>Digite pelo menos 3 caracteres</label>
							<input type="text" name="busca" class="form-control" id="inputSubject" />
						</div>
					</div><br />
										<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="inserir_pf" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Busca">
						</div>
					</div>
				</form>
	</div>
	</section>	
		
		
        </main>
      </div>
    </div>
	
<?php 
include "footer.php";
?>