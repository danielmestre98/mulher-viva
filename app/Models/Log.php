<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'targeted_table',
        'action',
        'comment',
        'target_id',
        'new_data',
        'old_data'
    ];
}
