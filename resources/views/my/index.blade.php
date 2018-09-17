@extends('layouts.app')
@section('breadcrumbs', false)
@section('content')
<div class="page-container">
<form class="form form-horizontal" method="post" action="{{route('my.update')}}" id="form-my-update">
                    {{ csrf_field() }}
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            用户名 </label>
                        <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" readonly="true" value="{{Auth::user()->name}}" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">
                                电话 </label>
                            <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" readonly="true" value="{{Auth::user()->mobile}}" class="input-text">
                            </div>
                        </div>
                    <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">
                                密码：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                            <input type="password" minlength="6" id="password" required name="password" placeholder="如需修改密码请填写" value="{{old('password')}}" class="input-text">
                            </div>
                        </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            确认密码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="password" minlength="6" id="confirm_password" equalTo="#password" name="confirm_password" placeholder="确认密码" value="" class="input-text">
                        </div>
                    </div>
                     
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
                    <button class="btn btn-default radius" id="button-reset" type="reset">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $().ready(function() {
            // $("#form-my-update").validate({
            //     messages: {
            //         password: {
            //             required: "请填写密码"
            //         },
            //         confirm_password : {
            //             equalTo: '两次密码输入不一致'
            //         }
            //     }
            // });
            $("#button-reset").on("click", function() {
                if (window.parent.myLayerIndex) {
                    window.parent.layer.close(window.parent.myLayerIndex);
                    return false;
                }
            })
        })
    </script>
@endsection