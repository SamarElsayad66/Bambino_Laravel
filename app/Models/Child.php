<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $table = 'children';

    protected $fillable = [
       ' id',
        'baby_name',
        'gender',
        'date_of_birth',
    ];

//    public static function create(array $array)
//    {
//    }


}
