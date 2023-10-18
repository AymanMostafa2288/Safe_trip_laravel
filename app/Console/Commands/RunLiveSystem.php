<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class RunLiveSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system-live:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{

            Artisan::call('migrate:fresh --path=/database/migrations/installation --seed');
            Artisan::call('migrate');

            $file    = new Filesystem;
            $Files   = [];
            $Files[] = 'app/Http/Controllers/backend/custom_modules_management';
            $Files[] = 'app/Http/Requests/backend/custom_modules_management';
            $Files[] = 'app/Models/CustomModels';
            $Files[] = 'app/Repositories/Eloquent/custom_modules_management';
            $Files[] = 'app/Repositories/Interfaces/custom_modules_management';
            $Files[] = 'app/Forms/custom_modules_management';
            $Files[] = 'app/Tables/custom_modules_management';
            foreach($Files as $key=>$dir){
                if (! File::exists($dir)) {
                    File::makeDirectory($dir);
                }
            }


            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');




            $this->info('The command was successful!');

        }catch(Exception $e){
            $this->error($e->getMessage());
        }

    }
}
