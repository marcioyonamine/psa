<?php 
/*
Calendário para os eventos Pré-CulturAZ

+ Listar filtros (quais?)
+ Aplicar cores
+ 

*/
?>
<?php require_once("../../wp-load.php"); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='fullcalendar.min.css' rel='stylesheet' />
<link href='fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='lib/moment.min.js'></script>
<script src='lib/jquery.min.js'></script>
<script src='fullcalendar.min.js'></script>
<script src='locale/pt-br.js'></script>
<script>

	$(document).ready(function() {
		
		var initialLocaleCode = 'pt-br';
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},
			defaultDate: '<?php echo date('Y-m-d'); ?>',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
			<?php 
			global $wpdb;
			$sql_busca = "SELECT nomeEvento,data, hora FROM sc_agenda, sc_evento WHERE sc_evento.idEvento = sc_agenda.idEvento ";
			$res = $wpdb->get_results($sql_busca,ARRAY_A);
			for($i = 0; $i < count($res); $i++){
				$title = $res[$i]['nomeEvento'];
				$data = $res[$i]['data'];
				$hora = $res[$i]['hora'];
				echo "{title: '".$title."',";
				echo "start: '".$data."T".$hora."'},";
			}
			?>
			]
		});
		
	});

</script>
<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}

</style>
</head>
<body>

	<div id='calendar'></div>

</body>
</html>
