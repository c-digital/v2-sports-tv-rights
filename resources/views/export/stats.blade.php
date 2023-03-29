<style>
	table, tr, td, th {
		border: 1px solid black;
		border-collapse: collapse;
	}

	.right {
		text-align: right;
	}

	.center {
		text-align: center;
	}
</style>

<table>
	<tr>
		<th class="right">{{ $local }}</th>
		<th></th>
		<th>{{ $away }}</th>
	</tr>

    <tr>
    	<td class="right">{{ $data[$local]['corners'] }}</td>
    	<td class="center">Corners</td>
    	<td>{{ $data[$away]['corners'] }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['shots'] }}</td>
    	<td class="center">Tiros</td>
    	<td>{{ $data[$away]['shots'] }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['fouls'] }}</td>
    	<td class="center">Faltas</td>
    	<td>{{ $data[$away]['fouls'] }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['offside'] }}</td>
    	<td class="center">Offside</td>
    	<td>{{ $data[$away]['offside'] }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['possession'] }}</td>
    	<td class="center">Posesion</td>
    	<td>{{ $data[$away]['possession'] }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['yellows'] }}</td>
    	<td class="center">Amarillas</td>
    	<td>{{ $data[$away]['yellows'] }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['reds'] ?? 0 }}</td>
    	<td class="center">Rojas</td>
    	<td>{{ $data[$away]['reds'] ?? 0 }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['expected_goals'] ?? 0 }}</td>
    	<td class="center">Goles esperados</td>
    	<td>{{ $data[$away]['expected_goals'] ?? 0 }}</td>
    </tr>
</table>