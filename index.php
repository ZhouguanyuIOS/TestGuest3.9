<?php
//定义常量用来授权调用includes里面的文件
define('IN_TG',true);
//每个页面却有一个不相同的css，那么可以定义一个常量来证明本页
define('SCRIPT','index');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>安迪Web俱乐部多用户留言系统</title>
    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
</head>
<body>
<!--调用头部-->
<?php
include ROOT_PATH.'includes/header.inc.php';
?>
<div id="list">
    <h2>帖子列表</h2>
</div>
<div id="user">
    <h2>新进会员</h2>
</div>
<div id="pics">
    <h2>最新图片</h2>
</div>
<!--调用尾部-->
<?php
include ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>