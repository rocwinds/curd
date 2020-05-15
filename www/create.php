<?php
//引入在config.php定义的myssql地址\账号\密码\数据库名字
require_once 'config.php';

//连接mysql
$conn=new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PW);
//检测是否连接上了mysql
if($conn->connect_error){
    //确认连接失败就输出一条消息并退出这段php脚本
    die("连接失败:".$conn->connect_error);
}

//只要没有提示就证明成功进入了mysql
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
            )";
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