<?php
 include 'utlsockclient.php';
?>

<?php 

class Person 
{  
  public $name;
  public $sex;
  public $m_tskClt;
      
  //定义一个构造方法初始化赋值
  public function __construct( $name, $sex )
  {  
    $this->name = $name;
    $this->sex = $sex;

    $this->m_tskClt = new CSockClient( 'localhost', 90 );
  }  
  private function test()
  {
    echo "My name is : ".$this->name."<br/>";  
    echo "My sex is : ".$this->sex;  
  }
  public function say()
  {
    if ( $this->m_tskClt->m_bSockOpenOk )
    {
	$out = '<br>sock client send message<br>'; 
	$len = strlen( $out );
	$this->m_tskClt->Write( $out, $len );
	$in = $this->m_tskClt->Read( $len );
	echo $in; 
    }
    else
    {
	echo "connect error ".$this->m_tskClt->m_slastError."<br>";
    }

    $this->test();
  }

  //析构函数
  function __destruct()
  {  
    echo "<br>goodbye : ".$this->name;  
  }
  
}  
    
header('Content-Type:text/html;charset=GB2312');
echo "test中文<br>";

$user_name = $_POST[ 'name' ];
$user_sex = $_POST[ 'sex' ];

$user_name = mb_convert_encoding( $user_name, "gb2312", "utf-8" );
$user_sex = mb_convert_encoding( $user_sex, "gb2312", "utf-8" );

$p1 = new Person( $user_name, $user_sex );
$p1->say();

?>
