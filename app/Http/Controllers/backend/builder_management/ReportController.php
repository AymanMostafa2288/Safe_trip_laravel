<?php
namespace App\Http\Controllers\backend\builder_management;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\builder_management\ReportInterface;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    private $repository;
    public function __construct(ReportInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $table = getTable('builder_management/reports');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builder & Reports';
        $config['breadcrumb']=[];
        return viewBackend('global','index',['table'=>$table,'config'=>$config]);
    }
    public function create()
    {
        $form = getForm('builder_management/reports');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & Reports';
        $config['breadcrumb']=[];
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }
    public function store(Request $request)
    {

        $this->repository->store($request->all());
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>'#']);
    }
    public function show($id)
    {
        $data=$this->repository->data([],$id);

        $form = getForm('builder_management/reports',$id,$data);
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & Modules';
        $config['breadcrumb']=[];

        return viewBackend('global','edit',['form'=>$form,'config'=>$config]);
    }
    public function update(Request $request, $id)
    {
        $this->repository->store($request->all(),$id);
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>'#']);
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->back()->with("success", "Your Record Deleted Successfully");
    }

    public function single($id){

        $data=$this->repository->data([],$id);

        $main_table=$data['table_db'];
        $joins=json_decode($data['db_joins'],true);
        $condtions=json_decode($data['db_condtions'],true);

        $selects=json_decode($data['db_select'],true);
        $orders=json_decode($data['report_order_by'],true);
        $addtional=json_decode($data['report_addtinal_filter'],true);
        $limits=$data['limit'];
        $groups_by=$data['group_by'];

        $query=$this->repository->build_query($main_table,$selects,$joins,$condtions,$groups_by,$orders,$limits,request()->all());
        $form=$this->repository->build_form($condtions,$addtional);

        // $data=DB::query($query);
        $url=route('dashboard_single_report',$id);
        $config=[];
        $config['main_title']='Reports';
        $config['sub_title']=$data['name'];
        $config['breadcrumb']=[];
        $config['url']=$url;
        $table=[];
        $table['head']=$selects['show_as'];
        $table['body']= DB::select($query);
        $config['id']=$id;
        return viewBackend('global','report',['form'=>$form,'config'=>$config,'table'=>$table]);
    }


}
