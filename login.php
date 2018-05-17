<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/5/8
 * Time: 下午6:46
 */
session_start();//将验证码打开
define('IN_TG',true);
//每个页面却有一个不相同的css，那么可以定义一个常量来证明本页
define('SCRIPT','login');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//登录状态
_login_state();
//开始处理登录状态
if ($_GET['action']=='login'){
    //判断验证码
    _check_code($_POST['code'],$_SESSION['codeOne']);
    //引入验证文件
    include  ROOT_PATH.'includes/login.func.php';
    //创建一个接受数组
    $_clean=array();
    $_clear['username'] =_check_username($_POST['username'],2,20);
    $_clear['password'] =_check_password($_POST['password'],6);
    //exit($_clear['password']);
    $_clear['time'] =_check_time($_POST['time']);
    //数据库验证
    if (!!$_rows=_fetch_array($_conn,"SELECT tg_username,tg_uniqid FROM tg_user WHERE tg_username='{$_clear['username']}' AND tg_password='{$_clear['password']}' AND tg_active='' LIMIT 1")){
        //登录成功后记录登录信息
        _query_result($_conn,"UPDATE tg_user SET tg_last_time=NOW(),tg_last_ip='{$_SERVER["REMOTE_ADDR"]}',tg_login_count=tg_login_count+1 WHERE tg_username='{$_clear['username']}'");
        _setcookies($_rows['tg_username'],$_rows['tg_uniqid'],$_clear['time']);

       _session_destroy();

        mysqli_close($_conn);
        _location('登录成功','member.php');
    }else{
        //关闭函数库
        _session_destroy();
        mysqli_close($_conn);
        _location('用户名，密码不正确，或者该账户未被激活','login.php');
    };
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>多用户留言系统--登录</title>
    <?php require ROOT_PATH.'includes/title.inc.php';?>
    <script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/login.js"></script>
</head>
<body>
<!--调用头部-->
<?php
include ROOT_PATH.'includes/header.inc.php';
?>
<div id="login">
    <h2>登录</h2>
    <form method="post" name="login" action="login.php?action=login" >
        <input type="hidden" name="uniqid" value="<?php echo $_uniqid?>">
        <dl>
            <dt>    </dt>
            <dd><label>用 户 名：</label><input type="text" name="username" class="text">（*必填，至少两位）</dd>
            <dd><label>密码：</label><input type="password" name="password" class="text">（*必填，至少六位）</dd>
            <dd><label>确认密码：</label><input type="password" name="notpassword" class="text">（*必填，同上）</dd>
            <dd><label>保留：</label><input type="radio" name="time" value="0" checked="checked" class="radio"/> 不保留 <input type="radio" name="time" value="1" class="radio"/> 一天 <input type="radio" name="time" value="2" class="radio"/> 一周 <input type="radio" name="time" value="3" class="radio"/> 一月</dd>
            <dd><label>验证码：</label><input type="text" name="code" class="text code"> <img src="code.php" id="codeOne"></dd>
            <dd><input type="submit" value="登录" class="button"/><input type="button" value="注册" id="location" class="button"/></dd>
        </dl>
    </form>
</div>
<!--调用尾部-->
<?php
include ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


