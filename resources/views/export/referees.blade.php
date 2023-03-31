<style>
	table, tr, td, th {
		border: 1px solid black;
		border-collapse: collapse;
	}

	th {
		font-weight: bold;
	}

	.text-left {
		text-align: left;
	}
</style>

<table>
	<tr>
		<th colspan="2">Arbitros</th>
	</tr>

	@foreach($referees as $referee)
		<tr>
			<th class="text-left">{{ type($referee->type) }}</th>
			<td>{{ $referee->firstName . ' ' . $referee->lastName }}</td>
		</tr>
	@endforeach
</table>