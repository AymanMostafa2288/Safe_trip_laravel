<?php
namespace App\Models;


class Module extends Main
{
    protected $table = "install_modules";
    protected $fillable = [
        'name',
        'is_active',
        'show_in_left_side',
        'table_db',
        'departments_module',
        'fields_action',
        'crud_with',
        'with_group',
        'name_repo',
        'folder_repo',
        'model_repo',
        'route_repo',
        'controller_repo',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];

    public static function transform($item)
    {

        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->name = $item->name;
        $transaction->is_active = ($item->is_active==1)?'Active':'Blocked';
        $transaction->show_in_left_side = $item->show_in_left_side;
        $transaction->table_db = $item->table_db;
        $transaction->departments_module = $item->departments_module;
        $transaction->fields_action = $item->fields_action;
        $transaction->crud_with = $item->crud_with;
        $transaction->with_group = $item->with_group;
        $transaction->name_repo = $item->name_repo;
        $transaction->folder_repo = $item->folder_repo;
        $transaction->model_repo = $item->model_repo;
        $transaction->route_repo = $item->route_repo;
        $transaction->controller_repo = $item->controller_repo;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        $transaction->fields = ModuleField::transformCollection($item->fields);
        $transaction->crud_with_relation = Module::transformCollection($item->crud_with_relation);
        return $transaction;
    }
    public static function transformArray($item)
    {

        $transaction = [];
        $transaction['id'] = $item->id;
        $transaction['name'] = $item->name;
        $transaction['is_active'] = $item->is_active;
        $transaction['show_in_left_side'] = $item->show_in_left_side;
        $transaction['table_db'] = $item->table_db;
        $transaction['departments_module'] = $item->departments_module;
        $transaction['fields_action'] = $item->fields_action;
        $transaction['crud_with'] = $item->crud_with;
        $transaction['with_group'] = $item->with_group;
        $transaction['name_repo'] = $item->name_repo;
        $transaction['folder_repo'] = $item->folder_repo;
        $transaction['model_repo'] = $item->model_repo;
        $transaction['route_repo'] = $item->route_repo;
        $transaction['controller_repo'] = $item->controller_repo;
        $transaction['created_at'] = date("Y-m-d H:i:s", strtotime($item->created_at));
        $transaction['fields'] = ModuleField::transformCollection($item->fields);

        $transaction['crud_with_relation'] =Module::transformCollection($item->crud_with_relation);

        return $transaction;
    }

    public static function transformCustom($item,$select){
        if($select=='*'){
            return self::transform($item);
        }else{
            $transaction = new \stdclass();
            foreach ($select as $row) {
                $transaction->$row = $item->$row;
            }

            return $transaction;
        }
    }

    public function fields(){
        return $this->hasMany(ModuleField::class,'module_id','id');
    }
    public function crud_with_relation(){
        return $this->hasMany(Module::class,'crud_with','id');
    }
}
