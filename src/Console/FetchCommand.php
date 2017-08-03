<?php

namespace HighSolutions\GoogleKeywords\Console;

use Illuminate\Console\Command;
use HighSolutions\GoogleKeywords\Services\KeywordsFetcher;

class FetchCommand extends Command 
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'keywords:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Google Keywords from last day.';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $fetcher = new KeywordsFetcher(\Config::get('laravel-google-keywords'));
        $fetcher->fetchAll();

        $this->info("Command executed.");
    }

}
