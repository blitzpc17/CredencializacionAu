<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellidos',
        'usuario', // Este será nuestro campo de login
        'password',
        'perfilesId',
        'activo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Sobrescribir el método para usar 'usuario' en lugar de 'email'
     */
    public function getAuthIdentifierName()
    {
        return 'usuario';
    }

    /**
     * Sobrescribir para encontrar por usuario
     */
    public function getAuthIdentifier()
    {
        return $this->usuario;
    }

    // Relación con el perfil
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'perfilesId');
    }

    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    // Scope para usuarios activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Mutator para encriptar password
    /*public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }*/
}