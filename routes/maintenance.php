<?php

use Illuminate\Support\Facades\Route;

$dashboard_route = config('var.dashboard_route');
$api_route = config('var.api_route');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//StartNameSpaceExists
//database_management
//EndNameSpaceExists



$prefix='/';
if(request()->segment(2)=='en'){
    $prefix='en/';
}
Route::prefix($prefix)->namespace('frontend\website_management')->name('maintenance.')->group(function () {

});



