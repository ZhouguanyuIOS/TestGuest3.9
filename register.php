<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/4/26
 * Time: 上午10:27
 */
session_start();//将验证码打开
//定义常量用来授权调用includes里面的文件
define('IN_TG',true);
//每个页面却有一个不相同的css，那么可以定义一个常量来证明本页
define('SCRIPT','register');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//登录状态
_login_state();
//判断是否提交了
if ($_GET['action']=='register'){

    //判断验证码
    _check_code($_POST['code'],$_SESSION['codeOne']);



    //引入验证文件
    include  ROOT_PATH.'includes/check.func.php';
    //用一个空数组，用来存放提交过来的合法数据
    $_clear=array();
    //头尾的空格必须去掉
    //这个存放数据库的唯一标识符还有第二个用途,就是登陆的cookies验证
    $_clear['uniqid']=_check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);
    //active也是唯一标识符，用来刚注册的用户进行激活处理，方可登陆
    $_clear['active']=_sha1_uniqid();
    
    $_clear['username'] = _check_username($_POST['username'],2,20);
    $_clear['password'] =_check_password($_POST['password'],$_POST['notpassword'],6);
    $_clear['question']=_check_question($_POST['question'],2,20);
    $_clear['answer']=_check_answer($_POST['answer'],$_POST['question'],2,20);
    $_clear['email']=_check_email($_POST['email'],6,40);
    $_clear['sex']=_check_sex($_POST['sex']);
    $_clear['face']=_check_face($_POST['face']);
    $_clear['qq']=_check_qq($_POST['qq']);
    $_clear['url']=_check_url($_POST['url'],40);
  //  print_r($_clear);
   //新增用户之前判断用户名是否重复
    $_sql="SELECT tg_username FROM tg_user WHERE tg_username='{$_clear['username']}' LIMIT 1";

   _is_repeat($_conn,$_sql,'对不起，此用户已被注册');


    //在双引号里面直接放变量是可以的，但如果是数组比如$_clear['username'，就必须加上{}
   $_result=_query_result($_conn,"INSERT INTO tg_user(
                                                   tg_uniqid,
                                                   tg_active,
                                                   tg_username,
                                                   tg_password,
                                                   tg_question,
                                                   tg_answer,
                                                   tg_sex,
                                                   tg_face,
                                                   tg_email,
                                                   tg_qq,
                                                   tg_url,
                                                   tg_reg_time,
                                                   tg_last_time,
                                                   tg_last_ip
                                                  )
                                            VALUES (
                                            '{$_clear['uniqid']}',
                                            '{$_clear['active']}',
                                            '{$_clear['username']}',
                                            '{$_clear['password']}',
                                            '{$_clear['question']}',
                                            '{$_clear['answer']}',
                                            '{$_clear['sex']}',
                                            '{$_clear['face']}',
                                            '{$_clear['email']}',
                                            '{$_clear['qq']}',
                                            '{$_clear['url']}',
                                            NOW(),
                                            NOW(),
                                            '{$_SERVER["REMOTE_ADDR"]}'
                                            )");

    if (_affected_rows($_conn)==1){
       mysqli_close($_conn);
        _location('恭喜你，注册成功','active.php?active='.$_clear['active']);

    }else{
        mysqli_close($_conn);
        _location('注册失败，请重试','register.php');

    }
}else{
    //判断唯一标识符,每台电脑都不会产生相同的标识符
    $_SESSION['uniqid']=$_uniqid=_sha1_uniqid();
}
?>
<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>多用户留言系统--注册</title>
    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/register.js"></script>
    <script type="text/javascript" src="js/code.js"></script>

</head>
<body>
<!--调用头部-->
<?php
include ROOT_PATH.'includes/header.inc.php';
?>

<div id="register">
    <h2>会员注册</h2>
    <form method="post" name="resgister" action="register.php?action=register" >
        <input type="hidden" name="uniqid" value="<?php echo $_uniqid?>">
        <dl>
            <dt>请认真填写一下内容</dt>
            <dd><label>用 户 名：</label><input type="text" name="username" class="text">（*必填，至少两位）</dd>
            <dd><label>密码：</label><input type="password" name="password" class="text">（*必填，至少六位）</dd>
            <dd><label>确认密码：</label><input type="password" name="notpassword" class="text">（*必填，同上）</dd>
            <dd><label>密码提示：</label><input type="text" name="question" class="text">（*必填，至少两位）</dd>
            <dd><label>密码回答：</label><input type="text" name="answer" class="text">（*必填，至少两位）</dd>
            <dd><label>性别：</label><input type="radio" name="sex" value="男" checked="checked"> 男 <input type="radio" name="sex" value="女" > 女</dd>
            <dd class="face" ><input type="hidden" name="face" value="face/m1.gif"/><img src="face/m1.gif" alt="头像选择"n id="faceimg"/></dd>
            <dd><label>电子邮件：</label><input type="text" name="email" class="text"></dd>
            <dd><label> QQ：</label><input type="text" name="qq" class="text"></dd>
            <dd><label>主页地址：</label><input type="text" name="url" class="text" value="http://"></dd>
            <dd><label>验证码：</label><input type="text" name="code" class="text yzm"> <img src="code.php" id="codeOne"></dd>
            <dd><input type="submit" class="submit" value="注册"/></dd>
        </dl>
    </form>
</div>
<!--调用尾部-->
<?php
include ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


