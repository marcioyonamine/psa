<?php include "header.php"; ?>

  <body>
  
  <?php include "menu/me_inicio.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Ambiente teste</h1>
		<?php 
		$tipo = 'usuario';
		$id = 1;
		$x = opcaoDados($tipo,$id);
		
		var_dump($x);
		
		//algoritmo de sorteio 
$numero_inicial = 2;
$numero_final = 220;
$numero_grupo = 4;
$numero_quantidade = ($numero_final - $numero_inicial)/$numero_grupo;

$input = array();


for($i = $numero_inicial; $i <= $numero_final; $i++){
	array_push($input,$i);		
}

$grupo = array();

for($w = 1;$w <= $numero_grupo; $w++){
$grupo[$w] = array();
	for($k = $numero_inicial; $k <= $numero_quantidade; $k++){
		$rand_keys = array_rand($input, 1);
		array_push($grupo[$w],$rand_keys);
		$newArr = array();
		foreach($input as $value)
		{
			if( $value != $rand_keys )
			{
				array_push($newArr, $value);
			}
			$input = $newArr;
		}
	}
}

$x = json_encode($grupo);

$sql_insert_grupo = "UPDATE ava_edital SET avaliadores = '$x' WHERE id_mapas = '273'";
$insert = $wpdb->query($sql_insert_grupo);


echo "<pre>";
var_dump($grupo);
echo "</pre>";
		
		//echo $x['departamento'];
			
		//$x = orcamento(14,'2017-11-18');
		//var_dump($x);
		
		?>
		  
		  
		  
			<?php 
			/*
			echo "<h1>Teste decode json</h1>";
			$teste = recuperaDados("ava_edital","1","id");
			echo "<pre>";
			var_dump($teste);
			echo "</pre>";
			echo "<br />";
			$json =  json_decode($teste['avaliadores']);
			echo "<pre>";
			var_dump($json);
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
		/*
		?>
		  <h2>Insere datas na Agenda</h2>
		  
		  <?php 
			atualizarAgenda($_GET['id']);
		  
		  ?>		  
          <h2>Lista Usuários</h2>
		<?php
			$blogusers = get_users( 'role=administrator' );
			// Array of WP_User objects.
			echo "<pre>";
			var_dump($blogusers);
			echo "</pre>";
			
			foreach ( $blogusers as $user ) {
				echo '<p>' . esc_html( $user->user_email ) . '</p>';
			}
			*/
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