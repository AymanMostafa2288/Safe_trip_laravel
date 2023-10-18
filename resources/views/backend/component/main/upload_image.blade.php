
@isset($around_div)
<div class="{{ $around_div }}">
@endisset
@isset($title)
<h4>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Select '.$title) }}</h4>
@endisset

<div class="fileinput fileinput-new" data-provides="fileinput"
    @if(isset($readonly) && $readonly==true)
    style="display: none !important;"
    @endif
    >
    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
        @if($value!='')
            <img src="{{ $value }}">
        @endif
    </div>
    <div>
        <span class="btn default btn-file">
        <span class="fileinput-new">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Select '.$title) }}</span>
        <span class="fileinput-exists">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Change') }} </span>
        <input type="file" name="{{ $name }}"
            @isset($attributes)
                @foreach ($attributes as $attr_key => $attr)
                    {{ $attr_key }} = {{ $attr }}
                @endforeach
            @endisset
        >
        </span>
        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Remove') }} </a>

    </div>
    @isset($below_div)
    <span style="color:red">{!! $below_div !!}</span>
    @endisset
</div>
<p style="padding-top: 15px; color:red" id="{{ $name }}_validation"><span class="label label-danger"></p>
@isset($around_div)
</div>
@endisset

