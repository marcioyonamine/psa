<?php 
/* 
$_GET['file'] = nome do arquivo xls
$_GET['mapas'] = número do projeto no CulturAZ

*/

?>

<?php include "header.php"; ?>

  <body>
  
  <?php include "menu.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Importar Inscrições</h1>

			<div>
			

			<br />
			<?php 
			require_once dirname(__FILE__) . '/classes/PHPExcel.php';
			
			if(isset($_GET['file'])){
			$fileName = "upload/".$_GET['file'];
			
			/** detecta automaticamente o tipo de arruivo que será carregado */
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
			
			echo "Linhas:  ".$highestRow;
			
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
					global $wpdb;
					$json = addslashes(json_encode($matriz,JSON_UNESCAPED_UNICODE));		
					$sql = "INSERT INTO `ava_inscricao` (`id`, `id_mapas`, `inscricao`, `edital`, `aprovado`, `descricao`) 
					VALUES (NULL, '".$_GET['mapas']."', '".($matriz['Número'])."', '".$_GET['edital']."', '', '".$json."')";
					$insert = $wpdb->query($sql);
					if($insert == FALSE){
						echo $sql."<br /><br />";
					}else{
						echo "Sucesso $sql<br /><br />";
					}
					
					
				}

					
					
		
			

				
			echo "<pre>";
			var_dump($matriz);
			echo "</pre>";
			}
	}
	/*		

									$empenho = $matriz["Empenho"];
						$ano  = $matriz["Ano Empenho"];
						$unixTimestamp = PHPExcel_Shared_Date::ExcelToPHP($matriz["Data"]);
						$data  =  date('Y-m-d', $unixTimestamp);
						$ficha  = $matriz["Ficha"];
						$projeto  = $matriz["Projeto"];
						$v_empenho  = $matriz["Empenho2"];
						$v_estorno  = $matriz["Estorno"];
						$v_anulado  = $matriz["Anulado"];
						$v_n_processado  = $matriz["Não processado"];
						$v_processado = $matriz["Processado"];
						$v_op  = $matriz["Valor OP"];
						$v_op_baixado = $matriz["OP Baixada"];
						$v_saldo = $matriz["Saldo a pagar"];
						$n_processo = $matriz["Processo"];
						$historico = $matriz["Histórico"];		
						
						$sql_ins = "INSERT INTO `sc_giap` (`id`, `empenho`, `ano`, `data`, `ficha`, `projeto`, `v_empenho`, `v_estorno`, `v_anulado`, `v_n_processado`, `v_processado`, `v_op`, `v_op_baixado`, `v_saldo`, `nProcesso`, `historico`) VALUES (NULL, '$empenho', '$ano', '$data', '$ficha', '$projeto', '$v_empenho', '$v_estorno', '$v_anulado', '$v_n_processado', '$v_processado', '$v_op', '$v_op_baixado', '$v_saldo', '$n_processo', '$historico')";
						
						$x = $wpdb->query($sql_ins);
			
			
			}									
									
			}else{
				echo "<h2>Nenhum arquivo foi selecionado.</h2>";	
				
			}	

			
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
			*/
			
		/*
		$edital = editais($user->ID);
		
		echo "var_dump da funcao edital";
		echo "<pre>";
		var_dump($edital);
		echo "</pre>";
	*/	
		?>
			
			
			</div>	
		  
		  

        </main>
      </div>
    </div>
	
<?php 
include "footer.php";
?>