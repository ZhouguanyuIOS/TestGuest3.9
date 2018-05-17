<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/5/2
 * Time: 下午4:00
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
    $_char_pattern='/[<>\'\"\]/';
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
 * @param $_end_pss
 * @param $_min_num
 * @return string 返回一个加密后的密码
 */
function _check_password($_first_pass,$_end_pss,$_min_num){
    //判断密码
    if (strlen($_first_pass)<$_min_num){
        _alert_back('密码不得小于'.$_min_num.'位');
    }
    //密码和密码确认必须一致
    if ($_first_pass != $_end_pss){
        _alert_back('密码和密码确认不一致');
    }
    //密码加密

    return _mysql_string(sha1($_first_pass));
}

/**
 * _check_modify_password 判断修改密码
 * @param $_srting
 * @param $_min_num
 */
function _check_modify_password($_string,$_min_num){
    //判断密码
    if (!empty($_string)){
        if (strlen($_string)<$_min_num){
            _alert_back('密码不得小于'.$_min_num.'位');
        }
    }else{
        return null;
    }
    return _mysql_string(sha1($_string));
}

/**
 * _check_question 返回密码提示
 * @access public 表示函数对外公开
 * @param string $_string
 * @param int  $_min_num
 * @param  int $_max_num
 * @return string
 */
function _check_question($_string,$_min_num,$_max_num){
    $_string=trim($_string);
    //长度小于2或大于20都不行
    if (mb_strlen($_string,'utf-8')<$_min_num ||mb_strlen($_string,'utf-8')>$_max_num){
        _alert_back('密码提示不能小于'.$_min_num.'位，不能大于'.$_max_num.'位');
    }
    //返回密码提示

    return _mysql_string($_string);

}

/**
 * _check_answer 返回密码
 * @param string $ques
 * @param string $_answ
 * @param int $_min_num
 * @param int $_max_num
 */
function _check_answer($_ques,$_answ,$_min_num,$_max_num){
    $_string=trim($_answ);
    //长度小于2或大于20都不行
    if (mb_strlen($_answ,'utf-8')<$_min_num ||mb_strlen($_answ,'utf-8')>$_max_num){
        _alert_back('密码回答不能小于'.$_min_num.'位，不能大于'.$_max_num.'位');
    }
    //密码提示与回答不能一致
    if ($_ques == $_answ){
        _alert_back('密码提示与回答不得一致');
    }
    //加密返回
    return _mysql_string(sha1($_answ));
}
/**
 * _check_sex  性别
 * @access public 表示函数对外公开
 * @param  string $_string
 * @return  string
 */
function _check_sex($_string){
    return _mysql_string($_string);
}
/**
 * _check_face 头像
 * @access public 表示函数对外公开
 * @param $_string
 * @return string
 */
function _check_face($_string){
    return _mysql_string($_string);
}
/**
 * _check_email 返回一个格式正确的邮件
 * @access public 表示函数对外公开
 * @param string $_email
 * @return string  $_email
 */
function _check_email($_email,$_min_num,$_max_num)
{
    if (empty($_email)){
       return null;
    }else{
        //正则语法
        //正则字符串，参考bnbns@163.com
        //[a-zA-Z0-9_]=>\w
        if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$_email)){
            _alert_back('邮件格式不正确');
        }

    }
    if (strlen($_email)<$_min_num || strlen($_email)>$_max_num){
        _alert_back('邮件长度不合法');

    }
    return _mysql_string($_email);
}
/**
 * _check_qq 验证QQ格式
 * @access public 表示函数对外公开
 * @param $_qqStr
 * @return null
 */
function _check_qq($_qqStr){
    if (empty($_qqStr)){
        return null;
    }else{
        if (!preg_match('/^[1-9]{1}[0-9]{4,9}$/',$_qqStr)){
            _alert_back('QQ号码不正确');
        }

    }
    if (strlen($_qqStr)<5||strlen($_qqStr)>10){
        _alert_back('QQ账号不合法');
    }
    return _mysql_string($_qqStr);
}

/**
 * @param $_url 网址验证
 * @access public 表示函数对外公开
 * @return null
 */
function _check_url($_url,$_max_num){
    if (empty($_url)||($_url == 'http://')){
        return null;
    }else{
        //http://www.yc60.com
        if (!preg_match('/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/',$_url)){
            _alert_back('网址不正确');
        }
    }
    if ( strlen($_url)>$_max_num){
        _alert_back('网址太长');

    }
    return _mysql_string($_url);
}

/**
 * _check_uniqid 判断唯一标识符是否一样
 * @param $_first_uniqid
 * @param $_end_uniqid
 * @return string
 */
function _check_uniqid($_first_uniqid,$_end_uniqid){

    if (strlen($_first_uniqid)!=40||($_first_uniqid != $_end_uniqid)){
        _alert_back('唯一标识符异常');
    }
    return _mysql_string($_first_uniqid);
}
/**
 * _check_content 验证短信内容大小
 * @param $_string
 */
function _check_content($_string){
    if (mb_strlen($_string,'utf-8')<10 ||mb_strlen($_string,'utf-8')>200){
        _alert_back('短信字数不能小于10位，大于200位');
    }
    return $_string;
}
?>