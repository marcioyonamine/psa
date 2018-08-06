<?php 
/*
Orçamento 	(Série Mensal)
	> Total
	> Contigenciamento
	> Suplementado / Liberado (?)
	> Empenhado
	> Reservado
	> Disponível
	> % reservado/empenhado em relação ao disponível (executado)

Público e Distribuição - Eventos (Série Mensal) 	> Público atendido
	> Número de atividades
	> Número de atividades com artistas locais (criar especificação)
	> % atividades com artistas locais
	> Número Agentes Culturais envolvidos (agentes?)
	> Número de Bairros
	> % Bairros atendidos (ref. 105)
	> Descentralizados (Número de bairros)
	
Público e Distribuição - Atvidades continuadas (Série Mensal) 	> Público atendido
	> Número de atividades
	> Número de atividades com artistas locais (criar especificação)
	> % atividades com artistas locais
	> Número Agentes Culturais envolvidos (agentes?)
	> Número de Bairros
	> % Bairros atendidos (ref. 105)
	> Descentralizados (Número de bairros)

Incentivo a Criação (Atendimentos) - Inscrições / Evasão?
	> Inscrições
	> Evasão
	> Apresentações / trabalhos
	
Convocatórias / Editais ();

Plataforma CulturAZ (série histórica mensal)
	> Total eventos, projetos, agentes, locais
	> Eventos Novos
	> Projetos Novos
	> Novos agentes
	
Monitoramento Redes Sociais (série histórica mensal)
	> Páginas de Facebook 
	>> Cultura
	>> Casa da Palavra
	>> ELCV
	>> EMIA
	>> Museu
	>> CEU MAREK
	>> Biblioteca
	>> Biblioteca Floresta
	>> ELD
	>> Orquestra 
	>> Casa do Olhar
	>> CONDEPHAAPSA

	
Indicadores (25 e 26 de junho reunião)
		-> evento
			-> artistas locais (novo campo)
			-> Parceria e qual parceiro?
			-> agentes locais
			-> bairros atendidos (rever nomenclatura de espaços no culturaz e colocar bairros)
			
		-> serviço
		
		
		-> escolas (cursos continuados) / inscritos / frequência
			alunos matriculados
		
		
			-> público
		
Ciclo
Concurso
Conferência
Congresso
Contação de História
Convenção
Curso
Encontros
Espetáculo
Espetáculo Infantil
Feira
Festa Popular
Festa Religiosa
Festival
Fórum
Intervenção
Jornada
Mostra
Oficina
Palestra
Parada / Desfile
Performance
Programa
Reunião 
Sarau
Seminário
Sessão de Cinema
Show
Simpósio
Workshop


"Exposição" CulturAZ sobrepor no mesmo espaço

tipo = geral
       especifico 
		
	   
contagem = média aritmética
		   total		
	*/
	
	?>
<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
//session_start(); // carrega a sessão

