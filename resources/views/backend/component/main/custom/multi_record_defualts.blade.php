@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
@if(!empty($values))

    @foreach ($values['defaults'] as $value)


        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >

                {!! viewComponents('select',
                    [
                        'type'=>'text',
                        'name'=>$name.'[defaults][]',
                        'title'=>'',
                        "attributes"=>[
                            'readonly'=>"readonly",
                        ],
                        'class'=>'',
                        'placeholder'=>'Default',
                        'around_div'=>'col-md-6',
                        'options'=>$options['defaults'],
                        'selected'=>(array_key_exists('defaults',$values))?$values['defaults'][$row_count]:''
                    ])
                !!}
                @if ($count==1)
                {!! viewComponents('select',
                    [
                        'type'=>'text',
                        'name'=>$name.'[value][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Type',
                        'around_div'=>'col-md-6',
                        'options'=>$options['typs'],
                        'selected'=>(array_key_exists('value',$values))?$values['value'][$row_count]:''
                    ])
                !!}
                @elseif($count==2)
                {!! viewComponents('select',
                    [
                        'type'=>'text',
                        'name'=>$name.'[value][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'State',
                        'around_div'=>'col-md-6',
                        'options'=>$options['states'],
                        'selected'=>(array_key_exists('value',$values))?$values['value'][$row_count]:''
                    ])
                !!}
                @elseif($count==3)
                {!! viewComponents('select',
                    [
                        'type'=>'text',
                        'name'=>$name.'[value][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Category',
                        'around_div'=>'col-md-6',
                        'options'=>$options['categories'],
                        'selected'=>(array_key_exists('value',$values))?$values['value'][$row_count]:''
                    ])
                !!}
                @endif




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
        {!! viewComponents('select',
        [
            'type'=>'text',
            'name'=>$name.'[defaults][]',
            'title'=>'',
            'class'=>'',
            'placeholder'=>'Setting',
            'around_div'=>'col-md-6',
            'options'=>$options['defaults'],
            'selected'=>''
        ])
    !!}
      {!! viewComponents('select',
        [
            'type'=>'text',
            'name'=>$name.'[value][]',
            'title'=>'',
            'class'=>'',
            'placeholder'=>'Value',
            'around_div'=>'col-md-6',
            'options'=>$options['check'],
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
