<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregnancy extends Model
{
    use HasFactory;
    protected $table = 'pregnancy';
    protected $primaryKey = 'week';
    protected $fillable = [
        'week',
        'length',
        'weight',
        'hCG norms',
        'Heart_rate',
        'Title1',
        'Description1',
        'Title2',
        'Description2',
        'Title3',
        'Description3',
        'Title4',
        'Description4',
        'Fruits_and_Veggies',
        'Fruits_and_Veggies_photo',
        'baby_photo',
        'youtupe_vedio'];
}
