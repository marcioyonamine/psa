   <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">SC.PSA</a>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Settings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Help</a>
          </li>
		</ul>
        <form class="form-inline mt-2 mt-md-0">
		   <a class="navbar-brand" style="color:white;" > Olá, <?php echo $user->display_name; ?></a>
        		
          <input class="form-control mr-sm-2" type="text" placeholder="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>

	
    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

		<ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Início <span class="sr-only">(current)</span></a>
            </li>
		</ul>
	

		<?php 
		if((isset($_GET['p']) AND $_GET['p'] == 'editar') OR isset($_SESSION['idEvento'])){
		
		?>
		  <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="evento.php?p=editar">Informações</a>
            </li>
		  <li class="nav-item">
              <a class="nav-link" href="ocorrencias.php?p=inserir">Inserir Ocorrências</a>
            </li>
	  <li class="nav-item">
              <a class="nav-link" href="ocorrencias.php?p=listar">Listar Ocorrências</a>
            </li>
        
	<li class="nav-item">
              <a class="nav-link" href="#">Uploads</a>
            </li>
	<li class="nav-item">
              <a class="nav-link" href="#">Contrato</a>
            </li>
	<li class="nav-item">
              <a class="nav-link" href="#">Enviar</a>
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
