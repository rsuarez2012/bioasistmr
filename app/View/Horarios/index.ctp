<?php
	$output = array();
	$output1 = array();
	$output2 = array();
	//Preparando formato profesores 
	if(isset($profesores)){
		foreach($profesores as $row) {
        		$output[] = $row['Personal'];        	
        }
        $profesores = $output;        
	}
	
	//Preparando formato materias
	if(isset($materias)){
		foreach($materias as $row) {
        		$output1[] = $row['Materia'];        	
        }
        $materias = $output1;			
	}
	
	//Preparando formato bloques de horas
	if(isset($bloques_horas)){
		foreach($bloques_horas as $row) {
        		$output2[] = $row['BloquesHora'];        	
        }
        $bloques_horas = $output2;              
	}
?>
<script type="text/javascript">
		var url;
		
		//Arreglos para obtener nombre de los dias de la seman
		var diasSemana = new Array("","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado", "Domingo");
	
		function nuevo(){
			url = 'nuevo';
			$(location).attr('href',url);
			
		}
		
		function editar(){
			var row = $('#dg').datagrid('getSelected');					
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = 'editar/'+row.id;
			}
		}
		
		function guardar(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){												
					var result = eval('('+result+')');					
					if (result.success){						
						$('#dlg').dialog('close');		// close the dialog
						$('#dg').datagrid('reload');	// reload the user data
						$.messager.show({	// show error message
							title: 'Resultado de la Operación',
							msg: result.msg
						});
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.msg
						});
					}
				}
			});
		}
		
		function eliminar(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','¿Seguro que desea eliminar el registro?',function(r){
					if (r){		
						url = 'eliminar/'+row.id;										
						$.post(url,function(result){																		
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
								$.messager.show({	// show error message
									title: 'Resultado de la Operación',
									msg: result.msg
								});
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.msg
								});
							}
						},'json');
					}
				});
			}
		}
	 	
	 	//Utilizada para obtener nombres y apellidos del profesor
	 	function profesorNombre(val,row){															
			var profesor = eval('('+'<?php echo json_encode($profesores)?>'+')');		
			for(id in profesor) {
				if(row.personal_id == profesor[id].id)
					val = profesor[id].nombres+" "+profesor[id].apellidos;											
			}		
			return val;
		}
		
		
	 	//Utilizada para obtener nombre de la materia
	 	function materiaNombre(val,row){															
			var materia = eval('('+'<?php echo json_encode($materias)?>'+')');		
			for(id in materia) {
				if(row.materia_id == materia[id].id)
					val = materia[id].nombre;											
			}		
			return val;
		}
		
		//Utilizada para obtener bloque hora inicio
	 	function bloqueInicio(val,row){															
			var bloque_hora = eval('('+'<?php echo json_encode($bloques_horas)?>'+')');		
			for(id in bloque_hora) {				
				if(row.inicio == bloque_hora[id].id) 
					val = bloque_hora[id].bloque;																
			}		
			return val;
		}
		
		//Utilizada para obtener bloque hora fin
	 	function bloqueFin(val,row){															
			var bloque_hora = eval('('+'<?php echo json_encode($bloques_horas)?>'+')');		
			for(id in bloque_hora) {				
				if(row.fin == bloque_hora[id].id) 
					val = bloque_hora[id].bloque;																
			}		
			return val;
		}
		
		//Utilizada para obtener dia
	 	function diaNombre(val,row){																
					val = diasSemana[row.dia_id];													
			return val;
		}
    function imprimir(){
    url = 'pdf/';
    $(location).attr('href' ,url);
    }
                
	</script>
<table id="dg" title="Horarios" class="easyui-datagrid" style="height:643px" url="verHorarios" toolbar="#toolbar"  pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">  
    <thead>  
        <tr>               
            <th field="materia_id" width="160" formatter="materiaNombre">Materia</th>
            <th field="personal_id" width=150" align="left" formatter="profesorNombre">Profesor</th>
            <th field="dia_id" width="60" sortable="true" align="center" formatter="diaNombre">Día</th>
            <th field="seccion_id" width="50" align="center">Sección</th>             
            <th field="inicio" width="60" align="center" formatter="bloqueInicio">Inicio</th>
            <th field="fin" width="60" align="center" formatter="bloqueFin">Fin</th>            
        </tr>          
    </thead>  
</table>  
<div id="toolbar"> 
	<div id="basic-acciones"> 
    	<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo()">Nuevo Registro</a>  
    	<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editar()">Editar</a>  
    	<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminar()">Eliminar</a>    	
    	<a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="imprimir()">Imprimir</a>
   	</div>
   	<div id="busqueda-accion">      
    	<span>Nombre: </span><input id="entrada" name="entrada" style="float: relative; font-size: 8pt; padding: 2px;border:1px solid #ccc;width: 100px;"><a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="buscar()">Buscar</a>
    </div>
</div>  
