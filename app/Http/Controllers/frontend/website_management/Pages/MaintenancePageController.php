<?php

namespace App\Http\Controllers\frontend\website_management\Pages;

use App\Http\Controllers\Controller;
use Location;

use Illuminate\Http\Request;
use Exception;

use DB;
use Illuminate\Support\Facades\Validator;

//================================================

class MaintenancePageController extends Controller
{
    public function index(Request $request){
        $passing_data=[];
        app('debugbar')->disable();
        return viewFrontEnd('maintenance','index',$passing_data);
    }
}
