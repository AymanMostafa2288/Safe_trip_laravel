<?php

namespace App\Http\Controllers\frontend\website_management\Pages;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\custom_modules_management\Contacts\ContactInterface;
use Location;

use Illuminate\Http\Request;
use Exception;

use DB;
use Illuminate\Support\Facades\Validator;

//================================================

class ContactPageController extends Controller
{
    public function index(Request $request){

        return viewFrontEnd('contact','index',[]);
    }
    public function store(Request $request){
        app(ContactInterface::class)->save($request->all());
        return redirect()->back()->with('success', 'Your message send successfully , and we will reply to you soon.');
    }
}
