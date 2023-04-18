<?php

function queryString()
{
	$queryString = [];

	foreach ($_GET as $key => $value) {
		$queryString[] = "$key=$value";
	}

	$queryString = implode('&', $queryString);

	return $queryString;
}

function formatName($name)
{
	if ($name == '') {
		return $name;
	}

	$array = explode(' ', $name);

	if (isset($array[3])) {
		return $array[0] . ' ' . $array[2];
	}

	return $array[0] . ' ' . $array[1];
}

function statTrans($key)
{
	$array = require 'resources/lang/es/stats.php';
	
	if (isset($array[$key]) && $array[$key] != '') {
		return $array[$key];
	}

	return $key;
}

function token()
{
	$token = file_get_contents('https://api-v2.sportstvrights.com/token.txt');
	return $token;
}

function type($type)
{
	switch ($type) {
		case 'Main':
			$type = 'Árbitro';
			break;

		case 'Lineman 1':
			$type = '1er asistente';
			break;

		case 'Lineman 2':
			$type = '2do asistente';
			break;

		case 'Fourth official':
			$type = '4to arbitro';
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
