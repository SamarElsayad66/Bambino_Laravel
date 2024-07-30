<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dinner extends Model
{
    use HasFactory;
    protected $table = 'dinner';
    protected $fillable = [
        'name',
        'photo',
        'description',
        'facts',];
}
