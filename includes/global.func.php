<?php
/**
 * _runtime是用来获取执行耗时的
 * @access public 表示函数对外公开
 * @return float 表示出来的是一个浮点型数字
 */
function _runtime(){
    $_mtime=explode(' ',microtime());
  return  $_start_time=$_mtime[0]+$_mtime[1];
}
/**
 * _alert_back
 * @access public 表示函数对外公开
 *  @access string $_info
 * @return 弹框
 */
function _alert_back($_info='非法操作'){
   echo "<script type='text/javascript'>alert('".$_info."');history.back();</script>";
   exit;
}

/**
 * _alert_close 关闭当前页面
 * @param $_info
 */
function _alert_close($_info){
    echo "<script type='text/javascript'>alert('".$_info."');window.close();</script>";
    exit;
}

/**
 * _location 跳转到页面
 * @param $_info
 * @param $_url
 */
function _location($_info,$_url) {

    if (!empty($_info)) {
        echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
        exit;
    } else {
        header('Location:index.php');
    }
}

/**
 * _page 判断分页参数
 * @param $_size  每页显示的数目
 * @param $_link  数据库开启
 * @param $_sql   查询sql语句
 */
function _page($_size,$_link,$_sql){
    global $_page,$_pagesize,$_pagenum,$_pageabsolute,$_num;
    if (isset($_GET['page'])){

        $_page=$_GET['page'];
        //判断值不能是空，不能小于0，不为整数则去取整数
        if (empty($_page)||$_page<0||!is_numeric($_page)){
            $_page=1;
        }else{
            $_page=intval($_GET['page']);
        }
    }else{
        $_page=1;
    }
    $_pagesize=$_size;
    $_num=  mysqli_num_rows(_query_result($_link,$_sql));
//首先得到所有数据的结果集
    if ($_num==0){
        $_pageabsolute=1;
    }else{
        $_pageabsolute=ceil($_num/$_pagesize);
    }
    if ($_page>$_pageabsolute ){
        $_page=$_pageabsolute;
    }
    $_pagenum=($_page-1)*$_pagesize;
}

/**
 * _paging 分页函数
 * @param $_type 1 数字 2文本
 * @param $_page 当前页数
 * @param $_pageabsolute  总页数
 * @param $_num  总条数
 * @return 返回分页
 */
function _paging($_type){
    global $_page,$_pageabsolute,$_num;

    if ($_type==1){
        echo '<div id="page_num">';
        echo "\n";
        echo '<ul>';
        echo "\n";
        for ($i=0;$i<$_pageabsolute;$i++) {
            if ($_page == $i + 1) {
                echo '<Li><a href="' . SCRIPT . '.php?page=' . ($i + 1) . '" class="selected">' . ($i + 1) . '</a></Li>';
                echo "\n";
            } else {
                echo '<Li><a href="' . SCRIPT . '.php?page=' . ($i + 1) . '">' . ($i + 1) . '</a></Li>';
                echo "\n";
            }
        }
            echo '</ul>';
            echo "\n";
            echo '</div>';
            echo "\n";

    }else{
        echo '<div id="page_text">';
        echo "\n";
        echo '<ul>';
        echo "\n";
            echo '<li>'.$_page.'/'.$_pageabsolute.'页|</li>';
            echo "\n";
            echo'<li>共有<strong>'.$_num.'</strong>个</li>';
            echo "\n";
            if ($_page==1){
                echo '<li>首页|</li>';
                echo "\n";
                echo '<li>上一页|</li>';
                echo "\n";
            }else{
                echo '<li><a href="'.SCRIPT.'.php?page=1">首页|</a></li>';
                echo "\n";
                echo "\t\t";
                echo '<li><a href="'.SCRIPT.'.php?page='.($_page-1).'">上一页|</a></li>';
                echo "\n";
            }
            if ($_page==$_pageabsolute){
                echo '<li>下一页|</li>';
                echo "\n";
                echo '<li>尾页|</li>';
                echo "\n";
            }else{
                echo '<li><a href="'.SCRIPT.'.php?page='.($_page+1).'">下一页|</a></li>';
                echo "\n";
                echo "\t\t";
                echo '<li><a href="'.SCRIPT.'.php?page='.$_pageabsolute.'">尾页|</a></li>';
            }
            echo '</ul>';
        echo '</div>';
    }
}
function _session_destroy(){
    session_destroy();
}
/**
 * _unsetcookies 删除cookie
 */
