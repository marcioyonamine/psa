<?php include "barra.php"; ?>

	
    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

		<ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Início <span class="sr-only">(current)</span></a>
            </li>
		</ul>
	

		<?php 
		if((isset($_GET['p']) AND $_GET['p'] == 'editar') OR isset($_SESSION['id'])){
		
		?>
		  <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $_SESSION['entidade']; ?>.php?p=editar">Voltar</a>
            </li>
        
	<li class="nav-item">
              <a class="nav-link" href="arquivo.php">Listar Arquivos</a>
            </li>

	<li class="nav-item">
              <a class="nav-link" href="arquivo.php?p=inserir">Insere Arquivos</a>
            </li>

			</ul>

		  <?php 
		}
		?>


		<ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="evento.php">Meus Eventos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="evento.php?p=inserir">Inserir Evento</a>
		    </li>
          </ul>



          <ul class="nav nav-pills flex-column">

            <li class="nav-item">
              <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
            </li>
          </ul>
        </nav>
