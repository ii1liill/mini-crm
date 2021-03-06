@if ( 
    (isset($label) && strlen($label)) || 
    (isset($buttons_left) && count($buttons_left)) || 
    (isset($buttons_center) && count($buttons_center)) || 
    (isset($buttons_right) && count($buttons_right))
    )

<div class="row cl">
            @if (isset($label) && strlen($label))
            <div class="pull-left">
                <h2>{!! $label !!}</h2>
            </div>
            @endif
            @if (isset($buttons_left) && count($buttons_left))
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                @foreach ($buttons_left as $button) {!! $button !!}
                @endforeach
            </div>
            @endif
    
            @if (isset($buttons_right) && count($buttons_right))
            <div class="pull-right">
                @foreach ($buttons_right as $button) {!! $button !!}
                @endforeach
            </div>
            @endif
    
            @if (isset($buttons_center) && count($buttons_center))
            <div style="text-align: center;">
                @foreach ($buttons_center as $button) {!! $button !!}
                @endforeach
            </div>
            @endif
            @if (isset($dg))
                <span class="r">共有数据：<strong> {!! $dg->totalRows() !!}</strong> 条</span> 
            @endif
    </div>
@else
@endif
