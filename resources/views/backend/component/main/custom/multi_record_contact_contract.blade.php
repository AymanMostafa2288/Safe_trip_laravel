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
                        'type'=>'text',
                        'name'=>$name.'[code][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Contact Code',
                        'around_div'=>'col-md-12',
                        'value'=>$value['addtional']
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'date',
                        'name'=>$name.'[date][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Date',
                        'around_div'=>'col-md-12',
                        'value'=>date('Y-m-d',strtotime($value['created_at']))
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
                'type'=>'text',
                'name'=>$name.'[code][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Contact Code',
                'around_div'=>'col-md-12',
                'value'=>''
            ])
        !!}
        {!! viewComponents('input',[
                'type'=>'date',
                'name'=>$name.'[date][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Date',
                'around_div'=>'col-md-12',
                'value'=>date('Y-m-d')
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
