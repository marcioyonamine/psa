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
		'imagem' => ''
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



