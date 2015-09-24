<?php
App::import('Model','Horario');
App::import('Model','Personal');
App::import('Model','Seccion');
App::import('Model','Materia');
App::import('Model','BloquesHora');
App::import('Model','PeriodosLectivo');
App::import('Model','Aula');
App::import('Model','Dia');
class HorariosController extends AppController {
	public $helpers = array('Html', 'Form', 'Ajax');
	public $components = array('Session');		
	public $name = 'Horarios';	
	
	public function index() {	
		$personal = new Personal();
		$materia = new Materia();
		$bloque_hora = new BloquesHora();		
		
		$this->set('profesores',$personal->find('all', array('order' => 'Personal.apellidos ASC', 'recursive' => 0, 'fields' => array('id', 'cedula', 'nombres', 'apellidos'))));
		$this->set('materias',$materia->find('all', array('order' => 'Materia.nombre ASC', 'recursive' => 0, 'fields' => array('id', 'nombre'))));
		$this->set('bloques_horas',$bloque_hora->find('all', array('order' => 'BloquesHora.bloque ASC', 'recursive' => 0, 'fields' => array('id', 'bloque'))));			
	
	}
	
	public function nuevo() {
		$periodo_lectivo = new PeriodosLectivo();
		$this->set('periodo_lectivo', $periodo_lectivo->find('all', array('conditions' => array('PeriodosLectivo.estatus' => '1'))));
		
	}
		
	public function listaMaterias() {
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';			
			$materia = new Materia();
			$row = $materia->find('all', array('conditions' => array('Materia.nombre like' => "%$q%")));
			$this->set('result',$row);
			$this->render('listaMaterias','ajax');		
	}
	
	public function listaSecciones() {
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$secciones = new Seccion();
		$row = $secciones->find('all', array('conditions' => array('Seccion.nombre like' => "%$q%")));
		$this->set('result',$row);
		$this->render('listaSecciones','ajax');
	}
	
	public function listaAulas() {
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$aula = new Aula();
		$row = $aula->find('all', array('conditions' => array('Aula.nombre like' => "%$q%")));
		$this->set('result',$row);
		$this->render('listaAulas','ajax');
	}
	
	public function listaDias() {
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$dias = new Dia();
		$row = $dias->find('all', array('conditions' => array('Dia.nombre like' => "%$q%"), 'order' => 'Dia.id'));
		$this->set('result',$row);
		$this->render('listaDias','ajax');
	}
	
	public function listaProfesores() {
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';	
		$personal = new Personal();
		$row = $personal->find('all', array('conditions' => array('Personal.nombres like' => "%$q%"), 'fields'  => array('Personal.id, Personal.cedula, Personal.nombres, Personal.apellidos, Personal.telefono')));
		$this->set('result',$row);
		$this->render('listaProfesores','ajax');		
	}
	
	public function listaBloquesHora() {
		$q = isset($_POST['q']) ? strval($_POST['q']) : '';
		$bloques = new BloquesHora();
		$row = $bloques->find('all', array('conditions' => array('BloquesHora.bloque like' => "%$q%")));
		$this->set('result',$row);
		$this->render('listaBloquesHora','ajax');
	}
	
	public function verHorarios() {
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 21;		
		$offset = ($page-1)*$rows;
		$this->autoRender= false;
		if(isset($_REQUEST['entrada'])) {
			$entrada = $_REQUEST['entrada'];			
		}		
		//Busquedas
		if(isset($entrada)) {
			//Caso de los directores
			if($this->Session->read('usuario.perfil_id') == 3){
				$row['total'] = $this->Horario->find('count', array('conditions' => array('Materia.direccion_id' => $this->Session->read('usuario.direccion_id'), 'Horario.materia_id' => $entrada)))."";	
				$row['rows'] = $this->Horario->find('all', array('conditions' => array('Materia.direccion_id' => $this->Session->read('usuario.direccion_id'),'Horario.materia_id' => $entrada)));
			}
			//Caso Decano
			else {
				$row['total'] = $this->Horario->find('count', array('conditions' => array('Horario.materia_id' => $entrada)))."";
				$row['rows'] = $this->Horario->find('all', array('conditions' => array('Horario.materia_id' => $entrada)));
			}			
		}
		else {
			//Caso de los directores
			if($this->Session->read('usuario.perfil_id') == 3){
											
				$row['total'] = $this->Horario->find('count', array('conditions' => array('Materia.direccion_id' => $this->Session->read('usuario.direccion_id'))))."";
				$row['rows'] = $this->Horario->find('all', array('conditions' => array('Materia.direccion_id' => $this->Session->read('usuario.direccion_id')),'order' => 'Horario.materia_id ASC', 'offset' => $offset, 'limit' => $rows,'recursive' => 1));
			}
			else {
				$row['total'] = $this->Horario->find('count')."";
				$row['rows'] = $this->Horario->find('all', array('order' => 'Horario.materia_id ASC', 'offset' => $offset, 'limit' => $rows,'recursive' => 1));
			}
		}		
		$this->set(compact('row["rows"]'));
		$this->set('result',$row);
		$this->render('verHorarios','ajax');		
	}

