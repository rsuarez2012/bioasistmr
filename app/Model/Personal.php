<?php
class Personal extends AppModel {
	
	public $name = 'Personal';
	
	public $virtualFields = array("full_name"=>"CONCAT(nombres, ' ' ,apellidos)");

	public $displayField = 'full_name';

	public $belongsTo = array('TipoPersonal' => array('className' => 'TipoPersonal', 'foreignKey' => 'tipo_personal_id'));
	
	//public $hasMany = array('Horario' => array('className' => 'Horario', 'foreignKey' => 'personal_id'));
	
	public $validate = array (
			'cedula' => array('rule' => 'notEmpty'),
			'nombres' => array('rule' => 'notEmpty'),
			'apellidos' => array('rule' => 'notEmpty'),
			'sexo' => array('rule' => 'notEmpty'),
			'direccion' => array('rule' => 'notEmpty'),
			'telefono' => array('rule' => 'notEmpty'),
			'email' => array('rule' => 'notEmpty'),
			'Personal' => array('rule' => 'notEmpty', 'rule' => 'alphanumeric'),
			'clave' => array('rule' => 'notEmpty')
	);
		
}
?>