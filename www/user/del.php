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