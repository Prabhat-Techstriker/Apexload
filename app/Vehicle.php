<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;

class Vehicle extends Model
{
    use Notifiable;
    use HasRoles;
    protected $fillable = ['posted_by', 'orign_name', 'orign_lat', 'orign_long', 'destination_name', 'destination_lat', 'destination_long', 'miles', 'available_date_from','available_date_to', 'equipment', 'load_size', 'lenght', 'hieght', 'width', 'vehicle_brand', 'vehicle_number', 'description', 'set_price','status'];

    protected $hidden = ['pivot'];
    
    public function eqp_types()
    {
        return $this->belongsToMany('App\Equipment');
    }
}
