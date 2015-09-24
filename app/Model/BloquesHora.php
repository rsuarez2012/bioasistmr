<?php
class BloquesHora extends AppModel {
	
	public $name = 'BloquesHora';	

	//public $hasMany = array('Horario' => array('className' => 'Horario', 'foreignKey' => 'inicio_id'));
	
	public $validate = array (			
			'bloque' => array('rule' => 'notEmpty')
	);
	
}
?>