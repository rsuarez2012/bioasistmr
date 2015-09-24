<?php
	//Validamos la sesion
	if($this->Session->check('usuario')) {
		$usu = $this->Session->read('usuario');		
	}
	if(!isset($usu)) {
		header("Location: http://localhost/bioasistmr/usuarios/login");
	}
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$sitioNombre = 'Sistema de Control de Asistencia - UNERG .:. AIS';
$sitioUrl = 'http://localhost/bioasistmr/';
$sitioPie = $sitioNombre.' &copy; 2012 <br/> Desarrollado por: Silvia Perez & Ana Perez';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 
	echo  $this->Html->charset('UTF-8');
	?>
	<title>
		<?php echo $sitioNombre; ?>:		
	</title>
	<?php		
		echo $this->Html->css(array('main','accordion-menu', 'easyui', 'icon', 'demo',  'jquery-ui-1.8.custom'));
		echo $this->Html->script(array('jquery-1.8.0','jquery.easyui.min', 'jquery-ui-1.8.custom.min', 'datagrid-detailview'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
		<div id="encabezado">
			<div id="titulo"><h1><?php echo $this->Html->link($sitioNombre, $sitioUrl); ?></h1></div>
			<div id="sesion-cerrar">Conectado: <span><?php echo $usu['usuario']; ?></span><a href="<?php echo $sitioUrl.'usuarios/inicio';?>" title="Inicio"><?php echo $this->Html->image('home.png', array('alt' => 'Inicio', 'width' => '20', 'align' => 'absmiddle', 'border' => 0));?></a><?php echo $this->Html->image('salir.png', array('alt' => 'Cerrar Sesión', 'width' => '20', 'align' => 'absmiddle', 'border' => 0, 'title' => 'Salir', 'url' => array('controller' => 'usuarios', 'action' => 'logout')));?></div>
		</div>		
		<div id="contenedor">
			<?php 
				//Opciones del Menú
				if($this->Session->check('usuario')) {
					//Perfil Administrador o Decano
					$usu = $this->Session->read('usuario');
					if(($usu['perfil_id']==1) || ($usu['perfil_id']==2)){						
						echo $this->Element('admin_bar_menu'); 
						
					}
					else {
						//Perfil Directores
						if($usu['perfil_id']==3) {						
							echo $this->Element('director_bar_menu');		
						}
						else {
							//Perfil Usuario Reportes
							if($usu['perfil_id']==4) {						
								echo $this->Element('usuario_bar_menu');		
							}
						}
					}
				}				
			?>		
			<div id="cuerpo">
                            <?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>				
			</div>
		</div>
		<div id="pie"><?php echo $sitioPie; ?></div>	
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
