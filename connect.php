<?php
  
  session_start();
  
  $servername = '';  //servername
  $username = '';  //username
  $password = '';  //password
  $dbname = '';  //database name
  
  $connection = mysqli_connect($servername, $username, $password, $dbname);
  //closing tag not here intentionally!
