<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\SupportQueryController;
use Exception;

class RegisterController extends Controller
{
use RegistersUsers;

protected $redirectTo = '/register';

public function __construct()
{
    $this->middleware('guest');
}

// Validation rules
protected function validator(array $data)
{
    $info = $this->findUserName($data['referrer']);

    // Convert the rule string into an array
    $referrerRules = explode('|', $info['regex']);

    return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'/*, 'unique:users'*/],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'referrer'  => $referrerRules,
        'contact'    => ['required', 'numeric'],
        'countrycode'    => ['nullable', 'string'],
        /*'gender'    => ['required', 'numeric'],*/
    ]);
}


// Handle register request
public function register(Request $request)
{
    $validator = $this->validator($request->all());

    if ($validator->fails()) {
        $errors = $validator->errors()->all();
        $errorMessage = implode('<br>', $errors);
        return redirect()->back()->withInput()->with('error', $errorMessage);
    }

    return $this->create($request->all());
}

// Create user
protected function create(array $data)
{
    set_time_limit(0);
    $guiderid = 0;
    if (!is_null($data['referrer'])) {
        $info = $this->findUserName($data['referrer']);
        $guiderid = User::where('uuid', $data['referrer'])->select('id')->first();
        if (is_null($guiderid)) {
            return redirect()->back()->with('error', 'Referrer User ID incorrect. Register with correct Referrer ID.');
        }
    }

    $randomId = $this->randomid();

    $user = User::create([
        'usersname' => $data['name'],
        'email' => $data['email'],
        'contact' => $data['contact'],
        'ccode' => $data['countrycode'] ?? '+91',
        'password' => Hash::make($data['password']),
        's_password' => Crypt::encrypt($data['password']),
        'doj' => date("Y-m-d"),
        'created_at' => now(),
        'uuid' => $randomId,
        'wallet_address' => $data['wallet_address'] ?? null, // ✅ Wallet
        'email_verified_at' => now(),
    ]);

    $userdetails = \App\UserDetails::insertGetId([
        'userid' => $user->id,
        'sponsorid' => is_object($guiderid) ? $guiderid->id : $guiderid
    ]);

    $details = [
        'id' => $user->email,
        'password' => $data['password'],
        'uid' => $userdetails,
        'email' => $data['email'],
        'contact' => $data['contact'],
        'name' => $data['name'],
        'referrerid' => $data['referrer'],
        'uniqueid' => $randomId,
    ];

    event(new \App\Events\UserRegistered($details));

    // Send welcome mail
    try {
        $details['subject'] = 'Welcome to MetaWealths.';
        $details['view'] = 'welcomeMail';
        $mailObj = new SupportQueryController();
        $mailObj->sendMailgun($details);
    } catch (Exception $e) {
        \Log::info('Mail error after registration: ' . $userdetails);
        \Log::info($e->getMessage());
    }

    // Send data to MetaWallet
    try {
        $mwObj = new SupportQueryController();
        $mwObj->sendDatatoMetawallet($details);
    } catch (Exception $e) {
        \Log::info('MetaWallet error after registration: ' . $userdetails);
        \Log::info($e->getMessage());
    }

    return redirect('/register')->with([
    'success' => 'Registration Successful.',
    'details' => [
        'username' => $user->email,
        'password' => $data['password'],
        'uniqueid' => $randomId,
        'wallet_address' => $data['wallet_address'] ?? 'N/A',
    ]
]);

}

public function getSponsor($id)
{
    $data = [];
    $info = $this->findUserName($id);
    $name = \App\User::where($info['type'], $id)->pluck('usersname')->first();
    if (is_null($name)) $data["status"] = 1;
    else { $data["status"] = 0; $data["name"] = $name; }
    return $data;
}

public function reffer($userid) { return view('auth.register')->with('userid', $userid); }

public function randomid()
{
    $val = true;
    while ($val) {
        $num = "MWT" . rand(1111111, 9999999);
        $chkUser = \App\User::where('uuid', $num)->first();
        if (is_null($chkUser)) $val = false;
    }
    return $num;
}
protected function findUserName($sponsor)
{
    // Default: assume UUID type
    $type = 'uuid';
    $regex = 'required|string|max:50';

    if (filter_var($sponsor, FILTER_VALIDATE_EMAIL)) {
        $type = 'email';
        $regex = 'required|email|max:255';
    } elseif (is_numeric($sponsor)) {
        $type = 'id';
        $regex = 'required|numeric';
    }

    return [
        'type' => $type, // for database search
        'regex' => $regex // for validation
    ];
}

}
