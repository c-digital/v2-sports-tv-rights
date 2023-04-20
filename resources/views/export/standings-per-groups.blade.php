<style>
	table {
		margin-bottom: 10px;
	}

	table, tr, td, th {
		border: 1px solid black;
		border-collapse: collapse;
	}

	th {
		font-weight: bold;
		text-align: left;
	}
</style>

@foreach($data as $group => $teams)
	<table>
		<tr>
			<th colspan="4">{{ $group }}</th>
		</tr>

		<tr>
			<th>Posicion</th>
			<th>Equipo</th>
			<th>Jugados</th>
			<th>Puntos</th>
		</tr>

		@foreach($teams as $team)
			<tr>
				<td>{{ $team['position'] }}</td>
				<td>{{ $team['team'] }}</td>
				<td>{{ $team['played'] }}</td>
				<td>{{ $team['points'] }}</td>
			</tr>
		@endforeach
	</table>
@endforeach