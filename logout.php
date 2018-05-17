<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/5/9
 * Time: 下午7:00
 */
define('IN_TG',true);
//每个页面却有一个不相同的css，那么可以定义一个常量来证明本页

define('SCRIPT','login');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//退出
_unsetcookies();
?>