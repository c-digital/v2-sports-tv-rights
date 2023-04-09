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

	@foreach($data->stat as $stat)
		<tr>
			<th class="left">{{ statTrans($stat->type) }}</th>
			<td>{{ $stat->value }}</td>
		</tr>
	@endforeach
</table>