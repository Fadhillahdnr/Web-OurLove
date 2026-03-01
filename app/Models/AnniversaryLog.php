<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnniversaryLog extends Model
{
    protected $fillable = [
        'date',
        'message',
        'month_number'
    ];

    protected $casts = [
        'date' => 'date',
    ];
}