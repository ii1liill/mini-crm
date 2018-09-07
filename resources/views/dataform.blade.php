@extends('layouts.app')
@section('content')
<div class="page-container">
	{!! $form !!} 
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('/lib/My97DatePicker/4.8/WdatePicker.js') }}"></script> 
@endsection