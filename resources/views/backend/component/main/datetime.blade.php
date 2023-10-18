@isset($around_div)
<div class="{{ $around_div }}">
@endisset
    <div class="input-group date form_datetime">
        @isset($title)
        <label>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$title) }}</label>
        @endisset
        <input type="text" size="16" name="{{ $name }}" value='{{ old(@$name,@$value) }}' readonly class="form-control">
        <span class="input-group-btn">
        <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
        </span>
        @isset($below_div)
        <p style="padding-top: 15px;" ><span class="label label-info">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Note') }}</span> {!! appendToLanguage(getDashboardCurrantLanguage(),'globals',$below_div) !!}</p>
        @endisset
    </div>

@isset($around_div)
</div>
@endisset
<p style="padding-top: 15px; color:red" id="{{ $name }}_validation"><span class="label label-danger"></p>
