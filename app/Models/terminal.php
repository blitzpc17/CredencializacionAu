<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'terminales';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'baja',
        'latitud',
        'longitud'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'baja' => 'boolean',      
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * Scope para búsqueda por proximidad
     */
    public function scopeCercanos($query, $latitud, $longitud, $radioKm = 10)
    {
        return $query->selectRaw(
            '*, (6371 * acos(cos(radians(?)) * cos(radians(latitud)) * cos(radians(longitud) - radians(?)) + sin(radians(?)) * sin(radians(latitud)))) AS distancia',
            [$latitud, $longitud, $latitud]
        )->having('distancia', '<', $radioKm)
         ->orderBy('distancia');
    }

    /**
     * Accessor para coordenadas formateadas
     */
    public function getCoordenadasAttribute()
    {
        return "{$this->latitud}, {$this->longitud}";
    }

    public function Solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'terminalesId');
    }


}