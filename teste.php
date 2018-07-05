<?php include "header.php"; ?>

  <body>
  
  <?php //include "menu/me_inicio.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Ambiente teste</h1>

		  <?php echo exibeHoje();?>




		  
<?php 
// Atualiza tabela de inscricao

if(isset($_GET['mapas'])){
	
	$m = $_GET['mapas'];

class gMaps {
  private $mapsKey;
  function __construct($key = null) {
    if (!is_null($key)) {
      $this->mapsKey = $key;
    }
  }
  function carregaUrl($url) {
    if (function_exists('curl_init')) {
      $cURL = curl_init($url);
      curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
      $resultado = curl_exec($cURL);
      curl_close($cURL);
    } else {
      $resultado = file_get_contents($url);
    }
	
    if (!$resultado) {
      trigger_error('Não foi possível carregar o endereço: <strong>' . $url . '</strong>');
    } else {
      return $resultado;
    }
  }
  
  function geoLocal($endereco) {
    $url = "https://maps.googleapis.com/maps/api/geocode/json?key={$this->mapsKey}&address=" . urlencode($endereco);
    $data = json_decode($this->carregaUrl($url));
    
    if ($data->status === 'OK') {
      return $data->results[0]->geometry->location;
    } else {
      return false;
    }
  }

    function geoEndereco($endereco) {
    $url = "https://maps.googleapis.com/maps/api/geocode/json?key={$this->mapsKey}&latlng=" . urlencode($endereco);
    $data = json_decode($this->carregaUrl($url));
    
    if ($data->status === 'OK') {
      return $data->results[0];
    } else {
      return false;
    }
  }
  
}

$sql = "SELECT * FROM ava_inscricao WHERE id_mapas = '$m' ";
$x = $wpdb->get_results($sql,ARRAY_A);

for ($i = 0; $i < count($x); $i++){
	$y = json_decode($x[$i]['descricao'],true);
	//echo "<pre>";
	//var_dump($y);
	//echo "</pre>";
	$aprovado = $y['Aprovados'];
	$atuacao = $y['Agente responsável pela inscrição - Área de Atuação'];
	$cidade = strtoupper(tirarAcentos($y['Agente responsável pela inscrição - Município']));
	$bairro = strtoupper(tirarAcentos($y['Agente responsável pela inscrição - Bairro']));
	$nascimento = $y['Agente responsável pela inscrição - Data de Nascimento/Fundação'];
	$genero = $y['Agente responsável pela inscrição - Gênero'];
	$id = $x[$i]['id'];
	$agente = $y['Agente responsável pela inscrição - Id'];
	
	echo $atuacao."<br />";
	echo ($cidade)."<br />";
	echo ($bairro)."<br />";
	echo $nascimento." ".date('d/m/Y',$nascimento)."<br />";
	echo $genero."<br /><br />";
	$geo = $y['Agente responsável pela inscrição -']."<br />";
	
	if($cidade == "" AND ($geo != "-23.533563948913,-46.5756915811594" AND $geo == 0)){
		$gmaps = new gMaps($_GET['key']);
		// Pega os dados (latitude, longitude e zoom) do endereço:
		$endereco = $agente;
		$dados = converterObjParaArray($gmaps->geoEndereco($endereco));
		var_dump($dados);
		$cidade = strtoupper(tirarAcentos($dados['address_components'][3]['long_name']));
	}
	
	
	$sql_update = "UPDATE ava_inscricao SET 
	genero = '$genero',
	segmento = '$atuacao',
	cidade = '$cidade',
	bairro = '$bairro',
	aprovado = '$aprovado',
	id_agente = '$agente'
	WHERE id = '$id'";
	$update = $wpdb->query($sql_update);
	
	
	
}

	$sql_update = "UPDATE ava_inscricao SET cidade = 'SANTO ANDRE' WHERE cidade = 'SANTOANDRE' OR cidade = 'SNARO ANDRE'";
	$update = $wpdb->query($sql_update);

	$sql_update = "UPDATE ava_inscricao SET cidade = 'SAO BERNARDO DO CAMPO' WHERE cidade = 'SAO BERNADO DO CAMPO' OR cidade = 'SAO BERNARDO'";
	$update = $wpdb->query($sql_update);



	$sql_cidades = "SELECT DISTINCT cidade FROM ava_inscricao WHERE id_mapas = '$m' ORDER BY cidade";
	$cidades = $wpdb->get_results($sql_cidades,ARRAY_A);
	echo count($cidades);
	for($i = 0; $i < count($cidades); $i++){
		$city = $cidades[$i]['cidade'];
		$sql_sel_city = "SELECT id FROM ava_inscricao WHERE id_mapas = '$m' AND cidade = '$city'";
		$n_city = $wpdb->get_results($sql_sel_city);
		echo $city."( ".count($n_city)." ), ";
		
		
		
	}



function validarCep($cep) {
    // retira espacos em branco
    $cep = trim($cep);
	
	$string = $cep;
		if (preg_match('/^[0-9]{5}-[0-9]{3}$/', $string)) {
		return retornaCEP($string);
	}
} 
	
	
$sem_endereco = "SELECT id,descricao FROM ava_inscricao WHERE id_mapas = '$m' AND cidade = ''";
$sem_end = $wpdb->get_results($sem_endereco,ARRAY_A);

for($i = 0; $i < count($sem_end); $i++){
	$json = $sem_end[$i]['descricao'];
	//var_dump($json);
	$busca = explode(",",$json);
	foreach($busca as $string){
		$cep = validarCep($string);
		$upd = "UPDATE ava_inscricao SET 
		cidade = '".strtoupper(tirarAcentos($cep['cidade']))."',
		bairro = '".strtoupper(tirarAcentos($cep['bairro']))."
		WHERE id = '".$sem_end[$i]['id']."'
		";
		$wpdb->query($upd);

	}
	
		
		
}

	
	
	



}else{
	echo "<h1>Não há edital selecionado para atualizar</h1>";
	
}

