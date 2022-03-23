
## About Laravel 笔记：


 
# 1.修改.env 的mysql redis等相关配置 #

# 2.进入项目执行 运行php项目程序 #
     php artisan serve
 
 显示所有命令

     php artisan 
 
       
# 3. 其中 migrate:install安装 数据迁移 为数据迁移做备份 #

      php artisan migrate:install

  创建 数据迁移表

       Create the migration repository 
 

# 4 .创建控制器 #

 php  创建postcontroller

       php artisan make:controller PostController 

  
# 5.创建表 #

 创建数据表 使用migration  记录表语句

     1.php artisan make:migration create_posts_table （意思是：创建为posts的表）

     2.修改database/migrateions/新创建的表

     3.php artisan migrate （通过php 执行 上述生成的文件，创建表名为 posts）


# 6.创建对应数据表模型文件 # 

驼峰命名 默认情况下对应的表模型 都是去掉s的驼峰命名

 默认是在app目录下

     php  artisan make:model Post
 
tinker 一种命令行，可以用于测试创建的Post模型是否成功

     php artisan tinker


 进入 命令行

      1.new 对象 $post  = new \App\Post();

     2.对象赋值 $post->title = '这是ceshi titiel222';

     3.对象增加和修改 $post->save();


通过主键取回一个模型

     $flight = App\Flight::find(1);
  
取回符合查询限制的第一个模型.

     $flight = App\Flight::where('active', 1)->first(); 

 get()    返回对象数组
 
 型示例上调用 delete 方法来删除模型：

     $flight = App\Flight::find(1);


    $flight->delete();
 
 
路径：config\app.php

laravel 默认时区是UTC 修改 中国时区  Asia/Shanghai'

 
 

    ps:测试数据快速填充  database\factories\ModelFactory.php 中  
    数据填充插件 https://github.com/fzaninotto/Faker
    1.新增一个Post的填充数据
    2.控制台命令： php artisan tinker 进入 tinker控制台
    命令：factory(App\Post::class,20)->make();   //是在命令行中直接显示20 个测试数据 
    命令：factory(App\Post::class,20)->create();   //是直接创建20 个测试数据 `
 
