<?php

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

	switch (get('type')) {
		case 'fixture':
			$link = 'https://api.sportstvrights.com/export/fixture/' . request('league') . '/' . request('round');
			break;

		case 'standings':
			$link = 'https://api.sportstvrights.com/export/standings/' . request('league');
			break;

		case 'lineups':
				$link = 'https://api.sportstvrights.com/export/lineups/' . request('fixture');
			break;

		case 'stats':
				$link = 'https://api.sportstvrights.com/export/stats/' . request('fixture');
			break;

		case 'score':
				$link = 'https://api.sportstvrights.com/export/score/' . request('fixture');
			break;
	}

	return $link;
}
