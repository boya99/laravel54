<h1>多片数据视图</h1>


@foreach($data as $item)
    <p>遍历循环{{$item['title']}}</p>
@endforeach

<h3>分片传递{{$title}}</h3>