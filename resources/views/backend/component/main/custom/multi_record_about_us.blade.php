@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
    @if(!empty($values))
        @foreach ($values['about_us_sections'] as $value)


            <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
                <div class="panel-body" >

                    {!! viewComponents('select',[
                        'type'=>'text',
                        'name'=>$name.'[about_us_sections][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'About Us Sections',
                        'around_div'=>'col-md-4',
                        'options'=>$options['about_us_sections'],
                        'selected'=>(array_key_exists('about_us_sections',$values))?$values['about_us_sections'][$row_count]:''
                    ])
                    !!}
                    {!! viewComponents('textarea',[
                            'type'=>'textarea',
                            'name'=>$name.'[value][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Link',
                            'around_div'=>'col-md-8',
                            'value'=>(array_key_exists('value',$values))?$values['value'][$row_count]:''
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
                        'name'=>$name.'[about_us_sections][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'App Links',
                        'around_div'=>'col-md-4',
                        'options'=>$options['about_us_sections'],
                        'selected'=>(array_key_exists('about_us_sections',$values))?$values['about_us_sections'][$row_count]:''
                    ])
                    !!}
                    {!! viewComponents('textarea',[
                            'type'=>'textarea',
                            'name'=>$name.'[value][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Link',
                            'around_div'=>'col-md-8',
                            'value'=>(array_key_exists('value',$values))?$values['value'][$row_count]:''
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
