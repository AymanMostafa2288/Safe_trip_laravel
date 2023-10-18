<?php

namespace App\Http\Controllers\frontend\website_management\Pages;

use App\Http\Controllers\Controller;
use App\Services\PartnerService;
use Location;

use Illuminate\Http\Request;
use Exception;

use DB;
use Illuminate\Support\Facades\Validator;

//================================================

class AboutPageController extends Controller
{
    public function index(Request $request){
        $partners=app(PartnerService::class)->index([],1,20)['body'];
        $passing_data=[];
        $passing_data['partners']=$partners;
        return viewFrontEnd('about','index',$passing_data);
    }
}
