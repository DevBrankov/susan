<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "susan";

  $connection = mysqli_connect($servername, $username, $password, $database);
  if (!$connection) {
    $information = file_get_contents('database.json');
    $products = json_decode($information, true);
    return $products;

  }
  $query = 'SELECT height, length, width FROM product';
  $data = mysqli_query($connection, $query);
  $products = array();
  if(mysqli_num_rows($data) > 0){
    while($row = mysqli_fetch_assoc($data)){
      $products[] = $row;
    }
  }


?>
