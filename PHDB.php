<?php 
echo "Hello World!"; 
?> 

<?php
 
  // ������Ϊһ��ʾ������
  // ������ʹ�� ODBC ���ӷ��� SQL SERVER ���ݿ�
  // ���Ƚ���һ�����ݿ⣬����ΪPNMNG
  // ����һ���û�PN������Ϊpn123456
  // �ٴ���һ�����ݱ�PNRecord
  // ����PartTypeΪ�ַ����ֶ�
  // ���ʹ�ü���������ߵ�����Դ���ܽ���һ������Դ������ΪPNMNG-ODBC
  // ���õ�¼�û���������Ϊǰ���û��������룬ͬʱ����Ĭ�����ݿ�ΪPNMNG
  // ��ʹ��UDL�ļ�����ODBC�������Ƿ���ȷ
  // ��PNRecord���ݱ������һЩ����
  // ����Ĵ��������ʾ��Щ���ݵ����ݣ�����ñ��о���PartNumֵΪ610117�ļ�¼
  // ��ü�¼��PartType�ֶν����޸�Ϊ456��

  // PHP.INIĬ�Ͼ����������ã����ûʲô���޸ĵ�
  // [PHP_PDO_ODBC]
  // extension=php_pdo_odbc.dll
 
  $server='PNMNG-ODBC';  // ע��Ҫ������Դ������һ��
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
  
  $exec = odbc_exec( $conn, $sql ); //ִ�����
  

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