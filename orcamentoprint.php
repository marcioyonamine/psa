<?php 
require_once("../wp-load.php");
$user = wp_get_current_user();
if(!is_user_logged_in()): // Impede acesso de pessoas não autorizadas
      /*** REMEMBER THE PAGE TO RETURN TO ONCE LOGGED IN ***/
	  $_SESSION["return_to"] = $_SERVER['REQUEST_URI'];
      /*** REDIRECT TO LOGIN PAGE ***/
	  header("location: /");
endif;
//Carrega os arquivos de funções
require "inc/function.php";
$orcamento = orcamentoTotal(2018);
$projeto = array();
$w = 0;
?>
<style>
body{
	font-size:10px;
}
.pieChart{
	float: right;
	
	
}
</style>
<div>
            <table border= "1" class="table table-striped">
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
				<td><?php echo dinheiroParaBr($orcamento['total'] - $orcamento['planejado'] ); ?></td>

				</tr>				
				</tbody>
            </table>
          </div> 
		  </div>
<div id="pieChart" align="center"></div>
		
		
		
          <div class="table-responsive">
            <table border= "1" class="table table-striped">
              <thead>
                <tr>
				<th width="25%">Programa</th>
				<th>Projeto</th>
				<th>Valor</th>
				<th width="30%">Nota</th>
				<th>Responsável</th>
				<th>Projeto/Ficha</th>
				<th width="15%">Descrição</th>

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
									<td><?php 
									if($pro_json['responsavel'] != NULL){
										$pro_json['responsavel'];
										$userwp = get_userdata($pro_json['responsavel']);
										if($userwp){
										echo $userwp->first_name."".$userwp->last_name; //var_dump($orc); 
										}
									}
									?></td>				
				<td><?php  if(isset($orc['projeto'])){echo $orc['projeto']; } ?> / <?php if(isset($orc['ficha'])){echo $orc['ficha'];} ?></td>				
				<td><?php  if(isset($orc['descricao'])){echo $orc['descricao']; } ?></td>				

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
				<td height="50px" colspan="7"></td>


				</tr>
				<?php 
				}


				?>

				</tbody>
            </table>
		<?php for ($i = 0; $i < count($programa); $i++){ ?>
			
				<p>"label": "<?php echo $programa[$i]['programa']?>",
				"value": <?php echo $programa[$i]['valor'] ?></p>
			
		<?php } ?>
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
		"canvasWidth": 900,
		"pieOuterRadius": "70%"
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


