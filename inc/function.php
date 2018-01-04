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
	$programa = tipo($res['idPrograma']);
	
	$projeto = tipo($res['idProjeto']);
	$linguagem = tipo($res['idLinguagem']);
	$tipo_evento = tipo($res["idTipo"]);
	$usuario = get_userdata($res['idResponsavel']);
	$etaria = tipo($res['faixaEtaria']);
	$periodo = periodo($res['idEvento']);
	$status = retornaStatus($res['idEvento']);
	
	$evento = array(
		'titulo' => $res['nomeEvento'],
		'programa' => $programa['tipo'],
		'projeto' => $projeto['tipo'],
		'linguagem' => $linguagem['tipo'],
		'responsavel' => $usuario->first_name." ".$usuario->last_name,
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
		'local' => '',
		'faixa_etaria' => $etaria['tipo'],
		'valor_entrada' => '',
		'imagem' => '',
		'planejamento' => $res['planejamento'],
		'objeto' => $tipo_evento['tipo']." - ".$res['nomeEvento'],
		'tipo' => $tipo_evento['tipo'],
		'data_envio' => $res['dataEnvio']
	);

	return $evento;
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
	$sql_orc = "SELECT * FROM sc_orcamento WHERE ano_base = '$ano_base' AND valor <> '0.00' AND publicado = '1'";
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
	$sel = "SELECT valor,dotacao,descricao, projeto, ficha, natureza, fonte FROM sc_orcamento WHERE id = '$id'";
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
	$sel_hist = "SELECT titulo,valor, descricao, tipo, idUsuario,data FROM sc_mov_orc WHERE idOrc = '$id' AND '$inicio' <= data AND '$fim' >= data AND publicado = '1' ORDER BY data ASC";
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
	
	
	
	
	
	
	$dotacao = array(
	'descricao' => $val['descricao'],
	'dotacao' => $val['dotacao'],
	'total' => 	$val['valor'],
	'contigenciado' => $valor_cont,
	'descontigenciado' => $valor_desc,
	'suplementado' => $valor_supl,
	'historico' => $hist,
	'visualizacao' => $val['projeto']." / ".$val['ficha'], //colocar natureza (importar de novo)
	'natureza' => $val['natureza']." / ".$val['fonte'],	
	'liberado' => $valor_lib,
	'planejado' => $valor_pla_pf + $valor_pla_pj,
	'teste' => $pla_pf,
	'teste2' => $pla_pj

	);
	
	
	return $dotacao;
	
}

/* Funções para Pedidos de Contratação */


