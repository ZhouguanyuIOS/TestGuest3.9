<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/4/26
 * Time: 下午2:12
 */
//定义常量用来授权调用includes里面的文件
define('IN_TG',true);
//每个页面却有一个不相同的css，那么可以定义一个常量来证明本页
define('SCRIPT','face');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';


?>
<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>多用户留言系统--头像选择</title>
    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/opener.js"></script>
</head>

<body>
<div id="face">
    <h3>选择头像</h3>
    <dl>
        <?php foreach (range(1,64)as $number) { ?>
            <dd><img src='face/m<?php echo $number?>.gif'alt="face/m<?php echo $number?>.gif" title='头像<?php echo $number?>'"></dd>
        <?php }?>
    </dl>
</div>
</body>

</html>


