@if (count($breadcrumbs))
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
            <span data-href="{{ $breadcrumb->url }}" class="c-gray en">&gt;</span>
            <a href="{{ $breadcrumb->url }}">
                {{ $breadcrumb->title }}
            </a>
            @else
                <span class="c-gray en">&gt;</span>
                {{ $breadcrumb->title }}
            @endif
        @endforeach
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.reload();" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
    
@endif