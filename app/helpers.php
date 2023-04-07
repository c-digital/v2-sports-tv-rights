<?php

function token()
{
	$token = file_get_contents('https://api-v2.sportstvrights.com/token.txt');
	return $token;
}

function type($type)
{
	return $type;

	switch ($type) {
		case 'Main':
			$type = 'Principal';
			break;

		case 'Lineman 1':
			$type = 'Línea 1';
			break;

		case 'Lineman 2':
			$type = 'Línea 2';
			break;

		case 'Fourth official':
			$type = 'Cuarto arbitro';
			break;
	}

	return $type;
}

function goal($goals, $team)
{
	$i = 0;

	foreach ($goals as $goal) {
		if ($goal['team'] == $team) {
			$i++;
		}
	}

	return $i;
}

function linkToCopy()
{
	$link = '';

	$url = server('protocol') . '://' . server('host');

	switch (get('type')) {
		case 'fixture':
			$link = $url . '/export/fixture/' . request('league') . '/' . request('round');
			break;

		case 'standings':
			$link = $url . '/export/standings/' . request('league');
			break;

		case 'lineups':
				$link = $url . '/export/lineups/' . request('fixture');
			break;

		case 'stats':
				$link = $url . '/export/stats/' . request('fixture');
			break;

		case 'score':
				$link = $url . '/export/score/' . request('fixture');
			break;

		case 'referees':
				$link = $url . '/export/referees/' . request('fixture');
			break;

		case 'playerStats':
				$link = $url . '/export/playerStats/' . request('fixture') . '/' . request('player');
			break;
	}

	if (get('bolivia')) {
		$link = $link . '?bolivia=1';
	}

	return $link;
}
