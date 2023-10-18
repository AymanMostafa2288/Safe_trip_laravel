@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
@if(!empty($values))
    @foreach ($values as $value)
        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >


            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[category_id][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Category',
                    'around_div'=>'col-md-12',
                    'options'=>$options['Category'],
                    'selected'=>$value->category_id,
                ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'number',
                    'name'=>$name.'[price_from][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Price From',
                    'around_div'=>'col-md-6',
                    'value'=>$value->price_from,
                ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'number',
                    'name'=>$name.'[price_to][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Price To',
                    'around_div'=>'col-md-6',
                    'value'=>$value->price_to,
                ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'number',
                    'name'=>$name.'[area_from][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Area From',
                    'around_div'=>'col-md-6',
                    'value'=>$value->area_from,
                ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'number',
                    'name'=>$name.'[area_to][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Area To',
                    'around_div'=>'col-md-6',
                    'value'=>$value->area_to,
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
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[category_id][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Category',
                    'around_div'=>'col-md-12',
                    'options'=>$options['Category'],
                    'selected'=>''
                ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'number',
                    'name'=>$name.'[price_from][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Price From',
                    'around_div'=>'col-md-6',
                    'value'=>''
                ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'number',
                    'name'=>$name.'[price_to][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Price To',
                    'around_div'=>'col-md-6',
                    'value'=>''
                ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'number',
                    'name'=>$name.'[area_from][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Area From',
                    'around_div'=>'col-md-6',
                    'value'=>''
                ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'number',
                    'name'=>$name.'[area_to][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Area To',
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
