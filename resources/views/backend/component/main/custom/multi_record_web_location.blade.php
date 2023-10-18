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
                'input',[
                    'type'=>'text',
                    'name'=>$name.'[url][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'URL',
                    'around_div'=>'col-md-6',
                    'value'=>(array_key_exists('url',$value))?$value['url']:''
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[location][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Location',
                    'around_div'=>'col-md-6',
                    'options'=>[
                        'header'=>'Header',
                        'side'=>'Side',
                        'footer'=>'Footer',
                    ],
                    'selected'=>$value['location']
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
                    'name'=>$name.'[url][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'URL',
                    'around_div'=>'col-md-6',
                    'value'=>''
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[location][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Location',
                    'around_div'=>'col-md-6',
                    'options'=>[
                        'header'=>'Header',
                        'side'=>'Side',
                        'footer'=>'Footer',
                    ],
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
