<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManufacturingOrder extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'mfg_order_id';
    
    protected $fillable = [
        'bom_id',
        'mfg_stat_id',
        'prod_manufacture_qty',
        'start_date',
        'finish_date',
        'status'
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'finish_date' => 'date',
    ];
    
    public function billOfMaterial()
    {
        return $this->belongsTo(BillOfMaterial::class, 'bom_id', 'bom_id');
    }
    
    public function manufacturingStatus()
    {
        return $this->belongsTo(ManufacturingStatus::class, 'mfg_stat_id', 'mfg_stat_id');
    }
}
