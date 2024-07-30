<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabyBOY extends Model
{
    use HasFactory;
    protected $table = 'baby_boy';

    protected $fillable = [
        'num',
        'name',
        'meaning'
    ];
}
