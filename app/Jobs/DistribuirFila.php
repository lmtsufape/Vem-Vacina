<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\FilaController;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Log\Logger;

class DistribuirFila implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        \Log::info("construct");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FilaController $fila)
    {
        \Log::info("handle");
        $fila->distribuirVacina();

        \Log::info("Dristribuido");
    }

    public function failed()
    {

    }
}
