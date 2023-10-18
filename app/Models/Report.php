<?php
namespace App\Models;

class Report extends Main
{
    protected $table = "install_reports";
    protected $fillable = [
        'name',
        'is_active',
        'table_db',
        'show_in',
        'module_id',
        'with_group',
        'with_report',
        'db_joins',
        'db_condtions',
        'db_select',
        'export_as',
        'group_by',
        'limit',
        'text_align',
        'report_order_by',
        'report_addtinal_filter',

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
        $transaction->show_in = $item->show_in;
        $transaction->table_db = $item->table_db;
        $transaction->text_align = $item->text_align;
        $transaction->module_id = $item->module_id;
        $transaction->with_group = $item->with_group;
        $transaction->with_report = $item->with_report;

        $transaction->db_joins = $item->db_joins;
        $transaction->db_condtions = $item->db_condtions;
        $transaction->db_select = $item->db_select;
        $transaction->export_as = $item->export_as;
        $transaction->group_by = $item->group_by;
        $transaction->limit = $item->limit;
        $transaction->report_order_by = $item->report_order_by;
        $transaction->report_addtinal_filter = $item->report_addtinal_filter;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }
    public static function transformArray($item)
    {
        $transaction = [];
        $transaction['id'] = $item->id;
        $transaction['name'] = $item->name;
        $transaction['is_active'] = $item->is_active;
        $transaction['show_in'] = $item->show_in;
        $transaction['table_db'] = $item->table_db;
        $transaction['text_align']= $item->text_align;
        $transaction['module_id'] = $item->module_id;
        $transaction['with_group'] = $item->with_group;
        $transaction['with_report'] = $item->with_report;
        $transaction['db_joins'] = $item->db_joins;
        $transaction['db_condtions'] = $item->db_condtions;
        $transaction['db_select'] = $item->db_select;
        $transaction['export_as'] = $item->export_as;
        $transaction['group_by'] = $item->group_by;
        $transaction['limit'] = $item->limit;
        $transaction['report_order_by'] = $item->report_order_by;
        $transaction['report_addtinal_filter'] = $item->report_addtinal_filter;
        $transaction['created_at'] = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }
}
