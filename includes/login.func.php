<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/5/9
 * Time: 下午1:31
 */

if (!defined('IN_TG')) {
    exit('Access Definend!');
}
if (!function_exists('_alert_back')){
    exit('_alert_back函数不存在，请检查!');
}
if (!function_exists('_mysql_string')){
    exit('_mysql_string函数不存在，请检查!');
}
/**
 * _check_username 表示检测并过滤用户名
 * @access public 表示函数对外公开
 * @param string $_string   受污染的用户名
 * @param  int $_min_num 最小位数
 * @param int  $_max_num 最大为数
 * @return string  过滤后的用户名
 */
function _check_username($_string,$_min_num,$_max_num){
    //去掉两边的空格
    $_string=trim($_string);
    //长度小于2或大于20都不行
    if (mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num){
        _alert_back('用户名长度不能小于'.$_min_num.'位，不能大于'.$_max_num.'位');
    }
    //限制敏感字符
    $_char_pattern='/[<>\'\"\ \  ]/';
    if (preg_match($_char_pattern,$_string)){
        _alert_back('用户名不得包含敏感字符');
    }
    //限制敏感用户名
    $_mg[0]='zgy';
    $_mg[1]='abc';
    $_mg[2]='def';
    //高速用户哪些不能注册
    $_mg_string='';
    foreach ($_mg as $value) {
        $_mg_string.=$value.'\n';
    }
    //这里采用的绝对匹配
    if (in_array($_string,$_mg))
    {
        _alert_back($_mg_string.'敏感用户名不得注册');
    }
    //将用户名转义输入
    // return $_string;
    return _mysql_string($_string);
}
/**
 * _check_password 判断验证密码
 * @param  string $_first_pass
 * @param $_min_num
 * @return string 返回一个加密后的密码
 */
function _check_password($_first_pass,$_min_num){
    //判断密码
    if (strlen($_first_pass)<$_min_num){
        _alert_back('密码不得小于'.$_min_num.'位');
    }
    return _mysql_string(sha1($_first_pass));
}

/**
 * _check_time 检查保留时间
 * @param $_string
 * @return string
 */
function _check_time($_string){
    $_time=array(0,1,2,3);
    if (!in_array($_string,$_time)){
        _alert_back('保留方式出错!');
    }
    return _mysql_string($_string);
}

/**
 * _setcookies 生成登录cookies
 * @param $_username
 * @param $_uniqid
 */
function _setcookies($_username,$_uniqid,$_time) {
    switch ($_time) {
        case '0':  //浏览器进程
            setcookie('username',$_username);
            setcookie('uniqid',$_uniqid);
            break;
        case '1':  //一天
            setcookie('username',$_username,time()+86400);
            setcookie('uniqid',$_uniqid,time()+86400);
            break;
        case '2':  //一周
            setcookie('username',$_username,time()+604800);
            setcookie('uniqid',$_uniqid,time()+604800);
            break;
        case '3':  //一月
            setcookie('username',$_username,time()+2592000);
            setcookie('uniqid',$_uniqid,time()+2592000);
            break;
    }
}
?>