<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
?>


  <body>
  
  <?php include "menu/me_contratacao.php"; ?>
      <link href="css/jquery-ui.css" rel="stylesheet">
 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 
 <script>
$(function() {
    $( ".calendario" ).datepicker();
	$(".cpf").mask("999.999.999-99");
	$(".cnpj").mask("99.999.999/9999-99");
	$( ".hora" ).mask("99:99");
	$( ".min" ).mask("999");
	$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
});



</script>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
 <?php 
 switch($p){
case "inicio": //Lista as contratações

// Insere Pessoa Física e Cria Pedido de Contratação
if(isset($_POST['inserir_pf'])){

	// Carrega as variáveis
	$Nome = $_POST["Nome"];
	$NomeArtistico = $_POST["NomeArtistico"];
	$CPF = $_POST["CPF"];
	$RG = $_POST["RG"];
	$tipo = $_POST["tipo"];
	$DataNascimento = exibirDataMysql($_POST["DataNascimento"]);
	$LocalNascimento = $_POST["LocalNascimento"];
	$Nacionalidade = $_POST["Nacionalidade"];
	$cep = $_POST["cep"];
	$Numero = $_POST["Numero"];
	$rua = $_POST["rua"];
	$bairro = $_POST["bairro"];
	$Complemento = $_POST["Complemento"];
	$cidade = $_POST["cidade"];
	$uf = $_POST["uf"];
	$Telefone1 = $_POST["Telefone1"];
	$Telefone2 = $_POST["Telefone2"];
	$Telefone3 = $_POST["Telefone3"];
	$Email = $_POST["Email"];
	$CCM = $_POST["CCM"];
	$INSS = $_POST["INSS"];
	$DRT = $_POST["DRT"];
	$OMB = $_POST["OMB"];
	$Funcao = $_POST["Funcao"];
	$PIS = $_POST["PIS"];
	$observacoes = $_POST["observacoes"];
	$Banco = $_POST["Banco"];
	$agencia = $_POST["agencia"];
	$conta = $_POST["conta"];
	$cbo = $_POST["cbo"];
	$data = date("Y-m-d");
	$id_usuario = $user->ID;
	
	// Insere na tabela sc_pf
	$sql_insere = "INSERT INTO `sc_pf` (`Nome`, `NomeArtistico`, `RG`, `CPF`, `CCM`, `IdEstadoCivil`, `DataNascimento`, `LocalNascimento`, `Nacionalidade`, `CEP`, `Numero`, `Complemento`, `Telefone1`, `Telefone2`, `Telefone3`, `Email`, `DRT`, `Funcao`, `InscricaoINSS`, `Pis`, `OMB`, `DataAtualizacao`, `Observacao`, `IdUsuario`, `codBanco`, `agencia`, `conta`, `cbo`) VALUES ('$Nome', '$NomeArtistico', '$RG', '$CPF', '$CCM', '$tipo', '$DataNascimento', '$LocalNascimento', '$Nacionalidade', '$cep', '$Numero', '$Complemento', '$Telefone1', '$Telefone2', '$Telefone3', '$Email', '$DRT', '$Funcao', '$INSS', '$PIS', '$OMB', '$data', '$observacoes', '$id_usuario',  '$Banco', '$agencia', '$conta', '$cbo')";
	$query = $wpdb->query($sql_insere);
	$numero = $wpdb->insert_id;
	
}

// Se foi inserido uma pessoa física, insere um pedido de contratação.
if((isset($numero))){
	if($numero > 0){
		$idUsuario = $user->ID;
		$evento = $_SESSION['id'];
		$pessoa = 1;
		$sql_insere_pedido = "INSERT INTO `sc_contratacao` (`idEvento`, `tipoPessoa`, `idPessoa`,  `publicado`) 
		VALUES ('$evento', '1', '$numero','1')";
		$query_pedido = $wpdb->query($sql_insere_pedido);
		if($wpdb->insert_id){
			$mensagem = '<div class="alert alert-success"> Pedido inserido com sucesso. </div>';			
		}
	}
}

// Insere Pedido Via Busca PF
if(isset($_POST['insere_pedido_pf'])){
	if($_POST['insere_pedido_pf'] > 0){
		$idUsuario = $user->ID;
		$evento = $_SESSION['id'];
		$pessoa = 1;
		$id_pessoa = $_POST['insere_pedido_pf'];
		if($_SESSION['entidade'] == 'evento'){
		$sql_insere_pedido = "INSERT INTO `sc_contratacao` (`idEvento`, `tipoPessoa`, `idPessoa`,  `publicado`) 
		VALUES ('$evento', '1', '$id_pessoa', '1')";
		}else{
		$sql_insere_pedido = "INSERT INTO `sc_contratacao` (`idAtividade`, `tipoPessoa`, `idPessoa`,  `publicado`) 
		VALUES ('$evento', '1', '$id_pessoa', '1')";
		}
		$query_pedido = $wpdb->query($sql_insere_pedido);
		if($wpdb->insert_id > 0){
			$mensagem = '<div class="alert alert-success">Pedido criado com sucesso.</div>';
		}else{
			$mensagem = '<div class="alert alert-warning">Erro ao criar Pedido.</div>';
		}
	}
}
// Insere Pedido Via Busca PJ
if(isset($_POST['insere_pedido_pj'])){
	if($_POST['insere_pedido_pj'] > 0){
		$idUsuario = $user->ID;
		$evento = $_SESSION['id'];
		$pessoa = 2;
		$id_pessoa = $_POST['insere_pedido_pj'];
		if($_SESSION['entidade'] == 'evento'){
		$sql_insere_pedido = "INSERT INTO `sc_contratacao` (`idEvento`, `tipoPessoa`, `idPessoa`,  `publicado`) 
		VALUES ('$evento', '2', '$id_pessoa', '1')";
		}else{
		$sql_insere_pedido = "INSERT INTO `sc_contratacao` (`idAtividade`, `tipoPessoa`, `idPessoa`,  `publicado`) 
		VALUES ('$evento', '2', '$id_pessoa', '1')";
		}
		$query_pedido = $wpdb->query($sql_insere_pedido);
		if($wpdb->insert_id > 0){
			$mensagem = '<div class="alert alert-success">Pedido criado com sucesso.</div>';
		}else{
			$mensagem = '<div class="alert alert-warning">Erro ao criar Pedido.</div>';
		}
	}
}

if(isset($_POST['apaga_pedido'])){
	$sql_apaga = "UPDATE sc_contratacao SET publicado = '0' WHERE idPedidoContratacao = '".$_POST['apaga_pedido']."'";
	$query_apaga = $wpdb->query($sql_apaga);
	if($query_apaga == 1){
		$mensagem = '<div class="alert alert-success"> Pedido apagado com sucesso. </div>';
	}
}

if(isset($_POST['duplicar'])){
	$sql_apaga = "INSERT INTO `sc_contratacao` (`idEvento`, `idAtividade`, `tipoPessoa`, `idRepresentante01`, `idPessoa`, `integrantesGrupo`, `valor`, `valorPorExtenso`, `formaPagamento`, `dotacao`, `anexo`, `observacao`, `publicado`, `valorIndividual`, `idRepresentante02`, `instituicao`, `executante`, `NumeroProcesso`, `NumeroNotaEmpenho`, `DataEmissaoNotaEmpenho`, `DataEntregaNotaEmpenho`, `IdUsuarioContratos`, `IdAssinatura`, `IdExecutante`, `justificativa`, `parecerArtistico`, `estado`, `aprovacaoFinanca`, `parcelas`, `idContratos`, `idDetalhamentoAcao`, `DataProposta`, `DataReserva`, `DataContrato`, `AmparoLegal`, `ComplementoDotacao`, `Finalizacao`, `idPenalidade`, `DataJuridico`, `DataPublicacao`, `DataContabilidade`, `DataPagamento`, `nProcesso`, `extratoLiquidacao`, `retencoesINSS`, `retencoesISS`, `retencoesIRRF`, `notaFiscal`, `descricaoNF`, `qtdApresentacoes`, `planejamento`,  `nLiberacao`, `mov_orc`) SELECT `idEvento`, `idAtividade`, `tipoPessoa`, `idRepresentante01`, `idPessoa`, `integrantesGrupo`, `valor`, `valorPorExtenso`, `formaPagamento`, `dotacao`, `anexo`, `observacao`, `publicado`, `valorIndividual`, `idRepresentante02`, `instituicao`, `executante`, `NumeroProcesso`, `NumeroNotaEmpenho`, `DataEmissaoNotaEmpenho`, `DataEntregaNotaEmpenho`, `IdUsuarioContratos`, `IdAssinatura`, `IdExecutante`, `justificativa`, `parecerArtistico`, `estado`, `aprovacaoFinanca`, `parcelas`, `idContratos`, `idDetalhamentoAcao`, `DataProposta`, `DataReserva`, `DataContrato`, `AmparoLegal`, `ComplementoDotacao`, `Finalizacao`, `idPenalidade`, `DataJuridico`, `DataPublicacao`, `DataContabilidade`, `DataPagamento`, `nProcesso`, `extratoLiquidacao`, `retencoesINSS`, `retencoesISS`, `retencoesIRRF`, `notaFiscal`, `descricaoNF`, `qtdApresentacoes`, `planejamento`,  `nLiberacao`, `mov_orc` FROM sc_contratacao WHERE idPedidoContratacao = '".$_POST['duplicar']."'";
	$query_apaga = $wpdb->query($sql_apaga);
	if($query_apaga == 1){
		$mensagem = '<div class="alert alert-success"> Pedido duplicado com sucesso. </div>';
	}
}


if(isset($_POST['inserir_pj'])){

	//carrega as variaveis	
	  $razao_social =  	  $_POST["razao_social"];
	  $cnpj =  	  $_POST["cnpj"];
	  $CCM  =  	  $_POST["CCM"];
	  $cep =  	  $_POST["cep"];
	  $Numero =  	  $_POST["Numero"];
	  $rua =  	  $_POST["rua"];
	  $bairro =  	  $_POST["bairro"];
	  $Complemento =  	  $_POST["Complemento"];
	  $cidade =  	  $_POST["cidade"];
	  $uf =  	  $_POST["uf"];
	  $Telefone1 = 	  $_POST["Telefone1"];
	  $Telefone2 =  	  $_POST["Telefone2"];
	  $Telefone3 =  	  $_POST["Telefone3"];
	  $Email =  	  $_POST["Email"];
	  $observacoes =  	  $_POST["observacoes"];
	  $Banco =  	  $_POST["Banco"];
	  $agencia =  	  $_POST["agencia"];
	  $conta =  	  $_POST["conta"];
	  $cbo =  	  $_POST["cbo"];
	  $rep_nome =  	  $_POST["rep_nome"];
	  $rep_cpf =  	  $_POST["rep_cpf"];
	  $rep_rg =  	  $_POST["rep_rg"];
	  $rep_civil =  	  $_POST["rep_civil"];
	  $rep_nacionalidade = $_POST['rep_nacionalidade'];
	  $data_atualiza = date("Y-m-d");
	  $id_usuario = $user->ID;
	$sql_insere = "INSERT INTO `sc_pj` (`RazaoSocial`, `CNPJ`, `CCM`, `CEP`, `Numero`, `Complemento`, `Telefone1`, `Telefone2`, `Telefone3`, `Email`, `DataAtualizacao`, `Observacao`, `IdUsuario`, `codBanco`, `agencia`, `conta`, `rep_nome`, `rep_rg`, `rep_cpf`, `rep_nacionalidade`, `rep_civil`) 
	VALUES ('$razao_social', '$cnpj', '$CCM', '$cep', '$Numero', '$Complemento', '$Telefone1', '$Telefone2', '$Telefone3', '$Email', '$data_atualiza', '$observacoes', '$id_usuario', '$Banco', 'agencia', '$conta', '$rep_nome', '$rep_cpf', '$rep_civil', '$rep_nacionalidade`', '$rep_civil')";	
	$query = $wpdb->query($sql_insere);
	$numero_pj = $wpdb->insert_id;
		
 }
 if((isset($numero_pj))){
	if($numero_pj > 0){
		$idUsuario = $user->ID;
		$evento = $_SESSION['id'];
		$pessoa = 1;
		$sql_insere_pedido = "INSERT INTO `sc_contratacao` (`idEvento`, `tipoPessoa`, `idPessoa`,  `publicado`) 
		VALUES ('$evento', '2', '$numero_pj','1')";
		$query_pedido = $wpdb->query($sql_insere_pedido);
		if($wpdb->insert_id){
			$mensagem = '<div class="alert alert-success"> Pedido inserido com sucesso. </div>';			
		}
	}
}
 

?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Pedidos de Contratação</h1>
					<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
				</div>
        </div>
		<?php 
		// se existe pedido, listar
		$peds = listaPedidos($_SESSION['id'],$_SESSION['entidade']);
		if(count($peds) > 0){
		
		?>
		
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Número</th>
                  <th>Tipo</th>
                  <th>Nome / Razão Social</th>
                  <th>CPF / CNPJ</th>
				  <th>Valor</th>
				  <?php if($_SESSION['entidade'] == 'atividade'){ echo "<th></th>"; } ?>
				  <th></th>
				  <th></th>

				  </tr>
              </thead>
              <tbody>
				<?php 
				for($i = 0; $i < count($peds); $i++){
					?>
					<tr>
					  <td><?php echo $peds[$i]['idPedidoContratacao']; ?></td>
					  <td><?php echo $peds[$i]['tipo']; ?></td>
					  <td><?php echo $peds[$i]['nome']; ?></td>
					  <td><?php echo $peds[$i]['cpf_cnpj']; ?></td>
					  <td><?php echo dinheiroParaBr($peds[$i]['valor']); ?></td>

						<?php if($_SESSION['entidade'] == 'atividade'){ ?>
						<td>	
							<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
							<input type="hidden" name="duplicar" value="<?php echo $peds[$i]['idPedidoContratacao']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Duplicar">
							</form>
					</td>
						<?php } ?>
					  <td>	
							<form method="POST" action="?p=editar_pedido" class="form-horizontal" role="form">
							<input type="hidden" name="editar_pedido" value="<?php echo $peds[$i]['idPedidoContratacao']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar">
							</form>
							<?php 
					  
					  ?></td>
					  <td>	
							<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
							<input type="hidden" name="apaga_pedido" value="<?php echo $peds[$i]['idPedidoContratacao']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Apagar">
							</form>
							<?php 
					  
					  ?></td>

					  </tr>
				<?php } // fim do for?>	
				
              </tbody>
            </table>
          </div>

		</div>
</section>		
		<?php 
		// se não existir, exibir
		}else{
		?>
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<center><h3>Não há pedidos de contratação.</h3></center>
			
				</div>
        </div
		<div class="form-group">
						<div class="col-md-offset-2">
						<br /><br />
						<center>
							<a class="btn btn-lg btn-primary" href="?p=busca_pf" role="button">Pessoa Física</a>
							<a class="btn btn-lg btn-primary" href="?p=busca_pj" role="button">Pessoa Jurídica</a>
						</center>			
						</div>
					</div>

		<?php 
		// fim do if existir pedido
		}
		?>
		
		
		
</div>
</section>

<?php 
break;
	case "busca_pf":
?>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Busca Pessoa Física</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=resultado_pf" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Insira o CPF (somente números) *</label>
							<input type="text" name="busca" class="form-control cpf" id="inputSubject" />
						</div>
					</div>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Buscar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php 
	break;
	case "resultado_pf":
	
	$sql_busca = "SELECT Id_PessoaFisica, Nome, NomeArtistico, CPF FROM sc_pf WHERE CPF LIKE '%".$_POST['busca']."%'";
	echo $sql_busca;
	$res = $wpdb->get_results($sql_busca,ARRAY_A);
	if(count($res) > 0){
		// lista os cpfs encontrados
?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Pessoas Físicas Encontradas</h1>
				</div>
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>CPF</th>
                  <th>Nome</th>
                  <th>Nome Artístico</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
				<?php 
				for($i = 0; $i < count($res); $i++){
					
					?>
					<tr>
					  <td><?php echo $res[$i]['CPF']; ?></td>
					  <td><?php echo $res[$i]['Nome']; ?></td>
					  <td><?php echo $res[$i]['NomeArtistico']; ?></td>
					  <td></td>
					  <td>	
							<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
							<input type="hidden" name="insere_pedido_pf" value="<?php echo $res[$i]['Id_PessoaFisica']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Criar Pedido de Contratação">
							</form>
							<?php 
					  
					  ?></td>
					</tr>
				<?php } // fim do for?>	
				
              </tbody>
            </table>
          </div>

		</div>
</section>
<?php
		
	}else{
		// Cria um formulário de inserção
	?>
	<script type="text/javascript">
	$(function() {
    $( ".calendario" ).datepicker();
	$( ".hora" ).mask("99:99");
	$( ".min" ).mask("999");
	$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
});
</script>

  <script type="text/javascript" >

        $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });

    </script>

 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Inserir Pessoa Física</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
					<div class="row">
						<div class="col-12">
							<label>Nome Completo *</label>
							<input type="text" name="Nome" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
							<label>Nome Artístico *</label>
							<input type="text" name="NomeArtistico" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>CPF *</label>
							<input type="text" name="CPF" class="form-control cpf" id="inputSubject" value="<?php echo $_POST['busca']; ?>" />
						</div>
						<div class="col-6">
							<label>RG *</label>
							<input type="text" name="RG" class="form-control" id="inputSubject" />
						</div>

					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>Estado civil</label>
							<select class="form-control" name="tipo" id="inputSubject" name="IdEstadoCivil">
							<option>Escolha uma opção</option>
							<?php echo geraTipoOpcao("civil") ?>
							</select>
						</div>
						<div class="col-6">
							<label>Data de Nascimento</label>
							<input type="text" class="form-control calendario" name="DataNascimento"> 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>Local de Nascimento</label>
							<input type="text" class="form-control" name="LocalNascimento" > 
						</div>
						<div class="col-6">
							<label>Nacionalidade</label>
							<input type="text" class="form-control" name="Nacionalidade" > 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>CEP</label>
							<input type="text" class="form-control" name="cep" id="cep" > 
						</div>
						<div class="col-6">
							<label>Número</label>
							<input type="text" class="form-control" name="Numero" > 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-12">
							<label>Logradouro *</label>
							<input type="text" name="rua" class="form-control" id="rua" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>Bairro</label>
							<input type="text" class="form-control" name="bairro" id="bairro" > 
						</div>
						<div class="col-6">
							<label>Complemento</label>
							<input type="text" class="form-control" name="Complemento"> 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>Cidade</label>
							<input type="text" class="form-control" name="cidade" id="cidade"> 
						</div>
						<div class="col-6">
							<label>Estado</label>
							<input type="text" class="form-control" name="uf" id="uf"> 
						</div>
					</div>	
					<br />					
										<div class="row">
						<div class="col-6">
							<label>Telefone 01</label>
							<input type="text" class="form-control" name="Telefone1" > 
						</div>
						<div class="col-6">
							<label>Telefone 02</label>
							<input type="text" class="form-control" name="Telefone2"> 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>Telefone 03</label>
							<input type="text" class="form-control" name="Telefone3"> 
						</div>
						<div class="col-6">
							<label>E-mail</label>
							<input type="text" class="form-control" name="Email"> 
						</div>
					</div>	
					<br />

					<div class="row">
						<div class="col-6">
							<label>CCM</label>
							<input type="text" class="form-control" name="CCM"> 
						</div>
						<div class="col-6">
							<label>INSS</label>
							<input type="text" class="form-control" name="INSS" > 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>DRT</label>
							<input type="text" class="form-control" name="DRT" > 
						</div>
						<div class="col-6">
							<label>OMB</label>
							<input type="text" class="form-control" name="OMB" > 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>Função</label>
							<input type="text" class="form-control" name="Funcao" > 
						</div>
						<div class="col-6">
							<label>PIS</label>
							<input type="text" class="form-control" name="PIS" > 
						</div>
					</div>	
					<br />					
					<div class="row">
						<div class="col-12">
							<label>Observações </label>
								<textarea name="observacoes" class="form-control" rows="10" ></textarea>					
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>Banco</label>
							<input type="text" class="form-control" name="Banco" > 
						</div>
						<div class="col-6">
							<label>Agência bancária</label>
							<input type="text" class="form-control" name="agencia"> 
						</div>
					</div>	
					<br />					
					<div class="row">
						<div class="col-6">
							<label>Conta Corrente</label>
							<input type="text" class="form-control" name="conta"> 
						</div>
						<div class="col-6">
							<label>CBO</label>
							<input type="text" class="form-control" name="cbo"> 
						</div>
					</div>	
					<br />					

					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="inserir_pf" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir Pessoa Física e Criar Pedido de Contratação">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>	
	
	<?php
	}
	
