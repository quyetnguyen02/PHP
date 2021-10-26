<?php
define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define("DB_PASSWORD",'');
define('DB_NAME','library');

  $mysqli=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

  if($mysqli ===false){
      die("ERROR:Could not connected ". $mysqli->connect-error);
  }
?>