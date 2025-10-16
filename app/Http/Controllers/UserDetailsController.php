<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\VerificationEmail;
use App\UserDetails;
use App\User;
use DB;
use Session;
use Illuminate\Support\Facades\Crypt;

class UserDetailsController extends Controller
{
    //Admin
    public function getAdminUnpaid(){
            $members=DB::table('users')->where([['users.licence','1'],['user_details.userstatus','0']])
            ->join('user_details','users.id','=','user_details.userid')
            ->select('users.id as id', 'users.usersname as name', 'users.uuid as userid', 'users.email as email', 'users.doj as doj', 'user_details.total_investment as totalinvestment')
            ->selectRaw('case when user_details.userstatus=0 then "Unpaid" when user_details.userstatus=1 then "Paid" end as status')
            ->selectRaw('case when user_details.userstatus=0 then "status-cancelled" when user_details.userstatus=1 then "status-complete" end as statusclass')
            ->orderByRaw('users.created_at DESC')
            ->get();
            return view('control.totalunpaid')->with('members',$members);
    }

    public function getAdminPaid(){
            $members=DB::table('users')->where([['users.licence','1'],['user_details.userstatus','1']])
            ->join('user_details','users.id','=','user_details.userid')
            ->join('users as gd','gd.id','=','user_details.sponsorid')
            ->select('users.id as id', 'users.usersname as name', 'users.uuid as userid', 'users.email as email', 'users.doj as doj', 'user_details.current_self_investment as current', 'gd.uuid as guiderid', 'user_details.active_direct as activedirect')
            ->selectRaw('case when user_details.userstatus=0 then "Unpaid" when user_details.userstatus=1 then "Paid" end as status')
            ->selectRaw('case when user_details.userstatus=0 then "status-cancelled" when user_details.userstatus=1 then "status-complete" end as statusclass')
            ->orderByRaw('users.created_at DESC')
            ->get();
            return view('control.totalpaid')->with('members',$members);
    }

    public function getAdminLevel(){
            $members=DB::table('users')->where([['users.licence','1'],['user_details.leveluser','>','0']])
            ->join('user_details','users.id','=','user_details.userid')
            ->join('users as gd','gd.id','=','user_details.sponsorid')
            ->select('users.id as id', 'users.usersname as name', 'users.uuid as userid', 'users.email as email', 'users.doj as doj', 'user_details.current_self_investment as current', 'gd.uuid as guiderid', 'user_details.active_direct as activedirect', 'user_details.leveluser as leveluser')
            ->selectRaw('case when user_details.userstatus=0 then "Unpaid" when user_details.userstatus=1 then "Paid" end as status')
            ->selectRaw('case when user_details.userstatus=0 then "status-cancelled" when user_details.userstatus=1 then "status-complete" end as statusclass')
            ->orderByRaw('users.created_at DESC')
            ->get();
            return view('control.totalopenlevel')->with('members',$members);
    }

    public function getAdminBooster(){
            $members=DB::table('users')->where([['users.licence','1'],['user_details.booster','2']])
            ->join('user_details','users.id','=','user_details.userid')
            ->join('users as gd','gd.id','=','user_details.sponsorid')
            ->select('users.id as id', 'users.usersname as name', 'users.uuid as userid', 'users.email as email', 'users.doj as doj', 'user_details.current_self_investment as current', 'gd.uuid as guiderid', 'user_details.active_direct as activedirect', 'user_details.leveluser as leveluser')
            ->selectRaw('case when user_details.userstatus=0 then "Unpaid" when user_details.userstatus=1 then "Paid" end as status')
            ->selectRaw('case when user_details.userstatus=0 then "status-cancelled" when user_details.userstatus=1 then "status-complete" end as statusclass')
            ->orderByRaw('users.created_at DESC')
            ->get();
            return view('control.totalbooster')->with('members',$members);
    }

