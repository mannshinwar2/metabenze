<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo(){
        $user=\App\UserDetails::where('users.id',\Auth::user()->id)
            ->leftjoin('users','users.id','=','user_details.userid')
            ->leftjoin('users as guider','guider.id','user_details.sponsorid')
            ->select('user_details.id as id','users.usersname as name','users.uuid as userid','users.email as email','users.licence as licence','users.permission as permission','users.uuid as uuid','guider.uuid as sponsorid','users.doj')
            ->first();
            \Session::put('user', $user);
            \Session::put('logtime',strtotime(now()));
            if ($user->licence=='3') {
                return '/Main/Dashboard';
            }
            elseif($user->licence=='2'){
                return '/Manage/Dashboard';
            }
            else{
                return '/User/Dashboard';
            }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->username();
    }

    public function username()
    {
        $login = request()->input('email');
        $fieldType ='uuid';
        if(filter_var($login, FILTER_VALIDATE_EMAIL)){
            $fieldType="email";
        }else{
            request()->merge([$fieldType => $login]);
            request()->merge([
                'uuid' => request()->request->get('email'),
            ]);
        }
        return $fieldType;
    }
}
