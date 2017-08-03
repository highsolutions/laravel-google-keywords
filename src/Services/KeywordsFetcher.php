<?php 

namespace HighSolutions\GoogleKeywords\Services;

use Carbon\Carbon;
use HighSolutions\GoogleKeywords\Models\GoogleKeyword;
use HighSolutions\GoogleKeywords\Services\Google\GoogleClientFactory;
use HighSolutions\GoogleKeywords\Services\Google\Webmasters;
use HighSolutions\GoogleKeywords\Services\KeywordsSaver;

class KeywordsFetcher
{

	protected $config;

	public function __construct($config)
	{
		$this->config = $config;
	}

	public function fetchAll()
	{
		foreach($this->config['websites'] as $website)
			$this->fetch($website);
	}

	public function fetch($params)
	{
		$factory = new GoogleClientFactory($params);
		$client = $factory->getClient("HighSolutions-Laravel-Google-Keywords", ['https://www.googleapis.com/auth/webmasters.readonly']);
        $webmasters = new Webmasters($client);

        $dates = $this->isFirstTime($params['url']) ? $this->getAllDates() : $this->getYesterdayDates();

        $results = $webmasters->query(array_merge($dates, [
            'url' => $params['url'],
        ]));

        $saver = new KeywordsSaver();
        return $saver->saveResults($params['url'], $results);
	}

	protected function isFirstTime($url)
	{
		return !GoogleKeyword::hasFetchedAnythingFor($url);
	}

	protected function getAllDates()
	{
		return [
			'startDate' => Carbon::yesterday()->subMonth(3),
            'endDate' => Carbon::yesterday(),
		];
	}

	protected function getYesterdayDates()
	{
		return [
			'startDate' => Carbon::yesterday(),
            'endDate' => Carbon::yesterday(),
		];
	}

}