<script type="text/javascript">
		var url;
		function nuevo(){
			$('#dlg').dialog('open').dialog('setTitle','Nuevo Perfil');			
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
	  	
	  	function imprimir(){
			var row = $('#dg').datagrid('getSelected');					
			if (row){				
				url = 'verPdf/'+row.id;
				$(location).attr('href',url);
			}
			else {
				alert('Debe seleccionar un registro!');
			}
	  	}
	  	
	  	
		function editar(){
			var row = $('#dg').datagrid('getSelected');					
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar Perfil');
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
	</script>
<table id="dg" title="Perfiles de Usuarios" class="easyui-datagrid" style="height:610px" url="verPerfiles"  toolbar="#toolbar"  pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">  
    <thead>  
        <tr>  
            <th field="nombre" width="100" sortable="true">Nombre</th>  
            <th field="descripcion" width="200">Descripcion</th>             
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
    	<span>Nombre: </span><input id="entrada" name="entrada" style="float: relative; font-size: 8pt; padding: 2px;border:1px solid #ccc;width: 100px;" class="easyui-validatebox"><a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="buscar()">Buscar</a>
    </div>
</div>  

<div id="dlg" class="easyui-dialog" style="width:350px;height:200px;padding:10px 20px; "
			closed="true">
		<form id="fm" method="post" novalidate>		
		<?php //echo $this->Form->create('Perfil', array('type' => 'post', 'id' => 'fm', 'action' => 'agregar', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
		<table>						
			<tr>
				<td><label>Nombre:</label></td>
				<td><?php echo $this->Form->input('nombre', array('div' => false,'name' => 'nombre', 'class' => 'easyui-validatebox', 'required' => 'true', 'label' => false)); ?></td>
			</tr>			
			<tr>
				<td><label>Descripción:</label></td>
				<td><?php echo $this->Form->textarea('descripcion', array('div' => false, 'name' => 'descripcion', 'class' => 'easyui-validatebox', 'required' => 'true', 'label' => false)); ?></td>
			</tr>			
		</table>					
		<?php echo $this->Form->end();?>
		<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" onclick="guardar()">Guardar</a>
		<a href="#" class="easyui-linkbutton" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>	
	</div>
	