@php
    $count=1;
    $row_count=0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
    @if(!empty($values))
        @foreach ($values as $key=>$value)

            <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
                <div class="panel-body" >
                    {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[name][]',
                        'repeater' => true,
                        'validation_title' => $name.'_name_'.$key,
                        'validation_num' => $key,
                        'title'=>'Name',
                        'class'=>'',
                        'placeholder'=>'Name',
                        'around_div'=>'col-md-6',
                        'start_row'=>true,
                        'value'=>$value['name'],
                    ])
                !!}
                    {!! viewComponents('select',[
                            'type'=>'text',
                            'name'=>$name.'[is_active][]',
                            'repeater' => true,
                            'validation_title' => $name.'_is_active_'.$key,
                            'validation_num' => $key,
                            'title'=>'Is Active ?',
                            'class'=>'',
                            'placeholder'=>'Is Active ?',
                            'around_div'=>'col-md-6',
                            'options'=>$options['active'],
                            'end_row'=>true,
                            'selected'=>$value['is_active'],
                        ])
                    !!}
                    {!! viewComponents('input',[
                           'type'=>'email',
                           'name'=>$name.'[email][]',
                           'repeater' => true,
                           'validation_title' => $name.'_email_'.$key,
                           'validation_num' => $key,
                           'title'=>'Email',
                           'class'=>'',
                           'placeholder'=>'Email',
                           'around_div'=>'col-md-6',
                           'start_row'=>true,
                           'value'=>$value['email']
                       ])
                   !!}
                    {!! viewComponents('input',[
                           'type'=>'password',
                           'name'=>$name.'[password][]',
                           'title'=>'Password',
                           'repeater' => true,
                           'validation_title' => $name.'_password_'.$key,
                           'validation_num' => $key,
                           'class'=>'',
                           'placeholder'=>'Password',
                           'around_div'=>'col-md-6',
                            'end_row'=>true,
                           'value'=>''

                       ])
                   !!}
                    {!! viewComponents('input',[
                           'type'=>'text',
                           'name'=>$name.'[national_id][]',
                           'title'=>'National ID',
                           'repeater' => true,
                           'validation_title' => $name.'_national_id_'.$key,
                           'validation_num' => $key,
                           'class'=>'',
                           'placeholder'=>'National ID',
                           'around_div'=>'col-md-6',
                           'start_row'=>true,
                           'value'=>$value['national_id']
                       ])
                   !!}
                    {!! viewComponents('input',[
                           'type'=>'text',
                           'name'=>$name.'[phone][]',
                           'validation_title' => $name.'_phone_'.$key,
                           'validation_num' => $key,
                           'repeater' => true,
                           'title'=>'Phone',
                           'class'=>'',
                           'placeholder'=>'Phone',
                           'around_div'=>'col-md-6',
                           'end_row'=>true,
                           'value'=>$value['phone']
                       ])
                   !!}
                    {!! viewComponents('select',[
                            'type'=>'text',
                            'name'=>$name.'[gander][]',
                            'repeater' => true,
                            'validation_title' => $name.'_gander_'.$key,
                            'validation_num' => $key,
                            'title'=>'Gander',
                            'class'=>'',
                            'placeholder'=>'Gander',
                            'around_div'=>'col-md-6',
                            'options'=>$options['gander'],
                            'start_row'=>true,
                            'selected'=>$value['gander']
                        ])
                    !!}
                    {!! viewComponents('select',[
                            'type'=>'text',
                            'name'=>$name.'[relation][]',
                            'repeater' => true,
                            'validation_title' => $name.'_relation_'.$key,
                            'validation_num' => $key,
                            'title'=>'Relation',
                            'class'=>'',
                            'placeholder'=>'Relation',
                            'around_div'=>'col-md-6',
                            'options'=>$options['parent_relations'],
                            'end_row'=>true,
                            'selected'=>$value['relation']
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
                        'repeater' => true,
                        'validation_title' => $name.'_name_0',
                        'validation_num' => 0,
                        'title'=>'Name',
                        'class'=>'',
                        'placeholder'=>'Name',
                        'around_div'=>'col-md-6',
                        'start_row'=>true,
                        'value'=>'',
                    ])
                !!}
                {!! viewComponents('select',[
                        'type'=>'text',
                        'name'=>$name.'[is_active][]',
                        'repeater' => true,
                        'validation_title' => $name.'_is_active_0',
                        'validation_num' => 0,
                        'title'=>'Is Active ?',
                        'class'=>'',
                        'placeholder'=>'Is Active ?',
                        'around_div'=>'col-md-6',
                        'options'=>$options['active'],
                        'end_row'=>true,
                        'selected'=>1
                    ])
                !!}
                {!! viewComponents('input',[
                       'type'=>'email',
                       'name'=>$name.'[email][]',
                       'repeater' => true,
                       'validation_title' => $name.'_email_0',
                       'validation_num' => 0,
                       'title'=>'Email',
                       'class'=>'',
                       'placeholder'=>'Email',
                       'around_div'=>'col-md-6',
                       'start_row'=>true,
                       'value'=>''
                   ])
               !!}
                {!! viewComponents('input',[
                       'type'=>'password',
                       'name'=>$name.'[password][]',
                       'title'=>'Password',
                       'repeater' => true,
                       'validation_title' => $name.'_password_0',
                       'validation_num' => 0,
                       'class'=>'',
                       'placeholder'=>'Password',
                       'around_div'=>'col-md-6',
                        'end_row'=>true,
                       'value'=>''

                   ])
               !!}
                {!! viewComponents('input',[
                       'type'=>'text',
                       'name'=>$name.'[national_id][]',
                       'title'=>'National ID',
                       'repeater' => true,
                       'validation_title' => $name.'_national_id_0',
                       'validation_num' => 0,
                       'class'=>'',
                       'placeholder'=>'National ID',
                       'around_div'=>'col-md-6',
                       'start_row'=>true,
                       'value'=>''
                   ])
               !!}
                {!! viewComponents('input',[
                       'type'=>'text',
                       'name'=>$name.'[phone][]',
                       'validation_title' => $name.'_phone_0',
                       'validation_num' => 0,
                       'repeater' => true,
                       'title'=>'Phone',
                       'class'=>'',
                       'placeholder'=>'Phone',
                       'around_div'=>'col-md-6',
                       'end_row'=>true,
                       'value'=>''
                   ])
               !!}
                {!! viewComponents('select',[
                        'type'=>'text',
                        'name'=>$name.'[gander][]',
                        'repeater' => true,
                        'validation_title' => $name.'_gander_0',
                        'validation_num' => 0,
                        'title'=>'Gander',
                        'class'=>'',
                        'placeholder'=>'Gander',
                        'around_div'=>'col-md-6',
                        'options'=>$options['gander'],
                        'start_row'=>true,
                        'selected'=>1
                    ])
                !!}
                {!! viewComponents('select',[
                        'type'=>'text',
                        'name'=>$name.'[relation][]',
                        'repeater' => true,
                        'validation_title' => $name.'_relation_0',
                        'validation_num' => 0,
                        'title'=>'Relation',
                        'class'=>'',
                        'placeholder'=>'Relation',
                        'around_div'=>'col-md-6',
                        'options'=>$options['parent_relations'],
                        'end_row'=>true,
                        'selected'=>1
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
