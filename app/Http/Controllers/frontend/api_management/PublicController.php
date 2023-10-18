<?php

namespace App\Http\Controllers\frontend\api_management;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Exception;
//================================================

class PublicController extends Controller
{
    public function returnSuccess(){}
    public function returnError(){}
    //================================================
    public function getFcmNotifications(){}
    public function sendFcmNotifications(){}
    //================================================
    public function sendMail(){}
    //================================================
    public function getLanguages(){}
    public function getCurrentLanguage(){}
    //================================================
    public function sendOtpMessage(){}
    public function checkOtpMessage(){}
}
