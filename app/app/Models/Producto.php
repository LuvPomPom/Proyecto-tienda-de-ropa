<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Nombre de la tabla en Supabase
    protected $table = 'productos'; 

    // Clave primaria de la tabla
    protected $primaryKey = 'id_producto';

    // Campos permitidos para inserción masiva
    protected $fillable = [
        'nombre',
        'precio',
        'stock',
        'categoria_id',
        'imagen',
    ];

    // Relación con la tabla Categorías
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }
}