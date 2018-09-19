<?php

namespace App\Http\Controllers;

use App\User;
use App\Batch;
use App\Trace;
use App\Client;
use Illuminate\Http\Request;
use Zofe\Rapyd\Facades\DataGrid;
use App\Http\Requests\ClientPost;
use Zofe\Rapyd\Facades\DataFilter;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:删除客户', ['only' => ['destroy']]);
        $this->middleware('permission:编辑客户', ['only' => ['edit', 'update']]);
        $this->middleware('permission:添加客户', ['only' => ['create', 'store']]);
        $this->middleware('permission:批量导入客户', ['only' => ['import', 'postImport']]);
        $this->middleware('permission:批量导出客户', ['only' => ['export']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // $clients = Client::
        $builder = Client::with(['creator', 'service', 'lastNote']);
        if (!Auth::user()->can('查看所有客户')) {
            $builder->where('belong_service', Auth::user()->id);
        }
        $builder->orderBy('order_at', 'desc')->orderBy('id', 'desc');
        $filter = DataFilter::source($builder);

        $filter->add('status', '状态', 'hidden')->scope(
            function ($query, $value) {
                if ($value == '未接触客户') {
                    return $query->where(function($query) use ($value) {
                        return $query->where('status', $value)->orWhere('status', null)->orWhere('status', '');
                    });
                } elseif ($value) {
                    return $query->where('status', $value);
                } else {
                    return $query;
                }
            }
        );
 
        $filter->add('keywords', '输入客户名称、电话、车牌', 'text')->scope(
            function ($query, $value) {
                return $query->where(function($query) use ($value) {
                    return $query->where('name', 'like', "%$value%")
                    ->orWhere('phone1', 'like', "%$value%")
                    ->orWhere('phone2', 'like', "%$value%")
                    ->orWhere('plate_number', 'like', "%$value%");
                });
            }
        )->attr(['class' => 'input-text', 'autocomplete' => 'off', 'style' => 'width: 250px']);
        
        $filter->submit('搜索', 'BL', ['class' => 'btn btn-success radius']);
        $filter->reset('重置', 'BL', ['class' => 'btn btn-default radius']);

        $grid = DataGrid::source($filter);

        if (Auth::user()->can('删除客户')) {
            $grid->add('select', '<input type="checkbox" name="" value="">')->cell( 
                function ($value, $row) {
                    $id = $row->getAttributes()['id'];
                    return "<input type='checkbox' name='selectedIDs[]' value='{$id}' >";
                }
            );
        }

        $grid->add('id', 'ID', true);
        $grid->add('name', '客户姓名')->cell(function($value, $row) {
            if (Auth::user()->can('编辑客户') || Auth::user()->can('追踪客户')) {
                return '<a href="'.route('client.edit', ['id' => $row->id]).'">'.$value.'</a>';
            } else {
                return $value;
            }
        });
        $grid->add('plate_number', '车牌')->cell(function($value, $row) {
            if (Auth::user()->can('编辑客户') || Auth::user()->can('追踪客户')) {
                return '<a href="'.route('client.edit', ['id' => $row->id]).'">'.$value.'</a>';
            } else {
                return $value;
            }
        });
        $grid->add('vin', '车架号');
        $grid->add('service.name', '坐席');
        $grid->add('from_batch', '批次');
        $grid->add('status', '状态');
        // $grid->add('insure_type', '保单类型');
        // $grid->add('insure_created_at', '起保时间')->cell(
        //     function ($value) {
        //         return $value ? $value->toDateString() : '';
        //     }
        // );
        // $grid->add('reg_at', '初次登记时间')->cell(
        //     function ($value) {
        //         return $value ? $value->toDateString() : '';
        //     }
        // );
        $grid->add('lastNote.note', '备注');
        $grid->add('order_at', '预约时间', true)->cell(
            function ($value) {
                return $value ? $value->toDateString() : '';
            }
        );
        // $grid->add('creator.name', '创建者');
        if (Auth::user()->can('删除客户') || Auth::user()->can('编辑客户')) {
            if (Auth::user()->can('编辑客户') || Auth::user()->can('追踪客户')) {
                $oprate[] = 'modify';
            }
            if (Auth::user()->can('删除客户')) {
                $oprate[] = 'delete';
            }
            $grid->edit('/client/edit', '编辑', implode('|', $oprate));
        }

        
        
        if (Auth::user()->can('删除客户')) {
            $grid->link(
                '#',
                "批量删除",
                "TL",
                [
                    'onClick' => 'datagrid_delete_multi();',
                    'class' => 'btn btn-danger'
                ]
            );  //add button
        }
        if (Auth::user()->can('添加客户')) {
            $grid->link(
                route('client.create'),
                "添加客户",
                "TL",
                [
                    'class' => 'btn btn-primary'
                ]
            );  //add button
        }
        if (Auth::user()->can('批量导入客户')) {
            $grid->link(
                '#',
                "导入",
                "TL",
                [
                    'class' => 'btn btn-primary',
                    'onClick' => 'layer.open({type: 2, title: "导入", shadeClose: true, shade: 0.8, area: ["380px", "310px"], content: "'.route('client.import').'",end: function() {location.reload()} }); '
                ]
            );  //add button
        }
        if (Auth::user()->can('批量导出客户')) {
            $grid->link(
                route('client.export'),
                "导出",
                "TL",
                [
                    'class' => 'btn btn-primary'
                ]
            );  //add button
        }

        $perPage = $request->input('perpage', 10);

        $grid->paginate($perPage);
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
        return view("client.edit", ['client' => new Client, 'trace' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientPost $request)
    {
        $input = $request->except(['_token', '_method', 'id']);
        $input['create_by'] = \Illuminate\Support\Facades\Auth::id();
        $client = Client::create($input);
        flash('创建成功。')->success();
        activity('客户')
                ->causedBy(Auth::user())
                ->withProperties(['id' => $client->id])
                ->log('创建客户：'. $client->name);
        return ['msg' => 'ok'];
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
        // return view("client.form");
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
        $client = $this->getClient($id);

        if ($client->belong_service != Auth::user()->id && !Auth::user()->can('查看所有客户')) {
            flash('您不能编辑该用户')->error();
            return redirect()->back();
        }
        return view("client.edit", compact('client'));

    }

    public function getClient($id)
    {
        return Client::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientPost $request, $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response('Not Found', 404);
        }
        $input = $request->except(['_token', '_method', 'id']);
        if (empty($input['pics'])) {
            $input['pics'] = null;
        }
        $client->update($input);
        activity('客户')
                ->causedBy(Auth::user())
                ->withProperties(['id' => $client->id])
                ->log('修改客户：'. $client->name);
        
        flash('保存成功。')->success();
        
        return ['msg' => 'success'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->can('删除客户')) {
            flush('您无权删除。')->error();
            return false;
        }
        $id = explode(",", $id);
        Client::whereIn('id', $id)->delete();
        activity('客户')
                ->causedBy(Auth::user())
                ->withProperties(['id' => $id])
                ->log('删除客户');
        flash("删除成功。")->success();
    }

    /**
     * 批量分配坐席
     *
     * @return nothing
     */
    public function attachService(Request $request)
    {
        if (!Auth::user()->can('批量分配坐席')) {
            flush('您无权分配。')->error();
            return false;
        }
        $ids = $request->input('ids');
        $serviceId = $request->input('serviceId');
        $service = User::find($serviceId);
        $result = Client::whereIn('id', $ids)->update(
            [
                'belong_service' => $serviceId
            ]
        );

        activity('客户')
                ->causedBy(Auth::user())
                ->withProperties(
                    [
                        '坐席' => $service->name,
                        '数量' => $result
                    ]
                )
                ->log('分配坐席');
        flash("成功将".$result.'个客户分配给坐席：'.$service->name)->success();
    }

    public function import()
    {
        return view("client.import");
    }

    public function postImport(Request $request)
    {
        set_time_limit(0);
        $file = $request->file('upload_excel');
        $fromBatch = $request->input('from_batch');
        $belongService = $request->input('belong_service');
        $realPath = $file->getRealPath();
        // $importIds = [];
        $importCount = 0;
        $map = config('cfmap.maps');
        (new FastExcel)
            ->import($file, function($line) use ($map, &$importCount, $fromBatch, $belongService) {
                $data = [];
                foreach ($map as $key => $v) {
                    if (!empty($line[$v])) {
                        $data[$key] = $line[$v];
                        if ($key == 'risk_times') {
                            $data[$key] = intval($line[$v]);
                        }
                    }
                }
                $data['create_by'] = Auth::user()->id;
                $data['from_batch'] = $fromBatch;
                $data['belong_service'] = $belongService;
                $client = Client::create($data);
                // $importIds[] = $client->id;
                $importCount ++;
                return $client;
            });
        
        activity('客户')
                ->causedBy(Auth::user())
                ->withProperties(['batch' => $fromBatch, 'count' => $importCount])
                ->log('导入客户');

        flash('导入成功。')->success();
        return view('system/success_back', ['tip' => '导入成功']);
    }

    public function export()
    {
        set_time_limit(0);
        $builder = Client::with(['creator', 'service']);
        if (!Auth::user()->can('查看所有客户')) {
            $builder->where('belong_service', Auth::user()->id);
        }
        $clients = $builder->get();
        $file = urlencode('客户列表_'.date('Y-m-d').'.xlsx');
        $map = config('cfmap.export_maps');
        activity('客户')
            ->causedBy(Auth::user())
            ->log('导出客户');
        (new FastExcel($clients))
            ->download($file, function($value) use ($map) {
                $new = [];
                $attributes = $value->getAttributes();
                foreach ($map as $key => $v) {
                    if ($key  == 'create_by') {
                        $new[$v] = $value->creator ? $value->creator->name : '';
                    } elseif ($key == 'belong_service') {
                        $new[$v] = $value->service ? $value->service->name : '';
                    } else {
                        // if (in_array($key, $value->))
                        $new[$v] = $attributes[$key];
                    }
                }
                return $new;
            });
    }
}
 