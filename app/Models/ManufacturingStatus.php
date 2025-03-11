<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturingStatus extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'mfg_stat_name',
    ];
}
