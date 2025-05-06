<?php

namespace App\Models;

use App\Models\EventRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'min_guests', 'max_guests', 'image_url'];

    public function eventRequests()
    {
        return $this->hasMany(EventRequest::class);
    }
}
