<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/5/11
 * Time: 下午5:15
 */
if (!defined('IN_TG')){
    exit('Access Definend!');
}
?>
<div id="member_sidebar">
    <h2>中心导航</h2>
    <dl>
        <dt>账号管理</dt>
        <dd><a href="member.php"><?php echo $_COOKIE['username']?>个人信息</a></dd>
        <dd><a href="member_modify.php">修改资料</a></dd>
    </dl>
    <dl>
        <dt>其他管理</dt>
        <dd><a href="member_message.php">短信查询</a></dd>
        <dd><a href="###">好友设置</a></dd>
        <dd><a href="###">查询花朵</a></dd>
        <dd><a href="###">个人相册</a></dd>
    </dl>
</div>
