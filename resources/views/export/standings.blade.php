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
		<th>Posicion</th>
		<th>Equipo</th>
		<th>Jugados</th>
		<th>Puntos</th>
	</tr>

	@foreach($data as $item)
		<tr>
			<td>{{ $item['position'] }}</td>
			<td>{{ $item['team'] }}</td>
			<td>{{ $item['played'] }}</td>
			<td>{{ $item['points'] }}</td>
		</tr>
	@endforeach
</table>