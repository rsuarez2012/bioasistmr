<?php
class Usuario extends AppModel {
	public $name = 'Usuario';

	public $belongsTo = array('Perfil' => array('className' => 'Perfil', 'foreignKey' => 'perfil_id'));
	
	public $validate = array (
			'cedula' => array('rule' => 'notEmpty'),
			'nombres' => array('rule' => 'notEmpty'),
			'apellidos' => array('rule' => 'notEmpty'),
			'sexo' => array('rule' => 'notEmpty'),
			'direccion' => array('rule' => 'notEmpty'),
			'telefono' => array('rule' => 'notEmpty'),
			'email' => array('rule' => 'notEmpty'),
			'usuario' => array('rule' => 'notEmpty', 'rule' => 'alphanumeric'),
			'clave' => array('rule' => 'notEmpty')
	);
	
	public function validateLogin($data) {		
		$usuario = $this->find('first', array('conditions' => array('usuario' => $data['usuario'], 'clave' => $data['clave'])), array('id', 'perfil_id', 'direccion_id','usuario'));
		if(!empty($usuario)) 			
			return $usuario['Usuario'];		
		return false;
	}	
	
}
?>