<?php
namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 *use Illuminate\Contracts\Auth\MustVerifyEmail;
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
*/
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;
    protected $dates = ['deleted_at'];

    protected $fillable = ['created_by','name','first_name','last_name', 'phone_number','phone_verify' ,'email', 'email_verify','user_role','responsibilty_type','account_type','profile_image','preferred_origin','preferred_origin_lat','preferred_origin_long','preferred_destination','preferred_destination_lat','equipment','preferred_destination_long','home_location','licence','address','package_id', 'password', 'device_token', 'remember_token','verification_code','email_verified_at','phone_verified_at','active', 'activation_token'];
    
    
    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    
    protected $casts = [
        'phone_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
         //'equipment' => 'array',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'phone_verified_at',
        'activation_token'
    ];
}
