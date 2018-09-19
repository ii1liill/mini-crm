@if ( 
    (isset($label) && strlen($label)) || 
    (isset($buttons_left) && count($buttons_left)) || 
    (isset($buttons_center) && count($buttons_center)) || 
    (isset($buttons_right) && count($buttons_right))
    )

<div class="cl pd-5 bg-1 bk-gray mt-20">
            @if (isset($label) && strlen($label))
            <div class="pull-left">
                <h2>{!! $label !!}</h2>
            </div>
            @endif
            
            @if (Auth::user()->can('批量分配坐席') &&  Route::currentRouteName() == 'client')
            <div class="pull-left" style="margin-right:5px;">
                    <select name="attach_service" class="input-text" id="attach_service" onChange="attach_service()">
                            <option value="">分配坐席</option>
                            @foreach (\App\User::pluck('name', 'id') as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
            </div>
            @endif

            @if (isset($buttons_left) && count($buttons_left))
            <div class="pull-left">
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
