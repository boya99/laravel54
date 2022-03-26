@extends('layout.main')
@section('content_main')
        <div class="col-sm-8 blog-main">
            <div class="blog-post">
                <div style="display:inline-flex">
                    <h2 class="blog-post-title">{{ $post->title  }}</h2>
                    @can('update',$post)
                    <a style="margin: auto"  href="/posts/{{$post->id}}/edit">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                    @endcan
                    @can('delete',$post)
                    <a style="margin: auto"  href="/posts/{{$post->id}}/delete">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </a>
                    @endcan
                </div>

                <p class="blog-post-meta"><span class="auth-time">{{$post->created_at}}</span>
                    <span>作者：<a href="javascript:;">{{$post->user->name}}</a></span></p>

{{--                 {!! 不转义 !!}--}}
                {!! $post->content !!}

                    <br>
                <div>
                    <a href="/posts/{{$post->id}}/zan" type="button" class="btn btn-primary btn-lg">赞</a>

                </div>
            </div>

            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">评论</div>

                <!-- List group -->
                <ul class="list-group">
{{--                    <li class="list-group-item">--}}
{{--                        <h5>2017-05-28 10:15:08 by Kassandra Ankunding2</h5>--}}
{{--                        <div>--}}
{{--                            这是第一个评论这是第一个评论这是第一个评论这是第一个评论这是第一个评论这是第一个评论这是第一个评论这是第一个评论这是第一个评论--}}
{{--                        </div>--}}
{{--                    </li>--}}
                    @foreach($post->comments as $comment)
                        <li class="list-group-item">
                            <h5><span class="auth-time">{{$comment->created_at}}</span> <span>评论人：{{$comment->user->name}}</span> </h5>
                            <div>
                                {{$comment->content}}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">发表评论</div>

                <!-- List group -->
                <ul class="list-group">
                    <form action="/posts/{{$post->id}}/comment" method="post">
                        {{csrf_field()}}
                        <li class="list-group-item">
                            <textarea name="content" class="form-control" rows="10"></textarea>
                            @include('layout.error')
                            <button class="btn btn-default" type="submit">提交</button>
                        </li>
                    </form>

                </ul>
            </div>

        </div><!-- /.blog-main -->
@endsection

