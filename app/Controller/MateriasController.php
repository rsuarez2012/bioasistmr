<?php
class MateriasController extends AppController {
	public $helpers = array('Html', 'Form', 'Ajax');
	public $components = array('Session');
	public $name = 'Materias';
	
	public function index() {
		App::import('Model','Nivel');
		$nivel = new Nivel();
		$this->set('niveles',$this->Materia->Nivel->find('list', array('order' => 'Nivel.nombre ASC')));
		$this->set('direcciones',$this->Materia->Direccion->find('list', array('order' => 'Direccion.nombre ASC')));
		$this->set('semestres',$nivel->find('all', array('order' => 'Nivel.nombre ASC', 'recursive' => 0, 'fields' => array('id', 'nombre', 'etiqueta'))));
	}
	
	public function verMaterias() {
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$offset = ($page-1)*$rows;
		$this->autoRender= false;
		if(isset($_REQUEST['entrada'])) {
			$entrada = $_REQUEST['entrada'];			
		}		
		if(isset($entrada)) {
			if($this->Session->read('usuario.perfil_id') == 3){
				$row['total'] = $this->Materia->find('count', array('conditions' => array('direccion_id' => $this->Session->read('usuario.direccion_id'), 'Materia.nombre like' => "%$entrada%")));
				$row['rows'] = $this->Materia->find('all', array('conditions' => array('direccion_id' => $this->Session->read('usuario.direccion_id'), 'Materia.nombre like' => "%$entrada%")));
			}
			else {
				$row['total'] = $this->Materia->find('count', array('conditions' => array('Materia.nombre like' => "%$entrada%")));
				$row['rows'] = $this->Materia->find('all', array('conditions' => array('Materia.nombre like' => "%$entrada%")));			
			}			
		}
		else {
			if($this->Session->read('usuario.perfil_id') == 3){
				$row['total'] = $this->Materia->find('count', array('conditions' => array('direccion_id' => $this->Session->read('usuario.direccion_id'))));
				$row['rows'] = $this->Materia->find('all', array('conditions' => array('direccion_id' => $this->Session->read('usuario.direccion_id')),'order' => $sort.' '.$order, 'limit' => $offset.','.$rows, 'recursive' => -1));
			}
			else{
				$row['total'] = $this->Materia->find('count')."";
				$row['rows'] = $this->Materia->find('all', array('order' => $sort.' '.$order, 'limit' => $offset.','.$rows, 'recursive' => -1));			
			}
		}		
		$this->set(compact('row["rows"]'));
		$this->set('result',$row);
		$this->render('verMaterias','ajax');		
	}
	
	function agregar() {
	//Verifica si es por metodo post
		if ($this->request->is('post')) {
                    //verifica si ya existe el registro
                     $existente = $this->Materia->find('count', array('conditions' => array('codigo' => $this->request->data['codigo'])));
                    if($existente>0){
                             $reg['msg'] = 'Disculpe, el codigo ya se encuentra registrado!!';
                    }
                    else {
                        //Asigna el resultado de la consulta
                        $row =$this->Materia->save($this->request->data);
                        if($row) {
                                $reg['success'] = true;
                                $reg['msg'] = 'Registro Guardado con éxito!';
                        }
                        else {
                                $reg['msg'] = 'Operacion no permitida';
                        }
                    }

                    $this->set('result',$reg);
                    $this->render('agregar','ajax');
		}
	}

	function editar($id = null) {
	if ($this->request->is('post')) {
			//Asigna el resultado de la consulta
			$this->Materia->id = $id;
			$row =$this->Materia->save($this->request->data);
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

	
	function eliminar($id) {
	//Verifica si es por metodo post
		if ($this->request->is('post')) {
			//Asigna el resultado de la consulta
			$row =$this->Materia->delete($id);
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