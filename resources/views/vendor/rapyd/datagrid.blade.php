

<div class="rpd-datagrid">
    @include('rapyd::toolbar', array('label'=>$label, 'buttons_right'=>$buttons['TR'], 'buttons_left'=>(isset($buttons['TL']) ? $buttons['TL'] : []) , 'buttons_center'=> (isset($buttons['TC']) ? $buttons['TC'] : [])))
    
    <div class="mt-20 table-responsive">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr>
                @foreach ($dg->columns as $column)
                    <th{!! $column->buildAttributes() !!}>
                        @if ($column->orderby)
                            @if ($dg->onOrderby($column->orderby_field, 'asc'))
                                <i class="Hui-iconfont Hui-iconfont-arrow2-top"></i>
                            @else
                                <a href="{{ $dg->orderbyLink($column->orderby_field,'asc') }}">
                                    <i class="Hui-iconfont Hui-iconfont-arrow2-top"></i>
                                </a>
                            @endif
                            @if ($dg->onOrderby($column->orderby_field, 'desc'))
                                <i class="Hui-iconfont Hui-iconfont-arrow2-bottom"></i>
                            @else
                                <a href="{{ $dg->orderbyLink($column->orderby_field,'desc') }}">
                                    <i class="Hui-iconfont Hui-iconfont-arrow2-bottom"></i>
                                </a>
                            @endif
                        @endif
                        {!! $column->label !!}
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @if (count($dg->rows) == 0)
                <tr><td colspan="{!! count($dg->columns) !!}">{!! trans('rapyd::rapyd.no_records') !!}</td></tr>
            @endif
            @foreach ($dg->rows as $row)
                <tr{!! $row->buildAttributes() !!}>
                    @foreach ($row->cells as $cell)
                        <td{!! $cell->buildAttributes() !!}>{!! $cell->value !!}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="btn-toolbar mt-20" role="toolbar">
        @if ($dg->havePagination())
            <div class="pull-left">
                @if (Auth::user()->can('删除客户'))
                    <div class="pull-left">
                        每页显示: <select class="input-text" style="width:80px;" name="perpage" id="perpage" onChange="location.href=changeURLArg(location.href, 'perpage', this.value)">
                                <option value="10" {{ Request::input('perpage') == 10 ? 'selected' : '' }}>10条</option>
                                <option value="50" {{ Request::input('perpage') == 50 ? 'selected' : '' }}>50条</option>
                                <option value="100" {{ Request::input('perpage') == 100 ? 'selected' : '' }}>100条</option>
                                <option value="200" {{ Request::input('perpage') == 200 ? 'selected' : '' }}>200条</option>
                                <option value="300" {{ Request::input('perpage') == 300 ? 'selected' : '' }}>300条</option>
                                <option value="400" {{ Request::input('perpage') == 400 ? 'selected' : '' }}>400条</option>
                                <option value="500" {{ Request::input('perpage') == 500 ? 'selected' : '' }}>500条</option>
                            </select>
                        </div>
                @endif
                
                {!! $dg->links() !!}
            </div>
            {{-- <div class="pull-right rpd-total-rows">
                {!! $dg->totalRows() !!}
            </div> --}}
        @endif
    </div>
</div>

