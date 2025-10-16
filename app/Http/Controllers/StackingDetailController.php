<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class StackingDetailController extends Controller
{
     public function cappingCalculation($userid,$amount){
        $getAllDeposite=\App\StackingDeposite::where([['userid',$userid],['status','>',0]])->get();
        $totalAmount=0;
        foreach($getAllDeposite as $deposit){
            if($amount>0){
                if(Crypt::decrypt($deposit->capamount)<=$amount){
                    $remainingAmount=Crypt::decrypt($deposit->capamount)-$amount;
                    $totalAmount+=Crypt::decrypt($deposit->capamount);
                    $amount=$amount-Crypt::decrypt($deposit->capamount);
                    $updateUserDetailUserstate=\App\UserDetails::where('id',$userid);
                    $updateUserDetailUserstate->decrement('userstate');
                    /*$updateUserDetailUserstate->save();*/
                    $updateCapping=\App\StackingDeposite::where('id',$deposit->id)->update([
                        'capamount'  =>   Crypt::encrypt(0),
                        'status'  =>   0,
                    ]);
                }else{
                    $remainingAmount=Crypt::decrypt($deposit->capamount)-$amount;
                    $updateCapping=\App\StackingDeposite::where('id',$deposit->id)->update([
                        'capamount'  =>   Crypt::encrypt($remainingAmount),
                    ]);
                    $totalAmount+=$amount;
                    $amount=0;
                }
                \Log::info('userid '. $deposit->userid.' remaining Capping Amount is '.Crypt::decrypt($deposit->capamount));
            }
        }
        return $totalAmount;
    }
}
