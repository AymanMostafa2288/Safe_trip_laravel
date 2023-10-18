<?php

namespace App\Http\Controllers\frontend\website_management\Pages;

use App\Http\Controllers\Controller;
use App\Services\BlogService;
use Location;

use Illuminate\Http\Request;
use Exception;

use DB;
use Illuminate\Support\Facades\Validator;

//================================================

class BlogPageController extends Controller
{
    public function index(Request $request){
        $page=1;
        if(array_key_exists('page',$_GET) && is_numeric($_GET['page'])){
            $page=$_GET['page'];
        }
        $blogs=app(BlogService::class)->index([],$page);
        $passing_data=[];
        $passing_data['data']=$blogs;
        return viewFrontEnd('blogs','index',$passing_data);
    }
    public function show($slug){

        $blogs=app(BlogService::class)->show('blogs/'.$slug);
        $passing_data=[];
        $passing_data['data']=$blogs;
        $passing_data['anothrt_blogs']=$this->lastBlogs($blogs->id);
        return viewFrontEnd('blogs','show',$passing_data);
    }
    private function lastBlogs($id){

        $page=1;
        $whereNotIn=[];
        $whereNotIn[]=[
            'id'=>[$id]
        ];
        $blogs=app(BlogService::class)->index([],$page,3,$whereNotIn)['body'];
        return $blogs;
    }
}
