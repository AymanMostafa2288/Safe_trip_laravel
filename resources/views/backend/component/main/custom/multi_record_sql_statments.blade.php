@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
    @if(!empty($values))
        @foreach ($values['id'] as $value)
            <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
                <div class="panel-body" >
                    {!! viewComponents('input',[
                            'type'=>'number',
                            'name'=>$name.'[id][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Dataset ID',
                            'around_div'=>'col-md-6',
                            'value'=>$values['id'][$row_count],
                        ])
                    !!}
                    {!! viewComponents('input',[
                            'type'=>'text',
                            'name'=>$name.'[param][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Lable',
                            'around_div'=>'col-md-6',
                            'value'=>$values['param'][$row_count],
                        ])
                    !!}
                    {!! viewComponents('textarea',[
                            'type'=>'textarea',
                            'name'=>$name.'[sql][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Sql',
                            'around_div'=>'col-md-12',
                            'value'=>(array_key_exists('sql',$values))?$values['sql'][$row_count]:''
                        ])
                    !!}
                    {!! viewComponents('textarea',[
                            'type'=>'textarea',
                            'name'=>$name.'[sql_defult][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Defult Sql',
                            'around_div'=>'col-md-12',
                            'value'=>(array_key_exists('sql_defult',$values))?$values['sql_defult'][$row_count]:''
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
            @php
                $count++;
                $row_count=$row_count+1;
            @endphp
        @endforeach
    @else
        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >
                {!! viewComponents('input',[
                           'type'=>'number',
                            'name'=>$name.'[id][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Dataset ID',
                            'around_div'=>'col-md-6',
                            'value'=>'',
                        ])
                    !!}
                    {!! viewComponents('input',[
                            'type'=>'text',
                            'name'=>$name.'[param][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Lable',
                            'around_div'=>'col-md-6',
                            'value'=>'',
                        ])
                    !!}
                    {!! viewComponents('textarea',[
                            'type'=>'textarea',
                            'name'=>$name.'[sql][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Sql',
                            'around_div'=>'col-md-12',
                            'value'=>''
                        ])
                    !!}
                    {!! viewComponents('textarea',[
                            'type'=>'textarea',
                            'name'=>$name.'[sql_defult][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Defult Sql',
                            'around_div'=>'col-md-12',
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
