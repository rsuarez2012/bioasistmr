<?php
class Horario extends AppModel {
	public $name = 'Horario';

	public $belongsTo = array('Personal' => array('className' => 'Personal', 'foreignKey' => 'personal_id'),
				'Dia' => array('className' => 'Dia', 'foreignKey' => 'dia_id'),
				'Materia' => array('className' => 'Materia', 'foreignKey' => 'materia_id'),
				'Seccion' => array('className' => 'Seccion', 'foreignKey' => 'seccion_id'),
				'Aula' => array('className' => 'Aula', 'foreignKey' => 'aula_id')
			);			
	
	//public $hasMany = array('Asistencia' => array('className' => 'Asistencia', 'foreignKey' => 'horario_id'));
	
	public $validate = array (
			'personal_id' => array('rule' => 'notEmpty'),
			'dia_id' => array('rule' => 'notEmpty'),
			'materia_id' => array('rule' => 'notEmpty'),
			'seccion_id' => array('rule' => 'notEmpty'),
			'aula_id' => array('rule' => 'notEmpty'),
			'inicio' => array('rule' => 'notEmpty'),
			'fin' => array('rule' => 'notEmpty')			
	);
		
}
?>