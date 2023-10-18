@isset($around_div)
<div class="{{ $around_div }}">
@endisset
<button type="{{ @$type }}" class="btn {{ @$class }}"
    @isset($attributes)
        @foreach ($attributes as $attr_key => $attr)
            {{ $attr_key }} = {{ $attr }}
        @endforeach
    @endisset
    >
    @isset($icon)
    <i class="{{ $icon }}"></i>
    @endisset

    {{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$title) }}
    </button>
@isset($around_div)
</div>
@endisset

@isset($below_div)
{!! $below_div !!}
@endisset