/*
//$x = array("on-1773097257","on-783829307","on-1761685716","on-352832","on-732854095","on-1442268823","on-1566051262","on-1683241002","on-1714966032","on-118036985","on-743253080","on-1048183298","on-757466696","on-816928171","on-206463587","on-802625839","on-1577808338","on-1911167732","on-21575494","on-692984084","on-1619996948","on-597512233","on-238034968","on-1968119092","on-833444987","on-947680953","on-1322976383","on-1820229336","on-2052139008","on-1717118768","on-1400064695","on-275136340","on-764674688","on-81144614","on-1097209228","on-2083747890","on-772235373","on-1489454805","on-1064335160","on-575366804","on-199453234","on-1038431609","on-1386686453","on-998397921","on-1901353153","on-63316958","on-1093220644","on-31740023","on-467012070","on-1511533568","on-549538762","on-1542680140","on-1762919233","on-840918750","on-1579498570","on-144863959","on-998053853","on-1014304746","on-1873687417","on-2059946682","on-1637835576","on-1213339754","on-1790838746","on-1686202074","on-1335892498","on-700738777","on-924806377","on-2114852335");

?>

<table>
<tr>
<th>CAT</th>
<th>Reclassificação</th>
<th>Segmento</th>
<th>Nome da Intervenção</th>
<th>Grupo / Coletivo</th>
<th>Descrição</th>
<th>Proponente</th>
<th>Valor</th>
<th>No. Apresentações</th>
<th>Valor Total</th>
<th>Contratado</th>
<th>Contato</th>
<th>Obs</th>
</tr>
<?php
//PROPOPENTE Valor No. Apresentações Valor Total Contratado CONTATO Obs.
foreach($x as $inscricao){
	$y = retornaInscricao($inscricao);
	$insc = json_decode($y['descricao'],true);
?>
<tr>
<td><?php echo $insc['3.2 - Categoria']; ?></td>
<td><?php echo $y['filtro']; ?></td>
<td><?php echo $insc['3.3 - Determine a área principal de enquadramento da proposta']; ?></td>
<td><?php echo $insc['3.1 - Título']; ?></td>
<td><?php echo $insc['1.4 - Resumo Currículo Grupo / Coletivo / Agente Cultural']; ?></td>
<td><?php echo $insc['3.6 - Sinopse do evento']; ?></td>
<td><?php echo $insc['Agente responsável pela inscrição']; // Proponente ?></td>
<td></td>
<td><?php echo $insc['3.11 - Valor (em Reais)']; // Valor ?></td>
<td></td>
<td><?php echo $insc['Instituição responsável']; // Contratado ?></td>
<td><?php echo $insc['Instituição responsável - Telefone 1']; // Contratado ?> / <?php echo $insc['Instituição responsável - Email Privado']; // Contratado ?></td>

<td></td>
</tr>

<?php


	//var_dump($insc);
	//echo "<br />";	
}

?>
</table>

<table>
<tr>
<th>Evento</th>
<th>Instituição</th>
<th>Razão Social</th>
<th>CNPJ</th>
</tr>
<?php
//PROPOPENTE Valor No. Apresentações Valor Total Contratado CONTATO Obs.
foreach($x as $inscricao){
	$y = retornaInscricao($inscricao);
	$insc = json_decode($y['descricao'],true);
?>
<tr>
<td><?php echo $insc['3.1 - Título']; ?></td>

<td><?php echo $insc['Instituição responsável']; ?></td>

<td><?php echo $insc['Instituição responsável - Nome completo ou Razão Social']; ?></td>
<td><?php echo $insc['Instituição responsável - CPF ou CNPJ']; ?></td>

</tr>

<?php


	//var_dump($insc);
	//echo "<br />";	
}

?>
</table>


<?php
*/
// atualiza as médias

