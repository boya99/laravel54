
<div class="blog-masthead">
    <div class="container">
        <form action="/posts/search" >
        <ul class="nav navbar-nav navbar-left">
            <li>
                <a class="blog-nav-item " href="/posts">首页</a>
            </li>
            <li>
                <a class="blog-nav-item" href="/posts/create">写文章</a>
            </li>
            <li>
                <a class="blog-nav-item" href="/notices">通知</a>
            </li>
            <li>
                <input name="query" type="text" value="" class="form-control" style="margin-top:10px" placeholder="搜索词">
            </li>
            <li>
                <button class="btn btn-default" style="margin-top:10px" type="submit">Go!</button>
            </li>
        </ul>
        </form>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <div>
                    <img src="{{\Illuminate\Support\Facades\Auth::user()->avatar}}"
                         alt="" class="img-rounded" style="border-radius:500px; height: 30px">
                    <a href="#" class="blog-nav-item dropdown-toggle" data-toggle="dropdown" role="button"
{{--                       可以直接使用Auth::user() 对象实例  --}}
                       aria-haspopup="true" aria-expanded="false">{{\Auth::User()->name}}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/user/{{\Illuminate\Support\Facades\Auth::user()->id}}">我的主页</a></li>
                        <li><a href="/user/me/setting">个人设置</a></li>
                        <li><a href="/logout">登出</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>