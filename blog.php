<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/5/9
 * Time: 下午7:18
 */
define('IN_TG',true);
//每个页面却有一个不相同的css，那么可以定义一个常量来证明本页
define('SCRIPT','blog');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//分页模块

_page(15,$_conn,"SELECT tg_id FROM tg_user");
//从数据库提取数据,获取结果集
$_result=_query_result($_conn,"SELECT tg_id,tg_username,tg_face,tg_sex FROM tg_user ORDER BY tg_reg_time asc LIMIT $_pagenum,$_pagesize")or die(mysqli_error($_conn));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>多用户留言系统--博友</title>
    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/blog.js"></script>
</head>

<body>
<!--调用头部-->
<?php
include ROOT_PATH.'includes/header.inc.php';
?>
<div id="blog">
    <h2>博友列表</h2>
    <?php
    while (!!$_rows= mysqli_fetch_array($_result)){
        $_html=array();
        $_html['id']=$_rows['tg_id'];
        $_html['username']=$_rows['tg_username'];
        $_html['face']=$_rows['tg_face'];
        $_html['sex']=$_rows['tg_sex'];
        ?>
    <dl>
        <dd class="user"><?php echo  $_html['username']?>(<?php echo  $_html['sex']?>)</dd>
        <dt><img src="<?php echo  $_html['face']?>" alt="andy"/></dt>
        <dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['id'];?>">发消息</a></dd>
        <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['id'];?>">加为好友</a></dd>
        <dd class="guest">写留言</dd>
        <dd class="flower">给他送花</dd>
    </dl>
    <?php }
        _paging(1);
        _paging(2);
        //销毁结果集
        _free_result($_result);
    ?>
</div>
<!--调用尾部-->
<?php
include ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
