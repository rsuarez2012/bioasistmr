<?php $sitioUrl = 'http://localhost/bioasistmr/';?>
<table>  
	<tr><th colspan="3">Secciones</th></tr>            
	<tr>				
		<td><a href="<?php echo $sitioUrl.'Aulas/';?>"><?php echo $this->Html->image('aulas.png', array('alt' => 'Aulas', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Aulas</a></td>
		<td><a href="<?php echo $sitioUrl.'Asistencias/';?>"><?php echo $this->Html->image('asistencias.png', array('alt' => 'Asistencias', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Asistencias</a></td>
		<td><a href="<?php echo $sitioUrl.'Horarios/';?>"><?php echo $this->Html->image('horarios.png', array('alt' => 'Horarios', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Horarios</a></td>
	</tr>
	<tr>		
		<td><a href="<?php echo $sitioUrl.'Materias/';?>"><?php echo $this->Html->image('materias.png', array('alt' => 'Materias', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Materias</a></td>
		<td><a href="<?php echo $sitioUrl.'Personal/';?>"><?php echo $this->Html->image('personal.png', array('alt' => 'Personal', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Personal</a></td>
		<td><a href="<?php echo $sitioUrl.'Secciones/';?>"><?php echo $this->Html->image('secciones.png', array('alt' => 'Secciones', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Secciones</a></td>
	</tr>
	<tr>
		<td><a href="<?php echo $sitioUrl.'Reportes/';?>"><?php echo $this->Html->image('reportes.png', array('alt' => 'Reportes', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Reportes</a></td>		
	</tr>           
</table>