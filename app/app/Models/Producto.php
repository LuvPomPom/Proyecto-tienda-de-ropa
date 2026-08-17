<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto'; // <--- Nombre exacto en Supabase
    protected $primaryKey = 'id_producto'; // <--- ID exacto
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'precio',
        'marca_id',
        'imagen',
        'categoria_id'
    ];
}