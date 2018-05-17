/*等待网页加载完毕在执行,通过onlick函数把图像传给父页面
* ***/
window.onload=function () {

    var faceimg=document.getElementById('faceimg');
    faceimg.onclick=function () {
        window.open('face.php','face','width=400,height=400,top=0,left=0,scrollbars=1');
    };

    code();
    // var code=document.getElementById('codeOne');
    // code.onclick=function () {
    //     this.src='code.php?tm='+Math.random();
    // };
    //

    //表单验证如下
    var fm=document.getElementsByTagName('form')[0];

    fm.onsubmit=function () {
        //能用客户端验证的尽量用客户端验证
        //js对于php是选学，并不强制掌握
        if (fm.username.value.length<2 ||fm.username.value.length>20){
            alert('用户名不能小于2位或者不能大于20位');
            fm.username.value='';//清空
            fm.username.focus();//将焦点以至表单字段
            return false;
        }
        //用户名判断
        if(/[<>\'\"\ \ ]/.test(fm.username.value)){
            alert('用户名不能包含非法字段');
            fm.username.value='';//清空
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
        //密码提示与回答
        if (fm.question.value.length<2||fm.question.value.length>20 ) {
            alert('密码提示不能小于2位或者大于20位');
            fm.question.value = '';//清空
            fm.question.focus();//将焦点以至表单字段
            return false;
        }
        if (fm.answer.value.length<2||fm.answer.value.length>20 ) {
            alert('密码回答不能小于2位或者大于20位');
            fm.answer.value = '';//清空
            fm.answer.focus();//将焦点以至表单字段
            return false;
        }
        if (fm.question.value ==fm.answer.value) {
            alert('密码提示和密码回答不能相等');
            fm.answer.value = '';//清空
            fm.answer.focus();//将焦点以至表单字段
            return false;
        }
        //邮箱验证
        if (fm.email.value!=''){
            if (!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)){
                alert('邮件格式不正确');
                fm.email.value = '';//清空
                fm.email.focus();//将焦点以至表单字段
                return false;
            }
        }
        //qq号码验证
        if (fm.qq.value!=''){
            if (!/^[1-9]{1}[0-9]{4,9}$/.test(fm.qq.value)){
                alert('QQ号码不正确');
                fm.qq.value = '';//清空
                fm.qq.focus();//将焦点以至表单字段
                return false;
            }
        }
        //网址验证

        if (!(fm.url.value==''||fm.url.value =='http://')){
            if (!/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)){
                alert('网址不合法');
                fm.url.value = '';//清空
                fm.url.focus();//将焦点以至表单字段
                return false;
            }
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
};