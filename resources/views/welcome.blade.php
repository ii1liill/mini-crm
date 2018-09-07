@extends('layouts.app')

@section('content')
<div class="page-container">
        <p class="f-20 text-success">欢迎使用{{setting('app_name')}} </p>
        <p>登录次数：{{$loginCount}} </p>
            <p>上次登录IP：{{ $previousLogin ? $previousLogin->getExtraProperty('ip') : '初次登录' }}  上次登录时间：{{ $previousLogin ? $previousLogin->created_at : '初次登录' }}</p>
        {{-- <table class="table table-border table-bordered table-bg">
            <thead>
                <tr>
                    <th colspan="7" scope="col">信息统计</th>
                </tr>
                <tr class="text-c">
                    <th>统计</th>
                    <th>资讯库</th>
                    <th>图片库</th>
                    <th>产品库</th>
                    <th>用户</th>
                    <th>管理员</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-c">
                    <td>总数</td>
                    <td>92</td>
                    <td>9</td>
                    <td>0</td>
                    <td>8</td>
                    <td>20</td>
                </tr>
                <tr class="text-c">
                    <td>今日</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr class="text-c">
                    <td>昨日</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr class="text-c">
                    <td>本周</td>
                    <td>2</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr class="text-c">
                    <td>本月</td>
                    <td>2</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            </tbody>
        </table> --}}
    </div>
    <footer class="footer mt-20">
        <div class="container">
            <p>技术支持：<a href="mailto:1090753786@qq.com">1090753786@qq.com</a></p>
        </div>
    </footer>
@endsection
