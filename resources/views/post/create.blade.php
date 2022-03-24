@extends('layout.main')
@section('content_main')
        <div class="col-sm-8 blog-main">
            <form action="/posts" method="POST">
                {{--  laravel 模板渲染会自带一个token，防止csrf跨站点请求伪造 攻击 --}}
{{--                <input type="hidden" name="_token" value="{{csrf_token()}}">--}}
                {{--   laravel 自带 csrf_field 和上述一直             --}}
                {{csrf_field()}}
                <div class="form-group">
                    <label>标题</label>
                    <input name="title" type="text" class="form-control" placeholder="这里是标题">
                </div>
                <div class="form-group">
                    <label>内容</label>
                    <textarea id="content"  style="height:400px;max-height:500px;" name="content" class="form-control" placeholder="这里是内容"></textarea>
                </div>
{{--                 如果错误存在--}}
                @include('layout.error')


                <button type="submit" class="btn btn-default">提交</button>

            </form>
            <br>

        </div><!-- /.blog-main -->
@endsection
