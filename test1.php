<?php

include_once 'dataBase.php';

//Function to get the smallest side of the product in meters
function smallestSideInMeters(array $param1) : float {
  return $smallest = min($param1) / 1000;
}

$bigProduct = 0;

//Array with total size of each product * 5
$getAllItemsVolume = array();

foreach ($products as $product) {
  //If a product don't have a side smaller than 3.6 meters, it can't be placed in the warehouse
  if(smallestSideInMeters($product) > 3.6){
    $bigProduct++;
    continue;
  }
  $size = (($product['height'] / 1000) * ($product['width'] / 1000) * ($product['length'] / 1000)) * 5;
  //Collecting the size of the products
  array_push($getAllItemsVolume, $size);
}
//Products
echo "<pre>";
echo $bigProduct." products cannot enter the warehouse because they don't have side smaller than 3.6m.";
echo "</pre>";

$warehouseVolume = ceil(array_sum($getAllItemsVolume));
$warehouseArea = ceil($warehouseVolume / 3.6);
// Needed area in square meter
echo "<pre>";
echo "According to the size of the products in cubic meters which is ".$warehouseVolume." and the given height of the warehouse total area needed for the warehouse as length and width is ".$warehouseArea."m2.";
echo "</pre>";

// Possible width and length
$dimensionOne = ceil(sqrt($warehouseArea));
$dimensionTwo = floor(sqrt($warehouseArea));
//Check if the width * length is more than the area in square meter
if ($dimensionOne * $dimensionTwo < $warehouseArea){
  $dimensionTwo = ceil(sqrt($warehouseArea));
}
echo "Assuming the warehouse is supposed to be as close as possible to a square the suggested dimensions are ".$dimensionOne."x".$dimensionTwo." meters.";
 ?>
