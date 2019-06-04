<!DOCTYPE HTML>

<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
<script src="layer/layer.js"></script><!--弹出窗口的JS 下载http://layer.layui.com/-->




</head>
    <body>
 <form id="form" name="register" action="" method="post">
             <table align="center" width="60%">
               <tr><td>会员名</td><td><input type="text"  name="username" id="username"></td>
                      <td id="usernameMsg"></td>   </tr> 
                <tr><td>电子邮箱</td><td><input type="text"  name="email" id="email"></td>
                       <td id="passwordMsg"></td></tr>
                <tr><td>密码</td><td><input type="password"  name="password"  id="password"></td></tr>
                <tr><td>再次输入密码</td><td><input type="password"  name="re_password" id="re_password" ></td></tr>
                <tr><input type="hidden" name="action" value="register"></tr>
                <tr><td colspan="2" align="center"><a href="#" onClick="user_add_1()">提交</a></td></tr>
                </table>




</form>


<!--弹出输入框，输入内容再提交到后台处理-->




<script>


function user_add_1()
{
 var a1=$('#username').val();
 var a2=$('#email').val();
 var a3=$('#password').val();
 var a4=$('#re_password').val();
 //var a1="黄海";
 var url="/c2.php?name="+a1+"&age="+a2;
//Ajax获取
$.post(url, {}, function(str){
 layer.open({
type: 1,
content: str //注意，如果str是object，那么需要字符拼接。
 });
});
};


</script>  
    </body>
</html>
