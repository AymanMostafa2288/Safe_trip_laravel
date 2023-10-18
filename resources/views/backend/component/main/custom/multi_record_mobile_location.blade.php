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
                    'name'=>$name.'[page][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Pages',
                    'around_div'=>'col-md-4',
                    'options'=>$options['pages'],
                    'selected'=>(array_key_exists('page',$value))?$value['page']:''
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[type][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Types',
                    'around_div'=>'col-md-4',
                    'options'=>$options['types'],
                    'selected'=>(array_key_exists('type',$value))?$value['type']:''
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[category_id][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Categories',
                    'around_div'=>'col-md-4',
                    'options'=>$options['categories'],
                    'selected'=>(array_key_exists('category_id',$value))?$value['category_id']:''
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[state_id][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'States',
                    'around_div'=>'col-md-4',
                    'options'=>$options['states'],
                    'selected'=>(array_key_exists('state_id',$value))?$value['state_id']:''
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[city_id][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Cities',
                    'around_div'=>'col-md-4',
                    'options'=>$options['cities'],
                    'selected'=>(array_key_exists('city_id',$value))?$value['city_id']:''
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[area_id][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Areas',
                    'around_div'=>'col-md-4',
                    'options'=>$options['areas'],
                    'selected'=>(array_key_exists('area_id',$value))?$value['area_id']:''
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
                'name'=>$name.'[page][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Pages',
                'around_div'=>'col-md-4',
                'options'=>$options['pages'],
                'selected'=>''
            ])
        !!}
        {!! viewComponents(
            'select',[
                'type'=>'text',
                'name'=>$name.'[type][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Types',
                'around_div'=>'col-md-4',
                'options'=>$options['types'],
                'selected'=>''
            ])
        !!}
        {!! viewComponents(
            'select',[
                'type'=>'text',
                'name'=>$name.'[category_id][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Categories',
                'around_div'=>'col-md-4',
                'options'=>$options['categories'],
                'selected'=>''
            ])
        !!}
        {!! viewComponents(
            'select',[
                'type'=>'text',
                'name'=>$name.'[state_id][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'States',
                'around_div'=>'col-md-4',
                'options'=>$options['states'],
                'selected'=>''
            ])
        !!}
        {!! viewComponents(
            'select',[
                'type'=>'text',
                'name'=>$name.'[city_id][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Cities',
                'around_div'=>'col-md-4',
                'options'=>$options['cities'],
                'selected'=>''
            ])
        !!}
        {!! viewComponents(
            'select',[
                'type'=>'text',
                'name'=>$name.'[area_id][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Areas',
                'around_div'=>'col-md-4',
                'options'=>$options['areas'],
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
