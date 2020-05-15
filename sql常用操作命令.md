登录
`mysql -h地址 -u账号 -p` 回车输入密码后登录数据库
 

登录之后
`show databases;`  查看mysql里的所有数据库;

`use 数据库名字;`   进入某个数据库

`show tables;`   查看该数据库下所有表

`desc 表名;`   查看某个表里的字段和值等内容

`select * from 表名`   选择某个表里的所有内容
`select *或者字段名 from 表名 where 字段名 = 值;`  选择某个表里指定字段或全部符合条件‘字段名 = 值’的内容
 
