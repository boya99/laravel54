文件存储  文件系统配置文件位于 
`config/filesystems.php`

默认下，你只能访问public目录，但是文件上传默认位置上传 storage/app/public
为了能通过网络访问，你需要创建 
public/storage 到 storage/app/public 的符号链接。

图片上传位置 默认位置：laravel54/storage/app/public

整个项目能访问的位置：laravel54/public

文件系统的配置文件位于 laravel54/config/filesystems.php

为了能够让 图片上传位置 在 laravel54/ public 能够访问，

**默认情况下 filesystems.php 的default 的配置项为 local**

1.先将  config/filesystems.php  中的 default 的配置项有local驱动改为 public 驱动执行建立软连接命令：

```
php artisan storage:link     //link 命令会找 config/filesystems.php 下的default 配置
```

成功后，在项目根路径/ public 会看到storage 的软连接


ps:测试数据快速填充 seed  database\factories\ModelFactory.php 中
重新define 一个 模型类      数据填充插件 https://github.com/fzaninotto/Faker

1.新增一个Post的填充数据，仿照填写完成后

2.控制台命令： php artisan tinker 进入 tinker控制台

```
命令：factory(App\Post::class,20)->make();   //是在命令行中直接显示20 个测试数据
命令：factory(App\Post::class,20)->create();   //是直接创建20 个测试数据
```

1，查看源 `composer config -g -l`

2，修改源：配置只在当前项目生效

`composer config repo.packagist composer https://mirrors.aliyun.com/composer/`

取消当前项目配置

`composer config --unset repos.packagist`

3，修改源：配置全局生效

`composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/`

取消全局配置

`composer config -g --unset repos.packagist`

**命令行版本7.4，项目运行php7.1 出现问题：Composer detected issues in your platform: Your Composer dependencies require a PHP version ">= 7.3.0".
将命令行的版本跟项目版本搞成一致。**

```
composer install --ignore-platform-reqs ： 安装 设置了忽略版本匹配
composer update --ignore-platform-reqs     更新设置忽略版本匹配
```

操作：
```
1.删除： composer.lock 和  vendor

2.修改  composer.json 的 config 配置项 增加

 "platform-check": false  //不检查版本


3.执行命令：
 1.composer clearcache  //清除缓存
 2.composer install --ignore-platform-reqs    //安装 设置了忽略版本匹配
 3.php artisan config:cache  //清除配置文件缓存。
 4.composer dump-autoload  //使用 dumpautoload 后会优先加载需要的类并提前返回
```



门脸类： 例如\Request::all();

在config/app.php 中的 aliases
```
Request $request 获取用户输入内容

$request->all();  以 数组 形式获取到所有输入数据:

$name = $request->input('name', 'Sally');  第二个参数传入一个默认值

$name = $request->name;     也可以动态获取

$input = $request->only(['username', 'password']);  仅能接收  'username', 'password'

$input = $request->except(['credit_card']); 除了 credit_card 其他都能接收

\request(['username', 'password'])  这是视频内容教的，也能获取

```

数据验证 controller 里 $this->validate(请求实例对象,['验证字段'=>'要求1|要求2|'])
验证失败会返回上一页中注册一个$errors的实例对象，进行验证

数据增删改

当 save 方法被调用时，created_at 以及 updated_at 时间戳将会被自动设置，因此我们不需要去手动设置它们
增加插入 使用save()方法

```
$flight = new Flight;
$flight->name = $request->name;
$flight->save();
```

更新 也使用save()方法

```
$flight = App\Flight::find(1);
$flight->name = 'New Flight Name';
$flight->save();
```

批量更新：'active' = 1 并且 destination = 'San Diego' 修改成 'delayed' => 1

```
App\Flight::where('active', 1)
          ->where('destination', 'San Diego')
          ->update(['delayed' => 1]);
```

插入数据：create()

```
$flight = App\Flight::create(['name' => 'zhangsan','age'=>18]);
```

**前提：Flight 模型上定义一个 fillable(允许批量增加的字段) 或 guarded(禁止增加的字段) 属性**

在flight模型中 添加： 不可被批量赋值的属性 price

protected $guarded = ['price'];

或者 protected $guarded = [];

属性都可以被批量赋值，你应该定义 $guarded 为空数组。


删除数据：先查再删

```
$flight = App\Flight::find(1);
$flight->delete();
```

**如果 知道 模型中的主键id，直接调用 destroy 方法**

```
App\Flight::destroy(1);
App\Flight::destroy([1, 2, 3]);
App\Flight::destroy(1, 2, 3);
```


## 数据模型关联 
例如：
手机表 phones  字段有 user_id
用户表 users  字段有 id
phones关联users

