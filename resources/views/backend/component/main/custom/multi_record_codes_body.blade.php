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
                    'input',[
                        'type'=>'text',
                        'name'=>$name.'[value][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Value',
                        'around_div'=>'col-md-4',
                        'value'=>(array_key_exists('value',$values))?$values['value'][$row_count]:''
                    ])
                !!}


            {!! viewComponents('button',[
                'type'=>'button',
                'icon'=>'fa fa-trush',
                'title'=>'Delete',
                'class'=>'red delete_element',
                'around_div'=>'col-md-4 text-right',
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
                'input',[
                    'type'=>'text',
                    'name'=>$name.'[value][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Value',
                    'around_div'=>'col-md-4',
                    'value'=>''
                ])
            !!}

        {!! viewComponents('button',[
            'type'=>'button',
            'icon'=>'fa fa-trush',
            'title'=>'Delete',
            'class'=>'red delete_element',
            'around_div'=>'col-md-4 text-right',
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
