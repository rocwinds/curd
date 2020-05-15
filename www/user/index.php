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
<div class='btn'><a href='add.php'>添加用户</a></div>

<?php
//echo输出html代码,先做个基本表框架和一个假按钮,添加样式
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
    $id=$result_arr['id'];
    $name=$result_arr['name'];
	$password=$result_arr['password'];
	$email=$result_arr['email'];
	
	//每一轮都会把遍历出来的数据连带表格标签一起echo打印出来,表格最后一列加入修改和删除的a链接
    echo "<tr><td>$id</td><td>$name</td><td>$password</td><td>$email</td><td><a href='updata.php?id=$id'>修改</a> <a href='del.php?id=$id'>删除</a></td></tr>";
}
echo "</table>"; ?>

<form action="retrieve.php" method="post">
根据用户名查询：
<input type="text" name="keywordname" id="search">
<input type="submit" name="btn" value="提交">
</form>
</body>
</html>