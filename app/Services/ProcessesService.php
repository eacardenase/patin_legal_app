<?php

namespace App\Services;

interface ProcessesService
{
    public function getProcess(string $processId);

    public function getProcessDetails(string $processId);
}