?>

<?php 
break;
	case "busca_pj":
?>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Busca Pessoa Jurídica</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=resultado_pj" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Insira o CNPJ *</label>
							<input type="text" name="busca" class="form-control cnpj" id="inputSubject" />
						</div>
					</div>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Buscar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php 
break;
case "resultado_pj":
?>
<?php 
	$sql_busca = "SELECT Id_PessoaJuridica, CNPJ, RazaoSocial FROM sc_pj WHERE CNPJ LIKE '%".$_POST['busca']."%'";
	echo $sql_busca;
	$res = $wpdb->get_results($sql_busca,ARRAY_A);
	if(count($res) > 0){
		// lista os cpfs encontrados
?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Pessoas Jurídica Encontradas</h1>
				</div>
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>CNPJ</th>
                  <th>Razão Social</th>
                  <th>Nome Artístico</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
				<?php 
				for($i = 0; $i < count($res); $i++){
					
					?>
					<tr>
					  <td><?php echo $res[$i]['CNPJ']; ?></td>
					  <td><?php echo $res[$i]['RazaoSocial']; ?></td>
					  <td><?php //echo $res[$i]['NomeArtistico']; ?></td>
					  <td></td>
					  <td>	
							<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
							<input type="hidden" name="insere_pedido_pj" value="<?php echo $res[$i]['Id_PessoaJuridica']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Criar Pedido de Contratação">
							</form>
							<?php 
					  
					  ?></td>
					</tr>
				<?php } // fim do for?>	
				
              </tbody>
            </table>
          </div>

		</div>
</section>


<?php		
	}else{
		// Cria um formulário de inserção
	?>


 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Inserir Pessoa Jurídica</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
					<div class="row">
						<div class="col-12">
							<label>Razão Social</label>
							<input type="text" name="razao_social" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
							<label>CNPJ</label>
							<input type="text" name="cnpj" class="form-control" id="inputSubject" value="<?php echo $_POST['busca']; ?>" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
							<label>CCM</label>
							<input type="text" name="CCM" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />

					<div class="row">
						<div class="col-6">
							<label>CEP</label>
							<input type="text" class="form-control" name="cep" id="cep" > 
						</div>
						<div class="col-6">
							<label>Número</label>
							<input type="text" class="form-control" name="Numero" > 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-12">
							<label>Logradouro *</label>
							<input type="text" name="rua" class="form-control" id="rua" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>Bairro</label>
							<input type="text" class="form-control" name="bairro" id="bairro" > 
						</div>
						<div class="col-6">
							<label>Complemento</label>
							<input type="text" class="form-control" name="Complemento"> 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>Cidade</label>
							<input type="text" class="form-control" name="cidade" id="cidade"> 
						</div>
						<div class="col-6">
							<label>Estado</label>
							<input type="text" class="form-control" name="uf" id="uf"> 
						</div>
					</div>	
					<br />					
										<div class="row">
						<div class="col-6">
							<label>Telefone 01</label>
							<input type="text" class="form-control" name="Telefone1" > 
						</div>
						<div class="col-6">
							<label>Telefone 02</label>
							<input type="text" class="form-control" name="Telefone2"> 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>Telefone 03</label>
							<input type="text" class="form-control" name="Telefone3"> 
						</div>
						<div class="col-6">
							<label>E-mail</label>
							<input type="text" class="form-control" name="Email"> 
						</div>
					</div>	
					<br />

					
					<div class="row">
						<div class="col-12">
							<label>Observações </label>
								<textarea name="observacoes" class="form-control" rows="10" ></textarea>					
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>Banco</label>
							<input type="text" class="form-control" name="Banco" > 
						</div>
						<div class="col-6">
							<label>Agência bancária</label>
							<input type="text" class="form-control" name="agencia"> 
						</div>
					</div>	
					<br />					
					<div class="row">
						<div class="col-6">
							<label>Conta Corrente</label>
							<input type="text" class="form-control" name="conta"> 
						</div>
						<div class="col-6">
							<label>CBO</label>
							<input type="text" class="form-control" name="cbo"> 
						</div>
					</div>	
					<br />					

					<div class="row">
						<div class="col-12">
						<h3>Representante Legal</h3>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
							<label>Nome Completo</label>
							<input type="text" name="rep_nome" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>CPF *</label>
							<input type="text" name="rep_cpf" class="form-control cpf" id="inputSubject"  />
						</div>
						<div class="col-6">
							<label>RG *</label>
							<input type="text" name="rep_rg" class="form-control" id="inputSubject" />
						</div>

					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>Estado civil</label>
							<select class="form-control" name="rep_civil" id="inputSubject" name="IdEstadoCivil">
							<option>Escolha uma opção</option>
							<?php echo geraTipoOpcao("civil") ?>
							</select>
						</div>
						<div class="col-6">
							<label>Data de Nascimento</label>
							<input type="text" class="form-control calendario" name="rep_nascimento"> 
						</div>
					</div>	
					<br />

					<div class="row">
						<div class="col-12">
							<label>Nacionalidade</label>
							<input type="text" name="rep_nacionalidade" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="inserir_pj" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir Pessoa Jurídica e Criar Pedido de Contratação">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>	
	
	<?php
	}
	
