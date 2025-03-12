<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RawMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'material_id';
    
    protected $fillable = [
        'invt_loc_name',
        'material_name',
        'material_quantity',
        'material_uom',
    ];
    
    /**
     * Get the inventory location that owns this raw material.
     */
    public function inventoryLocation(): BelongsTo
    {
        return $this->belongsTo(InventoryLocation::class, 'invt_loc_name', 'invt_loc_id');
    }
    
    /**
     * Get the bill of materials that use this raw material.
     */
    public function billOfMaterials(): HasMany
    {
        return $this->hasMany(BillOfMaterial::class, 'material_id', 'material_id');
    }
    
    /**
     * Get the formatted quantity with unit of measure.
     */
    public function getFormattedQuantityAttribute(): string
    {
        return $this->material_quantity . ' ' . $this->material_uom;
    }
    
    /**
     * Scope a query to filter materials by inventory location.
     */
    public function scopeByLocation($query, $locationId)
    {
        return $query->where('invt_loc_name', $locationId);
    }
    
    /**
     * Scope a query to filter materials with low quantity.
     */
    public function scopeLowStock($query, $threshold = null)
    {
        // You might want to define different thresholds for different materials
        // This is a simple implementation that you can customize
        if (is_null($threshold)) {
            $threshold = 10; // Default threshold
        }
        
        return $query->where('material_quantity', '<', $threshold);
    }
}