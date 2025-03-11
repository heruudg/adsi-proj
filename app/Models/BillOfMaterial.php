<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillOfMaterial extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'bom_id';
    
    protected $fillable = [
        'material_id',
        'work_ctr_id',
        'product_id',
        'bom_quantity',
        'material_name',
        'bom_material_qty',
        'material_uom',
        'work_ctr_name',
        'bom_name',
        'bom_qty_uom'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
    
    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'material_id', 'material_id');
    }
    
    public function workCenter()
    {
        return $this->belongsTo(WorkCenter::class, 'work_ctr_id', 'work_center_id');
    }
    
    public function manufacturingOrders()
    {
        return $this->hasMany(ManufacturingOrder::class, 'bom_id', 'bom_id');
    }
}