// pega todas as incrições com notas
/*
$sql_nota = "SELECT DISTINCT inscricao FROM ava_nota WHERE edital = 349";
$notas = $wpdb->get_results($sql_nota,ARRAY_A);
for ($i = 0; $i < count($notas); $i++){
	$inscricao = $notas[$i]['inscricao'];
	// pega o número de jurados
	$sql_jurados = "SELECT DISTINCT usuario FROM ava_nota WHERE inscricao ='$inscricao'";
	$jurados = $wpdb->get_results($sql_jurados,ARRAY_A);
	$num = count($jurados);
	
	// soma as notas
	$sql_soma = "SELECT nota FROM ava_nota WHERE inscricao = '$inscricao'";
	$soma = $wpdb->get_results($sql_soma,ARRAY_A);
	$soma_nota = 0;
	for($k =0; $k < count($soma); $k++){
		$soma_nota = $soma_nota + $soma[$k]['nota'];
	}
	$media = $soma_nota / $num;
	
	
	echo "A inscricao $inscricao teve $num jurados e média de $media ($soma_nota).<br />";

	// atualiza o ranking
	
	$sql_update = "UPDATE ava_ranking SET nota = '$media' WHERE inscricao = '$inscricao'";
	$update = $wpdb->query($sql_update);
	if($update == 1){
		echo "Ranking atualizado.<br />";
	}else{
		echo "Erro ao atualizar o ranking.<br />";
	}
	
	
}

*/


/*
$sql = "SELECT * FROM temp_bairros";
$x = $wpdb->get_results($sql,ARRAY_A);
for($i = 0; $i < count($x); $i++){
	$bairro = $x[$i]['bairro'];
	$distrito = $x[$i]['distrito'];
	$json = '{"distrito":"'.$distrito.'"}';
	$sql_insert = "INSERT INTO `sc_tipo` (`id_tipo`, `tipo`, `descricao`, `abreviatura`, `publicado`) VALUES (NULL, '$bairro', '$json', 'bairro', '1');";
	$ins = $wpdb->query($sql_insert);
	if($ins){
		echo "$bairro inserido com sucesso.<br />";
	}else{
		echo "Erro ao inserir $bairro.<br />";
	}
	
}

*/

?>		  
		  
		  
		  
<?php /*
$edital = $_GET['edital'];
$sql_gera = "SELECT DISTINCT inscricao FROM ava_nota WHERE edital = '$edital'";
$resultados = $wpdb->get_results($sql_gera,ARRAY_A);

//echo $sql_gera;
//echo "<br />";
//var_dump($resultados);

for($i = 0; $i < count($resultados); $i++){
	//verifica quantos usuários deram nota
	$sql_user = "SELECT DISTINCT usuario FROM ava_nota WHERE inscricao ='".$resultados[$i]['inscricao']."'";
	$user = $wpdb->get_results($sql_user,ARRAY_A);	
	$n_user = count($user);
	// contamos todos os valores
	$sql_notas = "SELECT nota FROM ava_nota WHERE inscricao = '".$resultados[$i]['inscricao']."'";
	$notas = $wpdb->get_results($sql_notas,ARRAY_A);	
	$total = 0;
	for($k = 0; $k < count($notas); $k++){
		$total = $total + $notas[$k]['nota'];
	}
	$inscricao = $resultados[$i]['inscricao'];
	$nota_media = $total/$n_user;
	
	$sql_insc = "SELECT descricao FROM ava_inscricao WHERE inscricao = '$inscricao'";
	$insc_json = $wpdb->get_results($sql_insc,ARRAY_A);
	$insc = json_decode($insc_json[0]['descricao'],true);
	$categoria = $insc['3.2 - Categoria'];
	//echo "<pre>";
	//var_dump($insc);
	//echo "</pre>";
	$sql_atualiza = "UPDATE ava_ranking SET
	nota = '$nota_media',
	filtro = '$categoria'
	WHERE inscricao = '$inscricao'
	";
	$atualiza = $wpdb->query($sql_atualiza);
	
	//echo $resultados[$i]['inscricao']." = ".$total." | média = ".$total/$n_user." Categoria: $categoria<br />"; 
	
	
	
}

*/
?>		
		
		
		<?php 
		/*
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