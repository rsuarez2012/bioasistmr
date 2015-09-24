<?php 
	$output = array(); 
	if(isset($semestres)){
		foreach($semestres as $row) {
        		$output[] = $row['Nivel'];        	
        }
        $semestres = $output;			
	}
?>
<script type="text/javascript">
		var url;
		function nuevo(){
			$('#dlg').dialog('open').dialog('setTitle','Nueva Materia');			
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
				$('#dlg').dialog('open').dialog('setTitle','Editar Materia');
				$('#fm').form('load',row);
				url = 'editar/'+row.id;
			}
			else {
				alert('Debe seleccionar un registro!');
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
				$.messager.confirm('Confirmación de la Operación','¿Seguro que desea eliminar el registro?',function(r){
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
		
		function Semestre(val,row){																		
				var semestres = eval('('+'<?php echo json_encode($semestres)?>'+')');		
				for(id in semestres) {					
					if(row.nivel_id == semestres[id].id){						
						val = semestres[id].etiqueta;
									
					}								
				}						
				return val;
		}
	</script>
<table id="dg" title="Materias" class="easyui-datagrid" style="height:610px" url="verMaterias"  toolbar="#toolbar"  pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">  
    <thead>  
        <tr>
            <th field="codigo" width="20" align="center">Código</th>
            <th field="nombre" width="100">Nombre</th>
            <th field="horas" width="40" align="center">Horas Semanales</th>
            <th field="nivel_id" width="20" sortable="true" align="center" formatter="Semestre">Semestre</th>                          
        </tr>          
    </thead>  
</table>  
<div id="toolbar"> 
	<div id="basic-acciones"> 
    	<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo()">Nuevo Registro</a>  
    	<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editar()">Editar</a>  
    	<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminar()">Eliminar</a>
   	</div>
   	<div id="busqueda-accion">      
    	<span>Nombre: </span><input id="entrada" name="entrada" style="float: relative; font-size: 8pt; padding: 2px;border:1px solid #ccc;width: 100px;" class="easyui-validatebox"><a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="buscar()">Buscar</a>
    </div>
</div>  

<div id="dlg" class="easyui-dialog" style="width:380px;height:290px;padding:10px 20px;" closed="true">
		<form id="fm" method="post" novalidate>
		<?php //echo $this->Form->create('Usuario', array('div' => false, 'method' => 'post', 'id' => 'fm', 'action' => 'agregar', 'novalidate')); ?>
		<table>	
			<tr>
				<td><label>Dirección:</label></td>
				<td><?php echo $this->Form->input('direccion_id', array('div' => false,'name' => 'direccion_id', 'id' => 'direccion_id', 'class' => 'easyui-validatebox', 'required' => 'true', 'label' => false)); ?></td>
			</tr>
			<tr>
				<td><label>Semestre:</label></td>
				<td><?php echo $this->Form->input('nivel_id', array('div' => false,'name' => 'nivel_id', 'id' => 'nivel_id', 'class' => 'easyui-validatebox', 'required' => 'true', 'label' => false)); ?></td>
			</tr>
                        <tr>
				<td><label>Código:</label></td>
				<td><?php echo $this->Form->input('codigo', array('div' => false,'name' => 'codigo', 'id' => 'codigo', 'class' => 'easyui-validatebox', 'required' => 'true', 'label' => false)); ?></td>
			</tr>
			<tr>
				<td><label>Nombre:</label></td>
				<td><?php echo $this->Form->textarea('nombre', array('div' => false, 'class' => 'easyui-validatebox', 'required' => 'true','label' => false, 'name' => 'nombre'))?></td>
			</tr>
                        <tr>
				<td><label>Horas:</label></td>
				<td><?php
                                    $options = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6');echo $this->Form->select('horas', $options)
                                    ?></td>
			</tr>
		</table>					
		</form>	
		<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" onclick="guardar()">Guardar</a>
		<a href="#" class="easyui-linkbutton" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>	
	</div>
	