@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
@if(!empty($values))
    @foreach ($values as $value)

        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >
                {!! viewComponents('input',[
                        'type'=>'date',
                        'name'=>$name.'[date_time][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Date Time',
                        'around_div'=>'col-md-6',
                        'value'=>(array_key_exists('created_at',$value))?date('Y-m-d',strtotime($value['created_at'])):''
                    ])
                !!}
                {!! viewComponents('select',[
                    'type'=>'text',
                    'name'=>$name.'[type][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Type',
                    'around_div'=>'col-md-6',
                    'options'=>$options['follow_type'],
                    'selected'=>(array_key_exists('type',$value))?$value['type']:''
                ])
                !!}
              {!! viewComponents('textarea',[
                    'type'=>'textarea',
                    'name'=>$name.'[reason][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Follow Reason',
                    'around_div'=>'col-md-6',
                    'value'=>(array_key_exists('reason',$value))?$value['reason']:''
                ])
                !!}
                {!! viewComponents('textarea',[
                    'type'=>'textarea',
                    'name'=>$name.'[result][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Follow Result',
                    'around_div'=>'col-md-6',
                    'value'=>(array_key_exists('reason',$value))?$value['result']:''
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
                'type'=>'date',
                'name'=>$name.'[date_time][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Date Time',
                'around_div'=>'col-md-6',
                'value'=>(array_key_exists('date_time',$values))?$values['date_time'][$row_count]:''
            ])
        !!}
        {!! viewComponents('select',[
                'type'=>'text',
                'name'=>$name.'[type][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Type',
                'around_div'=>'col-md-6',
                'options'=>$options['follow_type'],
                'selected'=>''
            ])
        !!}

        {!! viewComponents('textarea',[
                'type'=>'textarea',
                'name'=>$name.'[reason][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Follow Reason',
                'around_div'=>'col-md-6',
                'value'=>''
            ])
        !!}

        {!! viewComponents('textarea',[
                'type'=>'textarea',
                'name'=>$name.'[result][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Follow Result',
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
            'count'=>$count,
            'style'=>'display:none;'
        ],
        ])
    !!}
    </div>
</div>
@endif
</div>
