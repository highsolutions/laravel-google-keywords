<?php 

namespace HighSolutions\GoogleKeywords\Services\Google;

use Google_Client;

class GoogleClientFactory
{

	protected $config;

	public function __construct($config)
	{
		$this->config = $config;
	}

	public function getClient($appName, $scopes)
	{		
        $client = new Google_Client();
        $client->setAuthConfig($this->config['credentials']);
        $client->setApplicationName($appName);
        $client->setScopes($scopes);

        return $client;
	}

}