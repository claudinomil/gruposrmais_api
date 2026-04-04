<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemaPreventivoEquipamento extends Model
{
    use HasFactory;

    protected $table = 'sistemas_preventivos_equipamentos';

    protected $fillable = [
        'sistema_preventivo_id',
        'equipamento_preventivo_id',
        'equipamento_preventivo_item',
        'equipamento_preventivo_nome',
        'equipamento_preventivo_quantidade'
    ];

    public function equipamento()
    {
        return $this->belongsTo(EquipamentoPreventivo::class, 'equipamento_preventivo_id');
    }
}
