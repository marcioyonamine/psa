<?php 

//Carrega WP como FW
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

if(!isset($_GET['id']) OR !isset($_GET['modelo'])){
	echo "<h1>Erro.</h1>";
	
}else{
	$pedido = retornaPedido($_GET['id']);
	//var_dump($pedido);
	
	
	
	
	switch ($_GET['modelo']){
	case 303: // Folha de Rosto	
	
		$file_name='folha_de_rosto.doc';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/force-download');
		header('Content-type: application/vnd.ms-word');
		header('Content-Type: application/download');
		header('Content-Disposition: attachment;filename='.$file_name);
		header('Content-Transfer-Encoding: binary ');

			?>
		<html>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
		<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
		</style>
		<br /><br /><br /> 
		<p class="style_01">À <br />
		Encarregatura de Protocolo <br />
		Sr. Encarregado</p>
		<br />
		<br />
		<br />
		
		<p class="paragrafo">Solicitamos a abertura de processo administrativo com os seguintes dados:</p>

		<br /><br />
		<p>Interessado: <?php echo $pedido['area']." - ".$pedido['cr']; ?></p>

		<br />
		<br />
		<br />
		<p>Assunto: Dispensa de Licitação - contratação da <?php echo $pedido['tipoPessoa']; ?> <b><?php echo $pedido['nome_razaosocial']  ?> </b> para representar <b><?php echo $pedido['nome_razaosocial']  ?> </b> no evento "<b><?php echo $pedido['objeto'] ?></b>" que fará parte da programação cultural da Secretaria de Cultura.</p>

		<br />
		<br />
		<br />

		<p>Atenciosamente,</p>
				<br />
		<br />
		<br />
		<center>
		<p>Santo André, <?php 
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		echo strftime('%A, %d de %B de %Y', strtotime('today'));
		
		?>. </center></p>
		
		<br /><br />
		
		<br /><br />
		
		<p><center><?php echo $pedido['usuario']; ?><br />
		<?php echo $pedido['cargo']; ?>	
		</p></center>
		
		<br /><br />
		
		<br /><br />
		
		<p class="rodape">------------------------------------------------------------</p>
		<p class="rodape">Secretaria de Cultura - <?php echo $pedido['area']; ?> <br />
		Praça IV Centenário, 02 - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, <br /> 
		Telefone (11) 4433-0711/ 4433-0632 / email: musica@santoandre.sp.gov.br</p>
		
		
		
		
		
		
		
		
	<?php 
	break;	
	case 563: // Folha de Rosto	FIP
	
		$file_name='folha_de_rosto.doc';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/force-download');
		header('Content-type: application/vnd.ms-word');
		header('Content-Type: application/download');
		header('Content-Disposition: attachment;filename='.$file_name);
		header('Content-Transfer-Encoding: binary ');

			?>
		<html>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
		<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
		</style>
		<br /><br /><br /> 
		<p class="style_01">À <br />
		Encarregatura de Protocolo <br />
		Sr. Encarregado</p>
		<br />
		<br />
		<br />
		
		<p class="paragrafo">Solicitamos a abertura de processo administrativo com os seguintes dados:</p>

		<br /><br />
		<p>Interessado: (Nome do Setor Gerencia ou Encarregatura) -  CR (do setor)_

		<br />
		<br />
		<br />
		<p>Assunto: Inexigibilidade - contratação da <?php echo $pedido['tipoPessoa']; ?> <b><?php echo $pedido['nome_razaosocial']  ?> </b> para representar <b><?php if($pedido['integrantes'] == ""){ echo "(colocar o nome do artista)";}else{ echo $pedido['integrantes']; } ?> </b> para programação do XVIII Festival de Inverno de Paranapiacaba.

		<br />
		<br />
		<br />

		<p>Atenciosamente,</p>
				<br />
		<br />
		<br />
		<center>
		<p>Santo André, <?php 

		
		?>. </center></p>
		
		<br /><br />
		
		<br /><br />
		
		<p><center>_______________________________________<br />
		(Nome do Funcionário que abre o processo)<br />
		(Cargo do Funcionário que abre o processo)<br />
		IF-_______________________
		</p></center>
		
		<br /><br />
		
		<br /><br />
		
		<p class="rodape">------------------------------------------------------------</p>
		<p class="rodape">Secretaria de Cultura - Departamento de Planejamento e Projetos Especiais <br />
		Praça IV Centenário, 02 - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, <br /> 
		Telefone 4433-0421 / email: (email do funcionário)</p>
		
		
		
		
		
		
		
		
	<?php 
	break;	


	case 304: // OS	
	
	?>
	<!-- CSS para impressão -->
	
	
	
	<link rel="stylesheet" type="text/css" href="print.css" media="print" />

	
	
	
	<table  width="100%" border="1">
	<tr>
	<td rowspan="5" width="15%"><center><img src="images/logo.png" /></center></td>
	
	</tr>
	<tr>
	<td colspan="2"><center><b>Prefeitura Municipal de Santo André</b></center></td>
	</tr>
	<tr>
	<td colspan="2"><center><b>Solicitação de Serviços</b></center></td>
	</tr>	
		<tr>
		<td><center>Data da Emissão<br /><b><?php echo date("d/m/Y")?></b></center></td>
	<td><center>CR Requisitante<br /></center><b><?php echo $pedido['cr']; ?></b></td>

	</tr>
	<tr>
	<td colspan="3"><center><b>Nome da área requisitante: Secretaria de Cultura - <?php echo $pedido['area']; ?></b></center></td>
	<tr/>	
	</table>
	<table border="1">
	<tr>
	<td colspan="4"><center><b>Dotação orçamentária</b></center></td>

	</tr>

	<tr>
	<td>Cód. Dotação:<br /><b><?php echo resumoDotacao($pedido['cod_dotacao']); ?></b></td>
	<td>Projeto:<br /><b><?php echo $pedido['projeto']; ?><b/></td>
	<td>Ficha: <br /> <b><?php echo $pedido['ficha']; ?></b></td>
	<td>Sub-elemente Despesa: <br /><center>22</center></td>	
	</tr>
	</tr>
	<tr>
	<td colspan="3">Cód. Vinculação de Despesa<br /><center>110.000</center></td>
	<td>Fonte de Recursos: <br /><center>  <?php echo $pedido['fonte']; ?></center></td>
	</tr>
	<tr>
	<td colspan="3">Nome do Contato <br /><?php echo $pedido['usuario']; ?></td>
	<td>Telefone Contato<br /><?php echo $pedido['telefone']; ?></td>
	</tr>
	<tr><td colspan="4">Conta corrente codReduzido/DB<br /><center>252</center></td></tr>	
	<tr>
	<td colspan="4">Data Período do evento: <br /><?php echo $pedido['periodo']; ?></td>
	</tr>	
	<tr>
	<td colspan="4">Local de aplicação do serviço ou evento:<br /><?php echo $pedido['local']; ?></td>
	</tr>
	<tr>
	<td colspan="4">Especificação (a maior quantidade necessária de informações para a correta contratação)</td>
	</tr>
	<tr>
	<td colspan="4">	<p>Contratação de <?php echo $pedido['tipoPessoa']; ?> <b><?php echo $pedido['nome_razaosocial']  ?></b>, representando com exclusividade a(s) apresentação(ões) do(s) seguinte(s) artista(s) <b><?php  echo $pedido['integrantes'] ?></b> para  realização de <?php echo $pedido['objeto']; ?> em <?php echo $pedido['local']; ?> no(s) dia(s)  <?php echo $pedido['periodo']; ?> </b></p>
		<p>Empresa: <?php echo $pedido['nome_razaosocial']  ?><br />
	CNPJ: <?php echo $pedido['cpf_cnpj']  ?><br />
	Endereço: <?php echo $pedido['end']  ?><br />
	Email: <?php echo $pedido['email'];?> <br />
	<p>Valor total: R$<?php echo $pedido['valor'];?> (<?php echo $pedido['valor_extenso']; ?>)</p>
	
	<p><b>Forma de pagamento:</b> <?php echo $pedido['forma_pagamento'];?> </p>
	<p><?php echo $pedido['banco'];?> </p>		

	</td>
	</tr>
<tr>
<td colspan="4"><center><b>Aprovação (assinatura sobre carimbo e data)</b></center></td>
</tr>
<tr>

<td colspan="2" width='33%' height="100px" style="vertical-align:top; text-align: center;">Responsável pela Área<br />C.R. Requisitante</td>
<td width='33%' height="100px" style="vertical-align:top; text-align: center;">Diretor(a) da Área Área<br />C.R. Requisitante</td>
<td height="100px" style="vertical-align:top; text-align: center;">Secretário(a) da Área Área<br />C.R. Requisitante</td>


<tr>
<td colspan="4"><center><b>Aprovação (assinatura sobre carimbo e data)</b></center></td>
</tr>
<tr>

<td colspan="2" width='33%' height="100px" style="vertical-align:top; text-align: center;">Responsável pela Área<br />C.R. Requisitante</td>
<td width='33%' height="50px" style="vertical-align:top; text-align: center;">Diretor(a) da Área Área<br />C.R. Requisitante</td>
<td height="50px" style="vertical-align:top; text-align: center;">Secretário(a) da Área Área<br />C.R. Requisitante</td>


</tr>
<tr>
<td colspan="4"><center><b>1ª via - Processo          2ª via - Requisitante</b></center></td>
</tr>
<tr>	
		</table>
	
<?php 
break;
case 549: // OS para FIP2018

?>

	<link rel="stylesheet" type="text/css" href="print.css" media="print" />

	
	
	
	<table  width="100%" border="1">
	<tr>
	<td rowspan="5" width="15%"><center><img src="images/logo.png" /></center></td>
	
	</tr>
	<tr>
	<td colspan="2"><center><b>Prefeitura Municipal de Santo André</b></center></td>
	</tr>
	<tr>
	<td colspan="2"><center><b>Solicitação de Serviços</b></center></td>
	</tr>	
		<tr>
		<td><center>Data da Emissão<br /><b><?php echo date("d/m/Y")?></b></center></td>
	<td><center>CR Requisitante<br /></center><b>70500</b></td>

	</tr>
	<tr>
	<td colspan="3"><center><b>Nome da área requisitante: Secretaria de Cultura - <?php echo $pedido['area']; ?></b></center></td>
	<tr/>	
	</table>
	<table border="1">
	<tr>
	<td colspan="4"><center><b>Dotação orçamentária</b></center></td>

	</tr>

	<tr>
	<td>Cód. Dotação:<br /><b><?php echo resumoDotacao($pedido['cod_dotacao']); ?></b></td>
	<td>Projeto:<br /><b><?php echo $pedido['projeto']; ?><b/></td>
	<td>Ficha: <br /> <b><?php echo $pedido['ficha']; ?></b></td>
	<td>Sub-elemente Despesa: <br /><center>22</center></td>	
	</tr>
	</tr>
	<tr>
	<td colspan="3">Cód. Vinculação de Despesa<br /><center>110.000</center></td>
	<td>Fonte de Recursos: <br /><center>  <?php echo $pedido['fonte']; ?></center></td>
	</tr>
	<tr>
	<td colspan="3">Nome do Contato <br />Marco Moretto</td>
	<td>Telefone Contato<br />4433-0421</td>
	</tr>
	<tr><td colspan="4">Conta corrente codReduzido/DB<br /><center>252</center></td></tr>	
	<tr>
	<td colspan="4">Data Período do evento: <br /><?php echo $pedido['periodo']; ?></td>
	</tr>	
	<tr>
	<td colspan="4">Local de aplicação do serviço ou evento:<br /><?php echo $pedido['local']; ?></td>
	</tr>
	<tr>
	<td colspan="4">Especificação (a maior quantidade necessária de informações para a correta contratação)</td>
	</tr>
	<tr>
	<td colspan="4">	<p>Contratação de <?php echo $pedido['tipoPessoa']; ?> <b><?php echo $pedido['nome_razaosocial']  ?></b>, representando com exclusividade a(s) apresentação(ões) do(s) seguinte(s) artista(s) <b><?php  echo $pedido['integrantes'] ?></b> para  realização de <?php echo $pedido['objeto']; ?> em <?php echo $pedido['local']; ?> no(s) dia(s)  <?php echo $pedido['periodo']; ?> </b> inserido na programação do XVIII Festival de Inverno de Paranapiacaba em Santo André.</p>
		<p>Empresa: <?php echo $pedido['nome_razaosocial']  ?><br />
	CNPJ: <?php echo $pedido['cpf_cnpj']  ?><br />
	Endereço: <?php echo $pedido['end']  ?><br />
	Email: <?php echo $pedido['email'];?> <br />
	<p>Valor total: R$<?php echo $pedido['valor'];?> (<?php echo $pedido['valor_extenso']; ?>)</p>
	
	<p><b>Forma de pagamento:</b> <?php echo $pedido['forma_pagamento'];?> </p>
	<p><?php echo $pedido['banco'];?> </p>		

	</td>
	</tr>
<tr>
<td colspan="4"><center><b>Aprovação (assinatura sobre carimbo e data)</b></center></td>
</tr>
<tr>

<td colspan="2" width='33%' height="100px" style="vertical-align:top; text-align: center;">Responsável pela Área<br />C.R. Requisitante</td>
<td width='33%' height="100px" style="vertical-align:top; text-align: center;">Diretor(a) da Área Área<br />C.R. Requisitante</td>
<td height="100px" style="vertical-align:top; text-align: center;">Secretário(a) da Área Área<br />C.R. Requisitante</td>


<tr>
<td colspan="4"><center><b>Aprovação (assinatura sobre carimbo e data)</b></center></td>
</tr>

<tr>
<td colspan="4"><center><b>1ª via - Processo          2ª via - Requisitante</b></center></td>
</tr>
<tr>	
		</table>
	
	

	
	<?php /*
	echo '<pre>';
	var_dump($pedido);
	echo '</pre>';
	
		echo '<pre>';
	$metausuario = opcaoDados("usuario",1);
	var_dump($metausuario);
	echo '</pre>';
	*/
	?>
	
	
	
	<?php 
	break;	
	case 305: //Justificativa	
	?>

	<?php 
	break;	
	case 306: //Gerencia de compra	

		$file_name='gerencia_de_compras.doc';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/force-download');
		header('Content-type: application/vnd.ms-word');
		header('Content-Type: application/download');
		header('Content-Disposition: attachment;filename='.$file_name);
		header('Content-Transfer-Encoding: binary ');

			?>
		<html>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
		<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
		</style>
		<br /><br /><br /> 
		<p class="style_01">À <br />
		Gerência de Compras e Licitações | <br />
		Sr. Gerente</p>
		<br />

		
		<p class="paragrafo">Com base nas informações e justificativas, retro que adoto, peço a continuidade da contratação nas bases da O.S. que o presente processo trata, com fulcro na Lei Federal n°8.6666/93.</p>


		<br />
		<br />
		<p>Santo André, <?php 
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		echo strftime('%A, %d de %B de %Y', strtotime('today'));
		
		?>. </p>
		
		<br /><br />
		
		<br /><br />
		
		<p><center><?php echo $pedido['usuario']; ?><br />
		<?php echo $pedido['cargo']; ?>	
		</p></center>
		
		<br /><br />
		
		<br /><br />
		
		<p>De acordo,</p>

		<p>Santo André, <?php 
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		echo strftime('%A, %d de %B de %Y', strtotime('today'));
		
		?>. </p>

		<br /><br />
		
		<br /><br />
			<p>Simone Zárate<br />
			Secretaria de Cultura</p>
		
		<p class="rodape">------------------------------------------------------------</p>
		<p class="rodape">Secretaria de Cultura - <?php echo $pedido['area']; ?> <br />
		Praça IV Centenário, 02 - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, <br /> 
		Telefone (11) 4433-0711/ 4433-0632 / email: musica@santoandre.sp.gov.br</p>
		
		
		
		
	<?php 
	break;	
	case 561: //Gerencia de compra	FIP2018

		$file_name='gerencia_de_compras_fip2018.doc';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/force-download');
		header('Content-type: application/vnd.ms-word');
		header('Content-Type: application/download');
		header('Content-Disposition: attachment;filename='.$file_name);
		header('Content-Transfer-Encoding: binary ');

			?>
		<html>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
		<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
		</style>
		<br /><br /><br /> 
		<p class="style_01">À <br />
		Gerência de Compras e Licitações | <br />
		Sr. Gerente</p>
		<br />

		
		<p class="paragrafo">Com base nas informações e justificativas, retro que adoto, peço a continuidade da contratação nas bases da O.S. que o presente processo trata, com fulcro na Lei Federal n°8.6666/93.</p>


		<br />
		<br />
		<p>Santo André, <?php 
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		echo strftime('%A, %d de %B de %Y', strtotime('today'));
		
		?>. </p>
		
		<br /><br />
		
		<br /><br />
		
		<p><center>Marco Moretto Neto<br />
		Departamento de Planejamento e Projetos Especiais
		</p></center>
		
		<br /><br />
		
		<br /><br />
		
		<p>De acordo,</p>

		<p>Santo André, <?php 
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		echo strftime('%A, %d de %B de %Y', strtotime('today'));
		
		?>. </p>

		<br /><br />
		
		<br /><br />
			<p>Simone Zárate<br />
			Secretaria de Cultura</p>
		
		<p class="rodape">------------------------------------------------------------</p>
		<p class="rodape">Secretaria de Cultura - <?php echo $pedido['area']; ?> <br />
		Praça IV Centenário, 02 - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, <br /> 
		Telefone (11) 4433-0711/ 4433-0632 / email: musica@santoandre.sp.gov.br</p>
		
		
		
		
	<?php 
	break;	
	
	
	
	
	case 307: //Ordenador de Despesa	

		$file_name='ordenador_de_despesas.doc';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/force-download');
		header('Content-type: application/vnd.ms-word');
		header('Content-Type: application/download');
		header('Content-Disposition: attachment;filename='.$file_name);
		header('Content-Transfer-Encoding: binary ');

			?>
		<html>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
		<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
		</style>
		<br />

		
		<p>Ref: Contratação de <?php echo $pedido['tipoPessoa'] ?> <?php echo $pedido['nome'] ?> representando com exclusividade, <?php echo $pedido['autor'] ?>.


		<br />
		<br />
		<p>Dotação: <?php echo $pedido['cod_dotacao']?> - Projeto: <?php echo $pedido['projeto']?> - Ficha: <?php echo $pedido['ficha']?> </p>
<br /><br />
<p>Valor: R$ <?php echo $pedido['valor'] ?> ( <?php echo $pedido['valor_extenso'] ?>)		
		
		<br /><br />
		<p>Declaração</p>
		<p>
		Declaro que a despesa pretendida tem a correspondente adequação orçamentária e financeira de acordo com a lei orçamentária anual e possui dotação específica e suficiente, ou seja, está abrangida por crédito genérico, de forma que somadas todas as despesas da mesma espécie, realizadas e a realizar, previstas no programa de trabalho da unidade, não serão ultrapassados os limetes estabelecidos para o exercício, estando adequada também a Lei de Diretrizes Orçamentárias e o Plano Plurianual vigentes.</p>
		</p>
		<p>Santo André, <?php 
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		echo strftime('%A, %d de %B de %Y', strtotime('today'));
		
		?>. </p>
		
		<br /><br />
		
		<br /><br />
		

		<br /><br />
		
		<br /><br />
			<p>Simone Zárate<br />
			Secretaria de Cultura<br />
			CPF : 161.410.008-00<br />
			E-mail profissional: szarate@santoandre.sp.gov.br<br />
			E-mail particular: simonezarate@terra.com.br
			</p>
			
		
		<p class="rodape">------------------------------------------------------------</p>
		<p class="rodape">Secretaria de Cultura - <?php echo $pedido['area']; ?> <br />
		Praça IV Centenário, 02 - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, <br /> 
		Telefone (11) 4433-0711/ 4433-0632 / email: musica@santoandre.sp.gov.br</p>
	<?php 
	break;

		case 562: //Ordenador de Despesa FIP2018	

		$file_name='ordenador_de_despesas_fip2018.doc';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/force-download');
		header('Content-type: application/vnd.ms-word');
		header('Content-Type: application/download');
		header('Content-Disposition: attachment;filename='.$file_name);
		header('Content-Transfer-Encoding: binary ');

			?>
		<html>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
		<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
		</style>
		<br />

		
		<p>Ref: Contratação de <?php echo $pedido['tipoPessoa'] ?> <?php echo $pedido['nome'] ?> representando com exclusividade, <?php echo $pedido['autor'] ?>.


		<br />
		<br />
		<p>Dotação: <?php echo $pedido['cod_dotacao']?> - Projeto: <?php echo $pedido['projeto']?> - Ficha: <?php echo $pedido['ficha']?> </p>
<br /><br />
<p>Valor: R$ <?php echo $pedido['valor'] ?> ( <?php echo $pedido['valor_extenso'] ?>)		
		
		<br /><br />
		<p>Declaração</p>
		<p>
		Declaro que a despesa pretendida tem a correspondente adequação orçamentária e financeira de acordo com a lei orçamentária anual e possui dotação específica e suficiente, ou seja, está abrangida por crédito genérico, de forma que somadas todas as despesas da mesma espécie, realizadas e a realizar, previstas no programa de trabalho da unidade, não serão ultrapassados os limetes estabelecidos para o exercício, estando adequada também a Lei de Diretrizes Orçamentárias e o Plano Plurianual vigentes.</p>
		</p>
		<p>Santo André, <?php 
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		echo strftime('%A, %d de %B de %Y', strtotime('today'));
		
		?>. </p>
		
		<br /><br />
		
		<br /><br />
		

		<br /><br />
		
		<br /><br />
			<p>Simone Zárate<br />
			Secretaria de Cultura<br />
			CPF : 161.410.008-00<br />
			E-mail profissional: szarate@santoandre.sp.gov.br<br />
			E-mail particular: simonezarate@terra.com.br
			</p>
			
		
		<p class="rodape">------------------------------------------------------------</p>
		<p class="rodape">Secretaria de Cultura - <?php echo $pedido['area']; ?> <br />
		Praça IV Centenário, 02 - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, <br /> 
		Telefone (11) 4433-0711/ 4433-0632 / email: musica@santoandre.sp.gov.br</p>
	<?php 
	break;



	case 396:
		$justificativa = "";
		if($pedido['evento_atividade'] == 'atividade'){
			$justificativa .= "Valor a ser reservado para empenho  ".$pedido['obs']." ".$pedido['objeto'] ;	
		}else{
		$justificativa .= "
		Valor a ser reservado para empenho de contratação para ".$pedido['objeto']; 
		}
		
		$justificativa .= " a ser realizado por ".$pedido['nome_razaosocial']." representando ".$pedido['autor']."(".$pedido['cpf_cnpj'].") em data/período ".$pedido['periodo']  ;

		if($pedido['local'] != ""){
			$justificativa .= " em ".$pedido['local'];
			
		}
		
	

		$file_name='liberacaodeverba.doc';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/force-download');
		header('Content-type: application/vnd.ms-word');
		header('Content-Type: application/download');
		header('Content-Disposition: attachment;filename='.$file_name);
		header('Content-Transfer-Encoding: binary ');

			?>
		<html>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
		<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
		</style>

		<table border='1'>
		<tr>
		<th>Liberação Nº</th>
		<th>Data</th>
		<th>Justificativa</th>
		<th>Projeto/Ficha</th>
		<th>Dotação</th>
		<th>Fonte</th>
		<th>Valor</th>
		</tr>
		<tr>
		<td><?php echo $pedido['nLiberacao'] ?></td>	
		<td><?php echo date('d/m/Y'); ?></td>	
		<td><?php echo $justificativa ?></td>	
		<td><?php echo $pedido['projeto']." / ".$pedido['ficha']; ?></td>	
		<td><?php echo resumoDotacao($pedido['cod_dotacao']); ?></td>	
		<td><?php echo $pedido['fonte'] ?></td>	
		<td><?php echo $pedido['valor'] ?>	

		</tr>
		
		</table>

				<?php 
	break;
	case "320":
	
		
		$justificativa = "";

		if($pedido['evento_atividade'] == 'atividade'){
			$justificativa .= "Valor a ser reservado para empenho  ".$pedido['obs']." ".$pedido['objeto'] ;	
		}else{
		$justificativa .= "
		Valor a ser reservado para empenho de contratação para ".$pedido['objeto']; 
		}
		
		$justificativa .= " a ser realizado por ".$pedido['nome_razaosocial']." (".$pedido['cpf_cnpj'].") em data/período ".$pedido['periodo']  ;

		if($pedido['local'] != ""){
			$justificativa .= " em ".$pedido['local'];
			
		}
		
		$sql_mult = "SELECT idPedidoContratacao FROM sc_contratacao WHERE nLiberacao = '".$pedido['nLiberacao']."'";
		$res_mult = $wpdb->get_results($sql_mult,ARRAY_A);
		//var_dump($res_mult); $sql_mult;		
		
		$file_name='liberacaodeverbamultipla.doc';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/force-download');
		header('Content-type: application/vnd.ms-word');
		header('Content-Type: application/download');
		header('Content-Disposition: attachment;filename='.$file_name);
		header('Content-Transfer-Encoding: binary ');

			?>

		<html>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
		<body>
		<style type='text/css'>

		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}

		</style>

		<table border='1'>
		<tr>
		<th>Liberação Nº</th>
		<th>Data</th>
		<th>Justificativa</th>
		<th>Projeto/Ficha</th>
		<th>Dotação</th>
		<th>Fonte</th>
		<th>Valor</th>
		</tr>
		<tr>
		<td rowspan='<?php echo count($ped); ?>'><?php echo $pedido['nLiberacao'] ?></td>
		<td rowspan='<?php echo count($ped); ?>'><?php echo date('d/m/Y'); ?></td>
		<td rowspan='<?php echo count($ped); ?>'><?php echo $justificativa; ?></td>

		</tr>
		<?php $total = 0; ?>
		<?php for ($i = 0; $i < count($res_mult); $i++){ 
			$ped = retornaPedido($res_mult[$i]['idPedidoContratacao']);
			
		?>
		<tr>

		<td><?php echo $ped['projeto']." / ".$ped['ficha']; ?></td>	
		<td><?php echo resumoDotacao($ped['cod_dotacao']); ?></td>	
		<td><?php echo $ped['fonte'] ?></td>	
		<td><?php echo $ped['valor'];
			$total = $total + dinheiroDeBr($ped['valor']);
		?>	
		</tr>

		<?php } ?>
		<tr>
		
		<td colspan="5"></td>
		<td>Total</td>
		<td><?php echo dinheiroParaBr($total); ?></td>
		</tr>
		
		
		
		</table>
	
<?php 
break;
case "salao2018":
//http://scsantoandre.info/scpsa/documentos.php?id=0&modelo=salao2018

$sql = "SELECT descricao FROM ava_inscricao WHERE id_mapas = '277'";
$res = $wpdb->get_results($sql,ARRAY_A);

?>
	
<style>
.break { page-break-before: always; }
.esquerda{
	margin-left: 100px;
}

</style>
<?php 
for($i = 1;$i < count($res); $i++){
	$x = json_decode($res[$i]['descricao'],true);
	
	//echo "<pre>";
	//var_dump($x);
	//echo "</pre>";
	?>
	
	
	
	
	
	
	<h1 class="break"></h1>
	
	<p><center><font size="2">46° Salão de Arte Contemporânea Luiz Sacilotto - 2018 - Santo André<br />
	Caderno dos Artistas - 1 fase
	</font></center></p>
	<br />
	<div class="esquerda">
	<h3>Cadastro : ___________</h3>
	<p>Nome artístico: <?php echo $x['Nome artístico']?> / <?php echo $x['Número']?> </p>	
	<p>Técnica:<?php echo $x['Informar técnica']; ?> </p>
	<br />
	
	<h3>Obra A</h3>	
	<p>Título: <?php echo $x['Título da Obra (a)']; ?><br />
	Dimensões:  <?php echo $x['Dimensões (a)']; ?><br />
	Valor:  <?php echo $x['Valor (a)']; ?><br />
	</p>
	<br />

	<h3>Obra B</h3>	
	<p>Título: <?php echo $x['Título da Obra (b)']; ?><br />
	Dimensões:  <?php echo $x['Dimensões (b)']; ?><br />
	Valor:  <?php echo $x['Valor (b)']; ?><br />
	</p>
	<br />

	<h3>Obra C</h3>	
	<p>Título: <?php echo $x['Título da Obra (c)']; ?><br />
	Dimensões:  <?php echo $x['Dimensões (c)']; ?><br />
	Valor:  <?php echo $x['Valor (c)']; ?><br />
	</p>
	<br />

	<h3>Obra D</h3>	
	<p>Título: <?php echo $x['Título da Obra (d)']; ?><br />
	Dimensões:  <?php echo $x['Dimensões (d)']; ?><br />
	Valor:  <?php echo $x['Valor (d)']; ?><br />
	</p>
	<br />

	<h3>Obra E</h3>	
	<p>Título: <?php echo $x['Título da Obra (e)']; ?><br />
	Dimensões:  <?php echo $x['Dimensões (e)']; ?><br />
	Valor:  <?php echo $x['Valor (e)']; ?><br />
	</p>
	<br />
	</div>
	
	<?php
	
}

?>

	
	
		<?php 
	break;
	default:
	?>


	<?php 
   break;	
	}
	
	
}

