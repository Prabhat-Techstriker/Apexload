<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;



class Equipment extends Model
{
    protected $table = 'equipments';
    use Notifiable;
    use HasRoles;
    protected $fillable = ['type', 'description'];
    
    protected $hidden = ['pivot'];

    public function vehicles()
    {
        return $this->belongsToMany('App\Vehicle');
    }

    public function jobs()
    {
        return $this->belongsToMany('App\Job');
    }

}

