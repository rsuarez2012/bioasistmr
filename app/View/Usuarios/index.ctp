<script type="text/javascript">
		var url;
		function nuevo(){
			$('#dlg').dialog('open').dialog('setTitle','Nuevo Usuario');			
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
				$('#dlg').dialog('open').dialog('setTitle','Editar Usuario');
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
    function imprimir(){
    url = 'pdf/';
    $(location).attr('href' ,url);
    }
		
	
	</script>
<table id="dg" title="Usuarios del Sistema" class="easyui-datagrid" style="height:610px" url="verUsuarios"  toolbar="#toolbar"  pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">  
    <thead>  
        <tr>  
            <th field="cedula" width="20" sortable="true" align="center">Cédula</th>  
            <th field="nombres" width="50">Nombres</th>  
            <th field="apellidos" width="50" sortable="true">Apellidos</th>  
            <th field="telefono" width="20" align="center">Teléfono</th>  
            <th field="email" width="50">Email</th>
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
    	<span>Cédula: </span><input id="entrada" name="entrada" style="float: relative; font-size: 8pt; padding: 2px;border:1px solid #ccc;width: 100px;" class="easyui-validatebox"><a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="buscar()">Buscar</a>
    </div>
</div>  

<div id="dlg" class="easyui-dialog" style="width:450px;height:460px;padding:10px 20px;" closed="true">
		<form id="fm" method="post" novalidate>
		<?php //echo $this->Form->create('Usuario', array('div' => false, 'method' => 'post', 'id' => 'fm', 'action' => 'agregar', 'novalidate')); ?>
		<table>	
			<tr>
				<td><label>Perfil de Usuario:</label></td>
				<td><?php echo $this->Form->input('perfil_id', array('div' => false,'name' => 'perfil_id', 'id' => 'perfil_id', 'class' => 'easyui-validatebox', 'required' => 'true', 'label' => false)); ?></td>
			</tr>		
			<tr>
				<td><label>Cédula:</label></td>
				<td><?php echo $this->Form->input('cedula', array('div' => false, 'class' => 'easyui-validatebox', 'required' => 'true', 'label' => false, 'name' => 'cedula'))?></td>
			</tr>
			<tr>
				<td><label>Nombres:</label></td>
				<td><?php echo $this->Form->input('nombres', array('div' => false, 'class' => 'easyui-validatebox', 'required' => 'true', 'label' => false, 'name' => 'nombres'))?></td>
			</tr>
			<tr>
				<td><label>Apellidos:</label></td>
				<td><?php echo $this->Form->input('apellidos', array('div' => false, 'class' => 'easyui-validatebox', 'required' => 'true', 'label' => false, 'name' => 'apellidos'))?></td>
			</tr>
			<tr>
				<td><label>Sexo:</label></td>
				<td><select name="sexo" class="easyui-validatebox" required="true">					
					<option value="F">Femenino</option>
					<option value="M">Masculino</option>
				</select></td>
			</tr>
			<tr>
				<td><label>Dirección:</label></td>
				<td><?php echo $this->Form->textarea('direccion', array('div' => false, 'class' => 'easyui-validatebox', 'label' => false, 'name' => 'direccion'))?></td>
			</tr>
			<tr>
				<td><label>Teléfono:</label></td>
				<td><?php echo $this->Form->input('telefono', array('div' => false, 'class' => 'easyui-validatebox', 'label' => false, 'name' => 'telefono'))?></td>
			</tr>
			<tr>
				<td><label>Email:</label></td>
				<td><?php echo $this->Form->input('email', array('div' => false, 'class' => 'easyui-validatebox', 'required' => 'true', 'label' => false, 'name' => 'email', 'validType' => 'email'))?></td>
			</tr>
			<tr>
				<td><label>Usuario:</label></td>
				<td><?php echo $this->Form->input('usuario', array('class' => 'easyui-validatebox', 'required' => 'true', 'label' => false, 'name' => 'usuario'))?></td>
			</tr>
			<tr>
				<td><label>Clave:</label></td>
				<td><?php echo $this->Form->input('clave', array('div' => false, 'class' => 'easyui-validatebox', 'required' => 'true', 'type' => 'password', 'label' => false, 'name' => 'clave'))?></td>
			</tr>
		</table>					
		</form>	
		<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" onclick="guardar()">Guardar</a>
		<a href="#" class="easyui-linkbutton" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>	
	</div>
	