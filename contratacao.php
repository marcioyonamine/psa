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
	$( ".hora" ).mask("99:99");
	$( ".min" ).mask("999");
	$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
});



</script>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
 <?php 
 switch($p){
case "inicio": //Lista as contratações
?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Pedidos de Contratação</h1>
				</div>
        </div>
		<?php 
		// se existe pedido, listar
		$peds = listaPedidos($_SESSION['id'],$_SESSION['entidade']);
		if(count($peds) > 0){
		?>
		
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
	
	$sql_busca = "SELECT Id_PessoaFisica FROM sc_pf WHERE CPF LIKE '%".$_POST['busca']."%'";
	$res = $wpdb->get_results($sql_busca,ARRAY_A);
	if(count($res) > 0){
		// lista os cpfs encontrados
		
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
case "resultado_pj":
?>
<?php 
	$sql_busca = "SELECT Id_PessoaJuridica FROM sc_pj WHERE CNPJ LIKE '%".$_POST['busca']."%'";
	$res = $wpdb->get_results($sql_busca,ARRAY_A);
	if(count($res) > 0){
		// lista os cpfs encontrados
		
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
							<input type="text" name="Nome" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
							<label>CNPJ</label>
							<input type="text" name="NomeArtistico" class="form-control" id="inputSubject" value="<?php echo $_POST['busca']; ?>" />
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
							<input type="text" name="NomeArtistico" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-6">
							<label>CPF *</label>
							<input type="text" name="CPF" class="form-control cpf" id="inputSubject"  />
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
 case "editar_pf": //editar pessoa física
 ?>
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
break;	 
 case "inserir_pj": //inserir pessoa jurídica
 ?>

<?php 	 
break;	 
 case "editar_pj": //editar pessoa jurídica
 ?>
 

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