<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_datetime',
        'end_datetime',
        'poster_image',
        'active',
    ];

    public function getPosterImageAttribute($value)
    {
        if ($value) {
            return url('storage/' . $value);
        }
        return null;
    }
}
