@extends('layouts.app')

@section('content')
<div class="page-container">
        <form class="form form-horizontal form-validate" enctype="multipart/form-data" action="{{ route('client.import.post') }}" method="post" id="import-form">
            {{ csrf_field() }}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>批次：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" required class="input-text" value="{{ date("YmdHi") }}" placeholder="" id="from_batch" name="from_batch">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>所属坐席：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select name="belong_service" class="input-text" id="belong_service">
                        <option value="0">未选</option>
                        @foreach (App\User::all() as $key => $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择文件</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="file" required class="input-text" value="" placeholder="" id="upload_excel" name="upload_excel">
                </div>
            </div>
            <div style="position: fixed;bottom: 5px;right: 5px;color:#fff; text-decoration:none;filter:alpha(opacity=90); -moz-opacity:0.9;-khtml-opacity: 0.9; opacity: 0.8;display:block; border-radius:5px; height:40px; line-height:40px; text-align:center; ">
                <button type="submit" class="btn btn-success radius" id="khadd"><i class="icon-ok"></i>确定</button>
                <button onClick="parent.layer.closeAll()" class="btn btn-default radius" type="button">&nbsp;&nbsp;关闭&nbsp;&nbsp;</button>
            </div>
        </form>
    </div>
@endsection
    