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
                            'placeholder'=>'ID',
                            'around_div'=>'col-md-4',
                            'value'=>$values['id'][$row_count],
                        ])
                    !!}
                    {!! viewComponents('input',[
                            'type'=>'text',
                            'name'=>$name.'[lable][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Lable',
                            'around_div'=>'col-md-4',
                            'value'=>$values['lable'][$row_count],
                        ])
                    !!}
                    {!! viewComponents('input',[
                            'type'=>'text',
                            'name'=>$name.'[color][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Color',
                            'around_div'=>'col-md-4',
                            'value'=>$values['color'][$row_count],
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
                            'placeholder'=>'ID',
                            'around_div'=>'col-md-4',
                            'value'=>'',
                        ])
                    !!}
                    {!! viewComponents('input',[
                            'type'=>'text',
                            'name'=>$name.'[lable][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Lable',
                            'around_div'=>'col-md-4',
                            'value'=>'',
                        ])
                    !!}
                    {!! viewComponents('input',[
                            'type'=>'text',
                            'name'=>$name.'[color][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Color',
                            'around_div'=>'col-md-4',
                            'value'=>'',
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
