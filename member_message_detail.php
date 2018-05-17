<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/5/16
 * Time: 上午11:40
 */
define('IN_TG',true);
//每个页面却有一个不相同的css，那么可以定义一个常量来证明本页
define('SCRIPT','member_message_detail');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登录
if (!isset($_COOKIE['username'])){
    _alert_back('请先登录');
}
//删除模块
if ($_GET['action']=='delete'&& isset($_GET['id'])){
    $_sql="SELECT tg_fromuser,tg_date,tg_content FROM tg_message WHERE tg_id='{$_GET['id']}' LIMIT 1";
    if(!!$_rows=_fetch_array($_conn,$_sql)){
        //敏感操作，验证唯一标识符
        if (!!$_rows2=_fetch_array($_conn,"SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {
            _uniqid($_rows2['tg_uniqid'], $_COOKIE['uniqid']);
            //单删除
            _query_result($_conn,"DELETE FROM tg_message WHERE tg_id='{$_GET['id']}' LIMIT 1");
            //判断是否删除成功
            if (_affected_rows($_conn)==1){
                mysqli_close($_conn);
                _location('短信删除成功','member_message.php');

            }else{
                mysqli_close($_conn);
                _alert_back('短信删除失败');
            }

        }else{
            _alert_back('非法操作');
        }
    }else{
        _alert_back('此短信不存在');
    }
}
if (isset($_GET['id'])){
    //获取数据结果集
    $_sql="SELECT tg_fromuser,tg_date,tg_content,tg_state FROM tg_message WHERE tg_id='{$_GET['id']}'LIMIT 1";

    if(!!$_rows=_fetch_array($_conn,$_sql)){
        if (empty($_rows['tg_state'])){
            _query_result($_conn,"UPDATE tg_message SET tg_state=1 WHERE tg_id='{$_GET['id']}'LIMIT 1 ");
            if (!_affected_rows($_conn)){
                _alert_back('异常');
            }
        }
       $_html=array();
        $_html['id']=$_GET['id'];

        $_html['fromuser']=$_rows['tg_fromuser'];
       $_html['date']=$_rows['tg_date'];
       $_html['content']=$_rows['tg_content'];
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
    <script type="text/javascript" src="js/member_message_detail.js"></script>
</head>
<body>
<!--调用头部-->
<?php
include ROOT_PATH.'includes/header.inc.php';
?>
<div id="member">
    <?php
    require ROOT_PATH.'includes/member.inc.php';
    ?>
    <div id="member_main">
        <h2>短信详情</h2>
        <dl>
            <dd>发信人：<?php echo $_html['fromuser'];?></dd>
            <dd>内容：<strong><?php echo $_html['content'];?></strong></dd>
            <dd>发信时间：<?php echo $_html['date'];?></dd>
            <dd class="button"><input type="button" value="返回列表"  id="return";"/><input type="button" value="删除短信"  id="delete" name="<?php echo $_html['id']?>";"/></dd>
        </dl>
    </div>
</div>
<!--调用尾部-->
<?php
include ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
