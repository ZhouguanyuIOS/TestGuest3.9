window.onload=function () {
   code();
   //登录验证
    var fm=document.getElementsByTagName('form')[0];

    fm.onsubmit=function () {
        //能用客户端验证的尽量用客户端验证
        //js对于php是选学，并不强制掌握
        if (fm.username.value.length < 2 || fm.username.value.length > 20) {
            alert('用户名不能小于2位或者不能大于20位');
            fm.username.value = '';//清空
            fm.username.focus();//将焦点以至表单字段
            return false;
        }
        //密码判断
        if (fm.password.value.length<6 ) {
            alert('密码不能小于6位');
            fm.password.value = '';//清空
            fm.password.focus();//将焦点以至表单字段
            return false;
        }
        if (fm.password.value !=fm.notpassword.value) {
            alert('密码和密码确认必须一致');
            fm.notpassword.value = '';//清空
            fm.notpassword.focus();//将焦点以至表单字段
            return false;
        }
        //验证码必须是四位的判断
        if (fm.code.value.length != 4){
            alert('验证码必须是四位');
            fm.code.value = '';//清空
            fm.code.focus();//将焦点以至表单字段
            return false;
        }
        return true;
    }

}