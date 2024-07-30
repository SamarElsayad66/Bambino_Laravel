<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mom extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'baby_name', 'date_of_birth', 'gender'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
