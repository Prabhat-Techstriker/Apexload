<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;


class Search extends Model
{
    use Notifiable;
    use HasRoles;
    protected $fillable = ['user_id','orign_lat', 'orign_long','orign_name', 'destination_lat', 'destination_long','destination_name', 'miles','equipment','pickup_date','count','search_radius'];

}
