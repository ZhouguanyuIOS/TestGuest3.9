<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/4/25
 * Time: 下午5:46
 */
if (!defined('IN_TG')){
    exit('Access Definend!');
}
//关闭数据库
mysqli_close($_conn);
?>
<div id="footer">
    <p>本程序执行耗时为: <?php echo  round((_runtime() - START_TIME),4)?>秒</p>
    <p>版权所有 翻版必究</p>
    <p>本程序由<span>瓢城Web俱乐部</span>提供 源代码可以任意修改或发布 (c) yc60.com</p>
</div>

