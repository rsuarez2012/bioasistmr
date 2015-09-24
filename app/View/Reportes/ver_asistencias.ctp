<?php
	function bloqueHora($bloques, $bloque_id) {
		foreach($bloques as $b) {
			if($b['BloquesHora']['id']==$bloque_id) {
				$hora = $b['BloquesHora']['bloque'];
			}
		}
		return $hora;
	}	
 ?>
<h1>Reporte General de Asistencias- <a href="../../pdfVerAsistencias/<?php echo $rango; ?>"><?php echo $this->Html->image('icons/print.png', array('alt' => 'Aulas', 'width' => '15', 'align' => 'absmiddle', 'border' => 0));?></a></h1>
<div id="horarios">
         <?php if(empty($asistencias)) { ?>
               <h2>No hay asistencias registradas!!</h2>
        <?php } else {?>
	<table>
		<tr>
			<th>N°</th>
			<th>Fecha</th>
			<th>Docente</th>
			<th>Materia</th>						
			<th>Sección</th>
			<th>Inicio</th>
			<th>Fin</th>			
			<th>Hora Entrada</th>				
		</tr>
		<?php
			$i = 1; 
			foreach($asistencias as $asistencia) { 
		?>
		<tr>
			<td><?php echo $i; ?></td>                       
			<td><?php echo date('d-m-Y',strtotime($asistencia['0']['fecha'])); ?></td>
			<td><?php echo $asistencia['personal']['cedula']." - ".$asistencia['personal']['nombres'].", ".$asistencia['personal']['apellidos'] ; ?></td>
			<td><?php echo $asistencia['materias']['materia_nombre']; ?></td>
			<td><?php echo $asistencia['secciones']['seccion_nombre']; ?></td>
			<td><?php echo bloqueHora($bloques,$asistencia['horarios']['inicio']); ?></td>
			<td><?php echo bloqueHora($bloques, $asistencia['horarios']['fin']); ?></td>
			<td><?php echo $asistencia['0']['hora']; ?></td>
		</tr>
		<?php } ?>
	</table>
         <?php } //fin de la condición cuando existen registros?>
</div>