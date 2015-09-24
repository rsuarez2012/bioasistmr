<?php
class Perfil extends AppModel {
	
	public $name = 'Perfil';
	
	var $displayField = "nombre";

	public $hasMany = array('Usuario' => array('className' => 'Usuario', 'foreignKey' => 'perfil_id'));
	
	var $validate = array( 
			'nombre' => array('rule' => 'notEmpty', 'message' => 'Debe ingresar el nombre del perfil!'),
			'descripcion' => array('rule' => 'notEmpty', 'message' => 'Debe ingresar una breve descripción del registro!')
			);
}
?>