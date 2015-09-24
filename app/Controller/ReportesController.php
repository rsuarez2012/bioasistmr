<?php

App::import('Model', 'Horario');
App::import('Model', 'BloquesHora');

class ReportesController extends AppController {
	public $helper = array('Html', 'Form');
	public $component = array('Session', 'Auth');
	public $name = 'Reportes';	
	
	
	public function index() {
		$this->layout = 'reportes';
	}
	
	
	public function horariosHoy() {
		
		$this->layout = 'reportes';
		$horario = new Horario();
		if($this->Session->read('usuario.perfil_id') == 3){
			$this->set('horarios', $horario->query('SELECT DISTINCT(horarios.id) as id_horario, dias.nombre, personal.nombres AS nombres, personal.apellidos AS apellidos, materias.nombre AS materia_nombre, secciones.nombre AS seccion_nombre, aulas.nombre AS aula_nombre, horarios.inicio AS inicio, horarios.fin AS fin
												FROM materias, personal, horarios, secciones, aulas, bloques_horas, dias
												WHERE materias.id = horarios.materia_id
												AND personal.id = horarios.personal_id
												AND secciones.id = horarios.seccion_id
												AND aulas.id = horarios.aula_id
												AND dias.id = horarios.dia_id
												AND materias.direccion_id = '.$this->Session->read('usuario.direccion_id').'
												AND bloques_horas.id = horarios.inicio												
												AND DAYOFWEEK( CURDATE( ) -1 ) = horarios.dia_id ORDER BY horarios.inicio ASC'));
		}
		else {
			$this->set('horarios', $horario->query('SELECT DISTINCT(horarios.id) as id_horario, dias.nombre, personal.nombres AS nombres, personal.apellidos AS apellidos, materias.nombre AS materia_nombre, secciones.nombre AS seccion_nombre, aulas.nombre AS aula_nombre, horarios.inicio AS inicio, horarios.fin AS fin
													FROM materias, personal, horarios, secciones, aulas, bloques_horas, dias
													WHERE materias.id = horarios.materia_id
													AND personal.id = horarios.personal_id
													AND secciones.id = horarios.seccion_id
													AND aulas.id = horarios.aula_id
													AND dias.id = horarios.dia_id					
													AND bloques_horas.id = horarios.inicio
													AND DAYOFWEEK( CURDATE( ) -1 ) = horarios.dia_id ORDER BY horarios.inicio ASC'));
		}
		$bloque = new BloquesHora();
		$this->set('bloques', $bloque->find('all'));
	}

	public function verAsistencias($fecha_inicio = null, $fecha_fin = null) {
		$this->layout = 'reportes';
		$horario = new Horario();
		if($this->Session->read('usuario.perfil_id') == 3){
			$this->set('asistencias', $horario->query('SELECT personal.cedula AS cedula, personal.nombres AS nombres, personal.apellidos AS apellidos, materias.nombre AS materia_nombre, secciones.nombre AS seccion_nombre, aulas.nombre AS aula_nombre, DATE( asistencias.fecha ) AS fecha, TIME( asistencias.fecha ) AS hora, horarios.inicio as inicio, horarios.fin as fin
												FROM personal, horarios, materias, secciones, aulas, asistencias
												WHERE horarios.personal_id = personal.id
												AND horarios.materia_id = materias.id
												AND horarios.seccion_id = secciones.id
												AND horarios.aula_id = aulas.id
												AND asistencias.horario_id = horarios.id
												AND materias.direccion_id = '.$this->Session->read('usuario.direccion_id').'
												AND DATE( asistencias.fecha ) 
												BETWEEN  "'.$fecha_inicio.'"
												AND  "'.$fecha_fin.'"'));
		}
		else {
			$this->set('asistencias', $horario->query('SELECT personal.cedula AS cedula, personal.nombres AS nombres, personal.apellidos AS apellidos, materias.nombre AS materia_nombre, secciones.nombre AS seccion_nombre, aulas.nombre AS aula_nombre, DATE( asistencias.fecha ) AS fecha, TIME( asistencias.fecha ) AS hora, horarios.inicio as inicio, horarios.fin as fin
														FROM personal, horarios, materias, secciones, aulas, asistencias
														WHERE horarios.personal_id = personal.id
														AND horarios.materia_id = materias.id
														AND horarios.seccion_id = secciones.id
														AND horarios.aula_id = aulas.id
														AND asistencias.horario_id = horarios.id														
														AND DATE( asistencias.fecha )
														BETWEEN  "'.$fecha_inicio.'"
														AND  "'.$fecha_fin.'"'));
			
		}
		$bloque = new BloquesHora();
		$this->set('bloques', $bloque->find('all'));
                
                $rango_fechas = $fecha_inicio."/".$fecha_fin;
                $this->set('rango', $rango_fechas);
	}
        
            public function pdf() {
                Configure::write('debug',2);
		$this->layout = 'reportes';
		$horario = new Horario();
		if($this->Session->read('usuario.perfil_id') == 3){
			$this->set('horarios', $horario->query('SELECT DISTINCT(horarios.id) as id_horario, dias.nombre AS dia_nombre, personal.nombres AS nombres, personal.apellidos AS apellidos, materias.nombre AS materia_nombre, secciones.nombre AS seccion_nombre, aulas.nombre AS aula_nombre, horarios.inicio AS inicio, horarios.fin AS fin
												FROM materias, personal, horarios, secciones, aulas, bloques_horas, dias
												WHERE materias.id = horarios.materia_id
												AND personal.id = horarios.personal_id
												AND secciones.id = horarios.seccion_id
												AND aulas.id = horarios.aula_id
												AND dias.id = horarios.dia_id
												AND materias.direccion_id = '.$this->Session->read('usuario.direccion_id').'
												AND bloques_horas.id = horarios.inicio												
												AND DAYOFWEEK( CURDATE( ) -1 ) = horarios.dia_id ORDER BY horarios.inicio ASC'));
		}
		else {
			$this->set('horarios', $horario->query('SELECT DISTINCT(horarios.id) as id_horario, dias.nombre AS dia_nombre, personal.nombres AS nombres, personal.apellidos AS apellidos, materias.nombre AS materia_nombre, secciones.nombre AS seccion_nombre, aulas.nombre AS aula_nombre, horarios.inicio AS inicio, horarios.fin AS fin
					FROM materias, personal, horarios, secciones, aulas, bloques_horas, dias
					WHERE materias.id = horarios.materia_id
					AND personal.id = horarios.personal_id
					AND secciones.id = horarios.seccion_id
					AND aulas.id = horarios.aula_id
					AND dias.id = horarios.dia_id					
					AND bloques_horas.id = horarios.inicio
					AND DAYOFWEEK( CURDATE( ) -1 ) = horarios.dia_id ORDER BY horarios.inicio ASC'));
		}
		$bloque = new BloquesHora();
		$this->set('bloques', $bloque->find('all'));
                              
                
                $this->render();
	}
        
        public function pdfVerAsistencias($fecha_inicio = null, $fecha_fin = null) {
                Configure::write('debug',2);
		$this->layout = 'reportes';
		$horario = new Horario();
		if($this->Session->read('usuario.perfil_id') == 3){
			$this->set('asistencias', $horario->query('SELECT personal.cedula AS cedula, personal.nombres AS nombres, personal.apellidos AS apellidos, materias.nombre AS materia_nombre, secciones.nombre AS seccion_nombre, aulas.nombre AS aula_nombre, DATE( asistencias.fecha ) AS fecha, TIME( asistencias.fecha ) AS hora, horarios.inicio as inicio, horarios.fin as fin
												FROM personal, horarios, materias, secciones, aulas, asistencias
												WHERE horarios.personal_id = personal.id
												AND horarios.materia_id = materias.id
												AND horarios.seccion_id = secciones.id
												AND horarios.aula_id = aulas.id
												AND asistencias.horario_id = horarios.id
												AND materias.direccion_id = '.$this->Session->read('usuario.direccion_id').'
												AND DATE( asistencias.fecha ) 
												BETWEEN  "'.$fecha_inicio.'"
												AND  "'.$fecha_fin.'"'));
		}
		else{
			$this->set('asistencias', $horario->query('SELECT personal.cedula AS cedula, personal.nombres AS nombres, personal.apellidos AS apellidos, materias.nombre AS materia_nombre, secciones.nombre AS seccion_nombre, aulas.nombre AS aula_nombre, DATE( asistencias.fecha ) AS fecha, TIME( asistencias.fecha ) AS hora, horarios.inicio as inicio, horarios.fin as fin
												FROM personal, horarios, materias, secciones, aulas, asistencias
												WHERE horarios.personal_id = personal.id
												AND horarios.materia_id = materias.id
												AND horarios.seccion_id = secciones.id
												AND horarios.aula_id = aulas.id
												AND asistencias.horario_id = horarios.id												
												AND DATE( asistencias.fecha )
												BETWEEN  "'.$fecha_inicio.'"
												AND  "'.$fecha_fin.'"'));
			
		}
		$bloque = new BloquesHora();
		$this->set('bloques', $bloque->find('all'));
                
                $this->set('inicio', $fecha_inicio);
                
                $this->set('fin', $fecha_fin);
                
                $this->render();
	}
}
?>

