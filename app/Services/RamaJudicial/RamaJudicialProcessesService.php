<?php

namespace App\Services\RamaJudicial;

use App\Services\ProcessesService;
use Illuminate\Support\Facades\Http;

class RamaJudicialProcessesService implements ProcessesService
{
    protected string $url = 'https://consultaprocesos.ramajudicial.gov.co:448/api/v2';

    public function getProcess(string $processKey)
    {
        $processResponse = Http::get("$this->url/Procesos/Consulta/NumeroRadicacion", [
            'numero' => $processKey,
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
        $processDetailsResponse = Http::get("$this->url/Proceso/Detalle/$processId");
        return $processDetailsResponse->json();
    }

    public function getProcessActions(string $processId)
    {
        $processActions = [];
        $pageNumber = 1;

        $processActionsResponse = Http::get("$this->url/Proceso/Actuaciones/$processId?pagina=$pageNumber");
        $processActionsJson = $processActionsResponse->json();

        $pagesCount = $processActionsJson['paginacion']['cantidadPaginas'] ?? 10;
        $actuaciones = $processActionsJson['actuaciones'];

        $processActions = array_merge($processActions, $actuaciones);

        while ($pageNumber < $pagesCount) {
            $pageNumber++;

            $processActionsResponse = Http::get("$this->url/Proceso/Actuaciones/$processId?pagina=$pageNumber");
            $processActionsJson = $processActionsResponse->json();

            $actuaciones = $processActionsJson['actuaciones'];

            foreach ($actuaciones as $actuacion) {
                $processActions[] = $actuacion;
            }
        }

        return $processActions;
    }
}
