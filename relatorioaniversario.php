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

.pieChart{
	float: right;
	
	
}
</style>
<h1>CONVOCATÓRIA NO. 005/2017 
Aniversário da Cidade 2018
</h1>
<h2>Relação de intervenções selecionadas</h2>
<p>A Secretaria de Cultura de Santo André divulga abaixo a lista de classificação por categoria das propostas culturais selecionadas para compor o quadro de possíveis atrações que se apresentarão na programação do Aniversário da Cidade 2018.</p><p> 
A Secretaria de Cultura oportunamente entrará em contato com os selecionados, para solicitação de documentação complementar, item fundamental para efetivar a contratação. </p><p>
As contratações serão realizadas de acordo com as necessidades da grade de programação e no limite orçamentário do programa “Aniversário da Cidade 2018”. </p><p>
Terão prioridade de contratação as propostas cuja ação se apoie na história, patrimônio, memória e ou imaginário da Vila de Paranapiacaba, conforme disposto nas diretrizes que nortearam a presente  Convocatória. 
A Secretaria de Cultura esclarece ainda esta seleção contou com 226 propostas de intervenções culturais inscritas, cujas inscrições ocorreram entre 06/11 a 22/12/17. As propostas inscritas foram analisadas por uma Comissão de seleção composta pelos seguintes membros:</p><p>

-04 representantes da sociedade civil indicados pelo Conselho Municipal de Políticas Culturais Comissão de seleção</p><p>
•	Kleber Fernando de Albuquerque</p><p>
•	Rosana Banharoli</p><p>
•	Sergio Luis Zanchetta</p><p>
•	Tales Andre Loro Jaloretto</p><p>
- 04 representantes do poder público indicados pela Secretaria de Cultura. </p><p>
•	Luciana  Zorzato </p><p>
•	Kedley Correa de Moraes </p><p>
•	Miguel Gondim de Castro</p><p>
•	Milton Toller Correia</p><p>
Informamos ainda que todos os inscritos integrarão um banco de dados específico que terá validade até 31/dezembro/2018.
</p>
<div>


			  <?php 
			// Seleciona as categorias
			$sql_cat = "SELECT DISTINCT filtro FROM ava_ranking ORDER BY filtro ASC";
			$res_cat = $wpdb->get_results($sql_cat,ARRAY_A);

			for($i = 0; $i < count($res_cat); $i++){
				$filtro = $res_cat[$i]['filtro'];
				?>

				<h2><?php echo $filtro; ?></h2>
				<table border= "1" class="table table-striped">
				 <thead>
					<tr>
					<th>Proposta</th>
					<th>Inscrição</th>
					<th>Proponente</th>
					<th>Nota01</th>
					<th>Nota02</th>
					<th>Média</th>
					<th>Coletiva</th>
					<th>Final</th>
					<th>Obs</th>	
					</tr>
				  </thead>
				 <tbody>
				
				<?php 
					$sql_ins = "SELECT inscricao,nota FROM ava_ranking WHERE filtro = '$filtro' ORDER BY nota DESC";
					$res_ins = $wpdb->get_results($sql_ins,ARRAY_A);

					for($k = 0; $k < count($res_ins); $k++){		
						$inscricao = $res_ins[$k]['inscricao'];
						$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$inscricao'";	
						$json = $wpdb->get_row($sel,ARRAY_A);	
						$res_json = converterObjParaArray(json_decode(($json['descricao'])));
						$nota = nota($inscricao);						
					?>
						
					<tr>
					<td><?php echo $res_json['3.1 - Título']; ?></td>
					<td><?php echo $inscricao; ?></td>
					<td><?php echo $res_json['Agente responsável pela inscrição']; ?></td>
					<td><?php if(isset($nota['pareceristas'][0])){echo $nota['pareceristas'][0]['nota'];}?></td>
					<td><?php if(isset($nota['pareceristas'][1])){echo $nota['pareceristas'][1]['nota'];}?></td>
					<td><?php if(isset($nota['media'])){echo $nota['media'];}?></td>
					<td><?php echo retornaNota2Fase($inscricao); ?></td>
					<td><?php echo $res_ins[$k]['nota']; ?></td>
					<td><?php echo retornaAnotacao($inscricao,16,'274'); ?></td>
					</tr>			  

				<?php 
					}
				?>	
					
				</tbody>
				</table>			
				<?php			
				
			}
			
			
			
			?>
			  
			  

</div>
