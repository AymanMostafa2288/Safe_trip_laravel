<?php
namespace App\Models;
use DB;

class ModuleField extends Main
{
    protected $table = "install_module_fields";
    protected $fillable = [
        'name',
        'show_as',
        'is_active',
        'type',
        'related_with',
        'module_id',
        'min',
        'max',
        'regex',
        'with_group',
        'around_div',
        'hint',
        'fields_module',
        'fields_action',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];
    
    public static function transform($item)
    {
        $field_translate=static::translate($item->id);
   
        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->name = $item->name;
        $transaction->show_as = $item->show_as;
        $transaction->is_active = ($item->is_active==1)?'Active':'Blocked';
        $transaction->type = $item->type;
        $transaction->related_with = $item->related_with;
        $transaction->module_id = $item->module_id;
        $transaction->min = $item->min;
        $transaction->max = $item->max;
        $transaction->regex = $item->regex;
        $transaction->with_group = $item->with_group;
        $transaction->around_div = $item->around_div;
        $transaction->hint = $item->hint;
        $transaction->fields_module = $item->fields_module;
        $transaction->fields_action = $item->fields_action;
        $transaction->translate=$field_translate;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        
        return $transaction;
    }
    public static function transformArray($item)
    {
        $field_translate=static::translate($item->id);

        $transaction = [];
        $transaction['id'] = $item->id;
        $transaction['name'] = $item->name;
        $transaction['show_as'] = $item->show_as;
        $transaction['is_active'] = $item->is_active;
        $transaction['type'] = $item->type;
        $transaction['related_with'] = $item->related_with;
        $transaction['module_id'] = $item->module_id;
        $transaction['min'] = $item->min;
        $transaction['max'] = $item->max;
        $transaction['regex'] = $item->regex;
        $transaction['with_group'] = $item->with_group;
        $transaction['around_div'] = $item->around_div;
        $transaction['hint'] = $item->hint;
        $transaction['fields_module'] = $item->fields_module;
        $transaction['fields_action'] = $item->fields_action;
        $transaction['translate']=$field_translate;
        $transaction['created_at'] = date("Y-m-d H:i:s", strtotime($item->created_at));
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

    public static function translate($id){
        $model = new ModuleField;
        $table = explode("_",$model->getTable());
        unset($table[0]);
        $field_name=implode('_',$table)."_id";
        $table_name=$model->getTable()."_translate";
        $langs=DB::table($table_name)->where($field_name,$id)->get();
        $return=[];
        foreach($langs as $lang){
            $return[$lang->lang]=(array)$lang;
        }
        return $return;
    }

    public function module(){
        return $this->belongsTo(Module::class, 'id');
    }
}
