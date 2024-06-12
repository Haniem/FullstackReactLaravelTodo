<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doing extends Model
{
    use HasFactory;

    protected $fillable = [
        'doingname',
        'description',
        'id_type',
        'id_user',
        'state'
    ];
}
