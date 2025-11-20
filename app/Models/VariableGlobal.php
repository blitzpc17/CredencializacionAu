<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariableGlobal extends Model
{
    use HasFactory;

    protected $table = 'variables_globales';

    protected $fillable = [
        'nombre',
        'valor'
    ];

    protected $casts = [
        'valor' => 'string'
    ];

    // Scopes
    public function scopePorNombre($query, $nombre)
    {
        return $query->where('nombre', $nombre);
    }

    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    // Accessors
    public function getValorFormateadoAttribute()
    {
        // Intentar decodificar JSON
        $decoded = json_decode($this->valor, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }
        
        // Si no es JSON, devolver como string
        return $this->valor;
    }

    // Mutators
    public function setValorAttribute($value)
    {
        // Si el valor es un array, convertirlo a JSON
        if (is_array($value)) {
            $this->attributes['valor'] = json_encode($value);
        } else {
            $this->attributes['valor'] = $value;
        }
    }

    // Métodos estáticos para variables comunes
    public static function obtener($nombre, $default = null)
    {
        $variable = static::porNombre($nombre)->first();
        return $variable ? $variable->valor_formateado : $default;
    }

    public static function establecer($nombre, $valor)
    {
        return static::updateOrCreate(
            ['nombre' => $nombre],
            ['valor' => $valor]
        );
    }

    public static function obtenerConfiguracionEmail()
    {
        return [
            'smtp_host' => static::obtener('smtp_host', ''),
            'smtp_port' => static::obtener('smtp_port', '587'),
            'smtp_username' => static::obtener('smtp_username', ''),
            'smtp_password' => static::obtener('smtp_password', ''),
            'email_from' => static::obtener('email_from', ''),
            'email_from_name' => static::obtener('email_from_name', ''),
        ];
    }

    public static function obtenerConfiguracionSistema()
    {
        return [
            'nombre_sistema' => static::obtener('nombre_sistema', 'Sistema de Credencialización'),
            'logo_url' => static::obtener('logo_url', ''),
            'tiempo_sesion' => static::obtener('tiempo_sesion', '120'),
            'registro_abierto' => static::obtener('registro_abierto', 'true'),
        ];
    }
}