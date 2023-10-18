
@isset($around_div)
<div class="{{ $around_div }}">
@endisset
    @isset($title)
    <h4>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Select '.$title) }}</h4>
    @endisset


    <div class="fileinput fileinput-new" data-provides="fileinput">

        <div class="input-group input-large"
            @if(isset($readonly) && $readonly==true)
                style="display: none !important;"
            @endif
        >
            <div class="form-control uneditable-input span3" data-trigger="fileinput">
                <i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
                </span>
            </div>
            <span class="input-group-addon btn default btn-file" style="background-color: orange;">
            <span class="fileinput-new"> {{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Select '.$title) }} </span>

            <input type="file" name="{{ $name }}"
                @isset($attributes))
                    @foreach ($attributes as $attr_key => $attr)
                        {{ $attr_key }} = {{ $attr }}
                    @endforeach
                @endisset
            >
            </span>
            <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">
                {{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Remove') }} </a>
        </div>
        @if($value!='')
            @if (file_exists($value))
                <p style="margin-top: 10px;font-size: large;">
                    <a href="{{ $value }}" target="_blank"> {{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Preview '.$title) }}</a>
                </p>
            @endif
        @endif
    </div>

    <p style="padding-top: 15px; color:red" id="{{ $name }}_validation"><span class="label label-danger"></p>
@isset($around_div)
</div>
@endisset
