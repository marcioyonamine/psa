<?php include "barra.php"; ?>

	
    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Início <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="editais.php">Editais</a>
            </li>
            <!--<li class="nav-item">
              <a class="nav-link" href="inscricoes.php">Inscrições Selecionadas / Avaliações</a>
            </li>-->
			
			
			
			<?php
			$jurados = array(84,9,53,70,76,80,81,82,83,85,86);
			if(in_array($user->ID,$jurados)){
			?>
              <a class="nav-link" href="inscricoes.php?edital=349">Inscrições</a>
			<?php } ?>

			<?php 
		
			$peruser = array(2,1,5,6,7,53);
			if(in_array($user->ID,$peruser)){ ?>
			<li class="nav-item">
              <a class="nav-link" href="edital2fase.php?edital=349">Inscrições (2fase)</a>
            </li>
			<?php } ?>
			
            <!--<li class="nav-item">
              <a class="nav-link" href="inscricoes.php?p=all&edital=349"> Todas as Inscrições (Consulta)</a>
            </li>-->
			<?php 
		
			$peruser = array(2,1,5,6,7,53,15);
			if(in_array($user->ID,$peruser)){ ?>
            <li class="nav-item">
              <a class="nav-link" href="ranking.php?edital=349"> Ranking FIP 2018</a>
            </li>
			<?php } ?>
			<?php ?>
			<li class="nav-item">
              <a class="nav-link" href="http://culturaz.santoandre.sp.gov.br/autenticacao/" target="_blanck"> Login CulturAZ</a>
            </li>           
          </ul>

         



          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
            </li>
          </ul>
        </nav>
