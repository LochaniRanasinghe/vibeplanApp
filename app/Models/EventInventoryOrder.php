<?php

namespace App\Models;

use App\Models\CustomEvent;
use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventInventoryOrder extends Model
{
    use SoftDeletes;

    protected $fillable = ['custom_event_id', 'inventory_item_id', 'quantity', 'status'];

    public function customEvent()
    {
        return $this->belongsTo(CustomEvent::class);
    }

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
