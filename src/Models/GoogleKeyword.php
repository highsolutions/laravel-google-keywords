<?php

namespace HighSolutions\GoogleKeywords\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleKeyword extends Model
{

	protected $table = 'lgk_keywords';

	protected $dates = ['date'];

	protected $guarded = [];

	public static function hasFetchedAnythingFor($url)
	{
		return static::where('url', $url)->count() > 0;
	}

	public function scopeUrl($query, $url)
	{
		return $query->where('url', $url);
	}

	public function scopeGrouped($query)
	{
		return $query->select('url', 'keyword', \DB::raw('sum(clicks) as sum_clicks'), \DB::raw('sum(impressions) as sum_impressions'))
			->groupBy(['url', 'keyword']);
	}

	public function scopeByDate($query)
	{
		return $query->select('url', 'date', \DB::raw('sum(clicks) as sum_clicks'), \DB::raw('sum(impressions) as sum_impressions'))
			->groupBy(['url', 'date']);
	}

	public function scopeOrderByDate($query, $dir = 'asc')
	{
		return $query->orderBy('date', $dir);
	}

	public function scopeOrderBySum($query, $field = 'clicks')
	{
		return $query->orderBy('sum_'. $field, 'desc')
			->orderBy('sum_'. ($field == 'clicks' ? 'impressions' : 'clicks'), 'desc');
	}

	public function scopeOrderByAlpha($query, $dir = 'asc')
	{
		return $query->orderBy('keyword', $dir);
	}

}