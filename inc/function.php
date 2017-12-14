<?php
// funcoes sistema avaliacao sc.psa

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include "globals.php";

function converterObjParaArray($data) { //função que transforma objeto vindo do json em array
    if(is_object($data)) {
        $data = get_object_vars($data);
    }
    if(is_array($data)) {
        return array_map(__FUNCTION__, $data);
    }else{
        return $data;
    }
}

function nocache(){
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Last Modified: '. gmdate('D, d M Y H:i:s') .' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	header('Pragma: no-cache');
	header('Expires: 0');

	
}

function checar($id){
	if($id == 1){
		echo " checked ";		
	}
}


function saudacao(){ 
	$hora = date('H');
	if(($hora > 12) AND ($hora <= 18)){
		return "Boa tarde";	
	}else if(($hora > 18) AND ($hora <= 23)){
		return "Boa noite";	
	}else if(($hora >= 0) AND ($hora <= 4)){
		return "Boa noite";	
	}else if(($hora > 4) AND ($hora <=12)){
		return "Bom dia";
	}
}

function numeroSemana($date){
	return date("W", strtotime($date)); 
}

//soma(+) ou substrai(-) dias de um date(a-m-d)
function somarDatas($data,$dias){ 
	$data_final = date('Y-m-d', strtotime("$dias days",strtotime($data)));	
	return $data_final;
}

function recuperaDados($tabela,$idEvento,$campo){ //retorna uma array com os dados de qualquer tabela. serve apenas para 1 registro.
	global $wpdb;
	$sql = "SELECT * FROM $tabela WHERE $campo = '$idEvento' LIMIT 0,1";
	$result = $wpdb->get_row($sql,ARRAY_A);
	if($result){
		return $result;
	}else{
		return $sql;
	}
}

