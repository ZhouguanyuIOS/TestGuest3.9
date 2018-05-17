<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/5/11
 * Time: 下午4:54
 */
session_start();
define('IN_TG',true);
//每个页面却有一个不相同的css，那么可以定义一个常量来证明本页
define('SCRIPT','member');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断一下是否正常登录
if(isset($_COOKIE['username'])){
    //获取数据
    $_row=_fetch_array($_conn,"SELECT tg_username,tg_sex,tg_face,tg_email,tg_url,tg_reg_time,tg_qq,tg_level FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
    if ($_row){
        $_html=array();
        $_html['username']=_html($_row['tg_username']);
        $_html['sex']=_html($_row['tg_sex']);
        $_html['face']=_html($_row['tg_face']);
        $_html['email']=$_row['tg_email'];
        $_html['url']=_html($_row['tg_url']);
        $_html['qq']=_html($_row['tg_qq']);
        $_html['reg_time']=_html($_row['tg_reg_time']);
        switch ($_row['tg_level']){
            case 0;
            $_html['level']='普通会员';
            break;
            case 1;
            $_html['level']='管理员';
            break;
            default:
                $_html['level']='出错';
        }
        $_html=_html($_html);
    }else{
        _alert_back('此用户不存在');
    }
}else{
   _alert_back('非法登录');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>多用户留言系统--个人中心</title>
    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
</head>
<body>
<!--调用头部-->
<?php
include ROOT_PATH.'includes/header.inc.php';
?>
<div id="member">
    <?php require ROOT_PATH.'includes/member.inc.php'?>
    <div id="member_main">
        <h2>会员管理中心</h2>
        <dl>
            <dd>用 户名：<?php echo $_html['username']?></dd>
            <dd> 性 别：<?php echo $_html['sex']?></dd>
            <dd> 头 像：<?php echo $_html['face']?></dd>
            <dd>电子邮件：<?php echo $_html['email']?></dd>
            <dd> 主 页：<?php echo $_html['url']?></dd>
            <dd> Q  Q：<?php echo $_html['qq']?></dd>
            <dd>注册时间：<?php echo $_html['reg_time']?></dd>
            <dd> 身 份：<?php echo $_html['level']?></dd>
        </dl>
    </div>

</div>
<!--调用尾部-->
<?php
include ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
