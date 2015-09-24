<?php
class Seccion extends AppModel {
	
	public $name = 'Seccion';

	var $displayField = "nombre";

	//public $hasMany = array('Horario' => array('className' => 'Horario', 'foreignKey' => 'seccion_id'));
	
	public $validate = array (			
			'nombre' => array('rule' => 'notEmpty')
	);
	
}
?>