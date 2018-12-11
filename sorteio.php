<?php 
/* sorteio das inscrições entre os julgadores

$_GET['id_mapas'] é o id do Mapas Culturais
$_GET['grupos'] é o número de grupos ou integrantes (divido por)

*/

?>

<?php include "header.php"; ?>

  <body>
  
  <?php include "menu/me_inicio.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Ambiente teste</h1>
		<?php 
		$tipo = 'usuario';
		$id = 1;
		$x = opcaoDados($tipo,$id);
		
		$g = $x['edital'][1];
		echo "O grupo selecionado é ".$g."<br />";
		
		var_dump($x);
		
		$id_mapas = $_GET['id_mapas'];
		
		//algoritmo de sorteio 

		$sel_pes = "SELECT * FROM ava_inscricao WHERE id_mapas = '$id_mapas'";
		$res_sel = $wpdb->get_results($sel_pes,ARRAY_A);
		$total = count($res_sel);
		
		
		
		$numero_grupo = $_GET['grupos'];
		$numero_quantidade = (($total)/$numero_grupo);

$sobra = ($total)%$numero_grupo;
if($sobra > 0){
	$numero_quantidade = $numero_quantidade + 1;
	
}

$input = array();
$output = array();

for($i = 0; $i < $total; $i++){
	array_push($input,$res_sel[$i]['inscricao']);		
}

$grupo = array();
$novo_array = array();

function shuffle_assoc($list) { 
  if (!is_array($list)) return $list; 

  $keys = array_keys($list); 
  shuffle($keys); 
  $random = array(); 
  foreach ($keys as $key) 
    $random[$key] = $list[$key]; 

  return $random; 
} 

$input = shuffle_assoc($input);
 
$input = array_chunk($input,$numero_quantidade);
 
 


/*
for($w = 1;$w <= $numero_grupo; $w++){ //roda a quantidade grupos
$grupo[$w] = array(); // cria a array de grupos
	while(count($grupo[$w]) != $numero_quantidade AND count($output) != $total){ // começa a rodar a quantidade de elementos
		$rand_keys = array_rand($input, 1); // pega um número aleatório
		if(!in_array($rand_keys,$output)){
			array_push($output,$rand_keys);
			array_push($grupo[$w],$rand_keys);
		}
		
	}
}


*/
$x = "{";
for($i = 0; $i < $numero_grupo; $i++){
	$x = $x.'"'.$i.'":'.json_encode($input[$i]).',';
	
}
$x = $x."}";

$x = json_encode($input);

$sql_insert_grupo = "UPDATE ava_edital SET avaliadores = '$x' WHERE id_mapas = '".$_GET['id_mapas']."'";
$insert = $wpdb->query($sql_insert_grupo);


$sql_sel_ins = "SELECT avaliadores FROM ava_edital WHERE id_mapas = '".$_GET['id_mapas']."'";
$sel = $wpdb->get_row($sql_sel_ins,ARRAY_A);


$y = json_decode($sel['avaliadores'],true);




echo "<br />Total:".count($y[0]);
echo "<br />Total:".count($y[1]);
echo "<br />Total:".count($y[2]);
echo "<br />Total:".count($y[3]);
echo "<br />";

?>
        </main>
      </div>
    </div>
	
<?php 
include "footer.php";
?>