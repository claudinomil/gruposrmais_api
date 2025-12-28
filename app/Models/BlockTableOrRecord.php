<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockTableOrRecord extends Model
{
    use HasFactory;

    protected $table = 'block_table_or_record';

    protected $fillable = [
        'tabela',
        'tabela_id',
        'user_id',
        'session_hash',
        'locked_at'
    ];

    protected $dates = ['locked_at'];
}
