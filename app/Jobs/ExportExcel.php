<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Exports\DataExport;
use Maatwebsite\Excel\Facades\Excel;


class ExportExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $interfaces;
    public $filters;
    public $table;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($interfaces,$filters)
    {
        $this->interfaces = $interfaces;
        $this->filters = $filters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ob_end_clean();
        return Excel::download(new DataExport($this->interfaces,$this->filters), 'users.xlsx');
    }
}
