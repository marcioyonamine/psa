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
body{
	font-size:10px;
}
.pieChart{
	float: right;
	
	
}
</style>
<div>
            <table border= "1" class="table table-striped">
              <thead>
                <tr>
				<th></th>
				<th></th>
     			</tr>
              </thead>
              <tbody>
				<tr>
				<td>Orçamento Aprovado</td>
				<td><?php echo dinheiroParaBr($orcamento['orcamento']); ?></td>
				</tr>
				<tr>
				<td>Contigenciado</td>
				<td><?php echo dinheiroParaBr($orcamento['contigenciado']); ?></td>
				</tr>
				<tr>
				<td>Descontigenciado</td>
				<td><?php echo dinheiroParaBr($orcamento['descontigenciado']); ?></td>
				</tr>
				<tr>
				<td>Suplementado</td>
				<td><?php echo dinheiroParaBr($orcamento['suplementado']); ?></td>
				</tr>
				<tr>
				<td>Liberado</td>
				<td><?php echo dinheiroParaBr($orcamento['liberado']); ?></td>
				</tr>
								<tr>
				<td>Planejado</td>
				<td><?php echo dinheiroParaBr($orcamento['planejado']); ?></td>
				</tr>
								<tr>
				<td>Executado</td>
				<td></td>
				</tr>
				<tr>
				<td>Saldo </td>
				<td><?php echo dinheiroParaBr($orcamento['total']); ?></td>
				<td></td>
				</tr>
				<tr>
				<td>Saldo Planejado</td>
				<td><?php echo dinheiroParaBr($orcamento['total'] - $orcamento['planejado'] ); ?></td>

				</tr>				
				</tbody>
            </table>

