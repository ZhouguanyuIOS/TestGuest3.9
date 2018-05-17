<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/4/26
 * Time: 下午6:24
 */
session_start();//开启
//定义常量用来授权调用includes里面的文件
define('IN_TG',true);
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//运行验证码函数
_code(75,25,4,flase);
?>