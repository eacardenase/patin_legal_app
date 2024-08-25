<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Process extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_proceso',
        'llave_proceso',
        'es_privado',
        'fecha_proceso',
        'despacho',
        'ponente',
        'sujetos_procesales',
        'tipo_proceso',
        'clase_proceso',
        'subclase_proceso',
        'recurso',
        'ubicacion',
        'contenido_radicacion',
        'ultima_actualizacion',
        'user_id'
    ];

    public function actions()
    {
        return $this->hasMany(ProcessAction::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
