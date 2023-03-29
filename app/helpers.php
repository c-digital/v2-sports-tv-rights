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
			$link = 'https://api-v2.sportstvrights.com/export/fixture/' . request('league') . '/' . request('round');
			break;

		case 'standings':
			$link = 'https://api-v2.sportstvrights.com/export/standings/' . request('league');
			break;

		case 'lineups':
				$link = 'https://api-v2.sportstvrights.com/export/lineups/' . request('fixture');
			break;

		case 'stats':
				$link = 'https://api-v2.sportstvrights.com/export/stats/' . request('fixture');
			break;

		case 'score':
				$link = 'https://api-v2.sportstvrights.com/export/score/' . request('fixture');
			break;
	}

	if (get('bolivia')) {
		$link = $link . '?bolivia=1';
	}

	return $link;
}
