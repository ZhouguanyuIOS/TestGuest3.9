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
define('SCRIPT','member_modify');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//获取资料（获取数据前修改）
if ($_GET['action']=='modify'){
    //判断验证码
    _check_code($_POST['code'],$_SESSION['codeOne']);
    if (!!$_rows=_fetch_array($_conn,"SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")){
        //为了防止cookies伪造，还要比对一下uniqid
        _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
        //引入验证文件
        include  ROOT_PATH.'includes/check.func.php';
        //用一个空数组，用来存放提交过来的合法数据
        $_clean=array();
        $_clean['password']=_check_modify_password($_POST['password'],6);
        $_clean['email']=_check_email($_POST['email'],6,40);
        $_clean['sex']=_check_sex($_POST['sex']);
        $_clean['face']=_check_face($_POST['face']);
        $_clean['qq']=_check_qq($_POST['qq']);
        $_clean['url']=_check_url($_POST['url'],40);
        //修改资料
        if (empty($_clean['password'])){
            _query_result($_conn,"UPDATE tg_user SET
                                                          tg_sex='{$_clean['sex']}',
                                                          tg_face='{$_clean['face']}',
                                                          tg_qq='{$_clean['qq']}',
                                                          tg_email='{$_clean['email']}',
                                                          tg_url='{$_clean['url']}'
                                                      WHERE 
                                                          tg_username='{$_COOKIE['username']}'
                                                          ");
        }else{
            _query_result($_conn,"UPDATE tg_user SET
                                                          tg_password='{$_clean['password']}',
                                                          tg_sex='{$_clean['sex']}',
                                                          tg_qq='{$_clean['qq']}',
                                                          tg_face='{$_clean['face']}',
                                                          tg_email='{$_clean['email']}',
                                                          tg_url='{$_clean['url']}'
                                                      WHERE 
                                                          tg_username='{$_COOKIE['username']}'
                                                          ");
        }
    }

    //判断是否修改成功
    if (_affected_rows($_conn)==1){
        mysqli_close($_conn);
        _location('恭喜你，修改成功','member.php');

    }else{
        mysqli_close($_conn);
        _location('很遗憾，没有任何数据被修改','member_modify.php');

    }

}

//判断一下是否正常登录
if(isset($_COOKIE['username'])){
    //获取数据
    $_row=_fetch_array($_conn,"SELECT tg_username,tg_sex,tg_face,tg_email,tg_url,tg_qq FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
    if ($_row){
        $_html=array();
        $_html['username']=_html($_row['tg_username']);
        $_html['sex']=_html($_row['tg_sex']);
        $_html['face']=_html($_row['tg_face']);
        $_html['email']=$_row['tg_email'];
        $_html['url']=_html($_row['tg_url']);
        $_html['qq']=_html($_row['tg_qq']);
        $_html=_html($_html);
        //性别选择
        if ($_html['sex']=='男'){
            $_html['sex_html']='<input type="radio" name="sex" value="男" checked="checked"/>男<input type="radio" name="sex" value="女" />女';
        }elseif ($_html['sex']=='女'){
            $_html['sex_html']='<input type="radio" name="sex" value="男" />男<input type="radio" name="sex" checked="checked" value="女" />女';

        }
        //头像选择
        $_html['face_html']= '<select name="face">';
        foreach (range(1,64)as $number) {
            $_html['face_html'].='<option value="face/m'.$number.'.git">face/m'.$number.'.git</option>';
        }
        $_html['face_html'].='</select>';
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
    <script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/member_modify.js"></script>

</head>
<body>
<!--调用头部-->
<?php
include ROOT_PATH.'includes/header.inc.php';
?>

<div id="member">
    <?php require ROOT_PATH.'includes/member.inc.php'?>
    <div id="member_main">
        <form name="modify" method="post" action="member_modify.php?action=modify">
        <h2>修改资料</h2>
        <dl>
            <dd>用 户名：<?php echo $_html['username']?></dd>
            <dd> 密 码：<input type="password" class="text" name="password"/>(留空则不修改)</dd>
            <dd> 性 别：<?php echo $_html['sex_html']?></dd>
            <dd> 头 像：<?php echo $_html['face_html']?></dd>
            <dd>电子邮件：<input type="text" class="text" name="email" value="<?php echo $_html['email']?>"/></dd>
            <dd> 主 页：<input type="text" class="text" name="url" value="<?php echo $_html['url']?>"/></dd>
            <dd> Q  Q：<input type="text"   class="text" name="qq" value="<?php echo $_html['qq']?>"/></dd>
            <dd>验证码：</label><input type="text" name="code" class="text yzm"> <img src="code.php" id="codeOne"></dd>
            <dd><input type="submit" class="submit" value="修改资料"/></dd>
        </dl>
        </form>
    </div>
</div>
<!--调用尾部-->
<?php
include ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
