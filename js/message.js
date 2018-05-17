window.onload = function () {
    code();
    //登录验证
    var fm=document.getElementsByTagName('form')[0];

    fm.onsubmit=function () {
        //验证码必须是四位的判断
        if (fm.code.value.length != 4){
            alert('验证码必须是四位');
            fm.code.value = '';//清空
            fm.code.focus();//将焦点以至表单字段
            return false;
        }

        if (fm.content.value.length < 10 || fm.content.value.length > 200) {
            alert('信息内容不能小于10位或者不能大于200位');
            fm.username.value = '';//清空
            fm.username.focus();//将焦点以至表单字段
            return false;
        }
        return true;
    }
}