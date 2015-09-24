<?php
class Asistencia extends AppModel {
	
	public $name = 'Asistencia';

	public $belongsTo = array('Horario' => array('className' => 'Horario', 'foreignKey' => 'horario_id'));
	
	public $validate = array (			
			'horario_id' => array('rule' => 'notEmpty')					
	);
	
}
?>