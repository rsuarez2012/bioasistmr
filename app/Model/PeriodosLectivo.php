<?php
class PeriodosLectivo extends AppModel {
	
	public $name = 'PeriodosLectivo';

	var $displayField = "nombre";

	//public $hasMany = array('Materia' => array('className' => 'Materia', 'foreignKey' => 'nivel_id'));
	
	public $validate = array (			
			'nombre' => array('rule' => 'notEmpty'),
			'estatus' => array('rule' => 'notEmpty')
	);
	
}
?>