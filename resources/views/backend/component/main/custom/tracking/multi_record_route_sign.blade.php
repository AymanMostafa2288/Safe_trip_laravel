@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
    @if(!empty($values))
        @foreach ($values['title'] as $value)


            <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
                <div class="panel-body" >
                    {!! viewComponents('input',[
                                'type'=>'text',
                                'name'=>$name.'[title][]',
                                'title'=>'',
                                'class'=>'',
                                'placeholder'=>'Title',
                                'around_div'=>'col-md-12',
                                'value'=>(array_key_exists('title',$values))?$values['title'][$row_count]:''
                            ])
                        !!}
                    {!! viewComponents('input',[
                            'type'=>'date',
                            'name'=>$name.'[date_time][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Date Time',
                            'around_div'=>'col-md-12',
                            'value'=>(array_key_exists('date_time',$values))?$values['date_time'][$row_count]:''
                        ])
                    !!}
                    {!! viewComponents('select',[
                        'type'=>'text',
                        'name'=>$name.'[type][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Type',
                        'around_div'=>'col-md-12',
                        'options'=>$options['follow_type'],
                        'selected'=>(array_key_exists('type',$values))?$values['type'][$row_count]:''
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
        <div class="panel panel-default element_fields_{{ $name }}"  count="{{ $count }}">
            <div class="panel-body" >
                {!! viewComponents('select',[
                        'type'=>'text',
                        'name'=>$name.'[bus_id][]',
                        'repeater' => true,
                        'validation_title' => $name.'_bus_id_0',
                        'validation_num' => 0,
                        'title'=>'Bus',
                        'class'=>'',
                        'placeholder'=>'Bus',
                        'around_div'=>'col-md-4',
                        'options'=>$options['buses'],
                        'selected'=>''
                    ])
                !!}
                {!! viewComponents('select',[
                        'type'=>'text',
                        'name'=>$name.'[driver_id][]',
                        'repeater' => true,
                        'validation_title' => $name.'_driver_id_0',
                        'validation_num' => 0,
                        'title'=>'Worker',
                        'class'=>'',
                        'placeholder'=>'Worker',
                        'around_div'=>'col-md-4',
                        'options'=>$options['drivers'],
                        'selected'=>''
                    ])
                !!}
                {!! viewComponents('select',[
                        'type'=>'text',
                        'name'=>$name.'[supervisor_id][]',
                        'repeater' => true,
                        'validation_title' => $name.'_supervisor_id_0',
                        'validation_num' => 0,
                        'title'=>'Supervisors',
                        'repeater' => true,
                        'class'=>'',
                        'placeholder'=>'Supervisors',
                        'around_div'=>'col-md-4',
                        'options'=>$options['supervisors'],
                        'selected'=>1
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'time',
                        'name'=>$name.'[go_start_time][]',
                        'repeater' => true,
                        'validation_title' => $name.'_go_start_time_0',
                        'validation_num' => 0,
                        'title'=>'Go Trip Start At',
                        'class'=>'',
                        'placeholder'=>'Name',
                        'around_div'=>'col-md-6',
                        'value'=>''
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'time',
                        'name'=>$name.'[go_end_time][]',
                        'repeater' => true,
                        'validation_title' => $name.'_go_end_time_0',
                        'validation_num' => 0,
                        'title'=>'Go Trip End At',
                        'class'=>'',
                        'placeholder'=>'Name',
                        'around_div'=>'col-md-6',
                        'value'=>''
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'time',
                        'name'=>$name.'[back_start_time][]',
                        'repeater' => true,
                        'validation_title' => $name.'_back_start_time_0',
                        'validation_num' => 0,
                        'title'=>'Back Trip Start At',
                        'class'=>'',
                        'placeholder'=>'Name',
                        'around_div'=>'col-md-6',
                        'value'=>''
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'time',
                        'name'=>$name.'[back_end_time][]',
                        'repeater' => true,
                        'validation_title' => $name.'_back_end_time_0',
                        'validation_num' => 0,
                        'title'=>'Back Trip End At',
                        'class'=>'',
                        'placeholder'=>'Name',
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
