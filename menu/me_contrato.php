<?php include "barra.php"; ?>

	
    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

		<ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">Módulo Contratos <span class="sr-only">(current)</span></a>
            </li>
		</ul>
	

		  <ul class="nav nav-pills flex-column">
        
			<li class="nav-item">
              <a class="nav-link" href="contrato.php">Listar Contratações</a>
            </li>


			
			
			</ul>

		
		
		<?php 
		if((isset($_GET['p']) AND $_GET['p'] == 'editar_pedido')){
			if(isset($_POST['editar_pedido'])){
				$id_pedido = $_POST['editar_pedido'];
				$json = "{";
				foreach($_POST as $chave=>$valor){
						$$chave = $valor;
						$json .= '"'.$chave.'": "'.$valor.'",';
				}
				$json = substr($json,0,-1)."}";	
			}
		//echo $json;
		$json_array = json_decode($json,true);
		//var_dump($json_array);
		?>
		  <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">Checklist</a>
            </li>
        <form action="?p=editar_pedido" method="POST">
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="verba" /> Verba suficiente</a></p>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="justificativa" /> Justificativa da área requisitante</a></p>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="autorizacao" /> Autorização do Secretário</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="resp_fiscal" /> Declaração de LRF</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="proposta" /> Proposta de Trabalho</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="nepostismo" /> Declaracão de Nepotismo</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="prazo_exec" /> Prazo de execução</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="prazo_paga" /> Prazo de pagamento</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="rg" /> RG</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="cpf" /> CPF</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="inss" /> Cartão INSS/PIS</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="procuracao" /> Procuração dos Representados</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="cnd" /> CND/FGTS/CNDT/Cert. Estadual/Municipal/SN</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="contrato_social" /> Contrato Social</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="cnpj" /> CNPJ</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="atestado_curriculo" /> Atestados e currículos</a>
            </li>
			<li class="nav-item">
				<p class="nav-link" href="#" /><input type="checkbox" name="critica_reconhecida" /> Material da crítica</a>
            </li>
			<li class="nav-item">
				<input type="hidden" name="editar_pedido" value="<?php echo $id_pedido; ?>" />
				<p class="nav-link" href="#" /><input type="submit" class="btn btn-theme btn-lg btn-block" value="Atualizar Checklist" ></p>
            </li>
			
			
			</ul>
</form>

		  <?php 
		}
		?>





          <ul class="nav nav-pills flex-column">

            <li class="nav-item">
              <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
            </li>
          </ul>
        </nav>
