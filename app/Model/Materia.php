<?php
class Materia extends AppModel {
	
	public $name = 'Materia';

	public $belongsTo = array('Nivel' => array('className' => 'Nivel', 'foreignKey' => 'nivel_id'),
							  'Direccion' => array('className' => 'Direccion', 'foreignKey' => 'direccion_id')
								);	
	
	//public $hasMany = array('Horario' => array('className' => 'Horario', 'foreignKey' => 'materia_id'));
	
	public $validate = array (
			'nivel_id' => array('rule' => 'notEmpty'),			
			'nombre' => array('rule' => 'notEmpty')
	);
	
}
?>