    public function getAdminAll(Request $request){
            if($request->method()==="GET"){
                $fromDate=date('Y-m-d');
                $toDate=date('Y-m-d').' 23:59:59';
            }else{
                $fromDate=$request->fromdate;
                $toDate=$request->todate.' 23:59:59';
            }
            $members=DB::table('users')->where('users.licence','1')
            ->whereBetween('users.created_at',[$fromDate,$toDate])
            ->join('user_details','users.id','=','user_details.userid')
            ->join('users as gd','gd.id','=','user_details.sponsorid')
            ->select('users.id as id', 'users.usersname as name', 'users.uuid as userid', 'users.email as email', 'users.doj as doj', 'user_details.current_self_investment as current', 'gd.uuid as guiderid', 'user_details.active_direct as activedirect')
            ->selectRaw('case when user_details.userstatus=0 then "Unpaid" when user_details.userstatus=1 then "Paid" end as status')
            ->selectRaw('case when user_details.userstatus=0 then "status-cancelled" when user_details.userstatus=1 then "status-complete" end as statusclass')
            ->orderByRaw('users.created_at DESC')
            ->get();
            return view('control.totalmembers')->with('members',$members);
    }

    public function MemberEdit($userid, Request $request)
    {
        $memberedit=DB::table('users')->where([['users.licence','1'],['users.uuid',$userid]])
        ->join('user_details','users.id','=','user_details.userid')
        ->join('users as gd','gd.id','=','user_details.sponsorid')
        ->leftJoin('asset_details','asset_details.userid','=','user_details.id')
        ->select('users.id as id', 'users.usersname as usersname', 'users.uuid as uuid', 'users.s_password as showpassword', 'users.ccode as ccode', 'users.email as email', 'users.contact as contact', 'users.permission as permission', 'user_details.leveluser as levelpercentage', 'gd.uuid as guiderid', 'gd.usersname as guidername', 'asset_details.bep20addr as bep20address', 'asset_details.usdttrc20addr as usdtaddress', 'asset_details.usdtbep20addr as usdtbep20address')
        ->selectRaw('case when asset_details.asset_status=0 then "Not Open" when asset_details.asset_status=1 then "Open" end as asset_status')
        ->selectRaw('case when user_details.roi_status=0 then "Not Open" when user_details.roi_status=1 then "Open" end as roi_status')
        ->selectRaw('case when user_details.booster=1 then "Inactive" when user_details.booster=2 then "Active" end as booster_status')
        ->get()->first();
        return view('control.memberdetail')->with('editdata',$memberedit);
    }
    public function MemberUpdate(Request $request)
    {
        Validator::make($request->all(), [
            'name'      => ['required', 'string','regex:/^[a-zA-Z0-9\s]|[^<>]+$/u'],
            'uuid'      => ['required', 'string','regex:/^MWT|mwt|Mwt[0-9]{7}+$/'],
            'contact'      => ['nullable', 'numeric'],
            'oldemail' => ['nullable', 'string', 'email'],
            'email' => ['required', 'string', 'email'/*, 'unique:users'*/],
            'bep20address'      => ['string','nullable','regex:/^0x[a-fA-F0-9]{40}$/u'],
            'usdtaddress'      => ['string','nullable','regex:/^T[a-zA-Z0-9]{33}$/u'],
            'usdtbep20address'      => ['string','nullable','regex:/^0x[a-fA-F0-9]{40}$/u'],
        ])->validate();

        $userdt=DB::table('user_details')->where([['users.licence','1'],['users.uuid',$request->uuid]])
        ->join('users','users.id','=','user_details.userid')
        ->select('users.id as id', 'user_details.id as uid')
        ->get()->first();
        $newmailcheck=\App\User::where('email',$request->email)->first();
        
        /*if (!is_null($newmailcheck) && $request->oldemail!=$request->email) {
            return redirect('/Main/User/'.$request->uuid)->with('warning','Email Already Exists. Please use a different email.');
        }*/
        $updusr=DB::table('users')->where('id',$userdt->id)->update([
            'usersname' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            ]);
        
        $useredit=\App\AssetDetail::firstOrNew(array('userid'=>$userdt->uid));
        if(!is_null($request->bep20address))
            $useredit->bep20addr=$request->bep20address;
        if(!is_null($request->usdtaddress))
            $useredit->usdttrc20addr=$request->usdtaddress;
        if(!is_null($request->usdtbep20address))
            $useredit->usdtbep20addr=$request->usdtbep20address;
        $useredit->save();
        return redirect('/Main/User/'.$request->uuid)/*->back()*/->with('success','Profile Successfully Edited');
    }
    public function AdminUserPassword(Request $request)
    {
        Validator::make($request->all(), [
            'userid'      => ['required', 'string'],
            'password'      => ['required', 'string','regex:/^[a-zA-Z0-9\s]|[^<>]+$/u'],
        ])->validate();

        $userdts=DB::table('users')->where([['licence','1'],['uuid',$request->userid]])
        ->select('id')
        ->get()->first();
        $updpass=DB::table('users')->where([['id',$userdts->id],['uuid',$request->userid]])->update([
            'password' => Hash::make($request->password),
            's_password' => Crypt::encrypt($request->password),
            ]);
        return redirect()->back()->with('success','Password Successfully Edited');
    }

