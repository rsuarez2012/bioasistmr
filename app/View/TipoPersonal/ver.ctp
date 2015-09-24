<h1>Información del Usuario</h1>
<table>
	<tr>
		<th>Cédula</th>
		<td><?php echo $usuario['Usuario']['cedula'];?></td>
	</tr>
	<tr>
		<th>Nombres</th>
		<td><?php echo $usuario['Usuario']['nombres'];?></td>
	</tr>
	<tr>
		<th>Apellidos</th>
		<td><?php echo $usuario['Usuario']['apellidos'];?></td>
	</tr>
	<tr>
		<th>Sexo</th>
		<td><?php echo $usuario['Usuario']['sexo'];?></td>
	</tr>
	<tr>
		<th>Dirección</th>
		<td><?php echo $usuario['Usuario']['direccion'];?></td>
	</tr>
	<tr>
		<th>Teléfono</th>
		<td><?php echo $usuario['Usuario']['telefono'];?></td>
	</tr>
	<tr>
		<th>Correo Electrónico</th>
		<td><?php echo $usuario['Usuario']['email'];?></td>
	</tr>
	<tr>
		<th>Usuario</th>
		<td><?php echo $usuario['Usuario']['usuario'];?></td>
	</tr>
</table>