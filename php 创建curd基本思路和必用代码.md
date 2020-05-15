#### 0.常用php代码
```php
//引用
    include('config.php');//include引用同目录下的config.php这个文件（别的目录要写路径）
    require_once 'config.php';//require引用(不会重复引用)同目录下的config.php这个文件

//打印变量的值或类型
    echo 填变量名
    exit;

//打印数组
    echo"<pre>";
    print_r(填变量名); 
    echo"</pre>";
    exit;
```
#### 1.php登录mysql
```php
//准备地址账号密码
$servername="localhost";//服务器地址
$username="root";//填写自己数据库用户名
$password="root_123";//连接数据库密码

//登录mysql
$conn=new mysqli($servername,$username,$password);

//连接后测试一下是否正常，没通过测试就会报错
if($conn->connect_error){
    //连接失败就输出一条消息并退出这段php脚本
    die("连接失败:".$conn->connect_error);
}
```

#### 2.php连接mysql里的某个数据库（其实就是1加了一个数据库名字，数据库得存在才能连接上）
```php
$servername="localhost";//服务器地址
$username="root";//填写自己数据库用户名
$password="root_123";//连接数据库密码
$databasename="mydb";//自定义数据库名字
//登录mysql里并连接里面的mydb
$conn = new mysqli($servername,$username,$password,$databasename)

//测试是否成功连接mydb
if($conn->connect_error){
    //连接失败就输出一条消息并退出这段php脚本
    die("连接失败:".$conn->connect_error);
}
```

#### 3.php登录mysql后调用query方法创建一个数据库并连接（库名字为mydb）
```php
$servername="localhost";//服务器地址
$username="root";//填写自己数据库用户名
$password="root_123";//连接数据库密码
$databasename="mydb";//自定义数据库名字

//登录mysql（不判断了）
$conn = new mysqli($servername,$username,$password)

//提前准备创建数据库的sql命令（未执行）
$sql="create database mydb";

//mysql调用query方法执行$sql，也就是创建数据库mydb
$conn->query($sql);

//测试创建是否成功（if条件可以直接触发调用query方法）
if($conn->query($sql)===true){
    echo "已成功创建表$databasename";

    //再登录mysql里并连接里面的mydb
    $conn = new mysqli($servername,$username,$password,$databasename)
    //测试mydb是否连接上了，连接成功无提示
    if($conn->connect_error){
    //连接失败输出消息并退出脚本
    die("连接失败:".$conn->connect_error);
    }
}

```

#### 4.php连接mysql里的mydb数据库，创建user表并添入字段
```php
$servername="localhost";//服务器地址
$username="root";//填写自己数据库用户名
$password="root_123";//连接数据库密码
$databasename="mydb";//自定义数据库名字

//登录mysql里并连接里面的mydb（数据库里要有mydb这个库才会连接成功）
$conn = new mysqli($servername,$username,$password,$databasename);
//准备sql命令，创建user表，并添加字段id、name、password、email和各自的字段属性，需要注意id 的属性auto_increment会自增
$sql="create table user (
			id int(4) unsigned auto_increment primary key,
			name varchar(20) not null,
			password varchar(11) not null,
            email varchar(11) not null
            )";
//判断时会执行一次$conn->query($sql)
if ($conn->query($sql) === true) {
    echo "已经成功在表 $databasename 里创建了字段";
    exit;//退出脚本
} else {
    //   .$conn->error;是php自己的提示语
    echo "创建数据表错误: " . $conn->error;
    exit;
}
```