在 phone 模型中，增加 关联关系 user方法 表示关联user模型，users表

一对一关联 hasOne 通过手机找单个用户

```
public function user(){
    //表示找App/user模型文件，phones 表中的user_id = users表中的id
    return $this->hasOne('App\User','user_id','id');
}
```

一对多关联 hasMany 通过手机找多个用户
```
public function user(){
    //表示找App/user模型文件，phones 表中的user_id = users表中的id
    return $this->hasMany('App\User','user_id','id');
}
```


反向关联 belongsTo 通过手机找用户
```
public function user(){
    //表示找App/user模型文件，phones 表中的user_id = users表中的id
    return $this->belongsTo('App\User','user_id','id');
}
```

```
一对一  hasOne （用户-手机号）
一对多  hasMany （文章-评论）
一对多反向  belongsTo （评论-文章）
多对多  belongsToMany （用户-角色）
远层一对多 hasManyThrough(国家-作者-文章)  1个国家有多个作者，每个作者有n篇文章，国家和文章通过中间作者的关联叫远程一对多
多态关联 morphMany   (文章/视频-评论)     评论表中用一个字段 type type=1表示文章类型，type=2 表示视频类型
多态多对多 morphToMany   (文章/视频-标签)  一个标签可以给文章用，也可以给视频用，也可以多个文章多个视频用标签
注意关联模型时：一对多，以及 反向关联中 外键主键定义位置不同：重点难点！！！！！！！
```
**多对多**
```
用户有哪些角色  多对多关系，使用belongsToMany 在adminuser模型中添加：
    public function roles(){
//        参数1 'App\AdminRole' 要多对多的目标类   参数2 'admin_role_user' 两者中间关系表
//        参数3  'user_id' 中间关系表中跟当前model的外键  参数4 'role_id' 中间关系表中跟目标model的外键
        return $this->belongsToMany(
            'App\AdminRole',
            'admin_role_user',
            'user_id',
//            关系表中的user_id role_id取出来
            'role_id')->withPivot(['user_id','role_id']);
    }
```
## 使用model模型中的方法时有2中情况
```
多对多关系中：
有一下2种情况：

$this->roles  和 $this->roles() 区别

加了括号：返回的是模型关联对象    不加括号返回的是模型关联结果集
```
 










用户认证Auth 是指用户是否登录，登出

 email 字段被取出，如果用户被找到了，数据库里经过哈希的密码将会与数组中哈希的 password 值比对，
 如果两个值一样的话就会开启一个通过认证的 session 给用户。
 
如果认证成功，attempt 方法将会返回 true，反之则为 false。
    $rember boolean 是否被记住 users 数据表一定要包含一个 remember_token 字段，这是用来保存「记住我」令牌的
```
 if (Auth::attempt(['email' => $email, 'password' => $password],$rember)) {
    //用户记住
 }
 
 //注销
 Auth::logout();
 //是否登录
 Auth::check()
```

 鉴权策略使用 php artisan 命令对*模型进行鉴权

` php artisan make:policy *Policy`

 生成 Policies 文件夹 内有 *Policy.php 策略文件在其文件中修改例如：

 策略文件添加权限 是否有更改的权限
 ```
 public function update(User $user,Post $post){
     return $user->id == $post->user_id;
 }
 是否有创建的权限，只传模型用户是否有权限创建
 public function create(User $user)
 {
     //
 }
```

**策略编写完成进行，策略注册 在Providers/AuthServiceProvider 包含了一个 policies 属性
对 policise 属性进行编写**

```
protected $policies = [
//     模型文件     =>指向鉴权模型
      'App\Post' =>'App\Policies\PostPolicy',
];
```

权限验证 $post是否有被用户update权限 用户的id = posts的user_id

`$this->authorize('update',$post);`

权限验证 post是否有被用户create权限 属于这个用户就可以

`$this->authorize('create', Post::class);`

路由控制中，筛选需要权限的路由增加auth 中间件 middleware 使用auth 中间件
指向config /auth     下default属性中的web

```
Route::group(['middleware' => 'auth:web'], function () {
//登出行为
    Route::get('/logout', '\App\Http\Controllers\LoginController@logout');
})
```

修改表字段使用 修改users表需要执行下列操作：

`1.php artisan make:migration alter_users_table`

2.database/migrations/下有新创建的文件，在其中的up方法下增加代码，修改users表增加头像字段
```
if (Schema::hasTable('users')) {
    Schema::table('users', function (Blueprint $table) {
        $table->string('avatar',255)->default('')->comment('头像');
    });
}
```

