<?php

namespace App\Http\Controllers\frontend\website_management\Pages;

use App\Http\Controllers\Controller;
use App\Services\BlogService;
use App\Services\FaqService;
use App\Services\PartnerService;
use App\Services\ServiceService;
use App\Services\SliderService;
use Location;

use Illuminate\Http\Request;
use Exception;

use DB;
use Illuminate\Support\Facades\Validator;

//================================================

class HomePageController extends Controller
{
    public function index(Request $request){


        $sliders=app(SliderService::class)->index([],1,20)['body'];
        $services=app(ServiceService::class)->index(['in_home'=>1],1,6)['body'];
        $faqs=app(FaqService::class)->index([],1,20)['body'];
        $partners=app(PartnerService::class)->index([],1,20)['body'];
        $blogs=app(BlogService::class)->index([],1,3)['body'];

        $passing_data=[];
        $passing_data['sliders']=$sliders;
        $passing_data['services']=$services;
        $passing_data['faqs']=$faqs;
        $passing_data['partners']=$partners;
        $passing_data['blogs']=$blogs;
        return viewFrontEnd('homepage','index',$passing_data);
    }
}
