@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
@if(!empty($values))
    @foreach ($values['section'] as $value)
        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >
            {!! viewComponents('select',[
                'type'=>'text',
                'name'=>$name.'[section][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Section',
                'around_div'=>'col-md-4',
                'options'=>[
                    'left'=>'Left',
                    'middle'=>'Middle',
                    'right'=>'Right',
                ],
                'selected'=>(array_key_exists('section',$values))?$values['section'][$row_count]:''
            ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'text',
                    'name'=>$name.'[title][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Title',
                    'around_div'=>'col-md-4',
                    'value'=>(array_key_exists('title',$values))?$values['title'][$row_count]:''
                ])
            !!}
             {!! viewComponents(
                'input',[
                    'type'=>'text',
                    'name'=>$name.'[link][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Link',
                    'around_div'=>'col-md-4',
                    'value'=>(array_key_exists('link',$values))?$values['link'][$row_count]:''
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
                'name'=>$name.'[section][]',
                'title'=>'',
                'class'=>'',
                'placeholder'=>'Section',
                'around_div'=>'col-md-4',
                'options'=>[
                    'left'=>'Left',
                    'middle'=>'Middle',
                    'right'=>'Right',
                ],
                'selected'=>''
            ])
            !!}
            {!! viewComponents(
                'input',[
                    'type'=>'text',
                    'name'=>$name.'[title][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Title',
                    'around_div'=>'col-md-4',
                    'value'=>''
                ])
            !!}
             {!! viewComponents(
                'input',[
                    'type'=>'text',
                    'name'=>$name.'[link][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Link',
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