?>

	 
<?php 	 
break;	 
 case "editar_pf": //editar pessoa física
 ?>



 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Inserir Pessoa Física</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
					<div class="row">
						<div class="col-12">
							<label>Nome Completo *</label>
							<input type="text" name="Nome" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
							<label>Nome Artístico *</label>
							<input type="text" name="NomeArtistico" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>CPF *</label>
							<input type="text" name="CPF" class="form-control cpf" id="inputSubject" value="<?php echo $_POST['busca']; ?>" />
						</div>
						<div class="col-6">
							<label>RG *</label>
							<input type="text" name="RG" class="form-control" id="inputSubject" />
						</div>

					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>Estado civil</label>
							<select class="form-control" name="tipo" id="inputSubject" name="IdEstadoCivil">
							<option>Escolha uma opção</option>
							<?php echo geraTipoOpcao("civil") ?>
							</select>
						</div>
						<div class="col-6">
							<label>Data de Nascimento</label>
							<input type="text" class="form-control calendario" name="DataNascimento"> 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>Local de Nascimento</label>
							<input type="text" class="form-control" name="LocalNascimento" > 
						</div>
						<div class="col-6">
							<label>Nacionalidade</label>
							<input type="text" class="form-control" name="Nacionalidade" > 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>CEP</label>
							<input type="text" class="form-control" name="cep" id="cep" > 
						</div>
						<div class="col-6">
							<label>Número</label>
							<input type="text" class="form-control" name="Numero" > 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-12">
							<label>Logradouro *</label>
							<input type="text" name="rua" class="form-control" id="rua" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>Bairro</label>
							<input type="text" class="form-control" name="bairro" id="bairro" > 
						</div>
						<div class="col-6">
							<label>Complemento</label>
							<input type="text" class="form-control" name="Complemento"> 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>Cidade</label>
							<input type="text" class="form-control" name="cidade" id="cidade"> 
						</div>
						<div class="col-6">
							<label>Estado</label>
							<input type="text" class="form-control" name="uf" id="uf"> 
						</div>
					</div>	
					<br />					
										<div class="row">
						<div class="col-6">
							<label>Telefone 01</label>
							<input type="text" class="form-control" name="Telefone1" > 
						</div>
						<div class="col-6">
							<label>Telefone 02</label>
							<input type="text" class="form-control" name="Telefone2"> 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>Telefone 03</label>
							<input type="text" class="form-control" name="Telefone3"> 
						</div>
						<div class="col-6">
							<label>E-mail</label>
							<input type="text" class="form-control" name="Email"> 
						</div>
					</div>	
					<br />

					<div class="row">
						<div class="col-6">
							<label>CCM</label>
							<input type="text" class="form-control" name="CCM"> 
						</div>
						<div class="col-6">
							<label>INSS</label>
							<input type="text" class="form-control" name="INSS" > 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>DRT</label>
							<input type="text" class="form-control" name="DRT" > 
						</div>
						<div class="col-6">
							<label>OMB</label>
							<input type="text" class="form-control" name="OMB" > 
						</div>
					</div>	
					<br />
					<div class="row">
						<div class="col-6">
							<label>Função</label>
							<input type="text" class="form-control" name="Funcao" > 
						</div>
						<div class="col-6">
							<label>PIS</label>
							<input type="text" class="form-control" name="PIS" > 
						</div>
					</div>	
					<br />					
					<div class="row">
						<div class="col-12">
							<label>Observações </label>
								<textarea name="observacoes" class="form-control" rows="10" ></textarea>					
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>Banco</label>
							<input type="text" class="form-control" name="Banco" > 
						</div>
						<div class="col-6">
							<label>Agência bancária</label>
							<input type="text" class="form-control" name="agencia"> 
						</div>
					</div>	
					<br />					
					<div class="row">
						<div class="col-6">
							<label>Conta Corrente</label>
							<input type="text" class="form-control" name="conta"> 
						</div>
						<div class="col-6">
							<label>CBO</label>
							<input type="text" class="form-control" name="cbo"> 
						</div>
					</div>	
					<br />					

					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="inserir_pf" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir Pessoa Física e Criar Pedido de Contratação">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>	

