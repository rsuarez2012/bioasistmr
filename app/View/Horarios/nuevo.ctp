<script type="text/javascript">
		var counter = 0, lastIndex = 0;
		
		
		$(function(){
			$('#tt').datagrid({											
				width:800,
				height:300,
				singleSelect:true,
				rownumbers: true,
				//url: 'resumenHorario',	
				showFooter: true,										
				columns:[[													
					{field:'materia_id',title:'Materia',width:200,align:'text'},
					{field:'personal_id',title:'Profesor',width:160,align:'text'},
					{field:'seccion_id',title:'Sección',width:60,align:'center'},
					{field:'dia_id',title:'Dia',width:80,align:'center'},									
					{field:'aula_id',title:'Aula',width:50,align:'center'},
					{field:'inicio',title:'Hora Inicio',width:70,align:'center'},
					{field:'fin',title:'Hora Fin',width:70,align:'center'},
					{field:'action',title:'',width:40,align:'center',
						formatter:function(value,row,index){																						
									var d = '<a href="#" onclick="deleterow('+index+')" title="Borrar"><img src="../img/icons/edit_remove.png" border="0" width="12"></a>';
									return d;								
						}
					}
					
				]],
				onBeforeEdit:function(index,row){
					row.editing = true;
					updateActions();
				},
				onAfterEdit:function(index,row){
					row.editing = false;		 
					updateActions();
				},
				onCancelEdit:function(index,row){
					row.editing = false;
					updateActions();
				}
			});
		});
		
		//Función para agregar los inputs 
		function agregarItem(valores){

			$('<input type="hidden" name="data[Horario][' + counter + '][personal_id]" id="horarioDetalle[personal_id]' + counter + '" value="'+valores.personal_id+'" >'
			   +'<input type="hidden" name="data[Horario][' + counter + '][dia_id]" id="horarioDetalle[dia_id]' + counter + '" value="'+valores.dia_id+'" >'
			   +'<input type="hidden" name="data[Horario][' + counter + '][materia_id]" id="horarioDetalle[materia_id]' + counter + '" value="'+valores.materia_id+'" >'
			   +'<input type="hidden" name="data[Horario][' + counter + '][seccion_id]" id="horarioDetalle[seccion_id]' + counter + '" value="'+valores.seccion_id+'" >'
			   +'<input type="hidden" name="data[Horario][' + counter + '][aula_id]" id="horarioDetalle[aula_id]' + counter + '" value="'+valores.aula_id+'" >'
			   +'<input type="hidden" name="data[Horario][' + counter + '][inicio]" id="horarioDetalle[inicio]' + counter + '" value="'+valores.inicio+'" >'
			   +'<input type="hidden" name="data[Horario][' + counter + '][fin]" id="horarioDetalle[fin]' + counter + '" value="'+valores.fin+'" >').appendTo('#detalleHorario');
			counter++;			
		 }
		 
		 //Función para eliminar los productos seleccionados
		 function eliminarItem(index){
		 		
			   	$('input[name="data[Horario]['+index+'][personal_id]"]').remove();
				$('input[name="data[Horario]['+index+'][dia_id]"]').remove();
				$('input[name="data[Horario]['+index+'][materia_id]"]').remove();
				$('input[name="data[Horario]['+index+'][seccion_id]"]').remove();
				$('input[name="data[Horario]['+index+'][aula_id]"]').remove();
				$('input[name="data[Horario]['+index+'][inicio]"]').remove();
				$('input[name="data[Horario]['+index+'][fin]"]').remove();
					
				counter--;					
		 }
		  
		function updateActions(){
			
			var rowcount = $('#tt').datagrid('getRows').length;
			for(var i=0; i<rowcount; i++){
				$('#tt').datagrid('updateRow',{
					index:i,
					row:{action:''}
				});
			}
		}
		
		function editrow(index){					
			$('#tt').datagrid('beginEdit', index);
		}
		
		function deleterow(index){
			var row;
			$.messager.confirm('Confirmación','¿Realmente desea eliminar el registro?',function(r){
				if (r){
					//Se obtiene el registro seleccionado
					row = $('#tt').datagrid('getSelected');
					
					//Se calculan los montos
					eliminarItem(index);
					
					//Se elimina el registro
					$('#tt').datagrid('deleteRow', index);
										
					updateActions();
				}
			});
		}
		
		function saverow(index){
			$('#tt').datagrid('endEdit', index);
		}
		
		function cancelrow(index){
			$('#tt').datagrid('cancelEdit', index);
		}
		

		function insert(){			
			var materia, dia, profesor, seccion, aula, inicio, fin;			
			var horarioDetalle = new Array();			
						
			//Se obtiene el valor de grid materias
			mat =	$('#materias').combogrid('grid');	// get datagrid object							
			materia = mat.datagrid('getSelected');							
			
			//Se obtiene el valor de grid profesores
			prof =	$('#profesores').combogrid('grid');	// get datagrid object							
			profesor = prof.datagrid('getSelected');
						
			//Se obtiene el valor de grid secciones
			sec =	$('#secciones').combogrid('grid');	// get datagrid object							
			seccion = sec.datagrid('getSelected');
			
			//Se obtiene el valor de grid dias
			Dia =	$('#dias').combogrid('grid');	// get datagrid object							
			dia = Dia.datagrid('getSelected');			
			
			//Se obtiene el valor de grid aulas
			Aula =	$('#aulas').combogrid('grid');	// get datagrid object							
			aula = Aula.datagrid('getSelected');
			
			//Se obtiene el valor de grid inicio
			Inicio =	$('#hora_inicio').combogrid('grid');	// get datagrid object							
			inicio = Inicio.datagrid('getSelected');
			
			//Se obtiene el valor de grid fin
			Fin =	$('#hora_fin').combogrid('grid');	// get datagrid object							
			fin = Fin.datagrid('getSelected');
			
			//Validacion de las entradas 
			//Validacion de selección de materia
			if( materia == null ) {
				alert("Deber seleccionar una materia!!");
				return;
			}
			
			//Validacion de selección de profesor
			if( profesor == null ) {
				alert("Deber seleccionar un profesor!!");
				return;
			}
			
			//Validacion de selección de la sección
			if( seccion == null ) {
				alert("Deber seleccionar una sección!!");
				return;
			}
			
			//Validacion de selección del día
			if( dia == null ) {
				alert("Deber seleccionar un día!!");
				return;
			}
			
			//Validacion de selección del aula
			if( aula == null ) {
				alert("Deber seleccionar un aula!!");
				return;
			}
														
			var row = $('#tt').datagrid('getSelected');
			
			if (row){
				var index = $('#tt').datagrid('getRowIndex', row);
			} else {
				index = 0;
			}
			
			$('#tt').datagrid('insertRow', {				
				index: lastIndex,			
				row:{					
					materia_id: materia.nombre,
					personal_id: profesor.nombres+" "+profesor.apellidos,											
					seccion_id: seccion.nombre,
					dia_id: dia.nombre,
					aula_id: aula.nombre,
					inicio: inicio.bloque,
					fin: fin.bloque
				}				
			});
			lastIndex = $('#tt').datagrid('getRows').length-1;
			$('#tt').datagrid('selectRow',index);
			$('#tt').datagrid('beginEdit',index);
			
			
			//Limpiar los campos
			$('#aulas').combogrid('clear');
			$('#dias').combogrid('clear');
			$('#hora_inicio').combogrid('clear');
			$('#hora_fin').combogrid('clear');
			
			
			//Asignar los valores al array del detalle de la factura							
			horarioDetalle["aula_id"] = aula.id;
			horarioDetalle["materia_id"] = materia.id;
			horarioDetalle["personal_id"] = profesor.id;
			horarioDetalle["seccion_id"] = seccion.id;
			horarioDetalle["dia_id"] =  dia.id;
			horarioDetalle["inicio"] =  inicio.id;
			horarioDetalle["fin"] =  fin.id;							
			
			//Crea lo input de cada valor para construir el array
			agregarItem(horarioDetalle);											
						
		}
		
		function guardar(){					

			url =  'agregar';

			//Validacion selección al menos un horario
			if(counter<1) {
				alert("Debe seleccionar al menos un horario!!");
				return;
			}
								
			$('#cargaHoraria').form('submit',{
				url: url,
				onSubmit: function(){									
					return $(this).form('validate');
				},
				success: function(result){												
					var result = eval('('+result+')');					
			
					if (result.success){
						$(location).attr('href','index');						
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
		
		//Función para regresar a la lista de horarios
		function cancelar() {
			url = 'index';
			$(location).attr('href',url);		
		}
	</script>
</head>
<body>
<h1>Registro de Horarios</h1>
<form name="cargaHoraria" id="cargaHoraria" method="post" novalidate>
<table id="horario">
<tr>				
	<th colspan="6">Datos del Horario</th>
</tr>
<tr>				
	<td>Periodo Lectivo</td>	
	<td><?php echo $periodo_lectivo[0]['PeriodosLectivo']['nombre'];?></td>
</tr>
<tr>
	<td><label>Materia:</label></td>
	<td><input name="materias" id="materias" ></td>	
	<td><label>Sección:</label></td>
	<td><input name="secciones" id="secciones" ></td>
	<td><label>Aula:</label></td>
	<td><input name="aulas" id="aulas" ></td>		
</tr>
<tr>
	<td><label>Profesor:</label></td>
	<td><input name="profesores" id="profesores" ></td>	
	<td><label>Día:</label></td>
	<td><input name="dias" id="dias" ></td>	
</tr>
<tr>			
	<td><label>Hora Inicio:</label></td>
	<td><input name="hora_inicio" id="hora_inicio" ></td>	
	<td><label>Hora Fin:</label></td>
	<td><input name="hora_fin" id="hora_fin" ></td>
	<td><a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="insert()">Agregar</a></td>
</tr>	
<tr>
	<th colspan="6">
	Detalle Horarios
	</th>
</tr>
<tr>
	<td colspan="6">	 
	<table id="tt"></table>
	<input name="subtotal" id="subtotal" type="hidden" value="0">	
	<input name="impuesto" id="impuesto" type="hidden" value="0">
	<input name="total" id="total" type="hidden" value="0">
	<input name="fecha" id="fecha" type="hidden">
	<div id="detalleHorario"></div>
	</td>
</tr>
<tr>
	<th colspan="6">
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" onclick="guardar()">Guardar</a>
		<a href="#" class="easyui-linkbutton" onclick="cancelar()">Cancelar</a>	
	</div>
	</th>
</tr>
</table>
</form>
<script type="text/javascript">
    //Combogrid materias
    $('#materias').combogrid({
    panelWidth:400,
    url: 'listaMaterias',  
    idField:'id',  
    textField:'nombre', 
    mode:'remote',  
    fitColumns:true,  
    columns:[[  
        {field:'id',title:'ID',width:40},
        {field:'codigo',title:'Código',width:50},
        {field:'nombre',title:'Nombre',width:200},
        {field:'horas',title:'Horas',width:50}
    ]]  
	});
	
    //Combogrid dias
    $('#dias').combogrid({
    panelWidth:250,  
    url: 'listaDias',  
    idField:'id',  
    textField:'nombre', 
    mode:'remote',  
    fitColumns:true,  
    columns:[[  
        {field:'id',title:'ID',width:40},  
        {field:'nombre',title:'Nombre',width:200},                    
    ]]  
	});
	
    //Combogrid profesores
    $('#profesores').combogrid({
    panelWidth:550,
    url: 'listaProfesores',  
    idField:'id',  
    textField:'nombres', 
    mode:'remote',  
    fitColumns:true,  
    columns:[[  
        {field:'id',title:'ID',width:30, align:'center'},
        {field:'cedula',title:'Cédula',width:50, align:'center'},  
        {field:'nombres',title:'Nombres',width:100},
        {field:'apellidos',title:'Apellidos',width:100},           
        {field:'telefono',title:'Teléfono',width:70, align: 'center'}                  
    ]]  
	});
	
	//Combogrid secciones
	$('#secciones').combogrid({  
    panelWidth:100,  
    url: 'listaSecciones',  
    idField:'id',  
    textField:'nombre', 
    mode:'remote',  
    fitColumns:true,  
    columns:[[  
        {field:'id',title:'ID',width:30, align:'center'},
        {field:'nombre',title:'Nombre',width:70, align:'center'}                         
    ]] 
	});
	
	//Combogrid hora_inicio
	$('#hora_inicio').combogrid({  
    panelWidth:100,  
    url: 'listaBloquesHora',  
    idField:'id',  
    textField:'bloque', 
    mode:'remote',  
    fitColumns:true,  
    columns:[[  
        {field:'id',title:'ID',width:30, align:'center'},
        {field:'bloque',title:'Bloque',width:70, align:'center'}                         
    ]]  
	});
	
	//Combogrid hora_fin
	$('#hora_fin').combogrid({  
    panelWidth:120,  
    url: 'listaBloquesHora',  
    idField:'id',  
    textField:'bloque', 
    mode:'remote',  
    fitColumns:true,  
    columns:[[  
        {field:'id',title:'ID',width:30, align:'center'},
        {field:'bloque',title:'Bloque',width:80, align:'center'}                         
    ]]  
	});
	
	//Combogrid aulas
	$('#aulas').combogrid({  
    panelWidth:150,  
    url: 'listaAulas',  
    idField:'id',  
    textField:'nombre', 
    mode:'remote',  
    fitColumns:true,  
    columns:[[  
        {field:'id',title:'ID',width:40},  
        {field:'nombre',title:'Nombre',width:60},                    
    ]]  
	});
</script>