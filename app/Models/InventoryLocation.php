<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryLocation extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'invt_loc_id';
    
    protected $fillable = [
        'invt_loc_name',
        // Add other fields your inventory_locations table has
    ];
}
