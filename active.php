<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/5/8
 * Time: 下午5:41
 */
define('IN_TG',true);
//每个页面却有一个不相同的css，那么可以定义一个常量来证明本页

define('SCRIPT','active');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//开始激活处理
if (!isset($_GET['active'])){
    _alert_back('非法操作');
}
if (isset($_GET['action']) && isset($_GET['active'])&& $_GET['action']=='ok'){
    echo '开始激活';
    $_active=_mysql_string($_GET['active']);
    if (_fetch_array($_conn,"SELECT tg_active FROM tg_user WHERE tg_active='$_active' LIMIT 1")){
       //如果存在就设置为空
        _query_result($_conn,"UPDATE tg_user SET tg_active='' WHERE tg_active='$_active' LIMIT 1");
        if (_affected_rows($_conn)==1){
            mysqli_close($_conn);
            _location('账户激活成功','login.php');
        }else{
            mysqli_close($_conn);
            _location('账户激活失败','register.php');
        }
    }else{
         _alert_back('非法操作!');
    }
}
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>多用户留言系统--激活</title>
    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
</head>
<body>
<!--调用头部-->
<?php
include ROOT_PATH.'includes/header.inc.php';
?>
<div id="active">
    <h2>激活账户</h2>
     <p>本页面是为了模拟您的邮件的功能，点击以下超级链接激活您的账户</p>
    <p><a href="active.php?action=ok&amp;active=<?php echo $_GET['active']?>"><?php echo'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']?>?action=ok&amp;active=<?php echo $_GET['active']?></a></p>

</div>


<!--调用尾部-->
<?php
include ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>