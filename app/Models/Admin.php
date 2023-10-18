<?php
namespace App\Models;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable;

class Admin extends Main implements AuthenticatableContract
{
    use Authenticatable, CanResetPassword;

    protected $table = "install_admins";
    protected $guard = 'admin';
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password',
        'email',
        'type',
        'is_developer',
        'is_active',
        'role_id',
        'branch_id',
        'specific_permissions',
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
        $transaction->name = $item->first_name.' '.$item->last_name;
        $transaction->first_name = $item->first_name;
        $transaction->last_name = $item->last_name;
        $transaction->username = $item->username;
        $transaction->password = $item->password;
        $transaction->email = $item->email;
        $transaction->type = $item->type;
        $transaction->is_developer = $item->is_developer;
        $transaction->is_active = ($item->is_active==1)?'Active':'Blocked';
        $transaction->role_id = $item->role_id;
        $transaction->branch_id = $item->branch_id;
        $transaction->specific_permissions = $item->specific_permissions;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        $transaction->role = Role::transform($item->role);
        return $transaction;
    }
    public static function transformArray($item)
    {
        $transaction = [];
        $transaction['id'] = $item->id;
        $transaction['name'] = $item->first_name.' '.$item->last_name;
        $transaction['is_active'] = $item->is_active;
        $transaction['first_name'] = $item->first_name;
        $transaction['last_name'] = $item->last_name;
        $transaction['username'] = $item->username;
        $transaction['password'] = $item->password;
        $transaction['email'] = $item->email;
        $transaction['type'] = $item->type;
        $transaction['is_developer'] = $item->is_developer;
        $transaction['role_id'] = $item->role_id;
        $transaction['branch_id'] = $item->branch_id;
        $transaction['specific_permissions']= $item->specific_permissions;
        $transaction['created_at'] = date("Y-m-d H:i:s", strtotime($item->created_at));
        $transaction['role'] = Role::transform($item->role);
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

    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }

}