3.执行命令后，查看数据字段
`php artisan migrate`



elasticsearch 中文搜索存储引擎主要概念

```
索引：index            =>相当于mysql的 database数据库  例如：laravel54 | study-laravel 等等
类型：type             =>相当于mysql的 数据表     每个索引有多个类型  例如：posts表 zans表 users表 相当于type 类型为posts/zans/users
文档：document         =>相当于mysql的表中的每一行数据    一个类型里有多个文档。 一篇文章  就是一篇文档就是1条文章数据
字段：field            =>就是对应字段  每篇文档有多个字段   例如：文章里可以包含title:字段，content:字段
模板：template         =>每一个索引(database)中的每一个字段（column）都有哪一些特殊的设置  例如：varchar类型使用哪个分析器  配置模板应用在哪个索引上面
```

查询案例：
http://localhost:9200/myindex/share/1    =>myindex :索引（查库） share : 索引类型(查表)  1：索引文档唯一标识

elasticsearch 中文分词：
-https://github.com/medcl/elasticsearch-rtf

安装es包
```
1.安装java jdk8
2.下载https://github.com/medcl/elasticsearch-rtf 这个包
3.解压，删除plugins 除了 ik 其他扩展包都可以删除（用不到） 解压的文件夹叫elasticsearch
3. cd elasticsearch/bin
4.  elasticsearch.bat
5.访问：http://127.0.0.1:9200/  是否成功
```

