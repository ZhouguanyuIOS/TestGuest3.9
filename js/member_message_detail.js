window.onload=function () {
    var  ret =document.getElementById('return');
    var  del =document.getElementById('delete');
    ret.onclick=function () {
        history.back();
    };
    del.onclick=function () {
        if (confirm('你确定要删除这条短信吗？')){
           location.href='member_message_detail.php?action=delete&id='+this.name;
        }
    };
}