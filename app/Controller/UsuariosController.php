<?php
class UsuariosController extends AppController {
	public $helpers = array('Html', 'Form', 'Ajax');
	public $components = array('Session');
	public $name = 'Usuarios';
	
	public function index() {	
		$this->set('perfiles',$this->Usuario->Perfil->find('list', array('order' => 'Perfil.nombre ASC')));
	}
	
	public function inicio() {
		$this->layout = 'inicio';
	}
	
	
	public function verUsuarios() {
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$offset = ($page-1)*$rows;
		$this->autoRender= false;
		if(isset($_REQUEST['entrada'])) {
			$entrada = $_REQUEST['entrada'];			
		}		
		//Organizacion de las direcciones
		if($this->Session->read('usuario.perfil_id') == 3){
				$row['total'] = $this->Usuario->find('count', array('conditions' => array('direccion_id' => $this->Session->read('usuario.direccion_id'))));
				$row['rows'] = $this->Usuario->find('all', array('conditions' => array('direccion_id' => $this->Session->read('usuario.direccion_id')),'order' => $sort.' '.$order, 'limit' => $offset.','.$rows, 'recursive' => -1));
			}
			else{
				$row['total'] = $this->Usuario->find('count')."";
				$row['rows'] = $this->Usuario->find('all', array('order' => $sort.' '.$order, 'limit' => $offset.','.$rows, 'recursive' => -1));			
			}		
		$this->set(compact('row["rows"]'));
		$this->set('result',$row);
		$this->render('verUsuarios','ajax');		
	}
	
	function agregar() {
	//Verifica si es por metodo post
		if ($this->request->is('post')) {
			//Asigna el resultado de la consulta
			$row =$this->Usuario->save($this->request->data);
			if($row) {
				$reg['success'] = true;
				$reg['msg'] = 'Registro Guardado con éxito!';
			}
			else {
				$reg['msg'] = 'Operacion no permitida';
			}				
			$this->set('result',$reg);
			$this->render('agregar','ajax');
		}
	}
	
	function beforeFilter() {
		$this->__validateLoginStatus();
		
	}
	 
	public function login() {
				
		$this->layout = 'sesion';
		
		//Registro de asistencia
		if ($this->request->is('post')) {
			$cedula = $this->request->data['Personal']['cedula'];
			if(!empty($cedula)) {
				$this->request->data['usuario'] = "argemen";
				$this->request->data['clave'] = "argenis";
				$usuario = $this->Usuario->validateLogin($this->request->data);
				if($usuario) {
					App::import('Model', 'Personal');
					$personal = new Personal();
					$this->set('cedula', $personal_>find('all', array('conditions' => array('cedula' => $cedula))));
					
				//$this->render('login','ajax');
				}
			}
			else {
				if(!empty($this->request->data)) {
					if(($usuario = $this->Usuario->validateLogin($this->request->data)) == true) {
						$this->Session->write('usuario', $usuario);
						//$this->Session->setFlash('You\'ve successfully logged in.');
						$this->redirect(array('action' => 'inicio'));
						exit();
					}
					else {
						$this->Session->setFlash('Usuario Invalido!!', 'default', array('class' => 'error'));
						$this->redirect(array('action' => 'login'));
					}
				}
			}
		}//Fin verificación método post				
	}
	 
	function logout()
	{
		$this->Session->delete('usuario');
		$this->Session->destroy();
		//$this->Session->setFlash('Sesión Cerrada con éxito!!');
		$this->redirect(array('action' => 'login'));
	}
	 
	function __validateLoginStatus()
	{
		if($this->action != 'login' && $this->action != 'logout')
		{
			if($this->Session->check('usuario') == false)
			{
				$this->redirect(array('action' => 'login'));
				$this->Session->setFlash('The URL you\'ve followed requires you login.');
			}
		}
	}
	
	
	
	function editar($id = null) {
	if ($this->request->is('post')) {
			//Asigna el resultado de la consulta
			$this->Usuario->id = $id;
			$row =$this->Usuario->save($this->request->data);
			if($row) {
				$reg['success'] = true;
				$reg['msg'] = 'Registro Actualizado con éxito!';
			}
			else {
				$reg['msg'] = 'Operacion no permitida';
			}
			$this->set('result',$reg);
			$this->render('editar','ajax');
		}
	}
	
	function activar($id = null) {
		$this->Usuario->id = $id;
		if($this->request->is('get')) {
			if($this->Usuario->saveField('estatus','1')) {
				$this->Session->setFlash('La cuenta de usuario ha sido activada con exito!');
				$this->redirect(array('action' => 'index'));
			}
		}
	}
	
	function desactivar($id = null) {
		$this->Usuario->id = $id;
		if($this->request->is('get')) {
			if($this->Usuario->saveField('estatus','0')) {
				$this->Session->setFlash('La cuenta de usuario ha sido desactivada con exito!');
				$this->redirect(array('action' => 'index'));
			}
		}
	}
	
	function eliminar($id) {
	//Verifica si es por metodo post
		if ($this->request->is('post')) {
			//Asigna el resultado de la consulta
			$row =$this->Usuario->delete($id);
			if($row) {
				$reg['success'] = true;
				$reg['msg'] = 'Registro Eliminado con éxito!';
			}
			else {
				$reg['msg'] = 'Operacion no permitida';
			}
			$this->set('result',$reg);
			$this->render('eliminar','ajax');
		}	
	}
      function pdf($id=null){
      Configure::write('debug',2);
      $this->layout = 'pdf'; //this will use the pdf.ctp layout
      // Operaciones que deseamos realizar y variables que pasaremos a la vista.
      //$this->Post->id = $id;
      //$this->set('post', $this->Post->read($id));
      //$this->set('posts', $this->Aulas->find('all'));
      //$this->set('aula', $this->Aulas->find('all'));
	  $this->set('usuarios', $this->Usuario->find('all'));
      //$this->Aulas->id = $id;
      //$this->set('post', $this->Post->read());
      $this->render();
      
      }
}
?>