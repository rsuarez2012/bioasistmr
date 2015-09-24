<?php
App::import('Model','Horario');
App::import('Model','BloquesHora');
class AsistenciasController extends AppController {
	public $helper = array('Html', 'Form');
	public $component = array('Session', 'Auth');
	public $name = 'Asistencias';	
	
	public function index() {
            App::import('Model', 'Horario');
		App::import('Model', 'Personal');
		App::import('Model', 'Materia');
                App::import('Model', 'Seccion');
		
		$this->set('horarios',$this->Asistencia->Horario->find('list', array('order' => 'Horario.personal_id ASC')));
		
		$horario = new Horario();
		$this->set('lista_horarios', $horario->find('all', array('recursive' => -1)));
		
		$personal = new Personal();
		$this->set('docentes', $personal->find('all', array('recursive' => -1)));
		
		$materia = new Materia();
		$this->set('materias', $materia->find('all', array('recursive' => -1)));

                $seccion = new Seccion();
		$this->set('secciones', $seccion->find('all', array('recursive' => -1)));
		//$this->set('horarios',$this->Asistencia->Horario->find('list', array('order' => 'Horario.personal_id ASC')));
	}
	
	public function ver($id=null) {
		$this->Asistencia->id = $id;
		$this->set('Asistencia', $this->Asistencia->read());
	}
	
