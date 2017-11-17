<?php include "header.php"; ?>

  <body>
  
  <?php include "menu.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Inscrições</h1>


          <h2>Section title</h2>
		<div><select>
		<option></option>
		<input class="btn btn-sm btn-default" type="submit" value="Filtrar" />
		</select></div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
					<th>#</th>
                  <th>ID MAPAS</th>
                  <th>Proponente</th>
                  <th>Edital</th>
                  <th>Período de Avaliação</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
				<?php 
				global $wpdb;
				$res = $wpdb->get_results("SELECT * FROM ava_inscricao");
				
				//var_dump($res);
				for($i = 0; $i < count($res); $i++){ 
				$res_json = converterObjParaArray(json_decode(($res[$i]->descricao)));
				/*
				echo "<pre>";
				var_dump($res_json);
				echo "</pre>";
				*/
				
				//var_dump($edital);
				if(isset($res_json['Número'])){
					$edital = editais("",$res[0]->edital);
				?>	
    			 <tr>
				 <td><?php echo $i; ?></td>
                  <td><?php echo $res_json['Número']; ?></td>
                  <td><?php echo $res_json['Agente responsável pela inscrição']; ?></td>
                  <td><?php echo $edital[0]['titulo']; ?></td>
                  <td><?php echo $edital[0]['periodo']; ?></td>
                  <td></td>
					</tr>
				<?php 
				}
				} ?>	


				</tbody>
            </table>
          </div>
        </main>
      </div>
    </div>
	
<?php 
include "footer.php";
?>