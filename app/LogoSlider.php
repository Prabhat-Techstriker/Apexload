<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;



class LogoSlider extends Model
{
    use Notifiable;
    use HasRoles;
	protected $table = 'logosliders';
    protected $fillable = ['filenames'];
}
