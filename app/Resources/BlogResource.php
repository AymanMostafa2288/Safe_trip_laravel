<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class BlogResource extends JsonResource
{

        /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $return=[];
        $return['id'] = $this->id;
        return $return;
    }
    public function index($condtions=[],$page=10){

    }
}
?>
