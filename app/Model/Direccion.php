<?php
class Direccion extends AppModel {
	
	public $name = 'Direccion';

	var $displayField = "nombre";	
	
	public $hasMany = array('Materia' => array('className' => 'Materia', 'foreignKey' => 'direccion_id'),
							'Usuario' => array('className' => 'Usuario', 'foreignKey' => 'usuario_id')
							);
	
	public $validate = array (			
			'nombre' => array('rule' => 'notEmpty'),					
			'ubicacion' => array('rule' => 'notEmpty')
	);
	
}
?>