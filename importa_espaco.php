<?php include "header.php"; ?>

  <body>
  
  <?php include "menu.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Dashboard</h1>

		  
		  
		  
		  
         <!-- <section class="row text-center placeholders">
            <div class="col-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIABAAJ12AAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <div class="text-muted">Something else</div>
            </div>
            <div class="col-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIABAADcgwAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIABAAJ12AAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIABAADcgwAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
          </section>
			<div>
			<?php 
			/*

			$teste = recuperaDados("ava_edital","1","id");
			echo "<pre>";
			var_dump($teste);
			echo "</pre>";
			echo "<br />";
			$json =  json_decode($teste['avaliadores']);
			echo "<pre>";
			var_dump($json);
			echo "</pre>";
			
			global $wpdb;
			$teste2 = "SELECT * FROM ava_fase WHERE edital = '1'";
			$result = $wpdb->get_results($teste2);
			echo "ava_fase";
			echo "<pre>";
			var_dump($result);
			echo "</pre>";
			
			?>
			<br />
			<?php 
			require_once dirname(__FILE__) . '/classes/PHPExcel.php';
			$fileName = "elt.xls";
			
			// detecta automaticamente o tipo de arruivo que será carregado 
			$excelReader = PHPExcel_IOFactory::createReaderForFile($fileName);

			//Se não precisarmos de formatação
			$excelReader->setReadDataOnly();

			//carregar apenas algumas abas
			//$loadSheets = array('aba1', 'aba2');
			//$excelReader->setLoadSheetsOnly($loadSheets);

			//o comportamente padrão é carregar todas as abas
			$excelReader->setLoadAllSheets();
			
			$excelObj = $excelReader->load($fileName);
			
			//$excelObj->getActiveSheet()->toArray(null, true,true,true);


			$sheet = $excelObj->getSheet(0);
			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn();
			
			$matriz = array();
			
			//  Loop through each row of the worksheet in turn
			for ($row = 1; $row <= $highestRow; $row++){ 
				//  Read a row of data into an array
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);
			
				// Gera os índices
				
				if($row == 1){
					$indice = $rowData[0]; 		
				}else{
					for($k = 0; $k < count($rowData[0]); $k++){
						$matriz[$indice[$k]] = $rowData[0][$k];
					}
				}
				
			echo "<pre>";
			var_dump($matriz);
			echo "</pre>";
			
			}									
									
			*/

			
			/*
			echo "<pre>";
			var_dump($matriz);
			echo "</pre>";
		
			$json = json_encode($matriz);

			echo $json;
		
			$json_de = json_decode($json);
			
			echo "<pre>";
			var_dump($json_de);
			echo "</pre>";
			
		
		$edital = editais($user->ID);
		echo "var_dump da funcao edital";
		echo "<pre>";
		var_dump($edital);
		echo "</pre>";
			*/
		
		?>
			
			
			</div>-->	
		  
		  
          <h2>Importa espaço</h2>
		  <?php 
		  global $wpdb;
		  $sql = "SELECT * FROM mapas WHERE tipo = '2'";
		  $res = $wpdb->get_results($sql,ARRAY_A);
		  for($i = 0; $i < count($res); $i++){
			  $espaco = $res[$i]['valor'];
			  $dados = array('mapas' => $res[$i]['id_mapas']);
			  $json = json_encode($dados);
			  $sql_ins = "INSERT INTO `sc_tipo` (`id_tipo`, `tipo`, `descricao`, `abreviatura`) 
			  VALUES (NULL, '$espaco', '$json', 'local')";
			  $insert = $wpdb->query($sql_ins);
				var_dump($insert);
				echo $sql_ins."<br />";		
			  
			  
		  }
		  
		  
		  ?>
		  
          <!-- <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Header</th>
                  <th>Header</th>
                  <th>Header</th>
                  <th>Header</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1,001</td>
                  <td>Lorem</td>
                  <td>ipsum</td>
                  <td>dolor</td>
                  <td>sit</td>
                </tr>
                <tr>
                  <td>1,002</td>
                  <td>amet</td>
                  <td>consectetur</td>
                  <td>adipiscing</td>
                  <td>elit</td>
                </tr>
                <tr>
                  <td>1,003</td>
                  <td>Integer</td>
                  <td>nec</td>
                  <td>odio</td>
                  <td>Praesent</td>
                </tr>
                <tr>
                  <td>1,003</td>
                  <td>libero</td>
                  <td>Sed</td>
                  <td>cursus</td>
                  <td>ante</td>
                </tr>
                <tr>
                  <td>1,004</td>
                  <td>dapibus</td>
                  <td>diam</td>
                  <td>Sed</td>
                  <td>nisi</td>
                </tr>
                <tr>
                  <td>1,005</td>
                  <td>Nulla</td>
                  <td>quis</td>
                  <td>sem</td>
                  <td>at</td>
                </tr>
                <tr>
                  <td>1,006</td>
                  <td>nibh</td>
                  <td>elementum</td>
                  <td>imperdiet</td>
                  <td>Duis</td>
                </tr>
                <tr>
                  <td>1,007</td>
                  <td>sagittis</td>
                  <td>ipsum</td>
                  <td>Praesent</td>
                  <td>mauris</td>
                </tr>
                <tr>
                  <td>1,008</td>
                  <td>Fusce</td>
                  <td>nec</td>
                  <td>tellus</td>
                  <td>sed</td>
                </tr>
                <tr>
                  <td>1,009</td>
                  <td>augue</td>
                  <td>semper</td>
                  <td>porta</td>
                  <td>Mauris</td>
                </tr>
                <tr>
                  <td>1,010</td>
                  <td>massa</td>
                  <td>Vestibulum</td>
                  <td>lacinia</td>
                  <td>arcu</td>
                </tr>
                <tr>
                  <td>1,011</td>
                  <td>eget</td>
                  <td>nulla</td>
                  <td>Class</td>
                  <td>aptent</td>
                </tr>
                <tr>
                  <td>1,012</td>
                  <td>taciti</td>
                  <td>sociosqu</td>
                  <td>ad</td>
                  <td>litora</td>
                </tr>
                <tr>
                  <td>1,013</td>
                  <td>torquent</td>
                  <td>per</td>
                  <td>conubia</td>
                  <td>nostra</td>
                </tr>
                <tr>
                  <td>1,014</td>
                  <td>per</td>
                  <td>inceptos</td>
                  <td>himenaeos</td>
                  <td>Curabitur</td>
                </tr>
                <tr>
                  <td>1,015</td>
                  <td>sodales</td>
                  <td>ligula</td>
                  <td>in</td>
                  <td>libero</td>
                </tr>
              </tbody>
            </table>
          </div>-->
        </main>
      </div>
    </div>
	
<?php 
include "footer.php";
?>