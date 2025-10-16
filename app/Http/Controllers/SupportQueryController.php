<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupportQuery;
use Session;
use Illuminate\Support\Facades\Validator;
use DB;

class SupportQueryController extends Controller
{
    //User
    public function viewUserTicket(){
        $ticketList=SupportQuery::where([['support_queries.uid',Session::get('user.id')],['inqid',0]])
        ->select('subject as sub','message as htext','title as title','support_queries.id as subid','support_queries.created_at as created_at','status as status')
        ->selectRaw('case when support_queries.status=0 then "New" when support_queries.status=1 then "Replied" when support_queries.status=2 then "Closed" end as status')
        ->selectRaw('case when support_queries.status=0 then "status-cancelled" when support_queries.status=1 then "status-pending" when support_queries.status=2 then "status-complete" end as statusclass')
        ->orderByRaw('support_queries.id DESC')
        ->get();

        if(\Session::get('isMobile')==0)
            return view('user.supportview')->with('ticket',$ticketList);
        else
            return view('mobile.supportview')->with('ticket',$ticketList);
    }

    public function UserCreateTicket(Request $request){
        Validator::make($request->all(),[
            'subject' =>['required','string','regex:/^[^<>]+$/u'],
            'message'=>['required','string','regex:/^[^<>]+$/u'],
            'title'=>['required','string','regex:/^[^<>]+$/u'],
        ])->validate();
        $insSupprt=SupportQuery::create([
            'uid'=> Session::get('user.id'),
            'subject'=> $request->subject,
            'title'=> $request->title,
            'message'=> $request->message,
            'status'=> 0,
            'created_at' => now(),
        ]);
        return redirect()->back()->with('success','Ticket submitted successfully.');
    }
    public function viewTicketSingleUser($title,$tid){

        $viewticket=SupportQuery::where([['support_queries.uid',Session::get('user.id')],['support_queries.inqid',$tid]])->orWhere('support_queries.id',$tid)
        ->join('user_details','support_queries.uid','=','user_details.id')
        ->select('subject as subject','message as htext','title as title','support_queries.repliedby as ustatus','support_queries.id as subid','support_queries.created_at as created_at')
        ->selectRaw('case when support_queries.status=0 then "New" when support_queries.status=1 then "Replied" when support_queries.status=2 then "Closed"  end as status')
        ->get();

        if(\Session::get('isMobile')==0)
            return view('user.supportreply')->with('viewticket',$viewticket);
        else
            return view('mobile.supportreply')->with('viewticket',$viewticket);
    }
    public function postReplyUser(Request $request){
        Validator::make($request->all(),[
            'ticket' =>['required','integer'],
            'textmsg'=>['required','string','regex:/^[^<>]+$/u'],
        ])->validate();
        $qry="insert into support_queries (uid,inqid,message,status,created_at) values (".Session::get('user.id').",".($request->ticket).",'".$request->textmsg."',0,'".now()."')";
        $d=DB::statement($qry);
        return redirect()->back()->with('success','Reply submitted successfully.');
    }



    //Admin
    public function adminsupport(){
        $ticketList=SupportQuery::where('inqid',0)
        ->join('user_details','support_queries.uid','=','user_details.id')
        ->join('users','user_details.userid','=','users.id')
        ->select('users.email as email','users.uuid as userid','subject as sub','message as htext','title as title','support_queries.id as subid','support_queries.created_at as created_at')
        ->selectRaw('case when support_queries.status=0 then "New" when support_queries.status=1 then "Replied" when support_queries.status=2 then "Closed" end as status')
        ->selectRaw('case when support_queries.status=0 then "status-cancelled" when support_queries.status=1 then "status-pending" when support_queries.status=2 then "status-complete" end as statusclass')
        ->orderBy('support_queries.id', 'desc')
        ->get();
        return view('control.support')->with('ticket',$ticketList);
    }

    public function viewTicketAdmin($title,$tid){

        $viewticket=SupportQuery::where('support_queries.inqid',$tid)->orWhere('support_queries.id',$tid)
        ->join('user_details','support_queries.uid','=','user_details.id')
        ->join('users','user_details.userid','=','users.id')
        ->select('users.email as email','users.uuid as uuid', 'user_details.id as userid', 'subject as subject','message as htext','title as title','support_queries.repliedby as ustatus','support_queries.id as subid','support_queries.created_at as created_at')
        ->selectRaw('case when support_queries.status=0 then "New" when support_queries.status=1 then "Replied" when support_queries.status=2 then "Closed" end as status')
        ->get();
        return view('control.supportview')->with('viewticket',$viewticket);
    }

