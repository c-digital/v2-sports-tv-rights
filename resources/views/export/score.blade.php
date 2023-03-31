<style>
	table, tr, td, th {
		border: 1px solid black;
		border-collapse: collapse;
	}

	th {
		font-weight: bold;
		text-align: left;
	}

	img {
		width: 30px;
	}
</style>

<table>
	<tr>
		<td>
			@if($data['local']['logo'])
				<img src="{{ $data['local']['logo'] }}" alt="{{ $data['local']['team'] }}">
			@endif
		</td>

		<td>{{ $data['local']['team'] }}</td>

		<td>{{ goal($data['goals'], $data['local']['team']) }}</td>

		<td>{{ goal($data['goals'], $data['away']['team']) }}</td>

		<td>{{ $data['away']['team'] }}</td>

		<td>
			@if($data['away']['logo'])
				<img src="{{ $data['away']['logo'] }}" alt="{{ $data['away']['team'] }}">
			@endif
		</td>
	</tr>

	@foreach($data['goals'] as $goal)
		@if ($goal['team'] == $data['local']['team'])
			<tr>
				<td>{{ $goal['time'] }}</td>
				<td>{{ $goal['player'] }}</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		@else
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>{{ $goal['player'] }} {{ $goal['detail'] == 'Own Goal' ? '(GEC)' : '' }}</td>
				<td>{{ $goal['time'] }}</td>
			</tr>
		@endif
	@endforeach
</table>