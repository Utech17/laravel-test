<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudadano extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nacionalidad',
        'cedula',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'sexo',
    ];

    /**
     * Busca un ciudadano por su número de cédula.
     * Es un método estático para que pueda ser llamado directamente desde la clase
     * sin necesidad de crear una instancia. Ej: Ciudadano::findByCedula('123456');
     *
     * @param string $cedula El número de cédula a buscar.
     * @return self|null El modelo del ciudadano si se encuentra, o null si no.
     */
    public static function findByCedula(string $cedula): ?self
    {
        return self::where('cedula', $cedula)->first();
    }

    /**
     * Relación uno a uno con Profile (si existe)
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}