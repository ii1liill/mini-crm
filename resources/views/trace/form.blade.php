@extends('layouts.app')
@section('content')
<div class="page-container">
	{!! $form !!} 
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('/lib/My97DatePicker/4.8/WdatePicker.js') }}"></script> 
<script>
    $(function() {
        $("#traceForm").submit(function() {
            if (!$("input[name='call_status']:checked").val()) {
                // alert('请选择接听状态');
                if (!$("#div_call_status").hasClass("has-error")) {
                    $("#div_call_status").addClass("has-error").append('<span class="help-block">\
                            <span class="glyphicon glyphicon-warning-sign"></span>\
                            接听状态 不能为空。\
                        </span>');
                }
                return false;
            }
            var url = $(this).attr('action');
            $.post(url, $(this).serialize()).done(function(res) {
                window.parent.layer.msg('提交成功');
                window.parent.getTrace();
                window.parent.layer.close(window.parent.traceLayerIndex);
            });
            return false;
        });
        if ($("select#status").val() !== '实收客户') {
            $("#fg_created_at").hide();
        } else {
            $("#fg_created_at").show();
        }
        $("select#status").on('change', function() {
            var status = $("select#status").val();
            if (status === '实收客户') {
                $("#fg_created_at").show();
            } else {
                $("#fg_created_at").hide();
            }
        })
    })
</script>
@endsection