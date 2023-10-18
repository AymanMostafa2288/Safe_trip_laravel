@php
$count = 1;
$row_count = 0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
    @if (!empty($values))
    @foreach ($values['title'] as $key=>$value)
        <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
            <div class="panel-body">
                @if ($card_type=='cards_with_image')
                    {!! viewComponents(
                        'upload_image', [
                            'type' => 'image',
                            'name' => $name.'[image][]',
                            'title' => 'Image',
                            'class' => '',
                            'placeholder' => 'Image',
                            'around_div' => 'col-md-4',
                            'value' => (array_key_exists($key,$values['image']))?readFileStorage($values['image'][$key]):'',
                        ])
                    !!}
                @elseif ($card_type=='cards_with_icone')
                    {!! viewComponents('input',[
                            'type'=>'text',
                            'name'=>$name.'[icon][]',
                            'title'=>'',
                            'class'=>'',
                            'placeholder'=>'Icon',
                            'around_div'=>'col-md-6',
                            'value'=> $values['icon'][$key]
                        ])
                    !!}
                @endif

                {!! viewComponents(
                    'select',[
                        'type'=>'text',
                        'name'=>$name.'[lang][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Language',
                        'around_div'=>'col-md-6',
                        'options'=>[
                            'ar'=>'Arabic',
                            'en'=>'English'
                        ],
                        'selected'=>$values['lang'][$key]
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[title][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Title',
                        'around_div'=>'col-md-6',
                        'value'=>$value
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[button_text][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Button Text',
                        'around_div'=>'col-md-6',
                        'value'=>$values['button_text'][$key]
                    ])
                !!}
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[url][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Url',
                        'around_div'=>'col-md-6',
                        'value'=>$values['url'][$key]
                    ])
                !!}
                {!! viewComponents(
                    'textarea', [
                        'type' => 'textarea',
                        'attributes' => ['rows' => 6],
                        'name' => $name.'[content][]',
                        'title' => '',
                        'class' => '',
                        'placeholder' => 'Content',
                        'around_div' => 'col-md-6',
                        'value' => $values['content'][$key]
                    ])
                !!}

            </div>
        </div>
    @php
    $count++;
    $row_count = $row_count + 1;
    @endphp
    @endforeach
    @else
    <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
        <div class="panel-body">
            @if ($card_type=='cards_with_image')
                {!! viewComponents(
                    'upload_image', [
                        'type' => 'image',
                        'name' => $name.'[image][]',
                        'title' => 'Image',
                        'class' => '',
                        'placeholder' => 'Image',
                        'around_div' => 'col-md-4',
                        'value' => '',
                    ])
                !!}
            @elseif ($card_type=='cards_with_icone')
                {!! viewComponents('input',[
                        'type'=>'text',
                        'name'=>$name.'[icon][]',
                        'title'=>'',
                        'class'=>'',
                        'placeholder'=>'Icon',
                        'around_div'=>'col-md-6',
                        'value'=>''
                    ])
                !!}
            @endif

            {!! viewComponents(
                'select',[
                    'type'=>'text',
                    'name'=>$name.'[lang][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Language',
                    'around_div'=>'col-md-6',
                    'options'=>[
                        'ar'=>'Arabic',
                        'en'=>'English'
                    ],
                    'selected'=>''
                ])
            !!}
            {!! viewComponents('input',[
                    'type'=>'text',
                    'name'=>$name.'[title][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Title',
                    'around_div'=>'col-md-6',
                    'value'=>''
                ])
            !!}
            {!! viewComponents('input',[
                    'type'=>'text',
                    'name'=>$name.'[button_text][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Button Text',
                    'around_div'=>'col-md-6',
                    'value'=>''
                ])
            !!}
            {!! viewComponents('input',[
                    'type'=>'text',
                    'name'=>$name.'[url][]',
                    'title'=>'',
                    'class'=>'',
                    'placeholder'=>'Url',
                    'around_div'=>'col-md-6',
                    'value'=>''
                ])
            !!}
            {!! viewComponents(
                'textarea', [
                    'type' => 'textarea',
                    'attributes' => ['rows' => 6],
                    'name' => $name.'[content][]',
                    'title' => '',
                    'class' => '',
                    'placeholder' => 'Content',
                    'around_div' => 'col-md-6',
                    'value' => '',
                ])
            !!}



        </div>
    </div>
    @endif
</div>
