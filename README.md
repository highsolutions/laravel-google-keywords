Laravel Google Keywords
=======================

A Laravel package for synchronizing with Google Search Console to get visitors' search keywords.

![Laravel-Poster by HighSolutions](https://raw.githubusercontent.com/highsolutions/laravel-google-keywords/master/intro.jpg)

Installation
------------

Add the following line to the `require` section of your Laravel webapp's `composer.json` file:

```javascript
    "require": {
        "HighSolutions/GoogleKeywords": "1.*"
    }
```

Run `composer update` to install the package.

Then, update `config/app.php` by adding an entry for the service provider:

```php
'providers' => [
    // ...
    HighSolutions\GoogleKeywords\GoogleKeywordsServiceProvider::class,
];
```

Next, publish all package resources:

```bash
    php artisan vendor:publish --provider="HighSolutions\GoogleKeywords\GoogleKeywordsServiceProvider"
```

This will add to your project:

    - migration - database table for storing keywords
    - configuration - package configurations

Remember to launch migration: 

```bash
    php artisan migrate
```

Next step is to add cron task via Scheduler (`app\Console\Kernel.php`):

```php
    protected function schedule(Schedule $schedule)
    {
    	// ...
        $schedule->command('keywords:fetch')->daily();
    }
```

Configuration
-------------

| Setting name           | Description                       | Default value                                      |
|------------------------|-----------------------------------|----------------------------------------------------|
| websites.*.url         | URL of website (with protocol)    | ''                                                 |
| websites.*.credentials | JSON credentials file on server   | storage_path('app/google-search-credentials.json') |

Websites are defined in configuration as:

```php
<?php

return [
    'websites' => [
    	[
    		'url' => 'http://highsolutions.pl',
    		'credentials' => storage_path('app/HS-Credentials.json'),
    	],
    	// ...
    ],
];
```

Invalid configuration will return information about error.

Google Search Console and Google Cloud Platform integration
--------------------------------------------------

In order to get access to keywords from Google Search you need to complete 2 steps:

1) Google Search Console (https://www.google.com/webmasters/tools/home)
- Add your website
- Verify your ownership of website

2) Google Cloud Platform (https://console.cloud.google.com/apis/credentials)
- Add new project
- Generate server-side API key
- Download JSON credentials (name-of-project-id.json) and store them into `storage/app` folder
- Copy e-mail address of API key (e.g. name-of-key@name-of-package-id.iam.gserviceaccount.com) - available here: https://console.cloud.google.com/iam-admin/serviceaccounts/project?project=PROJECT_NAME-ID
- Assign it as owner of website in Google Search Console

Model structure
---------------

Model consists of fields:
- `id` - primary key
- `url` - URL of website
- `keyword` - full keyword
- `date` - date of result
- `clicks` - number of clicks on link in search view with particular keyword
- `impressions` - number of views of link in search view with particular keyword
- `ctr` - click through rate (clicks / impressions)
- `avg_position` - average position of link on list of results in search view with particular keyword

Model API
---------

To make usage of gathered data easier, there is a simple API for most common use cases:

- `url('http://example.com')` - adds where clause for limiting results to only one website (not necessary when you fetch only one website)
- `grouped()` - prepares sum of clicks and impressions of each keyword gathered for the website
- `byDay()` - prepares sum of clicks and impressions of each day
- `orderByDate($dir = 'asc')` - sorts results by date
- `orderBySum($param = 'clicks')` - sorts results by sum of clicks/impressions (works with `grouped` scope)
- `orderByAlpha($dir = 'asc')` - sorts results alphabetically

Usage
------

1) Get most popular keywords of your website:

```php
<?php
	use HighSolutions\GoogleKeywords\Models\GoogleKeyword;

	$results = GoogleKeyword::url('http://highsolutions.pl')->grouped()->orderBySum('clicks')->take(10)->get();
```

2) Get all keywords stored day by day:

```php
<?php
	use HighSolutions\GoogleKeywords\Models\GoogleKeyword;

	$results = GoogleKeyword::url('http://highsolutions.pl')->orderByDate()->get();
```

3) Get number of clicks/impressions in the last month:

```php
<?php
	use Carbon\Carbon;
	use HighSolutions\GoogleKeywords\Models\GoogleKeyword;

	$results = GoogleKeyword::url('http://highsolutions.pl')->byDate()->where('date', '>=', Carbon::now()->subMonth(1))->orderByDate()->get();
```

Changelog
---------

1.0.1
- Fix error with checking config

1.0.0
- Create package
- Model API

Roadmap
-------

* Gather info about subsites also
* Examples of usage as controllers and views
* Comments
* Unit tests!

Credits
-------

This package is developed by [HighSolutions](http://highsolutions.pl), software house from Poland in love in Laravel.