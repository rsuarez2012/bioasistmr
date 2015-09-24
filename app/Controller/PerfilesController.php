<?php
class PerfilesController extends AppController {
	public $helper = array('Html', 'Form');
	public $component = array('Session', 'Auth');
	public $name = 'Perfiles';	
	
	public function index() {				
				
	}
	

	function verPdf($id = null)
	{
		
		if (!$id)
		{
			$this->Session->setFlash('Sorry, there was no property ID submitted.');
			$this->redirect(array('action'=>'index'), null, true);
		}
		
		//Configure::write('debug',0); // Otherwise we cannot use this method while developing
		
		
		$perfil = $this->Perfil->find('all', array('conditions' => array('Perfil.id' => $id)));
	
		if (empty($perfil))
		{
			$this->Session->setFlash('Sorry, there is no property with the submitted ID.');
			$this->redirect(array('action'=>'index'), null, true);
		}
	
		$this->layout = 'pdf'; //this will use the pdf.ctp layout
		$this->render();
	}
	
	public function verPerfiles() {
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$offset = ($page-1)*$rows;
		$this->autoRender= false;
		$this->autoRender= false;
		if(isset($_REQUEST['entrada'])) {
			$entrada = $_REQUEST['entrada'];
		}
		if(isset($entrada)) {
			$row['total'] = $this->Perfil->find('count', array('conditions' => array('nombre like' => "%$entrada%")));
			$row['rows'] = $this->Perfil->find('all', array('conditions' => array('nombre like' => "%$entrada%")));
		}
		else {
			$row['total'] = $this->Perfil->find('count')."";
			$row['rows'] = $this->Perfil->find('all', array('order' => $sort.' '.$order, 'limit' => $offset.','.$rows, 'recursive' => -1));
		}
		$this->set(compact('row["rows"]'));
		$this->set('result',$row);
		$this->render('verPerfiles','ajax');
	}
	
	public function agregar() {
		//Verifica si es por metodo post
		if ($this->request->is('post')) {
			//Verifica que la data no este vacia
			if(!empty($this->request->data)) {
				//Asigna el resultado de la consulta
				$row = $this->Perfil->save($this->request->data);
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
			$this->Perfil->id = $id;
			$row =$this->Perfil->save($this->request->data);
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
			$row =$this->Perfil->delete($id);
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