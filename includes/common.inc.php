<?php
if (!defined('IN_TG')) {
    exit('Access Defined!');
}
//设置字符集编码
header('Content-Type:text/html;charset=utf-8');
//转换成硬路径，速度更快
define('ROOT_PATH',substr(dirname(__FILE__),0,-8));
 //创建一个自动转义状态的常量

define('GPC',get_magic_quotes_gpc());
//拒绝php低版本
if (PHP_VERSION<'4.1.0'){
    echo 'PHP版本太低';
}
//引入核心函数库
require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';
//执行耗时
define('START_TIME',_runtime());//设置全局变量或者超级全局变量
//数据库连接
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PWD','root');
define('DB_NAME','testguest');
//执行数据库连接
_connect();//连接mysql，并选择数据表,设置字符集
//短信提醒
$_message=_fetch_array($_conn,"SELECT COUNT(tg_id) AS count FROM tg_message WHERE tg_state=0");
if (empty($_message['count'])){
    $GLOBALS['message']='<strong class="noread"><a href="member_message.php">(0)</a></strong>';
}else{
    $GLOBALS['message']='<strong class="read"><a href="member_message.php">('.$_message['count'].')</a></strong>';
}
?>