<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemaPreventivo extends Model
{
    use HasFactory;

    protected $table = 'sistemas_preventivos';

    protected $fillable = [
        'medida_seguranca_id',
        'name'
    ];

    public function medidaSeguranca()
    {
        return $this->belongsTo(MedidaSeguranca::class);
    }

    public function equipamentos()
    {
        return $this->hasMany(SistemaPreventivoEquipamento::class, 'sistema_preventivo_id');
    }
}
