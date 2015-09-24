<?php
class TipoPersonal extends AppModel {
	
	public $name = 'TipoPersonal';
	
	var $displayField = "nombre";

	public $hasMany = array('Personal' => array('className' => 'Personal', 'foreignKey' => 'tipo_personal_id'));
	
	public $validate = array (						
			'nombre' => array('rule' => 'notEmpty')			
	);
	
}
?>