<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Supabase espera la tabla en plural (o el nombre exacto de la BD)
    protected $table = 'productos'; 

    // Indicamos que la clave primaria es id_producto y no 'id'
    protected $primaryKey = 'id_producto';

    // Campos permitidos para inserción masiva desde el Admin Panel
    protected $fillable = [
        'nombre',
        'precio',
        'stock',
        'marca_id', // O 'id_marca' según tu migración
        'categoria_id',
        'imagen',
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id', 'id');
    }
}