<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;


class Booking extends Model
{
    use Notifiable;
    use HasRoles;
    protected $fillable = ['job_id', 'vehicle_id', 'posted_by', 'requested_by', 'pickup_lat', 'pickup_long', 'destination_lat', 'destination_long', 'approved','status','distance'];

    public function jobs() {
        return $this->belongsTo('App\Job', 'job_id');
    }

    public function trucks() {
        return $this->belongsTo('App\Vehicle', 'vehicle_id');
    }

    public function user_data()
    {
        return $this->belongsTo('App\User', 'posted_by');
    }

    public function userByrequested()
    {
        return $this->belongsTo('App\User', 'requested_by');
    }

    public function truckinfo() {
        return $this->belongsTo('App\Vehicle','requested_by');
    }

    public function truckinfo1() {
        return $this->belongsTo('App\Vehicle','posted_by');
    }
}

