<?php 
require_once("../wp-load.php");
global $wpdb;

if(isset($_GET['CEP'])){
	$cep = $_GET['CEP'];	
}else{
	$cep = $_POST['CEP'];
}
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
 
echo json_encode($dados);