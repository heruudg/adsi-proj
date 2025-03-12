<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'product_id';
    
    protected $fillable = [
        'invt_loc_name',
        'product_name',
        'product_quantity',
        'product_uom',
    ];
    
    /**
     * Get the inventory location that this product belongs to.
     */
    public function inventoryLocation(): BelongsTo
    {
        return $this->belongsTo(InventoryLocation::class, 'invt_loc_name', 'invt_loc_id');
    }
    
    /**
     * Get the bill of materials for this product.
     */
    public function billOfMaterials(): HasMany
    {
        return $this->hasMany(BillOfMaterial::class, 'product_id', 'product_id');
    }
    
    /**
     * Get the manufacturing orders that use this product.
     */
    public function manufacturingOrders(): HasManyThrough
    {
        // This relationship assumes manufacturing orders are linked to products through BOMs
        // If there's a direct relation, you can adjust this
        return $this->hasManyThrough(
            ManufacturingOrder::class,
            BillOfMaterial::class,
            'product_id', // Foreign key on BillOfMaterial
            'bom_id',     // Foreign key on ManufacturingOrder
            'product_id', // Local key on Product
            'bom_id'      // Local key on BillOfMaterial
        );
    }
    
    /**
     * Format the product quantity with its unit of measure
     */
    public function getFormattedQuantityAttribute(): string
    {
        return $this->product_quantity . ' ' . $this->product_uom;
    }
}
