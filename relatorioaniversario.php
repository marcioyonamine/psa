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
<h1>CONVOCATÓRIA NO. 005/2017</h1>
<h2>Aniversário da Cidade 2018</h2>
 
 
<h3>Relação de intervenções selecionadas</h3>
 
<p>A Secretaria de Cultura de Santo André divulga abaixo a lista de classificação por categoria das propostas culturais selecionadas para compor o quadro de possíveis atrações que se apresentarão na programação do Aniversário da Cidade 2018.</p>
<p>A Secretaria de Cultura oportunamente entrará em contato com os selecionados, para solicitação de documentação complementar, item fundamental para efetivar a contratação.
As contratações serão realizadas de acordo com as necessidades da grade de programação e no limite orçamentário do programa “Aniversário da Cidade 2018”.</p>
<p>Terão prioridade de contratação as propostas cuja ação se apoie na história, patrimônio, memória e ou imaginário da Vila de Paranapiacaba, conforme disposto nas diretrizes que nortearam a presente Convocatória. A Secretaria de Cultura esclarece ainda esta seleção contou com 226 propostas de intervenções culturais inscritas, cujas inscrições ocorreram entre 06/11 a 22/12/17. As propostas inscritas foram analisadas por uma Comissão de seleção composta pelos seguintes membros:</p>
<ul>-04 representantes da sociedade civil indicados pelo Conselho Municipal de Políticas Culturais Comissão de seleção
<li>• Kleber Fernando de Albuquerque</li>
<li>• Rosana Banharoli</li>
<li>• Sergio Luis Zanchetta</li>
<li>• Tales Andre Loro Jaloretto</li>
</ul>
<ul>
- 04 representantes do poder público indicados pela Secretaria de Cultura.
<li>• Luciana Zorzato</li>
<li>• Kedley Correa de Moraes</li>
<li>• Miguel Gondim de Castro</li>
<li>• Milton Toller Correia</li>
</ul>
<p>Em consenso os membros da Comissão de Seleção estabeleceram os seguintes critérios que nortearam a análise das propostas:</p>
<ul>
<li>·         Representatividade do proponente em relação à linguagem/ segmento ao qual pertence; </li>
<li>·         Priorização de grupos e artistas locais e da região;</li>
<li>·         Diversidade de linguagens/ segmentos das propostas inscritas;</li>
<li>·         Evitar na medida do possível,  repetição de proponentes que participaram através de contratações de projetos pela Secretaria de Cultura no último exercício.</li>
</ul>

<p>A somatória dos valores propostas pelas intervenções selecionadas totaliza <strong>R$ 144.000,00</strong>.</p>
<p>Informamos ainda que todos os inscritos integrarão um banco de dados específico que terá validade até 31/dezembro/2018.</p>
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
					<td><?php if(isset($nota['media'])){echo substr($nota['media'], 0, 4);}?></td>
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
