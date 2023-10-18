@php
$count = 1;
$row_count = 0;
@endphp
<div class="row" id="new_fields_{{ $name }}">
    @if (!empty($values))
    @foreach ($values as $value)
    <div class="panel panel-default element_fields_{{ $name }}" count="{{ $count }}">
        <div class="panel-body">
            {{-- {!! viewComponents(
                'upload_file', [
                'type' => 'file',
                'name' => $name.'[attach_file][]',
                'title' => '',
                'class' => '',
                'placeholder' => 'Attach',
                'around_div' => 'col-md-4',
                'value' => $value->attach_file ? readFileStorage($value->attach_file) : '',
                ])
            !!} --}}
            {!! viewComponents('textarea', [
            'type' => 'textarea',
            'attributes' => ['rows' => 12],
            'name' => $name.'[message][]',
            'title' => '',
            'class' => '',
            'placeholder' => 'Message',
            'around_div' => 'col-md-12',
            'value' => $value->message,
            ]) !!}

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
            {{-- {!! viewComponents(
                'upload_file', [
                    'type' => 'file',
                    'name' => $name.'[attach_file][]',
                    'title' => 'Attach',
                    'class' => '',
                    'placeholder' => 'Attach',
                    'around_div' => 'col-md-4',
                    'value' => '',
                ])
            !!} --}}
            {!! viewComponents(
                'textarea', [
                    'type' => 'textarea',
                    'attributes' => ['rows' => 12],
                    'name' => $name.'[message][]',
                    'title' => '',
                    'class' => '',
                    'placeholder' => 'Message',
                    'around_div' => 'col-md-12',
                    'value' => '',
                ])
            !!}

        </div>
    </div>
    @endif
</div>
