@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
    @if(!empty($values))
        @foreach ($values['type'] as $value)
            <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
                <div class="panel-body" >
                {!! viewComponents(
                    'select',[
                        'type'=>'text',
                        'name'=>$name.'[type][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Type',
                        'around_div'=>'col-md-6',
                        'options'=>[
                            'join'=>'Join',
                            'left_join'=>'Left Join',
                            'right_join'=>'Right Join'
                        ],
                        'selected'=>$values['type'][$row_count]
                    ])
                !!}
                {!! viewComponents(
                    'select',[
                        'type'=>'text',
                        'name'=>$name.'[table][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Table',
                        'around_div'=>'col-md-6',
                        'options'=>$options['db_tables'],
                        'selected'=>$values['table'][$row_count]
                    ])
                !!}
                {!! viewComponents('input',[
                    'type'=>'text',
                    'name'=>$name.'[field1][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Field Name',
                    'around_div'=>'col-md-6',
                    'value'=>$values['field1'][$row_count]
                ])
                !!}
                {!! viewComponents('input',[
                    'type'=>'text',
                    'name'=>$name.'[field2][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Field Name',
                    'around_div'=>'col-md-6',
                    'value'=>$values['field2'][$row_count]
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
                    'select',[
                        'type'=>'text',
                        'name'=>$name.'[type][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Type',
                        'around_div'=>'col-md-6',
                        'options'=>[
                            'join'=>'Join',
                            'left_join'=>'Left Join',
                            'right_join'=>'Right Join'
                        ],
                        'selected'=>''
                    ])
                !!}
                {!! viewComponents(
                    'select',[
                        'type'=>'text',
                        'name'=>$name.'[table][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Table',
                        'around_div'=>'col-md-6',
                        'options'=>$options['db_tables'],
                        'selected'=>''
                    ])
                !!}
            {!! viewComponents('input',[
                    'type'=>'text',
                    'name'=>$name.'[field1][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Field Name',
                    'around_div'=>'col-md-6'
                ])
            !!}
            {!! viewComponents('input',[
                    'type'=>'text',
                    'name'=>$name.'[field2][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Field Name',
                    'around_div'=>'col-md-6'
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
