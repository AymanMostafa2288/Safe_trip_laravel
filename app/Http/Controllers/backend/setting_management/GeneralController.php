<?php

namespace App\Http\Controllers\backend\setting_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Interfaces\setting_management\GeneralInterface;
use DB;
class GeneralController extends Controller{

    private $repository;

	public function __construct(GeneralInterface $repository)
	{
	   $this->repository = $repository;
	}

    public function index(){

        $data=$this->repository->data();

        $config=[];
        if(request()->type){
            if(request()->type=='static_pages'){
                $form=getForm('setting_management/static_pages','',$data);
                $config['main_title']='Settings';
                $config['sub_title']='Settings & Static pages';
                $config['breadcrumb']=[
                    ['route'=>'generals.index','title'=>$config['sub_title'],'query_builder'=>['type'=>request()->type]],
                ];
            }elseif(request()->type=='sochiel_links'){
                $form=getForm('setting_management/sochiel_links','',$data);
                $config['main_title']='Settings';
                $config['sub_title']='Settings & Sochiel Links';
                $config['breadcrumb']=[
                    ['route'=>'generals.index','title'=>$config['sub_title'],'query_builder'=>['type'=>request()->type]],
                ];
            }elseif(request()->type=='payment_methods'){
                $form=getForm('setting_management/payment_methods','',$data);
                $config['main_title']='Settings';
                $config['sub_title']='Settings & Payment Methods';
                $config['breadcrumb']=[
                    ['route'=>'generals.index','title'=>$config['sub_title'],'query_builder'=>['type'=>request()->type]],
                ];
            }elseif(request()->type=='sochiel_media_login'){
                $form=getForm('setting_management/sochiel_media_login','',$data);
                $config['main_title']='Settings';
                $config['sub_title']='Settings & Sochiel Media Login';
                $config['breadcrumb']=[
                    ['route'=>'generals.index','title'=>$config['sub_title'],'query_builder'=>['type'=>request()->type]],
                ];
            }elseif(request()->type=='system_config'){
                $form=getForm('setting_management/system_config','',$data);
                $config['main_title']='Settings';
                $config['sub_title']='Settings & Sysyem Configrationsn';
                $config['breadcrumb']=[
                    ['route'=>'generals.index','title'=>$config['sub_title'],'query_builder'=>['type'=>request()->type]],
                ];
            }


        }else{
            $form=getForm('setting_management/general','',$data);

            $config['main_title']='Settings';
            $config['sub_title']='Settings & General';
            $config['breadcrumb']=[
                ['route'=>'generals.index','title'=>$config['sub_title']],
            ];
        }




        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }

    public function store(Request $request){

        $this->repository->store($request->all());
        // return redirect()->back()->with('success', 'Your Record Created Successfully');
        // return response()->json(['message'=>'Your Record Created Successfully']);

        return response()->json(['message'=>'Your Record Created Successfully','redirect'=>'#']);
    }

    // public function sort_managment($type){
    //     set_time_limit(2000);
    //     if($type=='static'){
    //         sitemap_static('',false);
    //     }elseif($type=='properties_category_r_for_sale'){
    //         sitemap_category('sale','',false);
    //     }elseif($type=='properties_category_r_for_rent'){
    //         sitemap_category('rent','',false);
    //     }elseif($type=='properties_category_c_for_sale'){
    //         sitemap_category('commercial_for_sale','',false);
    //     }elseif($type=='properties_category_c_for_rent'){
    //         sitemap_category('commercial_for_rent','',false);
    //     }elseif($type=='compounds'){
    //         // $ids=DB::table('osoule_property')->whereNotIn('osoule_property.id',DB::select("select section_id FROM `osoule_seo_managment` where section='single_properties' and section_lang='en' and section_type='r_for_sale'"));
    //         sitemap_projects('compounds_sitemap.xml',false);
    //     }elseif($type=='blogs'){
    //         sitemap_blogs('blogs_sitemap.xml',false);
    //     }elseif($type=='single_properties_r_for_sale'){
    //         $ids=DB::table('osoule_property')->whereNotIn('osoule_property.id',DB::select("select section_id FROM `osoule_seo_managment` where section='single_properties' and section_lang='en' and section_type='r_for_sale'"));
    //         sitemap_properties('r_for_sale',$ids,false);

    //     }elseif($type=='single_properties_r_for_rent'){
    //         $ids=DB::table('osoule_property')->whereNotIn('osoule_property.id',DB::select("select section_id FROM `osoule_seo_managment` where section='single_properties' and section_lang='en' and section_type='r_for_rent'"));
    //         sitemap_properties('r_for_rent',$ids,false);

    //     }elseif($type=='single_properties_c_for_sale'){
    //         $ids=DB::table('osoule_property')->whereNotIn('osoule_property.id',DB::select("select section_id FROM `osoule_seo_managment` where section='single_properties' and section_lang='en' and section_type='c_for_sale'"));
    //         sitemap_properties('c_for_sale',$ids,false);

    //     }elseif($type=='single_properties_c_for_rent'){
    //         $ids=DB::table('osoule_property')->whereNotIn('osoule_property.id',DB::select("select section_id FROM `osoule_seo_managment` where section='single_properties' and section_lang='en' and section_type='c_for_rent'"));
    //         sitemap_properties('c_for_rent',$ids,false);
    //     }elseif($type=='agency'){
    //         sitemap_agency('agency.xml',false);
    //     }
    //     return redirect()->back()->with('success', 'Your Record Created Successfully');
    // }
}

?>
