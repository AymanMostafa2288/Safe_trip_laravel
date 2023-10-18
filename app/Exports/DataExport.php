<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\CustomModels\Tags;

class DataExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $interface;
    public $filters;

    public function __construct($interface,$filters)
    {
        $this->interface = $interface;
        $this->filters = $filters;
    }
    public function collection()
    {
        $fields = $this->interface->model->getFillable();
        $key=array_search('updated_at',$fields);
        unset($fields[$key]);
        $request=[];
        $request['select']=$fields;
        $request=SetStatementDB($request,$this->filters);
        unset($request['row_in_page']);
        $return=collect($this->interface->data($request));
        return $return;
    }
    public function headings(): array
    {

        $fields = $this->interface->model->getFillable();
        $key=array_search('updated_at',$fields);
        unset($fields[$key]);
        return $fields;
    }
}
