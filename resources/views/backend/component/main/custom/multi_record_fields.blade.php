@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
    @if(!empty($values))
        @foreach ($values['name'] as $value)
        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[name][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Field Name',
                        'around_div'=>'col-md-4',
                        'value'=>$values['name'][$row_count]
                    ])
                !!}
                {!! viewComponents('select',[
                        'type'=>'text',
                        'name'=>$name.'[type][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Type',
                        'around_div'=>'col-md-4',
                        'options'=>$options['options'],
                        'selected'=>$values['type'][$row_count]
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[length][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Field Length',
                        'around_div'=>'col-md-4',
                        'value'=>$values['length'][$row_count]
                    ])
                !!}
                {!! viewComponents('select',[
                        'name'=>$name.'[default][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Default',
                        'around_div'=>'col-md-4',
                        'options'=>$options['default'],
                        'selected'=>$values['default'][$row_count]
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[default_text][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Default',
                        'around_div'=>'col-md-4',
                        'value'=>$values['default_text'][$row_count]
                    ])
                !!}
                {!! viewComponents('select',[
                        'name'=>$name.'[indexed][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Indexed',
                        'around_div'=>'col-md-4',
                        'options'=>$options['indexed'],
                        'selected'=>$values['indexed'][$row_count]
                    ])
                !!}
                {!! viewComponents('select',[
                    'name'=>$name.'[foreign_table][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Tables',
                    'around_div'=>'col-md-4',
                    'options'=>$options['tables'],
                    'selected'=>$values['foreign_table'][$row_count]
                    ])
                !!}
                {!! viewComponents('select',[
                    'name'=>$name.'[in_translate][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'In Translat Table',
                    'around_div'=>'col-md-4',
                    'options'=>[
                        'no'=>'No',
                        'yes'=>'Yes',
                    ],
                    'selected'=>$values['in_translate'][$row_count]
                    ])
                !!}
                {!! viewComponents('textarea',[
                        'type'=>'textarea',
                        'name'=>$name.'[note][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Note',
                        'around_div'=>'col-md-12',
                        'value'=>(array_key_exists('value',$values))?$values['note'][$row_count]:''
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
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[name][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Field Name',
                        'around_div'=>'col-md-4'
                    ])
                !!}
                {!! viewComponents('select',[
                        'type'=>'text',
                        'name'=>$name.'[type][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Type',
                        'around_div'=>'col-md-4',
                        'options'=>$options['options'],
                        'selected'=>''
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[length][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Field Length',
                        'around_div'=>'col-md-4'
                    ])
                !!}
                {!! viewComponents('select',[
                        'name'=>$name.'[default][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Default',
                        'around_div'=>'col-md-4',
                        'options'=>$options['default'],
                        'selected'=>''
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[default_text][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Default',
                        'around_div'=>'col-md-4'
                    ])
                !!}
                {!! viewComponents('select',[
                        'name'=>$name.'[indexed][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Indexed',
                        'around_div'=>'col-md-4',
                        'options'=>$options['indexed'],
                        'selected'=>''
                    ])
                !!}
                {!! viewComponents('select',[
                    'name'=>$name.'[foreign_table][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Tables',
                    'around_div'=>'col-md-4',
                    'options'=>$options['tables'],
                    'selected'=>''
                    ])
                !!}
                {!! viewComponents('select',[
                    'name'=>$name.'[in_translate][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'In Translat Table',
                    'around_div'=>'col-md-4',
                    'options'=>[
                        'no'=>'No',
                        'yes'=>'Yes',
                    ],
                    'selected'=>''
                    ])
                !!}
                {!! viewComponents('textarea',[
                        'type'=>'textarea',
                        'name'=>$name.'[note][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Note',
                        'around_div'=>'col-md-12',
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
                    'count'=>1,
                    'style'=>'display:none;'
                ],
                ])
            !!}
            </div>
        </div>
    @endif

</div>
