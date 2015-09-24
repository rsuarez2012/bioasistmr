<?php
class Dia extends AppModel {
	
	public $name = 'Dia';

	var $displayField = "nombre";

	//public $hasMany = array('Horario' => array('className' => 'Horario', 'foreignKey' => 'dia_id'));
	
	public $validate = array (			
			'nombre' => array('rule' => 'notEmpty')
	);
	
}
?>