<?php

namespace App\Http\Controllers\backend\builder_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\builder_management\TeansfareInterface;
use Location;
use DB;
class TeansfareController extends Controller
{
    private $repository;
    public function __construct(TeansfareInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $table = getTable('builder_management/transfare');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Transfare Data';
        $config['breadcrumb']=[];
        return viewBackend('global','index',['table'=>$table,'config'=>$config]);
    }

    public function trasfare_data(Request $request){
        set_time_limit(2000);
        $tables=[];
        $start=0;
        $limit=10000;
        if($request->id==1){
            $tables['state']='osoule_country';
            $tables['state_translate']='osoule_country_translate';
        }elseif($request->id==2){
            $tables['city']='osoule_city';
            $tables['city_translate']='osoule_city_translate';
        }elseif($request->id==3){
            $tables['area']='osoule_area';
            $tables['area_translate']='osoule_area_translate';
        }elseif($request->id==4){
            $tables['account']='osoule_account';
        }elseif($request->id==5){
            $tables['company']='osoule_company';
        }elseif($request->id==6){
            $tables['delegate']='osoule_delegates';
        }elseif($request->id==7){
            $tables['categories']='osoule_property_categories';
            $tables['categories_translate']='osoule_property_categories_translate';
        }elseif($request->id==8){
            $tables['features']='osoule_features';
            $tables['features_translate']='osoule_features_translate';
        }elseif($request->id==9){
            $tables['properties']='osoule_property';
            // $tables['properties_features']='osoule_property_features';
            // dd('asdasd');
            $start=9000;
            $limit=1000000;
        }elseif($request->id==10){
            $tables['projects']='osoule_project';
            $tables['projects_translate']='osoule_project_translate';
            $tables['projects_features']='osoule_project_features';
        }elseif($request->id==11){
            $tables['blogs']='osoule_blogs';
            $tables['blogs_translate']='osoule_blogs_translate';
            $tables['blogs_url']='osoule_blogs';
        }elseif($request->id==12){
            $tables['click_properties']='osoule_property_clicks';
            $tables['click_projects']='osoule_projects_click';

        }elseif($request->id==13){
            $tables['view_properties']='osoule_property_views';
            $start=5000;
            $limit=5000;
        }

    
        foreach($tables as $key=>$value){
            $this->handel_data_to_transfare($key,$value,$start,$limit);
        }
        return redirect()->back()->with('success', 'Your Record Transfared Successfully');
    }

    ///////////////////////////////////////////////////////////////////// For Data Transfare

