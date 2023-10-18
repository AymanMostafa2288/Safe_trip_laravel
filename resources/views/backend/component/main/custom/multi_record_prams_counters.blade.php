@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
    @if(!empty($values))
        @foreach ($values['order'] as $value)
            <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
                <div class="panel-body" >
                    {!! viewComponents('input',[
                            'type'=>'number',
                            'name'=>$name.'[order][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Order',
                            'around_div'=>'col-md-4',
                            'value'=>$values['order'][$row_count],
                        ])
                    !!}
                    {!! viewComponents('select',[
                        'type'=>'text',
                        'name'=>$name.'[fields_type][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Type',
                        'around_div'=>'col-md-4',
                        'options'=>$options['fields_type'],
                        'selected'=>$values['fields_type'][$row_count]
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[value][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Field Value',
                        'around_div'=>'col-md-4',
                        'value'=>$values['value'][$row_count],
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
                        'name'=>$name.'[order][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Order',
                        'around_div'=>'col-md-4'
                    ])
                !!}
                {!! viewComponents('select',[
                    'type'=>'text',
                    'name'=>$name.'[fields_type][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Type',
                    'around_div'=>'col-md-4',
                    'options'=>$options['fields_type'],
                    'selected'=>''
                ])
            !!}
            {!! viewComponents('input',[
                    'type'=>'text',
                    'name'=>$name.'[value][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Field Value',
                    'around_div'=>'col-md-4'
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
