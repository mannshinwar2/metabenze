<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\SupportQueryController;

class CpsIncomeController extends Controller
{
    public function cpsGeneration(){
       
        $getAllDeposit=\App\StackingDeposite::where([['status',1],['planid','>',0],['created_at','<',date('Y-m-d')]])->get();
        \Log::info('for planid '.$getAllDeposit);
        $profileStore=\App\ProfileStore::where('id',1)->first();
        
        foreach($getAllDeposit as $deposit){
            
            if(
                !is_null($deposit->walletTransfer()) && 
                $deposit->usdt==$deposit->walletTransfer()->amount &&
                $deposit->userDetail()->user()->permission==1 &&
                $deposit->userDetail()->capping !=1 &&
                $deposit->userDetail()->roi_status !=0
            ){
                $cps = $deposit->usdt * $deposit->planDetail()->cps / 100/date("t");
               
                $cappingFunction=new StackingDetailController();
                $returnAmount=$cappingFunction->cappingCalculation($deposit->userid,$cps);
              
                $insIncomeEntry=\App\CpsIncome::create([
                    'userid'        =>  $deposit->userid,
                    'txnid'         =>  $deposit->id,
                    'amount'        =>  $returnAmount/$profileStore->price,
                    'remaining'     =>  $returnAmount/$profileStore->price,
                    'amt_usdt'      =>  $returnAmount,
                    'status'        =>  0,
                    'created_at'    =>  now(),
                ]);
               
            }
        }
    }

    public function disburseLevel($amount,$userid){

    }


    //NowPayments
    public function showPage()
    {
        $userExistingPayment=\App\TransactionDetail::where([['userid','1'],['paymentstatus','<',2],['txntype',0],['release_date','>',date('Y-m-d H:i:s',strtotime('- 5 minutes',strtotime(now())))]])->join('transaction_infos','transaction_details.id','=','transaction_infos.txnid')
            ->select('comments as payment_id','transaction_infos.payment_addr as pay_address')->first();
        return view('user.depositnowpayment')->with('payment',$userExistingPayment);
    }

