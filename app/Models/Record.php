<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $fillable = [
        'seat',
        'member_ID',
        'member_amount',
        'order',
        'order_amount',
        'total',
        'paid',
        'online',
        'debt',
        'created_date',
        'modified_date',
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'modified_date' => 'datetime',
    ];
}
