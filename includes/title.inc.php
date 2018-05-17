<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/4/26
 * Time: 下午1:59
 */
if (!defined('IN_TG')){
    exit('Access Definend!');
}
//防止非HTML页面调用
if (!defined('SCRIPT')){
    exit('Script Error!');
}
?>
<link rel="shortcut icon"  href="favicon.ico"/>
<link rel="stylesheet" type="text/css" href="styles/1/basic.css"/>
<link rel="stylesheet" type="text/css" href="styles/1/<?php echo SCRIPT?>.css"/>

