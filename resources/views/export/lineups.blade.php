<style>
	table, tr, td, th {
		border: 1px solid black;
		border-collapse: collapse;
	}

	th {
		font-weight: bold;
		text-align: left;
	}
</style>

<table>
	<tr>
		<th>Equipo local</th>
		<td>{{ $data['local']['team'] }}</td>
		<td></td>
		<th>Equipo visitante</th>
		<td>{{ $data['away']['team'] }}</td>
	</tr>

	<tr>
		<th>Disposicion tactica</th>
		<td>{{ $data['local']['formation'] }}</td>
		<td></td>
		<th>Disposicion tactica</th>
		<td>{{ $data['away']['formation'] }}</td>
	</tr>

	<tr>
		<th colspan="2">Titulares</th>
		<th></th>
		<th colspan="2">Titulares</th>
	</tr>

	<tr>
		<th>Dorsal</th>
		<th>Nombre</th>
		<th></th>
		<th>Dorsal</th>
		<th>Nombre</th>
	</tr>

	@for($i = 0; $i <= 10; $i++)
		<tr>
			<td>{{ $data['local']['startXI'][$i]['number'] }}</td>
			<td>{{ $data['local']['startXI'][$i]['name'] }}</td>
			<td></td>
			<td>{{ $data['away']['startXI'][$i]['number'] }}</td>
			<td>{{ $data['away']['startXI'][$i]['name'] }}</td>
		</tr>
	@endfor

	<tr>
		<th>Entrenador</th>
		<td>{{ $data['local']['coach'] }}</td>
		<td></td>
		<th>Entrenador</th>
		<td>{{ $data['away']['coach'] }}</td>
	</tr>

	<tr>
		<th colspan="2">Suplentes</th>
		<th></th>
		<th colspan="2">Suplentes</th>
	</tr>

	<tr>
		<th>Dorsal</th>
		<th>Nombre</th>
		<th></th>
		<th>Dorsal</th>
		<th>Nombre</th>
	</tr>

	@for($i = 0; $i <= $max - 1; $i++)
		<tr>
			<td>{{ $data['local']['substitutes'][$i]['number'] ?? '' }}</td>
			<td>{{ $data['local']['substitutes'][$i]['name'] ?? '' }}</td>
			<td></td>
			<td>{{ $data['away']['substitutes'][$i]['number'] ?? '' }}</td>
			<td>{{ $data['away']['substitutes'][$i]['name'] ?? '' }}</td>
		</tr>
	@endfor
</table>