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