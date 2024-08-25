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
        $user = auth()->user();
        $processes = $user->processes()->paginate(10);

        return view("dashboard", [
            'processes' => $processes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $attributes = $this->validateProcess();

        $process = Process::where('id_proceso', $attributes['id_proceso'])->first();

        if (!$process) {
            $process = Process::create($attributes);
        }

        $user = auth()->user();
        $user->processes()->attach($process->id);

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
        $user = auth()->user();

        $user->processes()->detach($process->id);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    protected function validateProcess()
    {
        $validator = Validator::make(request()->all(), [
            'process' => [
                'required',
                'regex:/^\d{23}$/',
                function ($attribute, $value, $fail) {
                    $userId = auth()->id();

                    // Query the processes table, joined with the process_user table, to check if the same 'llave_proceso' exists for this user
                    $existingProcess = Process::where('llave_proceso', $value)
                        ->whereHas('users', function ($query) use ($userId) {
                            $query->where('user_id', $userId);
                        })
                        ->exists();

                    if ($existingProcess) {
                        $fail("You already have stored this process.");
                    }
                },
            ],
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
