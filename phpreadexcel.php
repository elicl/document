<?php
  /*读取excel文件，并进行相应处理*/
  $fileName = "url.xls";
  if (!file_exists($fileName)) 
  {
    exit("文件".$fileName."不存在");
  }

  //$startTime = time(); //返回当前时间的Unix 时间戳

  require_once './PHPExcel/IOFactory.php';
  $objPHPExcel = PHPExcel_IOFactory::load( $fileName );
  //获取sheet表格数目
  $sheetCount = $objPHPExcel->getSheetCount();
  //默认选中sheet0表
  $sheetSelected = 0;$objPHPExcel->setActiveSheetIndex( $sheetSelected );

  //获取表格行数
  $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();
  //获取表格列数
  $columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();
  echo "<div>Sheet Count : ".$sheetCount."　　行数： ".$rowCount."　　列数：".$columnCount."</div>\n";
  $dataArr = array();
 
  ob_end_clean();//清除缓冲区,避免乱码
  header('Content-Type: application/vnd.ms-excel');

  $percent = 0;
  $oldpercent = 0;
  /* 循环读取每个单元格的数据 */
  //行数循环
  for( $row = 1; $row <= $rowCount; $row++)
  {
    //列数循环 , 列数是以A列开始
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
      echo "<br/>第 " .$row. " 行消耗的内存为：".( memory_get_peak_usage( true ) / 1024 / 1024 )."M\n";
      $endTime = time();
      //echo "<div>总共消耗的时间为：".(($endTime - $startTime))."秒</div>";
    
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