    public function submitTransaction(Request $request){\Log::info('Amount '.$request->amount);
        $validator=Validator::make($request->all(),[           
           'amount'     =>   ['required','numeric'],
        ]);
        if($validator->fails()){//dd($validator->errors(),$request->plan);
            return redirect('/User/Deposit')->with('errors',$validator->errors());
        }
        if($request->amount < 24){
            return redirect('/User/Deposit')->with('warning','amount should be greater than 25');
        }

        $arrayParm = array("price_amount"=> $request->amount,
          "price_currency"=> "usd",
          "pay_currency"=> "usdtbsc",
          "ipn_callback_url"=> "https://nowpayments.io",
          "is_fixed_rate"=> true,
          "is_fee_paid_by_user"=> false,
        );
        $npObject=new NPController();

        $paymentCreation=json_decode($npObject->createPayment($arrayParm));
        
        if(isset($paymentCreation->payment_status))
        {
            $insertTransactionDetails=\App\TransactionDetail::insertGetId([
                'userid'  =>  '1',
                'txntype'  =>  0,
                'amountsftc'  =>  0,
                'amountusdt'  =>  $request->amount,
                'remaining'  =>  $request->amount,
                'paymentstatus'  =>  0,
                'txndesc'  =>  'User Deposit',
                'comments'  =>  $paymentCreation->payment_id,
                'currency'  =>  $paymentCreation->pay_currency,
                'release_date'  =>  date('Y-m-d H:i:s',strtotime('+ 19 minutes',strtotime(now()))),
                'created_at'  =>  now(),
                'updated_at'  =>  now(),
            ]);
            $insertTransactionInfo=\App\TransactionInfo::create([
                'txnid'  =>  $insertTransactionDetails,
                'payment_addr'  =>  $paymentCreation->pay_address,
                'payee_addr'  =>  '',
                'transaction_hash'  =>  '',
                'amount'  =>  0,
                'contract_addr'  =>  $paymentCreation->purchase_id,
                'txn_status'  =>  0,
            ]);

            \Log::info(json_encode($paymentCreation));
            $transactionDetail=\App\TransactionDetail::where('transaction_details.id',$insertTransactionDetails)
            ->join('transaction_infos','transaction_details.id','=','transaction_infos.txnid')
            ->select('comments as payment_id','transaction_infos.payment_addr as pay_address')->first();
            return view('user.depositnowpayment')->with('payment',($transactionDetail));
        }else{
            $userExistingPayment=\App\TransactionDetail::where([['userid',\Session::get('user.id')],['paymentstatus','<',2]])->join('transaction_infos','transaction_details.id','=','transaction_infos.txnid')
            ->select('comments as payment_id','transaction_infos.payment_addr as pay_address')->first();
            return view('user.depositnowpayment')->with('payment',$userExistingPayment)->with('warning','Something went wrong. Please try again after some time.');
        }
        /*{ ▼
          +"payment_id": "5097213251"
          +"payment_status": "waiting"
          +"pay_address": "0x609579991050aF114D5127493C8C45C42BBa261d"
          +"price_amount": 100
          +"price_currency": "usd"
          +"pay_amount": 102.001234
          +"amount_received": 99.997366
          +"pay_currency": "usdterc20"
          +"order_id": null
          +"order_description": null
          +"payin_extra_id": null
          +"ipn_callback_url": "https://nowpayments.io"
          +"customer_email": null
          +"created_at": "2025-08-25T18:33:17.474Z"
          +"updated_at": "2025-08-25T18:33:17.474Z"
          +"purchase_id": "5867222481"
          +"smart_contract": null
          +"network": "eth"
          +"network_precision": null
          +"time_limit": null
          +"burning_percent": null
          +"expiration_estimate_date": "2025-08-25T18:53:17.474Z"
          +"is_fixed_rate": true
          +"is_fee_paid_by_user": true
          +"valid_until": "2025-09-01T18:33:17.474Z"
          +"type": "crypto2crypto"
          +"product": "api"
          +"origin_ip": "2409:40d4:205f:9d89:2d46:4b9b:3084:819"
        }*/
        /*$paymentCreation='{"payment_id":"5977953151","payment_status":"waiting","pay_address":"0x24070CE7202c541381F3dF0aeb58d253006b9262","price_amount":13,"price_currency":"usd","pay_amount":13.25552622,"amount_received":12.96277893,"pay_currency":"usdtbsc","order_id":null,"order_description":null,"payin_extra_id":null,"ipn_callback_url":"https://nowpayments.io","customer_email":null,"created_at":"2025-08-27T16:56:58.628Z","updated_at":"2025-08-27T16:56:58.628Z","purchase_id":"4740818607","smart_contract":null,"network":"bsc","network_precision":null,"time_limit":null,"burning_percent":null,"expiration_estimate_date":"2025-08-27T17:16:58.628Z","is_fixed_rate":true,"is_fee_paid_by_user":false,"valid_until":"2025-09-03T16:56:58.628Z","type":"crypto2crypto","product":"api","origin_ip":"157.48.244.247"}';*///dd(($paymentCreation));    
    }

