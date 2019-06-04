<?php

class WebSocket 
{
  public var $master;              // ���� server �� client
  public var $sockets = array();   // ��ͬ״̬�� socket ����
  public var $handshake = false;   // �ж��Ƿ�����
//---------------------------------------------------------  
  public function __construct( $address, $port )
  {
    // ����һ�� socket �׽���
    $this->master = socket_create( AF_INET, SOCK_STREAM, SOL_TCP )
      or die( "socket_create() failed" );
    socket_set_option( $this->master, SOL_SOCKET, SO_REUSEADDR, 1 )  
      or die( "socket_option() failed" );
    socket_bind( $this->master, $address, $port )
      or die( "socket_bind() failed" );
    socket_listen( $this->master, 2 )
      or die( "socket_listen() failed" );
 
    $this->sockets[] = $this->master;
 
    // debug
    echo( "Master socket : ".$this->master."\n" );

    while( true )
    {
      //�Զ�ѡ������Ϣ�� socket ��������� �Զ�ѡ������
      $write = NULL;
      $except = NULL;
      socket_select( $this->sockets, $write, $except, NULL );
 
      foreach( $this->sockets as $socket )
      {
        //���������� client 
        if ($socket == $this->master)
        {
          $client = socket_accept( $this->master );
          if ($client < 0)
          {
            // debug
            echo "socket_accept() failed";
            continue;
          }
          else
          {
            //connect($client);
            array_push( $this->sockets, $client );
            echo "connect client\n";
          }
        }
        else
        {
          $bytes = @socket_recv( $socket,$buffer, 2048, 0 );
          print_r( $buffer );
          if( $bytes == 0 )
            return;
          if ( !$this->handshake )
          {
            // ���û�����֣������ֻ�Ӧ
            $this->doHandShake( $socket, $buffer );
            echo "shakeHands\n";
          }
          else
          {
            // ����Ѿ����֣�ֱ�ӽ������ݣ�������
            $buffer = $this->decode( $buffer );
            //process($socket, $buffer); 
            echo "send file\n";
          }
        }
      }
    }
  }
//---------------------------------------------------------
  public function dohandshake( $socket, $req )
  {
    // ��ȡ����key
    $acceptKey = $this->encry( $req );
    $upgrade = "HTTP/1.1 101 Switching Protocols\r\n" .
               "Upgrade: websocket\r\n" .
               "Connection: Upgrade\r\n" .
               "Sec-WebSocket-Accept: " . $acceptKey . "\r\n" .
               "\r\n";
 
    echo "dohandshake ".$upgrade.chr( 0 );
    // д��socket
    socket_write( $socket, $upgrade.chr( 0 ), strlen( $upgrade.chr( 0 ) ) );
    // ��������Ѿ��ɹ����´ν������ݲ�������֡��ʽ
    $this->handshake = true;
  }
//--------------------------------------------------------- 
  public function encry( $req )
  {
    $key = $this->getKey( $req );
    $mask = "258EAFA5-E914-47DA-95CA-C5AB0DC85B11";

    return base64_encode(sha1( $key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true ) );
  }
//---------------------------------------------------------
  public function getKey( $req ) 
  {
    $key = null;
    if ( preg_match( "/Sec-WebSocket-Key: (.*)\r\n/", $req, $match ) )
    { 
      $key = $match[1]; 
    }
    return $key;
  }
//---------------------------------------------------------      
  // ��������֡
  public function decode( $buffer )
  {
    $len = $masks = $data = $decoded = null;
    $len = ord( $buffer[ 1 ] ) & 127;

    if ( $len === 126 )
    {
      $masks = substr( $buffer, 4, 4 );
      $data = substr( $buffer, 8 );
    }
    else if ( $len === 127 )
    {
      $masks = substr( $buffer, 10, 4 );
      $data = substr( $buffer, 14 );
    }
    else
    {
      $masks = substr( $buffer, 2, 4 );
      $data = substr( $buffer, 6 );
    }
    for( $index = 0; $index < strlen( $data ); $index++ )
    {
      $decoded .= $data[ $index ] ^ $masks[ $index % 4 ];
    }
    return $decoded;
  }
//---------------------------------------------------------     
  // ����֡��Ϣ����
  public function frame( $s ) 
  {
    $a = str_split($s, 125);
    if ( count( $a ) == 1 )
    {
      return "\x81" . chr( strlen( $a[ 0 ] ) ) . $a[ 0 ];
    }
    $ns = "";
    foreach( $a as $o )
    {
      $ns .= "\x81" . chr( strlen( $o ) ) . $o;
    }
    return $ns;
  }
//---------------------------------------------------------
  // ��������
  public function send( $client, $msg )
  {
    $msg = $this->frame($msg);
    socket_write( $client, $msg, strlen( $msg ) );
  }
}
//---------------------------------------------------------
//����   $ws = new WebSocket( "127.0.0.1", 2000 );

?>