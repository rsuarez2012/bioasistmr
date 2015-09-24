<script type="text/javascript">
	function buscarAsistencias() {
			var inicio = $('#inicio').datebox('getValue');
			var fin = $('#fin').datebox('getValue');
                        if((inicio.length == 0) || (fin.length == 0)){
                            alert("Debe seleccionar el rango de fecha!!");
                            return;
                        }
			url = 'verAsistencias/'+inicio+'/'+fin;
  			$(location).attr('href',url);	
	}
</script>
<h1>Listado de Reportes</h1>
<div id="horarios">	
	<table id="general">
		<tr>
			<th>Nombre del Reporte</th>
			<th>Parámetros</th>
			<th>Ejecutar</th>									
		</tr>
		<tr>		
			<td>Horarios del día</td>
			<td align="center">-</th>		
			<td><a href="horariosHoy/"><?php echo $this->Html->image('buscar.png', array('alt' => 'Aulas', 'width' => '25', 'align' => 'absmiddle', 'border' => 0));?></a></td>
	
		</tr>
		<tr>			
			<td>Asistencias por fechas:</td>
			<td>			
			Desde: <input id="inicio" name="inicio" type="text" class="easyui-datebox" required="required">-
			Hasta: <input id="fin" name="fin" type="text" class="easyui-datebox" required="required">	            	
			</td>
			<td>
			<a href="#" onClick="buscarAsistencias();"><?php echo $this->Html->image('buscar.png', array('alt' => 'Aulas', 'width' => '25', 'align' => 'absmiddle','border' => 0));?></a>
			</td>						
		</tr>	
	</table>	
</div>
<script type="text/javascript">
	$.fn.datebox.defaults.formatter = function(date){
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		var d = date.getDate();
	return y+'-'+m+'-'+d;
	}
	$('#inicio').datebox({  required:true  });
	$('#fin').datebox({  required:true  });    
</script>