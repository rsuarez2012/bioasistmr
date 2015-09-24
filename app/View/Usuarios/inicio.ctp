<?php $sitioUrl = 'http://localhost/bioasistmr/';?>
<?php
	//Opciones del Menú
	if($this->Session->check('usuario')) {
		//Perfil Administrador o Decano
		$usu = $this->Session->read('usuario');
		if(($usu['perfil_id']==1) || ($usu['perfil_id']==2)){						
			echo $this->Element('admin_menu'); 
			
		}
		else {
			//Perfil Directores
			if($usu['perfil_id']==3) {						
				echo $this->Element('director_menu');		
			}
			else {
				//Perfil Usuario Reportes
				if($usu['perfil_id']==4) {						
					echo $this->Element('usuario_menu');		
				}
			}
		}
	}
?>