<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'company_address', 
        'company', 'phone', 'website', 'profile_image'
    ];
 
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
 
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function connectUsers()
    {
        return $this->hasMany(ConnectedUsers::class);
    }
    public function connectedUsers($id)
    {
        $connectedUsers = ConnectedUsers::where('user_id', '=', $id)->get()->toArray();

        foreach($connectedUsers as $conUser){
        $usersDetails[] = $this->where('id', '=', $conUser['connected_user'])->get()->toArray(); 
        }
        return $usersDetails;
    } 
}