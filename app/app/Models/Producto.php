<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Nombre tabla
    protected $table = 'productos';
    public $timestamps = false;

    // id
    protected $primaryKey = 'id_producto';

    // Columnas
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