<?php 	 
break;	 
 case "editar_pj": //editar pessoa jurídica
 ?>
 
<?php 	 
break;	 
 case "editar_pedido": //editar pessoa jurídica

 if(isset($_POST['editar_pedido'])){
	 $id_pedido = $_POST['editar_pedido'];
 }

 if(isset($_POST['atualizar_pedido'])){
	$id_pedido = $_POST['atualizar_pedido'];
	$integrantes =  $_POST["integrantes"];
	$valor =  dinheiroDeBr($_POST["valor"]);
	$forma_pagamento =   $_POST["forma_pagamento"];
	$dotacao =   $_POST["dotacao"];
	$justificativa =   $_POST["justificativa"];
	$parecer =   $_POST["parecer"];
	$observacao =   $_POST["observacao"];
	$parcelas =   $_POST["parcelas"];
	$processo =   $_POST["processo"];
	
	$sql_atualiza = "UPDATE sc_contratacao SET
	integrantesGrupo = '$integrantes',
	valor = '$valor',
	formaPagamento = '$forma_pagamento',
	dotacao = '$dotacao',
	justificativa = '$justificativa',
	parecerArtistico = '$parecer',
	nProcesso = '$processo',
	parcelas = '$parcelas',
	observacao = '$observacao'
	WHERE idPedidoContratacao = '$id_pedido'";
	$res = $wpdb->query($sql_atualiza);
 }
 
 
 
 
 $pedido = recuperaDados("sc_contratacao",$id_pedido,"idPedidoContratacao");
 ?>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Editar Pedido</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editar_pedido" class="form-horizontal" role="form">
					<div class="row">
						<div class="col-12">
						<p> Informações da Contratação </p>	
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
							<label>Número de Processo</label>
							<input type="text" name="processo" class="form-control" id="inputSubject" value="<?php echo $pedido['nProcesso']; ?>" />
						</div>
					</div>					
					
						<div class="row">
						<div class="col-12">
							<label>Integrantes do Grupo </label>
								<textarea name="integrantes" class="form-control" rows="10" ><?php echo $pedido['integrantesGrupo']; ?></textarea>					
						</div>
					</div>
					<br />
					
					<div class="row">
						<div class="col-12">
							<label>Valor *</label>
							<input type="text" name="valor" class="form-control valor" id="inputSubject" value="<?php echo dinheiroParaBr($pedido['valor']); ?>" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
						<label>Parcelas *</label>
							<select class="form-control" name="parcelas" id="inputSubject" >
							<?php for($i = 1; $i <= 10; $i++){ ?>
							<option value='<?php echo $i ?>' <?php if( $i == $pedido['parcelas'] ){ echo " selected"; } ?>><?php echo $i ?> parcela(s)</option>
							<?php } ?>
							</select>		
						</div>
					</div>
					<br />
					<?php if($pedido['parcelas'] > 0){?>
					<div class="row">
						<div class="col-12">
						<a href="?p=parcela&id=<?php echo $id_pedido; ?>" class="btn btn-primary btn-block" role="button">Editar parcelas</a>	
						</div>
					</div>
					<br />
					
					<?php } ?>
					
					
					<div class="row">
						<div class="col-12">
							<label>Forma de Pagamento / Valor da Prestação de Serviço:</label>
								<textarea name="forma_pagamento" class="form-control" rows="10" ><?php echo $pedido['formaPagamento']; ?></textarea>					
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
						<label>Dotação</label>
							<select class="form-control" name="dotacao" id="inputSubject" >
							<option>Escolha uma opção</option>
							<?php echo geraOpcaoDotacao('2018',$pedido['dotacao']); ?>
							</select>			
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
							<label>Justificativa:</label>
								<textarea name="justificativa" class="form-control" rows="10" ><?php echo $pedido['justificativa']; ?></textarea>					
						</div>
					</div>
					<br />					
					<div class="row">
						<div class="col-12">
							<label>Parecer artístico:</label>
								<textarea name="parecer" class="form-control" rows="10" ><?php echo $pedido['parecerArtistico']; ?></textarea>					
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
							<label>Observação:</label>
								<textarea name="observacao" class="form-control" rows="10" ><?php echo $pedido['observacao']; ?></textarea>					
						</div>
					</div>
					<br />

					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="atualizar_pedido" value="<?php echo $id_pedido; ?>" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Atualizar Pedido">
						</div>
					</div>
				</form>
				<form action="arquivo.php?p=inserir&tipo=302&id=<?php echo $id_pedido; ?>" method="post">
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="atualizar_pedido" value="<?php echo $id_pedido; ?>" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Anexar arquivos ao Pedido">
						</div>
					</div>

					<div class="row">
						<div class="col-12">
					<a  class="btn btn-theme btn-lg btn-block" href="documentos.php?modelo=303&id=<?php echo $id_pedido?>" target="_blank">Criar Folha de Rosto de Processo</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
					<a  class="btn btn-theme btn-lg btn-block" href="documentos.php?modelo=304&id=<?php echo $id_pedido?>" target="_blank">OS para pedido de contratação</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
					<a  class="btn btn-theme btn-lg btn-block" href="documentos.php?modelo=306&id=<?php echo $id_pedido?>" target="_blank">Gerencia de Compras</a>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
					<a  class="btn btn-theme btn-lg btn-block" href="documentos.php?modelo=307&id=<?php echo $id_pedido?>" target="_blank">Ordenador de Despesa</a>
						</div>
					</div>					
					
				</form>

				</div>
		</div>
	</div>
