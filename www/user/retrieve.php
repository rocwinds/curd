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