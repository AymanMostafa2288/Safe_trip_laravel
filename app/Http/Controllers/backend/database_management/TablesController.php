<?php

namespace App\Http\Controllers\backend\database_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Interfaces\database_management\TablesInterface;


class TablesController extends Controller
{
    private $repository;

	public function __construct(TablesInterface $repository)
	{
	   $this->repository = $repository;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // if ($request->ajax()) {
        //     $data = User::latest()->get();
        //     return Datatables::of($data)
        //             ->addIndexColumn()
        //             ->addColumn('action', function($row){

        //                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

        //                     return $btn;
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        // }
        $table=getTable('database_management/tables');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='DataBase & Connections';
        $config['breadcrumb']=[];
        return viewBackend('global','index',['table'=>$table,'config'=>$config]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->repository->create_migration_table();
        $form=getForm('database_management/tables');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='DataBase & Connections';
        $config['breadcrumb']=[];
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->repository->store($request);
         return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>'#']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
        // $this->repository->index($request,$id);
        $data=$this->repository->index([],$id);
        $form=getForm('database_management/tables',$id,$data);
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='DataBase & Connections';
        $config['breadcrumb']=[];
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->repository->delete($id);
        $this->repository->store($request);
        $redirect=route('tables.index');
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>$redirect]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->back()->with('success', 'Your Table Deleted Successfully');
    }

    public function genrateMigrationFiles(){

        $table_name=request()->table_name;

        $this->repository->genrate_migration_files($table_name);
        return redirect()->back()->with('success', 'Your Migration Files Created Successfully');
    }
}