?>



  <body>
  
  <?php include "menu/me_indicadores.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
 <?php 
 switch($p){
case "inicio": ?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h3>Relatórios de Público</h3>
				</div>
        </div>
         <div class="table-responsive">
				<p>Escolha no Menu ao lado o tipo de indicador que deseja inserir.</p>

		 </div>

    </div>
</section>

 
	 
<?php 	 
break;	 
 case "inserirevento":
 ?>
 
  <link href="css/jquery-ui.css" rel="stylesheet">
 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 
 <script>
$(function() {
    $( ".calendario" ).datepicker();
	$( ".hora" ).mask("99:99");
	$( ".min" ).mask("999");
	$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
});



</script>

 <script type="application/javascript">
	$(function()
	{
		$('#idEvento').change(function()
		{
			if( $(this).val() )
			{
				$('#idOcorrencia').hide();
				$('.carregando').show();
				$.getJSON('inc/ind.ocor.ajax.php?',{idEvento: $(this).val(), ajax: 'true'}, function(j)
				{
					var options = '<option value="0"></option>';	
					for (var i = 0; i < j.length; i++)
					{
						options += '<option value="' + j[i].idOcorrencia + '">' + j[i].data + '</option>';
					}	
					$('#idOcorrencia').html(options).show();
					$('.carregando').hide();
				});
			}
			else
			{
				$('#idOcorrencia').html('<option value="">-- Escolha um projeto --</option>');
			}
		});
	});
</script>

<section id="contact" class="home-section bg-white">
	<div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h2>Relatórios de Público - Inserir</h2>
					<?php
					// listar o evento;
					?>
					<br /><Br />
				</div>
        </div>
			
		</div>
		
		<?php 
		$idUsuario = $user->ID;
		if($idUsuario != '1' AND $idUsuario != '93'){
		$sql_lista_evento = "SELECT nomeEvento,idEvento FROM sc_evento WHERE (idUsuario = '$idUsuario' OR idResponsavel = '$idUsuario' OR idSuplente = '$idUsuario') AND (dataEnvio IS NOT NULL) ORDER BY nomeEvento ASC";
		}else{
		$sql_lista_evento = "SELECT nomeEvento,idEvento FROM sc_evento WHERE (dataEnvio IS NOT NULL) ORDER BY nomeEvento ASC";
			
		}
		$eventos = $wpdb->get_results($sql_lista_evento,ARRAY_A);
		?>
		<div class="row">
		<form class="formocor" action="?p=listarevento" method="POST" role="form">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Evento/Atividade</label>
							<select class="form-control" name="idEvento" id="idEvento" ><option>Selecione</option>
							<?php for($i = 0; $i < count($eventos); $i++){?>
							<option value='<?php echo $eventos[$i]['idEvento']; ?>'><?php echo $eventos[$i]['nomeEvento']; ?></option>
							<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Local</label>
							<select class="form-control" name="idOcorrencia" id="idOcorrencia" >

							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Tipo de Público</label>
							<select class="form-control" name="tipo" id="inputSubject" ><option>Selecione</option>
							<option value="1">Geral</option>
							<option value="2">Específico</option>
							</select>
						</div>
					</div>
				<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<label>Período do Relatório - Data de Início:</label>
                    <input type='text' class="form-control calendario" name="periodoInicio"/>
				</div>
			</div>
            <div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<label>Período do Relatório - Data de Encerramento (se for data única, não preencher):</label>
                    <input type='text' class="form-control calendario" name="periodoFim"/>
                </div>
            </div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
							<label>Dias úteis do período (se for data única, não preencher)</label>
							<input type="text" name="ndias" class="form-control" />
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Tipo de Contagem</label>
							<select class="form-control" name="contagem" id="inputSubject" ><option>Selecione</option>
							<option value="1">Número total (absoluto)</option>
							<option value="2">Média Geral (por dia)</option>
							</select>
						</div>
					</div>
				<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
							<label>Público (Número de espectadores)</label>
							<input type="text" name="valor" class="form-control" />
						</div> 
					</div>


					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Relato</label>
							<textarea name="relato" class="form-control" rows="10" placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="inserir" value="1" />
							<button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
						</div>
					</div>
				</form>
			</div>

</section>

<?php 	 
break;	 
 case "inserirbiblioteca":

 ?>
 
 <link href="css/jquery-ui.css" rel="stylesheet">
 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 
 <script>
$(function() {
    $( ".calendario" ).datepicker();
	$( ".hora" ).mask("99:99");
	$( ".min" ).mask("999");
	$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
});



</script>



<section id="contact" class="home-section bg-white">
	<div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h3>Biblioteca - Inserir</h3>
					<p><?php //echo $sql; ?></p>
				</div>
        </div>
			
		</div>
		<div class="row">	

		<form class="formocor" action="?p=listarbiblioteca" method="POST" role="form">
            <div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<label>Período de Avaliação - Início:</label>
                    <input type='text' class="form-control calendario" name="periodo_inicio" value="<?php //echo exibirDataBr($ocor['dataInicio']); ?>"/>
				</div>
			</div>
            <div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<label>Período de Avaliação - Fim:</label>
                    <input type='text' class="form-control calendario" name="periodo_fim" value="<?php //if($ocor['dataFinal'] != '0000-00-00'){ echo exibirDataBr($ocor['dataFinal']);} ?>"/>
                </div>
            </div>




			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Público Biblioteca Central (só número, sem pontuação)</label>
			<input type="text" name="pub_central" class="form-control publico" value="" />
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Público Biblioteca Ramais (só número, sem pontuação)</label>
			<input type="text" name="pub_ramais" class="form-control publico" value="" />
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Empréstimos Biblioteca Central (só número, sem pontuação)</label>
			<input type="text" name="emp_central" class="form-control publico" value="" />
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Empréstimos Biblioteca Ramais (só número, sem pontuação)</label>
			<input type="text" name="emp_ramais" class="form-control publico" value="" />
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Sócios Biblioteca Central (só número, sem pontuação)</label>
			<input type="text" name="soc_central" class="form-control publico" value="" />
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Sócios Biblioteca Ramais (só número, sem pontuação)</label>
			<input type="text" name="soc_ramais" class="form-control publico" value="" />
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Downloads (só número, sem pontuação)</label>
			<input type="text" name="downloads" class="form-control publico" value="" />
			</div>

			</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>obs</label>
							<textarea name="obs" class="form-control" rows="10" placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="inserir" value="1" />
							<button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
						</div>
					</div>			
			</form>
			</div>

</section>
<?php 
break;
case "listarbiblioteca":

if(isset($_POST['apagar'])){
	$sql_update = "UPDATE sc_ind_biblioteca SET publicado = '0' WHERE id = '".$_POST['apagar']."'";
	$apagar = $wpdb->query($sql_update);
	if($apagar == 1){
		$mensagem = alerta("Relatório apagado com sucesso","success");
	}
}


if(isset($_POST['inserir'])){
$mensagem = alerta("Erro.","");
  $periodo_inicio =  exibirDataMysql($_POST["periodo_inicio"]);
  $periodo_fim =  exibirDataMysql($_POST["periodo_fim"]);
  $pub_central =  $_POST["pub_central"];
  $pub_ramais =  $_POST["pub_ramais"];
  $emp_central =  $_POST["emp_central"];
  $emp_ramais =  $_POST["emp_ramais"];
  $soc_central =  $_POST["soc_central"];
  $soc_ramais =  $_POST["soc_ramais"];
  $downloads = $_POST["downloads"];
  $obs =  $_POST["obs"];
  
  $sql_inserir = "INSERT INTO `sc_ind_biblioteca` (`id`, `periodo_inicio`, `periodo_fim`, `pub_central`, `pub_ramais`, `emp_central`, `emp_ramais`, `soc_central`, `soc_ramais`, `downloads`, `obs`, `idUsuario`, `atualizacao`, `publicado`) VALUES (NULL, '$periodo_inicio', '$periodo_fim', '$pub_central', '$pub_ramais', '$emp_central', '$emp_ramais', '$soc_central', '$soc_ramais', '$downloads', '$obs', '".$user->ID."', '".date("Y-m-d")."','1')";
  //echo $sql_inserir;
   $ins = $wpdb->query($sql_inserir);
   if($ins == 1){
	   $mensagem = alerta("Relatório inserido com sucesso.","success");
   }
}



  



?>
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h3>Biblioteca - Listar Relatórios</h3>
					<p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
					<?php
					// listar o evento;
					// var_dump($ex);
					?>

				</div>		
		</div>
		
		<?php 
				$sel = "SELECT * FROM sc_ind_biblioteca WHERE publicado = '1' AND idUsuario = '".$user->ID."' ORDER BY periodo_inicio DESC";
				$ocor = $wpdb->get_results($sel,ARRAY_A);
				if(count($ocor) > 0){
		?>
		
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Período/Data</th>
                  <th>Público</th>
                  <th>Empréstimos</th>
                  <th>Sócios</th>
                  <th>Downloads</th>
                  <th width="10%"></th>

				  </tr>
              </thead>
              <tbody>
				<?php
				for($i = 0; $i < count($ocor); $i++){
				?>
				<tr>
                  <td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']); ?><?php if($ocor[$i]['periodo_fim'] != '0000-00-00'){ echo " a ".exibirDataBr($ocor[$i]['periodo_fim']);} ?></td>
				<td><?php echo $ocor[$i]['pub_central']+$ocor[$i]['pub_ramais'] ?></td>	  
				<td><?php echo $ocor[$i]['emp_central']+$ocor[$i]['emp_ramais'] ?></td>	 
				<td><?php echo $ocor[$i]['soc_central']+$ocor[$i]['soc_ramais'] ?></td>	 
				<td><?php echo $ocor[$i]['downloads'] ?></td>	 
                  <td>
					<form method="POST" action="?p=listarbiblioteca" class="form-horizontal" role="form">
					<input type="hidden" name="apagar" value="<?php echo $ocor[$i]['id']; ?>" />
					<input type="submit" class="btn btn-theme btn-sm btn-block" value="Apagar">
					</form>
				</td>
                </tr>
				<?php } ?>

				</tbody>
            </table>
			
			
			
          </div>

			</div>

		  <?php } else { ?>
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
				<p> Não há relatórios cadastrados. </p>
				</div>		
		</div>

		
		<?php } ?>


<?php 
break;
 case "inseririncentivo":

 ?>
 
 <link href="css/jquery-ui.css" rel="stylesheet">
 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 
 <script>
$(function() {
    $( ".calendario" ).datepicker();
	$( ".hora" ).mask("99:99");
	$( ".min" ).mask("999");
	$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
});



</script>



<section id="contact" class="home-section bg-white">
	<div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h3>Incentivo à Criação - Inserir Disciplina</h3>
					<p><?php //echo $sql; ?></p>
				</div>
        </div>
			
		</div>
		<div class="row">	

		<form class="formocor" action="?p=listarincentivo" method="POST" role="form">

			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Equipamentos Culturais / Local</label>
				<select class="form-control" name="equipamento" id="programa" >
								<?php geraTipoOpcao("local") ?>
								<option value='0'>Outros</option>
							</select>
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Outros Locais</label>
			<input type="text" name="outros" class="form-control" value="" />
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Bairro</label>
				<select class="form-control" name="bairro" id="programa" >
								<?php geraTipoOpcao("bairro") ?>
							</select>
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Projeto</label>
							<select class="form-control" name="projeto" id="programa" >
								<?php geraTipoOpcao("projeto") ?>
							</select>
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Tipo de ação</label>
				<select class="form-control" name="tipo_acao" id="programa" >
								<?php geraTipoOpcao("tipo_evento") ?>
							</select>
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Título da ação (título usado para divulgação na cidade)</label>
			<input type="text" name="titulo_acao" class="form-control" value="" />
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Linguagem</label>
				<select class="form-control" name="linguagem" id="programa" >
								<?php geraTipoOpcao("linguagens") ?>
							</select>
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Disciplinas</label>
			<input type="text" name="disciplinas" class="form-control" value="" />
			</div>
			</div>	

            <div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<label>Início:</label>
                    <input type='text' class="form-control calendario" name="ocor_inicio" value="<?php //echo exibirDataBr($ocor['dataInicio']); ?>"/>
				</div>
			</div>
            <div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<label>Fim:</label>
                    <input type='text' class="form-control calendario" name="ocor_fim" value="<?php //if($ocor['dataFinal'] != '0000-00-00'){ echo exibirDataBr($ocor['dataFinal']);} ?>"/>
                </div>
            </div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Carga Horária</label>
			<input type="text" name="carga_horaria" class="form-control" value="" />
			</div>
			</div>				
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número de Concluintes</label>
			<input type="text" name="n_concluintes" class="form-control" value="" />
			</div>
			</div>				
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número de Evasão</label>
			<input type="text" name="n_evasao" class="form-control" value="" />
			</div>
			</div>				
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Nome do(s) profissional(is)</label>
			<input type="text" name="nome_profissional" class="form-control" value="" />
			</div>
			</div>	
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Profissionnal é de Santo André?</label>
							<select class="form-control" name="santo_andre" id="programa" >
								<option value = '1'>Sim</option>
								<option value = '0'>Não</option>

								</select>
			</div>
			</div>				
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Custo da hora/aula do profissional</label>
			<input type="text" name="custo_hora_aula" class="form-control valor" value="" />
			</div>
			</div>					

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Carga horária total do profissional para esta ação</label>
			<input type="text" name="carga_horaria_prof" class="form-control" value="" />
			</div>
			</div>	

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Custo total de contratação do profissional para esta ação (R$)
</label>
			<input type="text" name="custo_total" class="form-control valor" value="" />
			</div>
			</div>				
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Gastos com materiais de consumo</label>
			<input type="text" name="material_consumo" class="form-control valor" value="" />
			</div>
			</div>				

			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Houve parceria para esta ação?</label>
							<select class="form-control" name="parceria" id="programa" >
								<option value = '1'>Sim</option>
								<option value = '0'>Não</option>

								</select>
			</div>
			</div>	

			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Qual o parceiro (incluindo voluntariado)?</label>
			<input type="text" name="parceiro" class="form-control" value="" />
			</div>
			</div>					

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número de vagas oferecidas</label>
			<input type="text" name="vagas" class="form-control" value="" />
			</div>
			</div>	
						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número de rematriculados
</label>
			<input type="text" name="rematriculas" class="form-control" value="" />
			</div>
			</div>	

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número de inscritos
</label>
			<input type="text" name="inscritos" class="form-control" value="" />
			</div>
			</div>	

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número de interessados em lista de espera</label>
			<input type="text" name="espera" class="form-control" value="" />
			</div>
			</div>	

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)
</label>
			<input type="text" name="atendidos" class="form-control" value="" />
			</div>
			</div>	

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número total de atendidos que são moradores de Santo André</label>
			<input type="text" name="atendidos_sa" class="form-control" value="" />
			</div>
			</div>	
			
			<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Obs</label>
							<textarea name="obs" class="form-control" rows="10" placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php //echo $campo["sinopse"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="inserir" value="1" />
							<button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
						</div>
					</div>			
			</form>
			</div>

</section>


<?php 
break;
 case "editarincentivo":
if(isset($_POST['editar'])){
	$ind = recuperaDados("sc_ind_incentivo",$_POST['editar'],"id");
	
}
$editar = 0;

if(isset($_POST["equipamento"])){
  $equipamento = $_POST["equipamento"];
  $outros = $_POST["outros"];
  $bairro = $_POST["bairro"];
  $projeto = $_POST["projeto"];
  $tipo_acao = $_POST["tipo_acao"];
  $titulo_acao = $_POST["titulo_acao"];
  $linguagem = $_POST["linguagem"];
  $disciplinas = $_POST["disciplinas"];
  $ocor_inicio = exibirDataMysql($_POST["ocor_inicio"]);
  $ocor_fim = exibirDataMysql($_POST["ocor_fim"]);
  $carga_horaria = $_POST["carga_horaria"];
  $n_concluintes = $_POST["n_concluintes"];
  $n_evasao = $_POST["n_evasao"];
  $nome_profissional = $_POST["nome_profissional"];
  $santo_andre = $_POST["santo_andre"];
  $custo_hora_aula = dinheiroDeBr($_POST["custo_hora_aula"]);
  $carga_horaria_prof = $_POST["carga_horaria_prof"];
  $custo_total = dinheiroDeBr($_POST["custo_total"]);
  $material_consumo = dinheiroDeBr($_POST["material_consumo"]);
  $parceria = $_POST["parceria"];
  $parceiro = $_POST["parceiro"];
  $vagas = $_POST["vagas"];
  $rematriculas = $_POST["rematriculas"];
  $inscritos = $_POST["inscritos"];
  $espera = $_POST["espera"];
  $atendidos = $_POST["atendidos"];
  $atendidos_sa = $_POST["atendidos_sa"];
  $obs = $_POST["obs"];
  $atualizacao = date("Y-m-d H:s:i");
  $idUsuario = $user->ID;

  $sql_update = "UPDATE sc_ind_incentivo SET
   equipamento = '$equipamento',
  outros = '$outros',
  bairro = '$bairro',
   projeto = '$projeto',
   tipo_acao = '$tipo_acao',
   titulo_acao = '$titulo_acao',
   linguagem = '$linguagem',
   disciplinas = '$disciplinas',
   ocor_inicio = '$ocor_inicio',
   ocor_fim = '$ocor_fim',
   carga_horaria = '$carga_horaria',
   n_concluintes = '$n_concluintes',
   n_evasao = '$n_evasao',
   nome_profissional = '$nome_profissional',
   santo_andre = '$santo_andre',
   custo_hora_aula = '$custo_hora_aula',
   carga_horaria_prof = '$carga_horaria_prof',   
   custo_total = '$custo_total',
   material_consumo = '$material_consumo',
   parceria = '$parceria',
   parceiro = '$parceiro',
   vagas = '$vagas',
   rematriculas = '$rematriculas',
   inscritos = '$inscritos',
   espera = '$espera',
   atendidos = '$atendidos',
   atendidos_sa = '$atendidos_sa',
   obs = '$obs'
   WHERE id = '".$_POST['editar']."'";

	$editar = $wpdb->query($sql_update);
	$ind = recuperaDados("sc_ind_incentivo",$_POST['editar'],"id");
  
}

 ?>
 
 <link href="css/jquery-ui.css" rel="stylesheet">
 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 
 <script>
$(function() {
    $( ".calendario" ).datepicker();
	$( ".hora" ).mask("99:99");
	$( ".min" ).mask("999");
	$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
});



</script>



<section id="contact" class="home-section bg-white">
	<div class="container">
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h3>Incentivo à Criação - Editar Disciplina</h3>
					<p><?php if($editar == 1){
						echo alerta("Disciplina/Curso atualizado.","success");
					}; ?></p>
				</div>
        </div>
			
		</div>
		<div class="row">	

		<form class="formocor" action="?p=editarincentivo" method="POST" role="form">
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Equipamentos Culturais / Local</label>
				<select class="form-control" name="equipamento" id="programa" >
								<?php geraTipoOpcao("local",$ind['equipamento']) ?>
								<option value='0'>Outros</option>
							</select>
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Outros Locais</label>
			<input type="text" name="outros" class="form-control" value="<?php echo $ind['outros']; ?>" />
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Bairro</label>
				<select class="form-control" name="bairro" id="programa" >
								<?php geraTipoOpcao("bairro",$ind['bairro']) ?>
							</select>
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Projeto</label>
							<select class="form-control" name="projeto" id="programa" >
								<?php geraTipoOpcao("projeto",$ind['projeto']) ?>
							</select>
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Tipo de ação</label>
				<select class="form-control" name="tipo_acao" id="programa" >
								<?php geraTipoOpcao("tipo_evento",$ind['tipo_acao']) ?>
							</select>
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Título da ação (título usado para divulgação na cidade)</label>
			<input type="text" name="titulo_acao" class="form-control" value="<?php echo $ind['titulo_acao']; ?>" />
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Linguagem</label>
				<select class="form-control" name="linguagem" id="programa" >
								<?php geraTipoOpcao("linguagens",$ind['linguagem']) ?>
							</select>
			</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Disciplinas</label>
			<input type="text" name="disciplinas" class="form-control" value="<?php echo $ind['disciplinas']; ?>" />
			</div>
			</div>	

            <div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<label>Início:</label>
                    <input type='text' class="form-control calendario" name="ocor_inicio" value="<?php echo exibirDataBr($ind['ocor_inicio']); ?>"/>
				</div>
			</div>
            <div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<label>Fim:</label>
                    <input type='text' class="form-control calendario" name="ocor_fim" value="<?php if($ind['ocor_fim'] != '0000-00-00'){ echo exibirDataBr($ind['ocor_fim']);} ?>"/>
                </div>
            </div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Carga Horária</label>
			<input type="text" name="carga_horaria" class="form-control" value="<?php echo $ind['carga_horaria']; ?>" />
			</div>
			</div>				
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número de Concluintes</label>
			<input type="text" name="n_concluintes" class="form-control" value="<?php echo $ind['n_concluintes']; ?>" />
			</div>
			</div>				
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número de Evasão</label>
			<input type="text" name="n_evasao" class="form-control" value="<?php echo $ind['n_evasao']; ?>" />
			</div>
			</div>				
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Nome do(s) profissional(is)</label>
			<input type="text" name="nome_profissional" class="form-control" value="<?php echo $ind['nome_profissional']; ?>" />
			</div>
			</div>	
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Profissionnal é de Santo André?</label>
							<select class="form-control" name="santo_andre" id="programa" >
								<option value = '1' <?php if($ind['santo_andre'] == 1){ echo "selected";} ?> >Sim</option>
								<option value = '0' <?php if($ind['santo_andre'] == 0){ echo "selected";} ?> >Não</option>
								
								</select>
			</div>
			</div>				
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Custo da hora/aula do profissional</label>
			<input type="text" name="custo_hora_aula" class="form-control valor" value="<?php echo $ind['custo_hora_aula']; ?>" />
			</div>
			</div>					

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Carga horária total do profissional para esta ação</label>
			<input type="text" name="carga_horaria_prof" class="form-control" value="<?php echo $ind['carga_horaria_prof']; ?>" />
			</div>
			</div>	

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Custo total de contratação do profissional para esta ação (R$)
</label>
			<input type="text" name="custo_total" class="form-control valor" value="<?php echo $ind['custo_total']; ?>" />
			</div>
			</div>				
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Gastos com materiais de consumo</label>
			<input type="text" name="material_consumo" class="form-control valor" value="<?php echo $ind['material_consumo']; ?>" />
			</div>
			</div>				

			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Houve parceria para esta ação?</label>
							<select class="form-control" name="parceria" id="programa" >
								<option value = '1' <?php if($ind['parceria'] == 1){ echo "selected";} ?> >Sim</option>
								<option value = '0' <?php if($ind['parceria'] == 0){ echo "selected";} ?> >Não</option>

								</select>
			</div>
			</div>	

			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Qual o parceiro (incluindo voluntariado)?</label>
			<input type="text" name="parceiro" class="form-control" value="<?php echo $ind['parceiro']; ?>" />
			</div>
			</div>					

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número de vagas oferecidas</label>
			<input type="text" name="vagas" class="form-control" value="<?php echo $ind['vagas']; ?>" />
			</div>
			</div>	
						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número de rematriculados
</label>
			<input type="text" name="rematriculas" class="form-control" value="<?php echo $ind['rematriculas']; ?>" />
			</div>
			</div>	

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número de inscritos
</label>
			<input type="text" name="inscritos" class="form-control" value="<?php echo $ind['inscritos']; ?>" />
			</div>
			</div>	

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número de interessados em lista de espera</label>
			<input type="text" name="espera" class="form-control" value="<?php echo $ind['espera']; ?>" />
			</div>
			</div>	

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)
</label>
			<input type="text" name="atendidos" class="form-control" value="<?php echo $ind['atendidos']; ?>" />
			</div>
			</div>	

						<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<label>Número total de atendidos que são moradores de Santo André</label>
			<input type="text" name="atendidos_sa" class="form-control" value="<?php echo $ind['atendidos_sa']; ?>" />
			</div>
			</div>	
			
			<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Obs</label>
							<textarea name="obs" class="form-control" rows="10" placeholder="Relato de incidentes, impressões, avaliações e críticas."><?php echo $ind["obs"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="editar" value="<?php echo $ind['id']; ?>" />
							<button type="submit" class="btn btn-theme btn-lg btn-block">Enviar Relatório</button>
						</div>
					</div>			
			</form>
			</div>

</section>


<?php 
break;

case "listarincentivo":


if(isset($_POST['inserir']) OR isset($_POST['editar'])){
  $equipamento = $_POST["equipamento"];
  $outros = $_POST["outros"];
  $bairro = $_POST["bairro"];
  $projeto = $_POST["projeto"];
  $tipo_acao = $_POST["tipo_acao"];
  $titulo_acao = $_POST["titulo_acao"];
  $linguagem = $_POST["linguagem"];
  $disciplinas = $_POST["disciplinas"];
  $ocor_inicio = exibirDataMysql($_POST["ocor_inicio"]);
  $ocor_fim = exibirDataMysql($_POST["ocor_fim"]);
  $carga_horaria = $_POST["carga_horaria"];
  $n_concluintes = $_POST["n_concluintes"];
  $n_evasao = $_POST["n_evasao"];
  $nome_profissional = $_POST["nome_profissional"];
  $santo_andre = $_POST["santo_andre"];
  $custo_hora_aula = dinheiroDeBr($_POST["custo_hora_aula"]);
  $carga_horaria_prof = $_POST["carga_horaria_prof"];
  $custo_total = dinheiroDeBr($_POST["custo_total"]);
  $material_consumo = dinheiroDeBr($_POST["material_consumo"]);
  $parceria = $_POST["parceria"];
  $parceiro = $_POST["parceiro"];
  $vagas = $_POST["vagas"];
  $rematriculas = $_POST["rematriculas"];
  $inscritos = $_POST["inscritos"];
  $espera = $_POST["espera"];
  $atendidos = $_POST["atendidos"];
  $atendidos_sa = $_POST["atendidos_sa"];
  $obs = $_POST["obs"];
  $atualizacao = date("Y-m-d H:s:i");
  $idUsuario = $user->ID;
}

if(isset($_POST['inserir'])){
	$sql_ins = "INSERT INTO `sc_ind_incentivo` (`equipamento`, `outros`, `bairro`, `projeto`, `tipo_acao`, `titulo_acao`, `disciplinas`, `linguagem`, `ocor_inicio`, `ocor_fim`, `carga_horaria`, `n_concluintes`, `n_evasao`, `nome_profissional`, `santo_andre`, `custo_hora_aula`, `carga_horaria_prof`, `custo_total`, `material_consumo`, `parceria`, `parceiro`, `vagas`, `rematriculas`, `inscritos`, `espera`, `atendidos`, `atendidos_sa`, `obs`, `atualizacao`, `idUsuario`, `publicado`) VALUES ( '$equipamento', '$outros', '$bairro', '$projeto', '$tipo_acao', '$titulo_acao', '$disciplinas', '$linguagem', '$ocor_inicio', '$ocor_fim', '$carga_horaria', '$n_concluintes', '$n_evasao', '$nome_profissional', '$santo_andre', '$custo_hora_aula', '$carga_horaria_prof', '$custo_total', '$material_consumo', '$parceria', '$parceiro', '$vagas', '$rematriculas', '$inscritos', '$espera', '$atendidos', '$atendidos_sa','$obs','$atualizacao','$idUsuario','1' );";
	$ins = $wpdb->query($sql_ins);
	$lastid = $wpdb->insert_id;
	
}



if(isset($_POST['apagar'])){
	global $wpdb;
	$id = $_POST['apagar'];
	$sql = "UPDATE sc_ind_incentivo SET publicado = '0' WHERE id = '$id'";
	$apagar = $wpdb->query($sql);	
}



?>


        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h3>Incentivo à Criação - Listar Disciplinas</h3>
					<?php
					// listar o evento;
					//var_dump($lastid);
					?>

				</div>		
		</div>
		
		<?php 
				$sel = "SELECT * FROM sc_ind_incentivo WHERE publicado = '1' ORDER BY id DESC";
				$ocor = $wpdb->get_results($sel,ARRAY_A);
		if(count($ocor) > 0){
		?>
		
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Título Disciplina/Curso</th>
                  <th>Responsável</th>
                  <th>Período</th>
                  <th width="10%"></th>
                  <th width="10%"></th>

				  </tr>
              </thead>
              <tbody>
				<?php
				for($i = 0; $i < count($ocor); $i++){
					
				?>
				<tr>
                  <td><?php echo $ocor[$i]['titulo_acao'];  ?></td>
                  <td><?php echo $ocor[$i]['nome_profissional']; ?></td>
                  <td><?php echo exibirDataBr($ocor[$i]['ocor_inicio']) ?> a <?php echo exibirDataBr($ocor[$i]['ocor_fim']) ?> </td>				  
                  <td>
					<form method="POST" action="?p=editarincentivo" class="form-horizontal" role="form">
					<input type="hidden" name="editar" value="<?php echo $ocor[$i]['id']; ?>" />
					<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
					</form>
				 </td>
                  <td>
					<form method="POST" action="?p=listarincentivo" class="form-horizontal" role="form">
					<input type="hidden" name="apagar" value="<?php echo $ocor[$i]['id']; ?>" />
					<input type="submit" class="btn btn-theme btn-sm btn-block" value="Apagar">
					</form>
				</td>
                </tr>
				<?php } ?>

				</tbody>
            </table>
			
			
			
          </div>

			</div>

		  <?php } else { ?>
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
				<p> Não há disciplinas/cursos cadastrados. </p>
				</div>		
		</div>

		
		<?php } ?>
<?php 
case "listarevento":

/*
array(9) {
  ["idEvento"]=>
  string(3) "121"
  ["tipo"]=>
  string(1) "1"
  ["periodoInicio"]=>
  string(10) "06/06/2018"
  ["periodoFim"]=>
  string(0) ""
  ["ndias"]=>
  string(0) ""
  ["contagem"]=>
  string(1) "1"
  ["valor"]=>
  string(3) "300"
  ["relato"]=>
  string(8) "teste123"
  ["inserir_evento"]=>
  string(1) "1"
}
*/

if(isset($_POST['apagar'])){
	$sql_update = "UPDATE sc_indicadores SET publicado = '0' WHERE id = '".$_POST['apagar']."'";
	$apagar = $wpdb->query($sql_update);
	if($apagar == 1){
		$mensagem = alerta("Relatório apagado com sucesso","success");
	}
}


if(isset($_POST['inserir'])){

	
  $idEvento = $_POST['idEvento'];
  $tipo = $_POST['tipo'];
  $idOcorrencia = $_POST['idOcorrencia'];
  $periodoInicio = exibirDataMysql($_POST['periodoInicio']);
   if($_POST['periodoFim'] != ''){
	$periodoFim = exibirDataMysql($_POST['periodoFim']);
  }else{
	$periodoFim = '0000-00-00';
	  
  }
  $ndias = $_POST['ndias'];
  $contagem = $_POST['contagem'];
  $valor = $_POST['valor'];
  $relato = $_POST['relato'];
  $idUsuario = $user->ID;

  $sql_inserir = "INSERT INTO `sc_indicadores` (`id`, `idEvento`, `valor`, `contagem`, `tipo`, `periodoInicio`, `periodoFim`, `ndias`, `idUsuario`, `relato`, `publicado`, `idOcorrencia`) VALUES (NULL, '$idEvento','$valor','$contagem', '$tipo','$periodoInicio', '$periodoFim', '$ndias', '$idUsuario', '$relato', '1','$idOcorrencia')";
  $ex = $wpdb->query($sql_inserir);
  if($ex == 1){
	  $mensagem = alerta("Relatório inserido com sucesso.","success");
  }
  
}

if(isset($_GET['filter'])){
	$order = ' ORDER BY "'.$_GET['filter'].'" '.$_GET['order'];
}else{
	$order = ' ORDER BY id DESC ';
}

$total = 0;
?>
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h3>Eventos - Listar Relatórios</h3>
					<p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
					<?php
					// listar o evento;
					// var_dump($ex);
					?>

				</div>		
		</div>
		
		<?php 
			if($user->ID != 1){
		
				$sel = "SELECT * FROM sc_indicadores WHERE publicado = '1' AND idUsuario = '".$user->ID."' $order";
			}else{
				$sel = "SELECT * FROM sc_indicadores WHERE publicado = '1' $order";
				
			}
				$ocor = $wpdb->get_results($sel,ARRAY_A);
				if(count($ocor) > 0){
		?>
		
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Evento</th>
                  <th>Período/Data</th>
                  <th>Contagem</th>
                  <th width="10%"></th>
                  <th width="10%"></th>

				  </tr>
              </thead>
              <tbody>
				<?php
				for($i = 0; $i < count($ocor); $i++){
					$evento = evento($ocor[$i]['idEvento']);
				?>
				<tr>
                  <td><?php echo $evento['titulo'];  ?></td>
                  <td><?php echo exibirDataBr($ocor[$i]['periodoInicio']); ?><?php if($ocor[$i]['periodoFim'] != '0000-00-00'){ echo " a ".exibirDataBr($ocor[$i]['periodoFim']);} ?></td>
                  <td><?php echo $ocor[$i]['valor']; if($ocor[$i]['contagem'] == 1){echo " (total)";}else{echo " (média/dia)";}  
				  $total = $total + $ocor[$i]['valor'];
				  
				  ?></td>				  
                  <td>
					
				 </td>
                  <td>
					<form method="POST" action="?p=listarevento" class="form-horizontal" role="form">
					<input type="hidden" name="apagar" value="<?php echo $ocor[$i]['id']; ?>" />
					<input type="submit" class="btn btn-theme btn-sm btn-block" value="Apagar">
					</form>
				</td>
                </tr>
			
				<?php } ?>
	<tr><td>Total:</td><td></td><td><?php echo $total; ?></td></tr>
				</tbody>
            </table>
			
			
			
          </div>

			</div>

		  <?php } else { ?>
        <div class="row">    
				<div class="col-md-offset-2 col-md-8">
				<p> Não há disciplinas/cursos cadastrados. </p>
				</div>		
		</div>

		
		<?php } ?>

<?php 

break;
case "grafico":
include ("inc/phplot/phplot.php");
?>
<?php 

$grafico = new PHPlot();

$grafico->SetFileFormat("png");

# Indicamos o títul do gráfico e o título dos dados no eixo X e Y do mesmo
$grafico->SetTitle("Gráfico de exemplo");
$grafico->SetXTitle("Eixo X");
$grafico->SetYTitle("Eixo Y");


# Definimos os dados do gráfico
$dados = array(
		array('Janeiro', 10),
		array('Fevereiro', 5),
		array('Março', 4),
		array('Abril', 8),
		array('Maio', 7),
		array('Junho', 5),
);

$grafico->SetDataValues($dados);
 
# Neste caso, usariamos o gráfico em barras
$grafico->SetPlotType("bars");

# Exibimos o gráfico
$grafico->DrawGraph();
?>

<?php 
break;
case "listar_evento_sem_indicador":

$sql = "SELECT idEvento,nomeEvento FROM sc_evento WHERE idEvento NOT IN(SELECT DISTINCT idEvento FROM sc_indicadores) AND dataEnvio IS NOT NULL";
$evento = $wpdb->get_results($sql,ARRAY_A);
echo "<h1>".count($evento)." eventos sem informação de público.</h1><br />";
for($i = 0; $i < count($evento); $i++){
	echo $evento[$i]['nomeEvento']."<br />";
	
}


?>




<?php 

break;
case "culturaz":

function chamaAPI($url,$data){
	$get_addr = $url.'?'.http_build_query($data);
	$ch = curl_init($get_addr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$page = curl_exec($ch);
	$evento = json_decode($page);
	$ccsp = converterObjParaArray($evento);
	return $ccsp;
	
}


$url_mapas = "http://culturaz.santoandre.sp.gov.br/api/";
$data = array(
	'@select' => 'createTimestamp'
);



$agente = chamaAPI($url_mapas."agent/find/",$data);
//$espaco = chamaAPI($url_mapas."space/find/",$data);
//$projeto = chamaAPI($url_mapas."project/find/",$data);
//$evento = chamaAPI($url_mapas."event/find/",$data);


	$k = array();

for($i = 0; $i < count($agente); $i++){
	$x = exibirDataBr($agente[$i]['createTimestamp']['date']);
	//echo $i." : ".$x;
	$y = explode("/",$x);	

	$k[$y[2]][$y[1]][$i] = $x;
	

	
}

echo "Total de agentes: ".count($k)."<br />";
echo "Total de agentes: ".sizeof($k)."<br />";
 
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