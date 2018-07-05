<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';
}


?>
  <body>
  
  <?php include "menu/me_relatorio.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
	<h1>Relatório</h1>		
<?php 
switch($p){
case 'inicio':
?>
  
<?php 
break;
case 'atualiza_categoria_ranking':  
if(isset($_GET['id_mapas'])){
	$id_mapas = $_GET['id_mapas'];
?>		  
<?php 
				$sql_sel_ins = "SELECT inscricao FROM ava_inscricao WHERE id_mapas = '$id_mapas'";
				$res = $wpdb->get_results($sql_sel_ins,ARRAY_A);
				
				
				for($i = 0; $i < count($res); $i++){
					$id_insc = $res[$i]['inscricao'];
					$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$id_insc'";	
					$json = $wpdb->get_row($sel,ARRAY_A);	
					$res_json = converterObjParaArray(json_decode(($json['descricao'])));
					$filtro = $res_json['3.2 - Categoria'];
					$sql_atualiza = "UPDATE ava_ranking SET filtro = '$filtro' WHERE inscricao = '$id_insc'";
					if($wpdb->query($sql_atualiza)){
						echo "$id_insc - Filtro atualizado.<br />";
					}else{
						echo "$id_insc - $sql_atualiza.<br />";
						
					}
				}
					
				}else{
					?>
					 <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Não há Edital indicado</h1>
				</div>
        </div>
		</div>
			<?php 	}

							
				?>


  

<?php 
break;
case 'orcamento':  
$projeto = array();
$w = 0;
$orcamentototal = orcamentoTotal(2018);
//var_dump($orcamentototal);
?>  

          <h1>Orçamentário</h1>
		<!--<div><select>
		<option></option>
		<input class="btn btn-sm btn-default" type="submit" value="Filtrar" />
		</select></div>-->
		<?php $orcamento = orcamentoTotal(2018);
		//var_dump($orcamento); ?>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
				<th></th>
				<th></th>
     			</tr>
              </thead>
              <tbody>
				<tr>
				<td>Orçamento Aprovado</td>
				<td><?php echo dinheiroParaBr($orcamento['orcamento']); ?></td>
				</tr>
				<tr>
				<td>Contigenciado</td>
				<td><?php echo dinheiroParaBr($orcamento['contigenciado']); ?></td>
				</tr>
				<tr>
				<td>Descontigenciado</td>
				<td><?php echo dinheiroParaBr($orcamento['descontigenciado']); ?></td>
				</tr>
				<tr>
				<td>Suplementado</td>
				<td><?php echo dinheiroParaBr($orcamento['suplementado']); ?></td>
				</tr>
				<tr>
				<td>Anulado</td>
				<td><?php echo dinheiroParaBr($orcamento['anulado']); ?></td>
				</tr>
				<tr>
				<td>Liberado</td>
				<td><?php echo dinheiroParaBr($orcamento['liberado']); ?></td>
				</tr>
								<tr>
				<td>Planejado</td>
				<td><?php echo dinheiroParaBr($orcamento['planejado']); ?></td>
				</tr>
								<tr>
				<td>Executado</td>
				<td></td>
				</tr>
				<tr>
				<td>Saldo </td>
				<td><?php echo dinheiroParaBr($orcamento['total']); ?></td>
				<td></td>
				</tr>
				<tr>
				<td>Saldo Planejado</td>
				<td><?php echo dinheiroParaBr($orcamento['total'] - $orcamento['planejado']); ?></td>

				</tr>				
				</tbody>
            </table>
          </div> 

		
		
		
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
				<th width="25%">Programa</th>
				<th>Projeto</th>
				<th>Valor</th>
				<th>Nota</th>
				<th>Responsável</th>
				<th>Projeto/Ficha</th>
				<th>Descrição</th>

     			</tr>
              </thead>
              <tbody>
				<?php 
				$programa = array();
				$sel_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'programa'";
				$res_programa = $wpdb->get_results($sel_programa,ARRAY_A);
				for($i = 0; $i < count($res_programa); $i++){
				$total_programa = 0;
				?>
				<tr>
				<td><strong><?php echo $res_programa[$i]['tipo'] ?></strong></td>
				<td></td>
				<td></td>				
				<td></td>				
				<td></td>				
				<td></td>				
				<td></td>				

				</tr>
					<?php 
					$sel_projeto = "SELECT * FROM sc_tipo WHERE abreviatura = 'projeto'";
					$res_projeto = $wpdb->get_results($sel_projeto,ARRAY_A);
					//var_dump($res_projeto);	
					for($k = 0; $k < count($res_projeto); $k++){
						$pro_json = json_decode(utf8_encode($res_projeto[$k]['descricao']),true);
						//var_dump($pro_json);
						if($pro_json['programa'] == $res_programa[$i]['id_tipo']){
							
					?>
					<tr>
					<td></td>
					<td><?php echo $res_projeto[$k]['tipo'] ?></td>
					<td>
					<?php 
						$sql_orc = "SELECT valor,obs,idPai FROM sc_orcamento WHERE planejamento ='".$res_projeto[$k]['id_tipo']."' AND publicado ='1'";
						$res_orc = $wpdb->get_row($sql_orc,ARRAY_A);
						
						if($res_orc['idPai'] != NULL){
							$orc = recuperaDados("sc_orcamento",$res_orc['idPai'],"id");
						}else{
							$orc = array(
							'obs' => '',
							'projeto' => '',
							'ficha' => '',
							'descricao' => ''
							);
						}
						//var_dump($orc);
						echo dinheiroParaBr($res_orc['valor']);
						if($res_orc['valor'] != NULL){
							$total_programa = $total_programa + $res_orc['valor'];
						}
						if($orc == NULL){
							$res_orc = array(
							'obs' => '',
							'projeto' => '',
							'ficha' => '',
							'descricao' => ''
							);
						}
						?>
					</td>
					<td><?php echo $res_orc['obs']; ?></td>
									<td><?php echo $pro_json['responsavel'];//var_dump($orc); ?></td>				
				<td><?php echo $orc['projeto'] ?> / <?php echo $orc['ficha'] ?></td>				
				<td><?php echo $orc['descricao'] ?></td>				

					</tr>
					<?php } 
					
					$projeto[$w]['nome'] = $res_projeto[$k]['tipo'];
					if($res_orc['valor'] == NULL){
						$projeto[$w]['valor'] = 0;
					}else{
					$projeto[$w]['valor'] = $res_orc['valor'];
					}
					$w++;
					}


					
					
					?>
				<?php 
				?>
				<tr>
				<td><strong>Total do Programa:</strong></td>
				<td></td>
				<td><strong><?php echo dinheiroParaBr($total_programa); ?></strong></td>
				<td></td>
				<td></td>				
				<td></td>				
				<td></td>				

				<?php 
				$programa[$i]['programa'] = $res_programa[$i]['tipo'];
				$programa[$i]['valor'] = $total_programa;
				?>
				</tr>
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
								<td></td>				
				<td></td>				
				<td></td>				

				</tr>
				<?php 
				}


				?>

				</tbody>
            </table>
          </div> 

<style>

.bar {
  fill: steelblue;
}

.bar:hover {
  fill: brown;
}

.axis--x path {
  display: none;
}

</style>



		  </div>

<div id="pieChart" align="center"></div>

<!--<div id="pieChart2" align="center"></div>-->
  <div>
	<?php 
	//var_dump($programa);
	?>
</div>


<script src="js/jquery-3.2.1.js"></script>
<script src="https://d3js.org/d3.v4.js"></script>
<script src="visual/d3/d3pie.js"></script>
<script>
var pie = new d3pie("pieChart", {
	"header": {
		"title": {
			"text": "Planejamento por Programa",
			"fontSize": 24,
			"font": "open sans"
		},
		"subtitle": {
			"text": "",
			"color": "#999999",
			"fontSize": 12,
			"font": "open sans"
		},
		"titleSubtitlePadding": 9
	},
	"footer": {
		"color": "#999999",
		"fontSize": 10,
		"font": "open sans",
		"location": "bottom-left"
	},
	"size": {
		"canvasWidth": 800,
		"pieOuterRadius": "90%"
	},
	"data": {
		"sortOrder": "value-desc",
		"content": [
		
		<?php for ($i = 0; $i < count($programa); $i++){ ?>
			{
				"label": "<?php echo $programa[$i]['programa']?>",
				"value": <?php echo $programa[$i]['valor'] ?>,
				"color": "<?php echo '#' . dechex(rand(256,16777215)) ?>"
			},
		<?php } ?>

		]
	},
	"labels": {
		"outer": {
			"pieDistance": 32
		},
		"inner": {
			"hideWhenLessThanPercentage": 3
		},
		"mainLabel": {
			"fontSize": 11
		},
		"percentage": {
			"color": "#ffffff",
			"decimalPlaces": 0
		},
		"value": {
			"color": "#adadad",
			"fontSize": 11
		},
		"lines": {
			"enabled": true
		},
		"truncation": {
			"enabled": true
		}
	},
	"effects": {
		"pullOutSegmentOnClick": {
			"effect": "linear",
			"speed": 400,
			"size": 8
		}
	},
	"misc": {
		"gradient": {
			"enabled": true,
			"percentage": 100
		}
	}
});
</script>



<?php 
break;
case 'projeto2':  

?>  
 <script type="text/javascript" src="visual/vis.js"></script>
  <link href="visual/vis-network.min.css" rel="stylesheet" type="text/css" />

  <style type="text/css">
    #mynetwork {
      width: 1200px;
      height: 1200px;
      border: 1px solid lightgray;
    }
  </style>
