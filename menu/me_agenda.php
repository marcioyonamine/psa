<?php include "barra.php"; ?>

	
    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Módulo Agenda
			  <span class="sr-only">(current)</span></a>
            </li>
			<!--
            <li class="nav-item">
              <a class="nav-link" href="editais.php">Editais</a>
            </li>
			-->
<br /><br />
<form action="?" method="POST">

			<label><center>Local</center></label>
			<select class="form-control" name="local" id="inputSubject" >
			<option value="0">Todos os locais</option>
			<?php geraTipoOpcao("local",$_POST['local']) ?>
			</select>
<br /><br />
			<label><center>Linguagem</center></label>
			<select class="form-control" name="linguagem" id="inputSubject" >
			<option value="0">Todas as linguagens</option>
			<?php geraTipoOpcao("linguagens",$_POST['linguagem']) ?>
			</select>
<br /><br />
			<label><center>Projeto</center></label>
			<select class="form-control" name="projeto" id="inputSubject" >
			<option value="0">Todas as linguagens</option>
			<?php geraTipoOpcao("projeto",$_POST['projeto']) ?>
			</select>
<br /><br />
<input type="submit" class="btn btn-theme btn-md btn-block" name="filtro" value="Aplicar filtro" />
</form>         

<br /><br />

          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
            </li>
          </ul>
        </nav>

		