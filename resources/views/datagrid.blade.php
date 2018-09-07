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
<script>
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