@extends('layout.main')
@section('content_main')
    <div class="alert alert-success" role="alert">
        下面是搜索"{{$query}}"出现的文章，共{{$posts->total()}}条
    </div>

    <div class="col-sm-8 blog-main">
        @foreach($posts as $post)
            <div class="blog-post">
                <h2 class="blog-post-title"><a href="/posts/{{$post->id}}" >{{$post->title}}</a></h2>
                {{--                                                       $post->user->name  是找post表对应的user表的name--}}
                <p class="blog-post-meta"><span class="auth-time">{{$post->created_at}}</span>
                    <span>作者：<a href="/user/{{$post->user->id}}">{{$post->user->name}}</a></span> </p>
                {{-- 默认全部显示--}}
                {{--<p>{{$post->content}}</p>--}}
                {{-- 使用str_limit 限制内容长度，显示100字符，超出部分显示...           --}}
                {{-- {{}} 语句会自动调用 PHP 的 htmlspecialchars 函数防止 XSS 攻击。不想转义 可以使用  {!! $name !!}             --}}
                <p>{!! str_limit($post->content,'150','...') !!}</p>

                <p class="blog-post-meta">赞 {{$post->zans_count}}    <span class="auth-time">评论 {{$post->comments_count}}</span></p>
            </div>
        @endforeach
            {{-- 默认分页样式--}}
            {{ $posts->links() }}

    </div><!-- /.blog-main -->
@endsection

