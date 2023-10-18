@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
@if(!empty($values))
    @foreach ($values['down_payment'] as $value)
        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >



            {!! viewComponents(
                'input',[
                    'type'=>'number',
                    'name'=>$name.'[down_payment][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Down Payment',
                    'around_div'=>'col-md-6',
                    'value'=>(array_key_exists('down_payment',$values))?$values['down_payment'][$row_count]:''
                ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'number',
                    'name'=>$name.'[number_of_years][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Number Of Years',
                    'around_div'=>'col-md-6',
                    'value'=>(array_key_exists('number_of_years',$values))?$values['number_of_years'][$row_count]:''
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
                    'type'=>'number',
                    'name'=>$name.'[down_payment][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Down Payment',
                    'around_div'=>'col-md-6',
                    'value'=>''
                ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'number',
                    'name'=>$name.'[number_of_years][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Number Of Years',
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
