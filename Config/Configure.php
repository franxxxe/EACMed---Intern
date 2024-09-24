<?php 
  $Conn = 1;
  if($Conn == 1){
    $connMysqli = mysqli_connect("localhost", "root", "", "eacmed_intern_db"); //MySQL
    $connPDO = new PDO('mysql: host=localhost; dbname=eacmed_intern_db', 'root', ''); //PDO
  }
  else{
    $connMysqli = mysqli_connect("localhost", "u745168153_alfelor", "h!!2l7U&", "u745168153_alfelor"); //MySQL
    $connPDO = new PDO('mysql:host=localhost;dbname=u745168153_alfelor', 'u745168153_alfelor', 'h!!2l7U&'); //PDO
  }
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }
?>