function _unsetcookies(){
    setcookie('username','',time()-1);
    setcookie('uniqid','',time()-1);
    _session_destroy();
    _location('退出成功','index.php');
}
//防止登录之后又能登录
/**
 * _login_state 登录状态的判断
 */
function _login_state(){
   if (isset($_COOKIE['username'])){
       _alert_back('登录状态无法进行本操作');
   }
}

/**
 * _title 标题截取函数
 * @param $_string
 * @return string
 */
function _title($_string){
    if (mb_strlen($_string,'utf-8')>14){
        $_string=mb_substr($_string,1,14,'utf-8').'....';
    }
    return $_string;
}
/**
 * _html 过滤HTML特殊字符,过滤数组和字符串
 * @param $_string
 * @return array|string
 */
function _html( $_string){
    if (is_array($_string)){
      foreach ($_string as $_key=>$_value)  {
          //采用的递归
          //$_string[$_key]=htmlspecialchars($_value);
          $_string[$_key]=_html($_value);
      }
    }else{
        $_string=htmlspecialchars($_string);
    }
    return $_string;
}

/**
 * _uniqid 判断唯一标识符是否异常
 * @param $_mysql_uniqid
 * @param $_cookies_uniqid
 */
function _uniqid($_mysql_uniqid,$_cookies_uniqid){
    if ($_mysql_uniqid!=$_cookies_uniqid){
        _alert_back('唯一标识符异常');
    }
}
/**
 * _sha1_uniqid
 * @param $_string
 * @return string
 */
function _sha1_uniqid($_string){

    return _mysql_string(sha1(uniqid(rand(),true)));
}
/**
 * _mysql_string  转义字符串的方法
 * @access public 表示函数对外公开
 * @param $_string
 * @return string
 */
function _mysql_string($_string){

    if (!GPC){
        if (is_array($_string)){
            foreach ($_string as $_key=>$_value)  {
                //采用的递归
                //$_string[$_key]=htmlspecialchars($_value);
                $_string[$_key]=_mysql_string($_value);
            }
        }else{
            $_string=addslashes($_string);
        }
    }
    return $_string;

}
function _check_code($_first_code,$_end_code){
    //验证码的用途，防止恶意注册和跨站攻击
    //验证验证码的正确性
    if ($_first_code != $_end_code){
        _alert_back('验证码不正确');
    }
}
/**
 * _code是绘制验证码图片的函数
 * @access int $_width  验证码的长度
 * @access int $_height 验证码的高度
 * @access int $_rnd_code 验证码的位数
 * @access int $_flag  拜师验证码是否需要边框
 * @access public 表示函数对外公开
 * @return void 这个函数执行后产生一个验证码
 */
function _code($_width=75,$_height=25,$_rnd_code=4,$_flag=false){
//    $rnd_code=4;
    $_nsmg='';
    for ($i=0;$i<$_rnd_code;$i++){
        $_nsmg.=dechex(mt_rand(0,15));
    }
//保存在session里面，更持久
    $_SESSION['codeOne']=$_nsmg;
//长和高
//    $_width=75;
//    $_height=25;
//创建一张图像
    $_imag=imagecreatetruecolor($_width,$_height);
    $_white=imagecolorallocate($_imag,255,255,255);
//填充背景
    imagefill($_imag,0,0,$_white);
//    $_flag=false;
    if ($_flag){
        //黑色边框
        $_black=imagecolorallocate($_imag,0,0,0);
        imagerectangle($_imag,0,0,$_width-1,$_height-1,$_black);
    }
//随机画出6个线条
    for ($i=0;$i<6;$i++){
        $_rnd_color=imagecolorallocate($_imag,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
        imageline($_imag,mt_rand(0,$_width),mt_rand(0,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_rnd_color);
    }
//随机雪花
    for ($i=0;$i<50;$i++) {
        imagestring($_imag,1,mt_rand(1,$_width),mt_rand(1,$_height),'*',$_rnd_color);
    }
//输出验证码
    for ($i=0;$i<strlen($_SESSION['codeOne']);$i++) {
        $_rnd_str_color = imagecolorallocate($_imag, mt_rand(0, 100), mt_rand(0, 150), mt_rand(0, 200));
        imagestring($_imag, 5, $i * $_width / $_rnd_code + mt_rand(1, 10), mt_rand(1, $_height / 2), $_SESSION['codeOne'][$i], $_rnd_str_color);
    }
//输出图像
    header('Content-Type:image/png');
    imagepng($_imag);
//销毁
    imagedestroy($_imag);
}
?>
