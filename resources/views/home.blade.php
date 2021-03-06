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
<link rel="stylesheet" type="text/css" href="{{asset("/static/h-ui/css/H-ui.min.css")}}" />
<link rel="stylesheet" type="text/css" href="{{asset("/static/h-ui.admin/css/H-ui.admin.css")}}" />
<link rel="stylesheet" type="text/css" href="{{asset("/lib/Hui-iconfont/1.0.8/iconfont.css")}}" />
<link rel="stylesheet" type="text/css" href="{{asset("/static/h-ui.admin/skin/default/skin.css")}}" id="skin" />
<link rel="stylesheet" type="text/css" href="{{asset("/static/h-ui.admin/css/style.css")}}" />
<!--[if IE 6]>
<script type="text/javascript" src="{{asset("/lib/DD_belatedPNG_0.0.8a-min.js")}}" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>{{setting('app_name')}}</title>
</head>
<body>
<header class="navbar-wrapper">
	<div class="navbar navbar-fixed-top">
		<div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="{{url('/')}}">{{setting('app_name')}}</a> <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="{{url('/')}}">{{setting('app_name')}}</a> 
			<a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
			 
		<nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
			<ul class="cl">
				<li> </li>
				<li class="dropDown dropDown_hover">
					<a href="#" class="dropDown_A">{{ Auth::user()->name }} <i class="Hui-iconfont">&#xe6d5;</i></a>
					<ul class="dropDown-menu menu radius box-shadow">
						<li><a href="javascript:;" onClick="myselfinfo()">个人信息</a></li>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">退出</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
				</ul>
			</li>
				{{-- <li id="Hui-msg"> <a href="#" title="消息"><span class="badge badge-danger">1</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li> --}}
				<li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
					<ul class="dropDown-menu menu radius box-shadow">
						<li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
						<li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
						<li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
						<li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
						<li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
						<li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</div>
</div>
</header>
<aside class="Hui-aside">
	<div class="menu_dropdown bk_2"> 
		@if (Auth::user()->can('查看客户'))
		<dl id="menu-member">
				<dt><i class="Hui-iconfont">&#xe60d;</i> 客户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
				<dd>
					<ul>
						@foreach (setting('client_status') as $item)
						<li><a data-href="{{ route('client', ['status' => $item, 'search' => 1]) }}" data-title="{{ $item }}" href="javascript:;">{{ $item }}</a></li>
						@endforeach
						<li><a data-href="{{ route('client') }}" data-title="客户列表" href="javascript:;">客户列表</a></li>
					</ul>
				</dd>
		</dl>
		@endif
		@if (Auth::user()->can('查看报表'))
		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 报表管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="{{ route('report') }}" data-title="日报表" href="javascript:;">报表</a></li>
					{{--  <li><a data-href="{{ route('report') }}" data-title="月报表" href="javascript:;">月报表</a></li>
					<li><a data-href="{{ route('report') }}" data-title="传统报表" href="javascript:;">传统报表</a></li>
					<li><a data-href="{{ route('report') }}" data-title="名单报表" href="javascript:;">名单报表</a></li>  --}}
				</ul>
			</dd>
		</dl>
		@endif
		@if (Auth::user()->can('用户管理'))
		<dl id="menu-admin">
			<dt><i class="Hui-iconfont">&#xe62d;</i> 用户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="{{ route('user') }}" data-title="用户列表" href="javascript:void(0)">用户列表</a></li>
					<li><a data-href="{{ route('role') }}" data-title="角色管理" href="javascript:void(0)">角色管理</a></li>
					<li><a data-href="{{ route('permission') }}" data-title="权限管理" href="javascript:void(0)">权限管理</a></li>
			</ul>
		</dd>
	</dl>
	@endif

	@if (Auth::user()->can('系统设置') || Auth::user()->can('系统日志'))
		<dl id="menu-system">
			<dt><i class="Hui-iconfont">&#xe62e;</i> 系统管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					@if (Auth::user()->can('系统设置'))
					<li><a data-href="{{route('setting')}}" data-title="系统设置" href="javascript:void(0)">系统设置</a></li>
					@endif
					@if (Auth::user()->can('系统日志'))
					<li><a data-href="{{ route('system.log') }}" data-title="系统日志" href="javascript:void(0)">系统日志</a></li>
					@endif
				</ul>
		</dd>
	</dl>
	@endif
</div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
	<div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
		<div class="Hui-tabNav-wp">
			<ul id="min_title_list" class="acrossTab cl">
				<li class="active">
					<span title="我的桌面" data-href="welcome.html">我的桌面</span>
					<em></em></li>
		</ul>
	</div>
		<div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
</div>
	<div id="iframe_box" class="Hui-article">
		<div class="show_iframe">
			<div style="display:none" class="loading"></div>
			<iframe scrolling="yes" frameborder="0" src="{{route('welcome')}}"></iframe>
	</div>
</div>
</section>

<div class="contextMenu" id="Huiadminmenu">
	<ul>
		<li id="closethis">关闭当前 </li>
		<li id="closeall">关闭全部 </li>
</ul>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="{{asset("/lib/jquery/1.9.1/jquery.min.js")}}"></script> 
<script type="text/javascript" src="{{asset("/lib/layer/2.4/layer.js")}}"></script>
<script type="text/javascript" src="{{asset("/static/h-ui/js/H-ui.min.js")}}"></script>
<script type="text/javascript" src="{{asset("/static/h-ui.admin/js/H-ui.admin.js")}}"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset("lib/jquery.contextmenu/jquery.contextmenu.r2.js")}}"></script>
<script type="text/javascript">
// 个人信息弹层Index
var myLayerIndex = 0;
$(function(){
	/*$("#min_title_list li").contextMenu('Huiadminmenu', {
		bindings: {
			'closethis': function(t) {
				console.log(t);
				if(t.find("i")){
					t.find("i").trigger("click");
				}		
			},
			'closeall': function(t) {
				alert('Trigger was '+t.id+'\nAction was Email');
			},
		}
	});*/
});
/*个人信息*/
function myselfinfo(){
    myLayerIndex = layer.open({
		type: 2,
		title: '个人信息',
		shadeClose: true,
		shade: 0.8,
		area: ['380px', '310px'],
		content: '{{url('my')}}' //iframe的url
	}); 
}

/*资讯-添加*/
function article_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*图片-添加*/
function picture_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*产品-添加*/
function product_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*用户-添加*/
function member_add(title,url,w,h){
	layer_show(title,url,w,h);
}


</script> 
 
</body>
</html>