<?php

namespace App\Repositories\Eloquent\custom_modules_management\Routes;

use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\TripStatusEnum;
use App\Models\CustomModels\School;
use App\Models\CustomModels\Trip;
use App\Repositories\Interfaces\custom_modules_management\Routes\RouteInterface;
use App\Repositories\Interfaces\setting_management\LanguageInterface;
use App\Repositories\Interfaces\builder_management\ModuleInterface;
use App\Models\CustomModels\Route;
use Exception;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RouteRepository implements RouteInterface
{
    public $model;
    private $files = [];
    private $images = [];
    private $json = [];

    public function __construct(Route $model)
    {
        $this->model = $model;
    }

    public function data($request, $id = "*", $field_name = "")
    {
        $data = $this->model;
        $another_select = [];
        if ($id == "*") {
            if (array_key_exists("with", $request)) {
                foreach ($request["with"] as $val) {
                    $another_select[] = $val;
                }
            }
            $data = StatementDB($data, $request);
            $data = $data->get();
            if (array_key_exists("select", $request) && !empty($request["select"])) {
                $request["select"] = array_merge($request["select"], $another_select);
                $data = $this->model->transformCollection($data, "Custom", false, false, $request["select"]);
            } else {
                $data = $this->model->transformCollection($data);
            }
        } else {
            if (array_key_exists("with", $request)) {
                foreach ($request["with"] as $val) {
                    $another_select[] = $val;
                }
            }
            $data = StatementDB($data, $request);
            $data = $data->where("id", $id);
            $data = $data->first();
            $data = $this->model->transformArray($data);
            if ($field_name != "") {
                $data = $data[$field_name];
            }
        }
        return $data;
    }

    public function save($request, $id = "")
    {
        DB::beginTransaction();

        try {
            if ($id != "") {
                if ($id != $request["id"]) {
                    return false;
                } else {
                    unset($request["id"]);
                }
                unset($request["_method"]);
            }
            unset($request["_token"]);
            foreach ($this->json as $json) {
                if (array_key_exists($json, $request)) {
                    $array = json_encode($request[$json]);
                    $first_row = current($request[$json]);
                    if (is_array($first_row)) {
                        $key = array_key_first($request[$json]);
                        if ($request[$json][$key][0] != null) {
                            $array = json_encode($request[$json]);
                        } else {
                            $array = json_encode([]);
                        }
                    }
                    $request[$json] = $array;
                } else {
                    $array = json_encode([]);
                    $request[$json] = $array;
                }
            }
            foreach ($this->images as $image_name) {
                $image                = request()->file($image_name);
                $image                = uploadImage($image);
                $old_image            = '';
                if ($id != "")
                    $old_image = $this->data([], $id, $image_name);

                $request[$image_name] = handel_request_and_upload_file ($request,$image,$image_name,$id,$old_image);

            }
            foreach ($this->files as $file_name) {
                $file                = request()->file($file_name);
                $file                = uploadFile($file);
                $old_file            = '';
                if ($id != "")
                    $old_file = $this->data([], $id, $file_name);

                $request[$file_name] = handel_request_and_upload_file ($request,$file,$file_name,$id,$old_file);

            }
            $school = School::find($request['school_id']);
            $request['address_from'] = $school->address;
            $request['location_from'] = $school->location;
            $request['location_to']   = $request['location'];
            unset($request['location']);


            $data = $this->model->updateOrCreate(["id" => $id],$request);
            if ($id == ""){
                $request_route_sign = $request['route_sign'];
                $route_sign = [];
                foreach ($request_route_sign['bus_id'] as $key=>$value){
                    $route_sign = [
                        'bus_id'          => $request_route_sign['bus_id'][$key],
                        'driver_id'       => $request_route_sign['driver_id'][$key],
                        'supervisor_id'   => $request_route_sign['supervisor_id'][$key],
                        'go_start_time'   => $request_route_sign['go_start_time'][$key],
                        'go_end_time'     => $request_route_sign['go_end_time'][$key],
                        'back_start_time' => $request_route_sign['back_start_time'][$key],
                        'back_end_time'   => $request_route_sign['back_end_time'][$key],
                        'is_active'       => ActiveStatusEnum::ACTIVE,
                    ];
                    $this->create_trip($route_sign ,$data->id,$request['date_from'],$request['date_to']);
                }
                unset($request['route_sign']);
            }

            DB::commit();
            return $data;
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                return false;
            }
            foreach ($this->images as $image_name) {
                $old_image = $this->data([], $id, $image_name);
                deleteFileStorage($old_image);
            }
            foreach ($this->files as $file_name) {
                $old_file = $this->data([], $id, $file_name);
                deleteFileStorage($old_file);
            }
            $data->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete_multi($ids)
    {
        try {
            $table_name = $this->model->table_name;
            foreach ($ids as $id) {
                foreach ($this->images as $image_name) {
                    $old_image = $this->data([], $id, $image_name);
                    deleteFileStorage($old_image);
                }
                foreach ($this->files as $file_name) {
                    $old_file = $this->data([], $id, $file_name);
                    deleteFileStorage($old_file);
                }
            }
            $this->model->whereIn("id", $ids)->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function create_trip($trip , $route_id,$start_date,$end_date){
        $days = date_range(first: $start_date , last: $end_date , without:['Fri','Sat']);
        $data = [];
        foreach ($days as $day){
            $code = Str::uuid();
            $data[] = [
                "route_id" => $route_id,
                "driver_id" => $trip['driver_id'],
                "supervisor_id" => $trip['supervisor_id'],
                "bus_id" => $trip['bus_id'],
                "trip_id" => null,
                "day" => $day,
                "time_start" => date('H:i' , strtotime($trip['go_start_time'])),
                "time_end" => date('H:i' , strtotime($trip['go_end_time'])),
                "actual_time_start" => null,
                "actual_time_end" => null,
                "status" => TripStatusEnum::NOT_YET,
                "is_active" => ActiveStatusEnum::ACTIVE,
                "created_at" => date('Y-m-d H:i:s'),
            ];
            $data[] = [
                "route_id" => $route_id,
                "driver_id" => $trip['driver_id'],
                "supervisor_id" => $trip['supervisor_id'],
                "bus_id" => $trip['bus_id'],
                "trip_id" => $code,
                "day" => $day,
                "time_start" => date('H:i' , strtotime($trip['back_start_time'])),
                "time_end" => date('H:i' , strtotime($trip['back_end_time'])),
                "actual_time_start" => null,
                "actual_time_end" => null,
                "status" => TripStatusEnum::NOT_YET,
                "is_active" => ActiveStatusEnum::ACTIVE,
                "created_at" => date('Y-m-d H:i:s'),
            ];
        }
        DB::table(app(Trip::class)->getTable())->insert($data);

        return true;

    }

}