    public function paymentStatus($id){
        $npObject=new NPController();

        $paymentCreation=json_decode($npObject->getPaymentStatus($id));
        $paymentStatus=0;//0=unpaid 1=paid 2=filed or returned
        $ransactionUrl='';
        $transactionMessage='';
        $transaction=\App\TransactionDetail::where([['paymentstatus','<',2],['comments',$id],['txntype',0]])->first();
        if(!is_null($transaction)){
            if($paymentCreation->payment_status=='failed' || $paymentCreation->payment_status=='refunded' || $paymentCreation->payment_status=='expired'){
                $transactionDetailUpate=\App\TransactionDetail::where('id',$transaction->id)->update([
                    'paymentstatus'  =>   3,
                    'updated_at'    =>  now(),
                ]);
                $transactionInfoUpdate=\App\TransactionInfo::where('txnid',$transaction->id)->update([
                    'txn_status'  =>  3,
                    'updated_at'    =>  now(),
                ]);
                $paymentStatus=2;
                $ransactionUrl='/User/Deposit';
                $transactionMessage='Your previous transaction either failed or refunded due to some reasons. Please initiate new transaction.';
                //return redirect('/User/Deposit')->with('warning','Your previous transaction either failed or refunded due to some reasons. Please initiate new transaction.');
            }elseif($paymentCreation->payment_status=='finished' || $paymentCreation->payment_status=='confirmed' || $paymentCreation->payment_status=='sending'|| ($paymentCreation->payment_status=='partially_paid' || $transaction->release_date<=date('Y-m-d H:i:s') && $transaction->remaining<=$paymentCreation->actually_paid)){
                $transactionDetailUpate=\App\TransactionDetail::where('id',$transaction->id)->update([
                    'paymentstatus'  =>   2,
                    'remaining' =>  0,
                    'amountusdt'    => $paymentCreation->actually_paid,
                    'updated_at'    =>  now(),
                ]);
                $transactionInfoUpdate=\App\TransactionInfo::where('txnid',$transaction->id)->update([
                    'txn_status'  =>  2,
                    'amount'    =>  $paymentCreation->actually_paid,
                    'transaction_hash'  =>  $paymentCreation->payin_hash,
                    'updated_at'    =>  now(),
                ]);
                $userWalletUpdate=\App\WalletTransfer::create([
                    'userid'  =>  $transaction->userid,
                    'txnid'  =>  $transaction->id,
                    'fromWallet'  =>  'deposite',
                    'toWallet'  =>  'wallet',
                    'amount'  =>  $paymentCreation->actually_paid,
                    'fromUser'  =>  $transaction->userid,
                    'release_date'  =>  date('Y-m-d'),
                    'created_at'  =>  now(),
                    'updated_at'  =>  now(),
                ]);
                $promotionalAdd=\App\AccountDeposit::firstOrNew([
                      'userid'    =>  $transaction->userid,
                  ]);
                if(!is_null($promotionalAdd->amount)){
                  $amt=Crypt::decrypt($promotionalAdd->amount)+($paymentCreation->actually_paid);
                }else{
                  $amt=($paymentCreation->actually_paid);
                }
                $promotionalAdd->amount=(Crypt::encrypt($amt));
                $promotionalAdd->save();
                $sendMail=new SupportQueryController();
                $userdt=\App\UserDetails::where('id',$transaction->userid)->first();
                try{
                    $details['email']=$userdt->user()->email;
                    $details['subject']='Your deposit confirmed at MetaWealths';
                    $details['view']='depositmail';
                    $details['amount']=$paymentCreation->actually_paid;
                    $details['userid']=$userdt->user()->uuid;
                    $status=$sendMail->sendMailgun($details);
                }catch(Exception $e){
                    \Log::info('Error in sending Topupmail for userid '.$transaction->userid);
                    \Log::info($e->messages());
                }
                $paymentStatus=1;
                $ransactionUrl='/User/Deposit';
                $transactionMessage='Transaction confirmed successfully. Amount transferred to your wallet.';
            }
        }
        \Log::info('payment status of id '.$id);\Log::info(json_encode($paymentCreation));
        \Log::info(json_encode(array('status'   =>  1,'payment_status'=>$paymentCreation->payment_status,'paid' =>$paymentCreation->actually_paid,'totalAmount' =>  $paymentCreation->pay_amount)));
        return json_encode(array('status'   =>  1,'payment_status'=>$paymentCreation->payment_status,'paid' =>$paymentCreation->actually_paid,'totalAmount' =>  $paymentCreation->pay_amount,'transaction_status'   =>$paymentStatus,'url'  =>  $ransactionUrl,'transaction_message'   =>  $transactionMessage));
        /*"{"payment_id":5093564248,"invoice_id":null,"payment_status":"waiting","pay_address":"0x44568B551126DE713C8EA19ec9eeB6081829d400","payin_extra_id":null,"price_amount":12,"price_currency":"usd","pay_amount":13.488185,"actually_paid":0,"pay_currency":"usdterc20","order_id":null,"order_description":null,"purchase_id":4628350473,"outcome_amount":null,"outcome_currency":"usdtbsc","payout_hash":null,"payin_hash":null,"created_at":"2025-08-26T16:31:32.669Z","updated_at":"2025-08-26T16:31:32.669Z","burning_percent":"null","type":"crypto2crypto"}"*/
    }


}
