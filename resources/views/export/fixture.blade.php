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
		<th>Local</th>
		<th>Fecha</th>
		<th>Hora</th>
		<th>Visitante</th>
	</tr>

	@foreach($data as $item)
		<tr>
			<td>{{ $item['local'] }}</td>
			<td>{{ $item['date'] }}</td>
			<td>{{ $item['time'] }}</td>
			<td>{{ $item['away'] }}</td>
		</tr>
	@endforeach
</table>