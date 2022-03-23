{{--继承 public下base的页面--}}
@extends('public.base')
@section('content_main')
    <h3>这是 继承模板中预留的占位符 content_main 的位置</h3>
@endsection

{{--
    模板渲染顺序是先执行页面内容，再执行 页面继承
--}}
<h1>这是test 页面</h1>
<h3>这是页面传递{{ $title }} 页面</h3>

@if ($isShow === true)
    if语句 我有一个记录！
@elseif ($isShow === false)
    elseif 我有多个记录！
@else
    else 我没有任何记录！
@endif

<hr/>

 @foreach($data as $item)
    <p>遍历循环{{$item['title']}}</p>
 @endforeach

