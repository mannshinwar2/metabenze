<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Http\Controllers\SupportQueryController;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm(){
        return view('auth.passwords.email');
    }//get     | password/reset

    public function sendResetLinkEmail(Request $request){
        $dataregex=$this->findUserName($request->email);
        $regex=['required',$dataregex['regex'],'exists:users,'.$dataregex['type']];
        Validator::make($request->all(),[
            'email'  =>  $regex,
        ])->validate();
        $user=\App\User::where($dataregex['type'],$request->email)->first();
        if(!is_null($user)){
            $randomString=$this->generateRandomString(64);
            $delExisting=\DB::delete('delete from password_resets where email = ?', [$user->uuid]);
            $insPswdReset=\DB::table('password_resets')->insert(['email'=>$user->uuid,'token'=>\Hash::make($randomString),'created_at'=>now()]);
            $data['email']=$user->email;
            $data['uuid']=$user->uuid;
            $data['token']=$randomString;
            try{
                $data['subject']='Reset Password of MetaWealths Account.';
                $data['view']='resetPasswordMail';
                $mailObj=new SupportQueryController();
                $mailStatus=$mailObj->sendMailgun($data);\Log::info($mailStatus);
                //\Mail::to($user->email)->send(new PasswordResetMail($data));
            }
            catch(Exception $e){
                \Log::info('Error in mails after forget password '.$user->email);
                \Log::info($e->messages());
            }
            

            return redirect('/login')->with('success','Password reset link successfully sent to your mail '.$user->email);
        }else{
            return back()->with('warning','User Id invalid.');
        }
    }// POST     | password/email

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
