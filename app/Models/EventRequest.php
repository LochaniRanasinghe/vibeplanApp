<?php

namespace App\Models;

use App\Models\User;
use App\Models\EventType;
use App\Models\CustomEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventRequest extends Model
{
    use SoftDeletes;

    protected $fillable = ['customer_id', 'event_type_id', 'title', 'description', 'event_date', 'guest_count', 'location', 'status'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function customEvent()
    {
        return $this->hasOne(CustomEvent::class);
    }

    public function hasPayment()
    {
        return $this->customEvent && $this->customEvent->payments()->exists();
    }

}
