<script type="text/javascript">
		var url;
		function nuevo(){
			$('#dlg').dialog('open').dialog('setTitle','Nuevo Bloque de Hora');			
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
				$('#dlg').dialog('open').dialog('setTitle','Editar Bloque de Hora');
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
		
		$('#dg').pagination({
			pageList: [20,50,100]
		});
	</script>
<table id="dg" title="Bloques de Horas" class="easyui-datagrid" style="height:610px" url="verBloquesHoras"  toolbar="#toolbar"  pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" data-options="pageSize:20">  
    <thead>  
        <tr>  
            <th field="bloque" width="20" sortable="true">Hora</th>                                   
        </tr>          
    </thead>  
</table>  
<div id="toolbar"> 
	<div id="basic-acciones"> 
    	<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo()">Nuevo Registro</a>  
    	<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editar()">Editar</a>  
    	<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminar()">Eliminar</a>    	
    	<a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="eliminar()">Imprimir</a>
   	</div>
   	<div id="busqueda-accion">      
    	<span>Nombre: </span><input id="entrada" name="entrada" style="float: relative; font-size: 8pt; padding: 2px;border:1px solid #ccc;width: 100px;" class="easyui-validatebox"><a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="buscar()">Buscar</a>
    </div>
</div>  

<div id="dlg" class="easyui-dialog" style="width:320px;height:180px;padding:10px 20px; "
			closed="true">		
		<form id="fm" method="post" novalidate>		
		<table>						
			<tr>
				<td><label>Bloque:</label></td>
				<td><?php echo $this->Form->input('bloque', array('div' => false,'name' => 'bloque', 'class' => 'easyui-timespinner', 'required' => 'true', 'label' => false, 'data-options' => 'min:"00:00",showSeconds:true')); ?></td>
			</tr>									
		</table>					
		<?php echo $this->Form->end();?>
		<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" onclick="guardar()">Guardar</a>
		<a href="#" class="easyui-linkbutton" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>	
	</div>
	