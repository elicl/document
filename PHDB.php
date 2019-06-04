<?php 
echo "Hello World!"; 
?> 

<?php
 
  // 本程序为一个示范程序
  // 本程序使用 ODBC 连接访问 SQL SERVER 数据库
  // 首先建立一个数据库，名称为PNMNG
  // 创建一个用户PN，密码为pn123456
  // 再创建一个数据表PNRecord
  // 其中PartType为字符串字段
  // 最后使用计算机管理工具的数据源功能建立一个数据源，名称为PNMNG-ODBC
  // 设置登录用户名及密码为前述用户名和密码，同时设置默认数据库为PNMNG
  // 可使用UDL文件严重ODBC的设置是否正确
  // 再PNRecord数据表中添加一些数据
  // 下面的代码可以显示这些数据的内容，如果该表中具有PartNum值为610117的记录
  // 则该记录的PartType字段将被修改为456。

  // PHP.INI默认具有如下配置，因此没什么可修改的
  // [PHP_PDO_ODBC]
  // extension=php_pdo_odbc.dll
 
  $server='PNMNG-ODBC';  // 注意要与数据源的名称一致
  $username='pn';
  $password='cgmdpan';

  $database='PNRecord';
 
  // sqlsrv_connect
  // odbc_connect
  // mssql_connect
  $conn= odbc_connect( $server, $username, $password );

 if ( $conn )
  {
    echo "Connection established.\n";
  }
  else
  {
    echo "Connection could not be established.\n";
    die( print_r( sqlsrv_errors(), true));
  }

  $sql = "SELECT * FROM PNRecord WHERE PartNum = 610117";
  
  $exec = odbc_exec( $conn, $sql ); //执行语句
  

  while( odbc_fetch_array( $exec ) )
  {
    $abc = odbc_result( $exec, "PartNum");
    echo $abc;
    echo "\n";
    $PartType = odbc_result( $exec, "PartType");
    echo $PartType;
    echo "\n";
  }
?>