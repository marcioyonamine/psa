<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';
}

?>
  <body>
  
  <?php include "menu/me_inicio.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
	<h1>Área de Manutenção</h1>		
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
case 'relatorio_edital':  

if(isset($_GET['edital'])){
	$edital = $_GET['edital'];
}else{
	echo "Não há edital selecionado.<br />";
}

if(isset($_GET['user'])){
	$user = $_GET['user'];
}else{
	echo "Não há usuário selecionado.<br />";
}

if(isset($user) AND isset($edital)){
	
	
}else{ ?>

<form method="POST" action="?" class="form-horizontal" role="form">
 <div class="container">
    <div class="row">    
		<div class="col-md-offset-2 col-md-8">
		<label>Edital</label>
		<input type="text" name="nomeEvento" class="form-control" id="inputSubject" value=""/>
		</div>
     </div>
</div>
</form>

<?php 
}
?>  
<?php 
break;
case 'atualiza_banco':
	$sql_sel = "SELECT * FROM igsis_bancos ORDER BY codigo";
	$res = $wpdb->get_results($sql_sel,ARRAY_A);
	for($i = 0; $i < count($res); $i++){
		$descricao = json_encode(array(
			"codBanco" => $res[$i]['codigo']
			)
		);
		$tipo = $res[$i]['banco'];
	$sql_ins = "INSERT INTO sc_tipo (tipo,descricao,abreviatura,publicado) VALUES('$tipo','$descricao','banco','1')";
	$ins = $wpdb->query($sql_ins);
	
	if($ins == 1){
		echo "$tipo migrado<br />";
	}else{
		echo $sql_ins."<br />";
		
	}
	
	}
  
?>	
<?php 
break;
case 'subelemento':

$sub = array(

	"319004" => [
		"3" => "Férias - CPTD",
		"21" =>	"13º Salário - CPTD",
		"151" => "Obrigação Patronal - Inss Temporário",
		"152" => "Obrigação Patronal - Inss Temporário -Férias",
		"153" => "Obrigação Patronal - Fgts Temporário",
		"154" => "Obrigação Patronal - Fgts Temporário -Férias",
		"991" => "Outras Contratações por Tempo Determinado - Demais", 
		"992" => "Outras Contratações por Tempo Determinado - Demais Férias",
		"998" => "Serviços Extraordinários Diurnos - Temporário"
	],

	"335043" => [
		"0" => "Subvenções Sociais" 
	],

	"339030" => [
		"4" => "Gás Engarrafado",
		"7" => "Gêneros de Alimentação",
		"24" => "Material para manutenção de bens imóveis",
		"26" => "Material elétrico e eletrônico	",
		"99" => "Outros materiais de consumo ",
	],	

	"339031" => [
		"0" => "Premiações Culturais, Artísticas, Científicas e Outras",

	],	
	
	"339033" => [
		"2" => "Passagens para o Exterior",
	],
	
	"339036" => [
		"7" => "Estagiários",
		"28" => "Serviço de Seleção e Treinamento",
		"99" => "Outros Serviços",

	],	

	"339039" => [
		"1" => "Assinaturas De Periódicos E Anuidades",
		"2" => "Condomínios",
		"4" => "Direitos Autorais",
		"5" => "Serviços Técnicos Profissionais ",
		"12" => "Locação de Máquinas e Equipamentos ",
		"16" => "Manutenção e Conservação De Bens Imóveis", 
		"17" => "Manutenção e Conservação de Máquinas e Equipamentos ",
		"22" => "Exposições, Congressos e Conferências",
		"39" => "Encargos Financeiros Indedutíveis - Empresas ",
		"47" => "Serviços de Comunicação em Geral", 
		"48" => "Serviço de Seleção e Treinamento",
		"57" => "Serviços de Processamento de Dados ",
		"58" => "Serviços de Telecomunicação",
		"63" => "Serviços Gráficos ",
		"99" => "Outros Serviços de Terceiros- Pessoa Jurídica ",

	],	
	
	"449052" => [
		"12	Aparelhos e Utensílios Domésticos ",
		"33	Equipamentos Para Áudio Vídeo e Foto",
		"42	Mobiliário em Geral ",
		"99	outros Materiais Permanente",
	],	
);


echo "<pre>";
var_dump($sub);
echo "</pre>";

var_dump(json_encode($sub));



?>	

<?php 
break;
case 'atualiza_agenda':  
set_time_limit(0);

$sql_evento = "SELECT idEvento FROM sc_evento WHERE publicado = '1'";
$evento = $wpdb->get_results($sql_evento,ARRAY_A);
for($i = 0; $i < count($evento); $i++){
	atualizarAgenda($evento[$i]['idEvento'],true);
}
	
	

?>		  
					 <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					
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