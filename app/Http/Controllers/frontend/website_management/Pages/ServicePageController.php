<?php

namespace App\Http\Controllers\frontend\website_management\Pages;

use App\Http\Controllers\Controller;
use App\Services\ServiceService;
use Location;

use Illuminate\Http\Request;
use Exception;

use DB;
use Illuminate\Support\Facades\Validator;

//================================================

class ServicePageController extends Controller
{
    public function index(Request $request){
        $page=1;
        if(array_key_exists('page',$_GET) && is_numeric($_GET['page'])){
            $page=$_GET['page'];
        }

        $services=app(ServiceService::class)->index([],$page);
        $passing_data=[];
        $passing_data['data']=$services;

        return viewFrontEnd('services','index',$passing_data);
    }
    public function show($slug){
        $services=app(ServiceService::class)->show('services/'.$slug);
        $passing_data=[];
        $passing_data['data']=$services;
        $passing_data['anothrt_services']=$this->anotherServices($services->id);

        return viewFrontEnd('services','show',$passing_data);
    }
    private function anotherServices($id){

        $page=1;
        $whereNotIn=[];
        $whereNotIn[]=[
            'id'=>[$id]
        ];
        $blogs=app(ServiceService::class)->index([],$page,15,$whereNotIn)['body'];
        return $blogs;
    }
}
