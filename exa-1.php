<html>
<head runat="server">
<meta charset="GB2312">
<title>Ajax取参数</title>
<script lang="javascript">
//---------------------------------------------------------
function showHint()
{
	var str = document.getElementById( "txt1" ).value;
	if( str.length == 0 )
	{
		document.getElementById( "txtHint" ).innerHTML = "";
		return;
	}
   
  xmlHttp = GetXmlHttpObject();
     
  if( xmlHttp == null )
  {
  	alert( "Browser does not support HTTP Request" );
  	return;
  }
   
  xmlHttp.onreadystatechange = updatePage;
  
  //xmlHttp.open( "POST", "/create.php", true );
  //xmlHttp.send( "name=王二狗 & sex=男" );
 
  xmlHttp.open( "POST", "/TAJAX.php", true );
  
  //var fd = new FormData();
  
  //fd.append( "name", str );
  //fd.append( "sex", "男" );
  
  //xmlHttp.send( fd );
  
  //xmlHttp.setRequestHeader( "Content-type", "application/x-www-form-urlencoded;charset=UTF-8" );
  
  xmlHttp.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
  xmlHttp.send( "name=" + str + " & sex=男" );
  
}
//---------------------------------------------------------
function GetXmlHttpObject()
{
  var xmlHttp = null;
  try
  {
  	// Firefox, Opera 8.0+, Safari
  	xmlHttp = new XMLHttpRequest();
  }
  catch( e )
  {
  	//Internet Explorer
  	try
  	{
  		xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
  	}
  	catch( e )
  	{
  		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  	}
  }
  return xmlHttp;
}
//--------------------------------------------------------- 
function updatePage()
{  
	//若响应完成且请求成功
  if( xmlHttp.readyState === 4 && xmlHttp.status === 200 )
  {
  	document.getElementById( "txtHint" ).innerHTML = xmlHttp.responseText;
  }
}
<!-------------------------------------------------------->
</script>
</head>
<body>
  <form id="form1">
  <div>
  <input id="txt1" type="text" onkeyup="showHint()"/>
  <p>参数：<span id="txtHint"></span></p>
  </div>
  <div>结束</div>
  </form>
</body>
</html>
<!-------------------------------------------------------->
