@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
@if(!empty($values))
    @foreach ($values['date_time'] as $value)


        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >


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

            {!! viewComponents('textarea',[
                    'type'=>'textarea',
                    'name'=>$name.'[note][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Note',
                    'around_div'=>'col-md-12',
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
        {!! viewComponents('input',[
                'type'=>'date',
                'name'=>$name.'[date_time][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Date Time',
                'around_div'=>'col-md-12',
                'value'=>''
            ])
        !!}

        {!! viewComponents('textarea',[
                'type'=>'textarea',
                'name'=>$name.'[note][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Note',
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
            'count'=>$count,
            'style'=>'display:none;'
        ],
        ])
    !!}
    </div>
</div>
@endif
</div>
