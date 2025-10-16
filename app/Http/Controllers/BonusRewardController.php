<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserDetails;
use DB;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class BonusRewardController extends Controller
{
    //Admin
    public function userDepositHis(Request $request){
        if($request->method()==="GET"){
            $fromDate=date('Y-m-d');
            $toDate=date('Y-m-d').' 23:59:59';
        }else{
            $fromDate=$request->fromdate;
            $toDate=$request->todate.' 23:59:59';
        }
        $topupuser=DB::table('transaction_details')->where([['transaction_details.txntype','0'],['transaction_details.txndesc','User Deposit'],['transaction_details.paymentstatus',2]])
        ->whereBetween('transaction_details.created_at',[$fromDate,$toDate])
        ->join('user_details','transaction_details.userid','=','user_details.id')
        ->join('users','user_details.userid','=','users.id')
        /*->join('user_details as pdb','transaction_details.paidby','=','pdb.id')
        ->join('users as pdby','pdb.userid','=','pdby.id')*/
        ->select('transaction_details.id as id', 'users.uuid as userid', 'users.email', 'users.usersname', 'transaction_details.amountsftc', 'transaction_details.amountusdt',/* 'pdby.usersname as paidbyname', 'pdby.email as paidbyid',*/ 'transaction_details.comments', 'transaction_details.created_at')
        ->selectRaw('case when transaction_details.paymentstatus=0 then "Pending" when transaction_details.paymentstatus=1 then "Pending" when transaction_details.paymentstatus=2 then "Confirmed" when transaction_details.paymentstatus=3 then "Failed" when transaction_details.paymentstatus=4 then "Failed" when transaction_details.paymentstatus=5 then "Failed" end as status')
        ->selectRaw('case when transaction_details.paymentstatus=0 then "status-pending" when transaction_details.paymentstatus=1 then "status-pending" when transaction_details.paymentstatus=2 then "status-complete" when transaction_details.paymentstatus=3 then "status-cancelled" when transaction_details.paymentstatus=4 then "status-cancelled" when transaction_details.paymentstatus=5 then "status-cancelled" end as statusclass')
        ->orderByRaw('transaction_details.id DESC')
        ->get();


        $sumamount=DB::table('transaction_details')->where([['transaction_details.txntype','0'],['transaction_details.txndesc','User Deposit'],['transaction_details.paymentstatus',2]])
        ->whereBetween('transaction_details.created_at',[$fromDate,$toDate])
        ->select(DB::raw('sum(amountsftc) as amountcoin,sum(amountusdt) as amountusdt'))
        ->get()->first();

        /*dd($topupuser);*/
        return view('control.deposituser')->with('topup',$topupuser)->with('sumamount',$sumamount);
    }

    public function userPeriodStaking(Request $request){
        if($request->method()==="GET"){
            $fromDate=date('Y-m-d');
            $toDate=date('Y-m-d').' 23:59:59';
        }else{
            $fromDate=$request->fromdate;
            $toDate=$request->todate.' 23:59:59';
        }
        $basichistory=DB::table('stacking_deposites')/*->where('stacking_deposites.userid',Session::get('user.id'))*/
        ->whereBetween('stacking_deposites.created_at',[$fromDate,$toDate])
        ->join('user_details','stacking_deposites.userid','=','user_details.id')
        ->join('users','user_details.userid','=','users.id')
        ->join('stacking_details','stacking_deposites.planid','=','stacking_details.id')
        ->join('wallet_transfers','stacking_deposites.txnid','=','wallet_transfers.id')
        ->join('user_details as ud','wallet_transfers.fromUser','=','ud.id')
        ->join('users as u','ud.userid','=','u.id')
        ->select('stacking_deposites.amount','stacking_deposites.usdt','stacking_details.cps', 'users.email', 'users.uuid', 'users.usersname', 'u.usersname as fromname', 'u.uuid as fromid', 'stacking_details.duration', 'wallet_transfers.fromWallet')
        ->selectRaw('DATE_FORMAT(stacking_deposites.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when stacking_deposites.status=0 then "Closed" when stacking_deposites.status=1 then "Active" when stacking_deposites.status=3 then "Active" when stacking_deposites.status=4 then "Active" end as status')
        ->selectRaw('case when stacking_deposites.status=0 then "status-cancelled" when stacking_deposites.status=1 then "status-complete" when stacking_deposites.status=3 then "status-complete" when stacking_deposites.status=4 then "status-complete" end as statusclass')
        ->selectRaw('case when stacking_deposites.staketype=1 then "Wallet" when stacking_deposites.staketype=2 then "Loan" when stacking_deposites.staketype=3 then "Gold" when stacking_deposites.staketype=4 then "Silver" end as staketype')
        ->orderByRaw('stacking_deposites.id DESC')
        ->get();
        $sumamount=DB::table('stacking_deposites')
        ->whereBetween('stacking_deposites.created_at',[$fromDate,$toDate])
        ->select(DB::raw('sum(amount) as amountstake,sum(usdt) as amountusdt'))
        ->get()->first();
        
        return view('control.stakinghistorybasic')->with('basichistory',$basichistory)->with('sumamount',$sumamount);
    }

    public function reportStaking(Request $request){
        $fromdate=date("Y-m-d").' 00:00:00';
        $todate=date("Y-m-d").' 23:59:59';
        if(!is_null($request->fromdate) && !is_null($request->todate)){
            $fromdate=$request->fromdate;
            $todate=$request->todate.' 23:59:59';
        }
        $reportbasic=DB::table('cps_incomes')/*->where('cps_details.desc','CPS')*/
        ->whereBetween('cps_incomes.created_at',[$fromdate,$todate])
        ->join('user_details','user_details.id','=','cps_incomes.userid')
        ->join('users','users.id','=','user_details.userid')
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->select('users.usersname as name','users.uuid as userid','users.email as email','cps_incomes.amount as amount','cps_incomes.amt_usdt as amountusdt', 'stacking_deposites.amount as principal', 'stacking_deposites.usdt as principalusdt', 'cps_incomes.created_at as created_at')
        ->orderBy('cps_incomes.id', 'desc')
        ->get();
        /*dd($reportbasic);*/
        $sumamount=DB::table('cps_incomes')/*->where('cps_details.desc','CPS')*/
        ->whereBetween('cps_incomes.created_at',[$fromdate,$todate])
        ->select(DB::raw('sum(amount) as amountcoin,sum(amt_usdt) as amountusdt'))
        ->get()->first();

        return view('control.reportstaking')->with('reportbasic',$reportbasic)->with('sumamount',$sumamount);
    }

    public function reportDirect(Request $request){
        $fromdate=date("Y-m-d").' 00:00:00';
        $todate=date("Y-m-d").' 23:59:59';
        if(!is_null($request->fromdate) && !is_null($request->todate)){
            $fromdate=$request->fromdate;
            $todate=$request->todate.' 23:59:59';
        }
        $reportdirect=DB::table('bonus_rewards')/*->where('bonus_rewards.description','referral')*/
        ->whereBetween('bonus_rewards.created_at',[$fromdate,$todate])
        ->join('user_details','user_details.id','=','bonus_rewards.userid')
        ->join('users','users.id','=','user_details.userid')
        ->join('user_details as ud','ud.id','=','bonus_rewards.fromuser')
        ->join('users as u','u.id','=','ud.userid')
        ->select('users.usersname as name','users.uuid as userid','users.email as email','u.usersname as fromname','u.uuid as fromid','bonus_rewards.amount as amount', 'bonus_rewards.amt_usdt as amountusdt', 'bonus_rewards.created_at as created_at')
        ->selectRaw('case when bonus_rewards.status=0 then "Wallet" when bonus_rewards.status=1 then "Wallet" when bonus_rewards.status=3 then "Locked" end as status')
        ->selectRaw('case when bonus_rewards.status=0 then "ffffff" when bonus_rewards.status=1 then "ffffff" when bonus_rewards.status=3 then "FF0000" end as statusclass')
        ->orderBy('bonus_rewards.id', 'desc')
        ->get();
        /*dd($reportbasic);*/
        $sumamount=DB::table('bonus_rewards')/*->where('bonus_rewards.description','referral')*/
        ->whereBetween('bonus_rewards.created_at',[$fromdate,$todate])
        ->select(DB::raw('sum(amount) as amountcoin,sum(amt_usdt) as amountusdt'))
        ->get()->first();

        return view('control.reportdirect')->with('reportdirect',$reportdirect)->with('sumamount',$sumamount);
    }

    public function reportStakingReferral(Request $request){
        $fromdate=date("Y-m-d").' 00:00:00';
        $todate=date("Y-m-d").' 23:59:59';
        if(!is_null($request->fromdate) && !is_null($request->todate)){
            $fromdate=$request->fromdate;
            $todate=$request->todate.' 23:59:59';
        }
        $levelreport=DB::table('level_incomes')->where('level_incomes.description','l')
        ->whereBetween('level_incomes.created_at',[$fromdate,$todate])
        ->join('user_details','user_details.id','=','level_incomes.userid')
        ->join('users','users.id','=','user_details.userid')
        /*->join('transaction_details','transaction_details.id','=','level_incomes.txnid')*/
        ->select('users.usersname as name','users.uuid as userid','users.email as email', 'level_incomes.created_at as created_at')
        ->selectRaw('sum(level_incomes.amount) as amount,sum(level_incomes.amt_usdt) as amountusdt')
        ->orderBy('level_incomes.id', 'desc')
        ->groupBy('level_incomes.userid')
        ->get();
        /*dd($levelreport);*/
        $sumamount=DB::table('level_incomes')->where('level_incomes.description','l')
        ->whereBetween('level_incomes.created_at',[$fromdate,$todate])
        ->select(DB::raw('sum(amount) as amountcoin,sum(amt_usdt) as amountusdt'))
        ->get()->first();

        return view('control.reportlevel')->with('reportlevel',$levelreport)->with('sumamount',$sumamount);
    }

    public function reportTeamDevelopment(Request $request){
        $fromdate=date("Y-m-d").' 00:00:00';
        $todate=date("Y-m-d").' 23:59:59';
        if(!is_null($request->fromdate) && !is_null($request->todate)){
            $fromdate=$request->fromdate;
            $todate=$request->todate.' 23:59:59';
        }
        $levelreport=DB::table('level_incomes')->where('level_incomes.description','r')
        ->whereBetween('level_incomes.created_at',[$fromdate,$todate])
        ->join('user_details','user_details.id','=','level_incomes.userid')
        ->join('users','users.id','=','user_details.userid')
        /*->join('transaction_details','transaction_details.id','=','level_incomes.txnid')*/
        ->select('users.usersname as name','users.uuid as userid','users.email as email', 'level_incomes.created_at as created_at')
        ->selectRaw('sum(level_incomes.amount) as amount,sum(level_incomes.amt_usdt) as amountusdt')
        ->orderBy('level_incomes.id', 'desc')
        ->groupBy('level_incomes.userid')
        ->get();
        /*dd($levelreport);*/
        $sumamount=DB::table('level_incomes')->where('level_incomes.description','r')
        ->whereBetween('level_incomes.created_at',[$fromdate,$todate])
        ->select(DB::raw('sum(amount) as amountcoin,sum(amt_usdt) as amountusdt'))
        ->get()->first();

        return view('control.reportlevelbonus')->with('reportlevel',$levelreport)->with('sumamount',$sumamount);
    }

    public function reportClub(Request $request){
        $fromdate=date("Y-m-d").' 00:00:00';
        $todate=date("Y-m-d").' 23:59:59';
        if(!is_null($request->fromdate) && !is_null($request->todate)){
            $fromdate=$request->fromdate;
            $todate=$request->todate.' 23:59:59';
        }
        $reportclub=DB::table('club_incomes')
        ->whereBetween('club_incomes.created_at',[$fromdate,$todate])
        ->join('user_details','user_details.id','=','club_incomes.userid')
        ->join('users','users.id','=','user_details.userid')
        ->join('club_details','club_details.id','=','club_incomes.clubid')
        ->select('users.usersname as name','users.uuid as userid','users.email as email','club_incomes.amount as amount', 'club_incomes.amt_usdt as amountusdt', 'club_details.clubname as clubname', 'club_incomes.created_at as created_at')
        ->orderBy('club_incomes.id', 'desc')
        ->get();
        /*dd($reportclub);*/
        $sumamount=DB::table('club_incomes')
        ->whereBetween('club_incomes.created_at',[$fromdate,$todate])
        ->select(DB::raw('sum(amount) as amountcoin,sum(amt_usdt) as amountusdt'))
        ->get()->first();

        return view('control.reportclub')->with('reportclub',$reportclub)->with('sumamount',$sumamount);
    }

    public function reportLifetime(Request $request){
        $fromdate=date("Y-m-d").' 00:00:00';
        $todate=date("Y-m-d").' 23:59:59';
        if(!is_null($request->fromdate) && !is_null($request->todate)){
            $fromdate=$request->fromdate;
            $todate=$request->todate.' 23:59:59';
        }
        $reportlifetime=DB::table('achievement_incomes')
        ->whereBetween('achievement_incomes.created_at',[$fromdate,$todate])
        ->join('user_details','user_details.id','=','achievement_incomes.userid')
        ->join('users','users.id','=','user_details.userid')
        ->join('achievement_details','achievement_details.id','=','achievement_incomes.achievementid')
        ->select('users.usersname as name','users.uuid as userid','users.email as email','achievement_incomes.amount as amount', 'achievement_incomes.amt_usdt as amountusdt', 'achievement_details.rewardname as rewardname', 'achievement_incomes.created_at as created_at')
        ->orderBy('achievement_incomes.id', 'desc')
        ->get();
        /*dd($reportlifetime);*/
        $sumamount=DB::table('achievement_incomes')
        ->whereBetween('achievement_incomes.created_at',[$fromdate,$todate])
        ->select(DB::raw('sum(amount) as amountcoin,sum(amt_usdt) as amountusdt'))
        ->get()->first();

        return view('control.reportlifetime')->with('reportlifetime',$reportlifetime)->with('sumamount',$sumamount);
    }

    public function reportStaking36(Request $request){
        $fromdate=date("Y-m-d").' 00:00:00';
        $todate=date("Y-m-d").' 23:59:59';
        if(!is_null($request->fromdate) && !is_null($request->todate)){
            $fromdate=$request->fromdate;
            $todate=$request->todate.' 23:59:59';
        }
        $reportbasic=DB::table('cps_incomes')->where([['stacking_deposites.planid','2'],['user_details.booster',2]])
        ->whereBetween('cps_incomes.created_at',[$fromdate,$todate])
        ->join('user_details','user_details.id','=','cps_incomes.userid')
        ->join('users','users.id','=','user_details.userid')
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->select('users.usersname as name','users.uuid as userid','users.email as email','cps_incomes.amount as amount','cps_incomes.amt_usdt as amountusdt', 'stacking_deposites.amount as principal', 'stacking_deposites.usdt as principalusdt', 'cps_incomes.created_at as created_at')
        ->orderBy('cps_incomes.id', 'desc')
        ->get();
        /*dd($reportbasic);*/
        $sumamount=DB::table('cps_incomes')->where([['stacking_deposites.planid','2'],['user_details.booster',2]])
        ->whereBetween('cps_incomes.created_at',[$fromdate,$todate])
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->join('user_details','user_details.id','=','cps_incomes.userid')
        ->select(DB::raw('sum(cps_incomes.amount) as amountcoin,sum(cps_incomes.amt_usdt) as amountusdt'))
        ->get()->first();

        return view('control.reportstaking36')->with('reportbasic',$reportbasic)->with('sumamount',$sumamount);
    }

    public function reportStaking30(Request $request){
        $fromdate=date("Y-m-d").' 00:00:00';
        $todate=date("Y-m-d").' 23:59:59';
        if(!is_null($request->fromdate) && !is_null($request->todate)){
            $fromdate=$request->fromdate;
            $todate=$request->todate.' 23:59:59';
        }
        $reportbasic=DB::table('cps_incomes')->where([['stacking_deposites.planid','1'],['stacking_deposites.staketype','!=',4],['user_details.booster',2]])
        ->whereBetween('cps_incomes.created_at',[$fromdate,$todate])
        ->join('user_details','user_details.id','=','cps_incomes.userid')
        ->join('users','users.id','=','user_details.userid')
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->select('users.usersname as name','users.uuid as userid','users.email as email','cps_incomes.amount as amount','cps_incomes.amt_usdt as amountusdt', 'stacking_deposites.amount as principal', 'stacking_deposites.usdt as principalusdt', 'cps_incomes.created_at as created_at')
        ->orderBy('cps_incomes.id', 'desc')
        ->get();
        /*dd($reportbasic);*/
        $sumamount=DB::table('cps_incomes')->where([['stacking_deposites.planid','1'],['stacking_deposites.staketype','!=',4],['user_details.booster',2]])
        ->whereBetween('cps_incomes.created_at',[$fromdate,$todate])
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->join('user_details','user_details.id','=','cps_incomes.userid')
        ->select(DB::raw('sum(cps_incomes.amount) as amountcoin,sum(cps_incomes.amt_usdt) as amountusdt'))
        ->get()->first();

        return view('control.reportstaking30')->with('reportbasic',$reportbasic)->with('sumamount',$sumamount);
    }

    public function reportStaking18(Request $request){
        $fromdate=date("Y-m-d").' 00:00:00';
        $todate=date("Y-m-d").' 23:59:59';
        if(!is_null($request->fromdate) && !is_null($request->todate)){
            $fromdate=$request->fromdate;
            $todate=$request->todate.' 23:59:59';
        }
        $reportbasic=DB::table('cps_incomes')->where([['stacking_deposites.planid','2'],['user_details.booster',1]])
        ->whereBetween('cps_incomes.created_at',[$fromdate,$todate])
        ->join('user_details','user_details.id','=','cps_incomes.userid')
        ->join('users','users.id','=','user_details.userid')
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->select('users.usersname as name','users.uuid as userid','users.email as email','cps_incomes.amount as amount','cps_incomes.amt_usdt as amountusdt', 'stacking_deposites.amount as principal', 'stacking_deposites.usdt as principalusdt', 'cps_incomes.created_at as created_at')
        ->orderBy('cps_incomes.id', 'desc')
        ->get();
        /*dd($reportbasic);*/
        $sumamount=DB::table('cps_incomes')->where([['stacking_deposites.planid','2'],['user_details.booster',1]])
        ->whereBetween('cps_incomes.created_at',[$fromdate,$todate])
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->join('user_details','user_details.id','=','cps_incomes.userid')
        ->select(DB::raw('sum(cps_incomes.amount) as amountcoin,sum(cps_incomes.amt_usdt) as amountusdt'))
        ->get()->first();

        return view('control.reportstaking18')->with('reportbasic',$reportbasic)->with('sumamount',$sumamount);
    }

    public function reportStaking15(Request $request){
        $fromdate=date("Y-m-d").' 00:00:00';
        $todate=date("Y-m-d").' 23:59:59';
        if(!is_null($request->fromdate) && !is_null($request->todate)){
            $fromdate=$request->fromdate;
            $todate=$request->todate.' 23:59:59';
        }
        $reportbasic=DB::table('cps_incomes')->where([['stacking_deposites.planid','1'],['stacking_deposites.staketype','!=',4],['user_details.booster',1]])
        ->whereBetween('cps_incomes.created_at',[$fromdate,$todate])
        ->join('user_details','user_details.id','=','cps_incomes.userid')
        ->join('users','users.id','=','user_details.userid')
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->select('users.usersname as name','users.uuid as userid','users.email as email','cps_incomes.amount as amount','cps_incomes.amt_usdt as amountusdt', 'stacking_deposites.amount as principal', 'stacking_deposites.usdt as principalusdt', 'cps_incomes.created_at as created_at')
        ->orderBy('cps_incomes.id', 'desc')
        ->get();
        /*dd($reportbasic);*/
        $sumamount=DB::table('cps_incomes')->where([['stacking_deposites.planid','1'],['stacking_deposites.staketype','!=',4],['user_details.booster',1]])
        ->whereBetween('cps_incomes.created_at',[$fromdate,$todate])
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->join('user_details','user_details.id','=','cps_incomes.userid')
        ->select(DB::raw('sum(cps_incomes.amount) as amountcoin,sum(cps_incomes.amt_usdt) as amountusdt'))
        ->get()->first();

        return view('control.reportstaking15')->with('reportbasic',$reportbasic)->with('sumamount',$sumamount);
    }

    public function reportStaking8(Request $request){
        $fromdate=date("Y-m-d").' 00:00:00';
        $todate=date("Y-m-d").' 23:59:59';
        if(!is_null($request->fromdate) && !is_null($request->todate)){
            $fromdate=$request->fromdate;
            $todate=$request->todate.' 23:59:59';
        }
        $reportbasic=DB::table('cps_incomes')->where('stacking_deposites.staketype','4')
        ->whereBetween('cps_incomes.created_at',[$fromdate,$todate])
        ->join('user_details','user_details.id','=','cps_incomes.userid')
        ->join('users','users.id','=','user_details.userid')
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->select('users.usersname as name','users.uuid as userid','users.email as email','cps_incomes.amount as amount','cps_incomes.amt_usdt as amountusdt', 'stacking_deposites.amount as principal', 'stacking_deposites.usdt as principalusdt', 'cps_incomes.created_at as created_at')
        ->orderBy('cps_incomes.id', 'desc')
        ->get();
        /*dd($reportbasic);*/
        $sumamount=DB::table('cps_incomes')->where('stacking_deposites.staketype','4')
        ->whereBetween('cps_incomes.created_at',[$fromdate,$todate])
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->select(DB::raw('sum(cps_incomes.amount) as amountcoin,sum(cps_incomes.amt_usdt) as amountusdt'))
        ->get()->first();

        return view('control.reportstaking8')->with('reportbasic',$reportbasic)->with('sumamount',$sumamount);
    }

    





    //User
    public function userDepositHistory(){
        $trnshistory=DB::table('transaction_details')->where([['transaction_details.userid','1'],['transaction_details.txntype','0']/*,['transaction_details.txndesc','User Deposit'],['transaction_details.paymentstatus',2]*/])
        ->join('transaction_infos','transaction_details.id','=','transaction_infos.txnid')
        ->join('user_details','transaction_details.userid','=','user_details.id')
        ->join('users','user_details.userid','=','users.id')
        ->select('transaction_details.amountsftc as coinamount','transaction_details.amountusdt as amountusdt','transaction_details.currency', 'users.email', 'users.uuid as userid', 'users.usersname', 'transaction_infos.transaction_hash')
        ->selectRaw('DATE_FORMAT(transaction_details.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when transaction_details.paymentstatus=0 then "Pending" when transaction_details.paymentstatus=1 then "Pending" when transaction_details.paymentstatus=2 then "Confirmed" when transaction_details.paymentstatus=3 then "Failed" when transaction_details.paymentstatus=4 then "Failed" when transaction_details.paymentstatus=5 then "Failed" end as status')
        ->selectRaw('case when transaction_details.paymentstatus=0 then "status-pending" when transaction_details.paymentstatus=1 then "status-pending" when transaction_details.paymentstatus=2 then "status-complete" when transaction_details.paymentstatus=3 then "status-cancelled" when transaction_details.paymentstatus=4 then "status-cancelled" when transaction_details.paymentstatus=5 then "status-cancelled" end as statusclass')
        ->orderByRaw('transaction_details.id DESC')
        ->get();
        /*dd($trnshistory);*/

        return view('user.deposithistory')->with('history',$trnshistory);
    }

    public function userUpgradeHistory(){
        $basichistory=DB::table('stacking_deposites')->where('stacking_deposites.userid',Session::get('user.id'))
        ->join('user_details','stacking_deposites.userid','=','user_details.id')
        ->join('users','user_details.userid','=','users.id')
        ->join('stacking_details','stacking_deposites.planid','=','stacking_details.id')
        ->select('stacking_deposites.amount','stacking_deposites.usdt','stacking_details.cps', 'users.email', 'users.uuid as userid', 'users.usersname as usersname')
        ->selectRaw('DATE_FORMAT(stacking_deposites.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when stacking_deposites.status=-1 then "Withdraw" when stacking_deposites.status=0 then "Closed" when stacking_deposites.status=1 then "Active" when stacking_deposites.status=2 then "Active" when stacking_deposites.status=3 then "Active" end as status')
        ->selectRaw('case when stacking_deposites.status=0 then "status-cancelled" when stacking_deposites.status=1 then "status-complete" when stacking_deposites.status=2 then "status-complete" when stacking_deposites.status=3 then "status-complete" end as statusclass')
        ->orderByRaw('stacking_deposites.id DESC')
        ->get();
        
        return view('user.packagehistory')->with('basic',$basichistory);
    }

    public function userUpgradeTxnHistory(){

        $txnhistory=DB::table('stacking_deposites')->where([['wallet_transfers.fromUser',Session::get('user.id')],['wallet_transfers.fromWallet','wallet'],['wallet_transfers.toWallet','basic']])
        ->join('wallet_transfers','stacking_deposites.txnid','=','wallet_transfers.id')
        ->join('user_details','stacking_deposites.userid','=','user_details.id')
        ->join('users','user_details.userid','=','users.id')
        ->join('stacking_details','stacking_deposites.planid','=','stacking_details.id')
        ->select('stacking_deposites.amount','stacking_deposites.usdt','stacking_details.cps', 'users.email', 'users.uuid as userid', 'users.usersname as usersname',/* 'wallet_transfers.userid'*/ )
        ->selectRaw('DATE_FORMAT(stacking_deposites.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when stacking_deposites.status=0 then "Closed" when stacking_deposites.status=1 then "Active" end as status')
        ->selectRaw('case when stacking_deposites.status=0 then "status-cancelled" when stacking_deposites.status=1 then "status-complete" end as statusclass')
        ->orderByRaw('stacking_deposites.id DESC')
        ->get();

        $walletreducehistory=DB::table('wallet_transfers')->where([['wallet_transfers.fromUser',Session::get('user.id')],['wallet_transfers.fromWallet','wallet'],['wallet_transfers.toWallet','wallet']])
        ->join('user_details','wallet_transfers.userid','=','user_details.id')
        ->join('users','user_details.userid','=','users.id')
        ->select('users.email', 'users.uuid as userid', 'users.usersname as usersname', 'wallet_transfers.amount')
        ->selectRaw('DATE_FORMAT(wallet_transfers.created_at,"%d-%m-%Y") as created_at')
        ->orderByRaw('wallet_transfers.id DESC')
        ->get();
        /*dd($walletreducehistory);*/

        
        return view('user.packagetxnhistory')->with('team',$txnhistory)->with('wallet',$walletreducehistory);
    }


    public function userIncomeOverview(){
        $totalroireceived=DB::table('cps_incomes')->where('cps_incomes.userid',Session::get('user.id'))
        ->select(DB::raw('sum(amount) as totalroi,sum(remaining) as remainingroi'))
        ->get()->first();
         $totallevelreceived=DB::table('level_incomes')->where([['level_incomes.userid',Session::get('user.id')]])
        ->select(DB::raw('sum(amount) as totallevel,sum(remaining) as remaininglevel'))
        ->get()->first();
        $totaldirectreceived=DB::table('bonus_rewards')->where([['bonus_rewards.userid',Session::get('user.id')],['bonus_rewards.description','referral']])
        ->select(DB::raw('sum(amount) as totaldirect,sum(remaining) as remainingdirect'))
        ->get()->first();
         

        $totalincome=$totalroireceived->totalroi+$totallevelreceived->totallevel+$totaldirectreceived->totaldirect;
        $remainingincome=$totalroireceived->remainingroi+$totallevelreceived->remaininglevel+$totaldirectreceived->remainingdirect;

        $totalwithdraw=DB::table('transaction_details')->where([['transaction_details.userid',Session::get('user.id')],['transaction_details.txntype','1'],['transaction_details.txndesc','Withdrawal'],['transaction_details.paymentstatus',2]])
        ->select(DB::raw('sum(amountusdt) as amount'))
        ->get()->first();
        
        $userDetail=\App\UserDetails::where('id',\Session::get('user.id'))->first();

        $totalturnover=$userDetail->total_investment-$userDetail->total_self_investment;
        $userClub=\App\ClubDetails::where('business_min','<=',$totalturnover)->get()->last();
        $clubId=(!is_null($userClub) && $userDetail->clubuser>$userClub->id)?$userDetail->clubuser:((!is_null($userClub))?$userClub->id:1);
        $userClub=\App\ClubDetails::where('id',$clubId)->first();

        $rdata['totalroireceived']=$totalroireceived;
        $rdata['totallevelreceived']=$totallevelreceived;
        $rdata['totaldirectreceived']=$totaldirectreceived;
        $rdata['totalwithdraw']=$totalwithdraw;
        $rdata['totalincome']=$totalincome;
        $rdata['remainingincome']=$remainingincome;
        $rdata['userDetail']=$userDetail;
        $rdata['userClub']=$userClub;
        
        /*dd($userClub);*/
        return view('user.incomeoverview')->with('data',$rdata);
    }

    public function userStakingReport(Request $request){
        if($request->method()==="GET"){
        $totalroireceived=DB::table('cps_incomes')->where('cps_incomes.userid',Session::get('user.id'))
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->select('cps_incomes.amount as amount', 'stacking_deposites.amount as principal')
        ->selectRaw('DATE_FORMAT(cps_incomes.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when cps_incomes.status=0 then "Credit" when cps_incomes.status=1 then "Withdraw" when cps_incomes.status=3 then "Locked" end as status')
        ->selectRaw('case when cps_incomes.status=0 then "ffffffbf " when cps_incomes.status=1 then "ffffffbf " when cps_incomes.status=3 then "FF0000" end as statusclass')
        ->orderBy('cps_incomes.id', 'desc')
        ->get();
        }else{
            $fromDate=$request->fromdate;
            $toDate=$request->todate.' 23:59:59';

        $totalroireceived=DB::table('cps_incomes')->where('cps_incomes.userid',Session::get('user.id'))
        ->whereBetween('cps_incomes.created_at',[$fromDate,$toDate])
        ->join('stacking_deposites','stacking_deposites.id','=','cps_incomes.txnid')
        ->select('cps_incomes.amount as amount', 'stacking_deposites.amount as principal')
        ->selectRaw('DATE_FORMAT(cps_incomes.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when cps_incomes.status=0 then "Credit" when cps_incomes.status=1 then "Withdraw" when cps_incomes.status=3 then "Locked" end as status')
        ->selectRaw('case when cps_incomes.status=0 then "ffffffbf " when cps_incomes.status=1 then "ffffffbf " when cps_incomes.status=3 then "FF0000" end as statusclass')
        ->orderBy('cps_incomes.id', 'desc')
        ->get();
        }

        return view('user.incomestaking')->with('roiamount',$totalroireceived);
    }

    public function userDirectReport(Request $request){
        if($request->method()==="GET"){
        $totaldirectreceived=DB::table('bonus_rewards')->where([['bonus_rewards.userid',Session::get('user.id')],['bonus_rewards.description','referral']])
        ->join('user_details','user_details.id','=','bonus_rewards.fromuser')
        ->join('users','users.id','=','user_details.userid')
        ->select('bonus_rewards.amount as amount','bonus_rewards.description as level','users.uuid as fromid','users.usersname as fromname')
        ->selectRaw('DATE_FORMAT(bonus_rewards.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when bonus_rewards.status=0 then "Credit" when bonus_rewards.status=1 then "Withdraw" when bonus_rewards.status=3 then "Locked" end as status')
        ->selectRaw('case when bonus_rewards.status=0 then "ffffffbf" when bonus_rewards.status=1 then "ffffffbf" when bonus_rewards.status=3 then "FF0000" end as statusclass')
        ->orderBy('bonus_rewards.id', 'desc')
        ->get();
        }else{
            $fromDate=$request->fromdate;
            $toDate=$request->todate.' 23:59:59';

        $totaldirectreceived=DB::table('bonus_rewards')->where([['bonus_rewards.userid',Session::get('user.id')],['bonus_rewards.description','referral']])
        ->whereBetween('bonus_rewards.created_at',[$fromDate,$toDate])
        ->join('user_details','user_details.id','=','bonus_rewards.fromuser')
        ->join('users','users.id','=','user_details.userid')
        ->select('bonus_rewards.amount as amount','bonus_rewards.description as level','users.uuid as fromid','users.usersname as fromname')
        ->selectRaw('DATE_FORMAT(bonus_rewards.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when bonus_rewards.status=0 then "Credit" when bonus_rewards.status=1 then "Withdraw" when bonus_rewards.status=3 then "Locked" end as status')
        ->selectRaw('case when bonus_rewards.status=0 then "ffffffbf" when bonus_rewards.status=1 then "ffffffbf" when bonus_rewards.status=3 then "FF0000" end as statusclass')
        ->orderBy('bonus_rewards.id', 'desc')
        ->get();
        }

        return view('user.incomedirect')->with('directamount',$totaldirectreceived);
    }
    
    public function userStakingReferralReward(Request $request){
        if($request->method()==="GET"){
        
        $totalreferralreceived=DB::table('level_incomes')->where([['level_incomes.userid',Session::get('user.id')],['level_incomes.description','l']])
        ->select(DB::raw('DATE_FORMAT(level_incomes.created_at ,"%Y-%m-%d")as txndate'))
        ->selectRaw('sum(level_incomes.amount) as amount')
        ->orderBy('txndate', 'desc')
        ->groupBy('txndate')
        ->get();
        }else{
            $fromDate=$request->fromdate;
            $toDate=$request->todate.' 23:59:59';

        $totalreferralreceived=DB::table('level_incomes')->where([['level_incomes.userid',Session::get('user.id')],['level_incomes.description','l']])
        ->whereBetween('level_incomes.created_at',[$fromDate,$toDate])
        ->select(DB::raw('DATE_FORMAT(level_incomes.created_at ,"%Y-%m-%d")as txndate'))
        ->selectRaw('sum(level_incomes.amount) as amount')
        ->orderBy('level_incomes.id', 'desc')
        ->groupBy('txndate')
        ->get();
        }


        $userlevel=\App\UserDetails::where('id',Session::get('user.id'))->first()->levelStatus();
        $adminlevel=\App\UserDetails::where('id',Session::get('user.id'))->first()->leveluser;
        if ($userlevel>=$adminlevel) {
            $level=$userlevel;
        }else{
            $level=$adminlevel;
        }
        /*dd($totalreferralreceived);*/

        return view('user.incomelevel')->with('referral',$totalreferralreceived)->with('level',$level);
    }
    public function userStakingReferralRewardDate($txndate){
            $fromDate=$txndate;
            $toDate=$txndate.' 23:59:59';
            $referralbydate=DB::table('level_incomes')->where([['level_incomes.userid',Session::get('user.id')],['level_incomes.description','l']])
            ->whereBetween('level_incomes.created_at',[$fromDate,$toDate])
            /*->join('cps_incomes','cps_incomes.id','=','level_incomes.txnid')*/
            ->join('user_details','user_details.id','=','level_incomes.fromuser')
            ->join('users','users.id','=','user_details.userid')
            /*->join('relation_stages','relation_stages.userid','=','level_details.fromUser')*/
            ->select('users.usersname as fromname','users.email as fromid','users.uuid as fromuserid','level_incomes.amount as amount', DB::raw('DATE_FORMAT(level_incomes.created_at ,"%Y-%m-%d")as txndate'))
            ->selectRaw('case when level_incomes.status=0 then "Credit" when level_incomes.status=1 then "Withdraw" when level_incomes.status=3 then "Locked" end as status')
            ->selectRaw('case when level_incomes.status=0 then "ffffffbf" when level_incomes.status=1 then "ffffffbf" when level_incomes.status=3 then "FF0000" end as statusclass')
            ->orderBy('level_incomes.id', 'desc')
            ->get();
            //dd($referralbydate);
            return view('user.incomeleveldate')->with('referral',$referralbydate);
    }
    
    public function userTeamDevelopmentReward(Request $request){
        if($request->method()==="GET"){
        
        $totalreferralreceived=DB::table('level_incomes')->where([['level_incomes.userid',Session::get('user.id')],['level_incomes.description','r']])
        ->select(DB::raw('DATE_FORMAT(level_incomes.created_at ,"%Y-%m-%d")as txndate'))
        ->selectRaw('sum(level_incomes.amount) as amount')
        ->orderBy('txndate', 'desc')
        ->groupBy('txndate')
        ->get();
        }else{
            $fromDate=$request->fromdate;
            $toDate=$request->todate.' 23:59:59';

        $totalreferralreceived=DB::table('level_incomes')->where([['level_incomes.userid',Session::get('user.id')],['level_incomes.description','r']])
        ->whereBetween('level_incomes.created_at',[$fromDate,$toDate])
        ->select(DB::raw('DATE_FORMAT(level_incomes.created_at ,"%Y-%m-%d")as txndate'))
        ->selectRaw('sum(level_incomes.amount) as amount')
        ->orderBy('level_incomes.id', 'desc')
        ->groupBy('txndate')
        ->get();
        }
        /*dd($totalreferralreceived);*/

        return view('user.incomelevelbonus')->with('referral',$totalreferralreceived);
    }
    public function userTeamDevelopmentRewardDate($txndate){
            $fromDate=$txndate;
            $toDate=$txndate.' 23:59:59';
            $referralbydate=DB::table('level_incomes')->where([['level_incomes.userid',Session::get('user.id')],['level_incomes.description','r']])
            ->whereBetween('level_incomes.created_at',[$fromDate,$toDate])
            /*->join('cps_incomes','cps_incomes.id','=','level_incomes.txnid')*/
            ->join('user_details','user_details.id','=','level_incomes.fromuser')
            ->join('users','users.id','=','user_details.userid')
            /*->join('relation_stages','relation_stages.userid','=','level_details.fromUser')*/
            ->select('users.usersname as fromname','users.email as fromid','users.uuid as fromuserid','level_incomes.amount as amount', DB::raw('DATE_FORMAT(level_incomes.created_at ,"%Y-%m-%d")as txndate'))
            ->selectRaw('case when level_incomes.status=0 then "Credit" when level_incomes.status=1 then "Withdraw" when level_incomes.status=3 then "Locked" end as status')
            ->selectRaw('case when level_incomes.status=0 then "ffffffbf" when level_incomes.status=1 then "ffffffbf" when level_incomes.status=3 then "FF0000" end as statusclass')
            ->orderBy('level_incomes.id', 'desc')
            ->get();
            //dd($referralbydate);
            return view('user.incomelevelbonusdate')->with('referral',$referralbydate);
    }

    public function userClubReward(Request $request){
        if($request->method()==="GET"){
        $totalclubreceived=DB::table('club_incomes')->where('club_incomes.userid',Session::get('user.id'))
        ->join('club_details','club_details.id','=','club_incomes.clubid')
        ->select('club_incomes.amount as amount', 'club_details.clubname as clubname')
        ->selectRaw('DATE_FORMAT(club_incomes.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when club_incomes.status=0 then "Credit" when club_incomes.status=1 then "Withdraw" when club_incomes.status=3 then "Locked" end as status')
        ->selectRaw('case when club_incomes.status=0 then "ffffffbf " when club_incomes.status=1 then "ffffffbf " when club_incomes.status=3 then "FF0000" end as statusclass')
        ->orderBy('club_incomes.id', 'desc')
        ->get();
        }else{
            $fromDate=$request->fromdate;
            $toDate=$request->todate.' 23:59:59';

        $totalclubreceived=DB::table('club_incomes')->where('club_incomes.userid',Session::get('user.id'))
        ->whereBetween('club_incomes.created_at',[$fromDate,$toDate])
        ->join('club_details','club_details.id','=','club_incomes.clubid')
        ->select('club_incomes.amount as amount', 'club_details.clubname as clubname')
        ->selectRaw('DATE_FORMAT(club_incomes.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when club_incomes.status=0 then "Credit" when club_incomes.status=1 then "Withdraw" when club_incomes.status=3 then "Locked" end as status')
        ->selectRaw('case when club_incomes.status=0 then "ffffffbf " when club_incomes.status=1 then "ffffffbf " when club_incomes.status=3 then "FF0000" end as statusclass')
        ->orderBy('club_incomes.id', 'desc')
        ->get();
        }

        $userDetail=\App\UserDetails::where('id',\Session::get('user.id'))->first();

        /*$totalturnover=$userDetail->total_investment-$userDetail->total_self_investment;
        $userClub=\App\ClubDetails::where('business_min','<=',$totalturnover)->get()->last();
        $clubId=(!is_null($userClub) && $userDetail->clubuser>$userClub->id)?$userDetail->clubuser:((!is_null($userClub))?$userClub->id:1);
        $userClub=\App\ClubDetails::where('id',$clubId)->first();*/

        return view('user.incomeclub')->with('incomeclub',$totalclubreceived)->with('userDetail',$userDetail);
    }

    public function userLifetimeReward(Request $request){
        if($request->method()==="GET"){
        $lifetimereceived=DB::table('achievement_incomes')->where('achievement_incomes.userid',Session::get('user.id'))
        ->join('achievement_details','achievement_details.id','=','achievement_incomes.achievementid')
        ->select('achievement_incomes.amount as amount', 'achievement_details.rewardname as rewardname')
        ->selectRaw('DATE_FORMAT(achievement_incomes.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when achievement_incomes.status=0 then "Credit" when achievement_incomes.status=1 then "Withdraw" when achievement_incomes.status=3 then "Locked" end as status')
        ->selectRaw('case when achievement_incomes.status=0 then "ffffffbf " when achievement_incomes.status=1 then "ffffffbf " when achievement_incomes.status=3 then "FF0000" end as statusclass')
        ->orderBy('achievement_incomes.id', 'desc')
        ->get();
        }else{
            $fromDate=$request->fromdate;
            $toDate=$request->todate.' 23:59:59';

        $lifetimereceived=DB::table('achievement_incomes')->where('achievement_incomes.userid',Session::get('user.id'))
        ->whereBetween('achievement_incomes.created_at',[$fromDate,$toDate])
        ->join('achievement_details','achievement_details.id','=','achievement_incomes.achievementid')
        ->select('achievement_incomes.amount as amount', 'achievement_details.rewardname as rewardname')
        ->selectRaw('DATE_FORMAT(achievement_incomes.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when achievement_incomes.status=0 then "Credit" when achievement_incomes.status=1 then "Withdraw" when achievement_incomes.status=3 then "Locked" end as status')
        ->selectRaw('case when achievement_incomes.status=0 then "ffffffbf " when achievement_incomes.status=1 then "ffffffbf " when achievement_incomes.status=3 then "FF0000" end as statusclass')
        ->orderBy('achievement_incomes.id', 'desc')
        ->get();
        }

        $userDetail=\App\UserDetails::where('id',\Session::get('user.id'))->first();

        return view('user.incomelifetime')->with('incomelifetime',$lifetimereceived)->with('user',$userDetail);
    }


    public function withdrawHistoryUser(){
        $withhistory=DB::table('transaction_details')->where([['transaction_details.userid',Session::get('user.id')],['transaction_details.txntype','1'],['transaction_details.txndesc','Withdrawal']/*,['transaction_details.paymentstatus',2]*/])
        ->join('transaction_infos','transaction_details.id','=','transaction_infos.txnid')
        ->join('user_details','transaction_details.userid','=','user_details.id')
        ->join('users','user_details.userid','=','users.id')
        ->select('transaction_details.amountsftc','transaction_details.amountusdt','transaction_details.deduction','transaction_details.net_amount','transaction_details.currency', 'users.uuid', 'users.email', 'users.usersname', 'transaction_infos.transaction_hash')
        ->selectRaw('DATE_FORMAT(transaction_details.created_at,"%d-%m-%Y") as created_at')
        ->selectRaw('case when transaction_details.paymentstatus=0 then "Verification Pending" when transaction_details.paymentstatus=1 then "Pending" when transaction_details.paymentstatus=2 then "Confirmed" when transaction_details.paymentstatus=3 then "Cancelled" when transaction_details.paymentstatus=4 then "Failed" when transaction_details.paymentstatus=5 then "Expired" end as status')
        ->selectRaw('case when transaction_details.paymentstatus=0 then "badge-warning" when transaction_details.paymentstatus=1 then "badge-warning" when transaction_details.paymentstatus=2 then "badge-success" when transaction_details.paymentstatus=3 then "badge-danger" when transaction_details.paymentstatus=4 then "badge-danger" when transaction_details.paymentstatus=5 then "badge-danger" end as statusclass')
        ->orderByRaw('transaction_details.id DESC')
        ->get();
        return view('user.withdrawhistory')->with('history',$withhistory);
    }






}
