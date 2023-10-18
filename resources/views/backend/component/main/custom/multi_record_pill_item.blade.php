@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
@if(!empty($values))
    @foreach ($values['order'] as $value)


        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >
                {!! viewComponents('select',[
                    'type'=>'text',
                    'name'=>$name.'[item_id][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Item',
                    'around_div'=>'col-md-4',
                    'options'=>$options['items'],
                    'selected'=>$values['item_id'][$row_count]
                ])
                !!}
                {!! viewComponents('input',[
                    'type'=>'number',
                    'name'=>$name.'[count][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Count',
                    'around_div'=>'col-md-4',
                    'value'=>$values['count'][$row_count]
                ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'number',
                        'name'=>$name.'[price][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Price',
                        'around_div'=>'col-md-4',
                        'value'=>$values['price'][$row_count]
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
        {!! viewComponents('select',[
                'type'=>'text',
                'name'=>$name.'[item_id][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Item',
                'around_div'=>'col-md-4',
                'options'=>$options['items'],
                'selected'=>''
            ])
        !!}
        {!! viewComponents('input',[
                'type'=>'number',
                'name'=>$name.'[count][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Count',
                'around_div'=>'col-md-4',
                'value'=>''
            ])
        !!}
        {!! viewComponents('input',[
                'type'=>'number',
                'name'=>$name.'[price][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Price',
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
