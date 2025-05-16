<?php

namespace App\Models;

use App\Models\User;
use App\Models\EventRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'locations', 'starting_price', 'image_url', 'added_by'];

    public function eventRequests()
    {
        return $this->hasMany(EventRequest::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
