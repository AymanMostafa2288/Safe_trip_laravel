<?php
namespace App\Services;
use App\Http\Resources\BlogResource;
use App\Models\CustomModels\Blog;
use App\Repositories\Interfaces\custom_modules_management\Sliders\SliderInterface;

class SliderService{

    public $model;
    public $interface;
    public function __construct(Blog $model,SliderInterface $interface)
    {
        $this->model = $model;
        $this->interface = $interface;
    }

    public function index($filters,$page = 1,$row_in_page=9){
        $request = [];
        $filters['row_in_page']=$row_in_page;
        $request = SetStatementDB($request, $filters);

        $offset = 0;
        $pagination = false;

        $request["page"] = $page;
        $request["offset"] = $offset;
        $request["orderBy"] = [];
        $request["orderBy"]["created_at"] = "asc";
        $request["whereNull"] =['deleted_at'];
        $body = app(SliderInterface::class)->data($request);
        $body = (array) json_decode(json_encode($body), true);
        $records_count = count($body);
        if (request()->page && request()->page >= 1) {
            $page = request()->page;
            $offset = ($page * $request["row_in_page"]) - $request["row_in_page"];
            $pagination = ceil($records_count / $request["row_in_page"]);
        }
        $rows["body"] = $body;
        $rows["page"] = $page;
        if ($body > $request["row_in_page"]) {
            $rows["pagination"] = $pagination;
        } else {
            $rows["pagination"] = $pagination;
        }
        $rows["records_count"] = $records_count;
        return $rows;
    }


}
