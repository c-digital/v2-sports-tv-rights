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
    	<td class="right">{{ $data[$local]['corners'] ?? 0 }}</td>
    	<td class="center">Corners</td>
    	<td>{{ $data[$away]['corners'] ?? 0 }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['shots'] ?? 0 }}</td>
    	<td class="center">Tiros</td>
    	<td>{{ $data[$away]['shots'] ?? 0 }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['shots_on_goal'] ?? 0 }}</td>
    	<td class="center">Tiros a puerta</td>
    	<td>{{ $data[$away]['shots_on_goal'] ?? 0 }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['fouls'] ?? 0 }}</td>
    	<td class="center">Faltas</td>
    	<td>{{ $data[$away]['fouls'] ?? 0 }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['offside'] ?? 0 }}</td>
    	<td class="center">Offside</td>
    	<td>{{ $data[$away]['offside'] ?? 0 }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['possession'] ?? 0 }}</td>
    	<td class="center">Posesion</td>
    	<td>{{ $data[$away]['possession'] ?? 0 }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['yellows'] ?? 0 }}</td>
    	<td class="center">Amarillas</td>
    	<td>{{ $data[$away]['yellows'] ?? 0 }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['reds'] ?? 0 }}</td>
    	<td class="center">Rojas</td>
    	<td>{{ $data[$away]['reds'] ?? 0 }}</td>
    </tr>

    <tr>
    	<td class="right">{{ isset($data[$local]['expected_goals']) ? number_format($data[$local]['expected_goals'], 2) : 0 }}</td>
    	<td class="center">Goles esperados</td>
    	<td>{{ isset($data[$away]['expected_goals']) ? number_format($data[$away]['expected_goals'], 2) : 0 }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['passes'] ?? 0 }}</td>
    	<td class="center">Pases</td>
    	<td>{{ $data[$away]['passes'] ?? 0 }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['successfulPasses'] ?? 0 }}</td>
    	<td class="center">Pases acertados</td>
    	<td>{{ $data[$away]['successfulPasses'] ?? 0 }}</td>
    </tr>

    <tr>
    	<td class="right">{{ $data[$local]['passesLastThird'] ?? 0 }}</td>
    	<td class="center">Pases en el último tercio</td>
    	<td>{{ $data[$away]['passesLastThird'] ?? 0 }}</td>
    </tr>

    <tr>
        <td class="right">{{ $data[$local]['second_yellow'] ?? 0 }}</td>
        <td class="center">Segundas amarillas</td>
        <td>{{ $data[$away]['second_yellow'] ?? 0 }}</td>
    </tr>

    <tr>
        <td class="right">{{ $data[$local]['precision'] ?? 0 }}</td>
        <td class="center">Precisión %</td>
        <td>{{ $data[$away]['precision'] ?? 0 }}</td>
    </tr>
</table>