<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="{{asset("/lib/html5shiv.js")}}"></script>
<script type="text/javascript" src="{{asset("/lib/respond.min.js")}}"></script>

<![endif]-->
<link href="{{asset("/static/h-ui/css/H-ui.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("/static/h-ui.admin/css/H-ui.admin.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("/lib/Hui-iconfont/1.0.8/iconfont.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("/css/style.css")}}" rel="stylesheet" type="text/css" />
<style>
        .pull-left {
                float: left;
        }
        .pull-right {
                float: right;
        }
        td.formControls label.error {
            right: 10px;
            top: 12px;
        }
        .search-bar label.sr-only {
            display: none !important;
        }
        .has-error .help-block {
            color: red;
        }
</style>

<!--[if IE 6]>
<script type="text/javascript" src="{{asset("/lib/DD_belatedPNG_0.0.8a-min.js")}}" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>{{ setting('app_name') }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
        @yield('breadcrumbs', Breadcrumbs::render())
        @include('flash::message')
        @yield('content')
<script type="text/javascript" src="{{asset("/lib/jquery/1.9.1/jquery.min.js")}}"></script> 
<script type="text/javascript" src="{{asset("/lib/layer/2.4/layer.js")}}"></script>
<script type="text/javascript" src="{{asset("/lib/jquery.validation/1.14.0/jquery.validate.js")}}"></script>
<script type="text/javascript" src="{{asset("/lib/jquery.validation/1.14.0/validate-methods.js")}}"></script>
<script type="text/javascript" src="{{asset("/lib/jquery.validation/1.14.0/messages_zh.js")}}"></script>
<script type="text/javascript" src="{{asset("/static/h-ui/js/H-ui.min.js")}}"></script>
<script type="text/javascript" src="{{asset("/static/h-ui.admin/js/H-ui.admin.js")}}"></script> 
<script>
    var BASE_URL = '{{ url('') }}';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(".form-validate").validate();
    function layer_close() {
        layer.closeAll();
    }
</script>
@yield('script')
</body>
</html>