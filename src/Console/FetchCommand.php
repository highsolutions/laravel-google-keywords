<?php 

namespace HighSolutions\GoogleKeywords\Console;

use Illuminate\Console\Command;

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
        $this->info("Command executed.");
    }

}