function retornaPessoa($id,$tipo){
	global $wpdb;
	$x = array();
	if($tipo == 1){
		$sql = "SELECT Nome, CPF, Email, codBanco, agencia, conta FROM sc_pf WHERE Id_PessoaFisica = '$id'";
		$res = $wpdb->get_row($sql,ARRAY_A);	
		$x['nome'] = $res['Nome'];
		$x['cpf_cnpj'] = $res['CPF'];
		$x['tipoPessoa'] = "Pessoa Física";
		$x['email'] = $res['Email'];
		$x['banco'] = "Banco: ".$res['codBanco']." / Agência: ".$res['agencia']." / Conta Corrente: ".$res['conta'];
		
	}else{
		$sql = "SELECT RazaoSocial, CNPJ, Email, codBanco, agencia, conta FROM sc_pj WHERE Id_PessoaJuridica = '$id'";
		$res = $wpdb->get_row($sql,ARRAY_A);	
		$x['nome'] = $res['RazaoSocial'];
		$x['cpf_cnpj'] = $res['CNPJ'];
		$x['tipoPessoa'] = "Pessoa Jurídica";
		$x['email'] = $res['Email'];
		$x['banco'] = "Banco: ".$res['codBanco']." / Agência: ".$res['agencia']." / Conta Corrente: ".$res['conta'];
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


function opcaoDados($tipo,$id){
	global $wpdb;
	$sql = "SELECT opcao FROM sc_opcoes WHERE entidade = '$tipo' AND id_entidade = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return json_decode($res['opcao'],true);
	
}


function retornaPedido($id){
	global $wpdb;
	$sql = "SELECT valor, tipoPessoa, idPessoa, sc_evento.idEvento, idResponsavel, dotacao, valor, formaPagamento, empenhado, liberado  FROM sc_contratacao, sc_evento WHERE idPedidoContratacao = '$id' AND sc_evento.idEvento = sc_contratacao.idEvento ";
	$res = $wpdb->get_row($sql,ARRAY_A);
	$pessoa = retornaPessoa($res['idPessoa'],$res['tipoPessoa']);
	$objeto = evento($res['idEvento']);
	$periodo = periodo($res['idEvento']);
	$usuario = get_userdata($res['idResponsavel']);
	$metausuario = opcaoDados("usuario",4);
	$dotac = recuperaDados("sc_orcamento",$res['dotacao'],"id");
	$local = retornaLocais($res['idEvento']);
	$end = retornaEndereco($res['tipoPessoa'],$res['idPessoa']);
	$status = "Em análise";
	if('0000-00-00' != $res['empenhado']){
		$status = 'Empenhado';
	}else if('0000-00-00' != $res['liberado']){
		$status = 'Liberado';
	}
	
	
	$x = array();
	$x['nome'] = $pessoa['nome'];
	$x['objeto'] = $objeto['objeto'];	
	$x['autor'] = $objeto['autor'];
	$x['periodo'] = $periodo['legivel'];
	$x['usuario'] = $usuario->first_name." ".$usuario->last_name;
	$x['area'] = $metausuario['departamento'];
	$x['cargo'] = $metausuario['funcao'];
	$x['tipoPessoa'] = $pessoa['tipoPessoa'];
	$x['nome_razaosocial'] = $pessoa['nome'];
	$x['cpf_cnpj'] = $pessoa['cpf_cnpj'];
	$x['cr'] = $metausuario['cr'];
	$x['cod_dotacao'] = $dotac['dotacao'];
	$x['ficha'] = $dotac['ficha'];
	$x['projeto'] = $dotac['projeto'];
	$x['despesa'] = "";
	$x['fonte'] = $dotac['fonte'];
	$x['telefone'] = $metausuario['telefone'];
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
	return $x;
	
}

function opcoes($id,$entidade){
	global $wpdb;
	$sql = "SELECT * FROM sc_opcoes WHERE entidade = '$entidade' AND id_entidade = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	$json = json_decode($res['opcao']);
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
/*		$url = "https://viacep.com.br/ws/".$cep."/json/";
		$ch = curl_init($url);
		$page = curl_exec($ch);
		$dec = json_decode($page,true);
		$dados = array();
		$dados['rua']     = $dec['logradouro'];
		$dados['bairro']  = $dec['bairro'];
		$dados['cidade']  = $dec['localidade'];
		$dados['estado']  = $dec['uf'];	
		var_dump($dec);
		return $dados;
*/
}


function retornaEndereco($tipo,$pessoa){
	global $wpdb;
	switch ($tipo){
		case 1:
		$sql = "SELECT CEP, Numero, Complemento FROM sc_pf WHERE Id_PessoaFisica = '$pessoa' ";
		$res = $wpdb->get_row($sql,ARRAY_A);
		$dados = retornaCEP($res['CEP']);
		
		$end = $dados['rua'].", ".$res['Numero']." - ".$res['Complemento']. "<br />".$dados['bairro']. " " .$dados['cidade']. " / ".$dados['estado'];
		
		return $end;
		
		break;		

		case 2:
		$sql = "SELECT CEP, Numero, Complemento FROM sc_pj WHERE Id_PessoaJuridica = '$pessoa' ";
		$res = $wpdb->get_row($sql,ARRAY_A);
		$dados = retornaCEP($res['CEP']);
		
		$end = $dados['rua'].", ".$res['Numero']." - ".$res['Complemento']. "<br />".$dados['bairro']. " " .$dados['cidade']. " / ".$dados['estado'];
		
		return $end;
		
		break;
		
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

	//Ocorrencias
	$ocorrencias = periodo($idEvento);
	if($ocorrencias['bool'] == FALSE){
		$relatorio .= "O evento não possui ocorrências.<br />";
		$r++;	
	}

	$pedidos = listaPedidos($idEvento,'evento');	
	if(count($pedidos) > 0){
		//$relatorio .= "O evento possui pedidos de contratação.<br />";
		$ped = retornaPedido($pedidos[$i]['idPedidoContratacao']);
		
		
		
		
		
		
		
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
		$pedidos = listaPedidos($idEvento,'evento');	
		if(count($pedidos) == 0){ //Não há pedidos
			$x['pedido'] = NULL;						
		}else{
			for($i = 0; $i < count($pedidos); $i++){
				
				
			}
			
		}
		
		
		
		
		
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

function somaNotas($inscricao,$usuario){
	global $wpdb;
	$sql_soma = "SELECT nota FROM `ava_nota` WHERE inscricao = '$inscricao' AND usuario ='$usuario'";
	$res = $wpdb->get_results($sql_soma,ARRAY_A);
	$total = 0;
	if(count($res) > 0){
		for($i = 0; $i < count($res); $i++){
			$total = $total + $res[$i]['nota'];			
		} 
	}
	return $total;
}

function retornaAnotacao($inscricao,$usuario){
	global $wpdb;
	$sql_sel_obs = "SELECT anotacao FROM ava_anotacao WHERE usuario = '".$usuario."' AND inscricao = '".$inscricao."'";
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
			$nota[$k] = somaNotas($inscricao,$query_pareceristas[$k]['usuario']);		
			$nota_total = $nota_total + $nota[$k];
		}
	
	$nota_total = $nota_total/$numero;
	$discrepancia = 0;
	if($numero == 2){
		$discrepancia = moduloAritimetica($nota[0] - $nota[1]);
	}
	
	
	
	//atualiza ranking
	$update_ranking = "UPDATE ava_ranking SET nota = '$nota', discrepancia = '$discrepancia' WHERE inscricao = '$inscricao'";
	$wpdb->query($update_ranking);
	}
}

function moduloAritimetica($numero){
	if($numero < 0){
		return $numero*(-1);
	}else{
		return $numero;
	}
}

