<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>添加用户</title>
</head>
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
    };
}

?>
<form action="add.php" method="post">
    <label for="nametext">用户名：&nbsp;</label><input type="text" name="name" id="nametext"><br>
    <label for="passwordtext">密&nbsp;&nbsp;&nbsp;&nbsp;码：</label><input type="password" name="password" id="passwordtext" ><br>
    <label for="emailtext">邮&nbsp;&nbsp;&nbsp;&nbsp;箱：</label><input type="text" name="email" id="emailtext"><br>
    <input type="submit" name="btn" value="提交">
    <a href="http://localhost/user/index.php"><input type="button" value="返回"></a>
</form>
</body>
</html>

