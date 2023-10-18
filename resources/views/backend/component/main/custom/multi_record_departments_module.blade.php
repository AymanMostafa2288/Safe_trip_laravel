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
                        'around_div'=>'col-md-2',
                        'value'=>$values['order'][$row_count]
                    ])
                !!}
                {!! viewComponents('input',[
                    'type'=>'text',
                    'name'=>$name.'[name][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Field Name',
                    'around_div'=>'col-md-5',
                    'value'=>$values['name'][$row_count]
                ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[title][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Field Title',
                        'around_div'=>'col-md-5',
                        'value'=>$values['title'][$row_count]
                    ])
                !!}

                {!! viewComponents('select',[
                        'type'=>'text',
                        'name'=>$name.'[icone][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Icone',
                        'around_div'=>'col-md-6',
                        'options'=>$options['icon'],
                        'selected'=>$values['icone'][$row_count]
                    ])
                !!}
                {!! viewComponents('select',[
                    'name'=>$name.'[side][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Side',
                    'around_div'=>'col-md-6',
                    'options'=>$options['side'],
                    'selected'=>$values['side'][$row_count]
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
        {!! viewComponents('input',[
                'type'=>'number',
                'name'=>$name.'[order][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Order',
                'around_div'=>'col-md-2',
                'value'=>''
            ])
        !!}

        {!! viewComponents('input',[
                'type'=>'text',
                'name'=>$name.'[title][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Field Title',
                'around_div'=>'col-md-5',
                'value'=>''
            ])
        !!}
        {!! viewComponents('input',[
                'type'=>'text',
                'name'=>$name.'[name][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Field Name',
                'around_div'=>'col-md-5',
                'value'=>''
            ])
        !!}
        {!! viewComponents('select',[
                'type'=>'text',
                'name'=>$name.'[icone][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Icone',
                'around_div'=>'col-md-6',
                'options'=>$options['icon'],
                'selected'=>''
            ])
        !!}

        {!! viewComponents('select',[
            'name'=>$name.'[side][]',
            'title'=>'',
            'class'=>'',
            'placeholder'=>'Side',
            'around_div'=>'col-md-6',
            'options'=>$options['side'],
            'selected'=>''
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
            'style'=>'display:none;'
        ],
        ])
    !!}
    </div>
</div>
@endif
</div>
