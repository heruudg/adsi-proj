<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkCenter extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'work_center_id';
    
    protected $fillable = [
        'work_ctr_name',
        'work_ctr_desc',
    ];
}
