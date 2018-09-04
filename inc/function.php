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


function exibeHoje(){
	$dia = date('d');
	$ano = date('Y');
	
	switch(date('m')){
		case '1':
			$mes = "Janeiro";
		break;
		case '2':
			$mes = "Fevereiro";
		
		break;
		case '3':
			$mes = "Março";
		
		break;
		case '4':
			$mes = "Abril";
		
		break;
		case '5':
			$mes = "Maio";
		
		break;
		case '6':
			$mes = "Junho";
		
		break;
		case '7':
			$mes = "Julho";
		
		break;
		case '8':
			$mes = "Agosto";
		
		break;
		case '9':
			$mes = "Setembro";
		
		break;
		case '10':
			$mes = "Outubro";
		
		break;
		case '11':
			$mes = "Novembro";
		
		break;
		case '12':
			$mes = "Dezembro";
		
		break;


		
	}
	
	return "$dia de $mes de $ano";
	
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

function nSemana($date){
	return date("w", strtotime($date)); 
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
function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
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

function valorPorExtenso($valor=0)
	{
		//retorna um valor por extenso
		$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
		$z=0;
		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];
		$rt = "";
		// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;) 
		$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++)
		{
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}
		return($rt ? $rt : "zero");
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

//soma minutos

function somaMinutos($hora,$minutos){
	return date("H:i",strtotime($hora." ".$minutos." minutes"));	
}

//retorna o endereço da página atual
function urlAtual(){ 
	$dominio= $_SERVER['HTTP_HOST'];
	$url = "http://" . $dominio. $_SERVER['REQUEST_URI'];
	return $url;
}

function retornaMascara($val, $mask)
{
  $maskared = '';
  $k = 0;
  for($i = 0; $i<=strlen($mask)-1; $i++)
  {
     if($mask[$i] == '#')
     {
        if(isset($val[$k]))
        $maskared .= $val[$k++];
     }
     else
     {
        if(isset($mask[$i]))
           $maskared .= $mask[$i];
     } 
  }
  return $maskared;
}

function gravarLog($log, $idUsuario){ //grava na tabela ig_log os inserts e updates
		global $wpdb;
		$logTratado = addslashes($log);
		//$idUsuario = $user->ID;
		
		if(isset($_SERVER['REMOTE_ADDR'])){ 
			$ip = $_SERVER["REMOTE_ADDR"];
			}else{
			$ip = "1.1.1.1";
			}
		
		//$ip = $_SERVER['REMOTE_ADDR'];
		
		
		$data = date('Y-m-d H:i:s');
		$sql = "INSERT INTO `sc_log` (`idUsuario`, `ip`, `data`, `query`) VALUES ('$idUsuario', '$ip', '$data', '$logTratado')";
		$wpdb->query($sql);
}
/*
	function diasemana($data)
	{
		$ano =  substr("$data", 0, 4);
		$mes =  substr("$data", 5, -3);
		$dia =  substr("$data", 8, 9);
		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		switch($diasemana)
		{
			case"0": $diasemana = "Domingo";       break;
			case"1": $diasemana = "Segunda-Feira"; break;
			case"2": $diasemana = "Terça-Feira";   break;
			case"3": $diasemana = "Quarta-Feira";  break;
			case"4": $diasemana = "Quinta-Feira";  break;
			case"5": $diasemana = "Sexta-Feira";   break;
			case"6": $diasemana = "Sábado";        break;
		}
		return "$diasemana";
	}

function diasemanaint($data)
	{
		$ano =  substr("$data", 0, 4);
		$mes =  substr("$data", 5, -3);
		$dia =  substr("$data", 8, 9);
		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		
		return $diasemana;
	}
*/	
function noResend(){
	$p1 = $_SERVER["HTTP_REFERER"];
	$p2 = $_SERVER["QUERY_STRING"];
	echo $p1;
	header('Location:'.$p1, true, 301);
}
function mask($val, $tipo){
	
	//verifica se é só número
	if(is_float($val) == true){	
		$val = (string)$val;
		// prepara o tipo de mascara
		switch($tipo){
			case "cnpj": 
				$mask ='##.###.###/####-##';
			break;
			case "cpf":
				$mask = '###.###.###-##';
			break;
			case "cep":
				$mask ='#####-###';
			break;
			case "data":
				$mask ='##/##/####';
			break;
		}
		$maskared = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++)
		{
			if($mask[$i] == '#')
			{
				if(isset($val[$k]))
				$maskared .= $val[$k++];
			}
		else
			{
			if(isset($mask[$i]))
			$maskared .= $mask[$i];
			}
		}
	}else{
		$maskared = $val;
	}
	return $maskared;
}

