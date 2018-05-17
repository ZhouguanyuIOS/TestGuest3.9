<?php
if (!defined('IN_TG')) {
    exit('Access Definend!');
}
/**
 * _connect 开启数据库连接并设置字符集
 */
function _connect(){
    global $_conn;//表示全局变量，意图是将此变量在函数外部也能访问
    if (!$_conn=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME)){
        exit("数据库连接错误: " . mysqli_connect_error());
    }
    if (!mysqli_query($_conn,'SET NAMES UTF8')){
        exit("字符集选择错误: " . mysqli_connect_error());
    }
}
/**
 * _query_result //返回数据库查询的结果
 * @param $_link
 * @param $_sql
 * @return bool|mysqli_result
 */
function _query_result($_link,$_sql){
    if (!$result=mysqli_query($_link,$_sql)){
        echo 'SQL执行失败'.mysqli_error($_link);
        exit;
    }
    return $result;

}
/**_affected_rows 返回受影响的记录数
 * @param $_link
 * @return int
 */
function _affected_rows($_link){
   return mysqli_affected_rows($_link);
}

/**
 * _free_result 销毁结果集
 * @param $_result
 */
function _free_result($_result){
    mysqli_free_result($_result);
}

/**
 * _fetch_array //返回数据库查询的结果
 * @param $_link
 * @param $_sql
 * @return array|null
 */
function _fetch_array($_link,$_sql){
   $_result= mysqli_fetch_array(_query_result($_link,$_sql),MYSQLI_ASSOC);
    return $_result;
}
/**
 * //判断并提示冲突
 * @param $_link
 * @param $_sql
 * @param $_info
 */
function _is_repeat($_link,$_sql,$_info){
    $_result= _fetch_array($_link,$_sql);
    if ($_result){
        _alert_back($_info);
    }

}


