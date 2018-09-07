

@if (in_array("show", $actions))
    <a class="" title="@lang('rapyd::rapyd.show')" href="{!! $uri !!}?show={!! $id !!}"><span class="glyphicon glyphicon-eye-open"> </span></a>
@endif
@if (in_array("modify", $actions))
    <a class="" title="@lang('rapyd::rapyd.modify')" href="{{ route(Route::currentRouteName().".edit", $id) }}"><span class="Hui-iconfont Hui-iconfont-edit"> </span></a>
@endif
@if (in_array("delete", $actions))
    <a class="text-danger" title="@lang('rapyd::rapyd.delete')" onclick="datagrid_delete('{{ $id }}')" href="javascript:;"><span class="Hui-iconfont Hui-iconfont-del3"> </span></a>
@endif
