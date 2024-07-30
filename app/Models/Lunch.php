<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lunch extends Model
{
    use HasFactory;
    protected $table = 'lunch';
    protected $fillable = [
        'name',
        'photo',
        'description',
        'facts',
        
    ];
}
