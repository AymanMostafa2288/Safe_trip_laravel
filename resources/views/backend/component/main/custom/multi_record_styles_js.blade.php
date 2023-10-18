@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">

@if(!empty($values))
    @foreach ($values['path'] as $key=>$value)
        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body" >



            {!! viewComponents(
                'input',[
                    'type'=>'text',
                    'name'=>$name.'[path][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Path',
                    'around_div'=>'col-md-4',
                    'value'=>$value
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[type][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Type',
                    'around_div'=>'col-md-4',
                    'options'=>$options['script_css'],
                    'selected'=>$values['type'][$key]
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'select',
                    'name'=>$name.'[language][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Language',
                    'around_div'=>'col-md-4',
                    'options'=>[
                        'all'=>'All',
                        'ar'=>'Arabic',
                        'en'=>'English',

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
                    'name'=>$name.'[path][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Path',
                    'around_div'=>'col-md-4',
                    'value'=>''
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'select',
                    'name'=>$name.'[type][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Type',
                    'around_div'=>'col-md-4',
                    'options'=>[
                        'css'=>'Css',
                        'js'=>'JS',
                    ],
                    'selected'=>''
                ])
            !!}
            {!! viewComponents(
                'select',[
                    'type'=>'select',
                    'name'=>$name.'[language][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Language',
                    'around_div'=>'col-md-4',
                    'options'=>[
                        'all'=>'All',
                        'ar'=>'Arabic',
                        'en'=>'English',
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