        private function getArray($row,$type,$check=false,$lang='en'){
            $arr=[];
            if($type=='delegate'){
                $arr['code']=randomNumber(4);
                $arr['first_name']=$row->first_name;
                $arr['last_name']=$row->last_name;
                $arr['email']=$row->email;
                $arr['phone']=$row->phone;
                $arr['whatsapp']=$row->whatsapp;
                $arr['password']=$row->password;
                $arr['image']=($row->image_url)?$row->image_url:'default/user_account.png';
                $arr['role']='broker';
                $arr['company_id']=$check->id;
                $arr['status']='active';
                $arr['created_at']=$row->created_at;
            }elseif($type=='company'){
                $arr['id']=$row->company_name;
                $arr['code']=randomNumber(4);
                $arr['name']=($row->company_name)?$row->company_name:$row->first_name.' '.$row->last_name;
                $arr['hotline']=$row->phone;
                $arr['email']=$row->email;
                $arr['logo']='notFound.png';
                $arr['head_office']=$row->company_address;
                $arr['about_company']=$row->about_company;
                $arr['account_id']=$row->id;
                $arr['type']='broker';
                $arr['created_at']=$row->created_at;
            }elseif($type=='account'){
                $arr['first_name']=$row->first_name;
                $arr['last_name']=$row->last_name;
                $arr['email']=$row->email;
                $arr['phone']=$row->phone;
                $arr['whatsapp']=$row->whatsapp;
                $arr['password']=$row->password;
                $arr['image']=($row->image_url)?$row->image_url:'notFound.png';
                $arr['type']=($row->type==2)?'broker':'individual';
                $arr['status']='active';
                $arr['social_login_by']=null;
                $arr['social_login_code']=null;
                $arr['verification_at']=date('Y-m-d');
                $arr['gender']=null;
                $arr['birth_date']=null;
                $arr['free_listing']=0;
                $arr['sponsor_listing']=0;
                $arr['sponsor_listing']=0;
                $arr['created_at']=$row->created_at;
            }elseif($type=='state'){
                $arr['id']=$row->id;
                $arr['name']=$row->name;
                $arr['note']=null;
                $arr['created_at']=$row->created_at;
            }elseif($type=='city'){
                $arr['id']=$row->id;
                $arr['name']=$row->name;
                $arr['note']=null;
                $arr['status']='published';
                $arr['country_id']=$check->id;
                $arr['home_page']=0;
                $arr['image']='notFound.png';
                $arr['created_at']=$row->created_at;
            }elseif($type=='area'){
                $arr['id']=$row->id;
                $arr['name']=$row->name;
                $arr['note']=null;
                $arr['status']='published';
                $arr['city_id']=$check->id;
                $arr['created_at']=$row->created_at;
            }elseif($type=='categories'){
                $arr['id']=$row->id;
                $arr['title']=$row->name;
                $arr['status']='published';
                $arr['type']='c_sale';
                $arr['tags']=$row->name;
                $arr['created_at']=$row->created_at;
            }elseif($type=='projects'){
                $image='notFound.png';
                $images=null;
                if($row->images && $row->images!='[]'){
                    $images_array=array_values(json_decode($row->images,true));
                    $image=$images_array[0];
                    unset($images_array[0]);
                    if(count($images_array) > 0){
                        $images=json_encode($images_array);
                    }
                }
                $company=DB::table('osoule_company')->where('account_id',$row->company_id)->first();
                if($company){
                    $company_id=$company->id;
                    $delegate=DB::table('osoule_delegates')->where('company_id',$company_id)->first();
                    $delegate_id=null;
                    if($delegate){
                        $delegate_id=$delegate->id;
                    }

                }else{
                    $company_id=12;
                    $delegate_id=null;
                }

                if($row->lat==null || $row->lng==null){
                    $location=null;
                }else{
                    $location=$row->lat.','.$row->lng;
                }
                $area=DB::table('osoule_area')->where('id',$row->city_id)->first();
                if($area){
                    $area_id=$area->id;
                    $city_id=$area->city_id;
                    $state_id=DB::table('osoule_city')->where('id',$city_id)->first()->country_id;
                }else{
                    $area_id=null;
                    $city_id=$row->city_id;
                    $state=DB::table('osoule_city')->where('id',$city_id)->first();
                    if(!$state){
                        return false;
                    }
                    $state_id=$state->country_id;
                }



                $arr['id']=$row->id;
                $arr['code']=randomNumber(4);
                $arr['name']=$row->name;
                $arr['status']='published';
                $arr['is_featured']=0;
                $arr['desctiption']=$row->description;
                $arr['content']=$row->content;
                $arr['company_id']=$company_id;
                $arr['delegate_id']=$delegate_id;

                $arr['country_id']=$state_id;
                $arr['city_id']=$city_id;
                $arr['area_id']=$area_id;

                $arr['location']=$location;
                $arr['video_url']=null;

                $arr['image']=$image;
                $arr['images']=$images;

                $arr['delivery_date']=null;
                $arr['payment_systems']=null;
                $arr['faqs']=null;
                $arr['created_at']=$row->created_at;
            }elseif($type=='properties'){
                if($row->type=='sale'){
                    $type='r_for_sale';
                }elseif($row->type=='rent'){
                    $type='r_for_rent';
                }elseif($row->type=='commercial_for_sale'){
                    $type='c_for_sale';
                }elseif($row->type=='commercial_for_rent'){
                    $type='c_for_rent';
                }

                $image='notFound.png';
                $images=null;
                if($row->images && $row->images!='[]'){
                    $images_array=array_values(json_decode($row->images,true));
                    $image=$images_array[0];
                    if($image==null){
                        $image='notFound.png';
                    }else{
                        unset($images_array[0]);
                        if(count($images_array) > 0){
                            $images_array = array_filter($images_array);
                            $images=json_encode($images_array);
                        }
                    }

                }


                $company_id=null;
                $delegate_id=null;
                $account_id=$row->author_id;
                if($check->type=='broker'){

                    $company_id=DB::table('osoule_company')->where('account_id',$account_id)->first()->id;
                    $delegate=DB::table('osoule_delegates')->where('company_id',$company_id)->first();
                    if($delegate){
                        $delegate_id=$delegate->id;
                    }
                }





                if($row->lat==null || $row->lng==null){
                    $location=null;
                }else{
                    $location=$row->lat.','.$row->lng;
                }

                $area=DB::table('osoule_area')->where('id',$row->city_id)->first();
                if($area){
                    $area_id=$area->id;
                    $city_id=$area->city_id;
                    $state_id=DB::table('osoule_city')->where('id',$city_id)->first()->country_id;
                }else{
                    $area=DB::table('osoule_area')->where('city_id',$row->city_id)->first();
                    if($area){
                        $area_id=$area->id;
                    }else{
                        $area_id=null;
                    }
                    $city_id=$row->city_id;
                    $state_id=DB::table('osoule_city')->where('id',$city_id)->first();
                    if(!$state_id){
                        dd($state_id);
                        return false;
                    }
                    $state_id=DB::table('osoule_city')->where('id',$city_id)->first()->country_id;
                }

                $project_id=null;

                if($row->project_id){
                    $project=DB::table('osoule_project')->where('id',$row->project_id)->first();
                    if($project){
                        $project_id=$project->id;
                    }else{
                        $data=DB::connection('mysql2')->table('re_projects')->where('id',$row->project_id)->first();

                        $arr_projects=$this->getArray($data,'projects');
                        if($arr_projects!=false){
                            $array=[];
                            $array[]=$arr_projects;
                            DB::table('osoule_project')->insert($array);
                            $project_id=$arr_projects['id'];
                        }else{

                            return false;
                        }
                    }
                }
                if($row->category_id){
                    $category=DB::table('osoule_property_categories')->where('id',$row->category_id)->first();
                    if(!$category){
                        return false;
                    }
                }else{
                    return false;
                }



                // $arr['id']=$row->id;
                $arr['code']=randomNumber(4,$row->id);
                $arr['name']=$row->name;
                $arr['moderation_status']='published';
                $arr['type']=$type;
                $arr['category_id']=$row->category_id;

                $arr['is_featured']=$row->is_featured;
                $arr['is_trusted']=$row->powered_by;
                $arr['is_registered']=0;

                $arr['description']=$row->description;
                $arr['content']=$row->content;

                $arr['account_id']=$account_id;
                $arr['company_id']=$company_id;
                $arr['delegate_id']=$delegate_id;

                $arr['country_id']=$state_id;
                $arr['city_id']=$city_id;
                $arr['area_id']=$area_id;
                $arr['location']=$location;
                $arr['address']=$row->location;

                $arr['project_id']=$project_id;

                $arr['main_image']=$image;
                $arr['images']=$images;
                $arr['files']=null;
                $arr['video_url']=null;

                $arr['area_meter']=(in_array($row->category_id,[29,11]))?null:$row->square;
                $arr['area_acres']=(in_array($row->category_id,[29,11]))?$row->square:null;
                $arr['totaly_price']=(in_array($type,['r_for_sale','c_for_sale']))?$row->price:null;
                $arr['price_per_month']=(in_array($type,['r_for_rent','c_for_rent']))?$row->price:null;
                $arr['rooms']=$row->number_bedroom;;
                $arr['bathroom']=$row->number_bathroom;;
                $arr['floor']=$row->number_floor;;
                $arr['building_floors']=null;
                $arr['date_of_construction']=null;
                $arr['finishing_type']=null;
                $arr['overlooking']=null;
                $arr['rejected_reason']=null;
                $arr['added_from']='website';
                $arr['published_at']=date('Y-m-d H:i:s');
                $arr['furnished']=null;
                $arr['payment_method']=null;
                $arr['down_payment']=null;
                $arr['installment']=null;

                $arr['created_at']=$row->created_at;
            }elseif($type=='features'){
                $arr['id']=$row->id;
                $arr['name']=$row->name;
                $arr['icon']=$row->icon;
            }elseif($type=='projects_features'){
                $arr['feature_id']=$row->feature_id;
                $arr['project_id']=$row->project_id;
            }elseif($type=='properties_features'){
                $arr['feature_id']=$row->feature_id;
                $arr['property_id']=$row->property_id;
            }elseif($type=='categories_blogs'){
                $arr['id']=$row->id;
                $arr['title']=$row->name;
                $arr['note']=$row->description;
            }elseif($type=='blogs'){
                $arr['id']=$row->id;
                $arr['code']=randomNumber(4);
                $arr['name']=$row->name;
                $arr['status']='published';
                $arr['description']=$row->description;
                $arr['content']=$row->content;
                $arr['image']=$row->image;
                $arr['images']=null;
                $arr['file']=null;
                $arr['video']=null;
                $arr['faqs']=null;
                $arr['blog_category_id']=2;
                $arr['created_at']=$row->created_at;

            }elseif($type=='state_translate'){
                if($lang=='ar'){
                    $arr['name']=$row->title;
                }else{
                    $arr['name']=$row->name;
                }

                $arr['note']=null;
                $arr['country_id']=$check->id;
                $arr['lang']=$lang;
            }elseif($type=='city_translate'){
                if($lang=='ar'){
                    $arr['name']=$row->title;
                }else{
                    $arr['name']=$row->name;
                }

                $arr['note']=null;
                $arr['city_id']=$check->id;
                $arr['lang']=$lang;
            }elseif($type=='area_translate'){
                if($lang=='ar'){
                    $arr['name']=$row->title;
                }else{
                    $arr['name']=$row->name;
                }
                $arr['note']=null;
                $arr['tags']=null;
                $arr['area_id']=$check->id;
                $arr['lang']=$lang;
            }elseif($type=='categories_translate'){
                if($lang=='ar'){
                    $arr['title']=$row->title;
                }else{
                    $arr['title']=$row->title;
                }
                $arr['property_categories_id']=$check->id;
                $arr['lang']=$lang;
            }elseif($type=='features_translate'){
                if($lang=='ar'){
                    $arr['name']=$row->title;
                }else{
                    $arr['name']=$row->name;
                }
                $arr['features_id']=$check->id;
                $arr['lang']=$lang;
            }elseif($type=='blogs_translate'){
                if($lang=='ar'){
                    $arr['name']=$row->title;
                }else{
                    $arr['name']=$row->name;
                }
                $arr['description']=$row->description;
                $arr['content']=$row->content;
                $arr['blogs_id']=$check->id;
                $arr['lang']=$lang;
            }elseif($type=='projects_translate'){
                if($lang=='ar'){
                    $arr['name']=$row->title;
                    $arr['desctiption']=$row->description;
                }else{
                    $arr['name']=$row->name;
                    $arr['desctiption']=$row->desctiption;
                }

                $arr['content']=$row->content;
                $arr['project_id']=$check->id;
                $arr['lang']=$lang;
            }elseif($type=='click_properties'){
                $data=$this->loaction_data($row->ip);
                $arr['property_id']=$row->property_id;
                $arr['ip']=$row->ip;
                $arr['country_id']=$data['state'];
                $arr['city_id']=$data['city'];
                $arr['account_id']=null;
                $arr['delegate_id']=null;
                $arr['phone']=null;
                $arr['name']=null;
                $arr['type']='phone';
                $arr['created_at']=$row->created_at;


            }elseif($type=='click_projects'){
                $data=$this->loaction_data($row->ip);
                $arr['project_id']=$row->project_id;
                $arr['ip']=$row->ip;
                $arr['country_id']=$data['state'];
                $arr['city_id']=$data['city'];
                $arr['account_id']=null;
                $arr['delegate_id']=null;
                $arr['phone']=null;
                $arr['name']=null;
                $arr['type']='phone';
                $arr['created_at']=$row->created_at;


            }elseif($type=='view_properties'){
                // $data=$this->loaction_data($row->ip);
                $arr['property_id']=$check->id;
                $arr['ip']=$row->ip;
                $arr['country_id']=null;
                $arr['city_id']=null;
                $arr['duration']=$row->total;
                $arr['created_at']=$row->date;

            }
            return $arr;
        }
        private function handel_data_to_transfare($type,$table,$offset=0,$limit=500){

            $arrays=[];
            if($type=='state'){
                $data=DB::connection('mysql2')->table('states')
                ->where('status','published')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                $arrays=[];
                foreach($data as $row){
                    $arr=$this->getArray($row,$type);
                    if($arr!=false){
                        $arrays[]=$arr;
                    }
                }

            }elseif($type=='city'){
                $data=DB::connection('mysql2')->table('cities')
                ->where('status','published')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                $arrays=[];
                foreach($data as $row){
                    $state=DB::table('osoule_country')->where('id',$row->state_id)->first();
                    if($state){
                        $arr=$this->getArray($row,$type,$state);
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }
            }elseif($type=='area'){
                $data=DB::connection('mysql2')->table('areas')
                ->where('status','published')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                foreach($data as $row){
                    $city=DB::table('osoule_city')->where('id',$row->city_id)->first();
                    if($city){
                        $arr=$this->getArray($row,$type,$city);
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }

            }elseif($type=='account'){
                $data=DB::connection('mysql2')->table('re_accounts')
                ->leftJoin('media_files','re_accounts.avatar_id','media_files.id')
                ->select('re_accounts.*','media_files.url as image_url')
                ->where('re_accounts.id',1598)
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                $arrays=[];
                foreach($data as $row){
                    $arr=$this->getArray($row,$type);
                    if($arr!=false){
                        $arrays[]=$arr;
                    }
                }
            }elseif($type=='company'){
                $data=DB::connection('mysql2')->table('re_accounts')
                ->where('type',2)
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                foreach($data as $row){
                    $account=DB::table('osoule_account')->where('id',$row->id)->first();
                    if($account){
                        $arr=$this->getArray($row,$type,$account);
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }
            }elseif($type=='delegate'){
                $data=DB::connection('mysql2')->table('re_accounts')
                ->leftJoin('media_files','re_accounts.avatar_id','media_files.id')
                ->select('re_accounts.*','media_files.url as image_url')
                ->whereNotNull('author_id')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                foreach($data as $row){
                    $company=DB::table('osoule_company')->where('account_id',$row->author_id)->first();
                    if($company){
                        $arr=$this->getArray($row,$type,$company);
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }
            }elseif($type=='features'){
                $data=DB::connection('mysql2')->table('re_features')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                foreach($data as $row){
                    $arr=$this->getArray($row,$type);
                    if($arr!=false){
                        $arrays[]=$arr;
                    }
                }
            }elseif($type=='categories'){
                $data=DB::connection('mysql2')->table('re_categories')
                ->where('status','published')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                foreach($data as $row){
                    $arr=$this->getArray($row,$type);
                    if($arr!=false){
                        $arrays[]=$arr;
                    }
                }
            }elseif($type=='projects'){
                $data=DB::connection('mysql2')->table('re_projects')
                ->leftJoin('re_projects_account','re_projects_account.project_id','re_projects.id')
                ->select('re_projects.*','re_projects_account.account_id as company_id')
                ->where('moderation_status','approved')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                foreach($data as $row){
                    $arr=$this->getArray($row,$type);
                    if($arr!=false){
                        $arrays[]=$arr;
                    }
                }
            }elseif($type=='projects_features'){
                $data=DB::connection('mysql2')->table('re_project_features')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                foreach($data as $row){
                    $project=DB::table('osoule_project')->where('id',$row->project_id)->first();
                    $features=DB::table('osoule_features')->where('id',$row->feature_id)->first();
                    if($project && $features){
                        $arr=$this->getArray($row,$type);
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }

                }
            }elseif($type=='properties'){
                $data=DB::connection('mysql2')
                ->table('re_properties')
                ->where('author_id',1598)
                ->get()
                ->toArray();
                
                // $ids=[];
                // $old_ids=DB::select('SELECT `osoule_property`.id from `osoule_property`');
                // foreach($old_ids as $old_id){
                //     $ids[]=$old_id->id;
                // }
                // $data=DB::connection('mysql2')
                // ->table('re_properties')
                // ->where('moderation_status','approved')
                // ->whereNotIn('re_properties.id',$ids)->select('re_properties.*')->get()->toArray();
                
                foreach($data as $row){
                    
                    // if($row->author_id){
                    //      $account=DB::table('osoule_account')
                    // ->where('id',$row->author_id)
                    // ->first();
                    // }else{
                    //      $account=DB::table('osoule_account')
                    //     ->where('id',274)
                    //     ->first();
                    // }
                    $account=DB::table('osoule_account')
                        ->where('id',1608)
                        ->first();
                   
                    if($account){
                        $arr=$this->getArray($row,'properties',$account);
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }

            }elseif($type=='properties_features'){
                $data=DB::connection('mysql2')->table('re_property_features')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                foreach($data as $row){
                    $property=DB::table('osoule_property')->where('id',$row->property_id)->first();
                    $features=DB::table('osoule_features')->where('id',$row->feature_id)->first();
                    if($property && $features){
                        $arr=$this->getArray($row,$type);
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }
            }elseif($type=='categories_blogs'){
                $data=DB::connection('mysql2')->table('tags')
                ->where('status','published')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                $arrays=[];
                foreach($data as $row){
                    $arr=$this->getArray($row,$type);
                    if($arr!=false){
                        $arrays[]=$arr;
                    }
                }
            }elseif($type=='blogs'){
                $data=DB::connection('mysql2')->table('posts')
                ->select('posts.*')
                ->join('post_categories','post_categories.post_id','posts.id')
                ->where('post_categories.category_id',10)
                ->where('posts.status','published')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                foreach($data as $row){
                    $arr=$this->getArray($row,$type);
                    if($arr!=false){
                        $arrays[]=$arr;
                    }
                }
            }elseif($type=='state_translate'){
                $data=DB::connection('mysql2')->table('content_language')
                ->where('element','location_state')
                ->where('lang','ar')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                $arrays=[];
                foreach($data as $row){
                    $state=DB::table('osoule_country')->where('id',$row->element_id)->first();
                    if($state){
                        $arr=$this->getArray($state,$type,$state,'en');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                        $arr=$this->getArray($row,$type,$state,'ar');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }
            }elseif($type=='city_translate'){
                $data=DB::connection('mysql2')->table('content_language')
                ->where('element','location_city')
                ->where('lang','ar')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                $arrays=[];
                foreach($data as $row){
                    $state=DB::table('osoule_city')->where('id',$row->element_id)->first();
                    if($state){
                        $arr=$this->getArray($state,$type,$state,'en');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                        $arr=$this->getArray($row,$type,$state,'ar');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }
            }elseif($type=='area_translate'){
                $data=DB::connection('mysql2')->table('content_language')
                ->where('element','location_area')
                ->where('lang','ar')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                $arrays=[];
                foreach($data as $row){
                    $state=DB::table('osoule_area')->where('id',$row->element_id)->first();
                    if($state){
                        $arr=$this->getArray($state,$type,$state,'en');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                        $arr=$this->getArray($row,$type,$state,'ar');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }
            }elseif($type=='categories_translate'){
                $data=DB::connection('mysql2')->table('content_language')
                ->where('element','real_estate_category')
                ->where('lang','ar')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                $arrays=[];
                foreach($data as $row){
                    $state=DB::table('osoule_property_categories')->where('id',$row->element_id)->first();
                    if($state){
                        $arr=$this->getArray($state,$type,$state,'en');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                        $arr=$this->getArray($row,$type,$state,'ar');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }
            }elseif($type=='features_translate'){
                $data=DB::connection('mysql2')->table('content_language')
                ->where('element','real_estate_feature')
                ->where('lang','ar')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                $arrays=[];
                foreach($data as $row){
                    $state=DB::table('osoule_features')->where('id',$row->element_id)->first();
                    if($state){
                        $arr=$this->getArray($state,$type,$state,'en');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                        $arr=$this->getArray($row,$type,$state,'ar');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }
            }elseif($type=='blogs_translate'){
                $data=DB::connection('mysql2')->table('content_language')
                ->where('element','blog_post')
                ->where('lang','ar')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                $arrays=[];
                foreach($data as $row){
                    $state=DB::table('osoule_blogs')->where('id',$row->element_id)->first();
                    if($state){
                        $arr=$this->getArray($state,$type,$state,'en');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                        $arr=$this->getArray($row,$type,$state,'ar');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }
            }elseif($type=='projects_translate'){
                $data=DB::connection('mysql2')->table('content_language')
                ->where('element','real_estate_project')
                ->where('lang','ar')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                $arrays=[];
                foreach($data as $row){
                    $state=DB::table('osoule_project')->where('id',$row->element_id)->first();
                    if($state){
                        $arr=$this->getArray($state,$type,$state,'en');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                        $arr=$this->getArray($row,$type,$state,'ar');
                        if($arr!=false){
                            $arrays[]=$arr;
                        }
                    }
                }
            }elseif($type=='click_properties'){
                $data=DB::connection('mysql2')->table('clicks_counter')
                ->select(DB::raw('count(*) as total'),'property_id')
                ->groupBy('property_id')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();

                $arrays=[];
                foreach($data as $row){
                    if($row->property_id){
                        $property=DB::table('osoule_property')->where('id',$row->property_id)->first();
                        if($property){
                            $data=DB::connection('mysql2')->table('clicks_counter')
                            ->where('property_id',$row->property_id)->get()
                            ->toArray();

                            foreach($data as $row){
                                $arr=$this->getArray($row,$type);
                                if($arr!=false){
                                    $arrays[]=$arr;
                                }
                            }


                        }
                    }

                }
            }elseif($type=='click_projects'){
                $data=DB::connection('mysql2')->table('clicks_counter')
                ->select(DB::raw('count(*) as total'),'project_id')
                ->groupBy('project_id')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();

                $arrays=[];
                foreach($data as $row){
                    if($row->project_id){
                        $property=DB::table('osoule_project')->where('id',$row->project_id)->first();
                        if($property){
                            $data=DB::connection('mysql2')->table('clicks_counter')
                            ->where('project_id',$row->project_id)->get()
                            ->toArray();

                            foreach($data as $row){
                                $arr=$this->getArray($row,$type);
                                if($arr!=false){
                                    $arrays[]=$arr;
                                }
                            }


                        }
                    }

                }
            }elseif($type=='view_properties'){
                $data=DB::table('osoule_property')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
                
                $arrays=[];
                foreach($data as $row_1){
                    
                    $data2=DB::connection('mysql2')
                    ->table('views_counter')
                    ->select(DB::raw('count(*) as total'),'ip', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'))
                    ->where('property_id',$row_1->id)
                    ->groupBy('ip','date')
                    ->get();
                    
                    foreach($data2 as $row){
                        $arr=$this->getArray($row,$type,$row_1);
                        
                        if($arr!=false){
                            $arrays[]=$arr;
                            
                        }
                        
                    }
                   
                    DB::table($table)->insert($arrays);
                }
                
            }elseif($type=='blogs_url'){
                $data=DB::connection('mysql2')->select("SELECT slugs.* FROM `slugs` WHERE `reference_type` like '%Post' and reference_id in (select posts.id from posts JOIN post_categories ON post_categories.post_id=posts.id where post_categories.category_id=10)");

                foreach($data as $value){
                    $exists=DB::table('osoule_blogs')->where('id',$value->reference_id)->first();
                    if($exists){
                        DB::table('osoule_blogs')->where('id',$value->reference_id)->update(['site_url'=>$value->key]);
                    }
                }
                return true;
            }
            /*
            SELECT slugs.* FROM `slugs` WHERE `reference_type` like '%Post' and reference_id in (select posts.id from posts JOIN post_categories ON post_categories.post_id=posts.id where posts.status='published' and post_categories.category_id=10)
            */
            $array_chanks=array_chunk($arrays,1000);
            foreach($array_chanks as $arry){
                DB::table($table)->insert($arry);
            }

            // DB::table($table)->insert($arrays);
            return true;

        }
        private function loaction_data($ip){
            $data = Location::get($ip);
            $state='';
            $city='';
            $return=[];
            $return['state']=null;
            $return['city']=null;
            if($data){
                $state=$data->regionName;
                $city=$data->cityName;
                $state=DB::table('osoule_country')->where('name','like','%'.$state.'%')->first();
                if($state){
                    $return['state']=$state->id;
                }
                $city=DB::table('osoule_city')->where('name','like','%'.$city.'%')->first();
                if($city){
                    $return['city']=$city->id;
                    $return['state']=$city->country_id;
                }
            }
            return $return;
        }

    ///////////////////////////////////////////////////////////////////// For Data Transfare

}
