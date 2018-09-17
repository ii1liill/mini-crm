@extends('layouts.app')

@if (isset($client->id)) 
@section('breadcrumbs')
{{ Breadcrumbs::render('client.edit', $client) }}
@endsection
@endif

@section('content')
<link rel="stylesheet" href="{{ asset('js/webuploader-0.1.5/webuploader.css') }}">
<link rel="stylesheet" href="{{ asset('js/webuploader-0.1.5/multi.css') }}">
<div class="page-container">
        <form id="clientForm" action="" method="post">
            {{ csrf_field() }}
            <div class="col-xs-4 nopadding">
                <table class="table table-border table-bordered table-bg">
                    <tr class="text-c">
                        <th colspan="2" style="text-align:center">客户资料</th>
                    </tr>
                    <tr class="text-c">
                        <th><span class="c-red">*</span>客户姓名</th>
                        <td class="formControls">
                            <input class="input-text" name="name" required id="name" type="text" value="{{ $client->name }}" placeholder="输入客户姓名"/>
                        </td>
                    </tr>
                    <tr class="text-c">
                        <th><span class="c-red">*</span>电话</th>
                        <td class="formControls">
                            <input class="input-text" name="phone1" required id="phone1" type="text" value="{{ $client->phone1 }}" style="width:100%" placeholder="输入电话"/>
                        </td>
                    </tr>
                    <tr class="text-c">
                        <th><span class="c-red">*</span>车牌</th>
                        <td class="formControls"><input class="input-text" required name="plate_number" id="plate_number"   type="text" value="{{ $client->plate_number }}" placeholder="输入车牌"/></td>
                    </tr>
                    <tr class="text-c">
                        <th>车架号</th>
                        <td><input class="input-text" name="vin" id="vin" type="text" value="{{ $client->vin }}" placeholder="输入车架号"/></td>
                    </tr>
                    <tr class="text-c">
                        <th>发动机号</th>
                        <td><input class="input-text" name="engine_number" id="engine_number" type="text" value="{{ $client->engine_number }}" placeholder="输入发动机号"/></td>
                    </tr>
                    <tr class="text-c">
                        <th>身份证</th>
                        <td><input class="input-text" name="id_card" id="id_card" type="text" value="{{ $client->id_card }}" maxlength="18" placeholder="输入18位身份证"/></td>
                    </tr>
                    <tr class="text-c">
                        <th>客户地址</th>
                        <td><input class="input-text" name="address" id="address" type="text" value="{{ $client->address }}" style="width:100%;" placeholder="输入客户地址"/></td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-4 nopadding">
                <table class="table table-border table-bordered table-bg">
                    <tr>
                        <th colspan="2" style="text-align:center">保险</th>
                    </tr>
                    <tr class="text-c">
                        <th><span class="c-red">*</span>初次登记</th>
                        <td class="formControls">
                            <input type="text" required onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="reg_at" id="reg_at" value="{{ $client->reg_at ? $client->reg_at->toDateString() : '' }}" class="input-text Wdate">
                        </td>
                    </tr>
                    <tr class="text-c">
                        <th><span class="c-red">*</span>保险起保</th>
                        <td class="formControls">
                            <input type="text" required onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="insure_created_at" id="insure_created_at" value="{{ $client->insure_created_at ? $client->insure_created_at->toDateString() : Carbon::now()->toDateString() }}" class="input-text Wdate">
                        </td>
                    </tr>
                    <tr class="text-c">
                        <th>商业险保费</th>
                        <td><input class="input-text" name="commercial_insure" id="commercial_insure" type="text" value="{{ $client->commercial_insure }}" placeholder="输入商业险"/></td>
                    </tr>
                    <tr class="text-c">
                        <th>交强险+车船税</th>
                        <td><input class="input-text" name="forced_insure" id="forced_insure" type="text" value="{{ $client->forced_insure }}" placeholder="输入交强险"/></td>
                    </tr>
                    <tr class="text-c">
                        <th>驾意险</th>
                        <td><input class="input-text" name="insure_driver_fee" id="insure_driver_fee" type="text" value="{{ $client->insure_driver_fee }}" placeholder="司机位保费"/></td>
                    </tr>
                    <tr class="text-c">
                        <th>保单类型</th>
                        <td>
                            <select class="input-text" name="insure_type" id="insure_type">
                                <option value="0" >未选</option>
                                @foreach (setting('insure_types') as $item)
                                    <option value="{{ $item }}" {{ $client->insure_type == $item ? 'selected="selected"' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-4 nopadding">
                <table class="table table-border table-bordered table-bg">
                    <tr>
                        <th colspan="2" style="text-align:center">其他</th>
                    </tr>
                    <tr class="text-c">
                        <th>所属坐席</th>
                        <td>
                            <select class="input-text" name="belong_service" id="belong_service">
                                <option value="0" >未选</option>
                                @foreach (App\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ $client->belong_service == $user->id ? 'selected="selected"' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="text-c">
                        <th>批次</th>
                        <td><input class="input-text" name="from_batch" id="from_batch" type="text" value="{{ $client->from_batch }}" placeholder="输入批次"/></td>
                    </tr>
                    <tr class="text-c">
                        <th id="abc" >状态</th>
                        <td id="edf" >
                            <select class="input-text" style="width:100%" name="status" id="status">
                                <option value="0" >未选</option>
                                @foreach (setting('client_status') as $item)
                                    <option value="{{ $item }}" {{ $client->status == $item ? 'selected="selected"' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="text-c">
                        <th>预约时间</th>
                        <td id="edff" ><input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="order_at" id="order_at" value="{{ $client->order_at ? $client->order_at->toDateString() : '' }}" class="input-text Wdate"></td>
                    </tr>
                    <tr>
                        <th class="text-c">照片</th>
                        <td>
                                <div id="uploader" class="wu-example" style="width:380px">
                                        <div class="queueList">
                                            <div id="dndArea" class="placeholder">
                                                <div id="filePicker"></div>
                                                <p>或将照片拖到这里，也可以直接粘贴</p>
                                            </div>
                                        </div>
                                        <div class="statusBar" style="display:none;">
                                            <div class="progress">
                                                <span class="text">0%</span>
                                                <span class="percentage"></span>
                                            </div><div class="info"></div>
                                            <div class="btns">
                                                <div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
                                            </div>
                                        </div>
                                    </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="page-container col-xs-12">
                    <strong>照片：</strong>
                    
                </div>
            <div style="position: fixed;
                        bottom: 100px;
                        right: 2px;
                        border-radius:5px; 
                        height:20px; 
                        line-height:40px; 
                        text-align:center; 
                        ">
                @if (!empty($client->id))
                    <button type="button" class="btn btn-primary radius" id="service-trace-button">追踪</button>
                    <br/>
                @endif
                @if (auth()->user()->can('编辑客户'))
                    <button type="submit" class="btn btn-success radius" id="admin-role-save">保存</button>
                    <br/> 
                @endif
                <button type="button" onClick="javascript:history.go(-1);" class="btn btn-default radius">返回</button>
                <br/>
                 
            </div>
            @if (!empty($client->pics))
                @foreach ($client->pics as $path)
                    <input type="hidden" name="pics[]" value="{{ $path }}">
                @endforeach
            @endif
        </form>
        
        <div id="traceGrid">

        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('/lib/My97DatePicker/4.8/WdatePicker.js') }}"></script> 
<script type="text/javascript" src="{{ asset('js/webuploader-0.1.5/webuploader.min.js') }}"></script> 
<script>
    var uploadedPics = {!! $client->pics ? json_encode($client->pics) : '[]' !!};
</script>
<script type="text/javascript" src="{{ asset('js/webuploader-0.1.5/multi.js') }}"></script> 
    <script>
        $.validator.setDefaults({
            submitHandler: function() {
                $.ajax({
                    type: "{{ isset($client->id) ? 'PUT' : 'POST' }}",
                    url: "{{ isset($client->id) ? route('client.update', $client->id) : route('client.store') }}",
                    dataType: 'json',
                    data: $("#clientForm").serialize(),
                    success: function(data) {
                        window.history.back(-1);
                    },
                    error:function(error) {
                        console.log(error)
                    },
                });		
            }
        });
        var getTrace = function() {
            var url = '{{ route("trace", ['client_id' => $client->id]) }}';
            $.get(url).done(function(res) {
                $("#traceGrid").html(res);
            });
        }
        var traceLayerIndex;
        $().ready(function() {
            getTrace();
            $("#clientForm").validate();
            $("#service-trace-button").on('click', function() {
                traceLayerIndex = layer.open({
                    type: 2,
                    title: '追踪客户',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['480px', '510px'],
                    content: '{{ isset($client->id) ? route('trace.create', ['client_id' => $client->id]) : '' }}' //iframe的url
                }); 
            })

            
        })
    </script>
@endsection