<div id="mynetwork"></div>

<script type="text/javascript">
  // create an array with nodes
  var nodes = new vis.DataSet([
	<?php 
	$sel_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'programa'";
	$res_programa = $wpdb->get_results($sel_programa,ARRAY_A);
	for($i = 0; $i < count($res_programa); $i++){
	?>
    {id: <?php echo $res_programa[$i]['id_tipo']; ?>, label: '<?php echo $res_programa[$i]['tipo'] ?>', color: 'red', widthConstraint: { minimum: 120 }},
	<?php 
		$sel_projeto = "SELECT * FROM sc_tipo WHERE abreviatura = 'projeto'";
		$res_projeto = $wpdb->get_results($sel_projeto,ARRAY_A);
		//var_dump($res_projeto);	
		for($k = 0; $k < count($res_projeto); $k++){
			$pro_json = json_decode(utf8_encode($res_projeto[$k]['descricao']),true);
			//var_dump($pro_json);
			if($pro_json['programa'] == $res_programa[$i]['id_tipo']){ ?>
			{id: <?php echo $res_projeto[$k]['id_tipo']; ?>, label: '<?php echo $res_projeto[$k]['tipo'] ?>', color: 'yellow', widthConstraint: { minimum: 120 } },
			<?php
			}
		}
	}		
	?>
	
    {id: 200, label: 'Node 5'}
  ]);

  // create an array with edges
  var edges = new vis.DataSet([
  	<?php 
	$sel_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'programa'";
	$res_programa = $wpdb->get_results($sel_programa,ARRAY_A);
	$id = 1;
	for($i = 0; $i < count($res_programa); $i++){
	?>
	<?php 
		$id++;
		$sel_projeto = "SELECT * FROM sc_tipo WHERE abreviatura = 'projeto'";
		$res_projeto = $wpdb->get_results($sel_projeto,ARRAY_A);
		//var_dump($res_projeto);	
		for($k = 0; $k < count($res_projeto); $k++){
			$pro_json = json_decode(utf8_encode($res_projeto[$k]['descricao']),true);
			//var_dump($pro_json);
			if($pro_json['programa'] == $res_programa[$i]['id_tipo']){ ?>
			    {from: <?php echo $res_projeto[$k]['id_tipo'] ?> , to: <?php echo $res_programa[$i]['id_tipo']; ?>},
			
			<?php $id++;
				}
		}
	}		
	?>
    
    {from: 99, to: 99}
  ]);

  // create a network
  var container = document.getElementById('mynetwork');
  var data = {
    nodes: nodes,
    edges: edges
  };
  var options = {};
  var network = new vis.Network(container, data, options);
