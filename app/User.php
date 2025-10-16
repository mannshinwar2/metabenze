<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usersname', 'email', 'password', 'ccode', 'contact', 'gender', 'licence', 'permission', 'doj', 'email_verified_at', 'created_at','uuid','s_password','wallet_address'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userDetails(){
        return $this->hasOne('\App\UserDetails','userid','id');
    }

    public function maskedEmail(){

        
        $em   = explode("@",$this->email);
        $name = implode('@', array_slice($em, 0, count($em)-1));
        $len  = floor(strlen($name)/2);

        return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);
    }

    public function maskedContact(){
        $length=strlen($this->contact);
        $frontlength=substr($this->contact,$length-10);
        return  substr($this->contact,0, $length-strlen($frontlength)).substr($this->contact,$length-strlen($frontlength), 2) . str_repeat('*', strlen($frontlength)-5) . substr($this->contact,$length-3, $length);
    }

    public function findForPassport($username) {
        if(filter_var($username, FILTER_VALIDATE_EMAIL)){
            $data['type']='email';
            //$data['regex']='email';
        }else{
            $data['type']='uuid';
            //$data['regex']='regex:/^STY|sty[0-9]{7}+$/';
        }
        return $this->where($data['type'], $username)->first();
    }
    
}
