<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;

class Rating extends Model
{
    use Notifiable;
    use HasRoles;
    protected $fillable = ['rating_by', 'rating_to', 'rating', 'review', 'status'];
    
}
