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
                    'input',[
                        'type'=>'text',
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
                    'input',[
                        'type'=>'text',
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
