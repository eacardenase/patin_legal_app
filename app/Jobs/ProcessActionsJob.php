<?php

namespace App\Jobs;

use App\Models\Process;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\RamaJudicial\RamaJudicialProcessesService;

class ProcessActionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Process $process)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ramaJudicial = new RamaJudicialProcessesService();
        $processActions = $ramaJudicial->getProcessActions($this->process->id_proceso);

        foreach ($processActions as $action) {
            $this->process->actions()->create([
                'id_reg_actuacion' => $action['idRegActuacion'],
                'consecutivo_actuacion' => $action['consActuacion'],
                'fecha_actuacion' => $action['fechaActuacion'],
                'actuacion' => $action['actuacion'],
                'anotacion' => $action['anotacion'],
                'fecha_registro' => $action['fechaRegistro'],
                'con_documentos' => $action['conDocumentos'],
            ]);
        }
    }
}
