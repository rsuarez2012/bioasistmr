<?php
class Aula extends AppModel {
	
	public $name = 'Aula';

	var $displayField = "nombre";	
	
	//public $hasMany = array('Horario' => array('className' => 'Horario', 'foreignKey' => 'aula_id'));
	
	public $validate = array (			
			'nombre' => array('rule' => 'notEmpty'),					
			'ubicacion' => array('rule' => 'notEmpty')
	);
	
}
?>