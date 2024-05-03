<?php

namespace App\Http\Controllers;

use App\Models\Process;
use App\Services\RamaJudicial\RamaJudicialProcessesService;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Process::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $processData)
    {
        return Process::create($processData);
    }

    /**
     * Display the specified resource.
     */
    public function show(RamaJudicialProcessesService $ramaJudicial, string $processKey)
    {
        if (strlen($processKey) !== 23) {
            return [
                "error" => "Process key must be 23 characters."
            ];
        }

        $process = Process::where('llave_proceso', $processKey)->first();

        if (!$process) {
            $ramaJudicialProcess = $ramaJudicial->getProcess($processKey);

            if (!$ramaJudicialProcess) {
                return [
                    'error' => "Process with key '$processKey' does not exist."
                ];
            }

            $processId = $ramaJudicialProcess['idProceso'];
            $ramaJudicialProcessDetails = $ramaJudicial->getProcessDetails($processId);

            $process = $this->store([
                    'id_proceso' => $processId,
                    'llave_proceso' => $ramaJudicialProcessDetails['llaveProceso'],
                    'es_privado' => $ramaJudicialProcessDetails['esPrivado'],
                    'fecha_proceso' => $ramaJudicialProcessDetails['fechaProceso'],
                    'despacho' => $ramaJudicialProcessDetails['despacho'],
                    'ponente' => $ramaJudicialProcessDetails['ponente'],
                    'sujetos_procesales' => $ramaJudicialProcess['sujetosProcesales'],
                    'tipo_proceso' => $ramaJudicialProcessDetails['tipoProceso'],
                    'clase_proceso' => $ramaJudicialProcessDetails['claseProceso'],
                    'subclase_proceso' => $ramaJudicialProcessDetails['subclaseProceso'],
                    'recurso' => $ramaJudicialProcessDetails['recurso'],
                    'ubicacion' => $ramaJudicialProcessDetails['ubicacion'],
                    'contenido_radicacion' => $ramaJudicialProcessDetails['contenidoRadicacion'],
                    'ultima_actualizacion' => $ramaJudicialProcessDetails['ultimaActualizacion'],
                ]
            );

            $processActions = $ramaJudicial->getProcessActions($processId);

            foreach ($processActions as $action) {
                $process->actions()->create([
                    'id_reg_actuacion' => $action['idRegActuacion'],
                    'consecutivo_actuacion' => $action['consActuacion'],
                    'fecha_actuacion' => $action['fechaActuacion'],
                    'actuacion' => $action['actuacion'],
                    'anotacion' => $action['anotacion'],
                    'fecha_registro' => $action['fechaRegistro'],
                    'con_documentos' => $action['conDocumentos'],
                ]);
            }

            return $process;
        }

        return $process;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Process $process)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Process $process)
    {
        //
    }
}
