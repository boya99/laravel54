@extends('layout.main')
@section('content_main')

        <div class="col-sm-8 blog-main">
            <form class="form-horizontal" action="/user/me/setting" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="name" type="text" value="{{$user->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">头像</label>
                    <div class="col-sm-2">
                        <input class=" file-loading preview_input" type="file" value="头像"   name="avatar">
                        <img  class="preview_img" src="{{$user->avatar}}" alt="" class="img-rounded" style="width:100%;margin-top:10px;border-radius:500px;">
                    </div>
                </div>
                @include('layout.error')
                <button type="submit" class="btn btn-default">修改</button>
            </form>
            <br>

        </div>

@endsection