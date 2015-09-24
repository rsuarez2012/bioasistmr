<?php
class Nivel extends AppModel {
	
	public $name = 'Nivel';

	var $displayField = "etiqueta";

	public $hasMany = array('Materia' => array('className' => 'Materia', 'foreignKey' => 'nivel_id'));
	
	public $validate = array (			
			'nombre' => array('rule' => 'notEmpty'),
			'etiqueta' => array('rule' => 'notEmpty')
	);
	
}
?>