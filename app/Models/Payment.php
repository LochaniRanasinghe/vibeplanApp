<?php

namespace App\Models;

use App\Models\User;
use App\Models\CustomEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = ['customer_id', 'custom_event_id', 'amount', 'payment_method', 'payment_status', 'paid_at'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function customEvent()
    {
        return $this->belongsTo(CustomEvent::class);
    }
}
