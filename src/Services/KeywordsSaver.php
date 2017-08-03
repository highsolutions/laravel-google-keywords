<?php 

namespace HighSolutions\GoogleKeywords\Services;

use Carbon\Carbon;
use HighSolutions\GoogleKeywords\Models\GoogleKeyword;
use Illuminate\Database\QueryException;

class KeywordsSaver
{

	public function saveResults($url, $results)
	{
		try {				
			foreach($results as $result) {
				GoogleKeyword::create([
					'url' => $url,
					'keyword' => $this->getKeyword($result),
					'date' => $this->getDate($result),
					'clicks' => $result->clicks,
					'impressions' => $result->impressions,
					'ctr' => $result->ctr,
					'avg_position' => $result->position,
				]);
			}
		} catch (QueryException $e) {

		}
	}

	protected function getKeyword($result)
	{
		return $result->keys[0];
	}

	protected function getDate($result)
	{
		return $result->keys[1];
	}

}