    public function postReplyAdmin(Request $request){
        Validator::make($request->all(),[
            'user' =>['required','integer'],
            'ticket' =>['required','integer'],
            'textmsg'=>['required','string','regex:/^[^<>]+$/u'],
        ])->validate();
        $textmsg=str_replace("'", "`", $request->textmsg);
        $qry="insert into support_queries (uid,inqid,message,status,created_at,repliedby) values (".($request->user).",".($request->ticket).",'".$textmsg."',1,'".now()."',".Session::get('user.id').")";
        $d=DB::statement($qry);
        $statusUpdate=SupportQuery::where('id',$request->ticket)->update(["status"=>1]);
        return redirect()->back()->with('success','Reply submitted successfully.');
    }

    public function sendMailgun($data){
        $view=view('mail.'.$data['view'])->with('data',$data)->render();//\Log::info(is_string($view));\Log::info($view);
        //$otpinsert=\DB::table('password_resets')->insert(["email"=>$data['email'],"token"=>$data['code'],"created_at"=>now()]);
        try{
          $header = 'api:' . env('MAILGUN_API_KEY');
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.mailgun.net/v3/metawealths.com/messages',
              CURLOPT_USERPWD    => $header,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array('from' => 'MetaWealth <postmaster@metawealths.com>',
                'to' => $data['email'],
                'subject' => $data['subject'],
                'html' => $view
                ),
            ));//\Log::info($curl);
            $response = curl_exec($curl);$converted_response=json_decode($response,true);
            //\Log::info(json_decode($response,true));
            if(isset($converted_response['errors'])){
                \Log::info('errors in '.$data['view'].' for User '.$data['useruuid']);\Log::info($converted_response['errors']);
                curl_close($curl);
                return 0;
            }
            curl_close($curl);
            return 1;
        }
        catch(Exception $e){
            return 0;
        }
    }


    public function sendDatatoMetawallet($data){
        try{
            $curl = curl_init();
            $postData = [
                "HostId"        => 1,
                "Token"         => "635607b6743e4a876cb2a2a667ed488f",
                "emailid"       => $data['email'], 
                "mobileNo"      => $data['contact'],
                "name"          => $data['name'],
                "pincode"       => "302020",
                "referalIDStr"  => "AN1",
                "ReferralNo"  => "1111111111",
                "CustomLoginID" => $data['uniqueid'],
                "roleID" => 3,
                "Password"      => $data['password']
            ];
            /*\Log::info($postData);*/
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'http://metawallet.info/API/UserSignup',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => json_encode($postData),
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
              ),
            ));

            $response = curl_exec($curl);
            \Log::info(json_decode($response,true));

            curl_close($curl);

            return 1;
        }
        catch(Exception $e){
            \Log::info("metawallet api failed for userid ".$data['uniqueid']);
            return 0;
        }

    }

    public function sendPasswordtoMetawallet($data){
        try{
            $curl = curl_init();
            $postData = [
                "HostId"        => 1,
                "Token"         => "635607b6743e4a876cb2a2a667ed488f",
                "OldPassword"       => $data['oldpassword'],             
                "NewPassword"      => $data['newpassword'],
                "strUserId"          => $data['userid'],
            ];
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'http://metawallet.info/API/ChangePassword',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => json_encode($postData),
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
              ),
            ));

            $response = curl_exec($curl);
            \Log::info(json_decode($response,true));

            curl_close($curl);

            return 1;
        }
        catch(Exception $e){
            \Log::info("metawallet password api failed for userid ".$data['uniqueid']);
            return 0;
        }

    }

    public function directDataMetawallet(){
        try{
            $curl = curl_init();
            /*$postData = [
                "HostId"        => 1,
                "Token"         => "635607b6743e4a876cb2a2a667ed488f",
                "emailid"       => "dharma2796@gmail.com", 
                "pincode"       => "302020",             
                "mobileNo"      => "9988998899",
                "name"          => "Crew M",
                "referalIDStr"  => "MWT7655995",
                "ReferralNo"  => "1111111111",
                "CustomLoginID" => "MWT8082650",
                "roleID" => 3,
                "Password"      => "123123123"
            ];*/
            $postData = [
                "HostId"        => 1,
                "Token"         => "635607b6743e4a876cb2a2a667ed488f",
                "emailid"       => "dharma2796@gmail.com", 
                "mobileNo"      => "9988998261",
                "name"          => "Crew M",
                "pincode"       => "302020",
                "referalIDStr"  => "AN1",
                "ReferralNo"  => "1111111111",
                "CustomLoginID" => "MWT8082650",
                "roleID" => 3,
                "Password"      => "123123123"
            ];
            \Log::info($postData);
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'http://metawallet.info/API/UserSignup',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => json_encode($postData),
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
              ),
            ));

            $response = curl_exec($curl);
            \Log::info(json_decode($response,true));

            curl_close($curl);

            return 1;
        }
        catch(Exception $e){
            \Log::info("metawallet api failed for userid ".$data['uniqueid']);
            return 0;
        }

    }




}
