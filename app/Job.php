<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;

class Job extends Model
{
	use Notifiable;
	use HasRoles;
	protected $fillable = ['posted_by', 'orign_name', 'orign_lat', 'orign_long', 'destination_name', 'destination_lat', 'destination_long', 'miles', 'pickup_date', 'equipment', 'load', 'weight', 'lenght', 'hieght', 'width', 'pieces', 'quantity', 'com_name', 'com_email', 'com_phone', 'com_office', 'com_fax', 'per_user', 'per_phone', 'per_email','set_price','status','delivery_date'];

	protected $hidden = ['pivot'];

	public function eqp_types()
	{
		return $this->belongsToMany('App\Equipment');
	}
}
