<?php $sitioUrl = 'http://localhost/bioasistmr/';?>
<table>  
	<tr><th colspan="3">Secciones</th></tr>            
	<tr>				
		<td><a href="<?php echo $sitioUrl.'Aulas/';?>"><?php echo $this->Html->image('aulas.png', array('alt' => 'Aulas', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Aulas</a></td>
		<td><a href="<?php echo $sitioUrl.'Asistencias/';?>"><?php echo $this->Html->image('asistencias.png', array('alt' => 'Asistencias', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Asistencias</a></td>
		<td><a href="<?php echo $sitioUrl.'BloquesHoras/';?>"><?php echo $this->Html->image('bloques_horas.png', array('alt' => 'Bloques de Horas', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Bloques</a></td>
	</tr>
	<tr>
		<td><a href="<?php echo $sitioUrl.'Horarios/';?>"><?php echo $this->Html->image('horarios.png', array('alt' => 'Horarios', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Horarios</a></td>
		<td><a href="<?php echo $sitioUrl.'Materias/';?>"><?php echo $this->Html->image('materias.png', array('alt' => 'Materias', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Materias</a></td>
		<td><a href="<?php echo $sitioUrl.'Personal/';?>"><?php echo $this->Html->image('personal.png', array('alt' => 'Personal', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Personal</a></td>
	</tr>
	<tr>
		<td><a href="<?php echo $sitioUrl.'PeriodosLectivos/';?>"><?php echo $this->Html->image('periodos.png', array('alt' => 'Períodos Lectivos', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Períodos</a></td>
		<td><a href="<?php echo $sitioUrl.'Secciones/';?>"><?php echo $this->Html->image('secciones.png', array('alt' => 'Secciones', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Secciones</a></td>
		<td><a href="<?php echo $sitioUrl.'Niveles/';?>"><?php echo $this->Html->image('semestres.png', array('alt' => 'Semestres', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Semestres</a></td>
	</tr>
	<tr>
		<td><a href="<?php echo $sitioUrl.'Reportes/';?>"><?php echo $this->Html->image('reportes.png', array('alt' => 'Reportes', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Reportes</a></td>
		<td><a href="<?php echo $sitioUrl.'usuarios/';?>"><?php echo $this->Html->image('usuarios.png', array('alt' => 'Usuarios', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Usuarios</a></td>
		<td><a href="<?php echo $sitioUrl.'perfiles/';?>"><?php echo $this->Html->image('perfiles.png', array('alt' => 'Perfiles de Usuarios', 'width' => '100', 'align' => 'absmiddle', 'border' => 0));?>Perfiles</a></td>
	</tr>           
</table>						