

@php
    if(count($options) > 0){
        $by=(count($options) % 2 == 0)?count($options)/2:count($options)/3;

        if($by < 1){
            $by=1;
        }
        $options=array_chunk($options, $by, true);
        $rows=(count($options) % 2 == 0)?2:3;
    }

@endphp

<div class="row">
    @foreach ($options as $key=>$values)
    @if ($rows==2)
    <div class="col-md-6">
    @else
    <div class="col-md-4">
    @endif

        <div class="form-group form-md-checkboxes">
            <label>{{ @$title }}</label>
            <div class="md-checkbox-list">
                @foreach ($values as $key => $value)
                    <div class="md-checkbox">
                        <input type="checkbox" name="{{ $name }}[]" id="{{ $name }}{{ $key }}" class="md-check" value="{{ $key }}" @if(in_array($key,$selected)) checked @endif>
                        <label for="{{ $name }}{{ $key }}">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span>
                        {{ $value }} </label>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    @endforeach
</div>

@isset($below_div)
    {!! $below_div !!}
@endisset
<p style="padding-top: 15px; color:red" id="{{ $name }}_validation"><span class="label label-danger"></p>


