

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
                {!! $dg->links() !!}
            </div>
            {{-- <div class="pull-right rpd-total-rows">
                {!! $dg->totalRows() !!}
            </div> --}}
        @endif
    </div>
</div>

