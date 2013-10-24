<?php

class NHL_Streaks {

	public $sites = array(
						array(
							'url'		=>'http://www.tsn.ca/fantasy_news/rankings/nhl/',
							'type'		=>'power_rankings',
							'source'	=> 'tsn',
							'callback'	=>'tsn_power_rankings'
						),
						array(
							'url'		=>'http://espn.go.com/nhl/powerrankings',
							'type'		=>'power_rankings',
							'source'	=> 'espn',
							'callback'	=>'espn_power_rankings'
						)

					);
	public $current_season = '2013-2014';
	public $content = array();
	public $last_update;

	/**
	 * Class constructor
	*/
	public function __construct()
	{
		$this->get_content();
	}

	/**
     * magic method : GET
     * @param varchar $property
     */
	public function __get($property)
	{
	    if (property_exists($this, $property)) {
	    	return $this->$property;
	    }
    }

   	/**
     * magic method : SET
     * @param varchar $property
     * @param varchar $value
     */
    public function __set($property, $value)
    {
    	if (property_exists($this, $property)) {
    		$this->$property = $value;
    	}
    }


    /**
	 * update data sources
	 *
	*/
	public function update()
	{
		$this->fetch_content();
		$this->get_content();
	}


	/**
	 * fetch content from some sources
	 *
	 * @return array content read from cache
	*/
	public function get_content()
	{
		foreach($this->sites as $site)
		{
			//get schedule from cache
	    	$file = PATH_CACHE . '/' . md5($site['url']) . '.html';

	    	//cache is expired : update automatically
	    	if( !file_exists($file) || (filemtime($file) + CACHE_EXPIRE) < time())
	    		$this->update();

	    	//load content
	    	if(@file_exists($file)) {
	    		$content = @file_get_contents($file);
				$content = unserialize($content);
				$this->last_update = date('Y-m-d H:i:s', filemtime($file));
	    	}

			//save to object
			$this->content[$site['type']][$site['source']] = $content;
		}

		return $this->content;
	}

	/**
	 * fetch content from some sources
	 *
	*/
	public function fetch_content()
	{

		foreach($this->sites as $site)
		{
			//get schedule from cache
	    	$file = PATH_CACHE . '/' . md5($site['url']) . '.html';

	    	$callback 		= 'callback_' . $site['callback'];
	    	$content 		= $this->$callback($site);
	    	$file_content 	= serialize($content);

	    	//save to cahe
			if (!$handle = fopen($file, 'w+'))
			{
				throw new Exception('Cannot open file ' . $file);
			}
		    if (fwrite($handle, $file_content) === FALSE)
		    {
		        throw new Exception("Cannot write to file ($file)");
		    }
		    $this->last_update = date('Y-m-d H:i:s');
			fclose($handle);
		}
	}

	/**
	 * extract power rankings from TSN
	 *
	 * @param $site Array Contains url, type, source and callback keys
	 * @return array power rankings
	*/
	private function callback_tsn_power_rankings($site)
	{

		$html = file_get_contents($site['url']);
		//clean HTML to exclude useless stuff and improve performance in creating DOM object
    	$dom = str_get_html($html);
    	$out = array(
    			'date'=>date('Y-m-d', strtotime(str_replace('Updated: ', '', $dom->find('#tsnStats .noPad', 0)->plaintext))),
    			'url'=>$site['url'],
    			'content'=>array()
    		);

    	foreach($dom->find('#tsnStats .tsnPowerRankings') as $line)
    	{
    		$tmp = array(
    					'pos_w'=>$line->find('.thisWeekRank', 0)->plaintext,
    					'pos_lw'=>$line->find('.lastWeekRank', 0)->plaintext,
    					'team_name'=>$line->find('.teamName', 0)->plaintext,
    					'team_abbr'=>nhl_team_full_name_to_abbr($line->find('.teamName', 0)->plaintext),
    					'team_record'=>$line->find('.teamRecord', 0)->plaintext,
    					'comments'=>''
    				);
    		$tmp['pos_diff'] = (-1) * ($tmp['pos_w'] - $tmp['pos_lw']);
    		if($tmp['pos_diff'] > 0) $tmp['pos_diff'] = '+' . $tmp['pos_diff'];
    		$out['content'][] = $tmp;
    	}

		return $out;
	}


	/**
	 * extract power rankings from ESPN
	 *
	 * @param $site Array Contains url, type, source and callback keys
	 * @return array power rankings
	*/
	private function callback_espn_power_rankings($site)
	{

		$html = file_get_contents($site['url']);
		//clean HTML to exclude useless stuff and improve performance in creating DOM object
    	$dom = str_get_html($html);
    	$d = explode(',', str_replace('Updated: ', '', $dom->find('.mod-article-title .datehead', 0)->plaintext));
    	$out = array(
    			'date'=>date('Y-m-d', strtotime($d[0].','.$d[1])),
    			'url'=>$site['url'],
    			'content'=>array()
    		);

    	foreach($dom->find('.mod-container .mod-content table tr') as $line)
    	{
    		if($line->class == 'stathead' || $line->class == 'colhead' || $line->class == '') continue;
    		$team_li = @$line->find('td', 1)->plaintext;
    		$team_name = trim(preg_replace('/[0-9]+\-[0-9]+\-[0-9]+/is', '', $team_li));
    		if($team_name == 'New York' && strpos(@$line->find('td', 1)->outertext, 'islanders') > 0) $team_name .= ' Islanders';
    		if($team_name == 'New York' && strpos(@$line->find('td', 1)->outertext, 'rangers') > 0) $team_name .= ' Rangers';
    		$tmp = array(
    					'pos_w'=>@$line->find('.pr-rank', 0)->plaintext,
    					'pos_lw'=>trim(str_replace('Last Week: ', '', @$line->find('.pr-last', 0)->plaintext)),
    					'team_name'=>$team_name,
    					'team_abbr'=>nhl_team_cities_to_abbr($team_name),
    					'team_record'=>@$line->find('.pr-record', 0)->plaintext,
    					'comments'=>@$line->find('td', 3)->plaintext
    				);
    		if($tmp['pos_lw'] == 'NR') $tmp['pos_lw'] = $tmp['pos_w'];
    		$tmp['pos_diff'] = (-1) * ($tmp['pos_w'] - $tmp['pos_lw']);
    		if($tmp['pos_diff'] > 0) $tmp['pos_diff'] = '+' . $tmp['pos_diff'];
    		$out['content'][] = $tmp;
    	}
		return $out;
	}

}