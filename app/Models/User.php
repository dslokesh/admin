<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Emadadly\LaravelUuid\Uuids;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class User extends Authenticatable
{   
    use HasApiTokens, HasFactory, Notifiable,HasRoleAndPermission;
	 use HasRoleAndPermission;
    use Uuids;
    protected $guarded = ['id'];
	protected $keyType = 'string';
	public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','lname', 'phone', 'city', 'country', 'postcode', 'image', 'email', 'password', 'role_id', 'is_active',];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	protected $appends = ['full_name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function getFullNameAttribute() // notice that the attribute name is in CamelCase.
	{
	return $this->name . ' ' . $this->lname;
	}

   
    
	
	
	
}
