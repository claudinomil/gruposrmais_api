<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdificacaoNivel extends Model
{
    use HasFactory;

    protected $table = 'edificacoes_niveis';

    protected $fillable = [
        'edificacao_id',
        'ordem',
        'nivel',
        'name',
        'area_construida'
    ];

    public function setAreaConstruidaAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['area_construida'] = $value;
        } else {
            $this->attributes['area_construida'] = 0;
        }
    }
}
