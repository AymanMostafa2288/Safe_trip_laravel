<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Main
{

    protected $table = 'install_roles';
    protected $fillable = [
        'name',
        'note',
        'reports_permissions',
        'spasfice_permissions',
        'notifications_permissions',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];


    public static function transform($item){
        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->name = $item->name;
        $transaction->note = $item->note;
        $transaction->spasfice_permissions = $item->spasfice_permissions;
        $transaction->reports_permissions = $item->report_permissions;
        $transaction->notifications_permissions = $item->notifications_permissions;

        $transaction->created_at = date('Y-m-d H:i:s',strtotime($item->created_at));
        return $transaction;
    }
    public static function transformArray($item)
    {
        $transaction = [];
        $transaction['id'] = $item->id;
        $transaction['name'] = $item->name;
        $transaction['note'] = $item->note;
        $transaction['spasfice_permissions'] = $item->spasfice_permissions;
        $transaction['reports_permissions'] = $item->report_permissions;
        $transaction['notifications_permissions'] = $item->notifications_permissions;

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
    public function permissions(){
        return $this->hasMany(RolePermissions::class,'role_id','id');
    }
}