</script>
<?php 
break;
case 'culturaz':  

function chamaAPI($url,$data){
	$get_addr = $url.'?'.http_build_query($data);
	echo $get_addr;
	$ch = curl_init($get_addr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$page = curl_exec($ch);
	$evento = json_decode($page,true);
	return $evento;
	
}

	
	$data = array(
 	"@select" => "id,createTimestamp",
	"@order" => "createTimestamp DESC",
	"@limit" => 1
	//"owner" => "IN(870,105)",
	//"isVerified" => TRUE
	//"@order" => "id ASC"
	);
	
	
	$teste = chamaAPI("http://culturaz.santoandre.sp.gov.br/api/agent/find/",$data);
	
?>		  
<div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>CulturAZ</h1>
				</div>
        </div>

        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h2>Total de Agentes</h2>
					<?php 
					echo $teste[0]['id'];
					echo "<pre>";
					var_dump($teste);
					echo "</pre>";
					?>
				</div>
        </div>
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h2>Novos Agentes</h2>
				</div>
        </div>
</div>

<?php 
break;
case 'fip2018':  

/* 
+ Número de eventos (puxar projeto);
+ Número de agentes artistas 
+ Número de agentes artistas de Santo André
+ Divisão via gênero
+ Valores para contratação de artistas
+ Valores para contratação de infraestrutura
+ Eventos por linguagem (bartira)
+ Eventos por espaços (bartira)
+ Horas de programação




*/
$selecionados = array("on-1773097257","on-783829307","on-1761685716","on-352832","on-1453010115","on-1442268823","on-1566051262","on-1683241002","on-1714966032","on-118036985","on-743253080","on-1048183298","on-757466696","on-816928171","on-206463587","on-802625839","on-1577808338","on-1911167732","on-21575494","on-692984084","on-1619996948","on-597512233","on-238034968","on-1968119092","on-833444987","on-947680953","on-1738877893","on-1820229336","on-2052139008","on-1717118768","on-1400064695","on-275136340","on-764674688","on-81144614","on-1097209228","on-2083747890","on-772235373","on-1489454805","on-1064335160","on-575366804","on-199453234","on-1038431609","on-1386686453","on-998397921","on-1901353153","on-63316958","on-1093220644","on-31740023","on-467012070","on-1511533568","on-549538762","on-1542680140","on-1762919233","on-840918750","on-1579498570","on-144863959","on-998053853","on-1014304746","on-1873687417","on-2059946682","on-1637835576","on-1213339754","on-1790838746","on-1686202074","on-1335892498","on-700738777","on-924806377","on-2114852335");

$abc = array("SANTO ANDRE","SAO BERNARDO DO CAMPO","SAO CAETANO DO SUL", "DIADEMA", "MAUA","RIBEIRAO PIRES","RIO GRANDE DA SERRA");



?>	
         <h1>Festival de Inverno de 2018</h1>

          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
				<th width="15%"></th>
				<th></th>
     			</tr>
              </thead>
              <tbody>
			  <tr><td colspan='2'><h3>Processo de Seleção</h3><td></tr>
				<tr>
				<td>Número de Inscrições no Chamamento</td>
				<td><?php 
				$sql_n_inscricoes = "SELECT id FROM ava_inscricao WHERE id_mapas = '349'";
				$x = $wpdb->get_results($sql_n_inscricoes);
				$sql_n_inscricoes_2017 = "SELECT id FROM ava_inscricao WHERE id_mapas = '185'";
				$y = $wpdb->get_results($sql_n_inscricoes_2017);
				$aumento = (count($x)/count($y))*100;
				
				
				echo "2018: ".count($x)." / 2017: ".count($y)." / aumento de ".dinheiroParaBr($aumento)."%"; 
				
				
				?></td>
				</tr>
				<tr>
				<td>Número de Agentes Inscritos no Chamamento</td>
				<td><?php 
				$sql_n_agentes = "SELECT DISTINCT id_agente FROM ava_inscricao WHERE id_mapas = '349'";
				$x = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($x);
			
				
				?></td>
				</tr>
				<tr>
				<td>Inscritos por cidade</td>
				<td><?php
					$sql_cidades = "SELECT DISTINCT cidade FROM ava_inscricao WHERE id_mapas = '349' ORDER BY cidade";
					$cidades = $wpdb->get_results($sql_cidades,ARRAY_A);
					for($i = 0; $i < count($cidades); $i++){
						$city = $cidades[$i]['cidade'];

						$sql_sel_city = "SELECT id FROM ava_inscricao WHERE id_mapas = '349' AND cidade = '$city'";
						$n_city = $wpdb->get_results($sql_sel_city);
						if($city == "" ){
							$city = "OUTROS";
						}
						echo $city."( ".count($n_city)." ), ";
		
	}

				?></td>
				</tr>
				<td>Selecionados por cidade</td>
				<td><?php
				echo count($selecionados)." selecionados.<br />" ;	
				$n_abc = 0;
				
				$sql_cidades = "SELECT DISTINCT cidade FROM ava_inscricao WHERE id_mapas = '349' ORDER BY cidade";
				$cidades = $wpdb->get_results($sql_cidades,ARRAY_A);
				for($i = 0; $i < count($cidades); $i++){
					$city = $cidades[$i]['cidade'];

					$sql_sel_city = "SELECT inscricao FROM ava_inscricao WHERE id_mapas = '349' AND cidade = '$city'";
					$inscricao = $wpdb->get_results($sql_sel_city,ARRAY_A);
					$n = 0;
					for($k = 0; $k < count($inscricao); $k++){
						if(in_array($inscricao[$k]['inscricao'],$selecionados)){
							$n++;
							if(in_array($city,$abc)){
								$n_abc++;
							}
					}

					}
					if($city == "" ){
						$city = "OUTROS";
					}
					
					if($n != 0){
						echo $city."( ".($n)." ), ";
					}
					//$n_abc = $n_abc + $n;
				}
				
				//echo $n_abc."<br />";
				$porc = ($n_abc/count($selecionados))*100;
				
				echo "<br />% de selecionados do ABC: ".round($porc)."%";
				
				
				
				?></td>
				</tr>
			  <tr><td colspan='2'><h3>Programação</h3><td></tr>
				<tr>
				<td>Número de Eventos</td>
				<td>
				<?php 
				$sql_n_eventos_publicados = "SELECT idEvento FROM sc_evento WHERE idProjeto = '91' AND publicado = '1' AND dataEnvio IS NOT NULL";
				$x = $wpdb->get_results($sql_n_eventos_publicados);
				$sql_n_eventos_n_publicados = "SELECT idEvento FROM sc_evento WHERE idProjeto = '91' AND publicado = '1'";
				$y = $wpdb->get_results($sql_n_eventos_n_publicados);
				echo "Eventos planejados: ".count($y)." / Eventos Publicados: ".count($x);			
				?>
				</td>
				</tr>

				<tr>
				<td>Eventos</td>
				<td><?php
				$sql_n_eventos_n_publicados = "SELECT nomeEvento FROM sc_evento WHERE idProjeto = '91' AND publicado = '1' ORDER BY nomeEvento ";
				$y = $wpdb->get_results($sql_n_eventos_n_publicados,ARRAY_A);				
				for($i = 0; $i < count($y); $i++){
					echo $y[$i]['nomeEvento']."<br />";
				}

				?>
				</td>
				</tr>
				<tr>
				<td>Eventos por Linguagem</td>
				<td>
				<?php 
				$sql_linguagem = "SELECT DISTINCT idTipo FROM sc_evento WHERE idProjeto = '91'";
				$x = $wpdb->get_results($sql_linguagem, ARRAY_A);
				for($i = 0; $i < count($x); $i++){
					$tipo = $x[$i]['idTipo'];
					$linguagem = tipo($tipo);
					$sql_conta = "SELECT idEvento FROM sc_evento WHERE idTipo = '$tipo' AND idProjeto = '91'";
					$y = $wpdb->get_results($sql_conta,ARRAY_A);
					
				echo $linguagem['tipo']."(".count($y)."), ";
					
					
				}
				
				
				?>
				</td>
				</tr>
								<tr>
				<td>Eventos por Espaço</td>
				
				<td>
				<?php 
				$sql_espaco = "SELECT DISTINCT local FROM sc_ocorrencia WHERE idEvento IN(SELECT idEvento FROM sc_evento WHERE idProjeto = '91' AND publicado = '1' )";
				$x = $wpdb->get_results($sql_espaco,ARRAY_A);
				for($i = 0; $i < count($x); $i++){
					$local = tipo($x[$i]['local']);
					$sql_local = "SELECT local FROM sc_ocorrencia WHERE local = '".$x[$i]['local']."' AND idEvento IN(SELECT idEvento FROM sc_evento WHERE idProjeto = '91' AND publicado = '1' )";
					$y = $wpdb->get_results($sql_local);
					
					
					
					echo $local['tipo']."(".count($y)."), ";		
				}
				
				?>
				
				
				</td>
				</tr>
								<tr>
				<td>Horas de atividade concomitantes</td>
				<td>
				<?php 
				$minutos = 0;
				$sql_evento = "SELECT idEvento FROM sc_evento WHERE idProjeto = '91' AND publicado = '1'";
				$x = $wpdb->get_results($sql_evento,ARRAY_A);
				for($i = 0; $i < count($x); $i++){
					$t = diasEfetivos($x[$i]['idEvento']);
					$minutos = $minutos + $t['minutos'];
				//echo $i." ".$x[$i]['idEvento']."-";
				//var_dump($t);	
				}
				
				echo round($minutos/60) ." horas";
				
				?>
				
				
				</td>
				</tr>
				<tr>
				<td>Orçamento Executado</td>
				<td>
				<?php 
				$sql_orc = "SELECT valor FROM sc_contratacao WHERE idEvento IN(SELECT idEvento FROM sc_evento WHERE idProjeto = '91' AND publicado = '1') AND publicado = 1";
				$orc_exec = $wpdb->get_results($sql_orc,ARRAY_A);
				$total_art = 0;
				for($i = 0; $i < count($orc_exec); $i++){
					$total_art = $total_art + $orc_exec[$i]['valor'];
				}
				
				$sql_infra = "SELECT valor FROM sc_contratacao WHERE idAtividade IN(SELECT id FROM sc_atividade WHERE idProjeto = '91' AND publicado = '1') AND publicado = 1";
				$orc_infra = $wpdb->get_results($sql_infra,ARRAY_A);
				$total_infra = 0;
				for($i = 0; $i < count($orc_infra); $i++){
					$total_infra = $total_infra + $orc_infra[$i]['valor'];
				}					
				
				echo "Total de Contratações Artísticas: ".dinheiroParaBr($total_art)." <br />";				
				echo "Total de Infraestrutura e Serviços: ".dinheiroParaBr($total_infra)." <br />";
				echo "Total Geral: ".dinheiroParaBr($total_art+$total_infra);
				

				?>
				
				</td>
				<td></td>
				</tr>
				<tr>
				<td>Orçamento Executado por dotação </td>
				<td>
				<?php 
				$sql_dot = "SELECT DISTINCT dotacao FROM sc_contratacao WHERE publicado = '1' AND (idEvento IN(SELECT idEvento FROM sc_evento WHERE idProjeto = '91' AND publicado = '1') OR idAtividade IN(SELECT id FROM sc_atividade WHERE idProjeto = '91' AND publicado = '1'))";				
				$dot = $wpdb->get_results($sql_dot,ARRAY_A);
				for($i = 0; $i < count($dot); $i++){
					$total = 0;;		
					$sql_titulo = "SELECT descricao, projeto, ficha FROM sc_orcamento WHERE id = '".$dot[$i]['dotacao']."'";
					$y = $wpdb->get_row($sql_titulo,ARRAY_A);
					$sql_soma = "SELECT valor FROM sc_contratacao WHERE publicado = '1' AND (idEvento IN(SELECT idEvento FROM sc_evento WHERE idProjeto = '91' AND publicado = '1') OR idAtividade IN(SELECT id FROM sc_atividade WHERE idProjeto = '91' AND publicado = '1')) AND dotacao = '".$dot[$i]['dotacao']."'";
					$soma = $wpdb->get_results($sql_soma,ARRAY_A);
					for ($k = 0; $k < count($soma); $k++){
						$total = $total + $soma[$k]['valor'];
						
					}
					
					echo $y['descricao']." (".$y['projeto']."/".$y['ficha'].") = ".dinheiroParaBr($total)."<br />";
					
				}
				
				
				?>
				
				
				
				</td>

				</tr>				
				<tr>
				<td>Orçamento Executado por linguagem </td>
				<td></td>

				</tr>				

				</tbody>
            </table>
          </div> 
		  
<?php 
break;
case 'territorios':  

/* 
+ Número de eventos (puxar projeto);
+ Número de agentes artistas 
+ Número de agentes artistas de Santo André
+ Divisão via gênero
+ Valores para contratação de artistas
+ Valores para contratação de infraestrutura
+ Eventos por linguagem (bartira)
+ Eventos por espaços (bartira)
+ Horas de programação




*/
$selecionados = array("on-1773097257","on-783829307","on-1761685716","on-352832","on-1453010115","on-1442268823","on-1566051262","on-1683241002","on-1714966032","on-118036985","on-743253080","on-1048183298","on-757466696","on-816928171","on-206463587","on-802625839","on-1577808338","on-1911167732","on-21575494","on-692984084","on-1619996948","on-597512233","on-238034968","on-1968119092","on-833444987","on-947680953","on-1738877893","on-1820229336","on-2052139008","on-1717118768","on-1400064695","on-275136340","on-764674688","on-81144614","on-1097209228","on-2083747890","on-772235373","on-1489454805","on-1064335160","on-575366804","on-199453234","on-1038431609","on-1386686453","on-998397921","on-1901353153","on-63316958","on-1093220644","on-31740023","on-467012070","on-1511533568","on-549538762","on-1542680140","on-1762919233","on-840918750","on-1579498570","on-144863959","on-998053853","on-1014304746","on-1873687417","on-2059946682","on-1637835576","on-1213339754","on-1790838746","on-1686202074","on-1335892498","on-700738777","on-924806377","on-2114852335");

$abc = array("SANTO ANDRE","SAO BERNARDO DO CAMPO","SAO CAETANO DO SUL", "DIADEMA", "MAUA","RIBEIRAO PIRES","RIO GRANDE DA SERRA");



?>	
         <h1>Territórios de Cultura</h1>

          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
				<th width="15%"></th>
				<th width='30%'>2017</th>
				<th width='30%'>2018</th>
				<th width='20%'>Obs</th>
     			</tr>
              </thead>
              <tbody>
				<tr>
				<td>Número de Inscrições no Chamamento</td>
				<td><?php 
				$sql_n_inscricoes = "SELECT id FROM ava_inscricao WHERE id_mapas = '156'";
				$x = $wpdb->get_results($sql_n_inscricoes);
				$sql_n_inscricoes_2018 = "SELECT id FROM ava_inscricao WHERE id_mapas = '286'";
				$y = $wpdb->get_results($sql_n_inscricoes_2018);
				$aumento = (count($x)/count($y))*100;
				
				
				echo count($x);
				?>
				</td>		
				<td>
				<?php echo count($y); ?>

				</td>
				<td>Aumento de <?php echo $aumento; ?>%</td>
				</tr>
				<tr>
				<td>Número de Agentes Inscritos no Chamamento</td>
				<td><?php 
				$sql_n_agentes = "SELECT DISTINCT id_agente FROM ava_inscricao WHERE id_mapas = '156'";
				$x = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($x);
			
				
				?></td>
				<td><?php 
				$sql_n_agentes = "SELECT DISTINCT id_agente FROM ava_inscricao WHERE id_mapas = '286'";
				$y = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($y);
				
				?>
				</td>
				<td>Aumento de <?php echo $aumento; ?>%</td>
				</tr>
				<tr>
				<td>Inscritos por cidade</td>
				<td><?php
					$sql_cidades = "SELECT DISTINCT cidade FROM ava_inscricao WHERE id_mapas = '156' ORDER BY cidade";
					$cidades = $wpdb->get_results($sql_cidades,ARRAY_A);
					for($i = 0; $i < count($cidades); $i++){
						$city = $cidades[$i]['cidade'];

						$sql_sel_city = "SELECT id FROM ava_inscricao WHERE id_mapas = '156' AND cidade = '$city'";
						$n_city = $wpdb->get_results($sql_sel_city);
						if($city == "" ){
							$city = "OUTROS";
						}
						echo $city."( ".count($n_city)." ), ";
		
	}

				?></td>
				<td><?php
					$sql_cidades = "SELECT DISTINCT cidade FROM ava_inscricao WHERE id_mapas = '286' ORDER BY cidade";
					$cidades = $wpdb->get_results($sql_cidades,ARRAY_A);
					for($i = 0; $i < count($cidades); $i++){
						$city = $cidades[$i]['cidade'];

						$sql_sel_city = "SELECT id FROM ava_inscricao WHERE id_mapas = '286' AND cidade = '$city'";
						$n_city = $wpdb->get_results($sql_sel_city);
						if($city == "" ){
							$city = "OUTROS";
						}
						echo $city."( ".count($n_city)." ), ";
		
	}

				?></td>
				</tr>
				<td>Selecionados por cidade</td>
				<td><?php
				$sql_sel = "SELECT inscricao FROM ava_inscricao WHERE aprovado = '1' AND id_mapas = '156'";
				$sel = $wpdb->get_results($sql_sel,ARRAY_A);
				$selecionados = array();
				for($g = 0; $g < count($sel); $g++){
					array_push($selecionados,$sel[$g]['inscricao']);
				}
				echo count($selecionados)." selecionados.<br />" ;	
				$n_abc = 0;
				
				$sql_cidades = "SELECT DISTINCT cidade FROM ava_inscricao WHERE id_mapas = '156' ORDER BY cidade";
				$cidades = $wpdb->get_results($sql_cidades,ARRAY_A);
				for($i = 0; $i < count($cidades); $i++){
					$city = $cidades[$i]['cidade'];

					$sql_sel_city = "SELECT inscricao FROM ava_inscricao WHERE id_mapas = '156' AND cidade = '$city'";
					$inscricao = $wpdb->get_results($sql_sel_city,ARRAY_A);
					$n = 0;
					for($k = 0; $k < count($inscricao); $k++){
						if(in_array($inscricao[$k]['inscricao'],$selecionados)){
							$n++;
							if(in_array($city,$abc)){
								$n_abc++;
							}
					}

					}
					if($city == "" ){
						$city = "OUTROS";
					}
					
					if($n != 0){
						echo $city."( ".($n)." ), ";
					}
					//$n_abc = $n_abc + $n;
				}
				
				//echo $n_abc."<br />";
				$porc = ($n_abc/count($selecionados))*100;
				
				echo "<br />% de selecionados do ABC: ".round($porc)."%";
				
				
				
				?></td>
				<td><?php
				$sql_sel = "SELECT inscricao FROM ava_inscricao WHERE aprovado = '1' AND id_mapas = '286'";
				$sel = $wpdb->get_results($sql_sel,ARRAY_A);
				$selecionados = array();
				for($g = 0; $g < count($sel); $g++){
					array_push($selecionados,$sel[$g]['inscricao']);
				}
				echo count($selecionados)." selecionados.<br />" ;	
				$n_abc = 0;
				
				$sql_cidades = "SELECT DISTINCT cidade FROM ava_inscricao WHERE id_mapas = '286' ORDER BY cidade";
				$cidades = $wpdb->get_results($sql_cidades,ARRAY_A);
				for($i = 0; $i < count($cidades); $i++){
					$city = $cidades[$i]['cidade'];

					$sql_sel_city = "SELECT inscricao FROM ava_inscricao WHERE id_mapas = '286' AND cidade = '$city'";
					$inscricao = $wpdb->get_results($sql_sel_city,ARRAY_A);
					$n = 0;
					for($k = 0; $k < count($inscricao); $k++){
						if(in_array($inscricao[$k]['inscricao'],$selecionados)){
							$n++;
							if(in_array($city,$abc)){
								$n_abc++;
							}
					}

					}
					if($city == "" ){
						$city = "OUTROS";
					}
					
					if($n != 0){
						echo $city."( ".($n)." ), ";
					}
					//$n_abc = $n_abc + $n;
				}
				
				//echo $n_abc."<br />";
				$porc = ($n_abc/count($selecionados))*100;
				
				echo "<br />% de selecionados do ABC: ".round($porc)."%";
				
				
				
				?></td>				
				</tr>
<tr>
<td>Gênero dos Inscritos</td>
<td><?php 
				$sql_n_agentes = "SELECT id FROM ava_inscricao WHERE id_mapas = '156' AND genero = 'Mulher'";
				$x = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($x)." mulheres / ";
				$sql_n_agentes = "SELECT id FROM ava_inscricao WHERE id_mapas = '156' AND genero = 'Homem'";
				$y = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($y). " homens / ";
				$sql_n_agentes = "SELECT id FROM ava_inscricao WHERE id_mapas = '156' AND genero <> 'Homem' AND genero <> 'Mulher'";
				$w = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($w). " outras";
			
				
				?></td>
				<td><?php 
				$sql_n_agentes = "SELECT id FROM ava_inscricao WHERE id_mapas = '286' AND genero = 'Mulher'";
				$x = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($x)." mulheres / ";
				$sql_n_agentes = "SELECT id FROM ava_inscricao WHERE id_mapas = '286' AND genero = 'Homem'";
				$y = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($y). " homens / ";
				$sql_n_agentes = "SELECT id FROM ava_inscricao WHERE id_mapas = '286' AND genero <> 'Homem' AND genero <> 'Mulher'";
				$w = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($w). " outras";
				
				?>
				</td>
				
				</tr>
<tr>
<td>Gênero dos Selecionados</td>
<td><?php
				$sql_n_agentes = "SELECT id FROM ava_inscricao WHERE id_mapas = '156' AND genero = 'Mulher' AND aprovado = '1'";
				$x = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($x)." mulheres / ";
				$sql_n_agentes = "SELECT id FROM ava_inscricao WHERE id_mapas = '156' AND genero = 'Homem' AND aprovado = '1'";
				$y = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($y). " homens / ";
				$sql_n_agentes = "SELECT id FROM ava_inscricao WHERE id_mapas = '156' AND genero <> 'Homem' AND genero <> 'Mulher' AND aprovado = '1'";
				$w = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($w). " outras";
			
				
				?></td>
				<td><?php 
				$sql_n_agentes = "SELECT id FROM ava_inscricao WHERE id_mapas = '286' AND genero = 'Mulher' AND aprovado = '1'";
				$x = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($x)." mulheres / ";
				$sql_n_agentes = "SELECT id FROM ava_inscricao WHERE id_mapas = '286' AND genero = 'Homem' AND aprovado = '1'";
				$y = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($y). " homens / ";
				$sql_n_agentes = "SELECT id FROM ava_inscricao WHERE id_mapas = '286' AND genero <> 'Homem' AND genero <> 'Mulher' AND aprovado = '1'";
				$w = $wpdb->get_results($sql_n_agentes,ARRAY_A);
				echo count($w). " outras";
				
				?>
				</td>
				
				</tr>
				<tr>
				<td>Número de Agentes que se inscreveram novamente</td>
				<td></td>
				<td>
				<?php 
				$sql = "SELECT DISTINCT id_agente FROM ava_inscricao WHERE id_mapas = '286' AND id_agente IN(SELECT DISTINCT id_agente FROM ava_inscricao WHERE id_mapas = '156')";
				$x = $wpdb->get_results($sql);
				echo count($x);
				
				?>
				
				</td>
				<td></td>
				
				</tr>
				
				</tbody>
            </table>
          </div> 		  
		  
<?php 
break;
case 'quantitativo':  
?>	
<div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Quantitativo</h1>
				</div>
        </div>

        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h2>Empresas</h2>
					<?php 
					$sql = "SELECT idPedidoContratacao,idPessoa FROM sc_contratacao WHERE (sc_evento.idEvento = sc_contratacao.idEvento) AND (sc_evento.publicado = '1') AND tipoPessoa = '2' GROUP BY idPessoa";
					?>
				</div>
        </div>
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h2>Novos Agentes</h2>
				</div>
        </div>
</div>

		
<?php 
//break;
//case '':  
?>		  
<!--
					 <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Não há Edital indicado</h1>
				</div>
        </div>
		</div>
-->
<?php 
break;
}//fim da switch
?>		  
		  
        </main>
      </div>
    </div>
	
<?php 
include "footer.php";
?>