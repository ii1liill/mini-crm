@extends('layouts.app')

@section('content')
<div class="page-container">
<form class="form form-horizontal" method="post" action="{{route('setting.update', 1)}}" id="form-article-add">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div id="tab-system" class="HuiTab">
                <div class="tabBar cl">
                    <span>应用设置</span>
                    <span>保险设置</span> 
                </div>
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            平台名称：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" id="app_name" name="app_name" placeholder="请填写平台名称" value="{{setting('app_name')}}" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">
                                公司名称：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" id="company_name" name="company_name" placeholder="请填写公司名称" value="{{setting('company_name')}}" class="input-text">
                            </div>
                        </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            底部版权信息：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" id="copyright" name="copyright" placeholder="&copy; {{date('Y')}} My-CRM" value="{{setting('copyright')}}" class="input-text">
                        </div>
                    </div>
                </div>
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            三者险：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                        <textarea name="insure_third_limits" id="insure_third_limits" cols="60" rows="5">{{ setting('insure_third_limits') ? implode("\n", setting('insure_third_limits')) : null }}</textarea>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            玻璃险：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                        <textarea name="insure_glass_limits" id="insure_glass_limits" cols="60" rows="5">{{ setting('insure_glass_limits') ? implode("\n", setting('insure_glass_limits')) : null }}</textarea>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            划痕险：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                        <textarea name="insure_scratch_limits" id="insure_scratch_limits" cols="60" rows="5">{{ setting('insure_scratch_limits') ? implode("\n", setting('insure_scratch_limits')) : null }}</textarea>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            保单类型：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                        <textarea name="insure_types" id="insure_types" cols="60" rows="5">{{ setting('insure_types') ? implode("\n", setting('insure_types')) : null }}</textarea>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            录入渠道：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                        <textarea name="create_channels" id="create_channels" cols="60" rows="5">{{ setting('create_channels') ? implode("\n", setting('create_channels')) : null }}</textarea>
                        </div>
                    </div>
                    <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">
                                客户状态：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                            <textarea name="client_status" id="client_status" cols="60" rows="5">{{ setting('client_status') ? implode("\n", setting('client_status')) : null }}</textarea>
                            </div>
                        </div>
                    <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">
                                通话状态：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                            <textarea name="call_status" id="call_status" cols="60" rows="5">{{ setting('call_status') ? implode("\n", setting('call_status')) : null }}</textarea>
                            </div>
                        </div>
                </div>
            </div>
                     
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
                    <button class="btn btn-default radius" type="reset">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $("#tab-system").Huitab({
                index:0
            });
        })
    </script>
@endsection
