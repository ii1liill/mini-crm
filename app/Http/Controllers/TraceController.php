<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\Facades\DataForm;
use App\Client;
use App\Trace;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TraceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grid = DataGrid::source(Trace::where('client_id', $request->input('client_id')));
        $grid->add('created_at', '备注时间', true);
        $grid->add('call_status', '通话状态');
        $grid->add('status', '客户状态');
        $grid->add('order_at', '预约时间');
        $grid->add('note', '备注信息');
        $grid->orderBy('created_at', 'desc');

        return view('partials.datagrid', compact('grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $clientId = $request->input('client_id');
        $form = $this->form($clientId);
        return $form->view('trace.form', compact('form'));
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

    protected function form($clientId, $id = null)
    {
        $client = Client::find($clientId);
        if (!Auth::user()->can('追踪所有客户') && $client->belong_service != Auth::user()->id) {
            return response('您无权追踪该客户');
        }
        $source = $id ? Trace::find($id) : new Trace;
        $form = DataForm::source($source);
        $form->attributes(
            [
                'id' => 'traceForm'
            ]
        );
        $form->add('belong_service', '', 'auto')->insertValue(Auth::user()->id);
        $form->add('client_id', $client->id, 'hidden')->insertValue($client->id);
        $form->add('client_name', '客户', 'text')->attributes(
            [
                'readonly' => true,
                 
            ]
        )->insertValue($client->name);

        $callStatus = $clientStatus = [];
        foreach (setting('call_status') as $value) {
            $callStatus[$value] = $value;
        }
        foreach (setting('client_status') as $value) {
            $clientStatus[$value] = $value;
        }
        $form->add('call_status', '接听状态', 'radiogroup')->options($callStatus)->attributes(
            [
                'required' => 'true'
            ]
        )->rule('required');
        $form->add('status', '客户状态', 'select')->options($clientStatus)->rule('required')->insertValue($client->status)->attributes(
            [
                'required' => ''
            ]
        );
        $form->add('order_at', '预约时间', 'text')->attributes(
            [
                'class' => 'input-text Wdate',
                'onClick' => 'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss"})'
            ]
        )->insertValue($client->order_at);

        $form->add('created_at', '成交时间', 'text')->attributes(
            [
                'class' => 'input-text Wdate',
                'onClick' => 'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss"})'
            ]
        )->insertValue(Carbon::now()->toDateTimeString());

        $form->add('note', '备注', 'textarea')->attributes(
            [
                'class' => 'textarea',

            ]
        );

        $form->attributes(['class'=>'form form-horizontal form-validate']);

        $form->submit('保存');

        $form->saved(function () use ($form, $client) {
            $client->status = $form->field('status')->value;
            if (!empty($form->field('order_at')->value)) {
                $client->order_at = $form->field('order_at')->value;
            }
            $client->save();

            activity('坐席')
                ->causedBy(Auth::user())
                ->withProperties(
                    [
                        'id' => $form->model->id,
                        'client_id' => $client->id,
                        'client_name' => $client->name,
                        'call_status' => $form->field('call_status')->value,
                        'status' => $form->field('status')->value
                    ]
                )
                ->log('追踪客户：'.$client->name);
            // $form->message("OK");
            // return response()->json('OK');
            // return Redirect::to('role');
            // $form->link(route('permission'), "back to the form");
        });
        $form->build();

        return $form;
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
