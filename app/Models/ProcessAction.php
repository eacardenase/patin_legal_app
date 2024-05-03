<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'process_id',
        'id_reg_actuacion',
        'consecutivo_actuacion',
        'fecha_actuacion',
        'actuacion',
        'anotacion',
        'fecha_registro',
        'con_documentos',
    ];

    public function process()
    {
        return $this->belongsTo(Process::class);
    }
}
