<style>
	table, tr, td, th {
		border: 1px solid black;
		border-collapse: collapse;
	}

	.left {
		text-align: left;
	}

	.center {
		text-align: center;
	}
</style>

<table>
	<tr>
		<th colspan="2">{{ $data->matchName }}</th>
	</tr>

	<tr>
		<th class="left">Goles</th>
		<td>{{ $stats['goals'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Goles esperados</th>
		<td>{{ $stats['expected_goals'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Remates a portería</th>
		<td>{{ $stats['shots_on_goal'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Grandes ocasiones de gol</th>
		<td>{{ $stats['great_scoring_chances'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Remates</th>
		<td>{{ $stats['shots'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Ocasiones creadas</th>
		<td>{{ $stats['created_occasions'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Toques</th>
		<td>{{ $stats['touches'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Pases</th>
		<td>{{ $stats['pass'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Pases acertados en %</th>
		<td>{{ $stats['percentage_successful_pass'] ?? '0.00%' }}</td>
	</tr>

	<tr>
		<th class="left">Entradas</th>
		<td>{{ $stats['entries'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Faltas recibidas</th>
		<td>{{ $stats['fouls_received'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Faltas cometidas</th>
		<td>{{ $stats['fouls'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Intersecciones</th>
		<td>{{ $stats['intersections'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Duelos ganados</th>
		<td>{{ $stats['duel_wons'] ?? 0 }}</td>
	</tr>

	<tr>
		<th class="left">Recuperaciones</th>
		<td>{{ $stats['recoveries'] ?? 0 }}</td>
	</tr>

	@if($position == 'Goalkeeper')
		<tr>
			<th class="left">Paradas</th>
			<td>{{ $stats['stops'] ?? 0 }}</td>
		</tr>

		<tr>
			<th class="left">Remates recibidos</th>
			<td>{{ $stats['auctions_received'] ?? 0 }}</td>
		</tr>

		<tr>
			<th class="left">Porcentaje de paradas</th>
			<td>{{ $stats['percentage_stops'] ?? '0.00%' }}</td>
		</tr>
	@endif
</table>