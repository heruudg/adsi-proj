<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BillOfMaterial extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bill_of_materials';
    
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'bom_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'bom_name',
        'bom_quantity',
        'bom_qty_uom',
    ];
    
    /**
     * Get the product that owns this bill of material.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
    
    /**
     * Get the bill of material items for this BOM.
     */
    public function items(): HasMany
    {
        return $this->hasMany(BillOfMaterialItem::class, 'bill_of_material_id', 'bom_id');
    }
    
    /**
     * Get the manufacturing orders using this bill of material.
     */
    public function manufacturingOrders(): HasMany
    {
        return $this->hasMany(ManufacturingOrder::class, 'bom_id', 'bom_id');
    }
    
    /**
     * Get the raw materials used in this BOM through its items.
     */
    public function rawMaterials()
    {
        return $this->hasManyThrough(
            RawMaterial::class,
            BillOfMaterialItem::class,
            'bill_of_material_id', // Foreign key on BillOfMaterialItem
            'material_id',         // Foreign key on RawMaterial
            'bom_id',              // Local key on BillOfMaterial
            'material_id'          // Local key on BillOfMaterialItem
        );
    }
    
    /**
     * Get the work centers used in this BOM through its items.
     */
    public function workCenters()
    {
        return $this->hasManyThrough(
            WorkCenter::class,
            BillOfMaterialItem::class,
            'bill_of_material_id', // Foreign key on BillOfMaterialItem
            'work_center_id',      // Foreign key on WorkCenter
            'bom_id',              // Local key on BillOfMaterial
            'work_ctr_id'          // Local key on BillOfMaterialItem
        );
    }
}