@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
    @if(!empty($values))
        @foreach ($values['field_name'] as $value)
            <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
                <div class="panel-body" >
                {!! viewComponents(
                    'textarea',[
                        'type'=>'textarea',
                        'name'=>$name.'[field_name][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Field Name',
                        'around_div'=>'col-md-12',
                        'value'=>$values['field_name'][$row_count]
                    ])
                !!}
                {!! viewComponents(
                    'select',[
                        'type'=>'text',
                        'name'=>$name.'[type][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Type',
                        'around_div'=>'col-md-4',
                        'options'=>[
                            'query'=>'DB Query',
                            'static'=>'Static',
                            'dynamic'=>'Dynamic'
                        ],
                        'selected'=>$values['type'][$row_count]
                    ])
                !!}
                {!! viewComponents(
                    'select',[
                        'type'=>'text',
                        'name'=>$name.'[condtion_type][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Condtion Type',
                        'around_div'=>'col-md-4',
                        'options'=>[
                            '='=>'Equal',
                            '<>'=>'Not Equal',
                            '>'=>'Greater Than',
                            '<'=>'Less Than',
                            '>='=>'Greater Than Or Equal',
                            '<='=>'Less Than Or Equal',
                            'in'=>'In Array',
                            'not in'=>'Not In Array'
                        ],
                        'selected'=>$values['condtion_type'][$row_count]
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[param_name][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Param Name',
                        'around_div'=>'col-md-4',
                        'value'=>$values['param_name'][$row_count]
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[default][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Default Value',
                        'around_div'=>'col-md-4',
                        'value'=>$values['default'][$row_count]
                    ])
                !!}
                {!! viewComponents(
                    'select',[
                        'type'=>'text',
                        'name'=>$name.'[operators][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Operators',
                        'around_div'=>'col-md-4',
                        'options'=>[
                            'and'=>'And',
                            'or'=>'Or',
                        ],
                        'selected'=>$values['operators'][$row_count]
                    ])
                !!}
                {!! viewComponents(
                    'select',[
                        'type'=>'text',
                        'name'=>$name.'[field_type][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Field Type',
                        'around_div'=>'col-md-4',
                        'options'=>$options['options'],
                        'selected'=>$values['field_type'][$row_count]
                    ])
                !!}
                 {!! viewComponents(
                        'select',[
                            'type'=>'text',
                            'name'=>$name.'[from_table][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'From Table',
                            'around_div'=>'col-md-4',
                            'options'=>$options['db_tables'],
                            'selected'=>$values['from_table'][$row_count]
                        ])
                    !!}
                    {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[table_field_name][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Table Field Name',
                        'around_div'=>'col-md-4',
                        'value'=>$values['table_field_name'][$row_count]
                    ])
                !!}

                {!! viewComponents('button',[
                    'type'=>'button',
                    'icon'=>'fa fa-trush',
                    'title'=>'Delete',
                    'class'=>'red delete_element',
                    'around_div'=>'col-md-12 text-right',
                    'attributes'=>[
                        'name_element'=>$name,
                        'count'=>$count,
                    'style'=>($count==1)?'display:none;':''
                    ],
                    ])
                !!}
                </div>
            </div>
            @php
                $count++;
                $row_count=$row_count+1;
            @endphp
        @endforeach
    @else
        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >

            {!! viewComponents(
                'textarea',[
                    'type'=>'textarea',
                    'name'=>$name.'[field_name][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Field Name',
                    'around_div'=>'col-md-12',
                    'value'=>''
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[type][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Type',
                    'around_div'=>'col-md-4',
                    'options'=>[
                        'query'=>'DB Query',
                        'static'=>'Static',
                        'dynamic'=>'Dynamic'
                    ],
                    'selected'=>''
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[condtion_type][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Condtion Type',
                    'around_div'=>'col-md-4',
                    'options'=>[
                        '='=>'Equal',
                        '<>'=>'Not Equal',
                        '>'=>'Greater Than',
                        '<'=>'Less Than',
                        '>='=>'Greater Than Or Equal',
                        '<='=>'Less Than Or Equal',
                        'in'=>'In Array',
                        'not in'=>'Not In Array'
                    ],
                    'selected'=>''
                ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'text',
                    'name'=>$name.'[param_name][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Param Name',
                    'around_div'=>'col-md-4'
                ])
            !!}
            {!! viewComponents('input',[
                    'type'=>'text',
                    'name'=>$name.'[default][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Default Value',
                    'around_div'=>'col-md-4'
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[operators][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Operators',
                    'around_div'=>'col-md-4',
                    'options'=>[
                        'and'=>'And',
                        'or'=>'Or',
                    ],
                    'selected'=>''
                ])
            !!}

            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[field_type][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Field Type',
                    'around_div'=>'col-md-4',
                    'options'=>$options['options'],
                    'selected'=>''
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[from_table][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'From Table',
                    'around_div'=>'col-md-4',
                    'options'=>$options['db_tables'],
                    'selected'=>''
                ])
            !!}
            {!! viewComponents('input',[
                'type'=>'text',
                'name'=>$name.'[table_field_name][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Table Field Name',
                'around_div'=>'col-md-4',
                'value'=>''
            ])
            !!}

            {!! viewComponents('button',[
                'type'=>'button',
                'icon'=>'fa fa-trush',
                'title'=>'Delete',
                'class'=>'red delete_element',
                'around_div'=>'col-md-12 text-right',
                'attributes'=>[
                    'name_element'=>$name,
                    'count'=>1,
                    'style'=>'display:none;'
                ],
                ])
            !!}
            </div>
        </div>
    @endif

</div>