    public function MemberLock($userid, Request $request)
    {
        $memberID=DB::table('users')->where([['permission',1],['uuid',$userid]])
        ->join('user_details','users.id','=','user_details.userid')
        ->select('users.id as id','user_details.id as userid')
        ->first();
        $return=DB::table('users')->where('id',$memberID->id)->update([
            'permission' => '0',
            ]);
        
        return redirect()->back()->with(['success'=>'Member Locked for Login Successfully.']);
    }
    public function MemberUnlock($userid, Request $request)
    {
        $memberID=DB::table('users')->where([['permission',0],['uuid',$userid]])
        ->join('user_details','users.id','=','user_details.userid')
        ->select('users.id as id','user_details.id as userid','user_details.level as level','user_details.sponsorid as sponsorid')
        ->first();
        /*$countlevel=DB::table('level_details')->where('status',1)->get();*/
        $return=DB::table('users')->where('id',$memberID->id)->update([
            'permission' => '1',
            ]);
        
        return redirect()->back()->with(['success'=>'Member Unlocked for Login Successfully.']);
    }
    public function updateUserPermission($userid, Request $request){
        Validator::make($request->all(), [
            'assetstatus'      => ['string','required'],
            'usdtnull'      => ['string','nullable'],
            'usdtbep20null'      => ['string','nullable'],
            'levelpercentage'      => ['numeric','required'],
            'roistatus'      => ['string','required'],
            'boosterstatus'      => ['string','required'],
        ])->validate();
        
        if ($request->assetstatus=='Not Open') {
            $assetst=0;
        }elseif ($request->assetstatus=='Open') {
            $assetst=1;
        }
        if ($request->roistatus=='Not Open') {
            $roist=0;
        }elseif ($request->roistatus=='Open') {
            $roist=1;
        }
        if ($request->boosterstatus=='Inactive') {
            $btst=1;
        }elseif ($request->boosterstatus=='Active') {
            $btst=2;
        }
        $member=DB::table('users')->where([['permission',1],['uuid',$userid]])
        ->join('user_details','users.id','=','user_details.userid')
        ->select('users.id as id','user_details.id as userid','user_details.active_direct as active_direct')
        ->first();
        if($request->levelpercentage>0){
            $updlevel=DB::table('user_details')->where('id',$member->userid)->update([
                'leveluser' => $request->levelpercentage,
                'level_status' => 2,
            ]);
        }

        $updroi=DB::table('user_details')->where('id',$member->userid)->update([
            'roi_status' => $roist,
            'booster' => $btst,
        ]);
        
        if(!is_null($request->usdtnull)){
            $updusr=DB::table('asset_details')->where('userid',$member->userid)->update([
                'usdttrc20addr' => NULL,
            ]);
        }
        if(!is_null($request->usdtbep20null)){
            $updusr=DB::table('asset_details')->where('userid',$member->userid)->update([
                'usdtbep20addr' => NULL,
            ]);
        }
        $userasset=\App\AssetDetail::firstOrNew(array('userid'=>$member->userid));
        if(!is_null($assetst))
            $userasset->asset_status=$assetst;
            $userasset->save();
        
       
        return redirect()->back()->with(['success'=>'Permission Updated Successfully.']);
    }
    public function searchUserbyUserId(Request $request){
        $datareg=$this->findUserName($request->userrid);
        $showdata=DB::table('users')->where([['licence','1'],['uuid',$request->userrid]])
        ->select('users.id as id')
        ->get()->first();
        if (is_null($showdata)) {
            return redirect()->back()->with(['warning'=>'User Not Found']);
        }
        else{
            return redirect('/Main/User/'.$request->userrid);
        }
        
    }
    
