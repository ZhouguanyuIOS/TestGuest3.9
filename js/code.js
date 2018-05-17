function code() {
    var code=document.getElementById('codeOne');
    code.onclick=function () {
        this.src='code.php?tm='+Math.random();
    };

}