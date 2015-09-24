<?php
class PersonalController extends AppController {
	public $helpers = array('Html', 'Form', 'Ajax');
	public $components = array('Session');
	public $name = 'Personal';
	
	public function index() {
				
	}
	
	public function verPersonal() {
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
			$row['total'] = $this->Personal->find('count', array('conditions' => array('cedula' => $entrada)))."";	
			$row['rows'] = $this->Personal->find('all', array('conditions' => array('cedula' => $entrada)));			
		}
		else {
			$row['total'] = $this->Personal->find('count')."";
			$row['rows'] = $this->Personal->find('all', array('order' => $sort.' '.$order, 'limit' => $offset.','.$rows, 'recursive' => -1));
		}		
		$this->set(compact('row["rows"]'));
		$this->set('result',$row);
		$this->render('verPersonal','ajax');		
	}
	
	function agregar() {
	//Verifica si es por metodo post
		if ($this->request->is('post')) {
                        //verifica si ya existe el registro
                        $existente = $this->Personal->find('count', array('conditions' => array('cedula' => $this->request->data['cedula'])));
                        if($existente>0){
                                 $reg['msg'] = 'Disculpe, la cédula ya se encuentra registrada!!';
                        }
                        else {
                            //Asigna el resultado de la consulta
                            $row =$this->Personal->save($this->request->data);
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
			$this->Personal->id = $id;
			$row =$this->Personal->save($this->request->data);
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
			$row =$this->Personal->delete($id);
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
	
	public function registrar() {
		$this->layout = false;
		//Verifica si es por metodo post
		if ($this->request->is('post')) {
			App::import('Model', 'Asistencia');
			//Verifica que el docente se encuentra registrado
                        $no_registrado = 0;
                        $no_registrado = $this->Personal->find('count', array('conditions' => array('cedula' => $this->request->data['cedula']), 'recursive' => -1));

                        if($no_registrado<1) {
                            $this->Session->setFlash('Disculpe, Docente no registrado. Contacte el administrador!!', 'default', array('class' => 'error'));
                            $this->redirect(array('controller' => 'usuarios', 'action' => 'login'));

                        }
                        //Si existe en l docente, se realiza la verificación de horarios
                        $asistencia_registrada = 0;
			//Consulta de horarios
                        $docente = $this->Personal->find('all', array('conditions' => array('cedula' => $this->request->data['cedula']), 'recursive' => -1));
			$row = $this->Personal->query('SELECT personal.id AS id, personal.cedula AS cedula, personal.nombres AS nombres, personal.apellidos AS apellidos, materias.id AS materia_id, materias.nombre AS materia_nombre, secciones.id AS seccion_id, secciones.nombre AS seccion_nombre, aulas.id AS aula_id, aulas.nombre AS aula_nombre, DAYOFWEEK( CURDATE( ) -1 ) AS dia_id, CURDATE( ) AS fecha_hoy, CURTIME( ) AS hora_hoy, (
											bloques_horas.bloque - CURTIME( )
											) AS diferencia, horarios.id as horario_id, NOW() as fecha
											FROM personal, horarios, bloques_horas, materias, secciones, aulas
											WHERE personal.id = horarios.personal_id
											AND materias.id = horarios.materia_id
											AND secciones.id = horarios.seccion_id
											AND aulas.id = horarios.aula_id
											AND cedula ='.$this->request->data['cedula'].'
											AND DAYOFWEEK( CURDATE( ) -1 ) = horarios.dia_id
											AND bloques_horas.id = horarios.inicio
											AND (
											bloques_horas.bloque - CURTIME( )
											)
											BETWEEN -6000
											AND 12000');

			//Verificación de registro de asistencias existente                        
                        $datos_docente = $docente[0]['Personal']['full_name'];                        
			if($row) {
				
				$asistencia_registrada = $this->Personal->query('SELECT COUNT( asistencias.id ) as asistencia
															FROM asistencias, horarios
															WHERE asistencias.horario_id = '.$row[0]['horarios']['horario_id'].'
															AND horarios.id = asistencias.horario_id
															AND DATE( asistencias.fecha ) = DATE( NOW( ) )');
			}
			else {
			
					$this->Session->setFlash('Estimado Profesor(a): '.$datos_docente.' No hay horario disponible!!', 'default', array('class' => 'error'));
					$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
			}
			//Asistencia Registrada
			
			if($asistencia_registrada[0][0]['asistencia']>0) {
				$this->Session->setFlash('Estimado Profesor(a): '.$datos_docente.' Su asistencia ya fue registrada!!', 'default', array('class' => 'warning'));
				$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
			}
			else {
                                //Asignamos el id del horarios
				$this->request->data['Asistencia']['horario_id'] = $row[0]['horarios']['horario_id'];
                                //Activamos el estatus de la asistencia
                                $this->request->data['Asistencia']['estatus'] = 1;
				$asistencia = new Asistencia();
				
				$registro = $asistencia->save($this->request->data['Asistencia']);
				
				if($registro){				
					$this->set('horarios', $row);
					$this->Session->setFlash('Estimado Profesor(a): '.$datos_docente.' Asistencia Registrada!!', 'default', array('class' => 'success'));
					$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
				}
				//No hay horarios disponibles
			}	
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
      $this->set('personal', $this->Personal->find('all'));
      //$this->Aulas->id = $id;
      //$this->set('post', $this->Post->read());
      $this->render();
      
      }
}
?>