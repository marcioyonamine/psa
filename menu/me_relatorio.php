<?php include "barra.php"; ?>

	
    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

		<ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Início <span class="sr-only">(current)</span></a>
            </li>
		</ul>
	


		  <ul class="nav nav-pills flex-column">
          <!--  <li class="nav-item">
              <a class="nav-link" href="<?php echo $_SESSION['entidade']; ?>.php?p=editar">Voltar</a>
            </li> -->
        
			<li class="nav-item">
              <a class="nav-link" href="?p=orcamento">Orçamento</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="?p=orcamento" target="_blank">Orçamento para impressão</a>
            </li>
		<!--
			<li class="nav-item">
              <a class="nav-link" href="contratacao.php?p=busca_pf">Insere Contratação PF</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="contratacao.php?p=busca_pj">Insere Contratação PJ</a>
            </li>
			-->
			
			
			</ul>







          <ul class="nav nav-pills flex-column">

            <li class="nav-item">
              <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
            </li>
          </ul>
        </nav>
