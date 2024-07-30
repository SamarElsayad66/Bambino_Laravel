<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabyGirl extends Model
{
    use HasFactory;
    protected $table = 'baby_girls';

    protected $fillable = [
        'num',
        'name',
        'meaning'];
}
