<?php

function nhl_team_full_name_to_abbr($team)
{
	$teams = array(
		'chicago blackhawks' => 'chi',
		'pittsburgh penguins' => 'pit',
		'los angeles kings'	=> 'la',
		'boston bruins' => 'bos',
		'st. louis blues' => 'stl',
		'ottawa senators' => 'ott',
		'detroit red wings' => 'det',
		'washington capitals' => 'was',
		'san jose sharks' => 'sj',
		'montreal canadiens' => 'mon',
		'minnesota wild' => 'min',
		'vancouver canucks' => 'van',
		'philadelphia flyers' => 'phi',
		'new york rangers' => 'nyr',
		'anaheim ducks' => 'ana',
		'toronto maple leafs' => 'tor',
		'new york islanders' => 'nyi',
		'columbus blue jackets' => 'clb',
		'calgary flames' => 'cgy',
		'dallas stars' => 'dal',
		'tampa bay lightning' => 'tb',
		'carolina hurricanes' => 'car',
		'winnipeg jets' => 'win',
		'phoenix coyotes' => 'phx',
		'new jersey devils' => 'njd',
		'edmonton oilers' => 'edm',
		'colorado avalanche' => 'col',
		'nashville predators' => 'nas',
		'buffalo sabres' => 'buf',
		'florida panthers' => 'flo'
		);
	return $teams[strtolower(trim($team))];
}