</section>	

 <?php 
 break;
 case "parcela":
 $id = $_GET['id'];
 
 $parcela = parcela($id);
 if($parcela == NULL){
	for($i = 1; $i <= 10; $i++){
		$data = date("Y-m-d");
		$sql_ins = "INSERT INTO sc_parcela (idPedidoContratacao, numero, inicio, fim, comprobatorio) VALUES ('$id','$i','$data','$data','$data')";
		$res = $wpdb->query($sql_ins);
	} 
	$parcela = parcela($id);
	
 }
 
 

 if(isset($_POST['atualizar'])){
	 $array_json = array();

 foreach($_POST['inicio'] as $key => $value){
		 //echo $key." - ".$value."<br />";
		 if($value != ""){
			$array_json[$key+1]['inicio'] = exibirDataMysql($value);
		 }else{
			$array_json[$key+1]['inicio'] = date('Y-m-d');
		 }	
	 }
	 foreach($_POST['fim'] as $key => $value){
		 //echo $key." - ".$value."<br />";
		 if($value != ""){
			$array_json[$key+1]['fim'] = exibirDataMysql($value);
		 }else{
			$array_json[$key+1]['fim'] = date('Y-m-d');
		}	
	}
	 foreach($_POST['comprobatoria'] as $key => $value){
		 //echo $key." - ".$value."<br />";
		 if($value != ""){
			$array_json[$key+1]['comprobatoria'] = exibirDataMysql($value);
		 }else{
			$array_json[$key+1]['comprobatoria'] = date('Y-m-d');
		}	
	 }
	 foreach($_POST['valor'] as $key => $value){
		 if($value == ""){
			$array_json[$key+1]['valor'] = 0;
		 }else{
			$array_json[$key+1]['valor'] = dinheiroDeBr($value);

		}	
	}

	for($i = 1; $i <= count($array_json); $i++){
		$sql_upd = "UPDATE sc_parcela SET 
		inicio = '".$array_json[$i]['inicio']."',
		fim = '".$array_json[$i]['fim']."',
		comprobatorio = '".$array_json[$i]['comprobatoria']."',
		valor = '".$array_json[$i]['valor']."'
		WHERE numero = '$i' AND idPedidoContratacao = '".$id."'";
		$upd = $wpdb->query($sql_upd);
		if($upd != 1){
			//echo $sql_upd."<br />";
		}
	}
		$parcela = parcela($id);
	 
	 
 }

 ?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Editar Parcela</h1>
					<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
				</div>
        </div>
		<?php 
		// se existe pedido, listar
		
		?>
		
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
        </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Número</th>
                  <th>Período Inicio</th>
                  <th>Período Fim</th>
                  <th>Data comprobatória</th>
				  <th>Valor</th>
				  <th></th>
				  <th></th>

				  </tr>
              </thead>
              <tbody>
			  <form method="POST" action="?p=parcela&id=<?php echo $_GET['id']; ?>" class="form-horizontal" role="form">
				<?php 
				$pedido = retornaPedido($_GET['id']);

				for($i = 1; $i <= $pedido['parcelas']; $i++){
					?>
					
					<tr>
					  <td><?php echo $i ?></td>
					  <td><input type="text" name="inicio[]" class="form-control calendario" value="<?php echo exibirDataBr($parcela[$i]['inicio']); ?>" /></td>
					  <td><input type="text" name="fim[]" class="form-control calendario" value="<?php echo exibirDataBr($parcela[$i]['fim']); ?>" /></td>
					  <td><input type="text" name="comprobatoria[]" class="form-control calendario"  value="<?php echo exibirDataBr($parcela[$i]['comprobatorio']); ?>" /></td>
					  <td><input type="text" name="valor[]" class="form-control valor"  value="<?php echo dinheiroParaBr($parcela[$i]['valor']); ?>" /></td>
					  <td>	
					  
					  </td>
					  <td>	
					</td>

					  </tr>
				<?php } // fim do for?>
					<tr>
					<td colspan="6">
					<input type="hidden" name="atualizar" value="<?php echo $_GET['id']; ?>" />
					<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
					</td>
					</tr>
					</form>
				                <tr>
                  <th></th>
                  <th>Valor da Proposta</th>
                  <th></th>
                  <th>Soma das Parcelas</th>
				  <th></th>
				  <th>Status</th>
				  <th></th>

				  </tr>
              </tbody>
            </table>
          </div>

		</div>
</section>	
 
 
<?php 
break;
} // fim da switch p

?>
  
        </main>
      </div>
    </div>
	
<?php 
include "footer.php";
?>