<?php

namespace App\Http\Controllers;

use App\User;
use App\Trace;
use App\Client;
use Illuminate\Http\Request;
use Zofe\Rapyd\Facades\DataGrid;
use Illuminate\Support\Facades\DB;
use Zofe\Rapyd\Facades\DataFilter;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 要统计的客户状态
        $statStatus = [
            '失败客户',
            '无效客户',
            '实收客户'
        ];
        // 搜索时间区间参数
        $requestAll = $request->all();
        $builder = Client::from('crm_clients')->with(['creator', 'service']);
        $builder->whereNotNull('belong_service');
        $builder->groupBy('belong_service');
        $builder->select('*', DB::raw('count(1) as `total`'));
        $filter = DataFilter::source($builder);
        $filter->add('belong_service', '坐席', 'select')->options(['选择坐席'] + User::pluck('name', 'id')->toArray());
        $filter->add('start_at', '开始时间', 'text')->attributes([
            'class' => 'input-text Wdate',
            'onClick' => 'WdatePicker({dateFmt:"yyyy-MM-dd"})'
        ])->scope(
            function ($query, $value) {
                if ($value) {
                    return $query->where('created_at', '>=', $value);
                }
                return $query;
            }
        );
        $filter->add('end_at', '结束时间', 'text')->attributes([
            'class' => 'input-text Wdate',
            'onClick' => 'WdatePicker({dateFmt:"yyyy-MM-dd"})'
        ])->scope(
            function ($query, $value) {
                if ($value) {
                    return $query->where('created_at', '<=', $value);
                }
                return $query;
            }
        );
        $filter->submit('搜索', 'BL', ['class' => 'btn btn-success radius']);
        $filter->reset('重置', 'BL', ['class' => 'btn btn-default radius']);

        $grid = DataGrid::source($filter);
        $grid->add('service.name', '坐席');
        $grid->add('total', '客户数');
        foreach ($statStatus as $item) {
            $grid->add($item, $item)->cell(
                function ($value, $row) use ($item, $requestAll) {
                    $builder = Client::where('belong_service', $row->belong_service)
                        ->where('status', $item);
                    if (!empty($requestAll['start_at'])) {
                        $builder->where('created_at', '>=', $requestAll['start_at']);
                    }
                    if (!empty($requestAll['end_at'])) {
                        $builder->where('created_at', '>=', $requestAll['end_at']);
                    }
                    return $builder->count();
                }
            );
        }
        // $grid->add('', '');
        $grid->paginate(20);
        return view('datagrid', compact('filter', 'grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
