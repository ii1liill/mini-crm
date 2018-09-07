<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zofe\Rapyd\Facades\DataGrid;
use Spatie\Permission\Models\Role;
use Zofe\Rapyd\Facades\DataForm;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = DataGrid::source(new Role);
        $grid->add('select', '<input type="checkbox" name="" value="">')->cell( 
            function ($value, $row) {
                $id = $row->getAttributes()['id'];
                return "<input type='checkbox' name='selectedIDs[]' value='{$id}' >";
            }
        );
        $grid->add('name', '角色名称');
        $grid->add('permissions', '权限')->cell(
            function ($value, $row) {
                return implode("|", $value->pluck('name')->toArray());
            }
        );
        $grid->edit('/role/edit', '编辑', 'modify|delete');

        $grid->link(
            '#',
            "批量删除",
            "TL",
            [
                'onClick' => 'datagrid_delete_multi();',
                'class' => 'btn btn-danger'
            ]
        );  //add button
        $grid->link(
            route('role.create'),
            "新建角色",
            "TL",
            [
                'class' => 'btn btn-primary'
            ]
        );  //add button

        return view('datagrid', compact('grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $form = $this->form();

         
        return $form->view('dataform');
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
        //
        $form = $this->form($id);
        return $form->view('dataform');
    }

    /**
     * roleId
     *
     * @param [type] $id
     * @return void
     */
    protected function form($id = null)
    {
        //
        $source = $id ? Role::find($id) : new Role;
        $form = DataForm::source($source);
        $form->add('name', '角色名称', 'text')->rule('required'.( !$id ? '|unique:roles' : '' ));
        $form->add('permissions', '分配权限', 'checkboxgroup')->options(Permission::pluck('name', 'id')->all());

        $form->attributes(['class'=>'form form-horizontal form-validate']);

        $form->submit('保存');

        $form->saved(function () use ($form, $id) {
            activity('角色')
                ->causedBy(Auth::user())
                ->withProperties(['id' => $form->model->id])
                ->log(($id ? '编辑角色：' : '创建角色：').$form->field('name')->value);
            flash('保存成功')->success();
            return Redirect::to('role');
            // $form->link(route('permission'), "back to the form");
        });
        $form->build();

        return $form;
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
        $id = explode(",", $id);
        Role::whereIn('id', $id)->delete();
        activity('角色')
                ->causedBy(Auth::user())
                ->withProperties(['id' => $id])
                ->log('删除角色');
        flash("删除成功")->success();
    }
}