// Retira acentos das strings
function semAcento($string){
	$newstring = preg_replace("/[^a-zA-Z0-9_.]/", "", strtr($string, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
	return $newstring;
}

//retorna data d/m/y de mysql/date(a-m-d)
function exibirDataBr($data){ 
	$timestamp = strtotime($data); 
	return date('d/m/Y', $timestamp);
}

//retorna data mysql/date (a-m-d) de data/br (d/m/a)
function exibirDataMysql($data){ 
	list ($dia, $mes, $ano) = explode ('/', $data);
	$data_mysql = $ano.'-'.$mes.'-'.$dia;
	return $data_mysql;
}



function checado($x,$array){
	if (in_array($x,$array)){
		return "checked='checked'";		
	}
}



function select($id,$sel){
	if($id == $sel){
		return "selected";			
	}	
}
//retorna valor xxx,xx para xxx.xx
function dinheiroDeBr($valor)
{
	$valor = str_ireplace(".","",$valor);
	$valor = str_ireplace(",",".",$valor);
	return $valor;
}
//retorna valor xxx.xx para xxx,xx
function dinheiroParaBr($valor)
{ 
	$valor = number_format($valor, 2, ',', '.');
	return $valor;
}

// retorna datatime sem hora
function retornaDataSemHora($data){
	$semhora = substr($data, 0, 10);
	return $semhora;
}
	
//retorna data d/m/y de mysql/datetime(a-m-d H:i:s)	
function exibirDataHoraBr($data){ 
	$timestamp = strtotime($data); 
	return date('d/m/y - H:i:s', $timestamp);	
}
//retorna hora H:i de um datetime
function exibirHora($data){
	$timestamp = strtotime($data); 
	return date('H:i', $timestamp);	
}

//retorna o endereço da página atual
function urlAtual(){ 
	$dominio= $_SERVER['HTTP_HOST'];
	$url = "http://" . $dominio. $_SERVER['REQUEST_URI'];
	return $url;
}



function gravarLog($log, $idUsuario){ //grava na tabela ig_log os inserts e updates
		$logTratado = addslashes($log);
		//$idUsuario = $user->ID;
		
		if(isset($_SERVER['REMOTE_ADDR'])){ 
			$ip = $_SERVER["REMOTE_ADDR"];
			}else{
			$ip = "1.1.1.1";
			}
		
		//$ip = $_SERVER['REMOTE_ADDR'];
		
		
		$data = date('Y-m-d H:i:s');
		$sql = "INSERT INTO `iap_log` (`idLog`, `ig_usuario_idUsuario`, `enderecoIP`, `dataLog`, `descricao`) VALUES (NULL, '$idUsuario', '$ip', '$data', '$logTratado')";
		$mysqli = bancoMysqli();
		$mysqli->query($sql);
}


function noResend(){
	$p1 = $_SERVER["HTTP_REFERER"];
	$p2 = $_SERVER["QUERY_STRING"];
	echo $p1;
	header('Location:'.$p1, true, 301);
}

function vGlobais(){
	if(isset($_POST)){
		echo "POST";
		echo "<pre>";
		var_dump($_POST);
		echo "</pre>";
	}

	if(isset($_GET)){
		echo "GET";
		echo "<pre>";
		var_dump($_GET);
		echo "</pre>";	
	}
	if(isset($_SESSION)){
		echo "SESSION";
		echo "<pre>";
		var_dump($_SESSION);
		echo "</pre>";	
	}

	if(isset($_FILES)){
		echo "FILES";
		echo "<pre>";
		var_dump($_FILES);
		echo "</pre>";	
		
		
	}
	
	echo "SERVER";
	echo "<pre>";
	var_dump($_SERVER);
	echo "</pre>";

}

function geraTipoOpcao($abreviatura,$select = 0){
	global $wpdb;
	$sql = "SELECT * FROM sc_tipo WHERE abreviatura = '$abreviatura' ORDER BY tipo ASC";
	$query = $wpdb->get_results($sql,ARRAY_A);
	for($i = 0; $i < count($query); $i++){
		if($select == $query[$i]['id_tipo']){
			echo "<option value='".$query[$i]['id_tipo']."' selected >".$query[$i]['tipo']."</option>";
		}else{
			echo "<option value='".$query[$i]['id_tipo']."' >".$query[$i]['tipo']."</option>";
		}
	}		

}
	

function editais($usuario,$id = NULL){
	global $wpdb;
	$editais = array();
	
	if($id != NULL){
		$filtro = " AND id = '$id' ";		
	}else{
		$filtro =  "";	
	}
	$sql = "SELECT id, edital, id_mapas, avaliadores, fases FROM ava_edital WHERE publicado = '1' AND edital <> '' $filtro ";
	$res = $wpdb->get_results($sql);
	for($i = 0; $i < count($res); $i++){
		$editais[$i]['id'] = $res[$i]->id;
		$editais[$i]['titulo'] = $res[$i]->edital;	
		$editais[$i]['mapas'] = $res[$i]->id_mapas;
		$editais[$i]['fases']['quantidade'] = $res[$i]->fases;
		
		// lista as fases
		$sql_fase = "SELECT edital, fase, peso, inicio, fim FROM ava_fase WHERE edital = '".$editais[$i]['id']."'";
		$res_fase = $wpdb->get_results($sql_fase);
		
		
		for($k = 0; $k < count($res_fase); $k++){
			$editais[$i]['fases'][$k]['fase'] ['numero']= $res_fase[$k]->fase;
			$editais[$i]['fases'][$k]['fase']['peso'] = $res_fase[$k]->peso;
			$editais[$i]['fases'][$k]['fase']['inicio'] = $res_fase[$k]->inicio;
			$editais[$i]['fases'][$k]['fase']['fim'] = $res_fase[$k]->fim;
			$fim =  $res_fase[$k]->fim;
		}
		
		
		if(count($res_fase) == 0){
				$editais[$i]['periodo'] = "Não há fases cadastradas.";
		}else{
				$editais[$i]['periodo'] = "De ".exibirDataBr($editais[$i]['fases'][0]['fase']['inicio'])." a ".exibirDataBr($editais[$i]['fases'][count($res_fase) -1]['fase']['fim']);
			
		}
		
		
		// lista criterios
		
	}
	
	
	return $editais;


}
	
	
function tipo($id){
	global $wpdb;
	$sql = "SELECT * FROM sc_tipo WHERE id_tipo = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return $res;

}
	
	
function evento($id){

	global $wpdb;

	$sql =  "SELECT * FROM sc_evento WHERE idEvento = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	/*
	echo "<pre>";
	var_dump($programa);
	echo "</pre>";

	*/
	$programa = tipo($res['idTipo']);
	
	$projeto = tipo($res['idProjeto']);
	$linguagem = tipo($res['idLinguagem']);
	$tipo_evento = tipo($res["idTipo"]);
	
	$evento = array(
		'titulo' => $res['nomeEvento'],
		'programa' => $programa['tipo'],
		'projeto' => $projeto['tipo'],
		'linguagem' => $linguagem['tipo'],
		'responsavel' => '',
		'autor' => $res['autor'],
		'grupo' => $res['nomeGrupo'],
		'ficha_tecnica' => $res['fichaTecnica'],
		'sinopse' => $res['sinopse'],
		'release' => $res['releaseCom'],
		'status' => '',
		'usuario' => '',
		'sub' => '',
		'envio' => '',
		'periodo' => '',
		'local' => '',
		'faixa_etaria' => '',
		'valor_entrada' => '',
		'imagem' => '',
		'planejamento' => $res['planejamento'],
		'objeto' => $tipo_evento['tipo']." - ".$res['nomeEvento']
	);

	return $evento;
}
	
function ocorrencia($id){
	global $wpdb;
	$oc = $wpdb->get_row("SELECT * FROM sc_ocorrencia WHERE idOcorrencia = '$id'",ARRAY_A);
	if(($oc['dataInicio'] == $oc['dataFinal']) OR
		$oc['dataFinal'] == '' OR
		$oc['dataFinal'] == NULL OR
		$oc['dataFinal'] == '0000-00-00' 
		){
			$tipo = "Evento de Data Única";	
			$data =  exibirDataBr($oc['dataInicio'])." às ".substr($oc['horaInicio'],0,-3)." (".$oc['duracao']." minutos)";
			
	}else if($oc['dataInicio'] != $oc['dataFinal'] ){
		$tipo = "Evento de temporada";
		$s = " ";
		if($oc['segunda'] == 1){
			$s .= "segunda, ";		
		}
		if($oc['terca'] == 1){
			$s .= "terca, ";		
		}
		if($oc['quarta'] == 1){
			$s .= "quarta, ";		
		}
		if($oc['quinta'] == 1){
			$s .= "quinta, ";		
		}
		if($oc['sexta'] == 1){
			$s .= "sexta, ";		
		}
		if($oc['domingo'] == 1){
			$s .= "sabado, ";		
		}
		if($oc['domingo'] == 1){
			$s .= "domingo, ";		
		}

		
		if($s != " "){
			$sem = "( ".substr($s,0,-2)." )";
		}else{
			$sem = "";
		}

		$data = "De ".exibirDataBr($oc['dataInicio'])." a ".exibirDataBr($oc['dataFinal'])." às ".substr($oc['horaInicio'],0,-3)." (".$oc['duracao']." minutos)<br />".$sem;	
		
		
	}
	
	$local = tipo($oc['local']);
	
	$ocorrencia = array(
		'tipo' => $tipo,
		'data' =>  $data,
		'local' => $local['tipo']
	);
	
	return $ocorrencia;
	
}	

function geraOpcaoUsuario($select = NULL, $role = NULL){
	if($role == NULL){
		$x = '';
	}else{
		$x = "'role=$role'";
	}
	$blogusers = get_users( $x );
	// Array of WP_User objects.
	foreach ( $blogusers as $user ) {
		if($user->ID == $select){
			echo '<option value="'.esc_html( $user->ID ).'" selected>' . esc_html( $user->display_name ) . '</option>';
		}else{	
			echo '<option value="'.esc_html( $user->ID ).'">' . esc_html( $user->display_name ) . '</option>';
			
		}
	}	
	
}

function geraOpcaoDotacao($ano_base,$id = NULL){
	global $wpdb;
	$sql_orc = "SELECT * FROM sc_orcamento WHERE ano_base = '$ano_base'";
	$res = $wpdb->get_results($sql_orc,ARRAY_A);
	echo "<pre>";
	var_dump(($res));
	echo "</pre>";
	for($i = 0; $i < count($res) ; $i++){
		if($res[$i]['id'] == $id){
			echo "<option value = '".$res[$i]['id']."' selected >(".$res[$i]['id'].") ".$res[$i]['descricao']." (".$res[$i]['dotacao'].")</option>";
			//echo "<option>selected</option>";
		}else{
			echo "<option value = '".$res[$i]['id']."' >(".$res[$i]['id'].") ".$res[$i]['descricao']." (".$res[$i]['dotacao'].")</option>";
			//echo "<option>non-selected</option>";
		}	
	
	}
	
}

function verificaDataAgenda($data,$id,$hora,$local){
	global $wpdb;
	$sel = "SELECT idAgenda FROM sc_agenda WHERE data = '$data' AND hora = '$hora' AND idLocal = '$local' AND idEvento = '$id'";
	$res = $wpdb->get_results($sel,ARRAY_A);
	$num = $wpdb->num_rows;
	//echo $sel."<br />";

	return $num;
}

function insereAgenda($data,$id,$hora,$local){
		global $wpdb;
		
		// limpa a ocorrencia na agenda
		$sql_ins = "INSERT INTO `sc_agenda` (`idEvento`, `data`, `hora`, `idLocal`) 
					VALUES ('$id', '$data', '$hora', '$local')"; 			
		$insere = $wpdb->query($sql_ins);
		//var_dump($insere)."<br />";
		return $wpdb->insert_id;

}

function atualizarAgenda($id){ //01
	global $wpdb;
	$sql_limpa =  "DELETE FROM `sc_agenda` WHERE idEvento = '$id'";
	$limpa = $wpdb->query($sql_limpa);
	$sql = "SELECT * FROM sc_ocorrencia WHERE idEvento = '$id' AND publicado = '1'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	if(count($res) > 0){ //02
		for($i = 0; $i < count($res); $i++){ //03
			if($res[$i]['dataFinal'] != '0000-00-00'){ // temporada //04
				$di = $res[$i]['dataInicio'];
				while(strtotime($di) <= strtotime($res[$i]['dataFinal'])){
					$n = numeroSemana($di);
					echo $di."<br />";
					if($n == 0 AND $res[$i]['domingo'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local']);
						//echo $x;
					}
								
					if($n == 1 AND $res[$i]['segunda'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local']);
						//echo $x;
						
					}					
					if($n == 2 AND $res[$i]['terca'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local']);
						//echo $x;
						
					}					
					if($n == 3 AND $res[$i]['quarta'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local']);
						//echo $x;
						
					}					
					if($n == 4 AND $res[$i]['quinta'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local']);
						//echo $x;
						
					}					
					if($n == 5 AND $res[$i]['sexta'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local']);
						//echo $x;
						
					}					
					if($n == 6 AND $res[$i]['sabado'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local']);
						//echo $x;
					}					
					$di = somarDatas($di,"+1");
				}	
			}else{ // data única //04
						$x = insereAgenda($res[$i]['dataInicio'],$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local']);
						//echo $x;

			}
			
		}//03
	}	
} //01 

function orcamento($id,$fim = NULL,$inicio = NULL){
	if($fim == NULL){
		$fim = date('Y')."-12-31";
	}
	if($inicio == NULL){
		$inicio = date('Y')."-01-01";
	}
	
	
	global $wpdb;
	$sel = "SELECT valor,dotacao,descricao, projeto, ficha FROM sc_orcamento WHERE id = '$id'";
	$val = $wpdb->get_row($sel,ARRAY_A);
	
	// Contigenciado (286)
	$sel_cont	= "SELECT valor FROM sc_mov_orc WHERE tipo = '286' AND idOrc = '$id' AND '$inicio' <= data AND '$fim' >= data";
	$cont = $wpdb->get_results($sel_cont,ARRAY_A);
	$valor_cont = 0;
	for($i = 0; $i < count($cont); $i++){
		$valor_cont = $valor_cont + $cont[$i]['valor'];	
	}
	
	// Descontigenciado (287)
	$sel_cont	= "SELECT valor FROM sc_mov_orc WHERE tipo = '287' AND idOrc = '$id' AND '$inicio' <= data AND '$fim' >= data";
	$cont = $wpdb->get_results($sel_cont,ARRAY_A);
	$valor_desc = 0;
	for($i = 0; $i < count($cont); $i++){
		$valor_desc = $valor_desc + $cont[$i]['valor'];	
	}
	

	// Suplemento (288)
	$sel_cont	= "SELECT valor FROM sc_mov_orc WHERE tipo = '288' AND idOrc = '$id' AND '$inicio' <= data AND '$fim' >= data";
	$cont = $wpdb->get_results($sel_cont,ARRAY_A);
	$valor_supl = 0;
	for($i = 0; $i < count($cont); $i++){
		$valor_supl = $valor_supl + $cont[$i]['valor'];	
	}
	
	// Histórico
	$sel_hist = "SELECT titulo,valor, descricao, tipo, idUsuario,data FROM sc_mov_orc WHERE idOrc = '$id' AND '$inicio' <= data AND '$fim' >= data ORDER BY data ASC";
	$hist = $wpdb->get_results($sel_hist,ARRAY_A);
	
	// liberado
	$sql_lib = "SELECT valor FROM sc_contratacao WHERE dotacao = '$id' AND liberado = '1'";
	$lib = $wpdb->get_results($sql_lib,ARRAY_A);
	$valor_lib = 0;
	for($i = 0; $i < count($lib); $i++){
		$valor_lib = $valor_lib + $lib[$i]['valor'];	
	}		
	
	
	
	$dotacao = array(
	'descricao' => $val['descricao'],
	'dotacao' => $val['dotacao'],
	'total' => 	$val['valor'],
	'contigenciado' => $valor_cont,
	'descontigenciado' => $valor_desc,
	'suplementado' => $valor_supl,
	'historico' => $hist,
	'visualizacao' => $val['projeto']." / ".$val['ficha'], //colocar natureza (importar de novo)
	'liberado' => $valor_lib,
	'planejado' => '' 

	);
	
	
	return $dotacao;
	
}

/* Funções para Pedidos de Contratação */


function retornaPessoa($id,$tipo){
	global $wpdb;
	$x = array();
	if($tipo == 1){
		$sql = "SELECT Nome, CPF FROM sc_pf WHERE Id_PessoaFisica = '$id'";
		$res = $wpdb->get_row($sql,ARRAY_A);	
		$x['nome'] = $res['Nome'];
		$x['cpf_cnpj'] = $res['CPF'];
		
	}else{
		$sql = "SELECT RazaoSocial, CNPJ FROM sc_pj WHERE Id_PessoaJuridica = '$id'";
		$res = $wpdb->get_row($sql,ARRAY_A);	
		$x['nome'] = $res['RazaoSocial'];
		$x['cpf_cnpj'] = $res['CNPJ'];

	}
	return $x;

}


function listaPedidos($id,$tipo){ //lista os pedidos de contratação de determinado pedido

	global $wpdb;

	switch($tipo){
		case 'evento':
		default:
			$sql = "SELECT idPedidoContratacao, tipoPessoa, idPessoa, valor FROM sc_contratacao WHERE idEvento = '$id' AND publicado = '1'";
		break;
		case 'atividade' :
			$sql = "SELECT idPedidoContratacao, tipoPessoa, idPessoa, valor FROM sc_contratacao WHERE idAtividade = '$id' AND publicado = '1'";
		break;		
	}
	$res = $wpdb->get_results($sql,ARRAY_A);
	$pedido = array();
	for($i = 0; $i < count($res); $i++){
		if($res[$i]['tipoPessoa'] == 1){
			$tipo = "Pessoa Física";
			$pessoa = retornaPessoa($res[$i]['idPessoa'],1);
			
			
		}else{
			$tipo = "Pessoa Jurídica";
			$pessoa = retornaPessoa($res[$i]['idPessoa'],2);
		}
		$pedido[$i] = array(
		'idPedidoContratacao' => $res[$i]['idPedidoContratacao'],
		'tipo' => $tipo,
		'nome' => $pessoa['nome'],
		'valor' => $res[$i]['valor'],
		'cpf_cnpj' => $pessoa['cpf_cnpj']
		);
	
	}


	return $pedido;	
	
}

function periodo($id){ //retorna o período
	global $wpdb;
	$sql = "SELECT dataInicio, dataFinal FROM sc_ocorrencia WHERE publicado = '1' AND idEvento = '$id' ORDER BY dataInicio ASC";
	$res = $wpdb->get_results($sql,ARRAY_A);

	$x = array();
	if(count($res) == 0){ // não há ocorrências registradas
		$x['bool'] = FALSE;
		$x['legivel'] = "Não há ocorrências cadastradas.";
	}
	else if(count($res) == 1 AND $res[0]['dataFinal'] == '0000-00-00'){ // Evento de data única
		$x['bool'] = TRUE;
		$x['inicio'] = $res[0]['dataInicio'];
		$x['final'] = $res[0]['dataInicio'];
		$x['legivel'] = exibirDataBr($res[0]['dataInicio']);
	}else{ // temporadas ou multiplas ocorrencias
		if(count($res) == 1){ // se for apenas uma ocorrência
			$x['bool'] = TRUE;
			$x['inicio'] = $res[0]['dataInicio'];
			$x['final'] = $res[0]['dataFinal'];
			$x['legivel'] = exibirDataBr($res[0]['dataInicio'])." a ".exibirDataBr($res[0]['dataFinal']) ;
		}else{ // comparar datas
			$x['bool'] = TRUE;
			$x['inicio'] = $res[0]['dataInicio'];
			
			$data = $res[0]['dataInicio'];
			for($i = 0; $i < count($res); $i++){
				if(strtotime($data) <= strtotime($res[$i]['dataInicio'])){
					$data = $res[$i]['dataInicio'];
				}
				if(strtotime($data) <= strtotime($res[$i]['dataFinal'])){
					$data = $res[$i]['dataFinal'];
				}
			
			}
			$x['final'] = $data;
			$x['legivel'] = exibirDataBr($res[0]['dataInicio'])." a ".exibirDataBr($data) ;	
					
			
			
			
			
			
			
		}
		
		
	}
	
	
	
	return $x;

}




function retornaPedido($id){
	global $wpdb;
	$sql = "SELECT valor, tipoPessoa, idPessoa, sc_evento.idEvento FROM sc_contratacao, sc_evento WHERE idPedidoContratacao = '$id' AND sc_evento.idEvento = sc_contratacao.idEvento ";
	$res = $wpdb->get_row($sql,ARRAY_A);
	$pessoa = retornaPessoa($res['idPessoa'],$res['tipoPessoa']);
	$objeto = evento($res['idEvento']);
	$periodo = periodo($res['idEvento']);
	
	
	$x = array();
	$x['nome'] = $pessoa['nome'];
	$x['objeto'] = $objeto['objeto'];	
	$x['periodo'] = $periodo['legivel'];
	return $x;
	
}

function opcoes($id,$entidade){
	global $wpdb;
	$sql = "SELECT * FROM sc_opcoes WHERE entidade = '$entidade' AND id_entidade = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	$json = json_decode($res['opcao']);
	return $json;
}


/* Fim das Funções para Pedidos de Contratação */

