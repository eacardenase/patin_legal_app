<?php

namespace App\Services\RamaJudicial;

use App\Services\ProcessesService;
use Illuminate\Support\Facades\Http;

class RamaJudicialProcessesService implements ProcessesService
{

    public function getProcess(string $processId)
    {
        $processResponse = Http::get('https://consultaprocesos.ramajudicial.gov.co:448/api/v2/Procesos/Consulta/NumeroRadicacion', [
            'numero' => $processId,
            'SoloActivos' => 'false',
        ]);

        $processResponseJson = $processResponse->json();

        if (count($processResponseJson['procesos']) === 0) {
            return null;
        }

        return $processResponseJson['procesos'][0];
    }

    public function getProcessDetails(string $processId)
    {
        $processDetailsResponse = Http::get("https://consultaprocesos.ramajudicial.gov.co:448/api/v2/Proceso/Detalle/$processId");
        return $processDetailsResponse->json();
    }
}
