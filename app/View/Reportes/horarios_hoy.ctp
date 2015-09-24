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

<h1>Horarios - <script>dia();</script> <a href="../pdf/"><?php echo $this->Html->image('icons/print.png', array('alt' => 'Aulas', 'width' => '15', 'align' => 'absmiddle', 'border' => 0));?></a></h1>

<div id="horarios">
        <?php if(empty($horarios)) { ?>
               <h2>No hay horarios registrados para hoy!!</h2>
        <?php } else {?>	
	<table>
		<tr>
			<th>N°</th>
			<th>Materia</th>			
			<th>Apellidos y Nombres</th>
			<th>Sección</th>
			<th>Inicio</th>
			<th>Fin</th>
			<th>Aula</th>
			
		</tr>
		<?php 
			$i = 1;
			foreach($horarios as $horario) { 
		?>
		<tr>		
			<td><?php echo $i; ?></td>		
			<td><?php echo $horario['materias']['materia_nombre']; ?></td>
			<td><?php echo $horario['personal']['apellidos'].", ".$horario['personal']['nombres']; ?></td>
			<td><?php echo $horario['secciones']['seccion_nombre']; ?></td>
			<td><?php echo bloqueHora($bloques, $horario['horarios']['inicio']); ?></td>
			<td><?php echo bloqueHora($bloques,$horario['horarios']['fin']); ?></td>
			<td><?php echo $horario['aulas']['aula_nombre']; ?></td>
			
		</tr>
		<?php
				$i++;	
				 } 
		?>
	</table>
        <?php } //fin de la condición cuando existen registros?>
</div>