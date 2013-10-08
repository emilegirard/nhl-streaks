<?php

class NHL_Streaks {

	public $sites = array(
						array(
							'url'		=>'http://www.tsn.ca/fantasy_news/rankings/nhl/',
							'type'		=>'power_rankings',
							'source'	=> 'tsn',
							'callback'	=>'tsn_power_rankings'
						)
					);
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

	    	//cache is expired
	    	if( !file_exists($file) || (filemtime($file) + CACHE_EXPIRE) < time())
	    	{
		    	$html 			= file_get_contents($site['url']);
		    	$callback 		= 'callback_' . $site['callback'];
		    	$content 		= $this->$callback($html);
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

			//load from cache
			} else
			{
				$content = @file_get_contents($file);
				$content = unserialize($content);
				$this->last_update = date('Y-m-d H:i:s', filemtime($file));
			}

			//save to object
			$this->content[$site['type']][$site['source']] = $content;
		}
	}

	/**
	 * extract power rankings from TSN
	 *
	 * @param $html html content from TSN's url
	 * @return array power rankings
	*/
	private function callback_tsn_power_rankings($html)
	{
		//clean HTML to exclude useless stuff and improve performance in creating DOM object
    	$dom = str_get_html($html);
    	$out = array('date'=>date('Y-m-d', strtotime(str_replace('Updated: ', '', $dom->find('#tsnStats .noPad', 0)->plaintext))), 'content'=>array());

    	foreach($dom->find('#tsnStats .tsnPowerRankings') as $line)
    	{
    		$tmp = array(
    					'pos_w'=>$line->find('.thisWeekRank', 0)->plaintext,
    					'pos_lw'=>$line->find('.lastWeekRank', 0)->plaintext,
    					'team_name'=>$line->find('.teamName', 0)->plaintext,
    					'team_abbr'=>nhl_team_full_name_to_abbr($line->find('.teamName', 0)->plaintext),
    					'team_record'=>$line->find('.teamRecord', 0)->plaintext
    				);
    		$tmp['pos_diff'] = $tmp['pos_w'] - $tmp['pos_lw'];
    		if($tmp['pos_diff'] > 0) $tmp['pos_diff'] = '+' . $tmp['pos_diff'];
    		$out['content'][] = $tmp;
    	}

		return $out;
	}

}