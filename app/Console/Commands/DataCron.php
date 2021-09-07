<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DataSynchronizationController;

class DataCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Data cron job command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {	
		$this->info("Memulai data cron.");
		$jamSepi = [23, 24, 0, 1, 2, 3, 4];
		$h = date('H');
		if (in_array($h, $jamSepi)){
			$this->info(DataSynchronizationController::updateLMBDetail());
		}
		$this->info("Data Cron selesai.");
        return 0;
    }
}
