<?php
  /*��ȡexcel�ļ�����������Ӧ����*/
  $fileName = "url.xls";
  if (!file_exists($fileName)) 
  {
    exit("�ļ�".$fileName."������");
  }

  //$startTime = time(); //���ص�ǰʱ���Unix ʱ���

  require_once './PHPExcel/IOFactory.php';
  $objPHPExcel = PHPExcel_IOFactory::load( $fileName );
  //��ȡsheet�����Ŀ
  $sheetCount = $objPHPExcel->getSheetCount();
  //Ĭ��ѡ��sheet0��
  $sheetSelected = 0;$objPHPExcel->setActiveSheetIndex( $sheetSelected );

  //��ȡ�������
  $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();
  //��ȡ�������
  $columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();
  echo "<div>Sheet Count : ".$sheetCount."���������� ".$rowCount."����������".$columnCount."</div>\n";
  $dataArr = array();
 
  ob_end_clean();//���������,��������
  header('Content-Type: application/vnd.ms-excel');

  $percent = 0;
  $oldpercent = 0;
  /* ѭ����ȡÿ����Ԫ������� */
  //����ѭ��
  for( $row = 1; $row <= $rowCount; $row++)
  {
    //����ѭ�� , ��������A�п�ʼ
    for( $column = 'A'; $column <= $columnCount; $column++) 
    {
      $dataArr[] = $objPHPExcel->getActiveSheet()->getCell( $column.$row )->getValue();
      $data = $objPHPExcel->getActiveSheet()->getCell( $column.$row )->getValue();
      //$data = mb_convert_encoding( "gb2312", "UTF-8", $data );
      if ( $row  <= 2 )
      {
        echo $column.$row. ":" .$data. "<br />";
      }
    }

    if ( $row  <= 2 )
    {
      echo "<br/>�� " .$row. " �����ĵ��ڴ�Ϊ��".( memory_get_peak_usage( true ) / 1024 / 1024 )."M\n";
      $endTime = time();
      //echo "<div>�ܹ����ĵ�ʱ��Ϊ��".(($endTime - $startTime))."��</div>";
    
      var_dump( $dataArr );
    }
    else 
    {
      $percent = floor( ( $row * 100 ) / $rowCount );
      if ( $percent != $oldpercent )
      {
        echo $percent."%\n";
      }
      $oldpercent = $percent;
    }

    $dataArr = NULL;
  }
?>