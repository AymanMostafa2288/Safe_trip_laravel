<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Filesystem\Filesystem;

class RunSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:run';

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

            $file = new Filesystem;
            $Files=[];
            $Files[]='app/Enum/Custom';
            $Files[]='app/Http/Controllers/backend/custom_modules_management';
            $Files[]='app/Http/Requests/backend/custom_modules_management';
            $Files[]='app/Models/CustomModels';
            $Files[]='app/Repositories/Eloquent/custom_modules_management';
            $Files[]='app/Repositories/Interfaces/custom_modules_management';
            $Files[]='app/Forms/custom_modules_management';
            $Files[]='app/Tables/custom_modules_management';
            foreach($Files as $key=>$dir){
                $file->cleanDirectory($dir);
            }
            Artisan::call('key:generate');

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
