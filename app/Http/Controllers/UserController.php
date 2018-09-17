<?php

namespace App\Http\Controllers;

use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataForm;
use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = DataGrid::source(new User);
        $grid->add('select', '<input type="checkbox" name="" value="">')->cell( 
            function ($value, $row) {
                $id = $row->getAttributes()['id'];
                return "<input type='checkbox' name='selectedIDs[]' value='{$id}' >";
            }
        );
        $grid->add('name', '用户名');
        $grid->add('mobile', '电话');
        $grid->add('roles', '角色')->cell(
            function ($value, $row) {
                return implode("|", $value->pluck('name')->toArray());
            }
        );
        $grid->edit('/user/edit', '编辑', 'modify|delete');

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
            route('user.create'),
            "新建用户",
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
        $source = $id ? User::find($id) : new User;
        $form = DataForm::source($source);
        $form->add('name', '用户名', 'text')->rule('required'.( !$id ? '|unique:users' : '' ));
        $form->add('mobile', '电话', 'text')->rule('required'.( !$id ? '|unique:users' : '' ));
        $form->add('password', '密码', 'password');
        $form->add('roles', '分配角色', 'checkboxgroup')->options(Role::pluck('name', 'id')->all());

        $form->attributes(['class'=>'form form-horizontal form-validate']);

        $form->submit('保存');

        $form->saved(function () use ($form, $id) {
            // 同步角色
            $form->model->syncRoles($form->field('roles')->values);
            activity('用户')
                ->causedBy(Auth::user())
                ->withProperties(['id' => $form->model->id])
                ->log(($id ? '编辑用户：' : '创建用户：').$form->field('name')->value);
            flash('保存成功')->success();
            return Redirect::to('user');
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
        //
        $id = explode(",", $id);
        $users = User::whereIn('id', $id)->get();

        $deleteIds = [];
        foreach ($users as $user) {
            if ($user->hasRole('超级管理员')) {
                flash('超级管理员不能被删除')->warning();
                continue;
            }
            $deleteIds[] = $user->id;
            $user->delete();
        }
        activity('用户')
                ->causedBy(Auth::user())
                ->withProperties(['id' => $deleteIds])
                ->log('删除用户');
        if (!empty($deleteIds)) {
            flash("删除成功")->success();
        }
    }
}
