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