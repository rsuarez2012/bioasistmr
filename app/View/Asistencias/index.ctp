<?php
	$output = array();
	//Preparando formato horarios 
	if(isset($lista_horarios)){
		foreach($lista_horarios as $row) {
        		$output[] = $row['Horario'];        	
        }
        $lista_horarios = $output;			
	}
	
	$output1 = array();
	//Preparando formato docentes 
	if(isset($docentes)){
		foreach($docentes as $row) {
        		$output1[] = $row['Personal'];        	
        }
        $docentes = $output1;			
	}
	
	$output2 = array();	
	//Preparando formato materias
	if(isset($materias)){
		foreach($materias as $row) {
        		$output2[] = $row['Materia'];        	
        }
        $materias = $output2;
			
	}

        $output3 = array();
	//Preparando formato materias
	if(isset($secciones)){
		foreach($secciones as $row) {
        		$output2[] = $row['Seccion'];
        }
        $secciones = $output2;
	}
?>
<script type="text/javascript">
		var url;
		function nuevo(){
			$('#dlg').dialog('open').dialog('setTitle','Nuevo Registro');			
			$('#fm').form('clear');	
			url = 'agregar';	
		}
		
		function buscar(){
			//Valida la longitud de la entrada
			if($('#entrada').val().length == 0) { 
				alert('Debe ingresar un valor a buscar!!');
				return;
			}
			else {
					$('#dg').datagrid('load',{  
				        entrada: $('#entrada').val()  		         
		    	}); 
    		}
	  	}
	  	
		function editar(){
			var row = $('#dg').datagrid('getSelected');					
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar Registro');
				$('#fm').form('load',row);
				url = 'editar/'+row.id;
			}
			else {
				alert('Debe seleccionar un registro!');
			}
		}

                function inasistenciasHoy(){

                    $.messager.confirm('Confirmación de Acción','¿Seguro que desea registrar las inasistencias?',function(r){
                        if (r){
                            url = 'registrarInasistencias/';
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

                function inasistenciasAyer(){

                    $.messager.confirm('Confirmación de Acción','¿Seguro que desea registrar las inasistencias?',function(r){
                        if (r){
                            url = 'registrarInasistenciasAyer/';
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
				$.messager.confirm('Confirmación','¿Seguro que desea eliminar el registro?',function(r){
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
			else {
				alert('Debe seleccionar un registro!');
			}
		}
		
		function FEstatus(val, row) {
			if(row.estatus == 0 ){
				val = "No Asistió";
			}
			else{
				val = "Asistió";
			}
			return val;
		}
	
		function formatoAsistencia(val, row) {
			var horarios = eval('('+'<?php echo json_encode($lista_horarios)?>'+')');		
			var docentes = eval('('+'<?php echo json_encode($docentes)?>'+')');
			var materias = eval('('+'<?php echo json_encode($materias)?>'+')');
            var secciones = eval('('+'<?php echo json_encode($secciones)?>'+')');

            var docente, materia, seccion;
			//Busqueda id de docente
			for(id in horarios) {
				if(row.horario_id == horarios[id].id){
					personal_id = horarios[id].personal_id;
					materia_id = horarios[id].materia_id;
                    seccion_id = horarios[id].seccion_id;
                }
			}
			
			//Busqueda datos a mostrar del personal
			for(id in docentes) {
				if(personal_id == docentes[id].id) {					
					docente = docentes[id].cedula +' - ' + docentes[id].nombres + ', ' + docentes[id].apellidos;
				}
			}		
			
			//Busqueda datos a mostrar del materias
			for(id in materias) {
				if(materia_id == materias[id].id) {					
					materia = ' - ' + materias[id].nombre;
				}				
			}

            //Busqueda datos a mostrar de la sección
			for(id in secciones) {
				if(seccion_id == secciones[id].id) {
					seccion = ' - Sección: '+ secciones[id].nombre;
				}
			}	
						val = docente + materia + seccion;
							return val;										
						
		}

                function imprimir(){
                    url = 'pdf/';
                    $(location).attr('href' ,url);
                }

      
	</script>
<table id="dg" title="Asistencias Registradas" class="easyui-datagrid" style="height:610px" url="verAsistencias"  toolbar="#toolbar"  pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">  
    <thead>  
        <tr>  
            <th field="fecha" width="80" sortable="true" align="center">Fecha</th>  
            <th field="horario_id" width="300" formatter="formatoAsistencia">Datos del Docente</th>
            <th field="estatus" width="50" sortable="true" align="center" formatter="FEstatus" >Estatus</th>
            <th field="observaciones" width="200">Observaciones</th>              
        </tr>          
    </thead>  
</table>  
<div id="toolbar">
	<div id="basic-acciones"> 
    	<!--<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo()">Nuevo Registro</a>-
    	<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editar()">Editar</a>  -->
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="inasistenciasAyer()">Inasistencias Ayer</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="inasistenciasHoy()">Inasistencias Hoy</a>
    	<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminar()">Eliminar</a>
    	<a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="imprimir()">Imprimir</a>    	
   	</div>
   	<div id="busqueda-accion">
        
        </div>
</div>  

<div id="dlg" class="easyui-dialog" style="width:300px;height:250px;padding:10px 20px;" closed="true">
		<form id="fm" method="post" novalidate>		
		<table>	
			<tr>
				<td><label>Horario:</label></td>
				<td><?php echo $this->Form->input('horario_id', array('div' => false,'name' => 'horario_id', 'id' => 'horario_id', 'class' => 'easyui-validatebox', 'required' => 'true', 'label' => false)); ?></td>
			</tr>		
			<tr>
				<td><label>Fecha:</label></td>
				<td><?php echo $this->Form->input('fecha', array('div' => false, 'class' => 'easyui-validatebox', 'label' => false, 'name' => 'fecha'))?></td>
			</tr>			
			<tr>
				<td><label>Estatus:</label></td>
				<td><select name="estatus" class="easyui-validatebox" required="true">					
					<option value="1">Asistió</option>
					<option value="0">No Asistió</option>
				</select></td>
			</tr>
			<tr>
				<td><label>Observaciones:</label></td>
				<td><?php echo $this->Form->textarea('observaciones', array('div' => false, 'class' => 'easyui-validatebox', 'label' => false, 'name' => 'observaciones'))?></td>
			</tr>			
		</table>					
		</form>	
		<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" onclick="guardar()">Guardar</a>
		<a href="#" class="easyui-linkbutton" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>	
	</div>
<script type="text/javascript">
	$.fn.datebox.defaults.formatter = function(date){
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		var d = date.getDate();
	return y+'-'+m+'-'+d;
	}
	$('#entrada').datebox({  required:true  });
</script>