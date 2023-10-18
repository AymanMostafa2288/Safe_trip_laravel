<?php
namespace App\Services;
use App\Http\Resources\BlogResource;
use App\Models\CustomModels\Blog;
use App\Models\Slugable;
use App\Repositories\Interfaces\custom_modules_management\Blogs\BlogInterface;

 class BlogService{

    public $model;
    public $interface;
    public function __construct(Blog $model,BlogInterface $interface)
    {
        $this->model = $model;
        $this->interface = $interface;
    }

    public function index($filters,$page = 1,$row_in_page=9,$whereNotIn=[]){
        $request = [];
        $filters['row_in_page']=$row_in_page;
        $request = SetStatementDB($request, $filters);
        $offset = 0;
        $pagination = false;
        $records_count = app(BlogInterface::class)->model->whereNull('deleted_at')->count();
        if (request()->page && request()->page >= 1) {
            $page = request()->page;
            $offset = ($page * $request["row_in_page"]) - $request["row_in_page"];

            $pagination = ceil($records_count / $request["row_in_page"]);
        }
        $request["page"] = $page;
        $request["offset"] = $offset;
        $request["whereNull"] =['deleted_at'];
        if(!empty($whereNotIn)){
            $request["whereNotIn"] =$whereNotIn;
        }
        $body = app(BlogInterface::class)->data($request);
        $body = (array) json_decode(json_encode($body), true);

        $rows["body"] = $body;
        $rows["page"] = $page;
        if ($body > $request["row_in_page"]) {
            $rows["pagination"] = ceil($records_count / $request["row_in_page"]);
        } else {
            $rows["pagination"] = $pagination;
        }
        $rows["main_url"] =route(env('APP_MODE').'.services-page');
        $rows["records_count"] = $records_count;
        return $rows;
    }
    public function show($slug){

        $blog=Slugable::where('slug',$slug)->where('table_name',$this->model->getTable())->first();
        if(!$blog){
            abort(404);
        }
        $blog=$blog->row_id;
        $body = app(BlogInterface::class)->data([],$blog,'',false);
        if(!$body){
            abort(404);
        }
        return $body;

    }


}
