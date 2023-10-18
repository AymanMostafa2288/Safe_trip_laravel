@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
@if(!empty($values))
    @foreach ($values['settings'] as $value)


        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >

                {!! viewComponents('select',
                    [
                        'type'=>'text',
                        'name'=>$name.'[settings][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Setting',
                        'around_div'=>'col-md-4',
                        'options'=>$options['settings'],
                        'selected'=>(array_key_exists('settings',$values))?$values['settings'][$row_count]:''
                    ])
                !!}
                {!! viewComponents('select',
                    [
                        'type'=>'text',
                        'name'=>$name.'[value][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Value',
                        'around_div'=>'col-md-4',
                        'options'=>$options['check'],
                        'selected'=>(array_key_exists('value',$values))?$values['value'][$row_count]:''
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
        {!! viewComponents('select',
        [
            'type'=>'text',
            'name'=>$name.'[settings][]',
            'title'=>'',
            'class'=>'',
            'placeholder'=>'Setting',
            'around_div'=>'col-md-4',
            'options'=>$options['settings'],
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
            'around_div'=>'col-md-4',
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
