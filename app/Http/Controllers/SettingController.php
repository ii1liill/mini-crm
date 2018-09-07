<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingOptions = [
        'string' => [
            'app_name',
            'company_name',
            'copyright'
        ],
        'array' => [
            'insure_third_limits',
            'insure_glass_limits',
            'insure_scratch_limits',
            'insure_types',
            'create_channels',
            'client_status',
            'call_status'
        ],
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setting.index');
        //
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
        $request = $request->all();
        if (!is_array($request)) {
            flash('数据为空')->error();
            return redirect()->back();
        }
        foreach ($request as $option => $value) {
            if (in_array($option, $this->settingOptions['string'])) {
                setting([$option => $value]);
            }
            if (in_array($option, $this->settingOptions['array'])) {
                $value = str_replace("\r\n", "\n", $value);
                setting([$option => explode("\n", $value)]);
            }
        }
        setting()->save();
        flash('设置成功')->success();
        return redirect()->back();
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