	public function verAsistencias() {
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
			//Caso de los directores
			if($this->Session->read('usuario.perfil_id') == 3){
				$row['total'] = $this->Asistencia->find('count', array('conditions' => array('Materia.direccion_id' => $this->Session->read('usuario.direccion_id'), 'Asistencia.fecha' => $entrada)))."";
				$row['rows'] = $this->Asistencia->find('all', array('conditions' => array('Materia.direccion_id' => $this->Session->read('usuario.direccion_id'),'Asistencia.fecha' => $entrada)));
			}
			//Caso Decano
			else {
				$row['total'] = $this->Asistencia->find('count', array('conditions' => array('Asistencia.fecha' => $entrada)))."";
				$row['rows'] = $this->Asistencia->find('all', array('conditions' => array('Asistencia.fecha' => $entrada)));
			}			
		}
		else {
			//Caso de los directores
			if($this->Session->read('usuario.perfil_id') == 3){
				$row['total'] = $this->Asistencia->query('SELECT count(asistencias.id) as total
						FROM asistencias, horarios, materias
						WHERE horarios.materia_id = materias.id
						AND asistencias.horario_id = horarios.id
						AND materias.direccion_id = '.$this->Session->read('usuario.direccion_id'));
				$row['rows'] = $this->Asistencia->query('SELECT asistencias.fecha, asistencias.horario_id, asistencias.estatus, asistencias.observaciones
						FROM asistencias, horarios, materias
						WHERE horarios.materia_id = materias.id
						AND asistencias.horario_id = horarios.id
						AND materias.direccion_id = '.$this->Session->read('usuario.direccion_id'));
				//$row['total'] = $this->Asistencia->find('count')."";
				//$row['rows'] = $this->Asistencia->find('all', array('order' => 'Horario.materia_id ASC', 'offset' => $offset, 'limit' => $rows,'recursive' => 1));
			}
			else {
				$row['total'] = $this->Asistencia->query('SELECT count(asistencias.id) as total
						FROM asistencias, horarios, materias
						WHERE horarios.materia_id = materias.id
						AND asistencias.horario_id = horarios.id');						
				$row['rows'] = $this->Asistencia->query('SELECT asistencias.fecha, asistencias.horario_id, asistencias.estatus, asistencias.observaciones
						FROM asistencias, horarios, materias
						WHERE horarios.materia_id = materias.id
						AND asistencias.horario_id = horarios.id');
			}			
		}
		$this->set(compact('row["rows"]'));
		$this->set('result',$row);
		$this->render('verAsistencias','ajax');
	}
	
	public function agregar() {
		//Verifica si es por metodo post
		if ($this->request->is('post')) {
			//Verifica que la data no este vacia
			if(!empty($this->request->data)) {
				//Asigna el resultado de la consulta
				$row = $this->Asistencia->save($this->request->data);
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
			$this->Asistencia->id = $id;
			$row =$this->Asistencia->save($this->request->data);
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
			$row =$this->Asistencia->delete($id);
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

        function registrarInasistencias(){
            $this->Asistencia->query('INSERT INTO asistencias (horario_id) (SELECT DISTINCT (horarios.id)
                                        FROM horarios, personal, bloques_horas, asistencias
                                        WHERE horarios.personal_id = personal.id
                                        AND horarios.fin = bloques_horas.id
                                        AND horarios.id NOT
                                        IN (SELECT asistencias.horario_id
                                        FROM asistencias
                                        WHERE DATE( NOW( ) ) = DATE( asistencias.fecha ))
                                        AND DAYOFWEEK( CURDATE( ) -1 ) = horarios.dia_id
                                        AND TIME( NOW( ) ) > bloques_horas.bloque)');                     
            $reg['success'] = true;
            $reg['msg'] = 'Las inasistencias se registraron con éxito!';
            
            
            $this->set('result',$reg);
            $this->render('registrarInasistencias','ajax');

        }

        function registrarInasistenciasAyer(){
            $this->Asistencia->query('INSERT INTO asistencias (horario_id) (SELECT DISTINCT (horarios.id)
                                        FROM horarios, personal, bloques_horas, asistencias
                                        WHERE horarios.personal_id = personal.id
                                        AND horarios.fin = bloques_horas.id
                                        AND horarios.id NOT
                                        IN (SELECT asistencias.horario_id
                                        FROM asistencias
                                        WHERE DATE( NOW( ) ) = DATE( asistencias.fecha ))
                                        AND DAYOFWEEK( CURDATE( ) -2 ) = horarios.dia_id
                                        AND TIME( NOW( ) ) > bloques_horas.bloque)');
            $reg['success'] = true;
            $reg['msg'] = 'Las inasistencias se registraron con éxito!';


            $this->set('result',$reg);
            $this->render('registrarInasistencias','ajax');

        }
        
      	public function pdf($fecha_inicio = null, $fecha_fin = null) {
                Configure::write('debug',2);
		$this->layout = 'pdf';
		$horario = new Horario();
		//Caso de los directores
		if($this->Session->read('usuario.perfil_id') == 3){
			$sql= $horario->query('SELECT personal.cedula AS cedula, personal.nombres AS nombres, personal.apellidos AS apellidos, materias.nombre AS materia_nombre, DATE( asistencias.fecha ) AS fecha, TIME( asistencias.fecha ) AS hora_entrada, horarios.inicio AS inicio, horarios.fin AS fin
                                        FROM personal, asistencias, horarios, materias
                                        WHERE asistencias.horario_id = horarios.id
                                        AND horarios.personal_id = personal.id
                                        AND horarios.materia_id = materias.id
										AND materias.direccion_id ='.$this->Session->read('usuario.direccion_id').'
                                        AND asistencias.estatus =1');
		}
		else {
			$sql= $horario->query('SELECT personal.cedula AS cedula, personal.nombres AS nombres, personal.apellidos AS apellidos, materias.nombre AS materia_nombre, DATE( asistencias.fecha ) AS fecha, TIME( asistencias.fecha ) AS hora_entrada, horarios.inicio AS inicio, horarios.fin AS fin
					FROM personal, asistencias, horarios, materias
					WHERE asistencias.horario_id = horarios.id
					AND horarios.personal_id = personal.id
					AND horarios.materia_id = materias.id					
					AND asistencias.estatus =1');
			
		}
                //debug($sql);
		$bloque = new BloquesHora();
		$this->set('asistencias', $sql);
                
                $this->render();
	}

      
	

}
?>