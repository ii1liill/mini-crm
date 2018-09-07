<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyController extends Controller
{
    //
    public function index()
    {
        return view('my.index');
    }

    /**
     * 修改用户信息-密码
     *
     * @param UserPost $request
     * @return void
     */
    public function update(UserPost $request)
    {
        $user = Auth::user();
        $user->password = $request->input('password');

        $user->save();
        flash('密码设置成功')->success();
        return redirect()->back();
    }
}
