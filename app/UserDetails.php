<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class UserDetails extends Model
{
    public $timestamps=false;

    protected $fillable=['userid','sponserid','level','total_direct','active_direct','total_downline','active_downline','level_income','roi_income','wallet_amount','total_investment','current_investment','total_level_investment','current_level_investment','total_self_investment','current_self_investment','total_direct_investment','current_direct_investment','level_status','capping','roi_status','updated_at','userstatus','userstate','booster','loan_attempts','power_protected'];


    public function stackingDeposite(){
        return $this->hasMany('\App\StackingDeposite','userid','id');
    }

    public function stackingIncome(){
        return $this->hasMany('\App\CpsIncome','userid','id')->get();
    }

    public function levelIncome(){
        return $this->hasMany('\App\LevelIncome','userid','id')->get();
    }

    public function bonusReward(){
        return $this->hasMany('\App\BonusReward','userid','id')->get();
    }

    public function clubIncome(){
        return $this->hasMany('\App\ClubIncome','userid','id')->get();
    }

    public function totalIncome(){
        return $this->stackingIncome()->sum('amount')+$this->levelIncome()->sum('amount')+$this->bonusReward()->sum('amount')+$this->clubIncome()->sum('amount');
    }

    public function totalIncomeUSDT(){
        return $this->stackingIncome()->sum('amt_usdt')+$this->levelIncome()->sum('amt_usdt')+$this->bonusReward()->sum('amt_usdt')+$this->clubIncome()->sum('amt_usdt');
    }

    public function remainingIncome(){
        return $this->stackingIncome()->where('status',0)->sum('remaining')+$this->levelIncome()->where('status',0)->sum('remaining')+$this->bonusReward()->where('status','!=',3)->sum('remaining')+$this->clubIncome()->where('status',0)->sum('remaining');
    }

    public function lockedIncome(){
        return $this->stackingIncome()->where('status',3)->sum('remaining')+$this->levelIncome()->where('status',3)->sum('remaining')+$this->bonusReward()->where('status',3)->sum('remaining')+$this->clubIncome()->where('status',3)->sum('remaining');
    }

    public function lifetimeIncome(){
        return $this->hasMany('\App\AchievementIncome','userid','id')->get();
    }

    public function assetDetail(){
        return $this->hasOne('\App\AssetDetail','userid','id')->first();
    }

    public function user(){
        return $this->hasOne('\App\User','id','userid')->first();
    }

    public function totalDirect(){
        return $this->hasMany('\App\UserDetails','sponsorid','userid');
    }

    public function totalWithdraw(){
        return $this->hasMany('\App\TransactionDetail','userid','id')->where([['txntype',1],['txndesc','Withdrawal'],['paymentstatus',2]])->get();
    }

    public function guiderDetails(){
        return $this->hasOne('\App\UserDetails','userid','sponsorid');
    }

    public function directDetails(){
        return $this->totalDirect()->join('users' ,'user_details.userid','=','users.id')
        ->selectRaw('concat(email,"( ",usersname," )") as name,case when userstatus=1 then "circleGreen" when userstatus=0 then "circleRed" end as class,userid,sponsorid')
        ->get();
    }

    public function accountDeposite(){
        return $this->hasMany('\App\AccountDeposite','userid','id')->get();
    }
    
    public function userLoanStatus()
    {
        return $this->hasOne('\App\LoanDetails','userid','id')->first();
    }

    public function boosterCheck(){
        return ($this->booster==2)?true:false;
    }

    public function levelStatus(){
        $allLevel=\App\LevelDetails::where('status',1)->orderBy('levelname','desc')->get();
        $inv=$this->total_investment-$this->total_self_investmet;
        $userLevel=$allLevel->where('min_amount','<=',$inv)->where('direct_count','<=',$this->active_direct);//->where('max_amount','>=',$inv)
        return (!is_null($userLevel->first()))?$userLevel->first()->cps:0;
    }

    public function clubBusiness(){
        $direct=\App\UserDetails::where('sponsorid',$this->userid)->orderBy('total_investment','desc')->get();
        if (sizeof($direct)>0) {
            $first=(float)($direct->first()->total_investment);
            $rest=(($direct->sum('total_investment'))-$first);
        }
        else{
            $first=0;
            $rest=0;
        }
        return array('first'=>$first,'rest'=>$rest);
    }

    public function lifetimeAchievementBusiness(){
        $d=\App\UserDetails::where('sponsorid',$this->userid)->orderBy('total_investment','desc')->get();
        $direct=$d->all();
        $arr=[];
        if (sizeof($direct)>0) {
            $first=(float)array_shift($direct)['total_investment'];
            $second=(float)array_shift($direct)['total_investment'];
            $rest=(($d->sum('total_investment'))-($first+$second));//dd($arr);
        }
        else{
            $first=0;
            $second=0;
            $rest=0;
        }
        return array('first'=>$first,'second'=>$second,'rest'=>$rest);
    }

    public function remainingCapping(){
        $plans=\App\StackingDeposite::where('userid',$this->id)->get();
        $remaining=0;
        if (sizeof($plans)) {
            foreach($plans as $plan){
                $remaining+=Crypt::decrypt($plan->capamount);
            }
        }
        return $remaining;
        
    }
    
}
