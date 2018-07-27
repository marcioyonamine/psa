<?php include "barra.php"; 



?>

	
    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

		<ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">Módulo Indicadores <span class="sr-only">(current)</span></a>
            </li>
		</ul>
	

		<ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=listarbiblioteca">Listar Relatório Biblioteca</a>
            </li>
              <a class="nav-link" href="indicadores.php?p=inserirbiblioteca">Inserir Relatório Biblioteca</a>
            </li>
			<!--
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=listarincentivo">Listar Disciplinas/Cursos - Incentivo à Criação</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=inseririncentivo">Inserir Disciplinas/Cursos Incentivo à Criação</a>
            </li>
			-->
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=listarevento">Listar Relatório Eventos</a>
		    </li>
            <li class="nav-item">
              <a class="nav-link" href="indicadores.php?p=inserirevento">Inserir Realtório Eventos</a>
		    </li>
    
          </ul>




          <ul class="nav nav-pills flex-column">

            <li class="nav-item">
              <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
            </li>
          </ul>
        </nav>
