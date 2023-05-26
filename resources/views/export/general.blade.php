<style>
	table, tr, td, th {
		border: 1px solid black;
		border-collapse: collapse;
	}

	th {
		text-align: left;
	}
</style>

<table>
	<tr>
		<th>Equipo local</th>
		<td>{{ $lineups['local']['team'] }}</td>
		<td></td>
		<th>Equipo visitante</th>
		<td>{{ $lineups['away']['team'] }}</td>
	</tr>

	<tr>
		<th>Disposicion tactica</th>
		<td>{{ $lineups['local']['formation'] }}</td>
		<td></td>
		<th>Disposicion tactica</th>
		<td>{{ $lineups['away']['formation'] }}</td>
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
			<td>{{ $lineups['local']['startXI'][$i]['number'] }}</td>
			<td>{{ $lineups['local']['startXI'][$i]['name'] }}</td>
			<td></td>
			<td>{{ $lineups['away']['startXI'][$i]['number'] }}</td>
			<td>{{ $lineups['away']['startXI'][$i]['name'] }}</td>
		</tr>
	@endfor

	<tr>
		<th>Entrenador</th>
		<td>{{ isset($lineups['local']['coach']) ? $lineups['local']['coach'] : '' }}</td>
		<td></td>
		<th>Entrenador</th>
		<td>{{ isset($lineups['away']['coach']) ? $lineups['away']['coach'] : '' }}</td>
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
			<td>{{ $lineups['local']['substitutes'][$i]['number'] ?? '' }}</td>
			<td>{{ isset($lineups['local']['substitutes'][$i]['name']) ? $lineups['local']['substitutes'][$i]['name'] : '' }}</td>
			<td></td>
			<td>{{ $lineups['away']['substitutes'][$i]['number'] ?? '' }}</td>
			<td>{{ isset($lineups['away']['substitutes'][$i]['name']) ? $lineups['away']['substitutes'][$i]['name'] : '' }}</td>
		</tr>
	@endfor

	<tr>
		<th></th>
		<th></th>
		<th>Tiempo</th>
		<th></th>
		<th>Tiempo</th>
	</tr>

	<tr>
		<th></th>
		<th>Tarjeta roja</th>
		<td>{{ $red['home'] }}</td>
		<th>Tarjeta roja</th>
		<td>{{ $red['away'] }}</td>
	</tr>

	<tr>
		<th></th>
		<th>Doble amarilla</th>
		<td>{{ $secondYellow['home'] }}</td>
		<th>Doble amarilla</th>
		<td>{{ $secondYellow['away'] }}</td>
	</tr>

	<tr>
		<th></th>
		<th>Tarjeta amarilla</th>
		<td>{{ $yellow['home'] }}</td>
		<th>Tarjeta amarilla</th>
		<td>{{ $yellow['away'] }}</td>
	</tr>

	<tr>
		<th></th>
		<th>Goles</th>
		<td>{{ $goals['home'] }}</td>
		<th>Goles</th>
		<td>{{ $goals['away'] }}</td>
	</tr>

	<tr>
		<th></th>
		<th>Revisión de VAR</th>
		<td>{{ $var['home'] }}</td>
		<th>Revisión de VAR</th>
		<td>{{ $var['away'] }}</td>
	</tr>

	<tr>
		<th></th>
		<th>Fuera de juego</th>
		<td>{{ $offside['home'] }}</td>
		<th>Fuera de juego</th>
		<td>{{ $offside['away'] }}</td>
	</tr>
</table>