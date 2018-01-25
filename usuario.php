<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
//session_start();
	//$_SESSION['entidade'] = 'evento';
?>


  <body>
  
  <?php include "menu/me_evento.php"; ?>
 
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
 <?php 
 switch($p){
case "inicio": 
if(isset($_POST['atualizar'])){  // envia


	$usuario = array(
		'modulos' => '' ,
		'departamento' => '',
		'cr' => '',
		'funcao' => '',
		'chave01' => '',
		'chave02' => '',
		'idMapas' => ''
		
		
	);


	
}

/*
{"modulos": ["evento","atividade", "orcamento"," contrato","editais","relatorio"], "departamento": "Departamento de Planejamento e Projetos Especiais - CR 70500", "funcao": "Assessor de Gabinete", "edital":["273","1"]  }
*/

if(isset($_SESSION['id'])){
	unset($_SESSION['id']);
}
?>
 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Editar Usuário</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
					<div class="row">
						<div class="col-12">
							<label>Departamento</label>
							<select class="form-control" name="departamento" id="inputSubject" name="IdEstadoCivil">
							<option>Escolha uma opção</option>
							<?php echo geraTipoOpcao("unidade") ?>
							</select>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
							<label>CR</label>
							<input type="text" name="cr" class="form-control" id="inputSubject" value="" />
						</div>
					</div>
					<br />


					<div class="row">
						<div class="col-12">
							<label>Função</label>
							<input type="text" name="funcao" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
							<label>ID Agente Mapas (somente o número)</label>
							<input type="text" name="funcao" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />	
					<div class="row">
						<div class="col-12">
							<label>Mapas Chave 01</label>
							<input type="text" name="funcao" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />					<div class="row">
						<div class="col-12">
							<label>Mapas Chave 02</label>
							<input type="text" name="funcao" class="form-control" id="inputSubject" />
						</div>
					</div>
					<br />					
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="atualizar" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Salvar">
						</div>
					</div>
				</form>
			</div>
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