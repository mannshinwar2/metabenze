<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
        //User
    public function userindex(){
//         $userdetails=\App\UserDetails::where([['user_details.id',Session::get('user.id')]])
//         ->leftJoin(DB::raw('(SELECT * FROM stacking_deposites WHERE id IN (SELECT MIN(id) FROM stacking_deposites GROUP BY userid)) as first_stack'), 'user_details.id', '=', 'first_stack.userid')
//         ->select('total_direct as totaldirect','active_direct as activedirect','total_downline as totaldownline','active_downline as activedownline','total_direct_investment as directbusiness','total_level_investment as levelbusiness','total_investment as totalbusiness','current_self_investment as currentself','capping as capping','booster as booster')
//         ->selectRaw('case when first_stack.staketype=1 then "3cd2a5 " when first_stack.staketype=2 then "FF0000 " when first_stack.staketype=3 then "FFD700 " when first_stack.staketype=4 then "ffffff " else "FF0000 " end as statusclass')
//         ->get()->first();

//         $userDetail=\App\UserDetails::where('id',\Session::get('user.id'))->first();

//         $totaldirect=DB::table('user_details')->where([['user_details.id',Session::get('user.id')],['u.permission','1']])
//         ->join('user_details as ud','ud.sponsorid','=','user_details.userid')
//         ->join('users as u','u.id','=','ud.userid')
//         ->select(DB::raw('count(ud.id) as total'))
//         ->get()->first();
//         $activedirect=DB::table('user_details')->where([['user_details.id',Session::get('user.id')],['ud.userstatus','1'],['u.permission','1']])
//         ->join('user_details as ud','ud.sponsorid','=','user_details.userid')
//         ->join('users as u','u.id','=','ud.userid')
//         ->select(DB::raw('count(ud.id) as active'))
//         ->get()->first();

        

//         $totalwithdraw=DB::table('transaction_details')->where([['transaction_details.userid',Session::get('user.id')],['transaction_details.txntype','1'],['transaction_details.txndesc','Withdrawal'],['transaction_details.paymentstatus',2]])
//         ->select(DB::raw('sum(amountsftc) as amount,sum(amountusdt) as amountusdt'))
//         ->get()->first();

//         $totalroireceived=DB::table('cps_incomes')->where([['userid',Session::get('user.id')]/*,['txnDesc','CPS']*/])
//         ->select(DB::raw('sum(amount) as totalroi'))
//         ->get()->first();
//         $unpaidroireceived=DB::table('cps_incomes')->where([['userid',Session::get('user.id')]/*,['txnDesc','CPS']*/])
//         ->select(DB::raw('sum(remaining) as remainingroi'))
//         ->get()->first();
//         $totallevelreceived=DB::table('level_incomes')->where([['userid',Session::get('user.id')],['description','L']])
//         ->select(DB::raw('sum(amount) as totallevel'))
//         ->get()->first();
//         $unpaidlevelreceived=DB::table('level_incomes')->where([['userid',Session::get('user.id')],['description','L']])
//         ->select(DB::raw('sum(remaining) as remaininglevel'))
//         ->get()->first();
        
//         $totaldirectreceived=DB::table('bonus_rewards')->where([['userid',Session::get('user.id')]])
//         ->select(DB::raw('sum(amount) as totaldirect'))
//         ->get()->first();
//         $unpaiddirectreceived=DB::table('bonus_rewards')->where([['userid',Session::get('user.id')]])
//         ->select(DB::raw('sum(remaining) as remainingdirect'))
//         ->get()->first();

//         $totalincome=$totalroireceived->totalroi+$totallevelreceived->totallevel+$totaldirectreceived->totaldirect;
//         $unpaidincome=$unpaidroireceived->remainingroi+$unpaidlevelreceived->remaininglevel+$unpaiddirectreceived->remainingdirect;

//         $styprice=DB::table('profile_stores')->where('id',1)->get()->first();
//         $availblewallet=\App\AccountDeposit::where('userid',\Session::get('user.id'))->first();


//         $getIncomingFund=\App\WalletTransfer::where([['userid',\Session::get('user.id')],/*['txnid','!=',0],*/['toWallet','wallet']])->get();
//         $getOutgoingFund=\App\WalletTransfer::where([['fromUser',\Session::get('user.id')],['txnid',0],['fromWallet','wallet']])->get();
//         //dd($getIncomingFund->sum('amount'),$getOutgoingFund->sum('amount'));



//         $userlevel = \App\UserDetails::where('id', Session::get('user.id'))->first()->levelStatus();
//         $adminlevel = \App\UserDetails::where('id', Session::get('user.id'))->first()->leveluser;
//         if ($userlevel >= $adminlevel) {
//             $level = $userlevel;
//         } 
//         else {
//             $level = $adminlevel;
//         }



//         // Booster Logic
//         if ($userDetail->booster == 2) {
//                  $boosterStatus = "Active";
//                     $boosterExpiry = null;
//                     $activationDate = null;
//                     $packageAmount = 0;
//                     $directsCount = 0;
//                     $neededDirects = 5;
//                  } else {
//                     $boosterStatus = "Inactive";
//                     $firstdeposit=\App\StackingDeposite::where([
//                         ['stacking_deposites.userid',$userDetail->id],
//                         ['wallet_transfers.fromWallet','!=','loan']
//                     ])
//                     ->join('wallet_transfers','stacking_deposites.txnid','=','wallet_transfers.id')
//                     ->select('stacking_deposites.created_at as activationdate', 'stacking_deposites.usdt as package_amount')
//                     ->first();

//                         if (!is_null($firstdeposit)) {
//                             $activationDate = \Carbon\Carbon::parse($firstdeposit->activationdate);
//                             $boosterExpiry = $activationDate->copy()->addDays(7);
//                             $packageAmount = $firstdeposit->package_amount; // current user package amount
//                         } else {
//                             $activationDate = null;
//                             $boosterExpiry = null;
//                              $packageAmount = 0;
//                         }
//                         $directsCount = 0;

// if (!is_null($activationDate)) {
//     $directsCount = \App\UserDetails::where('sponsorid', $userDetail->userid) // direct users
//         ->join('stacking_deposites as sd', 'sd.userid', '=', 'user_details.id')
//         ->join('wallet_transfers as wt', 'sd.txnid', '=', 'wt.id')
//         ->where('wt.fromWallet','!=','loan')
//         ->where('sd.usdt', '>=', $packageAmount) // same or above package
//         ->whereBetween('sd.created_at', [$activationDate, $boosterExpiry]) // 7 days condition
//         ->count();
// }

// $neededDirects = max(0, 5 - $directsCount);

//                     }

//         $usrRaw['userdetails']=$userdetails;
//         $usrRaw['userDetail']=$userDetail;
//         $usrRaw['totaldirect']=$totaldirect;
//         $usrRaw['activedirect']=$activedirect;
//         $usrRaw['totalincome']=$totalincome;
//         $usrRaw['unpaidincome']=$unpaidincome;
//         $usrRaw['totalwithdraw']=$totalwithdraw;
//         $usrRaw['totaldirectreceived']=$totaldirectreceived;
//         $usrRaw['styprice']=$styprice;
//         $usrRaw['availblewallet']=$availblewallet;
//         $usrRaw['incomingfund']=$getIncomingFund->sum('amount');
//         $usrRaw['outgoingfund']=$getOutgoingFund->sum('amount');
//         $usrRaw['level'] = $level;  
//         $usrRaw['boosterExpiry']=$boosterExpiry ?? null;
//         $usrRaw['activationdate']= $activationDate ?? null;
//         $usrRaw['boosterDirectsAchieved'] = $directsCount;
//         $usrRaw['boosterDirectsNeeded'] = $neededDirects;

        
        return view('user.dashboard');
    }
}
