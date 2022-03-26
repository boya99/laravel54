{{-- extends 继承模板，来自 layout/main.blade.php--}}
@extends('layout.main')
{{-- section('content_main')  解析了 @yield('content_main') 的占位符--}}
 @section('content_main')
        <div class="col-sm-8 blog-main">
            <div>
                <div id="carousel-example" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example" data-slide-to="1"></li>
                        <li data-target="#carousel-example" data-slide-to="2"></li>
                    </ol><!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="http://ww1.sinaimg.cn/large/44287191gw1excbq6tb3rj21400migrz.jpg" alt="..." />
                            <div class="carousel-caption">...</div>
                        </div>
                        <div class="item">
                            <img src="http://ww3.sinaimg.cn/large/44287191gw1excbq5iwm6j21400min3o.jpg" alt="..." />
                            <div class="carousel-caption">...</div>
                        </div>
                        <div class="item">
                            <img src="http://ww2.sinaimg.cn/large/44287191gw1excbq4kx57j21400migs4.jpg" alt="..." />
                            <div class="carousel-caption">...</div>
                        </div>
                    </div>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span></a>
                    <a class="right carousel-control" href="#carousel-example" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
            </div>
            <div style="height: 20px;"></div>
            <div class="content-main">
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

                    <p class="blog-post-meta">赞 0  | 评论 {{$post->comments_count}}</p>
                </div>
                @endforeach

                    {{-- 默认分页样式--}}
                    {{ $posts->links() }}
            </div><!-- /.blog-main -->
        </div>
 @endsection


