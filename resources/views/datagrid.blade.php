@extends('layouts.app')
@section('content')
<div class="page-container">
	@if (isset($filter))
		<div class="text-c search-bar">
			{!! $filter !!}
		</div>
	@endif
	{!! $grid !!} 
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('/lib/My97DatePicker/4.8/WdatePicker.js') }}"></script> 
<script>
		function changeURLArg(url,arg,arg_val){ 
			var pattern=arg+'=([^&]*)'; 
			var replaceText=arg+'='+arg_val; 
			if(url.match(pattern)){ 
				var tmp='/('+ arg+'=)([^&]*)/gi'; 
				tmp=url.replace(eval(tmp),replaceText); 
				return tmp; 
			}else{ 
				if(url.match('[\?]')){ 
					return url+'&'+replaceText; 
				}else{ 
					return url+'?'+replaceText; 
				} 
			} 
			return url+'\n'+arg+'\n'+arg_val; 
		} 
		function attach_service() {
			var ids = [];
			$("input:checkbox[name='selectedIDs[]']:checked").each(function(index, item) {
				ids.push($(this).val());
			});
			if (ids.length <= 0) {
				return false;
			}
			var ids = [];
			$("input:checkbox[name='selectedIDs[]']:checked").each(function(index, item) {
				ids.push($(this).val());
			});
			if (ids.length <= 0) {
				return false;
			}
			var $select = $("#attach_service");
			var $name = $select.find('option:selected').text();
			var $serviceId = $select.val();
			console.log($serviceId);
			if (!$serviceId) {
				return false;
			}
			var index = layer.confirm('确认将所选客户分配给'+$name+'吗？',function(index){
				var url = "{{ route('client.attachService') }}";
				$.ajax({
					type: 'POST',
					url: url,
					data: {ids:ids, serviceId: $serviceId},
					dataType: 'json',
					success: function(data) {
						location.reload();
					},
					error:function(data) {
						location.reload();
					},
				});		
			});
			return false;
		}
	function datagrid_delete_multi() {
		var ids = [];
		$("input:checkbox[name='selectedIDs[]']:checked").each(function(index, item) {
			ids.push($(this).val());
		});
		if (ids.length <= 0) {
			return false;
		}
		datagrid_delete(ids);
		return false;
	}
	function datagrid_delete(ids) {
		var url = "{{ route(Route::currentRouteName()) }}"
		var index = layer.confirm('确认要删除吗？',function(index){
			$.ajax({
				type: 'DELETE',
				url: url + "/" + (typeof(ids) === "object" ? ids.join(",") : ids),
				dataType: 'json',
				success: function(data) {
					location.reload();
				},
				error:function(data) {
					location.reload();
				},
			});		
		});
		return false;
	}
</script>
@endsection