    public function searchUserbyAdmin(){
        return view('control.memberdetail')->with('editdata',array());
    }





    //User
    public function showEditData(){
        $memberdt=DB::table('user_details')->where([['users.licence','1'],['user_details.id','1']])
        ->leftJoin('users','users.id','=','user_details.userid')
        ->leftJoin('users as gd','gd.id','=','user_details.sponsorid')
        ->leftJoin('asset_details','asset_details.userid','=','user_details.id')
        ->select('users.usersname', 'users.email', 'users.contact', 'users.ccode','users.wallet_address','users.doj', 'gd.usersname as guidername', 'gd.email as guiderid', 'asset_details.bep20addr as styaddress', 'asset_details.usdttrc20addr as usdttrc20address', 'asset_details.usdtbep20addr as usdtbep20address')
        ->get()->first();
        $editstatus=\App\AssetDetailChanges::where([['userid',\Session::get('user.id')],['asset_status','>',0]])->first();

        return view('user.profile')->with('profile',$memberdt)->with('changeasset',$editstatus);
    }
    public function userUpdate(Request $request){
        set_time_limit(0);
        $editstatus=\App\AssetDetailChanges::where([['userid',\Session::get('user.id')],['asset_status','>',0]])->first();
        if(is_null($editstatus)){
            $vali=Validator::make($request->all(), [
                'mwtaddress'      => ['string','nullable','regex:/^0x[a-fA-F0-9]{40}$/u'],
                'usdtaddress'      => ['string','nullable','regex:/^T[a-zA-Z0-9]{33}$/u'],
                'usdtbep20address'      => ['string','nullable','regex:/^0x[a-fA-F0-9]{40}$/u'],
            ])->validate();//dd($vali->errors());
            $userdt=DB::table('user_details')->where([['users.licence','1'],['user_details.id',Session::get('user.id')]])
            ->join('users','users.id','=','user_details.userid')
            ->select('users.id as id', 'users.id as uid','users.email as email')
            ->get()->first();
            $userdetail=array();
            if(!is_null($request->mwtaddress))
                $userdetail['bep20addr']=$request->mwtaddress;
            if(!is_null($request->usdtaddress))
                $userdetail['usdttrc20addr']=$request->usdtaddress;
            if(!is_null($request->usdtbep20address))
                $userdetail['usdtbep20addr']=$request->usdtbep20address;
            if(sizeof($userdetail)>0){
                $userdetail['userid']=\Session::get('user.id');
                $userdetail['token']=rand(100000,999999);
                $userdetail['email']=$userdt->email;
                $userdetail['email_time']=now();
                $userDetailSave=\App\AssetDetailChanges::insertGetId($userdetail);
                $userdetail['view']="otpMail";
                $userdetail['subject']="OTP to confirm profile changes";
                $userdetail['useruuid']=\Session::get('user.userid');
                $mail=new SupportQueryController();
                $response=$mail->sendMailgun($userdetail);
                if($response==0)
                    $status=1;
                else
                    $status=2;
                $updstatus=\App\AssetDetailChanges::where('id',$userDetailSave)->update(['asset_status'=>$status,'updated_at'=>now()]);
            }
            //return redirect()->back()->with('success','Changes Saved Successfully.');
            return redirect()->back()->with('success','Verification mail sent to your mail id .Confirm it to save changes.');
        }else{
            $vali=Validator::make($request->all(), [
                'otp'      => ['integer','required',],
            ])->validate();
            if($editstatus->token==$request->otp){
                $checkUser=\App\AssetDetailChanges::where('id',$editstatus->id)->first();
                if(!is_null($checkUser)){
                    $updateUser=\App\AssetDetail::firstOrCreate(['userid'=>$checkUser->userid]);
                    if(!is_null($checkUser->bep20addr))
                    $updateUser->bep20addr=$checkUser->bep20addr;
                    if(!is_null($checkUser->usdttrc20addr))
                    $updateUser->usdttrc20addr=$checkUser->usdttrc20addr;
                    if(!is_null($checkUser->usdtbep20addr))
                    $updateUser->usdtbep20addr=$checkUser->usdtbep20addr;
                    $updateUser->asset_status=1;
                    $updateUser->updated_at=now();
                    $updateUser->save();
                    $deleteUser=\App\AssetDetailChanges::where('id',$checkUser->id)->delete();
                    return redirect()->to('/User/EditProfile')->with('success','Your Profile Edits Are Live Now.');
                }
            }else{
                return redirect()->to('/User/EditProfile')->with('warning','Invalid OTP . Please check email and enter again.');
            }
        }
    }

