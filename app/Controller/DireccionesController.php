<?php
class DireccionesController extends AppController {
	public $helper = array('Html', 'Form');
	public $component = array('Session', 'Auth');
	public $name = 'Direcciones';	
	
	public function index() {				
			
	}

	public function verDirecciones() {
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'Direccion.id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$offset = ($page-1)*$rows;
		$this->autoRender= false;
		
		if(isset($_REQUEST['entrada'])) {
			$entrada = $_REQUEST['entrada'];
		}
		if(isset($entrada)) {
			$row['total'] = $this->Direccion->find('count', array('conditions' => array('Direccion.nombre like' => "%$entrada%")));
			$row['rows'] = $this->Direccion->find('all', array('conditions' => array('Direccion.nombre like' => "%$entrada%")));
		}
		else {
				$row['total'] = $this->Direccion->find('count')."";
				$row['rows'] = $this->Direccion->find('all', array('order' => $sort.' '.$order, 'limit' => $offset.','.$rows, 'recursive' => -1));			
			      
		}
		$this->set(compact('row["rows"]'));
		$this->set('result',$row);
		$this->render('verDirecciones','ajax');
	}
	
	public function agregar() {
		//Verifica si es por metodo post
		if ($this->request->is('post')) {
			//Verifica que la data no este vacia
			if(!empty($this->request->data)) {
                                //verifica si ya existe el registro
                                $existente = $this->Direccion->find('count', array('conditions' => array('nombre' => $this->request->data['nombre'], 'ubicacion' => $this->request->data['ubicacion'])));

                                if($existente>0){
                                     $reg['msg'] = 'Disculpe, el Direccion ya se encuentra registrada!!';
                                }
                                else {
                                    //Asigna el resultado de la consulta
                                    $row = $this->Direccion->save($this->request->data);
                                    if($row) {
                                            $reg['success'] = true;
                                            $reg['msg'] = 'Registro Guardado con éxito!';
                                    }
                                    else {
                                            $reg['success'] = false;
                                            $reg['msg'] = 'Operacion no permitida';
                                    }
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
			$this->Direccion->id = $id;
			$row =$this->Direccion->save($this->request->data);
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
			$row =$this->Direccion->delete($id);
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
      //$this->set('posts', $this->Direcciones->find('all'));
      //$this->set('Direccion', $this->Direcciones->find('all'));
	  $this->set('Direcciones', $this->Direccion->find('all'));
      //$this->Direcciones->id = $id;
      //$this->set('post', $this->Post->read());
      $this->render();
      
      }
	

}
?>