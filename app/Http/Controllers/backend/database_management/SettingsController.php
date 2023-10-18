<?php

namespace App\Http\Controllers\backend\database_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Interfaces\database_management\SettingInterface;

class SettingsController extends Controller{

    private $repository;

	public function __construct(SettingInterface $repository)
	{
	   $this->repository = $repository;
	}
    
    public function index(){
        
        $form=getForm('database_management/connection');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='DataBase & Connections';
        $config['breadcrumb']=[];
        
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }

    public function connect_database(Request $request){
       
        foreach($request->all() as $key=>$value){
            if($key=='_token'){
                continue;
            }
            $this->repository->set_env($key,$value);
        }
        return redirect()->back()->with('success', 'Database updated!');
    }


  
}

?>
