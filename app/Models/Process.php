<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    ];

    public function actions()
    {
        return $this->hasMany(ProcessAction::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'process_user');
    }
}
