<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'beneficiaria',
        'field',
        'used',
        'created_by'
    ];
}
