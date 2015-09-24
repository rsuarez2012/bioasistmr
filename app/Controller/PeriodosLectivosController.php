<?php
class PeriodosLectivosController extends AppController {
	public $helper = array('Html', 'Form');
	public $component = array('Session', 'Auth');
	public $name = 'PeriodosLectivos';	
	
	public function index() {				
				
	}

	public function verPeriodosLectivos() {
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
			$row['total'] = $this->PeriodosLectivo->find('count', array('conditions' => array('nombre like' => "%$entrada%")));
			$row['rows'] = $this->PeriodosLectivo->find('all', array('conditions' => array('nombre like' => "%$entrada%")));
		}
		else {
			$row['total'] = $this->PeriodosLectivo->find('count')."";
			$row['rows'] = $this->PeriodosLectivo->find('all', array('order' => $sort.' '.$order, 'limit' => $offset.','.$rows, 'recursive' => -1, 'fields' => 'id, nombre, estatus'));
		}
		$this->set(compact('row["rows"]'));
		$this->set('result',$row);
		$this->render('verPeriodosLectivos','ajax');
	}
	
	public function agregar() {
		//Verifica si es por metodo post
		if ($this->request->is('post')) {
                        //verifica si ya existe el registro
                        $existente = $this->PeriodosLectivo->find('count', array('conditions' => array('nombre' => $this->request->data['nombre'])));
                        if($existente>0){
                                 $reg['msg'] = 'Disculpe, el período ya se encuentra registrado!!';
                        }
                        else {
                            //Verifica que la data no este vacia
                            if(!empty($this->request->data)) {
                                    //Asigna el resultado de la consulta
                                    $row = $this->PeriodosLectivo->save($this->request->data);
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
                        }
			$this->set('result',$reg);
			$this->render('agregar','ajax');
		}
	}
	
	function editar($id = null) {
		if ($this->request->is('post')) {
			//Asigna el resultado de la consulta
			$this->PeriodosLectivo->id = $id;
			$row =$this->PeriodosLectivo->save($this->request->data);
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
			$row =$this->PeriodosLectivo->delete($id);
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