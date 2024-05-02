<?php

namespace App\Http\Controllers;

use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $processKey)
    {
        if (strlen($processKey) !== 23) {
            return [
                "error" => "Process key must be 23 characters."
            ];
        }

        $process = Process::where('llave_proceso', $processKey)->first();

        if (!$process) {
            $processResponse = Http::get('https://consultaprocesos.ramajudicial.gov.co:448/api/v2/Procesos/Consulta/NumeroRadicacion', [
                'numero' => $processKey,
                'SoloActivos' => 'false',
            ]);

            $processResponseJson = $processResponse->json();

            if (count($processResponseJson['procesos']) === 0) {
                return [
                    'error' => "Process with key '$processKey' does not exist."
                ];
            }

            $processFound = $processResponseJson['procesos'][0];
            $processId = $processFound['idProceso'];

            $processDetailsResponse = Http::get("https://consultaprocesos.ramajudicial.gov.co:448/api/v2/Proceso/Detalle/$processId");
            $processDetailsJson = $processDetailsResponse->json();

            $process = Process::create([
                'id_proceso' => $processId,
                'llave_proceso' => $processDetailsJson['llaveProceso'],
                'es_privado' => $processDetailsJson['esPrivado'],
                'fecha_proceso' => $processDetailsJson['fechaProceso'],
                'despacho' => $processDetailsJson['despacho'],
                'ponente' => $processDetailsJson['ponente'],
                'sujetos_procesales' => $processFound['sujetosProcesales'],
                'tipo_proceso' => $processDetailsJson['tipoProceso'],
                'clase_proceso' => $processDetailsJson['claseProceso'],
                'subclase_proceso' => $processDetailsJson['subclaseProceso'],
                'recurso' => $processDetailsJson['recurso'],
                'ubicacion' => $processDetailsJson['ubicacion'],
                'contenido_radicacion' => $processDetailsJson['contenidoRadicacion'],
                'ultima_actualizacion' => $processDetailsJson['ultimaActualizacion'],
            ]);

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
