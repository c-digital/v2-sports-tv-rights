<?php

function linkToCopy()
{
	$link = '';

	switch (get('type')) {
		case 'fixture':
			$link = 'https://api.sportstvrights.com/export/fixture/' . request('fixture');
			break;
	}

	return $link;
}
