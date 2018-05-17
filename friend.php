<?php /**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/5/15
 * Time: 下午3:15
 */
session_start();//将验证码打开
define('IN_TG',true);
//每个页面却有一个不相同的css，那么可以定义一个常量来证明本页
define('SCRIPT','friend');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登录
if (!isset($_COOKIE['username'])){
    _alert_close('请先登录');
}
//添加好友
if($_GET['action']=='add'){
    //判断验证码
    _check_code($_POST['code'],$_SESSION['codeOne']);
    if (!!$_rows=_fetch_array($_conn,"SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {
        _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
        require ROOT_PATH.'includes/check.func.php';
        $_clean=array();
        $_clean['touser']=$_POST['touser'];
        $_clean['fromuser']=$_COOKIE['username'];
        $_clean['content']=_check_content($_POST['content']);
        $_clean=_mysql_string($_clean);
        //不能添加自己
        if ($_clean['touser']==$_clean['fromuser']){
            mysqli_close($_conn);
            _alert_close('请不要添加自己');
        }
        //数据库验证好友是否已经添加
        if (!!$_rows=_fetch_array($_conn,"SELECT 
                                                      tg_id
                                                FROM  
                                                      tg_friend
                                                WHERE 
                                                      (tg_touser='{$_clean['touser']}' AND tg_fromuser='{$_clean['formuser']}')
                                                  OR 
                                                      (tg_touser='{$_clean['formuser']}' AND tg_fromuser='{$_clean['touser']}')
                                                LIMIT 
                                                      1
        ")){
            _alert_close('你们已经是好友！或者是未验证的好友！无需添加！');

        }else{
            //添加好友信息
            _query_result($_conn,"INSERT  INTO tg_friend(
                                                      tg_touser,
                                                      tg_fromuser,
                                                      tg_content,
                                                      tg_date  
                                                    ) 
                                              VALUES (
                                                      '{$_clean['touser']}',
                                                      '{$_clean['fromuser']}',
                                                      '{$_clean['content']}',
                                                      NOW()
                                              )");

            if (_affected_rows($_conn)==1){
                mysqli_close($_conn);
                _alert_close('好友添加成功!请等待验证');

            }else{
                mysqli_close($_conn);
                _alert_back('好友添加失败！');
            }
        }

    }
}
//获取数据
if (isset($_GET['id'])){
    if (!!$_rows=_fetch_array($_conn,"SELECT tg_username FROM tg_user WHERE tg_id={$_GET['id']}")){
        $_html=array();
        $_html['touser']=$_rows['tg_username'];

        $_html=_html($_html);
    }else{
        _alert_close('不存在此用户');
    }
}else{
    _alert_close('非法操作!');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>多用户留言系统--添加好友</title>
    <?php require ROOT_PATH.'includes/title.inc.php';?>
    <script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/message.js"></script>
</head>
<body>
<div id="friend">
    <h3>添加好友</h3>
    <form method="post" action="?action=add">
        <input type="hidden" name="touser" value="<?php echo $_html['touser'];?>"/>
        <dl>
            <dd><input type="text" class="text" readonly="readonly" value="<?php echo 'TO:'. $_html['touser']; ?>"/></dd>
            <dd><textarea rows="" cols="" name="content">我非常想和你交朋友啊</textarea><dd>
            <dd>验证码：</label><input type="text" name="code" class="text yzm"> <img src="code.php" id="codeOne">     <input type="submit" value="添加好友" class="button"/></dd>
        </dl>
    </form>
</div>
</body>
</html>