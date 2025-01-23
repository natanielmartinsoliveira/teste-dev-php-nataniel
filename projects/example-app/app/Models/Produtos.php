<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'validade',
        'arquivo'
    ];

    protected $casts = [
        'validade'  => 'date:Y-m-d H:00'
    ];

    /*public function categoria() {
        return $this->belongsTo(Categorias::class, 'categoria_id', 'id');
    }*/

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhereRaw('LOWER(nome) COLLATE utf8mb4_unicode_ci LIKE ?', '%'.mb_strtolower($search).'%')
                ->orWhereRaw('LOWER(descricao) COLLATE utf8mb4_unicode_ci LIKE ?', '%'.mb_strtolower($search).'%');
        ;
    }
}