    public function showChangePass(){
        $memberdt=DB::table('user_details')->where([['users.licence','1'],['user_details.id',Session::get('user.id')]])
        ->leftJoin('users','users.id','=','user_details.userid')
        ->leftJoin('users as gd','gd.id','=','user_details.sponsorid')
        ->leftJoin('asset_details','asset_details.userid','=','user_details.id')
        ->select('users.usersname', 'users.email', 'users.contact', 'users.ccode', 'gd.usersname as guidername', 'gd.email as guiderid', 'asset_details.bep20addr as bep20address', 'asset_details.usdttrc20addr as usdtaddress')
        ->get()->first();

        return view('user.changepassword');
    }
    public function UserChangePass(Request $request){
        Validator::make($request->all(), [
            'oldpassword'      => ['required', 'string'],
            'password'=> ['required', 'string', 'min:5', 'confirmed'],
        ])->validate();
        //$oldpass=Hash::make($request->oldpassword);
        
        $userdts=DB::table('users')->where([['licence','1'],['user_details.id',Session::get('user.id')]])
        ->join('user_details','user_details.userid','=','users.id')
        ->select('users.id as id', 'users.password as password')
        ->get()->first();

        if(\Hash::check($request->oldpassword, $userdts->password)){
        $updpass=DB::table('users')->where([['id',$userdts->id],['licence','1']])->update([
            'password' => Hash::make($request->password),
            's_password' => Crypt::encrypt($request->password),
            ]);
        return redirect()->back()->with('success','Password Successfully Changed');
        }else{
            return redirect()->back()->with('warning','Invalid Old Password');
        }
    }

