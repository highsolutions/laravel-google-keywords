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

}