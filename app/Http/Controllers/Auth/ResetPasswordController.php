<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use DB;
use App\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(Request $request){
        Validator::make($request->all(),[
            'token'=> ['required','string'],
            'password'=> ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $tokenDetail=DB::table('password_resets')->get();
        $tokenDetail=$tokenDetail->filter(function($q)use($request){ return Hash::check($request->token, $q->token);});
        if(count($tokenDetail)){
            $correctUser=User::where('uuid',$tokenDetail->first()->email)->first();
            /*$userUpdate=User::where('id',$correctUser->id)->update(['password' => \Hash::make($request->password)]);*/
            $userUpdate=User::where('id',$correctUser->id)->update([
                'password' => Hash::make($request->password),
                's_password' => Crypt::encrypt($request->password),
                ]);
            $dltToken=\DB::table('password_resets')->where('email',$tokenDetail->first()->email)->delete();
            return redirect('/login')->with('success','Password changed Successfully.');
        }
        else{
            return redirect('/login')->with('warning','Your requested details not found. Please try with correct one.');
        }
    }// POST     | password/reset
    
    public function showResetForm(Request $request,$token){
        return view('auth.passwords.reset')->with(
            ['token' => $token,]
        );
    }////get     | password/reset/{token}
}
