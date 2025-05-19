<?php

namespace App\Models;

use App\Models\User;
use App\Models\EventInventoryOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    use SoftDeletes;

    protected $fillable = ['inventory_staff_id', 'item_name', 'description', 'quantity_available', 'price_per_unit','item_image'];

    public function staff()
    {
        return $this->belongsTo(User::class, 'inventory_staff_id');
    }

    public function inventoryOrders()
    {
        return $this->hasMany(EventInventoryOrder::class);
    }
}
