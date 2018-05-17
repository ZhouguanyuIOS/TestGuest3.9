window.onload=function () {
    var all=document.getElementById('all');
    var fm=document.getElementsByTagName('form')[0];

    all.onclick=function () {
        //form.elements.length 表单内的所有表单
        for (var i=0;i<fm.elements.length;i++){
            if (fm.elements[i].name !='chkall'){
                fm.elements[i].checked=fm.chkall.checked;
            }
        }
    }
    fm.onsubmit=function()  {
        if (confirm('你确定要删除这批短信吗？')){
            return true;
            // location.href='member_message_detail.php?action=delete&id='+this.name;
        }
        return false;
    }

}