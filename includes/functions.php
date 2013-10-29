<?php

if( !function_exists('nhl_team_full_name_to_abbr'))
{
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
			'florida panthers' => 'flo',

			'la kings'=>'la',
			'st.louis blues'=>'stl'
			);
		return $teams[strtolower(trim($team))];
	}
}

if( !function_exists('nhl_team_cities_to_abbr'))
{
	function nhl_team_cities_to_abbr($team)
	{
		$teams = array(
			'chicago' => 'chi',
			'pittsburgh' => 'pit',
			'los angeles'	=> 'la',
			'boston' => 'bos',
			'st. louis' => 'stl',
			'ottawa' => 'ott',
			'detroit' => 'det',
			'washington' => 'was',
			'san jose' => 'sj',
			'montreal' => 'mon',
			'minnesota' => 'min',
			'vancouver' => 'van',
			'philadelphia' => 'phi',
			'new york rangers' => 'nyr',
			'anaheim' => 'ana',
			'toronto' => 'tor',
			'new york islanders' => 'nyi',
			'columbus' => 'clb',
			'calgary' => 'cgy',
			'dallas' => 'dal',
			'tampa bay' => 'tb',
			'carolina' => 'car',
			'winnipeg' => 'win',
			'phoenix' => 'phx',
			'new jersey' => 'njd',
			'edmonton' => 'edm',
			'colorado' => 'col',
			'nashville' => 'nas',
			'buffalo' => 'buf',
			'florida' => 'flo'
			);
		return $teams[strtolower(trim($team))];
	}
}

if( !function_exists('nhl_teams_abbr_array'))
{
	function nhl_teams_abbr_array()
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
		$teams = array_flip($teams);
		$teams =array_map('ucwords', $teams);
		asort($teams);
		return $teams;
	}
}

if( !function_exists('cbs_match_abbr'))
{
	function cbs_match_abbr($abbr)
	{
		if($abbr == 'pho') $abbr = 'phx';
		if($abbr == 'nsh') $abbr = 'nas';
		if($abbr == 'wpg') $abbr = 'win';
		if($abbr == 'fla') $abbr = 'flo';
		if($abbr == 'nj') $abbr = 'njd';
		return $abbr;
	}
}

if( !function_exists('oddsshark_match_city'))
{
	function oddsshark_match_city($city)
	{
		if($city == 'NY Rangers') $city = 'new york rangers';
		if($city == 'NY Islanders') $city = 'new york islanders';
		return $city;
	}
}


if( !function_exists('diff_class_color'))
{
	function diff_class_color($diff)
	{
		$class = "neutral";
		if($diff > 0) $class = "up";
		if($diff < 0) $class = "down";
		return $class;
	}
}