<?php
  
  session_start();
  
  $servername = '';
  $username = '';
  $password = '';
  $dbname = '';
  
  $connection = mysqli_connect($servername, $username, $password, $dbname);
  //closing tag not here intentionally!
