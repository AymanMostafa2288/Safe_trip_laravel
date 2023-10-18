<?php
namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Repositories\Interfaces\admin_management\AdminInterface;
use App\Repositories\Interfaces\setting_management\LanguageInterface;
use Location;
use App\Models\Chart;
use ArielMejiaDev\LarapexCharts\LarapexChart;


class BaseController extends Controller{


    public function index(Request $request){

        $return=[];
        $chars_sql=Chart::get();
        $chars=Chart::transformCollection($chars_sql);

        $chartjs=[];
        $chartjs['pie']=[];
        foreach($chars as $chart){
            $labels=explode(',',$chart->labels);
            $width=$chart->width;
            $height=$chart->height;
            $name=$chart->name;
            $id=$chart->id;



            if($chart->type=='pie'){

                $config_datasate=json_decode($chart->datasate_config,true);
                $array_config_datasate=[];
                foreach($config_datasate['id'] as $key=>$config){
                    $arr=[];
                    $arr['lable']=$config_datasate['lable'][$key];
                    $arr['color']=$config_datasate['color'][$key];
                    $array_config_datasate[$config]=$arr;
                }

                $sql_statments=json_decode($chart->sql_statments,true);
                $array_sql_statments=[];
                foreach($sql_statments['id'] as $key=>$statments){

                    $arr=[];
                    $arr['param']=$sql_statments['param'][$key];
                    $arr['sql']=$sql_statments['sql'][$key];
                    $arr['sql_defult']=$sql_statments['sql_defult'][$key];

                    $arr['counters']=DB::select($sql_statments['sql_defult'][$key])[0]->counter ;
                    $array_sql_statments[$statments]=$arr;
                }

                $colors=array_column($array_config_datasate,'color');
                $counters=array_column($array_sql_statments,'counters');

                $chartshape = (new LarapexChart)->setType('pie')
                ->setDataset($counters)
                ->setLabels($labels)
                ->setColors($colors)
                ->setWidth($width)
                ->setHeight($height);
                $chartjs['pie'][$name]=$chartshape;
            }elseif($chart->type=='bar'){
                $config_datasate=json_decode($chart->datasate_config,true);
                $array_config_datasate=[];
                foreach($config_datasate['id'] as $key=>$config){
                    $arr=[];
                    $arr['lable']=$config_datasate['lable'][$key];
                    $arr['color']=$config_datasate['color'][$key];
                    $arr['sqls']=[];
                    $arr['counters']=[];
                    $array_config_datasate[$config]=$arr;
                }
                $sql_statments=json_decode($chart->sql_statments,true);
                foreach($sql_statments['id'] as $key=>$id){
                    if(array_key_exists($id,$array_config_datasate)){
                        $array_config_datasate[$id]['sqls'][$sql_statments['param'][$key]]=$sql_statments['sql_defult'][$key];
                        $counter=DB::select($sql_statments['sql_defult'][$key])[0]->counter ;
                        if(!$counter){
                            $counter=0;
                        }
                        $array_config_datasate[$id]['counters'][]=$counter;
                    }
                }
                $colors=array_column($array_config_datasate,'color');

                $chartshape = (new LarapexChart)->barChart();
                foreach($array_config_datasate as $dataSet){
                    $chartshape =$chartshape->addData($dataSet['lable'], $dataSet['counters']);
                }

                $chartshape =$chartshape->setColors($colors);
                $chartshape =$chartshape->setWidth($width);
                $chartshape =$chartshape->setHeight($height);
                $chartshape =$chartshape->setXAxis($labels);
                $chartjs['bar'][$name]=$chartshape;
            }elseif($chart->type=='line'){

            }
        }

        $return['charts']=$chartjs;


        return viewBackend('home_page','index',$return);
    }
    public function login_page(Request $request){
        return viewBackend('auth');
    }
    public function login(LoginRequest $request){
        if (Auth::guard('admin')->attempt(
            [
                'email' => $request->email,
                'password' => $request->password,
                'is_active' => 1
        ], true)) {

            return redirect()->intended('/dashboard');
        }
        $return['message']='Invalid Email Or Password Please';
        $return['email']=$request->email;
        return viewBackend('auth','index',$return);
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return viewBackend('auth');
    }
    public function profile(){
        $data=Auth::guard('admin')->user()->toArray();
        $form=getForm('auth_management/profile','',$data);
        $config=[];
        $config['main_title']='Dashboard';
        $config['sub_title']='Profile';
        $config['breadcrumb']=[];

        return viewBackend('auth','profile',['form'=>$form,'config'=>$config]);
    }
    public function edit_profile(Request $request){
        app(AdminInterface::class)->save($request->all(),Auth::guard('admin')->id());
        return redirect()->back()->with('success', 'Your Data Updated Successfully');
    }

    public function switch_lang($lang){
        session(['language_dashboard'=>$lang]);
        return redirect()->back();
    }
    public function lang(){
        $table = getTable('setting_management/translate');
        $config=[];
        $config['main_title']='Dashboard';
        $config['sub_title']='Translate';
        $config['breadcrumb']=[];
        return viewBackend('global','index',['table'=>$table,'config'=>$config]);
    }
    public function one_lang($file,Request $request){
        $language=$request->slug;
        $path_lang=base_path() . '/resources/lang/'.$language.'/'.$file.'.php';
        $data=[];
        $data['file']=$file;
        $data['language']=$language;
        $data['words']=include($path_lang);

        $form=getForm('setting_management/translate','',$data);
        $config=[];
        $config['main_title']='Dashboard';
        $config['sub_title']='Translate & '.$language;
        $config['breadcrumb']=[];

        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }

    public function update_lang($file,$slug,Request $request){
        $path_lang=base_path() . '/resources/lang/'.$slug.'/'.$file.'.php';
        $words=[];
        foreach($request->words as $value){
            $words[$value['key']]=$value['value'];
        }
        $content=app(LanguageInterface::class)->get_content_file_lang($words,$slug);
        File::delete($path_lang);
        File::put($path_lang,$content);
        return redirect()->back()->with('success', 'Your Record Created Successfully');
    }









}
