<?php 

if(isset($_GET['CEP'])){
	$cep = $_GET['CEP'];	
}else{
	$cep = $_POST['CEP'];
}
$url = "https://viacep.com.br/ws/".$cep."/json/";

$ch = curl_init($url);
$page = curl_exec($ch);

$dec = json_decode($page,true);
var_dump($dec);


$dados['rua']     = $dec['logradouro'];
$dados['bairro']  = $dec['bairro'];
$dados['cidade']  = $dec['localidade'];
$dados['estado']  = $dec['uf'];
 
echo json_encode($dados);