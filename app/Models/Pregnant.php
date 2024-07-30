<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregnant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_day_of_last_period',
        'due_date',
        'date_of_conception',
        'age_by_week',
    ];

    /**
     * The user that the pregnant record belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
