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
                        'around_div'=>'col-md-6',
                        'options'=>[
                            'normal'=>'Normal',
                            'select_query'=>'DB Select Query',
                            'query'=>'DB Query',
                        ],
                        'selected'=>$values['type'][$row_count]
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[show_as][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Show As',
                        'around_div'=>'col-md-6',
                        'value'=>$values['show_as'][$row_count]
                    ])
                !!}
                 {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[field_value][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Field Value',
                        'around_div'=>'col-md-6',
                        'value'=>$values['field_value'][$row_count]
                    ])
                !!}
                {!! viewComponents(
                    'textarea',[
                        'type'=>'textarea',
                        'name'=>$name.'[default_value][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Default Value',
                        'around_div'=>'col-md-6',
                        'value'=>$values['default_value'][$row_count]
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
                    'around_div'=>'col-md-6',
                    'options'=>[
                        'normal'=>'Normal',
                        'select_query'=>'DB Select Query',
                        'query'=>'DB Query',
                    ],
                    'selected'=>''
                ])
            !!}
            {!! viewComponents('input',[
                    'type'=>'text',
                    'name'=>$name.'[show_as][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Show As',
                    'around_div'=>'col-md-6'
                ])
            !!}
            {!! viewComponents('input',[
                'type'=>'text',
                'name'=>$name.'[field_value][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Field Value',
                'around_div'=>'col-md-6',
                'value'=>''
            ])
        !!}
        {!! viewComponents(
            'textarea',[
                'type'=>'textarea',
                'name'=>$name.'[default_value][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Default Value',
                'around_div'=>'col-md-6',
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
