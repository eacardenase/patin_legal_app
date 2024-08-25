<?php

namespace App\Http\Controllers;

use App\Models\Process;
use App\Services\RamaJudicial\RamaJudicialProcessesService;
use DateTime;
use Illuminate\Support\Facades\Validator;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("dashboard", [
            'processes' => Process::paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $attributes = $this->validateProcess();

        Process::create($attributes);

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Process $process)
    {
        return view('processes.show', [
            'process' => $process
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Process $process)
    {
        $process->delete();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    protected function validateProcess()
    {
        $validator = Validator::make(request()->all(), [
            'process' => ['required', 'regex:/^\d{23}$/', 'unique:processes,llave_proceso'],
        ]);

        $validated = $validator->validated();
        $processKey = $validated['process'];

        $ramaJudicial = new RamaJudicialProcessesService();
        $ramaJudicialProcess = null;

        $validator->after(function ($validator) use ($processKey, $ramaJudicial, &$ramaJudicialProcess) {
            $ramaJudicialProcess = $ramaJudicial->getProcess($processKey);

            if (!$ramaJudicialProcess) {
                $validator->errors()->add(
                    'process',
                    "Process with key '$processKey' does not exist."
                );
            }
        })->validate();

        $processId = $ramaJudicialProcess['idProceso'];
        $ramaJudicialProcessDetails = $ramaJudicial->getProcessDetails($processId);

        return [
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
            'ultima_actualizacion' => new DateTime($ramaJudicialProcessDetails['ultimaActualizacion']),
        ];
    }
}
