<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zofe\Rapyd\Facades\DataGrid;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    //
    public function index()
    {
        $grid = DataGrid::source(Activity::with('causer'));
        $grid->add('id', 'ID');
        $grid->add('log_name', '类别');
        $grid->add('description', '描述');
        $grid->add('causer.name', '用户');
        $grid->add('properties', '详情');
        $grid->add('created_at', '时间', true);
        $grid->orderBy('id', 'desc');
        $grid->paginate(50);
        return view('datagrid', compact('grid'));
    }
}
