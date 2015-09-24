<?php
class TipoPersonalController extends AppController {
	public $helper = array('Html', 'Form');
	public $component = array('Session', 'Auth');
	public $name = 'TipoPersonal';	
	
	public function index() {				
		//$this->set('TipoPersonal',$this->TipoPersonal->find('all', array('order' => 'nombre ASC')));		
	}
	
	public function ver($id=null) {
		$this->TipoPersonal->id = $id;
		$this->set('TipoPersonal', $this->TipoPersonal->read());
	}
	
	public function verTipoPersonal() {
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$offset = ($page-1)*$rows;
		$this->autoRender= false;
		$this->autoRender= false;
		if(isset($_REQUEST['entrada'])) {
			$entrada = $_REQUEST['entrada'];
		}
		if(isset($entrada)) {
			$row['total'] = $this->TipoPersonal->find('count', array('conditions' => array('nombre like' => "$entrada%")));
			$row['rows'] = $this->TipoPersonal->find('all', array('conditions' => array('nombre like' => "$entrada%")));
		}
		else {
			$row['total'] = $this->TipoPersonal->find('count')."";
			$row['rows'] = $this->TipoPersonal->find('all', array('order' => $sort.' '.$order, 'recursive' => -1));
		}
		$this->set(compact('row["rows"]'));
		$this->set('result',$row);
		$this->render('verTipoPersonal','ajax');
	}
	
	public function agregar() {
		//Verifica si es por metodo post
		if ($this->request->is('post')) {
			//Verifica que la data no este vacia
			if(!empty($this->request->data)) {
				//Asigna el resultado de la consulta
				$row = $this->TipoPersonal->save($this->request->data);
				if($row) {
					$reg['success'] = true;
					$reg['msg'] = 'Registro Guardado con éxito!';
				}
				else {
					$reg['success'] = false;
					$reg['msg'] = 'Operacion no permitida';
				}				
				
			}
			else {
				$reg['success'] = false;
				$reg['msg'] = 'Data vacia';
			}
			$this->set('result',$reg);
			$this->render('agregar','ajax');
		}
	}
	
	function editar($id = null) {
		if ($this->request->is('post')) {
			//Asigna el resultado de la consulta
			$this->TipoPersonal->id = $id;
			$row =$this->TipoPersonal->save($this->request->data);
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
	
	public function eliminar($id) {
		//Verifica si es por metodo post
		if ($this->request->is('post')) {
			//Asigna el resultado de la consulta
			$row =$this->TipoPersonal->delete($id);
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
	

}
?>