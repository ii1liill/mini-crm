<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="{{asset("/lib/html5shiv.js")}}"></script>
<script type="text/javascript" src="{{asset("/lib/respond.min.js")}}"></script>
<![endif]-->
<link href="{{asset("/static/h-ui/css/H-ui.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("/static/h-ui.admin/css/H-ui.login.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("/static/h-ui.admin/css/style.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("/lib/Hui-iconfont/1.0.8/iconfont.css")}}" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="{{asset("/lib/DD_belatedPNG_0.0.8a-min.js")}}" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>后台登录 - {{setting('app_name')}}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
  .header {
    background: none;
  }
    .app-name {
        color: #FFFFFF;
        height: 60px;
        line-height: 60px;
        padding: 0px 20px;
    }
</style>
</head>
<body>
<div class="header">
    @include('flash::message')
    <h1 class="app-name">{{setting('app_name')}}</h1>
</div>
<div class="loginWraper">
  <div class="loginBox">
    <form class="form form-horizontal" id="loginForm" action="{{url('/login')}}" method="post">
      {{ csrf_field() }}
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-xs-8">
          <input id="name" name="name" type="text" required placeholder="用户名" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-xs-8">
          <input id="password" name="password" required type="password" placeholder="密码" class="input-text size-L">
        </div>
      </div>
      {{-- <!-- <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input class="input-text size-L" type="text" placeholder="验证码" onblur="if(this.value==''){this.value='验证码:'}" onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;">
          <img src=""> <a id="kanbuq" href="javascript:;">看不清，换一张</a> </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <label for="online">
            <input type="checkbox" name="online" id="online" value="">
            使我保持登录状态</label>
        </div>
      </div> --> --}}
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
    </form>
  </div>
</div>
<div class="footer">Copyright {{setting('company_name')}} by {{setting('app_name')}}  </div>
<script type="text/javascript" src="{{asset("/lib/jquery/1.9.1/jquery.min.js")}}"></script> 
<script type="text/javascript" src="{{asset("/static/h-ui/js/H-ui.min.js")}}"></script>
<script type="text/javascript" src="{{asset("/lib/jquery.validation/1.14.0/jquery.validate.js")}}"></script>
<script type="text/javascript" src="{{asset("/lib/jquery.validation/1.14.0/validate-methods.js")}}"></script>
<script type="text/javascript" src="{{asset("/lib/jquery.validation/1.14.0/messages_zh.js")}}"></script>
<script>
//   $.validator.setDefaults({
//     submitHandler: function() {
//       alert("提交事件!");
//     }
// });
$().ready(function() {
    $("#loginForm").validate({
      messages: {
      name: "请输入用户名",
      password: "请输入密码" 
     }
    });
});
</script>
</body>
</html>