1.安装laravel/scout (http://d.laravel-china.org/docs/5.4/scout)

```
scout是个搜索的中间件,到时候可以更换底层es,上层逻辑不动
    1.1 执行 composer require laravel/scout    可能会有报错 版本不符
            可以执行 composer require laravel/scout:*   任意的版本
    1.2 ScoutServiceProvider 添加到你的 config/app.php 配置文件的 providers 数组中
          Laravel\Scout\ScoutServiceProvider::class,
    1.3 执行 php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider" 生成scout配置文件
```

2.安装scout的es驱动 让scout 支持es
(https://github.com/ErickTamayo/laravel-scout-elastic)
```
    2.1 执行 composer require tamayo/laravel-scout-elastic  可能会报错 版本不符
        可以执行 composer require tamayo/laravel-scout-elastic:*  任意版本
    2.2 添加服务提供器到 config/app.php 的 providers 数组中
        // config/app.php
        'providers' => [
            ...
            ScoutEngines\Elasticsearch\ElasticsearchProvider::class,
        ],
```

3.在 config/scout.php 文件中添加如下代码。默认使用的是 algolia 引擎，我们要使用 es 做引擎
```
        ...
'algolia' => [
    'id' => env('ALGOLIA_APP_ID', ''),
    'secret' => env('ALGOLIA_SECRET', ''),
],
//这里是添加的代码
'elasticsearch' => [
        'index' => env('ELASTICSEARCH_INDEX', 'laravel'),
        'hosts' => [
            env('ELASTICSEARCH_HOST', 'http://127.0.0.1:9200'),
        ],
 ],
```
3.1 配置.env 文件，添加如下代码。选择搜索引擎
```
 SCOUT_DRIVER=elasticsearch
 SCOUT_PREFIX=

 # elasticsearch 配置设置索引
 ELASTICSEARCH_INDEX=estest
 # elasticsearch服务器地址//我用的就是本地的
 ELASTICSEARCH_HOST=http://127.0.0.1:9200


```
使用laravel Command实现搜索引擎索引和模板建立

1.自定义es模板初始化命令
`php artisan make:command ESInit`

生成文件：app\Console\Commands\ESInit.php在文件中进行设置
```
命令：     $signature = 'es:init'
描述:     $description = 'init laravel es for post';
 操作难点：Client 是使用 composer require guzzlehttp/guzzle  来安装包

操作:     public function handle(){
                $client = new Client();
                //创建template
                $client->delete($url);
                $client->put($url, $param);
                // 创建index
                $client->delete($url);
                $client->put($url, $param);
         }
```

2.命令挂载在Kernel.php 中 在 $commands 属性添加ESInit这个类实例

3.php artisan   查看有新生成的es:init 这个命令

4. 执行 php artisan es:init


5.在post模型文件中添加

`use Laravel\Scout\Searchable;  //使用scout下的Searchable 语法规范`

定义索引里面的类型 type理解成一个数据表 把我们所有的要全文搜索的字段都存入到es中的一个叫'post'的表中

```
public function searchableAs()
{
    return "post";
}
```

 定义有哪些字段需要搜索
 ```
public function toSearchableArray()
{
    return [
        'title'=>$this->title,
        'content'=>$this->content,
    ];
}
```

6.post数据导入：

```
php artisan scout:import "App\Post"   //带命名空间
```

7.如果导入成功，浏览器访问：例如：
```
http://127.0.0.1:9200/laravel54/post/42   //laravel54表示查询哪个索引 post查找的类型，42就是id
//测试通过 post模型添加的数据自动输入es中
```
8. windows 运行
```
cd elasticsearch/bin 
cd D:\360安全浏览器下载\elasticsearch-rtf-master

elasticsearch.bat
```
## admin 后台模板使用 adminlte
`composer require "almasaeed2010/adminlte=~2.0"`


## 模型scope 方法使用：
laravel中在模板中处理(属于不属于)的数据(增删改查),引入了scope来处理

也就是在模板定义方法中,加上前缀scope。

简言之，Laravel中模型中可以定义scope开头方法，这类方法可以通过模型直接调用。这类方法也称作查询作用域。
aravel中要求在定义的方法scope后面跟的字母要大写(小驼峰命名法)
```
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query)
    {
        return $query->where('votes', '>', 100);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}

```

后面那我们去控制器进行处理数据
在控制器中使用:去除scope前缀,首字母变小写调用就好啦.

定义范围后，可以在查询模型时调用范围方法。但是，scope调用方法时不应包含前缀。您甚至可以将调用链接到各种范围，例如：
```
$users = App\User::popular()->active()->orderBy('created_at')->get();
```

通过or查询运算符组合多个Eloquent模型范围可能需要使用Closure回调：

```
$users = App\User::popular()->orWhere(function (Builder $query) {
    $query->active();
})->get();
```
 
但是由于这可能很麻烦，Laravel提供了一种“更高阶” orWhere方法，允许您在不使用闭包的情况下流畅地将这些范围链接在一起：

```
$users = App\User::popular()->orWhere->active()->get();
```

我们需要重新定义 boot 方法，集成父类 boot 以后，添加全局 scope，这样默认就已经全局使用了。

那么，我们有的时候有的查询是不需要这个全局 scope 的时候怎么办呢？去掉就可以
```
$posts = Post::withOutGlobalScope('avaiable')->orderBy('created_at','desc')->paginate(10);
```
**一对多 可以不用创建关联关系表，但是多对多，需要创建关联关系表，关联关系表无需创建model 模型**


### laravel 优化方法：
## 1.自带优化方法
```
## 优化1：路由缓存  php artisan route:cache  路径：bootstrap/cache/
        路由缓存清空    php artisan route:clear

## 优化2：配置缓存  php artisan config:cache  路径：bootstrap/cache/
         配置缓存清空  php artisan config:clear

## 优化3：优化类加载  php artisan optimize  路径：vender/composer/
        优化类加载清空  php artisan clear-compiled

```

## 2.Laravel框架开发调试工具Laravel Debugbar使用
``` 
安装教程
https://blog.csdn.net/h330531987/article/details/79088413
使用debugbar 调试无法检测到ajax 调用
```

## 3.页面比较慢，一般使用联合查询，未进行预加载 使用 预加载方式2中方式  with 和 load

```
    // with()使用 关联user表 （视图层foreach循环时 遍历查询user表，所以需要优化）
    public function index()
    {
        $user = Auth::user();
        $title = '列表页';
        $posts = Post::orderBy('created_at', 'desc')->withCount(['comments', 'zans'])->with('user')->paginate(6);

        return view('post/index', compact('title', 'posts', 'user'));
    }

    // load()使用 关联 user表   （视图层foreach循环时 遍历查询user表，所以需要优化）
    public function index()
    {
        $user = Auth::user();
        $title = '列表页';
        $posts = Post::orderBy('created_at', 'desc')->withCount(['comments', 'zans'])->paginate(6);
        $posts->load('user');
        return view('post/index', compact('title', 'posts', 'user'));
    }

```

## 4.慢sql的查询 \DB:listen()  只要进行sql 操作都会监听
```$xslt
1.注册  app\Providers\AppServiceProvider.php


    public function boot()
    {
        //启动前
        Schema::defaultStringLength(191);

//        公共页面传值 使用view::composer('模板','回调方法')
        View::composer('layout.sidebar',function($view){
            $topics = Topic::all();
            $view->with('topics',$topics);
        });
        //使用DB::listen 打印到日志 time 毫秒
        \DB::listen(function($query){
            $sql= $query->sql;
            $bindings = $query->bindings;
            $time = $query->time;
           if($time > 10){//大于10 毫秒的才打印
                //log 日志路径： storage\logs\laravel.log
               \Log::debug(var_export(compact('sql','bindings','time'),true));
           }

        });
    }
```
