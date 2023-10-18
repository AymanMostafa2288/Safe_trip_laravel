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


class ChartController extends Controller{


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



            }elseif($chart->type=='bar'){
                $chartshape = (new LarapexChart)->barChart()
                ->addData('Boston', $counters)
                ->setColors($colors)
                ->setWidth($width)
                ->setHeight($height)
                ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
                $chartjs['pie'][$name]=$chartshape;
            }
        }

        $return['charts']=$chartjs;


        return viewBackend('home_page','index',$return);
    }

    private function pieChart($chart){
        $labels=explode(',',$chart->labels);
        $width=$chart->width;
        $height=$chart->height;
        $name=$chart->name;
        $id=$chart->id;
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

        return $chartshape;
    }

    private function barChart($chart){

    }

// URL:: https://larapex-charts.netlify.app/3-more-charts/
//Type: Donut , Radial bar , Polar area , Line , Area , Herzontal Bar , HearMap , Radar










}
