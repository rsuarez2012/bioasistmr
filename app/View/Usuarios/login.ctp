<!--Inicio form admin-->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">	
			<div class="right">
				<?php echo $this->Form->create('Usuario', array( 'id' => 'sesionForm', 'class' => 'clearfix', 'controller' => 'usuarios', 'action' => 'login')); ?>				
				<table>
					<tr>
						<td><label class="grey" for="log">Usuario:</label></td>
						<td>
						<?php echo $this->Form->input('usuario', array('name' => 'usuario', 'label' => false, 'id' => 'usuario', 'class' => 'field')); ?></td>
						<td><label class="grey" for="pwd">Clave:</label></td>
						<td><?php echo $this->Form->input('clave', array('name' => 'clave', 'type' => 'password', 'label' => false, 'id' => 'clave', 'class' => 'field'));?></td>	            	
						<td><?php echo $this->Form->submit('Entrar', array('id' => 'bt_login'));?><?php echo $this->Form->end(); ?></td></tr>
				</table>
				</form>
			</div>
			
		</div>
	</div>	
	<div class="tab">
		<ul class="login">
			<li id="toggle">
				<a id="open" class="open" href="#"></a>
				<a id="close" style="display: none;" class="close" href="#"></a>			
			</li>
		</ul> 
	</div>
	<?php echo $this->Session->flash(); ?>
</div> 
<!--Fin formulario admin-->
<!--Información del Sistema-->

<div id="contenedor">
<div id="titulo">
	<div id="app-nombre">Sistema de Control de Asistencia</div>
	<div id="ayuda"><?php echo $this->Html->image('ayuda.png', array('alt' => 'Ayuda', 'width' => '20',  'align' => 'absmiddle')); ?></div>
</div>
<div id="app-info">
	<?php echo $this->Html->image('logo-ais.png', array('alt' => 'Control de Usuarios', 'width' => '80',  'align' => 'absmiddle')); ?>
	<p>Personal Docente<br/>AIS - UNERG</p>
	<br/>
	<?php echo $this->Html->link('Ver Horarios',array('controller' => 'reportes', 'action' => 'horariosHoy'), array('class' => 'popup')); ?>		
	<script type="text/javascript"> 
	$('.popup').popupWindow({ height:600, width:800, top:50, left:100 }); 
	</script>
</div>
<div id="registro">
	<div id="dia"><script>dia();</script></div>
	<?php echo $this->Form->create('Personal', array( 'id' => 'registroForm', 'controller' => 'personal', 'action' => 'registrar')); ?>	
	<br/><label>Bienvenido estimado profesor,<br/>ingrese su cédula:</label><br/>
	<?php echo $this->Form->input('cedula', array('name' => 'cedula', 'label' => false, 'id' => 'cedula', 'type' => 'password')); ?>
	
	<br/>
	<div id="fecha"><script>fecha();</script></div>
	<div id="spanreloj"></div>
	<?php echo $this->Form->end(); ?>	
</div>
<div id="pie">Desarrollado por: Tecnomundo SystemsS &copy; 2012</div>

</div>
<script type="text/javascript">
	function validar() {
		var cedula = $('#cedula').val();
		//Validación de ingreso de valores 
		if(cedula.length == 0) {
			alert("Debe ingresar un número de cédula!!");
			return false;
		}
		//Verificación valores numéricos
		else {
			if(isNaN(cedula)){
				alert("Debe ingresar valor numérico!!");
				return false;
			}
			//Envío del formulario
			else {
				return true;
			}
		}
	}

	setTimeout(function() {
	  $("#flashMessage").fadeOut().empty();
	}, 3400);
</script>
