<?php

namespace App\Models;

use App\Models\User;
use App\Models\Payment;
use App\Models\EventRequest;
use App\Models\EventInventoryOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomEvent extends Model
{
    use SoftDeletes;

    protected $fillable = ['event_request_id', 'organizer_id', 'finalized_date', 'total_price', 'notes', 'status'];

    public function request()
    {
        return $this->belongsTo(EventRequest::class, 'event_request_id');
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function inventoryOrders()
    {
        return $this->hasMany(EventInventoryOrder::class);
    }
}
