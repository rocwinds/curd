## 1首先需要准备好模拟环境和创建数据库
主要为phpstudy这个集成环境，打开之后启动apache和mysql两个服务，先尝试手动用命令行`mysql -hlocalhost -uroot -p`登录mysql确认是否正常运行中（登录时遇到报错就检查-h、-u、-p是否输入有问题）

确认mysql运行正常就开始写php自动连接代码，接下来会创建两个文件config.php、create.php和connect.php，create.php用作登录mysql并自动创建一个指定名字的数据库；connect.php则是登录mysql同时专门连接指定名字数据库；
#### config.php 
```php
config.php里直接把数据库登录必用的账号密码地址定义为了常量，之后只需要写变量名就行，创建之后使用方法是require_once 'config.php';（必须引用php文件要在同层级否则要写相对路径）

打开config.php，写入php代码
<?php
define('MYSQL_HOST','localhost');//数据库地址
define('MYSQL_USER','root');//数据库账号名
define('MYSQL_PW','root123');//数据库密码
?>

仔细对比`mysql -hlocalhost -uroot -p`填的正是常量定义的这些，所以不要填错
```

#### create.php
```php
打开create.php，这里php代码目的是自动连接mysql并创建一个指定名字的数据库

//引入在config.php定义的myssql地址\账号\密码\数据库名字
require_once 'config.php';

//连接mysql(遇到1045报错先检查地址、用户名、密码大小写是否写错)
$conn=new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PW);
//检测是否连接上了mysql
if($conn->connect_error){
    //确认连接失败就输出一条消息并退出这段php脚本
    die("连接失败:".$conn->connect_error);
}

//只要没报错就证明成功进入了mysql
//但此时没有数据库，就开始新建一个数据库
//准备sql的创建库命令,赋值给$sql(库名为mydb)
$sql="create database mydb";
//作if判断时就会调用mysqli的query方法结合$sql创建数据库
if($conn->query($sql)===true){
    $databasename="mydb";
    //再调用一次连接上刚创建的数据库,并指定为数据库
    $conn = new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PW,$databasename);
    //给变量$sql赋值sql命令,命令内容为创建user表,表内有字段id、name、password、email（各自有字段属性），当然到这里只是提前准备sql语句并没有创建
    $sql="create table user (
			id int(4) unsigned auto_increment primary key,
			name varchar(20) not null,
			password varchar(11) not null,
            email varchar(11) not null
            )";//注意id被设置为自动递增添加auto_increment和主键primary key,不能带符号unsigned 
            //通过if条件执行一次sql命令操作,然后判断是否成功,不论成功失败都会echo出提示并exit退出这段ifelse代码
			if ($conn->query($sql) === true) {
                echo "完成表创建,Table MyGuests created successfully";
                exit;//退出脚本
			} else {
                //   .$conn->error;是php自己的提示语
                echo "创建数据表错误: " . $conn->error;
                exit;
            }
            //
            //断开与变量$conn代表的数据库的连接
            $conn->close(); 
}else{
    //这里是创建数据库失败的提示
    echo "数据库创建失败：".$conn->error;
} 
$conn->close();
?>
```


分为准备代码和实际执行
创建config.php,里面放入常量,记录创建一个数据库应该有的数据库地址\账户\密码\数据库名字,以后用到这些数据就引用
接着再创建connect.php,放入代码,用mysqli作连接和创建数据库(create.php)