function mesBr($m){
	switch ($m) {
        case "01":    $mes = 'Janeiro';     break;
        case "02":    $mes = 'Fevereiro';   break;
        case "03":    $mes = 'Março';       break;
        case "04":    $mes = 'Abril';       break;
        case "05":    $mes = 'Maio';        break;
        case "06":    $mes = 'Junho';       break;
        case "07":    $mes = 'Julho';       break;
        case "08":    $mes = 'Agosto';      break;
        case "09":    $mes = 'Setembro';    break;
        case "10":    $mes = 'Outubro';     break;
        case "11":    $mes = 'Novembro';    break;
        case "12":    $mes = 'Dezembro';    break; 
	}

 return $mes;
	
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
	

function tipo($id){
	global $wpdb;
	$sql = "SELECT * FROM sc_tipo WHERE id_tipo = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return $res;

}

/*
function proxQuinta($data){ // em Y-m-d
	$data = diasemanaint($data_se);
	if($data_se == 4{
		return $data;
	}else{
		while($data_se != 4){
			$data = somarDatas($data,"4");
		}

	
	}
	
	
}
*/	
	

	
	
	
function evento($id){

	global $wpdb;

	$sql =  "SELECT * FROM sc_evento WHERE idEvento = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	/*
	echo "<pre>";
	var_dump($programa);
	echo "</pre>";

	*/
	$programa = tipo($res['idPrograma']);
	
	$projeto = tipo($res['idProjeto']);
	$linguagem = tipo($res['idLinguagem']);
	$tipo_evento = tipo($res["idTipo"]);
	$usuario = get_userdata($res['idResponsavel']);
	if($usuario != NULL){
		$usercon = $usuario->first_name." ".$usuario->last_name;
	}else{
		$usercon = "";
	}
	$etaria = tipo($res['faixaEtaria']);
	$periodo = periodo($res['idEvento']);
	$status = retornaStatus($res['idEvento']);
	$local = retornaLocais($id);
	
	
	
	$evento = array(
		'titulo' => $res['nomeEvento'],
		'programa' => $programa['tipo'],
		'projeto' => $projeto['tipo'],
		'linguagem' => $linguagem['tipo'],
		'responsavel' => $usercon,
		'autor' => $res['autor'],
		'grupo' => $res['nomeGrupo'],
		'ficha_tecnica' => $res['fichaTecnica'],
		'sinopse' => $res['sinopse'],
		'release' => $res['releaseCom'],
		'status' => $status['status'],
		'usuario' => '',
		'sub' => '',
		'envio' => '',
		'periodo' => $periodo,
		'local' => $local,
		'faixa_etaria' => $etaria['tipo'],
		'valor_entrada' => '',
		'imagem' => '',
		'planejamento' => $res['planejamento'],
		'objeto' => $tipo_evento['tipo']." - ".$res['nomeEvento'],
		'tipo' => $tipo_evento['tipo'],
		'dataEnvio' => $res['dataEnvio']
	);

	
	
	$evento['mapas'] = array(
		'id' => $res['mapas'],
		'name' => $res['nomeEvento'],
		'shortDescription' => substr($res['sinopse'],0,390)."...",
		'longDescription' => $res['releaseCom'],
		'classificaoEtaria' => $etaria['tipo'],
	);
	
	//ocorrências
	$sql_oc = "SELECT * FROM sc_ocorrencia WHERE idEvento = '$id' AND publicado = '1'";
	$res_oc = $wpdb->get_results($sql_oc,ARRAY_A);
	for($i = 0;$i < count($res_oc); $i++){
		$id_local = tipo($res_oc[$i]['local']);
		$x = json_decode($id_local['descricao'],ARRAY_A);
		$mapas_local = $x['mapas'];
		$evento['mapas']['ocorrencia'][$i]['spaceId'] = $mapas_local;
		$oc_legivel = ocorrencia($res_oc[$i]['idOcorrencia']);
		if($res_oc[$i]['dataFinal'] == '0000-00-00'){ // evento de data úntica

			$evento['mapas']['ocorrencia'][$i]['frequency'] = "once";			
			$evento['mapas']['ocorrencia'][$i]['startsOn'] = $res_oc[$i]['dataInicio'];
			$evento['mapas']['ocorrencia'][$i]['startsAt'] = substr($res_oc[$i]['horaInicio'],0,5);
			$evento['mapas']['ocorrencia'][$i]['duration'] = $res_oc[$i]['duracao'];
			$evento['mapas']['ocorrencia'][$i]['until'] = '';
			$evento['mapas']['ocorrencia'][$i]['description'] = $oc_legivel['data'];
			if($res_oc[$i]['valorIngresso'] == 0){
				$evento['mapas']['ocorrencia'][$i]['price'] = "Grátis";
			}else{
				$evento['mapas']['ocorrencia'][$i]['price'] = dinheiroParaBr($res_oc[$i]['valorIngresso']);
			}
		}else{

			$evento['mapas']['ocorrencia'][$i]['frequency'] = "weekly";			
			$evento['mapas']['ocorrencia'][$i]['startsOn'] = $res_oc[$i]['dataInicio'];
			$evento['mapas']['ocorrencia'][$i]['startsAt'] = substr($res_oc[$i]['horaInicio'],0,5);
			$evento['mapas']['ocorrencia'][$i]['duration'] = $res_oc[$i]['duracao'];
			$evento['mapas']['ocorrencia'][$i]['until'] = $res_oc[$i]['dataFinal'];
			$evento['mapas']['ocorrencia'][$i]['description'] = $oc_legivel['data'];
			if($res_oc[$i]['valorIngresso'] == 0){
				$evento['mapas']['ocorrencia'][$i]['price'] = "Grátis";
			}else{
				$evento['mapas']['ocorrencia'][$i]['price'] = dinheiroParaBr($res_oc[$i]['valorIngresso']);
			}
			
			$evento['mapas']['ocorrencia'][$i]['day'] = array();
			
			if($res_oc[$i]['domingo'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][0] = 'on';
			}		
			if($res_oc[$i]['segunda'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][1] = 'on';
			}		
			if($res_oc[$i]['terca'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][2] = 'on';
			}		
			if($res_oc[$i]['quarta'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][3] = 'on';
			}		
			if($res_oc[$i]['quinta'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][4] = 'on';
			}		
			if($res_oc[$i]['sexta'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][5] = 'on';
			}		
			if($res_oc[$i]['sabado'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][6] = 'on';
			}		

			
			
		}
	}
	
	return $evento;
}


function metausuario($id){
	global $wpdb;
	$sql = "SELECT opcao FROM sc_opcoes WHERE entidade = 'usuario' AND id_entidade = '$id'";
	//echo $sql;
	$res = $wpdb->get_row($sql,ARRAY_A);
	return json_decode($res['opcao'],true);
}

function atividade($id){

	global $wpdb;

	$sql =  "SELECT * FROM sc_atividade WHERE id = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	/*
	echo "<pre>";
	var_dump($programa);
	echo "</pre>";

	*/
	$programa = tipo($res['idPrograma']);
	$projeto = tipo($res['idProjeto']);
	$usuario = get_userdata($res['idRes']);
	
	//$status = retornaStatus($res['idEvento']);
	
	$evento = array(
		'titulo' => $res['titulo'],
		'nome' => $res['titulo'],
		'objeto' => $res['titulo'],
		'periodo' => exibirDataBr($res['periodo_inicio'])." a ".exibirDataBr($res['periodo_fim']), 
		'tipoPessoa' => 'Pessoa jurídica',
		'programa' => $programa['tipo'],
		'projeto' => $projeto['tipo'],
		'responsavel' => $usuario->first_name." ".$usuario->last_name,
		//'status' => $status['status'],
		'usuario' => ''
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

		$data = "De ".exibirDataBr($oc['dataInicio'])." a ".exibirDataBr($oc['dataFinal'])." às ".substr($oc['horaInicio'],0,-3)." (".$oc['duracao']." minutos)".$sem;	
		
		
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
	$sql_orc = "SELECT * FROM sc_orcamento WHERE ano_base = '$ano_base' AND (valor <> '0.00' OR id = '142') AND publicado = '1' ORDER BY projeto ASC, ficha ASC ";
	$res = $wpdb->get_results($sql_orc,ARRAY_A);
	echo "<pre>";
	var_dump(($res));
	echo "</pre>";
	for($i = 0; $i < count($res) ; $i++){
		if($res[$i]['id'] == $id){
			echo "<option value = '".$res[$i]['id']."' selected > ".$res[$i]['projeto']."/".$res[$i]['ficha']." - ".$res[$i]['descricao']." </option>";
			//echo "<option>selected</option>";
		}else{
			echo "<option value = '".$res[$i]['id']."' > ".$res[$i]['projeto']."/".$res[$i]['ficha']." - ".$res[$i]['descricao']." </option>";
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

function insereAgenda($data,$id,$hora,$local,$log = false){
		global $wpdb;
		
		// limpa a ocorrencia na agenda
		$sql_ins = "INSERT INTO `sc_agenda` (`idEvento`, `data`, `hora`, `idLocal`) 
					VALUES ('$id', '$data', '$hora', '$local')"; 			
		$insere = $wpdb->query($sql_ins);
		if($log == true){var_dump($sql_ins)."<br />";};
		return $wpdb->insert_id;

}

function atualizarAgenda($id,$log = false){ //01
	global $wpdb;
	$sql_limpa =  "DELETE FROM `sc_agenda` WHERE idEvento = '$id'";
	$limpa = $wpdb->query($sql_limpa);
	$sql = "SELECT * FROM sc_ocorrencia WHERE idEvento = '$id' AND publicado = '1'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	if(count($res) > 0){ //02
		for($i = 0; $i < count($res); $i++){ //03
			if($res[$i]['dataFinal'] != '0000-00-00'){ // temporada //04
				$di = $res[$i]['dataInicio'];
				while(strtotime($di) < strtotime($res[$i]['dataFinal'])){
					if($log == true){ echo strtotime($di)." / ".strtotime($res[$i]['dataFinal'])."<br />"; }
					$n = nSemana($di);
					//echo $di."<br />";
					if($n == 0 AND $res[$i]['domingo'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
					}
								
					if($n == 1 AND $res[$i]['segunda'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
						
					}					
					if($n == 2 AND $res[$i]['terca'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
						
					}					
					if($n == 3 AND $res[$i]['quarta'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
						
					}					
					if($n == 4 AND $res[$i]['quinta'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
						
					}					
					if($n == 5 AND $res[$i]['sexta'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
						
					}					
					if($n == 6 AND $res[$i]['sabado'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
					}					
					$di = somarDatas($di,"+1");
				}	
			}else{ // data única //04
						$x = insereAgenda($res[$i]['dataInicio'],$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$res[$i]['dataInicio']." <br />";}

			}
			
		}//03
	}	
} //01 

function diasEfetivos($id){ //01
	global $wpdb;
	$sql = "SELECT * FROM sc_ocorrencia WHERE idEvento = '$id' AND publicado = '1'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	$ndias = 0;
	$minutos = 0;
	if(count($res) > 0){ //02
		for($i = 0; $i < count($res); $i++){ //03
			if($res[$i]['dataFinal'] != '0000-00-00'){ // temporada //04
				$di = $res[$i]['dataInicio'];

				while(strtotime($di) <= strtotime($res[$i]['dataFinal'])){
					$n = nSemana($di);
					//echo strtotime($di)." <= ".strtotime($res[$i]['dataFinal'])."($n)<br /> ";
					if($n == 0 AND $res[$i]['domingo'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];
						//echo "domingo";
					}
								
					if($n == 1 AND $res[$i]['segunda'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];

					
					}					
					if($n == 2 AND $res[$i]['terca'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];


						}					
					if($n == 3 AND $res[$i]['quarta'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];
					}					
					if($n == 4 AND $res[$i]['quinta'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];

					}					
					if($n == 5 AND $res[$i]['sexta'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];

					}					
					if($n == 6 AND $res[$i]['sabado'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];
					}					
					$di = somarDatas($di,"+1");
				}	
			}else{ // data única //04
				$ndias++;
				$minutos = $minutos + $res[$i]['duracao'];
			
			}
			
		}//03
	}
	$tempo = array('dias' => $ndias, 'minutos' => $minutos);
	return $tempo;
} //01 

function orcamento($id,$fim = NULL,$inicio = NULL){
	if($fim == NULL){
		$fim = date('Y')."-12-31";
	}
	if($inicio == NULL){
		$inicio = date('Y')."-01-01";
	}
	
	
	global $wpdb;
	$sel = "SELECT valor,dotacao,descricao, projeto, ficha, natureza, fonte FROM sc_orcamento WHERE id = '$id'";
	$val = $wpdb->get_row($sel,ARRAY_A);
	
	// Contigenciado (286)
	$sel_cont	= "SELECT valor FROM sc_mov_orc WHERE tipo = '286' AND idOrc = '$id' AND '$inicio' <= data AND '$fim' >= data AND publicado = '1'" ;
	$cont = $wpdb->get_results($sel_cont,ARRAY_A);
	$valor_cont = 0;
	for($i = 0; $i < count($cont); $i++){
		$valor_cont = $valor_cont + $cont[$i]['valor'];	
	}
	
	// Anulado (394)
	$sel_cont	= "SELECT valor FROM sc_mov_orc WHERE tipo = '394' AND idOrc = '$id' AND '$inicio' <= data AND '$fim' >= data AND publicado = '1'" ;
	$cont = $wpdb->get_results($sel_cont,ARRAY_A);
	$valor_anul = 0;
	for($i = 0; $i < count($cont); $i++){
		$valor_anul = $valor_anul + $cont[$i]['valor'];	
	}
	
	
	// Descontigenciado (287)
	$sel_cont	= "SELECT valor FROM sc_mov_orc WHERE tipo = '287' AND idOrc = '$id' AND '$inicio' <= data AND '$fim' >= data AND publicado = '1'";
	$cont = $wpdb->get_results($sel_cont,ARRAY_A);
	$valor_desc = 0;
	for($i = 0; $i < count($cont); $i++){
		$valor_desc = $valor_desc + $cont[$i]['valor'];	
	}
	

	// Suplemento (288)
	$sel_cont	= "SELECT valor FROM sc_mov_orc WHERE tipo = '288' AND idOrc = '$id' AND '$inicio' <= data AND '$fim' >= data AND publicado = '1'";
	$cont = $wpdb->get_results($sel_cont,ARRAY_A);
	$valor_supl = 0;
	for($i = 0; $i < count($cont); $i++){
		$valor_supl = $valor_supl + $cont[$i]['valor'];	
	}
	
	// Histórico
	$sel_hist = "SELECT id, titulo,valor, descricao, tipo, idUsuario,data,idPedidoContratacao FROM sc_mov_orc WHERE idOrc = '$id' AND '$inicio' <= data AND '$fim' >= data AND publicado = '1' ORDER BY data ASC ";
	$hist = $wpdb->get_results($sel_hist,ARRAY_A);
		
	
	// liberado
	$sql_lib = "SELECT valor FROM sc_contratacao WHERE dotacao = '$id' AND liberado <> '0000-00-00' AND publicado = '1'";
	$lib = $wpdb->get_results($sql_lib,ARRAY_A);
	$valor_lib = 0;
	for($i = 0; $i < count($lib); $i++){
		$valor_lib = $valor_lib + $lib[$i]['valor'];	
	}

	//planejado 
	
	$valor_pla_pf = 0;
	$valor_pla_pj = 0;
	$valor_pla = 0;
	/*
	$sql_pla_pf = "SELECT valor FROM sc_contratacao WHERE dotacao = '$id' AND tipoPessoa =  '1' AND idPessoa IN (SELECT DISTINCT Id_PessoaFisica FROM sc_pf WHERE CPF = '000.000.000-00') AND publicado = '1'";
	$pla_pf = $wpdb->get_results($sql_pla_pf,ARRAY_A);
	if(count($pla_pf) > 0){
		for($i = 0; $i < count($pla_pf); $i++){
			$valor_pla_pf = $valor_pla_pf + $pla_pf[$i]['valor'];	
		}
	}

	$sql_pla_pj = "SELECT valor FROM sc_contratacao WHERE dotacao = '$id' AND tipoPessoa =  '2' AND idPessoa IN (SELECT DISTINCT Id_PessoaJuridica FROM sc_pj WHERE CNPJ = '00.000.000/0000-00') AND publicado = '1'";
	$pla_pj = $wpdb->get_results($sql_pla_pj,ARRAY_A);
	if(count($pla_pj) > 0){
		for($k = 0; $k < count($pla_pj); $k++){
			$valor_pla_pj = $valor_pla_pj + $pla_pj[$k]['valor'];	
		}
	}

	
	*/
	
	//$sql_pla = "SELECT valor FROM sc_orcamento WHERE idPai = '$id' AND publicado = '1'";
	$sql_pla = "SELECT * FROM sc_orcamento, sc_tipo  WHERE idPai = '$id' AND sc_orcamento.publicado = '1' AND sc_tipo.publicado ='1' AND sc_tipo.id_tipo = sc_orcamento.planejamento";
	$pla = $wpdb->get_results($sql_pla,ARRAY_A);
	if(count($pla) > 0){
		for($i = 0; $i < count($pla); $i++){
			$valor_pla = $valor_pla + $pla[$i]['valor'];	
		}
	}
	
	
	$dotacao = array(
	'descricao' => $val['descricao'],
	'dotacao' => $val['dotacao'],
	'total' => 	$val['valor'],
	'contigenciado' => $valor_cont,
	'descontigenciado' => $valor_desc,
	'suplementado' => $valor_supl,
	'historico' => $hist,
	'visualizacao' => $val['projeto']."/".$val['ficha'], //colocar natureza (importar de novo)
	'natureza' => $val['natureza']."/".$val['fonte'],	
	'liberado' => $valor_lib,
	'planejado' => $valor_pla,
	'anulado' => $valor_anul,
	'projeto' =>  $val['projeto'],
	'ficha' => $val['ficha']

	);
	
	
	return $dotacao;
	
}

function historicoOrcamento($id){
	global $wpdb;
	$sel_hist = "SELECT id, titulo,valor, descricao, tipo, idUsuario,data FROM sc_mov_orc WHERE idOrc = '$id' AND '$inicio' <= data AND '$fim' >= data AND publicado = '1' ORDER BY data ASC ";
	$hist = $wpdb->get_results($sel_hist,ARRAY_A);
	
	$sel_con = "SELECT idPedidoContratacao,idEvento,idAtividade, valor, liberado, observacao FROM sc_contratacao WHERE dotacao = '$i' AND liberado <> '0000-00-00'";
	$con = $wpdb->get_results($sel_con,ARRAY_A);
	$k = count($hist);
	for($i = 0; $i < count($con) ; $i++){
		$x = retornaPedido($con[$i]['idPedidoContratacao']);
		
		$hist[$k]['id'] = $con[$i]['idPedidoContratacao'];
		$hist[$k]['titulo'] = $x['objeto']." - ".$x['obs'];
		$hist[$k]['valor'] = $con[$i]['valor'];
		$hist[$k]['descricao'] = "Contratação da Empresa/Pessoa: ".$x['nome']." para ".$x['objeto']." no período ". $x['periodo']." em ".$x['local'];
		$hist[$k]['tipo'] = "Liberação";
		$hist[$k]['idUsuario'] = "";
		$hist[$k]['data'] = $con[$i]['liberado'];
		$k++;
	}
	//asort($hist,)
	
	return $hist;
	
	
	
}


function atualizaHistorico($idPedidoContratacao){
	// Liberação = 311, Empenho = 395
	// liberado, empenhado
	$user = wp_get_current_user();
	global $wpdb;
	$x = retornaPedido($idPedidoContratacao);
	$sql_ver_mov = "SELECT * FROM sc_mov_orc WHERE idPedidoContratacao = '$idPedidoContratacao'";
	$res_ver_mov = $wpdb->get_row($sql_ver_mov,ARRAY_A);
	if($res_ver_mov == NULL){ //insere
		if($x['liberado'] != '0000-00-00'){
			$titulo = $x['objeto'];
			$idOrc = $x['idDot'];
			$data = $x['liberado'];
			$valor = dinheiroDeBr($x['valor']);
			$descricao = "Contratação de ".$x['nome_razaosocial']."( ".$x['cpf_cnpj']. ") para ".$x['objeto']." no período ".$x['periodo'];
			if($x['local'] != ''){
				$descricao .= " em ".$x['local'];
			}

			$id_user = $user->ID;
			
			$sql = "INSERT INTO `sc_mov_orc` (`titulo`, `tipo`,  `idOrc`, `data`, `valor`, `descricao`, `idUsuario`, `publicado`, `idPedidoContratacao`) VALUES ('$titulo', '311',  '$idOrc', '$data', '$valor', '$descricao', '$id_user', '1', '$idPedidoContratacao')";	
			$q = $wpdb->query($sql);
			if($q == 0){
				$q = $sql;
			}
		}
		
	}else{ // atualiza
	$id = $res_ver_mov['id'];
	$valor = dinheiroDeBr($x['valor']);
	$data = $x['liberado'];
	$idOrc = $x['idDot'];
	$descricao = "Contratação de ".$x['nome_razaosocial']."( ".$x['cpf_cnpj']. ") para ".$x['objeto']." no período ".$x['periodo'];
	if($x['local'] != ''){
		$descricao .= " em ".$x['local'];
	}
		if($x['liberado'] != '0000-00-00'){
			$sql = "UPDATE sc_mov_orc SET 
			valor = '$valor',
			data = '$data',
			idOrc = '$idOrc',
			descricao = '$descricao',
			publicado = '1'
			WHERE id = '$id'";
			$q = $wpdb->query($sql);
			if($q == 0){
				$q = $sql;
			}			
		}else{
			$sql = "UPDATE sc_mov_orc SET 
			publicado = '0'
			WHERE id = '$id'";
			$q = $wpdb->query($sql);
			if($q == 0){
				$q = $sql;
			}
		}
		
	}
	
	return $q;
}


/* Funções para Pedidos de Contratação */


function retornaPessoa($id,$tipo){
	global $wpdb;
	$x = array();
	if($tipo == 1){
		$sql = "SELECT Nome, CPF, Email, codBanco, agencia, conta, Telefone1 FROM sc_pf WHERE Id_PessoaFisica = '$id'";
		$res = $wpdb->get_row($sql,ARRAY_A);	
		$b = tipo($res['codBanco']);
		$codBanco = json_decode($b['descricao'],true);

		$x['nome'] = $res['Nome'];
		$x['cpf_cnpj'] = $res['CPF'];
		$x['tipoPessoa'] = "Pessoa Física";
		$x['email'] = $res['Email'];
		$x['banco'] = "Banco: ".$b['tipo']." (".$codBanco['codBanco'].") / Agência: ".$res['agencia']." / Conta Corrente: ".$res['conta'];
		$x['telefone'] = $res['Telefone1'];
		
	}else{
		$sql = "SELECT RazaoSocial, CNPJ, Email, codBanco, agencia, conta, Telefone1 FROM sc_pj WHERE Id_PessoaJuridica = '$id'";
		$res = $wpdb->get_row($sql,ARRAY_A);	
		$b = tipo($res['codBanco']);
		$codBanco = json_decode($b['descricao'],true);
		$x['nome'] = $res['RazaoSocial'];
		$x['cpf_cnpj'] = $res['CNPJ'];
		$x['tipoPessoa'] = "Pessoa Jurídica";
		$x['email'] = $res['Email'];
		$x['banco'] = "Banco: ".$b['tipo']." (".$codBanco['codBanco'].") / Agência: ".$res['agencia']." / Conta Corrente: ".$res['conta'];
		$x['telefone'] = $res['Telefone1'];

		}
	return $x;

}


function listaPedidos($id,$tipo){ //lista os pedidos de contratação de determinado pedido

	global $wpdb;

	switch($tipo){
		case 'evento':
		default:
			$sql = "SELECT idPedidoContratacao, tipoPessoa, idPessoa, valor, dotacao FROM sc_contratacao WHERE idEvento = '$id' AND publicado = '1'";
		break;
		case 'atividade' :
			$sql = "SELECT idPedidoContratacao, tipoPessoa, idPessoa, valor, dotacao FROM sc_contratacao WHERE idAtividade = '$id' AND publicado = '1'";
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
		'idPessoa' => $res[$i]['idPessoa'],
		'cpf_cnpj' => $pessoa['cpf_cnpj'],
		'dotacao' => $res[$i]['dotacao']
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


function opcaoDados($tipo,$id){
	global $wpdb;
	$sql = "SELECT opcao FROM sc_opcoes WHERE entidade = '$tipo' AND id_entidade = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return json_decode($res['opcao'],true);
	
}


function retornaPedido($id){
	global $wpdb;
	$sql_tipo = "SELECT idEvento, idAtividade FROM sc_contratacao WHERE idPedidoContratacao = '$id'";
	$res_tipo = $wpdb->get_row($sql_tipo,ARRAY_A);
	
	if($res_tipo['idEvento'] != 0){
	
	
	$sql = "SELECT valor, tipoPessoa, idPessoa, sc_evento.idEvento, idResponsavel, dotacao, valor, formaPagamento, empenhado, liberado, parcelas, observacao, integrantesGrupo, nLiberacao, nProcesso,  sc_evento.dataEnvio  FROM sc_contratacao, sc_evento WHERE idPedidoContratacao = '$id' AND sc_evento.idEvento = sc_contratacao.idEvento ";
	$res = $wpdb->get_row($sql,ARRAY_A);
	$pessoa = retornaPessoa($res['idPessoa'],$res['tipoPessoa']);
	$objeto = evento($res['idEvento']);
	$periodo = periodo($res['idEvento']);
	$userwp = get_userdata($res['idResponsavel']);
	$metausuario = opcaoDados("usuario",$res['idResponsavel']);
	if(!isset($metausuario['cr'])){
		$metausuario['cr'] = "";
	}
	if(!isset($metausuario['telefone'])){
		$metausuario['telefone'] = "";
	}
	if(!isset($metausuario['funcao'])){
		$metausuario['funcao'] = "";
	}
	if(!isset($metausuario['departamento'])){
		$metausuario['departamento'] = "";
	}
	$dotac = recuperaDados("sc_orcamento",$res['dotacao'],"id");
	if(!is_array($dotac)){
		$dotac = array(
			'dotacao' => '',
			'ficha' => '',
			'projeto' => '',
			'fonte' => ''
		);
	}
	
	$local = retornaLocais($res['idEvento']);
	$end = retornaEndereco($res['tipoPessoa'],$res['idPessoa']);
	$status = "Em análise";
	if('0000-00-00' != $res['empenhado']){
		$status = 'Empenhado';
	}else if('0000-00-00' != $res['liberado']){
		$status = 'Liberado';
	}
	if($pessoa['tipoPessoa'] == 1){
		$pes = "Física";
	}else{
		$pes = "Jurídica";
	}
	
	if($userwp == NULL){
		$usuario = "";
	}else{
		$usuario = $userwp->first_name." ".$userwp->last_name;
	}
	
	$x = array();
	$x['evento_atividade'] = 'evento';
	$x['id'] = $res['idEvento'];
	$x['nome'] = $pessoa['nome'];
	$x['objeto'] = $objeto['objeto'];	
	$x['autor'] = $objeto['autor'];
	$x['periodo'] = $periodo['legivel'];
	$x['usuario'] = $usuario;
	$x['area'] = $metausuario['departamento'];
	$x['cargo'] = $metausuario['funcao'];
	$x['tipoPessoa'] = $pessoa['tipoPessoa'];
	$x['pessoa'] = $pes;
	$x['nome_razaosocial'] = $pessoa['nome'];
	$x['cpf_cnpj'] = $pessoa['cpf_cnpj'];
	$x['cr'] = $metausuario['cr'];
	$x['idDot'] = $res['dotacao'];
	$x['cod_dotacao'] = $dotac['dotacao'];
	$x['ficha'] = $dotac['ficha'];
	$x['projeto'] = $dotac['projeto'];
	$x['despesa'] = "";
	$x['fonte'] = $dotac['fonte'];
	$x['telefone'] = $pessoa['telefone'];
	$x['conta_corrente'] = "";
	$x['contato_telefone'] = $metausuario['telefone'];
	$x['local'] = $local;
	$x['tipo'] = $objeto['tipo'];
	$x['end'] = $end;
	$x['email'] = $pessoa['email'];
	$x['valor'] = dinheiroParaBr($res['valor']);
	$x['valor_extenso'] = valorPorExtenso($res['valor']);
	$x['forma_pagamento'] = $res['formaPagamento'];
	$x['banco'] = $pessoa['banco'];
	$x['liberado'] = $res['liberado'];
	$x['empenhado'] = $res['empenhado'];
	$x['status'] = $status;
	$x['parcelas'] = $res['parcelas'];
	$x['integrantes'] = $res['integrantesGrupo'];
	$x['obs'] = $res['observacao'];
	$x['nLiberacao'] = $res['nLiberacao'];
	$x['nProcesso'] = $res['nProcesso'];
	$x['dataEnvio'] = $res['dataEnvio'];
	return $x;
	}
	
	if($res_tipo['idAtividade'] != 0){
	$sql = "SELECT valor, tipoPessoa, idPessoa, sc_atividade.id, idRes, dotacao, valor, formaPagamento, empenhado, liberado, parcelas, observacao, nLiberacao, sc_contratacao.dataEnvio FROM sc_contratacao, sc_atividade WHERE idPedidoContratacao = '$id' AND sc_atividade.id = sc_contratacao.idAtividade";
	$res = $wpdb->get_row($sql,ARRAY_A);
	$pessoa = retornaPessoa($res['idPessoa'],$res['tipoPessoa']);
	$objeto = atividade($res['id']);
	$userwp = get_userdata($res['idRes']);
	if($userwp == NULL){
		$usuario = "";
	}else{
		$usuario = $userwp->first_name." ".$userwp->last_name;
	}
	$metausuario = opcaoDados("usuario",$res['idRes']);
		if(!isset($metausuario['cr'])){
		$metausuario['cr'] = "";
	}
	if(!isset($metausuario['telefone'])){
		$metausuario['telefone'] = "";
	}
	if(!isset($metausuario['funcao'])){
		$metausuario['funcao'] = "";
	}
	if(!isset($metausuario['departamento'])){
		$metausuario['departamento'] = "";
	}
	
	if($res['dotacao'] != NULL){
		$dotac = recuperaDados("sc_orcamento",$res['dotacao'],"id");
	}else{
		$dotac['dotacao'] = "";
		$dotac['ficha'] = "";
		$dotac['projeto'] = "";
		$dotac['fonte'] = "";
	}
	
	$local = "";
	$end = retornaEndereco($res['tipoPessoa'],$res['idPessoa']);
	$status = "Em análise";
	
	$x = array();
	$x['evento_atividade'] = 'atividade';
	$x['id'] = $res['id'];
	$x['nome'] = $pessoa['nome'];
	$x['objeto'] = $objeto['objeto'];	
	$x['autor'] = "";
	$x['periodo'] = $objeto['periodo'];
	$x['usuario'] = $usuario;
	$x['area'] = $metausuario['departamento'];
	$x['cargo'] = $metausuario['funcao'];
	$x['tipoPessoa'] = $pessoa['tipoPessoa'];
	$x['pessoa'] = "Pessoa Jurídica";
	$x['nome_razaosocial'] = $pessoa['nome'];
	$x['cpf_cnpj'] = $pessoa['cpf_cnpj'];
	$x['cr'] = "";
	$x['idDot'] = $res['dotacao'];
	$x['cod_dotacao'] = $dotac['dotacao'];
	$x['ficha'] = $dotac['ficha'];
	$x['projeto'] = $dotac['projeto'];
	$x['despesa'] = "";
	$x['fonte'] = $dotac['fonte'];
	$x['telefone'] = $metausuario['telefone'];
	$x['conta_corrente'] = "";
	$x['contato_telefone'] = $pessoa['telefone'];
	$x['local'] = $local;
	$x['tipo'] = "";
	$x['end'] = $end;
	$x['email'] = $pessoa['email'];
	$x['valor'] = dinheiroParaBr($res['valor']);
	$x['valor_extenso'] = valorPorExtenso($res['valor']);
	$x['forma_pagamento'] = $res['formaPagamento'];
	$x['banco'] = $pessoa['banco'];
	$x['liberado'] = $res['liberado'];
	$x['empenhado'] = $res['empenhado'];
	$x['status'] = $status;
	$x['parcelas'] = $res['parcelas'];
	$x['obs'] = $res['observacao'];
	$x['integrantes'] = "";
	$x['nLiberacao'] = $res['nLiberacao'];
	$x['dataEnvio'] = $res['dataEnvio'];
	return $x;	
	}
	
	
	
	
	
}

function opcoes($id,$entidade){
	global $wpdb;
	$sql = "SELECT * FROM sc_opcoes WHERE entidade = '$entidade' AND id_entidade = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	$json = json_decode($res['opcao'],true);
	return $json;
}

function retornaLocais($idEvento){
	global $wpdb;
	$sql = "SELECT DISTINCT local FROM sc_ocorrencia WHERE publicado = '1' AND idEvento = '$idEvento'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	$x = "";
	for($i = 0; $i < count($res) ; $i++){
		$t = tipo($res[$i]['local']);
		$x .= $t['tipo'].",";
	
	}
	return  substr($x, 0, -1);
	
}

function retornaCEP($cep){
	global $wpdb;
	$cep_index = substr($cep, 0, 5);
	$dados['sucesso'] = 0;
	$sql01 = "SELECT * FROM igsis_cep_cep_log_index WHERE cep5 = '$cep_index' LIMIT 0,1";
	$campo01 = $wpdb->get_row($sql01,ARRAY_A);
	$uf = "igsis_cep_".$campo01['uf'];
	$sql02 = "SELECT * FROM $uf WHERE cep = '$cep'";
	$campo02 = $wpdb->get_row($sql02,ARRAY_A);
	$res = count($campo02);
	 if($res > 0){
	$dados['sucesso'] = 1;
	 }else{
	$dados['sucesso'] = 0;
	 }
	$dados['rua']     = $campo02['tp_logradouro']." ".$campo02['logradouro'];
	$dados['bairro']  = $campo02['bairro'];
	$dados['cidade']  = $campo02['cidade'];
	$dados['estado']  = strtoupper($campo01['uf']);
	return $dados;
}


function retornaEndereco($tipo,$pessoa){
	global $wpdb;
	switch ($tipo){
		case 1:
		$sql = "SELECT CEP, Numero, Complemento FROM sc_pf WHERE Id_PessoaFisica = '$pessoa' ";
		$res = $wpdb->get_row($sql,ARRAY_A);
		$dados = retornaCEP($res['CEP']);
		
		$end = $dados['rua'].", ".$res['Numero']." - ".$res['Complemento']. " ".$dados['bairro']. " " .$dados['cidade']. " / ".$dados['estado']."<br />CEP:".$res['CEP'];
		
		return $end;
		
		break;		

		case 2:
		$sql = "SELECT CEP, Numero, Complemento FROM sc_pj WHERE Id_PessoaJuridica = '$pessoa' ";
		$res = $wpdb->get_row($sql,ARRAY_A);
		$dados = retornaCEP($res['CEP']);
		
		$end = $dados['rua'].", ".$res['Numero']." - ".$res['Complemento']. " ".$dados['bairro']. " " .$dados['cidade']. " / ".$dados['estado']."<br />CEP:".$res['CEP'];
		
		return $end;
		
		break;
		
	}
	
}

function resumoDotacao($dotacao){
	
	/*	[0]70
		[1]10
		[2].3
		[3].3
		[4].90
		[5].39
		[6].13
		[7].392
		[8].0072
		[9].2
		[10].189
		[11].01 

	*/
	global $wpdb;

	if(strlen($dotacao) > 5){ //veio inteiro
		$x = explode(".",$dotacao);
		$resumo = $x[0].$x[1].".".$x[2].$x[3].$x[4].$x[5].".".$x[10];
	
	}else{ //veio o id
		$sql = "SELECT dotacao FROM sc_orcamento WHERE id = '$dotacao'";
		$res = $wpdb->get_row($sql,ARRAY_A);
		$x = explode(".",$res['dotacao']);
		$resumo = $x[0].$x[1].".".$x[2].$x[3].$x[4].$x[5].".".$x[10];
	}
	return $resumo;
	
}

function parcela($id){
	global $wpdb;
	$sel = "SELECT * FROM sc_parcela WHERE idPedidoContratacao = '$id'";
	$res = $wpdb->get_results($sel,ARRAY_A);
	if(count($res) == 0){
		return NULL;
	}else{
		for($i = 0; $i < count($res); $i++){
			$x[$i+1] = $res[$i];
		}
		
		return $x;
	}
	
}




function verificaEvento($idEvento){
	/*
	Evento 
	Campos obrigatórios sc_evento:
		Nome do Evento
		Programa
		Projeto
		Linguagem
		Tipo de Evento
		Responsável
		Autor
		Classificação
		Sinopse
		Cidade
		Número de Agentes envolvidos
		Número de Agentes envolvidos de Santo André e Região
		
	
	
	
	Ocorrência
	Campos obrigatórios sc_ocorrencia:
		Data 
		Se data final
			Dias da semana
		horário
		local
		
	
	Se existir contratação
		Campos obrigatórios
		Valor
		Dotação
		Justificativa
		Parecer Artístico
	*/
	
	global $wpdb;
	
	$relatorio = "";
	$r = 0;
	$evento = evento($idEvento);
	
	
	if($evento['titulo'] == "" OR $evento['titulo'] == NULL){
		$relatorio .= "O evento não possui título.<br />";
		$r++;	
	}

	if($evento['programa'] == "" OR $evento['programa'] == NULL){
		$relatorio .= "Não foi determinado um programa.<br />";
		$r++;	
	}

	if($evento['projeto'] == "" OR $evento['projeto'] == NULL){
		$relatorio .= "Não foi determinado um projeto.<br />";
		$r++;	
	}

	if($evento['linguagem'] == "" OR $evento['linguagem'] == ""){
		$relatorio .= "Não foi determinado uma linguagem.<br />";
		$r++;	
	}

	if($evento['responsavel'] == "" OR $evento['responsavel'] == ""){
		$relatorio .= "O evento não possui responsável.<br />";
		$r++;	
	}

	if($evento['autor'] == "" OR $evento['autor'] == ""){
		$relatorio .= "O evento não possui um autor.<br />";
		$r++;	
	}	

	
	if($evento['faixa_etaria'] == "" OR $evento['faixa_etaria'] == ""){
		$relatorio .= "O evento não possui uma classificação etária.<br />";
		$r++;	
	}

	if($evento['sinopse'] == "" OR $evento['sinopse'] == ""){
		$relatorio .= "O evento não possui uma sinopse.<br />";
		$r++;	
	}

	/*
	if($evento['artista_local'] == 0){
		$relatorio .= "É preciso informar a origem do artista (local).<br />";
		$r++;	
	}	
	
	if($evento['n_agentes'] == 0){
		$relatorio .= "É preciso informar o número de agentes culturais envolvidos. Informe também o número de agentes culturais de Santo André e região<br />";
	}	
	*/
	
	//Ocorrencias
	$ocorrencias = periodo($idEvento);
	if($ocorrencias['bool'] == FALSE){
		$relatorio .= "O evento não possui ocorrências.<br />";
		$r++;
	}else{
		$sql_ocor = "SELECT * FROM sc_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1'";
		$res = $wpdb->get_results($sql_ocor,ARRAY_A);
		for ($i = 0; $i < count($res); $i++){
			if($res[$i]['local'] == 0){
				$relatorio .= "Há ocorrências sem locais.<br />";
				$r++;
			} 
			if($res[$i]['horaInicio'] == '00:00:00'){
				$relatorio .= "Há ocorrências sem hora de início.<br />";
				$r++;
			} 

			if($res[$i]['duracao'] == '0'){
				$relatorio .= "Há ocorrências sem duração.<br />";
				$r++;
			} 
		}
	}

	$pedidos = listaPedidos($idEvento,'evento');	
	if(count($pedidos) > 0){
		//$relatorio .= "O evento possui pedidos de contratação.<br />";
		//$ped = retornaPedido($pedidos[$i]['idPedidoContratacao']);
		for($k = 0; $k < count($pedidos); $k++){
			if($pedidos[$k]['dotacao'] == NULL){
				$relatorio .= "Há pedidos de contratação sem dotação definida.<br />";
				$r++;
			}
			if($pedidos[$k]['valor'] == 0){
				$relatorio .= "Há pedidos de contratação sem valores definidos.<br />";
				$r++;
			}
		}		
		
		
		
		
		
		
	}else{
		//$relatorio .= "O evento não possui pedidos de contratação.<br />";
		
	}
	
	
	$x['relatorio'] = $relatorio;
	$x['erros'] = $r;
	return $x;
		
	
	
}

function listaArquivos($entidade,$id){
	global $wpdb;
	$sql = "SELECT arquivo FROM sc_arquivo WHERE entidade ='$entidade' AND id = '$id' AND publicado = '1'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	return $res;
}

function retornaStatus($idEvento){
	global $wpdb;
	$sql = "SELECT dataEnvio FROM sc_evento WHERE idEvento = '$idEvento' AND planejamento = '0'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	$x = array(
		'status' => ''
	);
	if($res['dataEnvio'] == NULL){ // evento em elaboração
		$x['status'] = 'Em elaboração';
	}else{ // enviado
		$x['status'] = 'Publicado';		
	}
	return $x;
	
	
}





/* Fim das Funções para Pedidos de Contratação */


/* Editais */

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


function retornaNota($inscricao,$criterio,$usuario){
	global $wpdb;
	$sql = "SELECT nota FROM ava_nota WHERE usuario = '$usuario' AND criterio = '$criterio' AND inscricao = '$inscricao'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	if(count($res) > 0){
		return $res['nota'];
	}else{
		return 0;
	}
	
}

function somaNotas($inscricao,$usuario,$edital){
	global $wpdb;
	$sql_soma = "SELECT nota FROM `ava_nota` WHERE inscricao = '$inscricao' AND usuario ='$usuario' AND edital ='$edital'";
	$res = $wpdb->get_results($sql_soma,ARRAY_A);
	$total = 0;
	if(count($res) > 0){
		for($i = 0; $i < count($res); $i++){
			$total = $total + $res[$i]['nota'];			
		} 
	}
	return $total;
}

function retornaAnotacao($inscricao,$usuario,$edital = NULL){
	global $wpdb;
	$sql_sel_obs = "SELECT anotacao FROM ava_anotacao WHERE usuario = '".$usuario."' AND inscricao = '".$inscricao."' AND edital = '$edital'";
	$res_obs = $wpdb->get_row($sql_sel_obs,ARRAY_A);
	return $res_obs['anotacao'];
}

function atualizaNota($inscricao){
	global $wpdb;
	$nota_total = 0;	
	
	// seleciona os pareceridas
	$sql_pareceristas = "SELECT DISTINCT usuario FROM ava_nota WHERE inscricao = '$inscricao'";
	$query_pareceristas = $wpdb->get_results($sql_pareceristas,ARRAY_A);
	$numero = count($query_pareceristas);
	
	if($numero != 0){
	
		for($k = 0; $k < $numero; $k++){
			$nota[$k] = somaNotas($inscricao,$query_pareceristas[$k]['usuario'],273);		
			$nota_total = $nota_total + $nota[$k];
		}
	
	$nota_total = $nota_total/$numero;
	$discrepancia = 0;
	if($numero == 2){
		$discrepancia = moduloAritimetica($nota[0] - $nota[1]);
	}
	
	
	
	//atualiza ranking
	$update_ranking = "UPDATE ava_ranking SET nota = '$nota_total', discrepancia = '$discrepancia' WHERE inscricao = '$inscricao'";
	$wpdb->query($update_ranking);
	}
}

function atualizaNota2Fase($inscricao){
	global $wpdb;
	$nota_total = 0;	
	
	// seleciona os pareceridas
	$sql_pareceristas = "SELECT DISTINCT usuario FROM ava_nota WHERE inscricao = '$inscricao' AND edital = '349'";
	$query_pareceristas = $wpdb->get_results($sql_pareceristas,ARRAY_A);
	$numero = count($query_pareceristas);
	if($numero != 0){
		
		$sql_soma = "SELECT nota FROM ava_nota WHERE inscricao ='$inscricao' AND edital='349'";
		$soma = $wpdb->get_results($sql_soma,ARRAY_A);
		$total_nota = 0;
		for($i = 0; $i < count($soma); $i++){
			$total_nota = $total_nota + $soma[$i]['nota'];
		}	
			
	
	$nota_total = $total_nota/$numero;
	$discrepancia = 0;
	if($numero == 2){
		//$discrepancia = moduloAritimetica($nota[0] - $nota[1]);
	}
	
	$sql_2fase = "SELECT nota FROM ava_nota WHERE inscricao = '$inscricao' AND edital = '350'";
	$res_2fase = $wpdb->get_row($sql_2fase,ARRAY_A);
	
	if(count($res_2fase) > 0){
		$nota_total = $nota_total + $res_2fase['nota'];
		var_dump($nota_total);
	}
	

	
	//atualiza ranking
	$update_ranking = "UPDATE ava_ranking SET nota = '$nota_total' WHERE inscricao = '$inscricao'";
	$x = $wpdb->query($update_ranking);
	if($x){
		return "Ranking atualizado.";
	}else{
		return "Erro ao atualizar ranking";
	}
	
	}
}

function moduloAritimetica($numero){
	if($numero < 0){
		return $numero*(-1);
	}else{
		return $numero;
	}
}

function retornaCriterio($id){
	global $wpdb;
	$sql = "SELECT * FROM ava_criterios WHERE id = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return $res;
}

function valorNotaMax($inscricao,$usuario){
	global $wpdb;
	$sql = "SELECT nota,criterio FROM ava_nota WHERE inscricao = '$inscricao' AND usuario = '$usuario'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	for($i = 0;$i < count($res); $i++){
		$nota = $res[$i]['nota'];
		$x = retornaCriterio($res[$i]['criterio']);
		$corte = $x['nota_maxima'];
		if($nota > $corte){
			$sql_update = "UPDATE ava_nota SET nota = '$corte' WHERE inscricao = '$inscricao' AND usuario = '$usuario' AND criterio = '".$res[$i]['criterio']."'";
			$wpdb->query($sql_update);
		}
	}
}

function nota($inscricao){
	global $wpdb;
	$nota_total = 0;	
	$x = array();
	
	$sql_pareceristas = "SELECT DISTINCT usuario FROM ava_nota WHERE inscricao = '$inscricao' AND edital = '349'";
	$query_pareceristas = $wpdb->get_results($sql_pareceristas,ARRAY_A);
	$numero = count($query_pareceristas);
	
	if($numero != 0){
	
		for($k = 0; $k < $numero; $k++){
			$nota[$k] = somaNotas($inscricao,$query_pareceristas[$k]['usuario'],349);		
			$nota_total = $nota_total + $nota[$k];
			$x['pareceristas'][$k]['usuario'] = $query_pareceristas[$k]['usuario'];
			$x['pareceristas'][$k]['nota'] = $nota[$k];
		}
	
	$nota_total = $nota_total/$numero;
	$discrepancia = 0;

	if($numero == 2){
		$discrepancia = moduloAritimetica($nota[0] - $nota[1]);
	
	}

	$x['media'] = $nota_total;

	return $x;
	
	}
}

function retornaNotaTotal($inscricao,$usuario,$edital){
	global $wpdb;
	$nota = 0;
	$sql = "SELECT nota FROM ava_nota WHERE usuario = '$usuario' AND inscricao ='$inscricao' AND edital = '$edital'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	for($i = 0; $i < count($res); $i++){
		$nota = $nota + $res[$i]['nota'];
		
	}
	return $nota;
	
	
}

function retornaNota2Fase($inscricao){
	global $wpdb;
	$sql = "SELECT nota FROM ava_nota WHERE inscricao = '$inscricao' AND edital = '350'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return $res['nota'];
}

function listarAvaliadores($inscricao){
	global $wpdb;
	$nota = "";
//	$sql = "SELECT DISTINCT usuario FROM ava_nota WHERE inscricao = '$inscricao'";
	$sql = "SELECT usuario  FROM `ava_nota` WHERE `inscricao` LIKE '$inscricao' AND `edital` = 273 ORDER BY `usuario` DESC";

	//$res = $wpdb->get_results($sql,ARRAY_A);
	$res_ava = $wpdb->get_results($sql,ARRAY_A);
	$x = "";	
	for($i = 0; $i < count($res_ava); $i++){
		if($x != $res_ava[$i]['usuario']){
			$wpuser = get_userdata($res_ava[$i]['usuario']);
			$nota = $nota . $wpuser->first_name." / ";
			$x = $res_ava[$i]['usuario'];
		}
	}
	return $nota;
}

function verificaAvaliacao($usuario,$edital){
	global $wpdb;
	$anotacao = 0;
	$zeradas = 0;
	$matriz = array();
	
	$tipo = 'usuario';
	$id = $usuario;
	$x = opcaoDados($tipo,$id);
	$g = $x['edital'][1];
	$sql_sel_ins = "SELECT avaliadores FROM ava_edital WHERE id_mapas = '$edital'";
	$sel = $wpdb->get_row($sql_sel_ins,ARRAY_A);
	$res = json_decode($sel['avaliadores'],true);
	$inscritos = $res[$g];

	for($i = 0; $i < count($res[$g]); $i++){ //roda as notas das inscrições
		$id_insc = $res[$g][$i];
		$y = retornaAnotacao($id_insc,$usuario);
		if($y == NULL OR $y == ""){
			$anotacao++;
		}
		$k = retornaNotaTotal($id_insc,$usuario,$edital);
		if($k == 0){
			$zeradas = $zeradas + 1;
		}
	}

	$matriz['zeradas'] = $zeradas;
	$matriz['anotacao'] = $anotacao;
	
	return $matriz;
		
}


function retornaInscricao($inscricao){
	global $wpdb;
	$sql = "SELECT filtro, descricao FROM ava_inscricao, ava_ranking WHERE ava_inscricao.inscricao = '$inscricao' AND ava_inscricao.inscricao = ava_ranking.inscricao";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return $res;
	
}




/* Planejamento */

function retornaPlanejamento($idPlan){
	global $wpdb;
	$x = array();
	$x['bool'] = FALSE;
	$x['dotacao'] = 0;
	$x['valor'] = 0;
	$x['obs'] = "";	
	$sql_ver = "SELECT id, valor, idPai, obs FROM sc_orcamento WHERE planejamento = '$idPlan'";
	//echo $sql_ver;
	$res_ver = $wpdb->get_results($sql_ver,ARRAY_A);
	if(count($res_ver) > 0){
		$x['bool'] = TRUE;
		$x['dotacao'] = $res_ver[0]['idPai'];
		$x['valor'] = $res_ver[0]['valor'];
		$x['obs'] = $res_ver[0]['obs'];
	}
	
	return $x;

}

function orcamentoTotal($ano){
	global $wpdb;
	$sql_list =  "SELECT id FROM sc_orcamento WHERE publicado = '1' AND ano_base = '$ano' ORDER BY projeto ASC, ficha ASC";
	$res = $wpdb->get_results($sql_list,ARRAY_A);
	$total_orc = 0;
	$total_con = 0;
	$total_des = 0;
	$total_sup = 0;
	$total_res = 0;
	$total_tot = 0;
	$total_pla = 0;
	$total_lib = 0;
	$total_anul = 0;
		for($i = 0; $i < count($res); $i++){
		$orc = orcamento($res[$i]['id']);
			$total = $orc['total'] - $orc['contigenciado'] + $orc['descontigenciado'] + $orc['suplementado'] - $orc['liberado'] - $orc['anulado'];
					
			$total_orc = $total_orc + $orc['total'];
			$total_con = $total_con + $orc['contigenciado'];
			$total_des = $total_des + $orc['descontigenciado'];
			$total_sup = $total_sup + $orc['suplementado'];
			$total_lib = $total_lib + $orc['liberado'];
			$total_pla = $total_pla + $orc['planejado'];
			$total_anul = $total_anul + $orc['anulado'];	
				//$total_res = $total_res;
			$total_tot = $total_tot + $total;					
					
					
					
					
			} // fim do for	
			
			$sal_pla = $total_tot - $total_pla;
		$x = array(
		'orcamento' => $total_orc,
		'contigenciado' => $total_con,
		'descontigenciado' => $total_des,
		'suplementado' => $total_sup,
		'liberado' => $total_lib,
		'planejado' => $total_pla,
		'total' => $total_tot,
		'anulado' => $total_anul
		
		);
		return $x;
	
}

function retornaCheck($inscricao){
	global $wpdb;
	$sql = "SELECT revisao FROM ava_ranking WHERE inscricao = '$inscricao'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return $res['revisao'];
	
}

/* funções css */

function alerta($string,$tipo){ 
	// success, info, warning, danger
	return '<div class="alert alert-'.$tipo.'">'.$string.'</div>';
}

//infraestrutura

function insereAta($idEvento,$idAta,$qte){
		global $wpdb;
	$sql = "SELECT id,quantidade FROM sc_producao WHERE id_ata = '$idAta' AND id_evento = '$idEvento'";
	$x = $wpdb->get_results($sql,ARRAY_A);

	if(count($x) > 0){ //atualiza
		$sql_upd = "UPDATE sc_producao SET quantidade = '$qte' WHERE id = '".$x[0]['id']."'";	
		$wpdb->query($sql_upd);	
	}else{ //insere
		$sql_ins = "INSERT INTO sc_producao (id_ata,id_evento,quantidade) VALUES ('$idAta','$idEvento','$qte')";
		$wpdb->query($sql_ins);
	}
}

function recAta($idEvento,$idAta){
	global $wpdb;
	$sql = "SELECT id,quantidade FROM sc_producao WHERE id_ata = '$idAta' AND id_evento = '$idEvento'";
	$x = $wpdb->get_results($sql,ARRAY_A);
	if(count($x) > 0){
		return $x[0]['quantidade'];
	}else{
		return 0;
	}
}

function infraAta($idEvento){
	global $wpdb;
	$x = array();
	$geral = 0;	
	// distinct das empresas ()
	$sql_empresa = "SELECT DISTINCT pj FROM sc_ata";
	$emp = $wpdb->get_results($sql_empresa,ARRAY_A);
	for($i = 0; $i < count($emp); $i++){
		$empresa = retornaPessoa($emp[$i]['pj'],2);
		$x[$i]['id'] = $emp[$i]['pj'];
		$x[$i]['razao_social'] = $empresa['nome'];
		$x[$i]['cnpj'] = $empresa['cpf_cnpj'];	
		// soma valor
		$sql_soma = "SELECT * FROM sc_producao WHERE id_ata IN (SELECT id FROM sc_ata WHERE pj = '".$emp[$i]['pj']."') AND id_evento = '$idEvento'";
		$soma = $wpdb->get_results($sql_soma,ARRAY_A);
		$total = 0;
		for($k = 0; $k < count($soma); $k++){
			$sql_valor = "SELECT valor_diaria FROM sc_ata WHERE id = '".$soma[$k]['id_ata']."'";
			$valor = $wpdb->get_results($sql_valor,ARRAY_A);
			$total = $total + ($soma[$k]['quantidade'] * $valor[0]['valor_diaria']);
		}
		$x[$i]['total'] = $total;
		$geral = $geral + $total;



		
	}

	$x['total'] = $geral;
	return $x;
}

function retornaItemInfra($id){
	global $wpdb;
	$sql = "SELECT nome FROM sc_infra WHERE id = '$id'";
	$x = $wpdb->get_results($sql,ARRAY_A);
	return $x[0]['nome'];
	
}

function retornaInfra($idEvento){
	global $wpdb;
	$sql = "SELECT * FROM sc_producao WHERE id_evento = '$idEvento' AND quantidade <> '0'";
	$x = $wpdb->get_results($sql,ARRAY_A);
	$string = "";
	if(count($x) == 0){
		return NULL;
	}else{
		for($i = 0; $i < count($x); $i++){
			$string .= "+ ".retornaItemInfra($x[$i]['id_ata'])."(".$x[$i]['quantidade'].")<br />";
		}
		return $string;
	}
}

function retornaContabil($nProcesso){
	global $wpdb;
	$sql = "SELECT * FROM sc_contabil WHERE nProcesso LIKE '$nProcesso'";
	$x = $wpdb->get_results($sql,ARRAY_A);
	return $x;
	
	
	
}

