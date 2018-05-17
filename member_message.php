<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/5/15
 * Time: 下午6:38
 */
define('IN_TG',true);
//每个页面却有一个不相同的css，那么可以定义一个常量来证明本页
define('SCRIPT','member_message');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登录
if (!isset($_COOKIE['username'])){
    _alert_back('请先登录');
}
//批量删除短信
if ($_GET['action']=='delete' && isset($_POST['ids']))
{
   print_r($_POST['ids']);
   //implode 把数组用逗号拼接成字符串
    $_clean=array();
    $_clean['ids']=_mysql_string(implode(',',$_POST['ids']));

    //    //敏感操作，验证唯一标识符
    if (!!$_rows2=_fetch_array($_conn,"SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {
        _uniqid($_rows2['tg_uniqid'], $_COOKIE['uniqid']);
        _query_result($_conn,"DELETE FROM tg_message WHERE tg_id IN ({$_clean['ids']})");
        if (_affected_rows($_conn)){
            mysqli_close($_conn);
            _location('短信删除成功','member_message.php');

        }else{
            mysqli_close($_conn);
            _alert_back('短信删除失败');
        }
    }else{
        _alert_back('非法操作');
    }
}


//分页模块
_page(4,$_conn,"SELECT tg_id FROM tg_message");
//从数据库提取数据,获取结果集
$_result=_query_result($_conn,"SELECT tg_id,tg_touser,tg_fromuser,tg_date,tg_content,tg_state FROM tg_message ORDER BY tg_date asc LIMIT $_pagenum,$_pagesize");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>多用户留言系统--个人中心</title>
    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
    <SCRIPT type="text/javascript" src="js/member_message.js"></SCRIPT>
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
        <h2>短信管理中心</h2>
        <form method="post" action="?action=delete">
        <table cellspacing="1">
            <tr><th>发信人</th><th>短信内容</th><txh>时间</txh><th>状态</th><th>操作</th></tr>
            <?php
            while (!!$_rows= mysqli_fetch_array($_result)) {
                $_html=array();
                $_html['id']=$_rows['tg_id'];
                $_html['fromuser']=$_rows['tg_fromuser'];
                $_html['content']=$_rows['tg_content'];
                $_html['date']=$_rows['tg_date'];
                $_html=_html($_html);
                if (empty($_rows['tg_state'])){
                    $_html['state']='<image src="images/read.gif" alt="未读" title="未读"/>';
                    $_html['content_html']='<strong>'._title($_html['content']).'</strong>';

                }else{
                    $_html['state']='<image src="images/noread.gif" alt="已读" title="已读"/>';
                    $_html['content_html']=_title($_html['content']);
                }
                ?>
            <tr><td><?php echo $_html['fromuser'];?></td><td><a  href='member_message_detail.php?id=<?php echo $_html['id'];?>' title="<?php echo $_html['content'];?>"><?php echo $_html['content_html'];?></a></td><td><?php echo $_html['date'];?></td><td><?php echo $_html['state'];?></td><td><input type="checkbox" name="ids[]" value="<?php echo $_html['id']; ?>"/></td></tr>
            <?php
            }
            //销毁结果集
            _free_result($_result);
            ?>
            <tr><td colspan="5"><label for="all">全选<input type="checkbox" name="chkall" id="all"></label> <input type="submit" value="批量删除"/></td></tr>
        </table>
        </form>
        <?php
        _paging(2);
        ?>
    </div>
</div>
<!--调用尾部-->
<?php
include ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>