    public function getDirect(){
        $directList=DB::table('user_details')->where([['user_details.id',Session::get('user.id')],['u.permission','1']])
        ->join('user_details as ud','user_details.userid','=','ud.sponsorid')
        ->join('users as u','ud.userid','=','u.id')
        ->select('user_details.id as search','u.id as id', 'u.usersname as name', 'u.uuid as userid', 'u.email as username', 'u.doj as doj', 'ud.current_self_investment as shares', 'ud.total_self_investment as totalself','ud.total_investment as teamtotal')
        ->selectRaw('case when ud.userstatus=0 then "Inactive" when ud.userstatus=1 then "Active" end as status')
        ->selectRaw('case when ud.userstatus=0 then "FF0000 " when ud.userstatus=1 then "3cd2a5 " end as statusclass')
        ->orderByRaw('u.id DESC')
        ->get();
        
        return view('user.teamdirect')->with('direct',$directList);
    }
    public function getTotal(){
        $ar=array();
        $usrid=DB::table('user_details')->where('id',Session::get('user.id'))->get()->pluck('userid')->first();
        $udata=DB::table('users')->where('id',$usrid)->get()->first();
        if(is_null($udata)){

            return view('user.teamtotal')->with('Warning','This User Does Not Exists.');
        }
        else{
                $uid=array($usrid);
                for($i=1;$i<101;$i++){
                    
                        $rData=User::where('users.permission','1')
                        ->whereIn('ud.sponsorid',$uid)
                        ->join('user_details as ud','users.id','=','ud.userid')
                        ->join('users as gu','ud.sponsorid','=','gu.id')
                        ->leftJoin(DB::raw('(SELECT * FROM stacking_deposites WHERE id IN (SELECT MIN(id) FROM stacking_deposites GROUP BY userid)) as first_stack'), 'ud.id', '=', 'first_stack.userid')
                        ->select('users.id as id','users.usersname as name','users.email as username','users.uuid as userid','ud.current_self_investment as current'/*,'gu.usersname as guidername','gu.user_gf as guidergf'*/)
                        ->selectRaw('"Level-'. $i.'" as level,DATE_FORMAT(users.doj,"%d-%m-%Y") as doj')
                        ->selectRaw('case when ud.userstatus=0 then "Inactive" when ud.userstatus=1 then "Active" end as status')
                        ->selectRaw('case when first_stack.staketype=1 then "3cd2a5 " when first_stack.staketype=2 then "FF0000 " when first_stack.staketype=3 then "FFD700 " when first_stack.staketype=4 then "ffffff " else "FF0000 " end as statusclass')
                        ->get();
                        foreach ($rData as $key ) {
                           array_push($ar, $key);
                        }
                        $id=DB::table('user_details')->whereIn('sponsorid',$uid)->selectRaw('userid')->get()->pluck('userid');
                        if(count($id)==0||$id=="")
                            break;
                        else{  
                            $uid=$id;
                        }

                }
                /*dd($ar);*/

                return view('user.teamtotal')->with('totaldown',$ar);
            }   
    }
public function getTreeView()
{
    $userId = Session::get('user.id');

    // Root user (self details)
    $rootUser = DB::table('users as u')
        ->join('user_details as ud', 'u.id', '=', 'ud.userid')
        ->select(
            'u.id',
            'u.usersname as name',
            'u.email',
            'u.uuid as userid',
            'ud.current_self_investment as package',
            'ud.total_self_investment as totalself',  
            'ud.total_investment as teamtotal',    
            DB::raw('DATE_FORMAT(u.doj,"%d-%m-%Y") as doj'),
            DB::raw('CASE WHEN ud.userstatus=0 THEN "Inactive" WHEN ud.userstatus=1 THEN "Active" END as status'),
            DB::raw('CASE WHEN ud.userstatus=0 THEN "FF0000" WHEN ud.userstatus=1 THEN "3cd2a5" END as statusclass')
        )
        ->where('u.id', $userId)
        ->first();

    // Recursive function to fetch children
    $fetchChildren = function($parentId, $level = 1) use (&$fetchChildren) {
        $children = DB::table('users as u')
            ->join('user_details as ud', 'u.id', '=', 'ud.userid')
            ->select(
                'u.id',
                'u.usersname as name',
                'u.email',
                'u.uuid as userid',
                'ud.current_self_investment as package',
                'ud.total_self_investment as totalself',
                'ud.total_investment as teamtotal',     
                DB::raw('DATE_FORMAT(u.doj,"%d-%m-%Y") as doj'),
                DB::raw('CASE WHEN ud.userstatus=0 THEN "Inactive" WHEN ud.userstatus=1 THEN "Active" END as status'),
                DB::raw('CASE WHEN ud.userstatus=0 THEN "FF0000" WHEN ud.userstatus=1 THEN "3cd2a5" END as statusclass'),
                DB::raw("'Level-{$level}' as level")
            )
            ->where('ud.sponsorid', $parentId)
            ->get();

        foreach ($children as $child) {
            $child->children = $fetchChildren($child->id, $level + 1);
        }

        return $children;
    };

    $rootUser->children = $fetchChildren($rootUser->id);

    return view('user.treeview', compact('rootUser'));
}



    public function userTeamSummary(){
        $userdetails=\App\UserDetails::where([['user_details.id',Session::get('user.id')]])
        ->select('id as id','total_direct as totaldirect','active_direct as activedirect','total_downline as totaldownline','active_downline as activedownline','current_direct_investment as directbusiness','current_investment as totalbusiness','current_self_investment as currentself')
        ->get()->first();
        /*dd($userdetails);*/
        return view('user.teamsummary')->with('details',$userdetails);
    }



}