完成了代码创建接下来运行phpstudy开启apache和mysql,然后在study里创建一个网站,打开网站根目录把config.php和connect.php先丢到里面,打开网站地址在后缀名加上connect.php打开就能自动运行php脚本了(create.php主要是创建数据库)(例子http://www.test.com/connect.php)

运行完成会看到提示(在写代码是放好的提示),可以命令行登录数据库然后运行一下代码
 是按照之前config里的内容来填的
(记得一定一定一定要在config里填对地址,也就是-h的部分,密码用密文输入避免错误,root123)
    
show databases;查看mysql里的所有数据库;
use mydatabases;进入刚创建的mydatabases数据库;
show tables;查看myphp中的表（这里只有一个刚才建的user表）
desc user;查看user表的详情。
```php
打开config.php
<?php

//数据库名字不能当成常量!
```
打印一般内容

echo 打印的部分(变量)
exit;

打印数组
	echo"<pre>";
	print_r(这里写上要打印的部分); 
	echo"</pre>";
	exit;

```php
<?php
打开create.php

```
__________
## 2 加入增删改查的准备工作
现在要求用php单独请求连接数据库,以及制作好curd页面(先实现结构,增删改查逻辑之后一个个做)

#### 需求是用php代码直接连接到mysql里的mydb数据库里
```php
在网站的根目录\user\connect.php,用php代码连接到mysql里的mydb数据库里
<?php
//单独做一个连接sql中的指定数据库的代码,没有close方法,其实create.php已经有了,照着做即可

//先不像之前引入config.php了,还没搞清楚路径问题
//注意填入的信息是否正确符合之前创建的数据的信息,否则会弹出1045等错误提示
$servername="localhost";
$username="root";
$password="root123";
$databasename="mydb";

//连接mysql中的mydb数据库库,
$conne=new mysqli($servername,$username,$password,$databasename);
//检测是否连接上了mysql
if($conne->connect_error){
    //确认连接失败就输出一条消息并退出这段php脚本
    die("连接失败:".$conne->connect_error);
}
//想要输出文本总得用echo,php不能直接执行js方法会报错,只能通过输出字符串自动转化成js的方式执行,js标签里php全局变量能正常使用
echo "<script>alert('已经成功连接上$databasename')</script>";

?>
```

#### 先实现一个能加入增删改三个功能的网页结构出来
```php
打开网站根目录\user\index.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>curd</title>
	<style type="text/css">
	table.gridtable {
		font-size:22px;
		color:#333333;
		border-width: 1px;
		border-color: #666666;
		border-collapse: collapse;
		width: 70%;
	}
	table.gridtable th {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #666666;
		background-color: #dedede;
		text-align: center;
	}
	table.gridtable td {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #666666;
		background-color: #ffffff;
		text-align: center;
	}
	.btn{
		width:120px;
		height:40px;
		border:2px blue none;
		background-color: grey;
		margin:10px 0px;
		display: flex;
		justify-content: ceneter;
		align-items: center;
		border-radius: 5px;
	}
	.btn a{
		margin:0 auto;
		text-decoration: none;
		color:#ffffff;	
	}
	</style>
	
</head>
<body>
<?php
//echo输出html代码,先做个基本表框架和一个假按钮,添加样式
echo "<div Class='btn'><a href='add.php'>添加用户</a></div>";
echo "<table class='gridtable'> ";
//先echo打印出table的表头部分,表身部分交给循环,echo打印</table>一定要写在循环代码的后面,不然表格就不是一体的了
echo "
	<tr>
		<th>用户id</th><th>用户名</th><th>密码</th><th>邮箱</th><th>操作</th>
	</tr>
	<tr>
    <td>静态数据Text 1A</td><td>Text 1B</td><td>Text 1C</td><td>Text 1D</td><td>Text 1E</td>
	</tr>";


//include引用同目录下的connect.php,连接上数据库mydb,并且变量也通用了,运行结束之后$conn代表数据库mydb
include('connect.php');
//加入sql命令:从mydb里查询选择全部带user字样的的表,赋值给$sql等待执行
$sql="select * from user";
//选择数据库mydb,调用query方法运行刚定义的sql命令(选择表user),此时已经运行了一次查询选择操作然后赋值给变量$result
$result = $conn->query($sql);
//用mysqli_num_rows方法,统计数据库user表里有几行,给循环做准备
$dataCount=mysqli_num_rows($result);

//接下来打印表身部分,数据库mydb里已经输入两条数据作为动态添加表格数据的演示;
//循环添加
for($i=0;$i<$dataCount;$i++){
	//一行一行遍历出数据,用fetch_assoc方法遍历user表
	$result_arr=mysqli_fetch_assoc($result);
	//自动循环添加的id号,不能用,因为数据库里没有$id=$i+1;
    $id=$result_arr['id'];
    $name=$result_arr['name'];
	$password=$result_arr['password'];
	$email=$result_arr['email'];
	
	//每一轮都会把遍历出来的数据连带表格标签一起echo打印出来,表格最后一列加入修改和删除的a链接
    echo "<tr><td>$id</td><td>$name</td><td>$password</td><td>$email</td><td><a href='update.php?id=$id'>修改</a> <a href='del.php?id=$id'>删除</a></td></tr>";
}
echo "</table>"; ?>
</body>
</html>
```
__________________________________
## 3 现在加入增加数据功能(add.php)
现在页面里有三个链接,一个是添加数据add.php\修改数据edituser.php\删除数据deleteuser.php
记得修改和删除会把id当做传参a链接里带上'?id='来对应表格里的被点击字段(在循环时已经对应添加了)
```html
新建一个user/add.php.然后加入html标签
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>添加用户</title>
</head>
<body>
<form action="add.php" method="post">
    <!-- label for绑定input 的id,表单提交按钮绑定input的name!!(同一个form下) -->
    <label for="nametext">用户名：&nbsp;</label><input type="text" name="name" id="nametext"><br>
    <label for="passwordtext">密&nbsp;&nbsp;&nbsp;&nbsp;码：</label><input type="password" name="password" id="passwordtext" ><br>
    <label for="emailtext">邮&nbsp;&nbsp;&nbsp;&nbsp;箱：</label><input type="text" name="email" id="emailtext"><br>
    <input type="submit" name="btn" value="提交">
</form>
</body>
</html>
```

```php
现在给html标签加上php脚本逻辑(思路很简单,收集表单提交的数据,然后判断是否为空,不为空就执行sql命令新增到数据库里)
在body部分加入
<body>
<?php
//先链接上数据库
include("connect.php");
//$_POST里的btn的值真不为空就执行代码(使用预定义变量$_POST俩收集通过method=post的传递的值)(empty方法检查是否为空)
if(!empty($_POST['btn'])){
    //收集_POST里的对应字段数据,然后用insrt into命令把三个字段名和字段值添加到表user里
    $name=$_POST['name'];
	$password=$_POST['password'];
    $email=$_POST['email'];
    $sql="insert into user(name,password,email) values('$name','$password','$email')";
    //依旧是用if判断时顺带执行了insert into的sql命令,if判断确认了把表单输入的值添加到了user表就会执行header方法
    if($conn->query($sql) === true){
        //header会跳转回到之前本网站里的index.php(exit方法防止后续代码继续运行)
        header("Location:index.php");
        exit;
    }else{
        //$conn->query($sql)没成功时
        echo "<script>alert('数据添加失败')</script>";
    }
}
?>
//省略from表单部分
</body>

到此为止从网页输入数据并将其新增到数据库的操作页面就完成了(虽然还没有对输入数据进行判断非空非错),经历了页面放置表单之后可以继续添加其他功能了,下一个是删除功能
```
__________
## 4 现在加入删除数据功能(del.php) 
不需要网页结构所以直接写功能
```php
<!DOCTYPE HTML>
<html>
<head>
	<title>删除用户</title>
</head>
<body>
<!-- 思路是提取到对应id,然后根据符合id值条件在user表里执行sql删除语句 -->
<?php 
//引入连接数据库脚本
include("connect.php");
//根据网址参数(用_get发送的所以也会包括在$_GET)
$id=$_GET['id'];
//准备SQL命令 delete from,找到符合条件值的那条数据删除
$sql="delete from user where id='$id'";
//用query在$conn也就是mydb数据库执行$sql也就是删除命令
mysqli_query($conn,$sql);
//删除完自动跳回首页
header("Location:index.php");
?>
</body>
</html>
```
__________
## 5 加入更新数据功能
```php
思路类似

<!DOCTYPE HTML>
<html>

<head>
    <title>更新用户</title>
</head>


<body>
<?php
//依旧是一上来就链接数据库
include("connect.php");
//因为循环时已经添加了?id=作为参数，并用get传递到了这个页面，因此可以用_$GET里提取到这个值，做为sql选取的条件
//从index点击过来的必然带id（就靠这个id来选取数据库里对应数据）
if(!empty($_GET['id'])){
    //接收传递过来的id，用了get方式传递就在$_GET里找
    $id=$_GET['id'];
    //准备sql命令，从user选取全部id为$id的数据
    $sql="select * from user where id='$id'";
    //mydb数据库调用query执行sql命令，全部选了出来赋值给$result
    $result=$conn->query($sql);
    //如果没有就不会选到，所以$result用num_rows方法就是false的，如果为true说明至少选择到了一条以上符合条件数据
	if($result->num_rows>0){
    //那么费劲就是为了获取到一个符合条件的数组，然后在页面中显示出来，一切的前提是有对应数据的id
	$row=$result->fetch_assoc();
    }
}	
//只要被btn点击了就必然会传递值，—_POST到这一步实际已经接收到表单里传入的值了
if(!empty($_POST['btn'])){
    //从_POST里选取用post方法传递的值
	$id=$_POST['id'];
	$name=$_POST['name'];
	$password=$_POST['password'];
	$email=$_POST['email'];
    echo $name;
    //sql命令，更新user表中的name、password、email字段的值
    $sql="update user set name='$name',password='$password',email='$email' where id='$id'";
    //mydb里的调用query成功了就会执行跳转回去
	if($conn->query($sql) === true){
		header("Location:index.php");
		exit;//保证执行重定向后不在执行后面代码
	}else{
		echo "更新数据失败";
	}
}

?>  
    <!-- 加个表单，往本网页用post方法传数据（配合php的$_POST接收） -->
    <form action="updata.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
        <input type="password" name="password" value="<?php echo $row['password']; ?>"><br>
        <input type="text" name="email" value="<?php echo $row['email']; ?>"><br>
        <input type="submit" name="btn" value="提交">
        <a href="http://localhost/user/index.php"><input type="button" value="返回"></a>
    </form>
</body>
</html>
```
______________
## 最后加入查询功能
```php 
最简单的搜索显示，几乎和index是一样的
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查询</title>
    <style type="text/css">
	.table {
		font-size:22px;
		color:#333333;
		border-width: 1px;
		border-color: #666666;
		border-collapse: collapse;
		width: 70%;
	}
	.table th {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #666666;
		background-color: #dedede;
		text-align: center;
	}
	.table td {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #666666;
		background-color: #ffffff;
		text-align: center;
    }
    </style>
</head>
<body>

<?php
//依旧是一上来就链接数据库
include("connect.php");

//提取别的页面用post传递过来的关键字，做个非空判断
if(!empty($_POST['keywordname'])){
	//加个按钮和表头
	echo "<a href='http://localhost/user/index.php'><input type='button' value='返回'></a>";
	echo "<table class='table'> ";
	echo "<tr><th>用户id</th><th>用户名</th><th>密码</th><th>邮箱</th></tr>";
	//提取关键字
	$keywordname = $_POST['keywordname'];
	//准备sql命令，根据关键字在user表的name字段里模糊搜索
	$sql = "select * from user where name like '%$keywordname%'";
	//执行sql命令并赋给$result
	$result=$conn->query($sql);
	//计算符合条件有几列，作为列表循环次数
	$num_rows=mysqli_num_rows($result);
	for($i=0;$i<$num_rows;$i++){
		//跟着循环来一次一次遍历出数据,用fetch_assoc方法集中所有数据结果提取为数组
		$row=mysqli_fetch_assoc($result);
		$id=$row['id'];
		$name=$row['name'];
		$password=$row['password'];
		$email=$row['email'];
		//还在循环里，所以会跟着循环一次次渲染不同的数据
		echo "<tr><td>$row[id]</td><td>$row[name]</td><td>$row[password]</td><td>$row[email]</td></tr>";
	}
}else{
    echo "<script>alert('请输入搜索关键词');</script>";
}
?>
</body>
</html> 
```