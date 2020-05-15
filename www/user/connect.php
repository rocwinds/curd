<?php
//注意填入的信息是否正确符合之前创建的数据的信息,否则会弹出1045等错误提示
$servername="localhost";
$username="root";
$password="root123";
$databasename="mydb";

//连接mysql中的mydb数据库库,
$conn=new mysqli($servername,$username,$password,$databasename);
//检测是否连接上了mysql
if($conn->connect_error){
    //确认连接失败就输出一条消息并退出这段php脚本
    die("连接失败:".$conn->connect_error);
}
//想要输出文本总得用echo,php不能直接执行js方法会报错,只能通过输出字符串自动转化成js的方式执行,js标签里php全局变量能正常使用
//echo "<script>alert('已经成功连接上$databasename')</script>";

?>