	function agregar() {							
	//Verifica si es por metodo post
		if ($this->request->is('post')) {
                    $seccion_asignada = 0;
                    $aula_ocupada = 0;
                    foreach($this->request->data['Horario'] as $horario){
                        $existente = $this->Horario->query('SELECT COUNT( horarios.id ) AS total
                                                            FROM horarios, materias, secciones
                                                            WHERE horarios.materia_id = materias.id
                                                            AND horarios.seccion_id = secciones.id
                                                            AND horarios.materia_id = '.$horario['materia_id'].'
                                                            AND horarios.seccion_id ='.$horario['seccion_id']);

                        $aula_hora = $this->Horario->query('SELECT COUNT( horarios.id ) AS total
                                                            FROM horarios
                                                            WHERE horarios.aula_id = '.$horario['aula_id'].'
                                                            AND horarios.dia_id ='.$horario['dia_id'].'
                                                            AND horarios.inicio ='.$horario['inicio'].'
                                                            AND horarios.fin >='.$horario['fin']);

                       if($existente[0][0]['total'] > 0) {
                           $seccion_asignada = 1;
                       }
                       else{
                           if($aula_hora[0][0]['total'] > 0)
                           $aula_ocupada = 1;
                       }
                       

                    }
                       if($seccion_asignada > 0 )
                           $reg['msg'] = 'Disculpe, la Materia y la Seccion ya tiene horario asignado!!';

                       if($aula_ocupada > 0 ) 
                           $reg['msg'] = 'Disculpe, el aula ya se encuentra ocupada!!';
                       
                       if(($seccion_asignada < 1) && ($aula_ocupada < 1)){
			//Asigna el resultado de la consulta
			$row =$this->Horario->saveAll($this->request->data['Horario']);
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
			$this->Horario->id = $id;
			$row =$this->Horario->save($this->request->data);
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
			$row =$this->Horario->delete($id);
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
      	public function pdf($fecha_inicio = null, $fecha_fin = null) {
              Configure::write('debug',2);
		$this->layout = 'pdf';
		$horario = new Horario();
		if($this->Session->read('usuario.perfil_id') == 3){
			$sql= $horario->query('SELECT DISTINCT(horarios.id) as horario_id, materias.nombre AS materia_nombre, personal.cedula AS cedula, personal.nombres AS nombres, personal.apellidos AS apellidos, dias.nombre AS dia_nombre, secciones.nombre AS seccion_nombre, horarios.inicio AS inicio, horarios.fin AS fin, aulas.nombre AS aula_nombre
                                        FROM materias, personal, dias, secciones, horarios, aulas
                                        WHERE horarios.materia_id = materias.id
                                        AND horarios.dia_id = dias.id
                                        AND horarios.seccion_id = secciones.id
                                        AND horarios.aula_id = aulas.id
                                        AND horarios.personal_id = personal.id
										AND materias.direccion_id = '.$this->Session->read('usuario.direccion_id').'
                                        ORDER BY horarios.inicio ASC ');
		}
		else {
			$sql= $horario->query('SELECT DISTINCT(horarios.id) as horario_id, materias.nombre AS materia_nombre, personal.cedula AS cedula, personal.nombres AS nombres, personal.apellidos AS apellidos, dias.nombre AS dia_nombre, secciones.nombre AS seccion_nombre, horarios.inicio AS inicio, horarios.fin AS fin, aulas.nombre AS aula_nombre
					FROM materias, personal, dias, secciones, horarios, aulas
					WHERE horarios.materia_id = materias.id
					AND horarios.dia_id = dias.id
					AND horarios.seccion_id = secciones.id
					AND horarios.aula_id = aulas.id
					AND horarios.personal_id = personal.id					
					ORDER BY horarios.inicio ASC ');
		}
        //debug($sql);
		$this->set('horarios', $sql);
                
                $bloque = new BloquesHora();
		$this->set('bloques', $bloque->find('all'));
                
                $this->render();
	}

	
}
?>