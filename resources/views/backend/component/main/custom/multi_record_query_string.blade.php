@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
@if(!empty($values))
    @foreach ($values['name'] as $value)
        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >
                {!! viewComponents(
                    'input',[
                        'type'=>'text',
                        'name'=>$name.'[name][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Name',
                        'around_div'=>'col-md-4',
                        'value'=>(array_key_exists('name',$values))?$values['name'][$row_count]:''
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
                            'int'=>'Int',
                            'string'=>'String',
                        ],
                        'selected'=>(array_key_exists('type',$values))?$values['type'][$row_count]:''
                    ])
                !!}
                {!! viewComponents(
                    'textarea',[
                        'type'=>'textarea',
                        'name'=>$name.'[note][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Note',
                        'around_div'=>'col-md-4',
                        'value'=>(array_key_exists('note',$values))?$values['note'][$row_count]:''
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
                    'name'=>$name.'[name][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Name',
                    'around_div'=>'col-md-4',
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
                        'int'=>'Int',
                        'string'=>'String',
                    ],
                    'selected'=>'',
                ])
            !!}
            {!! viewComponents(
                'textarea',[
                    'type'=>'textarea',
                    'name'=>$name.'[note][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Note',
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
                'count'=>$count,
                'style'=>'display:none;'
            ],
            ])
        !!}
        </div>
    </div>
@endif
</div>
