{{--引入公共部分头部--}}
@include('public.baseHead')

<div class="container">

    <div class="blog-header">
    </div>

    <div class="row">
        {{--       公共模板部分使用 占位符@yield('content_main') 预留空间内容--}}
        @yield('content_main')

    </div>

</div><!-- /.container -->
{{--引入公共部分尾部--}}
@include('public.baseFooter')


</body>
</html>
