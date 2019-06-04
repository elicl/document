<!DOCTYPE html>
<html>

<script type="text/javascript">

var inputstr = "default";

</script>

<input type="button" value="click me" onClick="ShowMessage()"/>
<div><br></div>
<div><br></div>
<div>数字输入测试，只能输入数字，不能输入其它字符:</div>
<input id="myTest" type="text" value="" />
<body><table width="200" border="1">
  <tr>
    <td>　</td>
    <td>　</td>
    <td>　</td>
  </tr>
  <tr>
    <td>　</td>
    <td>　</td>
    <td>　</td>
  </tr>
  <tr>
    <td>　</td>
    <td>　</td>
    <td id = "myTD1">123</td>
  </tr>
</table>
<div id="myDiv1">
 aaaa
</div>
</body>

<?php
  include 'PHDB1.php';
?>

<script type="text/javascript">
function ShowMessage() {
alert( inputstr );
};
</script>

<script type="text/javascript">

var EventUtil = 
{
  addHandler: function( element, type, handler ) 
  {
    if( element.addEventListener )
    {
      element.addEventListener( type, handler, false );
    }
    else if ( element.attachEvent )  
    {
       element.attachEvent( "on" + type, handler );
    }
    else
    {
       element[ "on" + type ] = handler;
    }
  },
  removeHandler: function( element, type, handler )
  {
     if ( element.removeEventListener )
     {
        element.removeEventListener( type, handler, false );
     }
     else if ( element.detachEvent )
     {
        element.detachEvent( "on" + type, handler );
     }
     else
     {
        element[ "on" + type ] = null;
     }
  },
  preventDefault: function( element )
  {
    if ( element.preventDefault )
	{
	  element.preventDefault();
	}
  }
};

var textbox = document.getElementById( "myTest" );
var div1 = document.getElementById( "myDiv1" ); 
var td1 = document.getElementById( "myTD1" );

td1.innerHTML= '<font color="black">good</font>';
div1.innerHTML= '<font color="black">good</font>';

EventUtil.addHandler( textbox, "keyup", function( event )
{
  td1.innerHTML= '<font color="red">' + event.target.value + '</font>';
  div1.innerHTML= '<font color="red">' + event.target.value + '</font>';
  inputstr = event.target.value;
} );

EventUtil.addHandler( textbox, "keypress", function( event )
{
  //var target1 = EventUtil.getTarget( event );
  //var charCode = EventUtil.getCharCode( event );
  
  //if ( !/\d/.test( String.fromCharCode( charCode ) ) )
  if ( ( event.key < '0' ) || ( event.key > '9' ) )
  {
    EventUtil.preventDefault( event );
  }
} );
</script>


</html>