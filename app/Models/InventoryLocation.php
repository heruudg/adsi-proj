<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLocation extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'invt_loc_id';
    
    protected $fillable = [
        'invt_loc_name',
        // Add other fields your inventory_locations table has
    ];
}
